<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KuponDiskon;
use DataTables;

class KuponDiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = KuponDiskon::latest()->get();

            return Datatables::of($datas)
                    ->addColumn('Status', function($data){
                        $tglskrg = date_format(date_create(),'yy-m-d h:i:s');
                        $tglmulai = $data->TglMulai;
                        $tglselesai = $data->TglSelesai;

                        if($tglmulai <= $tglskrg && $tglselesai >= $tglskrg){
                            $status = "<span class='badge badge-success'>Aktif</span>";
                        }else{
                            $status = "<span class='badge badge-danger'>Tidak Aktif</span>";
                        }

                        //dd($tglskrg);

                        return $status;
                    })
                    ->addColumn('Aksi', function($data){
                        //dd($data);
                        $btn = "<button type='button' class='btn btn-warning btn-flat' title='Edit Data' data-toggle='modal' data-target='#edit' onclick='edit(\"".$data->IdKuponDiskon."\")'><i class='fa fa-edit'></i></button>";
                        $btn = $btn." <button type='button' class='btn btn-danger btn-flat' title='Delete Data' onclick='deletee(\"".$data->IdKuponDiskon."\")'><i class='fa fa-trash'></i></button>";

                        return $btn;
                    })
                    ->rawColumns(['Aksi','Status'])
                    ->make(true);
        }

        return view('pos.pages.kupondiskon');
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
            'IdKuponDiskon' => 'required|',
            'NamaKuponDiskon' => 'required|',
            'TglMulai' => 'required|',
            'TglSelesai' => 'required|',
            'JumlahPotongan' => 'required|',
        ]);

        $tabel = new KuponDiskon;

        $tabel->IdKuponDiskon = $request->IdKuponDiskon;
        $tabel->NamaKupon = $request->NamaKuponDiskon;
        $tabel->TglMulai = $request->TglMulai;
        $tabel->TglSelesai = $request->TglSelesai;
        $tabel->JumlahPotongan = $request->JumlahPotongan;

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
        $kupondiskon = KuponDiskon::find($id);
        return response()->json($kupondiskon);
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
            'IdKuponDiskon' => 'required|',
            'NamaKuponDiskon' => 'required|',
            'TglMulai' => 'required|',
            'TglSelesai' => 'required|',
            'JumlahPotongan' => 'required|',
        ]);

        $tabel = KuponDiskon::find($id);

        $tabel->IdKuponDiskon = $request->IdKuponDiskon;
        $tabel->NamaKupon = $request->NamaKuponDiskon;
        $tabel->TglMulai = $request->TglMulai;
        $tabel->TglSelesai = $request->TglSelesai;
        $tabel->JumlahPotongan = $request->JumlahPotongan;

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
        KuponDiskon::find($id)->delete();

        return response()->json(['success'=>'sukses']);
    }
}
