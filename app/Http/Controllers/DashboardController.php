<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaksi;
use App\DetailTransaksi;
use Carbon\Carbon;
use DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::today();

        // offline transaksi
        $totaltransaksioffs = Transaksi::select(
                    DB::raw('sum(GrandTotal) as total'), 
                    DB::raw("DATE_FORMAT(TglTransaksi,'%m') as monthKey")
                )
                ->whereYear('TglTransaksi', date('Y'))
                ->where('MetodePembayaran', 'Cash')
                ->groupBy('monthKey')
                ->orderBy('TglTransaksi', 'ASC')
                ->get();

        $datatransaksioff = [0,0,0,0,0,0,0,0,0,0,0,0];

        foreach($totaltransaksioffs as $transaksioff){
            $datatransaksioff[$transaksioff->monthKey-1] = $transaksioff->total;
        }

        // online transaksi
        $totaltransaksions = Transaksi::select(
                    DB::raw('sum(GrandTotal) as total'), 
                    DB::raw("DATE_FORMAT(TglTransaksi,'%m') as monthKey")
                )
                ->whereYear('TglTransaksi', date('Y'))
                ->where('MetodePembayaran', '!=' ,'Cash')
                ->groupBy('monthKey')
                ->orderBy('TglTransaksi', 'ASC')
                ->get();

        $datatransaksion = [0,0,0,0,0,0,0,0,0,0,0,0];

        foreach($totaltransaksions as $transaksion){
            $datatransaksion[$transaksion->monthKey-1] = $transaksion->total;
        }

        $pendapatanSum = Transaksi::select(DB::raw('COALESCE(SUM(GrandTotal),0) as pendapatanSum'))
                        ->whereBetween('TglTransaksi', [$now, $now->format('Y-m-d').' 23:59:59'])
                        ->get();

        $qtySum = DetailTransaksi::select(DB::raw('COALESCE(SUM(Qty),0) as qtySum'))
                ->whereBetween('created_at', [$now, $now->format('Y-m-d').' 23:59:59'])
                ->get();
        
        $transaksiCount = Transaksi::select(DB::raw('COALESCE(COUNT(IdTransaksi),0) as transaksiCount'))
                        ->whereBetween('TglTransaksi', [$now, $now->format('Y-m-d').' 23:59:59'])
                        ->get();

        $pesananbelumselesai = Transaksi::select(DB::raw('COALESCE(COUNT(StatusPesanan),0) as pesananbelumselesai'))
                        ->whereIn('StatusPesanan', [0,1,2])
                        ->where([
                            ['MetodePembayaran', '=', 'MidTrans'],
                            ['StatusPembayaran', '=', 1],
                        ])
                        ->get();

        if ($request->ajax()) {
            $listpesanan = Transaksi::join('pelanggan','transaksi.IdPelanggan','=','pelanggan.IdPelanggan')
                            ->select('IdTransaksi','pelanggan.NamaPelanggan','StatusPesanan')
                            ->whereIn('StatusPesanan', [0,1,2])
                            ->where([
                                ['MetodePembayaran', '=', 'MidTrans'],
                                ['StatusPembayaran', '=', 1],
                            ])
                            ->orderBy('TglTransaksi', 'desc')
                            ->get();

            return Datatables::of($listpesanan)
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
            ->addColumn('Aksi', function($data){
                $btn = "<button type='button' class='btn btn-primary btn-flat' title='Update Pesanan' data-toggle='modal' data-target='#pesanan' onclick='detail(".$data->IdTransaksi.")'><i class='fa fa-edit'></i></button>";

                return $btn;
            })
            ->rawColumns(['Aksi', 'StatusPesanan'])
            ->make(true);
        }

        $kategoriTerlaris = DB::select(
            DB::raw("
                SELECT p.IdKategoriProduk, kp.NamaKategori, COUNT(p.IdKategoriProduk) AS jumlah_dipesan
                FROM transaksi t INNER JOIN detailtransaksi dt USING(IdTransaksi) 
                INNER JOIN produk p USING(IdProduk) 
                INNER JOIN kategoriproduk kp USING(IdKategoriProduk) 
                WHERE YEAR(TglTransaksi) = date('Y') AND StatusPembayaran = 1
                GROUP BY p.IdKategoriProduk ORDER BY jumlah_dipesan DESC LIMIT 5
            ")
        );

        $label = [];
        $count = [];
        $total = 0;
        
        //dd($kategoriTerlaris);

        foreach($kategoriTerlaris as $kategori){
            $total += $kategori->jumlah_dipesan;
        }
        foreach($kategoriTerlaris as $kategori){
            $label[] = $kategori->NamaKategori;
            $count[] = $kategori->jumlah_dipesan;
        }
        $kategoriChartLabel= "['" . join("','", $label) . "']";
        $kategoriChartCount = "['" . join("','", $count) . "']";
        // dd($listpesanan);
        // return $pesananbelumdiproses;
        return view("pos.pages.index")
                ->with('totaltransaksioff', json_encode($datatransaksioff,JSON_NUMERIC_CHECK))
                ->with('totaltransaksion', json_encode($datatransaksion,JSON_NUMERIC_CHECK))
                ->with('pendapatanSum', $pendapatanSum)
                ->with('qtySum', $qtySum)
                ->with('transaksiCount', $transaksiCount)
                ->with('pesananbelumselesai', $pesananbelumselesai)
                ->with('kategoriChartLabel', $kategoriChartLabel)
                ->with('kategoriChartCount', $kategoriChartCount)
                ->with('kategoriTerlaris', $kategoriTerlaris);
    }

    public function showdetailtrans($id)    
    {
        $transaksi = Transaksi::with('pelanggan')->where('IdTransaksi', $id)->get();
        $detailtransaksi = DetailTransaksi::with(['produk','stokproduk','stokproduk.warna','stokproduk.ukuran'])->where('IdTransaksi', $id)->get();
        
        return response()->json(['transaksi' => $transaksi, 'detailtransaksi' => $detailtransaksi]);
    }
}
