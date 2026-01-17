<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StudyProgram;
use App\Models\Balance;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SellerController extends Controller
{
    /**
     * Show seller registration form (upgrade to mahasiswa)
     */
    public function register()
    {
        $user = Auth::user();
        
        // If already mahasiswa, redirect to seller dashboard
        if ($user->role === 'mahasiswa') {
            return redirect()->route('seller.dashboard');
        }
        
        // Get all study programs for dropdown
        $studyPrograms = StudyProgram::orderBy('name')->get();
        
        return view('seller.register', compact('studyPrograms'));
    }
    
    /**
     * Process seller registration
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nim' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'student_email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.ac\.id$/'],
            'prodi' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:15'],
        ], [
            'student_email.regex' => 'Email harus menggunakan domain .ac.id (email kampus)',
            'nim.unique' => 'NIM sudah terdaftar',
            'prodi.required' => 'Program studi wajib diisi',
        ]);
        
        // Update user to mahasiswa
        $user->update([
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'phone' => $request->phone,
            'role' => 'mahasiswa',
            'verified' => false, // Will be verified by validator
        ]);
        
        // Kirim notifikasi ke validator prodi yang sesuai
        $studyProgram = StudyProgram::where('name', 'LIKE', '%' . $request->prodi . '%')->first();
        if ($studyProgram) {
            $validator = User::where('role', 'validator')
                ->where('validator_prodi_id', $studyProgram->id)
                ->first();
            
            if ($validator) {
                Notification::create([
                    'user_id' => $validator->id,
                    'type' => 'seller_registration',
                    'title' => 'Pendaftaran Penjual Baru',
                    'message' => $user->name . ' (' . $request->nim . ') mendaftar sebagai penjual dari prodi ' . $request->prodi . '. Silakan verifikasi akun penjual.',
                    'related_id' => $user->id,
                    'is_read' => false,
                ]);
            }
        }
        
        return redirect()->route('seller.dashboard')->with('success', 'Selamat! Akun kamu sudah terdaftar sebagai penjual. Silakan tunggu verifikasi.');
    }
    
    /**
     * Show seller dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Check if user is mahasiswa
        if ($user->role !== 'mahasiswa') {
            return redirect()->route('seller.register');
        }
        
        // Get seller's products
        $products = Product::where('seller_id', $user->id)
            ->latest()
            ->get();
        
        // Count products by status
        $productCounts = [
            'pending' => Product::where('seller_id', $user->id)->where('status', 'pending_verif')->count(),
            'active' => Product::where('seller_id', $user->id)->where('status', 'verified')->count(),
            'sold' => OrderItem::whereHas('product', function($q) use ($user) {
                $q->where('seller_id', $user->id);
            })->sum('quantity'),
        ];
        
        // Calculate total earnings from completed/delivered orders
        $totalEarnings = OrderItem::whereHas('product', function($q) use ($user) {
                $q->where('seller_id', $user->id);
            })
            ->whereHas('order', function($q) {
                // ✅ FIX: Query both 'delivered' and 'completed' status
                $q->whereIn('status', ['delivered', 'completed']);
            })
            ->selectRaw('SUM(price_at_order * quantity) as total')
            ->value('total') ?? 0;
        
        // Get seller balance
        $balance = Balance::firstOrCreate(
            ['user_id' => $user->id, 'type' => 'seller'],
            ['amount' => 0, 'pending' => 0]
        );
        
        return view('seller.dashboard', compact('user', 'products', 'productCounts', 'totalEarnings', 'balance'));
    }
    
    /**
     * Show seller's products list
     */
    public function products()
    {
        $user = Auth::user();
        
        if ($user->role !== 'mahasiswa') {
            return redirect()->route('seller.register');
        }
        
        $products = Product::where('seller_id', $user->id)
            ->latest()
            ->paginate(10);
        
        return view('seller.products', compact('products'));
    }
    
    /**
     * Show edit shop form
     */
    public function editShop()
    {
        $user = Auth::user();
        
        if ($user->role !== 'mahasiswa') {
            return redirect()->route('seller.register');
        }
        
        return view('seller.edit-shop', compact('user'));
    }
    
    /**
     * Update shop information
     */
    public function updateShop(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role !== 'mahasiswa') {
            return redirect()->route('seller.register');
        }
        
        $request->validate([
            'shop_name' => ['required', 'string', 'max:100'],
            'shop_description' => ['nullable', 'string', 'max:1000'],
            'shop_address' => ['nullable', 'string', 'max:500'],
            'shop_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'phone' => ['required', 'string', 'max:15'],
        ], [
            'shop_name.required' => 'Nama toko wajib diisi',
            'shop_name.max' => 'Nama toko maksimal 100 karakter',
            'shop_description.max' => 'Deskripsi toko maksimal 1000 karakter',
            'shop_address.max' => 'Alamat toko maksimal 500 karakter',
            'shop_image.image' => 'File harus berupa gambar',
            'shop_image.max' => 'Ukuran gambar maksimal 2MB',
            'phone.required' => 'Nomor telepon wajib diisi',
        ]);
        
        $data = [
            'shop_name' => $request->shop_name,
            'shop_description' => $request->shop_description,
            'shop_address' => $request->shop_address,
            'phone' => $request->phone,
        ];
        
        // Handle shop image upload
        if ($request->hasFile('shop_image')) {
            // Delete old image if exists
            if ($user->shop_image && \Storage::disk('public')->exists($user->shop_image)) {
                \Storage::disk('public')->delete($user->shop_image);
            }
            
            $imagePath = $request->file('shop_image')->store('shop-images', 'public');
            $data['shop_image'] = $imagePath;
        }
        
        $user->update($data);
        
        return redirect()->route('seller.edit-shop')->with('success', 'Data toko berhasil diperbarui!');
    }
}
