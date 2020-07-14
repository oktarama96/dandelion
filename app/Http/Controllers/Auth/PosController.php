<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Route;

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
        // Validate the form data
        $this->validate($request, [
          'email'   => 'required|email',
          'password' => 'required|min:6'
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
        return redirect()->back()->withInput($request->only('email'));
    }
    
    public function logout()
    {
      Auth::guard('pengguna')->logout();

      return redirect()->route('pos.login');
    }
    
}
