<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KategoriProduk;
use DataTables;

class KategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kategoriproduk = KategoriProduk::latest()->get();

            return Datatables::of($kategoriproduk)
                    ->addColumn('Aksi', function($data){
                        $btn = "<button type='button' class='btn btn-warning btn-flat' title='Edit Data' data-toggle='modal' data-target='#edit' onclick='edit(".$data->IdKategoriProduk.")'><i class='fa fa-edit'></i></button>";
                        $btn = $btn." <button type='button' class='btn btn-danger btn-flat' title='Delete Data' onclick='deletee(".$data->IdKategoriProduk.")'><i class='fa fa-trash'></i></button>";

                        return $btn;
                    })
                    ->rawColumns(['Aksi'])
                    ->make(true);
        }

        return view('pos.pages.kategoriproduk');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'NamaKategoriProduk' => 'required|',
        ]);

        $kategoriproduk = new KategoriProduk;

        $kategoriproduk->NamaKategori = $request->NamaKategoriProduk;

        $kategoriproduk->save();
        
        return response()->json(['success'=>'sukses']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategoriproduk = KategoriProduk::find($id);
        return response()->json($kategoriproduk);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'NamaKategoriProduk' => 'required|',
        ]);

        $kategoriproduk = KategoriProduk::find($id);

        $kategoriproduk->NamaKategori = $request->NamaKategoriProduk;

        $kategoriproduk->save();
        
        return response()->json(['success'=>'sukses']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        KategoriProduk::find($id)->delete();

        return response()->json(['success'=>'sukses']);
    }
}
