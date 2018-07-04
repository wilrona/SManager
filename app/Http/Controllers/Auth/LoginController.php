<?php

namespace App\Http\Controllers\Auth;



use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){

          //echo Request::method();
//       echo $request->get('email');
//       echo $request->get('password');
       $email = $request->input('email');
       $password = $request->input('password');
       $attempt = Auth::attempt(['email' => $email, 'password' => $password]);

        if ($attempt) {
            return redirect()->intended('/');
        } else {
            return redirect()->intended('/login');
        }

    }

    public function logout() {
       Auth::logout();
        return redirect()->intended('login');
      // return Redirect::away('login');
    }
}
