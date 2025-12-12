<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if(Auth::user()->role === 'admin')
    //     return $next($request);
    //     return response()->json(['message'=>'Unauthorized'],403);
    // }

    public function handle(Request $request, Closure $next): Response
    {
        // أولاً تأكد أن المستخدم مسجّل دخول
        if(!Auth::check()) {
            return redirect()->route('login.form'); // أو رسالة خطأ مناسبة
        }

        // ثم تحقق من دوره
        if(Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.'); // يمنع أي مستخدم عادي
        }

        return $next($request);
    }
}