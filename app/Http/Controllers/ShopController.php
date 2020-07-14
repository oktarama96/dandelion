<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Ukuran;
use App\Warna;
use App\KategoriProduk;

class ShopController extends Controller
{
    public function index()
    {
        $produks = Produk::orderBy('created_at', 'desc')
                    ->take(4)
                    ->get();

        $ukurans = Ukuran::all();
        $warnas = Warna::all();
        $kategoris = KategoriProduk::all();

        return view('shop', compact('produks','ukurans','warnas','kategoris'));
    }
}
