<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaksi;
use App\DetailTransaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
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

        $pesananbelumdiproses = Transaksi::select(DB::raw('COALESCE(COUNT(StatusPesanan),0) as pesananbelumdiproses'))
                        ->where('StatusPesanan', 0)
                        ->get();

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

        // return $pesananbelumdiproses;
        return view("pos.pages.index")
                ->with('totaltransaksioff', json_encode($datatransaksioff,JSON_NUMERIC_CHECK))
                ->with('totaltransaksion', json_encode($datatransaksion,JSON_NUMERIC_CHECK))
                ->with('pendapatanSum', $pendapatanSum)
                ->with('qtySum', $qtySum)
                ->with('transaksiCount', $transaksiCount)
                ->with('pesananbelumdiproses', $pesananbelumdiproses)
                ->with('kategoriChartLabel', $kategoriChartLabel)
                ->with('kategoriChartCount', $kategoriChartCount)
                ->with('kategoriTerlaris', $kategoriTerlaris);
    }
}
