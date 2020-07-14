<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Produk;
use App\Transaksi;
use App\KategoriProduk;
use App\Warna;
use App\Ukuran;
use App\DetailTransaksi;
use App\StokProduk;
use Carbon\Carbon;
use DataTables;

class TransaksiController extends Controller
{
    public function pointofsale()
    {
        return view('pos.pages.pointofsale');
    }

    public function acproduk(Request $request)
    {
        $produk = $request->get('query');
        //dd($produk);

        $produks = DB::table('produk')
                ->select('IdProduk', 'NamaProduk')
                ->where('IdProduk', 'like', '%' . $produk . '%')
                ->orWhere('NamaProduk', 'like', '%' . $produk . '%')
                ->get(); 
    
        foreach($produks as $data){
            $returned[] = ['value' => $data->IdProduk." - ".$data->NamaProduk, 'id' => $data->IdProduk];
        }

        if(count($produks) > 0){
            return response()->json(array('suggestions' => $returned));
        }else{
            return response()->json(['suggestions' => '']);
        }        
    }

    public function addproduk($id)
    {
        $produk = Produk::select('IdProduk','NamaProduk','HargaJual')->where('IdProduk', $id)->get();
        $stokproduk = StokProduk::with(['warna','ukuran'])->where('IdProduk', $id)->get();
        return response()->json(['produk' => $produk , 'stokproduk' => $stokproduk]);
    }

    public function addukuran($id)
    {
        $stokproduk = StokProduk::with('ukuran')->where('IdWarna', $id)->get();
        return response()->json(['stokproduk' => $stokproduk]);
    }

    public function simpantransaksi(Request $request)
    {
        $this->validate($request, [
            'IdPengguna' => 'required',
            'Total' => 'required',
            'Potongan' => 'required',
            'Bayar' => 'required',
        ]);

        //dd($request->IdProduk[0]);

        if($request->Total == 0){
            return redirect()->back()->with("alert" , "Error : Form Transaksi Masih Kosong!");
        }else{
            if($request->Bayar == 0){
                return redirect()->back()->with("alert", "Error : Jumlah Pembayaran Tidak Sesuai!"); 
            }else{
                DB::beginTransaction();
                try {
                    $Tgl = Carbon::now();
                    $IdTransaksi = $Tgl->format("YmdHis");
                    $TglTransaksi = $Tgl->format("Y-m-d H:i:s");

                    $transaksi = new Transaksi;

                    $transaksi->IdTransaksi = $IdTransaksi;
                    $transaksi->TglTransaksi = $TglTransaksi;
                    $transaksi->Total = $request->Total;
                    $transaksi->Potongan = $request->Potongan;
                    $transaksi->OngkosKirim = 0;
                    $transaksi->NamaEkspedisi = "-";
                    $transaksi->GrandTotal = $request->GrandTotal;
                    $transaksi->MetodePembayaran = "Cash";
                    $transaksi->StatusPembayaran = 1;
                    $transaksi->StatusPesanan = 3; //0=diproses, 1=dikirim, 2=diterima, 3=selesai
                    $transaksi->Snap_token = "-";
                    $transaksi->IdKuponDiskon = "-";
                    $transaksi->IdPengguna = $request->IdPengguna;
                    $transaksi->IdPelanggan = 1;
                    
                    $transaksi->save();

                    if($request->IdProduk[0] != NULL){
                        for($i=0;$i<count($request->IdProduk);$i++){
                            $stokproduk = StokProduk::where([
                                ['IdProduk', '=', $request->IdProduk[$i]],
                                ['IdWarna', '=', $request->Warna[$i]],
                                ['IdUkuran', '=', $request->Ukuran[$i]],
                            ])->first();
                        
                            //dd($stokproduk->StokKeluar);
                            $stokkeluar = $stokproduk->StokKeluar + $request->Qty[$i];
                            
                            $stokproduk->StokKeluar = $stokkeluar;
                            $stokproduk->StokAkhir = $stokproduk->StokMasuk - $stokkeluar;

                            $stokproduk->save();

                            $detailtransaksi = new DetailTransaksi;
                        
                            $detailtransaksi->Qty = $request->Qty[$i];
                            $detailtransaksi->Diskon = $request->Diskon[$i];
                            $detailtransaksi->SubTotal = $request->SubTotal[$i];
                            $detailtransaksi->IdProduk = $request->IdProduk[$i];
                            $detailtransaksi->IdStokProduk = $stokproduk->IdStokProduk;
                            $detailtransaksi->IdTransaksi = $IdTransaksi;

                            $detailtransaksi->save();
                        }
                    }else{
                        return redirect()->back()->with("alert" , "Error : Tidak Ada Barang!");
                    }
                    
                    
                    DB::commit();

                    return redirect()->back()->with("alert", "Data Berhasil Disimpan!");
                }catch(Exception $e){
                    DB::rollback();
                    return redirect()->back()->with("alert", "Error : $e");
                }
            }
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(!empty($request->from_date)){
                $datas = Transaksi::with(['pengguna:IdPengguna,NamaPengguna', 'pelanggan:IdPelanggan,NamaPelanggan', 'kupondiskon:IdKuponDiskon,NamaKupon'])
                ->whereBetween('TglTransaksi', array($request->from_date, $request->to_date))
                ->get();
            }else{
                $datas = Transaksi::with(['pengguna:IdPengguna,NamaPengguna', 'pelanggan:IdPelanggan,NamaPelanggan', 'kupondiskon:IdKuponDiskon,NamaKupon'])
                ->get();
            }

            return Datatables::of($datas)
                    ->editColumn('StatusPembayaran', function($data){
                        if($data->StatusPembayaran == 1){
                            $status = "Lunas";
                        }else{
                            $status = "Belum Lunas";
                        }
                        return $status;
                    })
                    ->editColumn('StatusPesanan', function($data){
                        if($data->StatusPesanan == 0){
                            $statuspesanan = "DiProses";
                        }else if($data->StatusPesanan == 1){
                            $statuspesanan = "DiKirim";
                        }else if($data->StatusPesanan == 2){
                            $statuspesanan = "Diterima";
                        }else if($data->StatusPesanan == 3){
                            $statuspesanan = "Selesai";
                        }
                        return $statuspesanan;
                    })
                    ->addColumn('Aksi', function($data){
                        $btn = "<button type='button' class='btn btn-success btn-flat' title='Show Data' data-toggle='modal' data-target='#detail' onclick='detail(\"".$data->IdTransaksi."\")'><i class='fa fa-info'></i></button>";
                        if (auth()->guard('pengguna')->user()->Is_admin == 1) {
                            $btn = $btn." <button type='button' class='btn btn-danger btn-flat' title='Delete Data' onclick='deletee(\"".$data->IdTransaksi."\")'><i class='fa fa-trash'></i></button>";
                        }
                        return $btn;
                    })
                    ->rawColumns(['Aksi'])
                    ->make(true);
        }

        return view('pos.pages.transaksi');
    }

    public function showdetailtrans($id)    
    {
        $detailtransaksi = DetailTransaksi::with(['produk','stokproduk','stokproduk.warna','stokproduk.ukuran'])->where('IdTransaksi', $id)->get();
        return response()->json(['detailtransaksi' => $detailtransaksi]);
    }

    public function hapustransaksi($id)
    {
        DB::beginTransaction();
        try {
            $transaksi = Transaksi::find($id);
            $details = DetailTransaksi::where('IdTransaksi', $transaksi->IdTransaksi)->get();
            

            foreach ($details as $detail) {
                $stokproduk = StokProduk::find($detail->IdStokProduk);

                $stokkeluar = $stokproduk->StokKeluar - $detail->Qty;
                $stokmasuk = $stokproduk->StokMasuk + $detail->Qty;
                $stokproduk->StokMasuk = $stokmasuk;
                $stokproduk->StokKeluar = $stokkeluar;
                $stokproduk->StokAkhir = $stokproduk->StokMasuk - $stokkeluar;

                $stokproduk->save();
            }

            DetailTransaksi::where('IdTransaksi', $transaksi->IdTransaksi)->delete();
            Transaksi::find($id)->delete();
        
            DB::commit();

            return response()->json(['success'=>'sukses']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['error'=> $e ]);
        }
    }

}
