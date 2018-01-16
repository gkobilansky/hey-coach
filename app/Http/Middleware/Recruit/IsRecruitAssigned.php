<?php

namespace App\Http\Middleware\Recruit;

use Closure;
use App\Models\Setting;
use App\Models\Recruit;

class IsRecruitAssigned
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
        $recruit = Recruit::findOrFail($request->id);
        $settings = Setting::all();
        $isAdmin = Auth()->user()->hasRole('administrator');
        $settingscomplete = $settings[0]['recruit_assign_allowed'];
        if ($isAdmin) {
            return $next($request);
        }
        else if ($settingscomplete == 1  && Auth()->user()->id == $recruit->fk_user_id_assign) {
            Session()->flash('flash_message_warning', 'Not allowed to create recruit');
            return redirect()->back();
        }
        return $next($request);
    }
}
