<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Symfony\Component\HttpFoundation\Response;


class ApiAdminMiddleware
{
    use HasApiTokens;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::check()){

            if(auth()->user()->tokenCan('sever:admin')){
                return $next($request);

            }else{

                return response()->json([
                'status'=>403,
                'message'=>'Accept Denied! As you are not an Admin'
            ]);
            }

        }else{
            return response()->json([
                'status'=>400,
                'message'=>'Please Login First'
            ]);
        }
       
    }
}
