<?php
//  namespace App\Http\Controllers;
// use Illuminate\Http\Request;
// use App\Models\User;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// class AuthController extends Controller {
//     public function register(Request $reqeust)
//     {
//         $reqeust->validate([
//             'name'=>'required|string|max:255',
//             'email'=>'required|string|max:255|unique:users,email',
//             'password'=>'required|string|min:8|confirmed'
//         ]);
//         $user=User::create([
//             'name'=>$reqeust->name,
//             'email'=>$reqeust->email,
//             'password'=>Hash::make($reqeust->password)
//         ]);
//         return response()->json([
//             'message'=>'User Register Successfully',
//             'User'=>$user
//         ],201);
//     }
//     public function login(Request $reqeust)
//     {
//         $reqeust->validate([
//             'email'=>'required|string|email',
//             'password'=>'required|string'
//         ]);
//         if(!Auth::attempt($reqeust->only('email','password')))
//             return response()->json([
//         'message'=>'invaled email or password'
//             ],401);

//             $user=User::where('email',$reqeust->email)->firstOrFail();
//             $token = $user->createToken('auth_token')->plainTextToken;


//             return response()->json([
//                 'message'=>'Login Successfully',
//                 'User'=>$user,
//                 'Token'=>$token
//             ],201);
//             }

//             public function logout(Request $reqeust)
//             {
//                 $reqeust->user()->currentAccessToken()->delete();
//                 return response()->json([
//                     'message'=>'Logout Successfully'
//                 ]);
//             } 
//         }

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    
    public function showRegister(){ return view('auth.register'); }
    public function showLogin(){ return view('auth.login'); }

    public function register(Request $r){
        $r->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8|confirmed'
        ]);
        $user = User::create([
            'name'=>$r->name,
            'email'=>$r->email,
            'password'=>Hash::make($r->password)
        ]);
        Auth::login($user);
        return redirect()->route('admin.blogs.index');
    }

    public function login(Request $r){
        $r->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if (Auth::attempt($r->only('email','password'))) {
            $r->session()->regenerate();
            return redirect()->route('admin.blogs.index');
        }
        return back()->withErrors(['email'=>'بيانات الاعتماد خاطئة']);
    }

    public function logout(Request $r){
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login.form');
    }
}

