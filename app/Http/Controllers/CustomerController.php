<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;


class CustomerController extends Controller
{
    // public function index()
    // {
    //     return view('customer.index');
    // }


    public function orders()
    {
        $products = Product::paginate(4);
        return view('customer.myorder', ['products' => $products]);
    }
}
