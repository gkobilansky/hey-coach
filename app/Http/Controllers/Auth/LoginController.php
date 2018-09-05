<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        Log::debug("authenticated - attempting to store user " . json_encode($user));
        $college = $user->college;
        Log::debug("getting college of user " . json_encode($college));
        Log::debug("sub_domain_name through helper " . json_encode(get_subdomain($user)));
        //$request->session()->put('UserAgent', $user);
        //$request->session()->put('college_id', $user->college_id);
        //$request->session()->put('user_id', $user->id);
        Session::put('sub_domain_name', $college->sub_domain_name);
        Session::put('UserAgent', $user);
        Session::put('college_id', $user->college_id);
        Session::put('user_id', $user->id);

    }    
}
