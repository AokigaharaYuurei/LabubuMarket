<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function card($id = null)
    {
        if ($id) {
            $product = Product::findOrFail($id);
            return view('products.card', compact('product'));
        }

        $products = Product::all();
        return view('products.card', compact('products'));
    }
}