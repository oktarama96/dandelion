<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use DB;

class IndexController extends Controller
{
    public function index() 
    {
        $stokprodukid = DB::table('stokproduk')->where("StokAkhir",">",0);
        $stokprodukid = $stokprodukid->get('IdProduk')->pluck('IdProduk');

        $produks = DB::table('produk')->whereIn("IdProduk", $stokprodukid)->orderBy('created_at', 'desc')->take(4)->get();
        
        return view('index', compact('produks'));
    }
}
