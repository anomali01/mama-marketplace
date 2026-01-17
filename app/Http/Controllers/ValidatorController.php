<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\StudyProgram;
use App\Models\TransactionLog;
use App\Models\Balance;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ValidatorController extends Controller
{
    /**
     * Display validator dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistik - hanya produk dari prodi validator
        $stats = [
            'pending' => Product::where('status', 'pending_verif')
                ->whereHas('seller', function($query) use ($user) {
                    $query->where('prodi', $user->validatorStudyProgram->name ?? '');
                })
                ->count(),
            'approved' => Product::where('status', 'verified')
                ->whereHas('seller', function($query) use ($user) {
                    $query->where('prodi', $user->validatorStudyProgram->name ?? '');
                })
                ->count(),
            'rejected' => Product::where('status', 'rejected')
                ->whereHas('seller', function($query) use ($user) {
                    $query->where('prodi', $user->validatorStudyProgram->name ?? '');
                })
                ->count(),
            'total_sellers' => User::where('role', 'mahasiswa')
                ->where('prodi', $user->validatorStudyProgram->name ?? '')
                ->whereHas('products')
                ->count(),
        ];

        // Tracking Dana
        // Get saldo validator
        $validatorBalance = Balance::firstOrCreate(
            ['user_id' => $user->id, 'type' => 'validator'],
            ['amount' => 0, 'pending' => 0]
        );

        $transactionStats = [
            'validator_balance' => $validatorBalance->amount, // 3% dari semua transaksi
            'pending_withdrawals' => \App\Models\WithdrawalRequest::where('validator_id', $user->id)
                ->where('status', 'pending')
                ->sum('amount'), // Total yang harus ditransfer ke seller
            'total_transferred' => \App\Models\WithdrawalRequest::where('validator_id', $user->id)
                ->where('status', 'transferred')
                ->sum('amount'),
        ];

        // Recent transactions (10 terbaru)
        $recentTransactions = TransactionLog::where('user_id', $user->id)
            ->where('type', 'validator_commission')
            ->with(['order.items.product.seller'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Get validator's study program name
        $validatorProdi = $user->validatorProdi;
        $prodiName = $validatorProdi ? $validatorProdi->name : '';
        
        // Pending sellers - mahasiswa yang belum diverifikasi dari prodi validator
        $pendingSellers = User::where('role', 'mahasiswa')
            ->where('verified', false)
            ->where(function($q) use ($prodiName) {
                $q->where('prodi', 'LIKE', '%' . $prodiName . '%')
                  ->orWhere(function($q2) use ($prodiName) {
                      $shortName = str_replace(['Teknik ', 'Sistem '], '', $prodiName);
                      if ($shortName !== $prodiName) {
                          $q2->where('prodi', 'LIKE', '%' . $shortName . '%');
                      }
                  });
            })
            ->latest()
            ->take(5)
            ->get();
        
        // Produk pending terbaru - hanya dari prodi validator
        $pendingProducts = Product::with(['seller', 'category'])
            ->where('status', 'pending_verif')
            ->whereHas('seller', function($query) use ($prodiName) {
                $query->where(function($q) use ($prodiName) {
                    $q->where('prodi', 'LIKE', '%' . $prodiName . '%')
                      ->orWhere(function($q2) use ($prodiName) {
                          $shortName = str_replace(['Teknik ', 'Sistem '], '', $prodiName);
                          if ($shortName !== $prodiName) {
                              $q2->where('prodi', 'LIKE', '%' . $shortName . '%');
                          }
                      });
                });
            })
            ->latest()
            ->take(5)
            ->get();
        
        // Get seller balances in validator's prodi
        $sellerBalances = Balance::where('type', 'seller')
            ->where('amount', '>', 0)
            ->whereHas('user', function($query) use ($prodiName) {
                $query->where('role', 'mahasiswa')
                    ->where(function($q) use ($prodiName) {
                        $q->where('prodi', 'LIKE', '%' . $prodiName . '%')
                          ->orWhere(function($q2) use ($prodiName) {
                              $shortName = str_replace(['Teknik ', 'Sistem '], '', $prodiName);
                              if ($shortName !== $prodiName) {
                                  $q2->where('prodi', 'LIKE', '%' . $shortName . '%');
                              }
                          });
                    });
            })
            ->with('user')
            ->get();
        
        return view('validator.dashboard', compact('user', 'stats', 'transactionStats', 'recentTransactions', 'pendingSellers', 'pendingProducts', 'sellerBalances'));
    }

    /**
     * Display list of pending products for verification
     */
    public function pendingProducts()
    {
        $user = Auth::user();
        $prodiName = $user->validatorStudyProgram->name ?? '';
        
        $products = Product::with(['seller', 'category'])
            ->where('status', 'pending_verif')
            ->whereHas('seller', function($query) use ($prodiName) {
                $query->where(function($q) use ($prodiName) {
                    $q->where('prodi', 'LIKE', '%' . $prodiName . '%')
                      ->orWhere(function($q2) use ($prodiName) {
                          $shortName = str_replace(['Teknik ', 'Sistem '], '', $prodiName);
                          if ($shortName !== $prodiName) {
                              $q2->where('prodi', 'LIKE', '%' . $shortName . '%');
                          }
                      });
                });
            })
            ->latest()
            ->paginate(10);
        
        return view('validator.products.pending', compact('products'));
    }

    /**
     * Display list of all verified products
     */
    public function verifiedProducts()
    {
        $user = Auth::user();
        
        $products = Product::with(['seller', 'category'])
            ->where('status', 'verified')
            ->whereHas('seller', function($query) use ($user) {
                $query->where('prodi', $user->validatorStudyProgram->name ?? '');
            })
            ->latest()
            ->paginate(10);
        
        return view('validator.products.verified', compact('products'));
    }

    /**
     * Display list of rejected products
     */
    public function rejectedProducts()
    {
        $user = Auth::user();
        
        $products = Product::with(['seller', 'category'])
            ->where('status', 'rejected')
            ->whereHas('seller', function($query) use ($user) {
                $query->where('prodi', $user->validatorStudyProgram->name ?? '');
            })
            ->latest()
            ->paginate(10);
        
        return view('validator.products.rejected', compact('products'));
    }

    /**
     * Show product detail for verification
     */
    public function showProduct(Product $product)
    {
        $product->load(['seller', 'category']);
        
        return view('validator.products.show', compact('product'));
    }

    /**
     * Approve a product
     */
    public function approveProduct(Request $request, Product $product)
    {
        // Fixed bagi hasil: 3% untuk validator, 97% untuk penjual
        $validatorShare = 3;

        $product->update([
            'status' => 'verified',
            'seller_proposed_validator_share' => $validatorShare,
            'agreed_validator_share' => $validatorShare,
            'revenue_share_status' => 'agreed'
        ]);

        return redirect()->route('validator.products.pending')
            ->with('success', 'Produk "' . $product->name . '" berhasil diverifikasi dengan bagi hasil 3% untuk validator dan 97% untuk penjual!');
    }

    /**
     * Reject a product
     */
    public function rejectProduct(Request $request, Product $product)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $product->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        return redirect()->route('validator.products.pending')
            ->with('success', 'Produk "' . $product->name . '" ditolak.');
    }

    /**
     * Display list of sellers
     */
    public function sellers(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status', 'all');
        
        // Get validator's prodi name
        $validatorProdi = $user->validatorProdi;
        $prodiName = $validatorProdi ? $validatorProdi->name : '';
        
        // More flexible matching - check if either contains the other
        $query = User::where('role', 'mahasiswa')
            ->where(function($q) use ($prodiName) {
                $q->where('prodi', 'LIKE', '%' . $prodiName . '%')
                  ->orWhere(function($q2) use ($prodiName) {
                      // If prodi is "Teknik Informatika", also match "Informatika"
                      $shortName = str_replace(['Teknik ', 'Sistem '], '', $prodiName);
                      if ($shortName !== $prodiName) {
                          $q2->where('prodi', 'LIKE', '%' . $shortName . '%');
                      }
                  });
            })
            ->with('studyProgram')
            ->withCount([
                'products',
                'products as verified_products_count' => function ($query) {
                    $query->where('status', 'verified');
                },
                'products as pending_products_count' => function ($query) {
                    $query->where('status', 'pending_verif');
                }
            ]);
        
        // Filter by verification status
        if ($status === 'verified') {
            $query->where('verified', true);
        } elseif ($status === 'unverified') {
            $query->where('verified', false);
        }
        
        $sellers = $query->latest()->paginate(12);
        
        // Count for tabs (with same flexible matching)
        $baseQuery = User::where('role', 'mahasiswa')
            ->where(function($q) use ($prodiName) {
                $q->where('prodi', 'LIKE', '%' . $prodiName . '%')
                  ->orWhere(function($q2) use ($prodiName) {
                      $shortName = str_replace(['Teknik ', 'Sistem '], '', $prodiName);
                      if ($shortName !== $prodiName) {
                          $q2->where('prodi', 'LIKE', '%' . $shortName . '%');
                      }
                  });
            });
        
        $allCount = (clone $baseQuery)->count();
        $verifiedCount = (clone $baseQuery)->where('verified', true)->count();
        $unverifiedCount = (clone $baseQuery)->where('verified', false)->count();
        
        return view('validator.sellers.index', compact('sellers', 'status', 'allCount', 'verifiedCount', 'unverifiedCount'));
    }

    /**
     * Show seller detail
     */
    public function showSeller(User $seller)
    {
        $seller->load(['products' => function ($query) {
            $query->with('category')->latest();
        }, 'studyProgram']);
        
        $pendingProducts = $seller->products->where('status', 'pending_verif');
        $verifiedProducts = $seller->products->where('status', 'verified');
        $rejectedProducts = $seller->products->where('status', 'rejected');
        
        return view('validator.sellers.show', compact('seller', 'pendingProducts', 'verifiedProducts', 'rejectedProducts'));
    }

    /**
     * Verify seller account
     */
    public function verifySeller(User $seller)
    {
        $seller->update(['verified' => true]);

        // Kirim notifikasi ke penjual
        Notification::create([
            'user_id' => $seller->id,
            'type' => 'seller_verified',
            'title' => 'Akun Terverifikasi',
            'message' => 'Selamat! Akun penjual Anda telah diverifikasi oleh validator. Anda sekarang dapat mulai berjualan.',
            'is_read' => false,
        ]);

        return back()->with('success', 'Penjual ' . $seller->name . ' berhasil diverifikasi.');
    }

    /**
     * Display orders waiting for payment confirmation (validator)
     */
    public function orders(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status', 'pending_confirmation');

        $query = Order::where('validator_id', $user->id)
            ->where('payment_method', 'transfer')
            ->with(['buyer', 'items.product']);

        if ($status === 'pending_confirmation') {
            $query->where('payment_status', 'pending_confirmation')
                  ->whereNotNull('payment_proof');
        } elseif ($status === 'confirmed') {
            $query->where('payment_status', 'confirmed');
        }

        $orders = $query->latest()->paginate(20);

        $pendingCount = Order::where('validator_id', $user->id)
            ->where('payment_status', 'pending_confirmation')
            ->whereNotNull('payment_proof')
            ->count();

        $confirmedCount = Order::where('validator_id', $user->id)
            ->where('payment_status', 'confirmed')
            ->count();

        return view('validator.orders.index', compact('orders', 'pendingCount', 'confirmedCount', 'status'));
    }

    /**
     * Show order detail (validator)
     */
    public function showOrder(Order $order)
    {
        // Pastikan order ini milik validator ini
        if ($order->validator_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $order->load(['buyer', 'items.product.seller', 'validator']);

        return view('validator.orders.show', compact('order'));
    }

    /**
     * Confirm payment (validator only)
     */
    public function confirmPayment(Order $order)
    {
        // Pastikan order ini milik validator ini
        if ($order->validator_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        DB::transaction(function () use ($order) {
            $order->update([
                'payment_status' => 'confirmed',
                'status' => 'paid',
                'confirmed_at' => now(),
            ]);

            // Split revenue: 97% seller, 3% validator
            $totalAmount = $order->total_amount;
            $sellerShare = $totalAmount * 0.97; // 97%
            $validatorShare = $totalAmount * 0.03; // 3%

            // Update seller balance untuk setiap item
            foreach ($order->items as $item) {
                $itemTotal = $item->price_at_order * $item->quantity;
                $itemSellerShare = $itemTotal * 0.97;
                
                // Get atau create balance untuk seller
                $sellerBalance = Balance::firstOrCreate(
                    ['user_id' => $item->product->seller_id, 'type' => 'seller'],
                    ['amount' => 0, 'pending' => 0]
                );
                
                $sellerBalance->increment('amount', $itemSellerShare);

                // Notify seller
                \App\Models\Notification::createOrderNotification(
                    $item->product->seller_id,
                    'Pembayaran Dikonfirmasi 💰',
                    'Saldo Anda bertambah Rp' . number_format($itemSellerShare, 0, ',', '.') . ' dari pesanan ' . $order->order_code,
                    $order->id,
                    'paid'
                );
            }

            // Update validator balance
            $validatorBalance = Balance::firstOrCreate(
                ['user_id' => $order->validator_id, 'type' => 'validator'],
                ['amount' => 0, 'pending' => 0]
            );
            
            $validatorBalance->increment('amount', $validatorShare);

            // Notify buyer
            \App\Models\Notification::createOrderNotification(
                $order->buyer_id,
                'Pembayaran Dikonfirmasi ✅',
                'Pembayaran pesanan ' . $order->order_code . ' telah dikonfirmasi oleh validator.',
                $order->id,
                'paid'
            );
        });

        return back()->with('success', 'Pembayaran telah dikonfirmasi. Saldo seller dan validator telah diupdate.');
    }
}
