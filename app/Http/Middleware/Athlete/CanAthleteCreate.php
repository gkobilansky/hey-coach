<?php

namespace App\Http\Middleware\Athlete;

use Closure;

class CanAthleteCreate
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
        if (!auth()->user()->can('athlete-create')) {
            Session()->flash('flash_message_warning', 'Not allowed to create athlete!');
            return redirect()->route('athletes.index');
        }

        return $next($request);
    }
}
