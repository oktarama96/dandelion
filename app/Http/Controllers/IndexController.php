<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;

class IndexController extends Controller
{
    public function index() 
    {
        $produks = Produk::orderBy('created_at', 'desc')
                    ->take(4)
                    ->get();


        return view('index', compact('produks'));
    }
}
