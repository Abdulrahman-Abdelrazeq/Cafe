<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Session;


class StripeController extends Controller
{
    
    public function session(Request $request)
    {
        Session::put('note', $request->note);

        $user = auth()->user();
        $productItems = [];
        
        \Stripe\Stripe::setApiKey(config('stripe.sk'));
        $cart = Cart::where('user_id', auth()->id())->first();
        $cartItems = CartItem::where('cart_id', $cart->id)->get();
        foreach ($cartItems as $item) {
            // dd($user->email);

            $product_name = $item->product->name;
            $total = $item->product->price;
            $quantity = $item->quantity;

            $two0 = "00";
            $unit_amount = intval($total)."$two0";

            $productItems[] = [
            'price_data' => [
            'product_data' => [
            'name' => $product_name,
            ],
            'currency' => 'EGP',
            'unit_amount' => $unit_amount,
            ],
            'quantity' => $quantity
            ];
        }
        // dd($productItems);
        $checkoutSession = \Stripe\Checkout\Session::create([
        'line_items' => [$productItems],
        'mode' => 'payment',
        'allow_promotion_codes' => true,
        'metadata' => [
        'user_id' => "0001"
        ],
        'customer_email' => $user->email,
        'success_url' => route('success'),
        'cancel_url' => route('cancel'),
        ]);

        return redirect()->away($checkoutSession->url);
    }

    public function success()
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        $cartItems = CartItem::where('cart_id', $cart->id)->get();
        $total_amount = 0;
        foreach ($cartItems as $item) {
            $price = $item->product->price;
            $quantity = $item->quantity;
            $total = $price * $quantity;
            $total_amount += $total;
        }
        Order::create([
            'user_id'=> auth()->user()->id,
            'total_amount'=> $total_amount,
            'notes'=> session('note'),
        ]);
        $order = Order::where('user_id', auth()->id())->latest('id')->first();
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'=> $order->id,
                'product_id'=> $item->product->id,
                'quantity'=> $item->quantity,
            ]);
            $item->delete();
        }
        
        
        return redirect()->route('home')->with('message','The order was processed successfully');
    }

    public function cancel()
    {
        return redirect()->route('home')->with('message','You canceled the order');
    }
}