<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserStatusVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if login request then bypass
        if($request->path()=='app/login'){
            return $next($request);
        }

        // Make sure user is authenticated, for some routes.
        if(!Auth::check()){
            return response()->json([
                'msg' => 'You are not allowed to perform this operation.' , 
                'url' => $request->path()
            ], 403);
        }
        
        return $next($request);
    }
}
