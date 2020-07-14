<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warna;
use DataTables;

class WarnaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = Warna::latest()->get();

            return Datatables::of($datas)
                    ->addColumn('Aksi', function($data){
                        $btn = "<button type='button' class='btn btn-warning btn-flat' title='Edit Data' data-toggle='modal' data-target='#edit' onclick='edit(".$data->IdWarna.")'><i class='fa fa-edit'></i></button>";
                        $btn = $btn." <button type='button' class='btn btn-danger btn-flat' title='Delete Data' onclick='deletee(".$data->IdWarna.")'><i class='fa fa-trash'></i></button>";

                        return $btn;
                    })
                    ->rawColumns(['Aksi'])
                    ->make(true);
        }

        return view('pos.pages.warnaproduk');
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
            'NamaWarna' => 'required|',
        ]);

        $tabel = new Warna;

        $tabel->NamaWarna = $request->NamaWarna;

        $tabel->save();
        
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
        $warna = Warna::find($id);
        return response()->json($warna);
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
            'NamaWarna' => 'required|',
        ]);

        $tabel = Warna::find($id);

        $tabel->NamaWarna = $request->NamaWarna;

        $tabel->save();
        
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
        Warna::find($id)->delete();

        return response()->json(['success'=>'sukses']);
    }
}
