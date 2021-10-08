<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller{

    public function login(Request $request){
        
        if(!Auth::attempt($request->only('email', 'password'))){

           return response([
               'message' => 'Wrong credentials'
           ], Response::HTTP_UNAUTHORIZED);

        }

        //If the attempt is success the token will be created

        $user = Auth::user();

        //user token is set
        $token = $user->createToken('token')->plainTextToken;

        //store the token in cookie so the frontend will not have to handle it

        $cookie = cookie('jwt', $token, 60 * 24);

        return response([
            'message' => $token
        ])->withCookie($cookie);

    }

}
