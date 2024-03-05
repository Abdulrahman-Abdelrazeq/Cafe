<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{


    public function addToCart(Request $request, $productId)
    {
        // dd()
        $cart = Cart::where('user_id', auth()->id())->first();

        // Create a new cart item or update if already exists
        $cartItem = CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $productId],
            ['quantity' => \DB::raw('quantity + 1')] // Increase quantity by 1
        );

        $items = CartItem::where('cart_id', $cart->id)->get();
        $products = Product::paginate(4);
        
        view('customer.index', ['items' => $items, 'products' => $products]);

        return redirect()->back();
    }


    public function removeFromCart($item_id)
    {
        $item = CartItem::findOrFail($item_id);
        // dd($item);
        $item->delete();

        $cart = Cart::where('user_id', auth()->id())->first();
        $items = CartItem::where('cart_id', $cart->id)->get();
        $products = Product::paginate(4);
        return redirect()->back();
    }

    public function increaseQuantity($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->quantity++;
        $cartItem->save();
        return redirect()->back();
    }

    public function reduceQuantity($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        if ($cartItem->quantity > 1) {
            $cartItem->quantity--;
            $cartItem->save();
        } else {
            $cartItem->delete(); // Remove the item if quantity is 1 or less
        }
        return redirect()->back();
    }



}
