<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Buyer;
use App\Seller;

class RegisterController extends Controller
{
    
    public function index()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        if($request->user_type == 'Buyer'){
            $validator = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:buyers',
                'phone' => 'required|digits:10|unique:buyers',
                'password' => 'required|string|min:8|confirmed',
                'user_type' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $user = Buyer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' =>  Hash::make($request->password),
            ]);
            if($request->hasFile('image')){
                $path = public_path('images');
                $image = $request->file('image');
                $file_name = 'user_'.time().'.'.$image->extension();
                $image->move($path, $file_name);
                $buyer = Buyer::find($user->id);
                $buyer->image = $file_name;
                $buyer->save();
            }
            Auth::guard('buyer')->attempt(['email' => $request->email, 'password' => $request->password]);
            return redirect('buyer');
        }else if($request->user_type == 'Seller'){
            $validator = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:sellers',
                'phone' => 'required|digits:10|unique:sellers',
                'password' => 'required|string|min:8|confirmed',
                'user_type' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $user = Seller::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' =>  Hash::make($request->password),
            ]);

            if($request->hasFile('image')){
                $path = public_path('images');
                $image = $request->file('image');
                $file_name = 'user_'.time().'.'.$image->extension();
                $image->move($path, $file_name);
                $seller = Seller::find($user->id);
                $seller->image = $file_name;
                $seller->save();
            }
            Auth::guard('seller')->attempt(['email' => $request->email, 'password' => $request->password]);

            return redirect('seller');
        }else{
            $validator = $request->validate([
                'user_type' => 'required',
            ]);
        }
        
        
    }
}
