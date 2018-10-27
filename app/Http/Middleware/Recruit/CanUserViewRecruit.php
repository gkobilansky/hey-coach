<?php

namespace App\Http\Middleware\Recruit;

use App\Models\Recruit;
use Closure;
use Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class CanUserViewRecruit
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
        Log::debug("recruit view Middleware " . $request);
        //Log::debug("recruit view Middleware parameters " . json_encode($request->route()->parameters()));
        $recruit_id = $request->route('recruit');
        $recruit = Recruit::where('id', $recruit_id)->first();
        if($recruit == null) {
            //TODO - return page does not exist
            return new Response(view('auth/unauthorized'));
        } 
        $role = Session::get('role');
        if($recruit->college_id == Session::get('college_id') || $role->name == 'super_administrator') {
            Log::debug("recruit view Middleware has access");
            return $next($request);
        } else {            
            Log::debug("recruit view Middleware does not have access");
            return new Response(view('auth/unauthorized'));
        }
        
        
    }
}
