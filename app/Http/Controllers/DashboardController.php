<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $thn = $now->year;
        //$total = "";

        for ($i=1;$i<13;$i++) {
            $totaltransaksi = DB::select("SELECT SUM(Grandtotal) AS total1 FROM transaksi WHERE MONTH(TglTransaksi) = ? AND YEAR(TglTransaksi) = ? GROUP BY MONTH(TglTransaksi)", [$i, $thn]);
        }
        //dd($totaltransaksi);
        return view("pos.pages.index");
    }
}
