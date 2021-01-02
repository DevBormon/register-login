<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'user_type' => 'required',

        ]);

        if($request->user_type == 'Buyer'){
            if (Auth::guard('buyer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                // Authentication passed...
                return redirect('buyer');
            }else{
                return redirect('login')->withInput($request->input())->with('error', 'Oppes! You have entered invalid credentials');
            }
        }else if($request->user_type == 'Seller'){
            if (Auth::guard('seller')->attempt(['email' => $request->email, 'password' => $request->password])) {
                // Authentication passed...
                return redirect('seller');
            }else{
                return redirect('login')->withInput($request->input())->with('error', 'Oppes! You have entered invalid credentials');
            }
        }

        
    }

    public function logout(Request $request)
    {
        if($request->type == 'buyer'){
            Auth::guard('buyer')->logout();
        }else{
            Auth::guard('seller')->logout();
        }

      return redirect('login');
    }

}
