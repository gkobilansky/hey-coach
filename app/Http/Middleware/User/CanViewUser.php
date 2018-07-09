<?php

namespace App\Http\Middleware\User;

use App\Models\User;
use Closure;
use Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class CanViewUser
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
        Log::debug("user view Middleware " . $request);
        Log::debug("user view Middleware parameters " . json_encode($request->route()->parameters()));
        $user_id = $request->route('user');
        $user = User::where('id', $user_id)->first();
        Log::debug("user view result Middleware " . json_encode($user));

        if($user == null) {
            //TODO - return page does not exist
            return new Response(view('auth/unauthorized'));
        } 
        if($user->college_id == Session::get('college_id')) {
            Log::debug("user view Middleware has access");
            return $next($request);
        } else {            
            Log::debug("user view Middleware does not have access");
            return new Response(view('auth/unauthorized'));
        }
        
        
    }
}