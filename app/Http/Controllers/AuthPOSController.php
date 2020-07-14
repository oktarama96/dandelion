<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthPOSController extends Controller
{
    public function login(Request $request){
        
        $this->validate($request, [
            'email' => 'required|string', //VALIDASI KOLOM USERNAME
            //TAPI KOLOM INI BISA BERISI EMAIL ATAU USERNAME
            'password' => 'required|string|min:6',
        ]);
    
        //TAMPUNG INFORMASI LOGINNYA, DIMANA KOLOM TYPE PERTAMA BERSIFAT DINAMIS BERDASARKAN VALUE DARI PENGECEKAN DIATAS
        $login = [
            'email' => $request->email,
            'password' => $request->password,
            'hakases' => "0"
        ];
    
        //LAKUKAN LOGIN
        if (auth()->attempt($login)) {
            dd($login);
            //JIKA BERHASIL, MAKA REDIRECT KE HALAMAN HOME
            //return redirect()->route('index');
        }
        //dd($login);
        //JIKA SALAH, MAKA KEMBALI KE LOGIN DAN TAMPILKAN NOTIFIKASI 
        //return redirect()->route('login')->with(['error' => 'Email/Password salah!']);
    }
}
