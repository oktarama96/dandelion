<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan;
use App\Produk;
use DataTables;
use RuangApi;
use Auth;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = Pelanggan::latest()->get();

            return Datatables::of($datas)
                    ->editColumn('Alamat', function ($data) {
                        return $data->Alamat.", ".$data->NamaKecamatan.", ".$data->NamaKabupaten.", ".$data->NamaProvinsi;
                    })
                    ->addColumn('Aksi', function($data){
                        $btn = "<button type='button' class='btn btn-warning btn-flat' title='Edit Data' data-toggle='modal' data-target='#edit' onclick='edit(".$data->IdPelanggan.")'><i class='fa fa-edit'></i></button>";
                        $btn = $btn." <button type='button' class='btn btn-danger btn-flat' title='Delete Data' onclick='deletee(".$data->IdPelanggan.")'><i class='fa fa-trash'></i></button>";

                        return $btn;
                    })
                    ->rawColumns(['Aksi'])
                    ->make(true);
        }
        
        $provinsis = RuangApi::getProvinces();
        //dd($provinsis);
        return view('pos.pages.pelanggan', ['provinsis' => $provinsis]);
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

        $tabel = new Pelanggan;

        $tabel->NamaPelanggan = $request->NamaPelanggan;
        $tabel->email = $request->Email;
        $tabel->password = bcrypt($request->Password);
        $tabel->JenisKelamin = $request->JenisKelamin;
        $tabel->TglLahir = $request->TglLahir;
        $tabel->NoHandphone = $request->NoHandphone;
        $tabel->Alamat = $request->Alamat;
        $tabel->IdProvinsi = $request->Provinsi;
        $tabel->NamaProvinsi = $request->NamaProvinsi;
        $tabel->IdKabupaten = $request->Kabupaten;
        $tabel->NamaKabupaten = $request->NamaKabupaten;
        $tabel->IdKecamatan = $request->Kecamatan;
        $tabel->NamaKecamatan = $request->NamaKecamatan;

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
        $tabel = Pelanggan::find($id);
        $kabupatens = RuangApi::getCities($tabel->IdProvinsi, null, null);
        $kecamatans = RuangApi::getDistricts($tabel->IdKabupaten, null, null);

        return response()->json(array(
            'tabel' => $tabel,
            'kabupatens' => $kabupatens,
            'kecamatans' => $kecamatans,
        ));
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
            'NamaPelanggan' => 'required|',
            'Email' => 'email',
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

        $tabel = Pelanggan::find($id);

        $tabel->IdPelanggan = $request->IdPelanggan;
        $tabel->NamaPelanggan = $request->NamaPelanggan;
        if($request->has('Email')){
            $tabel->email = $request->Email;
        }

        if($request->has('Password')){
            $tabel->password = bcrypt($request->Password);
        }     
        $tabel->JenisKelamin = $request->JenisKelamin;
        $tabel->TglLahir = $request->TglLahir;
        $tabel->NoHandphone = $request->NoHandphone;
        $tabel->Alamat = $request->Alamat;
        $tabel->IdProvinsi = $request->Provinsi;
        $tabel->NamaProvinsi = $request->NamaProvinsi;
        $tabel->IdKabupaten = $request->Kabupaten;
        $tabel->NamaKabupaten = $request->NamaKabupaten;
        $tabel->IdKecamatan = $request->Kecamatan;
        $tabel->NamaKecamatan = $request->NamaKecamatan;

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
        Pelanggan::find($id)->delete();

        return response()->json(['success'=>'sukses']);
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

    public function tampilakun($id)
    {
        $warnas = '';
        $ukurans = '';

        $cart_produk = "[]";
        $cart_total = 0;

        if(Auth::guard('web')->check()){
            $cart_produk = [];
            $cart_produk = app('App\Http\Controllers\ShopController')->getCart();

            foreach($cart_produk as $produk){
                $cart_total+=$produk->sub_total;
            }
        }

        $pelanggans = Pelanggan::find($id);
        $provinsis = RuangApi::getProvinces();
        $kabupatens = RuangApi::getCities($pelanggans->IdProvinsi, null, null);
        $kecamatans = RuangApi::getDistricts($pelanggans->IdKabupaten, null, null);

        // dd($provinsis);
        // dd($kabupatens);
        return view('my-account', compact('pelanggans','warnas','ukurans','cart_produk','cart_total','provinsis','kabupatens','kecamatans'));
    }
}
