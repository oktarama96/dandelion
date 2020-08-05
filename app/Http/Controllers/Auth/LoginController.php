<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use RuangApi;
use App\Pelanggan;

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
        $provinsis = RuangApi::getProvinces();
        return view('login-register', ['provinsis' => $provinsis]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

    public function tampilkabupaten($id){
        $id = (int)$id;
        $kabupatens = RuangApi::getCities($id, null, null);
        //dd($kabupatens);
        return response()->json($kabupatens);
    }

    public function tampilkecamatan($id){
        $id = (int)$id;
        $kecamatans = RuangApi::getDistricts($id, null, null);
        //dd($kabupatens);
        return response()->json($kecamatans);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'NamaPelanggan' => 'required|',
            'Email' => 'required|email|unique:pelanggan',
            'Password' => 'required|',
            'JenisKelamin' => 'required|',
            'TglLahir' => 'required|',
            'NoHandphone' => 'required|',
            'Alamat' => 'required|',
            'Provinsi' => 'required|',
            'NamaProvinsi' => 'required|',
            'Kabupaten' => 'required|',
            'NamaKabupaten' => 'required|',
            'Kecamatan' => 'required|',
            'NamaKecamatan' => 'required|',
        ]);

        $pelanggan = new Pelanggan;

        $pelanggan->NamaPelanggan = $request->NamaPelanggan;
        $pelanggan->email = $request->Email;
        $pelanggan->password = bcrypt($request->Password);
        $pelanggan->JenisKelamin = $request->JenisKelamin;
        $pelanggan->TglLahir = $request->TglLahir;
        $pelanggan->NoHandphone = $request->NoHandphone;
        $pelanggan->Alamat = $request->Alamat;
        $pelanggan->IdProvinsi = $request->Provinsi;
        $pelanggan->NamaProvinsi = $request->NamaProvinsi;
        $pelanggan->IdKabupaten = $request->Kabupaten;
        $pelanggan->NamaKabupaten = $request->NamaKabupaten;
        $pelanggan->IdKecamatan = $request->Kecamatan;
        $pelanggan->NamaKecamatan = $request->NamaKecamatan;

        $pelanggan->save();
        
        Auth::guard('web')->login($pelanggan);

        return redirect('shop');
    }
}
