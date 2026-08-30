<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CustomeAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $session_id = Session::get('Login_Id');
        $user_fingerprint = Session::get('FingetPrint');
        $current_fingerprint = hash_hmac('sha256', $request->userAgent() . '|' . $request->ip(), config('app.key'));

        if(!$session_id){
            return redirect()->route('login');
        }

        return $next($request);
    }
}
