<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Если есть поисковый запрос, ищем товары
        if ($search) {
            $products = Product::where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('price', 'LIKE', "%{$search}%")
                ->get();
        } else {
            // Если нет поиска, показываем все товары
            $products = Product::all();
        }
        
        return view('products.index', compact('products', 'search'));
    }

    public function card($id)
    {
        $product = Product::findOrFail($id);
        return view('products.card', compact('product'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        
        // Поиск по базе данных
        $products = Product::where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('price', 'LIKE', "%{$search}%")
            ->get();
            
        return view('products.index', compact('products', 'search'));
    }

    // Альтернативный метод с использованием DB facade
    public function searchRaw(Request $request)
    {
        $search = $request->input('search');
        
        $products = DB::table('products')
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('price', 'LIKE', "%{$search}%")
            ->get();
            
        return view('products.index', compact('products', 'search'));
    }
}