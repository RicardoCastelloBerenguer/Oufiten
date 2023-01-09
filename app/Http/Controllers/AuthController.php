<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => ['required','email'],
            'password' =>'required',
            'remember'=>'boolean'
        ]);
        $remember = $login['remember'] ?? false;

        unset($login['remember']);

        if(!Auth::attempt($login,$remember)){
            return response([
                'message' => 'Email or password introduced incorrect'
            ],403);
        }

        $user = Auth::user();
        if(!$user->is_admin){
            Auth::logout();
            return response([
                'message' => 'Yo don\'t have authorization to enter as an admin.'
            ],401);
        }

        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }


    public function logout()
    {
        $user = Auth::user();

        $user->getRememberToken();

        return response('',200);
    }

    public function getUser(Request $request)
    {
        return new UserResource($request->user());
    }
}
