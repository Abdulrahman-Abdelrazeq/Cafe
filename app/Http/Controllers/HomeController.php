<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){

        if(Auth::id()){

            $userType = Auth()->user()->role;

            if($userType == 'user'){
                return view('customer.index');
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
