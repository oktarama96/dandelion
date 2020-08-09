<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\StokProduk;
use Carbon\Carbon;
use DataTables;
use DB;

class LaporanController extends Controller
{
    public function transaksiReport(Request $request)
    {
        $now = Carbon::today();
        // $now->format('Y-m-d')  

        if ($request->ajax()) {
            if($request->from_date == NULL){
                $datas = Transaksi::with(['pengguna:IdPengguna,NamaPengguna', 'pelanggan:IdPelanggan,NamaPelanggan', 'kupondiskon:IdKuponDiskon,NamaKupon'])
                ->whereBetween('TglTransaksi', [$now, $now->format('Y-m-d').' 23:59:59'])
                ->where('StatusPembayaran', 1)
                ->orderBy('TglTransaksi', 'DESC')
                ->get();

                $sum_gtotal = Transaksi::where('StatusPembayaran', 1)
                ->whereBetween('TglTransaksi', [$now, $now->format('Y-m-d').' 23:59:59'])
                ->sum('GrandTotal');
                $sum_total = Transaksi::where('StatusPembayaran', 1)
                ->whereBetween('TglTransaksi', [$now, $now->format('Y-m-d').' 23:59:59'])
                ->sum('Total');
                $sum_potongan = Transaksi::where('StatusPembayaran', 1)
                ->whereBetween('TglTransaksi', [$now, $now->format('Y-m-d').' 23:59:59'])
                ->sum('Potongan');
                $sum_ongkir = Transaksi::where('StatusPembayaran', 1)
                ->whereBetween('TglTransaksi', [$now, $now->format('Y-m-d').' 23:59:59'])
                ->sum('OngkosKirim');

                $sum_untung = DB::table('transaksi')
                ->join('detailtransaksi', 'transaksi.IdTransaksi', '=', 'detailtransaksi.IdTransaksi')
                ->join('produk', 'detailtransaksi.IdProduk', '=', 'produk.IdProduk')
                ->select(DB::raw('SUM(detailtransaksi.SubTotal - (produk.HargaPokok * detailtransaksi.Qty)) as untungkotor, SUM(transaksi.Potongan) as sumpotongan'))
                ->where('transaksi.StatusPembayaran', 1)
                ->whereBetween('transaksi.TglTransaksi', [$now, $now->format('Y-m-d').' 23:59:59'])
                ->get();

            }else{
                $datas = Transaksi::with(['pengguna:IdPengguna,NamaPengguna', 'pelanggan:IdPelanggan,NamaPelanggan', 'kupondiskon:IdKuponDiskon,NamaKupon'])
                ->whereBetween('TglTransaksi', [$request->from_date.' 00:00:00', $request->to_date.' 23:59:59'])
                ->where('StatusPembayaran', 1)
                ->orderBy('TglTransaksi', 'DESC')
                ->get();

                $sum_gtotal = Transaksi::where('StatusPembayaran', 1)
                ->whereBetween('TglTransaksi', [$request->from_date.' 00:00:00', $request->to_date.' 23:59:59'])
                ->sum('GrandTotal');
                $sum_total = Transaksi::where('StatusPembayaran', 1)
                ->whereBetween('TglTransaksi', [$request->from_date.' 00:00:00', $request->to_date.' 23:59:59'])
                ->sum('Total');
                $sum_potongan = Transaksi::where('StatusPembayaran', 1)
                ->whereBetween('TglTransaksi', [$request->from_date.' 00:00:00', $request->to_date.' 23:59:59'])
                ->sum('Potongan');
                $sum_ongkir = Transaksi::where('StatusPembayaran', 1)
                ->whereBetween('TglTransaksi', [$request->from_date.' 00:00:00', $request->to_date.' 23:59:59'])
                ->sum('OngkosKirim');

                $sum_untung = DB::table('transaksi')
                ->join('detailtransaksi', 'transaksi.IdTransaksi', '=', 'detailtransaksi.IdTransaksi')
                ->join('produk', 'detailtransaksi.IdProduk', '=', 'produk.IdProduk')
                ->select(DB::raw('SUM(detailtransaksi.SubTotal - (produk.HargaPokok * detailtransaksi.Qty)) as untungkotor, SUM(transaksi.Potongan) as sumpotongan'))
                ->where('transaksi.StatusPembayaran', 1)
                ->whereBetween('TglTransaksi', [$request->from_date.' 00:00:00', $request->to_date.' 23:59:59'])
                ->first();
            }
            
            //dd($datas);
            // dd($sum_untung);
            return Datatables::of($datas)
                    ->with(['sum_gtotal' => $sum_gtotal, 'sum_total' => $sum_total, 'sum_potongan' => $sum_potongan, 'sum_ongkir' => $sum_ongkir, 'sum_untung' => $sum_untung])
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
                    ->editColumn('Total', function($data){
                        return "Rp. ".number_format($data->Total,0,',',',')."";
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
                        }
                        return $statuspesanan;
                    })
                    ->rawColumns(['StatusPesanan', 'StatusPembayaran'])
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
