<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        return view('checkout.index');
    }

    /**
     * Process checkout and create orders
     */
    public function process(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'shipping_method' => 'required|in:pickup,delivery',
            'shipping_address' => 'required_if:shipping_method,delivery|nullable|string',
            'payment_method' => 'required|in:cod,transfer',
            'cart_data' => 'required|json',
            'notes' => 'nullable|string',
            'shipping_fee' => 'nullable|numeric|min:0',
        ]);

        $cartData = json_decode($request->cart_data, true);
        
        if (empty($cartData)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        try {
            $createdOrders = [];

            // Group items by seller
            $groupedBySeller = [];
            foreach ($cartData as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) continue;

                $sellerId = $product->seller_id;
                if (!isset($groupedBySeller[$sellerId])) {
                    $groupedBySeller[$sellerId] = [];
                }
                $groupedBySeller[$sellerId][] = [
                    'product' => $product,
                    'quantity' => $item['quantity']
                ];
            }

            // Create separate order for each seller
            foreach ($groupedBySeller as $sellerId => $items) {
                DB::transaction(function () use ($request, $items, $sellerId, &$createdOrders) {
                    $totalAmount = 0;

                    // Auto-assign validator based on seller's prodi
                    $seller = \App\Models\User::find($sellerId);
                    $validator = null;
                    
                    if ($seller && $seller->prodi) {
                        // Find prodi ID from prodi name
                        // Prodi is stored as full name like "Teknik Informatika"
                        $prodi = \App\Models\StudyProgram::where('name', $seller->prodi)
                            ->orWhere('name', 'LIKE', '%' . $seller->prodi . '%')
                            ->first();
                        
                        if ($prodi) {
                            // Find verified validator for seller's prodi
                            // MUST have complete bank info (bank_name, account_number)
                            $validator = \App\Models\User::where('role', 'validator')
                                ->where('validator_prodi_id', $prodi->id)
                                ->where('verified', true)
                                ->whereNotNull('bank_name')
                                ->whereNotNull('account_number')
                                ->where('bank_name', '!=', '')
                                ->where('account_number', '!=', '')
                                ->first();
                        }
                    }
                    
                    // If validator found, payment will be transferred to validator
                    // If no validator with complete bank info, order can still proceed but without validator confirmation

                    // Calculate total
                    foreach ($items as $item) {
                        $product = $item['product'];
                        if ($product->stock < $item['quantity']) {
                            throw new \Exception("Stok {$product->name} tidak mencukupi");
                        }
                        $totalAmount += $product->price * $item['quantity'];
                    }

                    // Build shipping info based on method
                    $shippingMethod = $request->shipping_method;
                    $shippingFee = $request->shipping_fee ?? 0;
                    
                    if ($shippingMethod === 'pickup') {
                        // For pickup, use product location
                        $pickupLocations = [];
                        foreach ($items as $item) {
                            $loc = $item['product']->location ?? 'Lokasi tidak tersedia';
                            if (!in_array($loc, $pickupLocations)) {
                                $pickupLocations[] = $loc;
                            }
                        }
                        $shippingAddress = sprintf(
                            "[AMBIL SENDIRI]\nNama: %s\nTelepon: %s\nLokasi Pengambilan: %s%s",
                            $request->recipient_name,
                            $request->recipient_phone,
                            implode(', ', $pickupLocations),
                            $request->notes ? "\nCatatan: " . $request->notes : ''
                        );
                    } else {
                        // For delivery
                        $shippingAddress = sprintf(
                            "[DIANTAR PENJUAL]\nNama: %s\nTelepon: %s\nAlamat: %s%s\n\n⚠️ Biaya pengiriman akan dikonfirmasi penjual",
                            $request->recipient_name,
                            $request->recipient_phone,
                            $request->shipping_address,
                            $request->notes ? "\nCatatan: " . $request->notes : ''
                        );
                    }

                    // Create order
                    $order = Order::create([
                        'order_code' => 'ORD-' . strtoupper(Str::random(10)),
                        'total_amount' => $totalAmount + $shippingFee,
                        'status' => 'pending',
                        'buyer_id' => Auth::id(),
                        'validator_id' => $validator?->id,
                        'shipping_address' => $shippingAddress,
                        'shipping_method' => $shippingMethod,
                        'shipping_fee' => $shippingFee,
                        'payment_method' => $request->payment_method,
                        'payment_status' => $request->payment_method === 'cod' ? 'unpaid' : 'unpaid',
                        'notes' => $request->notes,
                    ]);

                    // Create order items (stock will be deducted on payment confirmation)
                    foreach ($items as $item) {
                        $product = $item['product'];
                        $order->items()->create([
                            'product_id' => $product->id,
                            'quantity' => $item['quantity'],
                            'price_at_order' => $product->price,
                        ]);

                        // ✅ REMOVED: Stock decrement moved to confirmPayment()
                        // Stock will be checked and deducted only after payment is confirmed
                        
                        // Create notification for seller
                        \App\Models\Notification::createOrderNotification(
                            $product->seller_id,
                            'Pesanan Baru! 🎉',
                            'Ada pesanan baru untuk produk "' . $product->name . '" sebanyak ' . $item['quantity'] . ' pcs',
                            $order->id,
                            'new'
                        );
                    }
                    
                    // Create notification for buyer
                    \App\Models\Notification::createOrderNotification(
                        Auth::id(),
                        'Pesanan Berhasil Dibuat',
                        'Pesanan ' . $order->order_code . ' berhasil dibuat. Total: Rp' . number_format($order->total_amount, 0, ',', '.'),
                        $order->id,
                        'new'
                    );

                    $createdOrders[] = $order->id;
                });
            }

            // Redirect based on payment method
            if ($request->payment_method === 'transfer') {
                // Get first order to show bank info
                $firstOrder = Order::with('validator')->find($createdOrders[0]);
                
                $message = 'Pesanan berhasil dibuat! ';
                if ($firstOrder && $firstOrder->validator) {
                    $message .= 'Silakan transfer ke rekening ' . ($firstOrder->validator->bank_name ?? 'BCA') . 
                               ' (' . ($firstOrder->validator->account_number ?? '-') . ') ' .
                               'a.n. ' . ($firstOrder->validator->account_holder_name ?? $firstOrder->validator->name) . 
                               ' sebesar Rp' . number_format($firstOrder->total_amount, 0, ',', '.');
                }
                
                return redirect()->route('orders.show', $createdOrders[0])
                    ->with('success', $message);
            } else {
                return redirect()->route('orders.index')
                    ->with('success', 'Pesanan berhasil dibuat. Pembayaran COD saat barang diterima.');
            }

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
