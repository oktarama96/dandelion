<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan;
use App\Produk;
use App\Transaksi;
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
        if(!empty($request->Email)){
            $tabel->email = $request->Email;
        }

        if(!empty($request->Password)){
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

    public function tampilakun(Request $request, $id)
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

        if ($request->ajax()) {
            $datas = Transaksi::where('IdPelanggan', $id)->orderBy('TglTransaksi', 'DESC')->get();

            return Datatables::of($datas)
                            ->editColumn('Total', function($data){
                                return "Rp. ".number_format($data->Total,0,',',',')."";
                            })
                            ->editColumn('Potongan', function($data){
                                return "Rp. ".number_format($data->Potongan,0,',',',')."";
                            })
                            ->editColumn('OngkosKirim', function($data){
                                return "Rp. ".number_format($data->OngkosKirim,0,',',',')."";
                            })
                            ->editColumn('GrandTotal', function($data){
                                return "Rp. ".number_format($data->GrandTotal,0,',',',')."";
                            })
                            ->editColumn('StatusPembayaran', function($data){
                                if($data->StatusPembayaran == 1){
                                    $status = "<span class='badge badge-success'>Lunas</span>";
                                }else if($data->StatusPembayaran == 2){
                                    $status = "<span class='badge badge-danger'>Pending</span>";
                                }else if($data->StatusPembayaran == 3){
                                    $status = "<span class='badge badge-danger'>Gagal</span>";
                                }else if($data->StatusPembayaran == 4){
                                    $status = "<span class='badge badge-danger'>Kadaluarsa</span>";
                                }else{
                                    $status = "<span class='badge badge-danger'>Belum Lunas</span>";
                                }
                                return $status;
                            })
                            ->editColumn('StatusPesanan', function($data){
                                if($data->StatusPesanan == 0){
                                    $statuspesanan = "<span class='badge badge-danger'>Belum Diproses</span>";
                                }else if($data->StatusPesanan == 1){
                                    $statuspesanan = "<span class='badge badge-warning'>Diproses</span>";
                                }else if($data->StatusPesanan == 2){
                                    $statuspesanan = "<span class='badge badge-primary'>Dikirim</span>";
                                }else if($data->StatusPesanan == 3){
                                    $statuspesanan = "<span class='badge badge-success'>Selesai</span>";
                                }else if($data->StatusPesanan == 4){
                                    $statuspesanan = "<span class='badge badge-danger'>Dibatalkan</span>";
                                }
                                return $statuspesanan;
                            })
                            ->addColumn('Aksi', function($data){
                                $btn = "<button type='button' class='btn btn-success btn-flat' title='Show Data' data-toggle='modal' data-target='#pesanan' onclick='detail(\"".$data->IdTransaksi."\")'><i class='fa fa-info'></i></button>";
                                if ($data->StatusPesanan == 2) {
                                    $btn = $btn." <button type='button' class='btn btn-primary btn-flat' title='Update Pesanan' onclick='pesanan(\"".$data->IdTransaksi."\")'><i class='fa fa-check'></i></button>";
                                }
                                if ($data->StatusPembayaran == 0 || $data->StatusPembayaran == 2) {
                                    $btn = $btn." <button type='button' class='btn btn-danger btn-flat' title='Info Pembayaran' data-toggle='modal' data-target='#pembayaran' onclick='pembayaran(\"".$data->Snap_token."\")'><i class='fa fa-dollar'></i></button>";
                                }
                                return $btn;
                            })
                            ->rawColumns(['Aksi', 'StatusPesanan', 'StatusPembayaran'])
                            ->make(true);
        }

        $pelanggans = Pelanggan::find($id);
        $provinsis = RuangApi::getProvinces();
        $kabupatens = RuangApi::getCities($pelanggans->IdProvinsi, null, null);
        $kecamatans = RuangApi::getDistricts($pelanggans->IdKabupaten, null, null);

        // dd($provinsis);
        // dd($kabupatens);
        return view('my-account', compact('pelanggans','warnas','ukurans','cart_produk','cart_total','provinsis','kabupatens','kecamatans'));
    }

    public function updatetransaksi($id)        
    {
        $transaksi = Transaksi::find($id);

        $transaksi->StatusPesanan = 3;
        $transaksi->save();

        return response()->json(['success'=>'sukses']);
    }
}
