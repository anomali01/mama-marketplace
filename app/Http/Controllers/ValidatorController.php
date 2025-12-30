<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidatorController extends Controller
{
    /**
     * Display validator dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistik
        $stats = [
            'pending' => Product::where('status', 'pending_verif')->count(),
            'approved' => Product::where('status', 'verified')->count(),
            'rejected' => Product::where('status', 'rejected')->count(),
            'total_sellers' => User::where('role', 'mahasiswa')
                ->whereHas('products')
                ->count(),
        ];
        
        // Produk pending terbaru
        $pendingProducts = Product::with(['seller', 'category'])
            ->where('status', 'pending_verif')
            ->latest()
            ->take(5)
            ->get();
        
        return view('validator.dashboard', compact('user', 'stats', 'pendingProducts'));
    }

    /**
     * Display list of pending products for verification
     */
    public function pendingProducts()
    {
        $products = Product::with(['seller', 'category'])
            ->where('status', 'pending_verif')
            ->latest()
            ->paginate(10);
        
        return view('validator.products.pending', compact('products'));
    }

    /**
     * Display list of all verified products
     */
    public function verifiedProducts()
    {
        $products = Product::with(['seller', 'category'])
            ->where('status', 'verified')
            ->latest()
            ->paginate(10);
        
        return view('validator.products.verified', compact('products'));
    }

    /**
     * Display list of rejected products
     */
    public function rejectedProducts()
    {
        $products = Product::with(['seller', 'category'])
            ->where('status', 'rejected')
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
        $product->update([
            'status' => 'verified'
        ]);

        return redirect()->route('validator.products.pending')
            ->with('success', 'Produk "' . $product->name . '" berhasil diverifikasi!');
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
    public function sellers()
    {
        $sellers = User::where('role', 'mahasiswa')
            ->whereHas('products')
            ->with('studyProgram')
            ->withCount([
                'products',
                'products as verified_products_count' => function ($query) {
                    $query->where('status', 'verified');
                },
                'products as pending_products_count' => function ($query) {
                    $query->where('status', 'pending_verif');
                }
            ])
            ->paginate(12);
        
        return view('validator.sellers.index', compact('sellers'));
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
}
