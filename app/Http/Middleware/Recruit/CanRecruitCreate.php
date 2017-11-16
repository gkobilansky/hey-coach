<?php

namespace App\Http\Middleware\Recruit;

use Closure;

class CanRecruitCreate
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
        if (!auth()->user()->can('lead-create')) {
            Session()->flash('flash_message_warning', 'Not allowed to create lead');
            return redirect()->route('recruits.index');
        }
        return $next($request);
    }
}
