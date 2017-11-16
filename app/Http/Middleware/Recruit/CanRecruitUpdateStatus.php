<?php

namespace App\Http\Middleware\Recruit;

use Closure;
use App\Models\Setting;
use App\Models\Recruit;

class CanRecruitUpdateStatus
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
        $lead = Recruit::findOrFail($request->id);
        $isAdmin = Auth()->user()->hasRole('administrator');

        $settings = Setting::all();
        if ($isAdmin) {
            return $next($request);
        }
        $settingscomplete = $settings[0]['lead_complete_allowed'];
        if ($settingscomplete == 1  && Auth()->user()->id == $lead->fk_user_id_assign) {
            Session()->flash('flash_message_warning', 'Only assigned user are allowed to close recruiting pipeline.');
            return redirect()->back();
        }
        return $next($request);
    }
}
