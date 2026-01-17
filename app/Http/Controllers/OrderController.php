<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\BalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::where('buyer_id', Auth::id())
                        ->with('items.product');

        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);

        $order = null;
        try {
            DB::transaction(function () use ($request, $product, &$order) {
                if ($product->stock < $request->quantity) {
                    throw new \Exception('Not enough stock for this product.');
                }

                $totalAmount = $product->price * $request->quantity;

                $order = Order::create([
                    'order_code' => 'ORD-' . strtoupper(Str::random(10)),
                    'total_amount' => $totalAmount,
                    'status' => 'pending',
                    'buyer_id' => Auth::id(),
                    'shipping_address' => 'Default user address', // Placeholder
                ]);

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'price_at_order' => $product->price,
                ]);

                $product->decrement('stock', $request->quantity);
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Ensure user can only view their own order or if they're the seller
        if ($order->buyer_id !== Auth::id()) {
            // Check if current user is seller of any item in this order
            $isSeller = $order->items()->whereHas('product', function($query) {
                $query->where('seller_id', Auth::id());
            })->exists();
            
            if (!$isSeller) {
                abort(403, 'Unauthorized');
            }
        }

        $order->load(['items.product.seller', 'buyer', 'validator']);
        return view('orders.show', compact('order'));
    }

    /**
     * Upload payment proof
     */
    public function uploadPaymentProof(Request $request, Order $order)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            $order->update([
                'payment_proof' => $path,
                'payment_status' => 'pending_confirmation',
            ]);

            // Kirim notifikasi ke validator untuk verifikasi pembayaran
            if ($order->validator_id) {
                \App\Models\Notification::create([
                    'user_id' => $order->validator_id,
                    'type' => 'payment_verification',
                    'title' => 'Verifikasi Pembayaran Baru',
                    'message' => 'Pembeli telah mengupload bukti pembayaran untuk pesanan ' . $order->order_code . '. Silakan verifikasi.',
                    'related_id' => $order->id,
                    'is_read' => false,
                ]);
            }

            return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi validator.');
        }

        return back()->with('error', 'Gagal mengupload bukti pembayaran.');
    }

    /**
     * Upload delivery proof
     */
    public function uploadDeliveryProof(Request $request, Order $order)
    {
        $request->validate([
            'delivery_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($request->hasFile('delivery_proof')) {
            $path = $request->file('delivery_proof')->store('delivery_proofs', 'public');
            
            DB::transaction(function () use ($order, $path) {
                $order->update([
                    'delivery_proof' => $path,
                    'status' => 'delivered',
                    'delivered_at' => now(),
                ]);

                // ✅ FIX: Add balance to seller with revenue sharing
                $balanceService = new BalanceService();
                
                foreach ($order->items as $item) {
                    $product = $item->product;
                    $grossAmount = $item->price_at_order * $item->quantity;
                    
                    // Get agreed validator share percentage (default 0)
                    $validatorSharePct = $product->agreed_validator_share ?? 0;
                    
                    // Add income with revenue sharing
                    $balanceService->addOrderIncome(
                        sellerId: $product->seller_id,
                        orderId: $order->id,
                        grossAmount: $grossAmount,
                        validatorSharePercentage: $validatorSharePct,
                        validatorId: $order->validator_id
                    );
                    
                    // Notify seller
                    \App\Models\Notification::createOrderNotification(
                        $product->seller_id,
                        'Pesanan Selesai ✅',
                        'Pesanan ' . $order->order_code . ' telah diterima. Saldo Anda telah ditambahkan!',
                        $order->id,
                        'completed'
                    );
                }
            });

            return back()->with('success', 'Bukti penerimaan berhasil diupload. Pesanan selesai dan saldo penjual telah diperbarui.');
        }

        return back()->with('error', 'Gagal mengupload bukti penerimaan.');
    }

    /**
     * Confirm payment (seller only)
     */
    public function confirmPayment(Order $order)
    {
        // Check if current user is seller
        $isSeller = $order->items()->whereHas('product', function($query) {
            $query->where('seller_id', Auth::id());
        })->exists();
        
        if (!$isSeller) {
            abort(403, 'Unauthorized');
        }

        // ✅ FIX: Kurangi stock saat payment confirmed, bukan saat checkout
        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $product = $item->product;
                
                // Check stock availability
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}");
                }
                
                // Deduct stock
                $product->decrement('stock', $item->quantity);
            }
            
            $order->update([
                'payment_status' => 'confirmed',
                'status' => 'paid',
                'confirmed_at' => now(),
            ]);
        });

        // Notify buyer
        \App\Models\Notification::createOrderNotification(
            $order->buyer_id,
            'Pembayaran Dikonfirmasi 💰',
            'Pembayaran pesanan ' . $order->order_code . ' telah dikonfirmasi oleh penjual.',
            $order->id,
            'paid'
        );

        return back()->with('success', 'Pembayaran telah dikonfirmasi dan stok telah dikurangi.');
    }

    /**
     * Pack order (seller only)
     */
    public function packOrder(Order $order)
    {
        $isSeller = $order->items()->whereHas('product', function($query) {
            $query->where('seller_id', Auth::id());
        })->exists();
        
        if (!$isSeller) {
            abort(403, 'Unauthorized');
        }

        $order->update([
            'status' => 'packed',
            'packed_at' => now(),
        ]);

        // Notify buyer
        \App\Models\Notification::createOrderNotification(
            $order->buyer_id,
            'Pesanan Dikemas 📦',
            'Pesanan ' . $order->order_code . ' sedang dikemas oleh penjual.',
            $order->id,
            'shipped'
        );

        return back()->with('success', 'Pesanan sudah dikemas.');
    }

    /**
     * Ship order (seller only)
     */
    public function shipOrder(Order $order)
    {
        $isSeller = $order->items()->whereHas('product', function($query) {
            $query->where('seller_id', Auth::id());
        })->exists();
        
        if (!$isSeller) {
            abort(403, 'Unauthorized');
        }

        $order->update([
            'status' => 'shipped',
            'shipped_at' => now(),
        ]);

        // ✅ FIX: Auto-confirm COD payment saat shipped
        if ($order->payment_method === 'cod' && $order->payment_status !== 'confirmed') {
            $order->update(['payment_status' => 'confirmed']);
        }

        // Notify buyer based on shipping method
        if ($order->shipping_method === 'pickup') {
            \App\Models\Notification::createOrderNotification(
                $order->buyer_id,
                'Pesanan Siap Diambil 📦',
                'Pesanan ' . $order->order_code . ' sudah siap diambil. Silakan ambil pesanan Anda di lokasi penjual.',
                $order->id,
                'shipped'
            );
            return back()->with('success', 'Pesanan siap diambil oleh pembeli.');
        } else {
            \App\Models\Notification::createOrderNotification(
                $order->buyer_id,
                'Pesanan Dikirim 🚚',
                'Pesanan ' . $order->order_code . ' sedang dalam perjalanan ke alamat Anda.',
                $order->id,
                'shipped'
            );
            return back()->with('success', 'Pesanan sedang dikirim.');
        }
    }

    /**
     * Complete order (mark as completed after delivered)
     */
    public function completeOrder(Order $order)
    {
        // Buyer can complete their own order
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($order->status !== 'delivered') {
            return back()->with('error', 'Pesanan harus berstatus delivered untuk diselesaikan.');
        }

        $order->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Pesanan telah diselesaikan. Terima kasih!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
