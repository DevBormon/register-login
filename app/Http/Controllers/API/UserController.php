<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Buyer;
use App\Seller;
use App\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $successStatus = 200;
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
            'user_type' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }else{
            $credentials = $request->only('email', 'password');
    
            if (Auth::guard('buyer')->attempt($credentials)) {
                // Authentication passed...
                $user = Auth::guard('buyer')->user();
                $data['token'] =  $user->createToken('PujaBazar')->accessToken;
                $data['user'] = $user;
                return response()->json(['data' => $data, 'code' => $this->successStatus]);                
            }else if (Auth::guard('seller')->attempt($credentials)) {
                // Authentication passed...
                $user = Auth::guard('seller')->user();
                $data['token'] =  $user->createToken('PujaBazar')->accessToken;
                $data['user'] = $user;
                return response()->json(['data' => $data, 'code' => $this->successStatus]);
            } else {
                return response()->json(['error' => 'These credentials do not match our records.'], 401);
            }
        }
    }

    public function register(Request $request)
    {

        if($request->user_type == 'Buyer'){
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:buyers',
                'phone' => 'required|digits:10|unique:buyers',
                'password' => 'required|string|min:8|confirmed',
                'user_type' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        }else if($request->user_type == 'Seller'){
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:sellers',
                'phone' => 'required|digits:10|unique:sellers',
                'password' => 'required|string|min:8|confirmed',
                'user_type' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

        }else{
            $validator = Validator::make($request->all(), [
                'user_type' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        if($request->user_type == 'Buyer'){
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
        }else if($request->user_type == 'Seller'){
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
        }

        $data['token'] =  $user->createToken('test')->accessToken;
        $data['user'] = $user;
        return response()->json(['data' => $data,'code' => $this->successStatus]);
        
    }

    public function logout(Request $request)
    {
        if($request->type == 'buyer'){
            Auth::guard('buyer-api')->user()->token()->revoke();
        }else if($request->type == 'seller'){
            Auth::guard('seller-api')->user()->token()->revoke();
        }else{
            return response()->json(['error' => 'User type please'], 401);
        }

        return response()->json(['message' => "Logout Sucessful",'code' => $this->successStatus]);
    }

    public function details(Request $request)
    {
        if($request->type == 'buyer'){
            $user = Auth::guard('buyer-api')->user();
        }else if($request->type == 'seller'){
            $user = Auth::guard('seller-api')->user();
        }else{
            return response()->json(['error' => 'User type please'], 401);
        }
        return response()->json(['success' => $user], $this->successStatus);
    }
}
