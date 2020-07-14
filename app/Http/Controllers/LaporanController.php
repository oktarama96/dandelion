<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\StokProduk;
use DataTables;

class LaporanController extends Controller
{
    public function transaksiReport(Request $request)
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
                    ->make(true);
        }

        return view('pos.pages.report.transaksi');
    }

    public function stokprodukReport(Request $request)
    {
        if ($request->ajax()) {
            $datas = StokProduk::with(['produk','warna','ukuran'])->get();

            return Datatables::of($datas)
                    ->make(true);
        }

        return view('pos.pages.report.stokproduk');
    }

    public function stokhabisReport(Request $request)       
    {
        if ($request->ajax()) {
            $datas = StokProduk::with(['produk','warna','ukuran'])
                    ->where('StokAkhir','<=',0)
                    ->get();

            return Datatables::of($datas)
                    ->make(true);
        }

        return view('pos.pages.report.stokhabis');
    }

    public function stoklarisReport(Request $request)       
    {
        if ($request->ajax()) {
            $datas = StokProduk::with(['produk','warna','ukuran'])
                    ->orderBy('StokKeluar', 'desc')
                    ->get();

            return Datatables::of($datas)
                    ->make(true);
        }

        return view('pos.pages.report.stoklaris');
    }
}
