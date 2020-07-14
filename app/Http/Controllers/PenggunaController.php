<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengguna;
use DataTables;

class PenggunaController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $pengguna = Pengguna::latest()->get();

            return Datatables::of($pengguna)
                    ->editColumn('Is_admin', function ($data) {
                        if($data->Is_admin == 1){
                            return "Admin";
                        }else{
                            return "Kasir";
                        }
                    })
                    ->addColumn('Aksi', function($data){
                        $btn = "<button type='button' class='btn btn-warning btn-flat' title='Edit Data' data-toggle='modal' data-target='#edit' onclick='edit(".$data->IdPengguna.")'><i class='fa fa-edit'></i></button>";
                        $btn = $btn." <button type='button' class='btn btn-danger btn-flat' title='Delete Data' onclick='deletee(".$data->IdPengguna.")'><i class='fa fa-trash'></i></button>";

                        return $btn;
                    })
                    ->rawColumns(['Aksi'])
                    ->make(true);
        }

        return view('pos.pages.pengguna');
    }

    public function store(Request $request){
        $this->validate($request, [
            'NamaPengguna' => 'required|min:4',
            'Email' => 'required|min:4|email|unique:pengguna',
            'Password' => 'required',
            'Alamat' => 'required|min:4',
            'NoHandphone' => 'required|min:4',
            'jabatan' => 'required',
        ]);

        $pengguna = new Pengguna;

        $pengguna->NamaPengguna = $request->NamaPengguna;
        $pengguna->Email = $request->Email;
        $pengguna->Password = bcrypt($request->Password);
        $pengguna->Alamat = $request->Alamat;
        $pengguna->NoHandphone = $request->NoHandphone;
        $pengguna->Is_admin = $request->jabatan;

        $pengguna->save();
        
        return response()->json(['success'=>'sukses']);
        
    }

    public function edit($id){
        $pengguna = Pengguna::find($id);
        return response()->json($pengguna);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'NamaPengguna' => 'required|min:4',
            'Email' => 'min:4|email',
            'Alamat' => 'required|min:4',
            'NoHandphone' => 'required|min:4',
            'jabatan' => 'required',
        ]);
        
        $pengguna = Pengguna::find($id);
        
        $pengguna->IdPengguna = $request->IdPengguna;
        $pengguna->NamaPengguna = $request->NamaPengguna;
        if($request->has('Email')){
            $pengguna->Email = $request->Email;
        }

        if($request->has('Password')){
            $pengguna->Password = bcrypt($request->Password);
        }        
        $pengguna->Alamat = $request->Alamat;
        $pengguna->NoHandphone = $request->NoHandphone;
        $pengguna->Is_admin = $request->jabatan;

        $pengguna->save();


        return response()->json(['success'=>'sukses']);
    }

    public function destroy($id){

        Pengguna::find($id)->delete();

        return response()->json(['success'=>'sukses']);
    }
}
