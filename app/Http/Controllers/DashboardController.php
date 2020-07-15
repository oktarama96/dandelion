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
        $totaltransaksis = Transaksi::select(
                    DB::raw('sum(GrandTotal) as total'), 
                    DB::raw("DATE_FORMAT(TglTransaksi,'%m') as monthKey")
                )
                ->whereYear('TglTransaksi', date('Y'))
                ->groupBy('monthKey')
                ->orderBy('TglTransaksi', 'ASC')
                ->get();

        $datatransaksi = [0,0,0,0,0,0,0,0,0,0,0,0];

        foreach($totaltransaksis as $transaksi){
            $datatransaksi[$transaksi->monthKey-1] = $transaksi->total;
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

        // return $pesananbelumdiproses;
        return view("pos.pages.index")
                ->with('totaltransaksi', json_encode($datatransaksi,JSON_NUMERIC_CHECK))
                ->with('pendapatanSum', $pendapatanSum)
                ->with('qtySum', $qtySum)
                ->with('transaksiCount', $transaksiCount)
                ->with('pesananbelumdiproses', $pesananbelumdiproses);
    }
}
