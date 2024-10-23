<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::with('features')->get();
        return view('products', compact('products'));
    }
    
    public function create()
    {
        return view('products.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'required|array',
            'features.*' => 'string|max:255',
        ]);

        $path = $request->file('image')->store('product_images', 'public');

        $product = Product::create([
            'name' => $request->name,
            'image' => $path,
        ]);
        foreach ($request->features as $feature) {
            Feature::create([
                'product_id' => $product->id,
                'feature' => $feature,
            ]);
        }

        return to_route('products')->with('success', 'Product created successfully!');
    }
}
