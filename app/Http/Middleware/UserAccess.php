<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class UserAccess
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $userType)
    {
       $type = array ( "HQ","CO","DB","ME","HQ_MAN","FP" );
       $arr = explode('|', $userType);
        foreach ($arr as $arrs){
            if($type[auth()->user()->role] ==  $arrs){
                return $next($request);
            }
        }
        return response()->json(["you do not have permission" ],401);
    }
}
