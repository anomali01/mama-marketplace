<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Stemming sederhana untuk Bahasa Indonesia
     * Menghilangkan imbuhan umum untuk mendapatkan kata dasar
     */
    private function stemIndonesian($word)
    {
        $word = strtolower(trim($word));
        
        // Jangan stem kata yang terlalu pendek
        if (strlen($word) <= 3) {
            return $word;
        }
        
        // Hapus imbuhan awalan (prefiks)
        $prefixes = ['meng', 'meny', 'mem', 'men', 'me', 'peng', 'pen', 'per', 'ber', 'ter', 'ke', 'di', 'se'];
        foreach ($prefixes as $prefix) {
            if (substr($word, 0, strlen($prefix)) === $prefix) {
                $word = substr($word, strlen($prefix));
                break;
            }
        }
        
        // Hapus imbuhan akhiran (sufiks)
        $suffixes = ['kan', 'an', 'i', 'nya'];
        foreach ($suffixes as $suffix) {
            if (substr($word, -strlen($suffix)) === $suffix) {
                $word = substr($word, 0, -strlen($suffix));
                break;
            }
        }
        
        return $word;
    }
    
    /**
     * Get search keywords dengan stemming dan fuzzy matching
     */
    private function getSearchKeywords($keyword)
    {
        $keyword = strtolower(trim($keyword));
        
        // Sinonim domain-specific
        $synonyms = [
            'hp' => ['handphone', 'smartphone', 'ponsel', 'telepon', 'phone', 'mobile', 'hp'],
            'handphone' => ['hp', 'smartphone', 'ponsel', 'telepon', 'phone', 'mobile'],
            'smartphone' => ['hp', 'handphone', 'ponsel', 'telepon', 'phone', 'mobile'],
            'laptop' => ['notebook', 'komputer', 'pc', 'laptop'],
            'notebook' => ['laptop', 'komputer', 'pc'],
            'komputer' => ['laptop', 'notebook', 'pc', 'computer'],
            'buku' => ['book', 'novel', 'buku'],
            'sepatu' => ['shoes', 'sandal', 'sendal', 'sepatu'],
            'baju' => ['kaos', 'kemeja', 'shirt', 'pakaian', 'clothes', 'baju'],
            'tas' => ['bag', 'backpack', 'ransel', 'tas'],
            'jam' => ['watch', 'jam'],
            'kipas' => ['kipas angin', 'fan', 'kipas'],
            'mouse' => ['mice', 'tetikus', 'mouse'],
            'keyboard' => ['papan ketik', 'keyboard'],
            'charger' => ['cas', 'pengisian', 'adaptor', 'charger'],
            'headset' => ['headphone', 'earphone', 'headset'],
            'kabel' => ['cable', 'wire', 'kabel'],
            'pulpen' => ['pen', 'pena', 'bolpen', 'pulpen'],
            'makanan' => ['makan', 'snack', 'cemilan', 'food', 'jajanan', 'makanan', 'camilan'],
            'makan' => ['makanan', 'snack', 'cemilan', 'food', 'jajanan', 'camilan'],
            'minuman' => ['minum', 'drink', 'beverage', 'minuman'],
            'minum' => ['minuman', 'drink', 'beverage'],
            'alat' => ['tool', 'peralatan', 'alat'],
        ];
        
        $searchTerms = [];
        
        // 1. Tambahkan keyword asli
        $searchTerms[] = $keyword;
        
        // 2. Stemming kata asli
        $stemmed = $this->stemIndonesian($keyword);
        if ($stemmed !== $keyword && strlen($stemmed) >= 3) {
            $searchTerms[] = $stemmed;
        }
        
        // 3. Pecah menjadi kata-kata individual
        $words = array_filter(array_map('trim', explode(' ', $keyword)));
        foreach ($words as $word) {
            if (strlen($word) >= 2) {
                $searchTerms[] = $word;
                
                // Stem setiap kata
                $wordStem = $this->stemIndonesian($word);
                if ($wordStem !== $word && strlen($wordStem) >= 2) {
                    $searchTerms[] = $wordStem;
                }
                
                // Tambahkan sinonim
                if (isset($synonyms[$word])) {
                    $searchTerms = array_merge($searchTerms, $synonyms[$word]);
                }
                
                // Tambahkan sinonim dari stem
                if (isset($synonyms[$wordStem])) {
                    $searchTerms = array_merge($searchTerms, $synonyms[$wordStem]);
                }
            }
        }
        
        // Hapus duplikat dan kata terlalu pendek
        $searchTerms = array_unique($searchTerms);
        $searchTerms = array_filter($searchTerms, function($term) {
            return strlen($term) >= 2;
        });
        
        return array_values($searchTerms);
    }
    /**
     * Display the home/dashboard page.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        
        $query = Product::with(['category', 'seller.studyProgram']);
        
        // Filter by category if selected
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }
        
        // Get trending products (produk dengan penjualan tertinggi dan terbaru)
        $trendingProducts = Product::with(['category', 'seller.studyProgram'])
            ->where('status', 'verified')
            ->withCount('orderItems') // Hitung jumlah order items
            ->orderByDesc('order_items_count') // Urutkan berdasarkan paling banyak dibeli
            ->orderByDesc('created_at') // Kemudian yang terbaru
            ->take(6) // Ambil 6 produk trending
            ->get();
        
        // Search functionality with AI-like matching
        // Only search if user explicitly entered a search term
        if ($request->has('search') && $request->search != '' && trim($request->search) != '') {
            $searchTerm = $request->search;
            $keywords = $this->getSearchKeywords($searchTerm);
            
            // Build query dengan OR conditions untuk semua keywords
            $query->where(function($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('name', 'like', '%' . $keyword . '%')
                      ->orWhere('description', 'like', '%' . $keyword . '%');
                }
            });
            
            // Tambahkan sorting berdasarkan relevansi (prioritas nama produk)
            // Produk yang memiliki keyword di nama akan muncul lebih dulu
            $firstKeyword = $keywords[0] ?? $searchTerm;
            $query->orderByRaw("CASE 
                WHEN LOWER(name) LIKE ? THEN 1
                WHEN LOWER(name) LIKE ? THEN 2
                WHEN LOWER(description) LIKE ? THEN 3
                ELSE 4
            END", [
                '%' . strtolower($firstKeyword) . '%',
                '%' . strtolower($searchTerm) . '%',
                '%' . strtolower($searchTerm) . '%'
            ]);
        } else {
            // Jika tidak ada search, urutkan berdasarkan terbaru
            $query->latest();
        }
        
        // Only show active products if status column exists
        try {
            $products = $query->where('status', 'verified')
                             ->paginate(10);
        } catch (\Exception $e) {
            // If status column doesn't exist, just get all products
            $products = Product::with(['category', 'seller'])
                              ->latest()
                              ->paginate(10);
        }
        
        return view('home', compact('products', 'categories', 'trendingProducts'));
    }
    
    /**
     * Search products via AJAX.
     */
    public function search(Request $request)
    {
        $query = Product::with(['category', 'seller']);
        
        if ($request->has('q') && $request->q != '') {
            $searchTerm = $request->q;
            $keywords = $this->getSearchKeywords($searchTerm);
            
            // Build query dengan OR conditions
            $query->where(function($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('name', 'like', '%' . $keyword . '%')
                      ->orWhere('description', 'like', '%' . $keyword . '%');
                }
            });
            
            // Sorting berdasarkan relevansi
            $firstKeyword = $keywords[0] ?? $searchTerm;
            $query->orderByRaw("CASE 
                WHEN LOWER(name) LIKE ? THEN 1
                WHEN LOWER(name) LIKE ? THEN 2
                WHEN LOWER(description) LIKE ? THEN 3
                ELSE 4
            END", [
                '%' . strtolower($firstKeyword) . '%',
                '%' . strtolower($searchTerm) . '%',
                '%' . strtolower($searchTerm) . '%'
            ]);
        }
        
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }
        
        try {
            $products = $query->where('status', 'verified')
                             ->take(20)
                             ->get();
        } catch (\Exception $e) {
            $products = $query->take(20)->get();
        }
        
        return response()->json($products);
    }

    /**
     * Display trending page with products grouped by study program and overall
     */
    public function trending(Request $request)
    {
        $user = auth()->user();
        $selectedProdi = $request->get('prodi', 'all'); // Default: semua
        
        // Get all study programs (tampilkan semua prodi yang tersedia)
        $studyPrograms = \App\Models\StudyProgram::orderBy('name')->get();
        
        // Trending Umum - Berdasarkan jumlah pembelian (semua prodi)
        $trendingGeneral = Product::with(['category', 'seller', 'studyProgram'])
            ->where('status', 'verified')
            ->withCount('orderItems')
            ->having('order_items_count', '>', 0)
            ->orderByDesc('order_items_count')
            ->orderByDesc('created_at')
            ->take(12)
            ->get();
        
        // Trending Per Prodi - Berdasarkan filter
        $trendingByProdi = collect();
        if ($selectedProdi !== 'all') {
            // Ambil produk dari prodi yang dipilih (cek prodi_id ATAU seller.prodi)
            $trendingByProdi = Product::with(['category', 'seller', 'studyProgram'])
                ->where('status', 'verified')
                ->where(function($q) use ($selectedProdi) {
                    $q->where('prodi_id', $selectedProdi)
                      ->orWhereHas('seller', function($sq) use ($selectedProdi) {
                          $sq->where('prodi', $selectedProdi);
                      });
                })
                ->withCount('orderItems')
                ->orderByDesc('order_items_count')
                ->orderByDesc('created_at')
                ->take(20)
                ->get();
        } else {
            // Jika "all", ambil semua prodi dengan produk trending (yang sudah terjual)
            $trendingByProdi = Product::with(['category', 'seller', 'studyProgram'])
                ->where('status', 'verified')
                ->where(function($q) {
                    $q->whereNotNull('prodi_id')
                      ->orWhereHas('seller', function($sq) {
                          $sq->whereNotNull('prodi');
                      });
                })
                ->withCount('orderItems')
                ->having('order_items_count', '>', 0)
                ->orderByDesc('order_items_count')
                ->orderByDesc('created_at')
                ->get()
                ->groupBy(function($product) {
                    return $product->prodi_id ?? $product->seller->prodi ?? 0;
                })
                ->filter(function($products, $key) {
                    return $key > 0;
                })
                ->map(function($products) {
                    return $products->take(12);
                });
        }
        
        return view('trending', compact('trendingGeneral', 'trendingByProdi', 'user', 'studyPrograms', 'selectedProdi'));
    }
}
