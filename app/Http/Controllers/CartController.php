<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        $products = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $product->quantity = $quantity;
                $products[] = $product;
                $total += $product->price * $quantity;
            }
        }

        return view('basket', compact('products', 'total'));
    }

    public function add($productId, Request $request)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Товар не найден!'], 404);
            }
            return redirect()->back()->with('error', 'Товар не найден!');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]++;
        } else {
            $cart[$productId] = 1;
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Товар добавлен в корзину!',
                'cartCount' => array_sum($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Товар добавлен в корзину!');
    }

    public function remove($productId, Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Товар удален из корзины!',
                'cartCount' => array_sum($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Товар удален из корзины!');
    }

    public function update($productId, Request $request)
    {
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', $request->json('quantity', 1));

        if ($quantity > 0) {
            $cart[$productId] = $quantity;
        } else {
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Корзина обновлена!',
                'cartCount' => array_sum($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Корзина обновлена!');
    }

    public function clear()
    {
        session()->forget('cart');
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Корзина очищена!',
                'cartCount' => 0
            ]);
        }

        return redirect()->back()->with('success', 'Корзина очищена!');
    }
}