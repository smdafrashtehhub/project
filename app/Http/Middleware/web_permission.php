<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class web_permission
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
//--------------------------------------- web ---------------------------------------
//        $user = auth()->user();
//        if (!$user) {
//            return redirect()->route('login');
//        } else {
//            if (in_array($user->role, $role))
//                return $next($request);
//            else
//                return redirect()->route('error');
//        }
//        return $next($request);
//--------------------------------------- api ---------------------------------------
        try {
//            dd(auth()->user());
            $user = auth()->user();
            if (in_array($user->role, $role))
                return $next($request);
            else
                return response()->json([
                    'status' => false,
                    'message' => 'کاربر ' . $user->first_name . ' ' . $user->last_name . ' به ابن لینک دسترسی ندارد'
                ]);
        } catch (\throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}

//public function handle(Request $request, Closure $next,string $admin,string $seller='',string $customer=''): Response
//    {
//
//        $user=auth()->user();
//        if(!$user)
//        {
//            return redirect()->route('login');
//        }
//        else
//        {
//            if($admin=='admin' && $seller == '' && $customer=='')
//            {
//                if($user->role == 'admin') {
//                    return $next($request);
//                }
//                else
//                {
//
//                    return redirect()->route('error');
//                }
//
//            }
//            if($admin=='admin' && $seller == 'seller' && $customer=='')
//            {
//                if($user->role == 'admin' || $user->role == 'seller') {
//                    return $next($request);
//                }
//                else{
//
//                    return redirect()->route('error');
//                }
//            }
//            if($admin=='admin' && $seller == 'seller' && $customer=='customer')
//            {
//                if($user->role == 'admin' || $user->role == 'seller' || $user->role == 'customer') {
//                    return $next($request);
//                }
//                else{
//
//                    return redirect()->route('error');
//                }
//            }
//
//
//
//        }
//
//        return $next($request);
//    }
//}

