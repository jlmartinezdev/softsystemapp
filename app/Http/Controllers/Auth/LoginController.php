<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServieProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    // public function showLoginForm()
    // {
    //     return view('login');
    // }
    use AuthenticatesUsers;

    /**
    * Check either username or email.
    * @return string
    */
    public function username()
    {
        return 'user_usuarios';
    }
     public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            //return $this->sendLoginResponse($request);
            return response()->json(['success'=>'si'],200);
        }
        $this->incrementLoginAttempts($request);

        return response()->json(['success'=>'no'],200);
            
        
    }
}
