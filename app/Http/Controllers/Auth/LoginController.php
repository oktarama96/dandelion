<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $errors = new MessageBag(['email' => ['Email atau password salah!.']]);
        // Validate the form data
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required'
        ]);
        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/shop');
        } 
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withErrors($errors)->withInput($request->except('password'));
    }

    public function showLoginForm()
    {
        return view('login-register');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
