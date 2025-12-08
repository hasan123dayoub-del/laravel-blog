<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;

class UserController extends Controller
{
    public function register(Request $reqeust)
    {
        $reqeust->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255|unique:users,email',
            'password'=>'required|string|min:8|confirmed'
        ]);
        $user=User::create([
            'name'=>$reqeust->name,
            'email'=>$reqeust->email,
            'password'=>Hash::make($reqeust->password)
        ]);
        return response()->json([
            'message'=>'User Register Successfully',
            'User'=>$user
        ],201);
    }
    public function login(Request $reqeust)
    {
        $reqeust->validate([
            'email'=>'required|string|email',
            'password'=>'required|string'
        ]);
        if(!Auth::attempt($reqeust->only('email','password')))
            return response()->json([
        'message'=>'invaled email or password'
            ],401);

            $user=User::where('email',$reqeust->email)->firstOrFail();
            $token=$user->creareToken('auth_token')->plainTextToken;
            return response()->json([
                'message'=>'Login Successfully',
                'User'=>$user,
                'Token'=>$token
            ],201);
            }

            public function logout(Request $reqeust)
            {
                $reqeust->user()->currentAccessToken()->delete();
                return response()->json([
                    'message'=>'Logout Successfully'
                ]);
            }
}
