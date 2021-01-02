<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Auth;
use App\Buyer;
use App\Seller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // dd(Auth::guard('sellers')->user());
        // $this->middleware('auth');
        // $this->middleware('auth:buyer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $buyer = Buyer::all();
        $seller = Seller::all();
        return view('home', ['buyers' => $buyer, 'sellers' => $seller]);
    }
}
