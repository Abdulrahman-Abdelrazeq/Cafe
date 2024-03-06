<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;


class OrderController extends Controller
{
    public function index()
    {
        $order = Order::where('user_id', auth()->id())->latest('id')->first();
        if($order){
            $order_items = OrderItem::where('order_id', $order->id)->paginate(4);
            $orders = Order::where('user_id', auth()->id())->latest('id')->paginate(4);
        }
        return view('customer.myorder', ['order_items' => $order_items??null, 'orders'=> $orders??null]);  
    }

    public function showOrdersBetweenDates(Request $request)
    {
        // Get start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $order = Order::where('user_id', auth()->id())->whereBetween('created_at', [$startDate, $endDate])->latest('id')->first();
        if($order){
            $order_items = OrderItem::where('order_id', $order->id)->paginate(4);
        }
        // Fetch orders between the two dates
        $orders = Order::where('user_id', auth()->id())->whereBetween('created_at', [$startDate, $endDate])->latest('id')->get();

        return view('customer.myorder', ['order_items' => $order_items ?? null, 'orders'=> $orders]);
    }

    public function remove_order($id)
    {
        $order = Order::findOrFail($id);
        // dd($item);
        $order->delete();

        // $cart = Cart::where('user_id', auth()->id())->first();
        // $items = CartItem::where('cart_id', $cart->id)->get();
        // $products = Product::paginate(4);
        return redirect()->back();
    }
}
