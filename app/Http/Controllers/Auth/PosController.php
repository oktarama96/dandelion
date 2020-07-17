<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Route;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

class PosController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:pengguna', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
      return view('pos.login');
    }

    public function login(Request $request)
    {
        $errors = new MessageBag(['email' => ['Email atau password salah!.']]);
        // Validate the form data
        $this->validate($request, [
          'email'   => 'required|email',
          'password' => 'required'
        ]);
      
        if (Auth::guard('pengguna')->attempt(['email' => $request->email, 'password' => $request->password])) {
          
            if (Auth::guard('pengguna')->user()->Is_admin == 1) {
                // return "Halaman Admin";
                return redirect()->route('kasir.index');
                // return redirect()->intended(route('admin.dashboard'));
            }else{
                return redirect()->route('kasir.index');
            }
        } 
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withErrors($errors)->withInput($request->except('password'));
    }
    
    public function logout()
    {
      Auth::guard('pengguna')->logout();

      return redirect()->route('pos.login');
    }
    
}
