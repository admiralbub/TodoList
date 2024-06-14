<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function login(Request $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('access_token')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return response()->json(['message'=>'User login successfully.','token'=>$success['token']]);
        } 
        else{ 
             return response()->json(['message'=>'Unauthorised.']);
        } 
    }
}
