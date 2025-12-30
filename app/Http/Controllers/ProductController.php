<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(12);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['seller_id'] = auth()->id();
        $data['status'] = 'pending_verif'; // Menunggu verifikasi

        // Handle single image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['images'] = [$path];
        }

        Product::create($data);

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil ditambahkan dan menunggu verifikasi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['seller.studyProgram', 'category']);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
