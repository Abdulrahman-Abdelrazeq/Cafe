<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{



    public function index(){

        if(Auth::id()){

            $userType = Auth()->user()->role;

            if($userType == 'user'){
                $cartExists = Cart::where('user_id', Auth::id())->exists();
                if (!$cartExists) {
                    Cart::create([
                        'user_id'=> Auth::id()
                    ]);
                }
                $cart = Cart::where('user_id', auth()->id())->first();
                $items = CartItem::where('cart_id', $cart->id)->get();
                $products = Product::paginate(8);
                
                // return $totalPrice;
                $totalPrice = 0;
                foreach ($items as $item) {
                    $totalPrice += $item->quantity * $item->product->price;
                }
                return view('customer.index', ['items' => $items, 'products' => $products, 'totalPrice' => $totalPrice]);
            }
            else if($userType == 'admin'){
                return view('admin.index');
            }
            else{
                return redirect()->back();
            }
        }

    }
}
