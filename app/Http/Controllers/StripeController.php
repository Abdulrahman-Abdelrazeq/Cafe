<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class StripeController extends Controller
{
    
    public function session(Request $request)
    {
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
        return "Thanks for you order You have just completed your payment.";
    }

    public function cancel()
    {
        return "cancel";
    }
}