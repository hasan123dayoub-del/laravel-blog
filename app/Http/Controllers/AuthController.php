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
        return $this->redirectAfterLogin($user);
    }

    public function login(Request $r){
        $r->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user = User::where('email', $r->email)->first();
        if (! $user || ! Hash::check($r->password, $user->password)) {
            return back()->withErrors(['email'=>'بيانات الاعتماد خاطئة']);
        }

        // Users who turned on two-factor authentication must pass Fortify's challenge before they are logged in.
        if ($user->two_factor_secret && $user->two_factor_confirmed_at) {
            $r->session()->put(['login.id' => $user->getKey(), 'login.remember' => $r->boolean('remember')]);
            return redirect()->route('two-factor.login');
        }

        Auth::login($user, $r->boolean('remember'));
        $r->session()->regenerate();
        return $this->redirectAfterLogin($user);
    }

    // Only admins may open the admin panel (CheckUser); everyone else goes to the blog.
    private function redirectAfterLogin(User $user){
        return redirect()->route($user->role === 'admin' ? 'admin.blogs.index' : 'frontend.index');
    }

    public function logout(Request $r){
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login.form');
    }
}

