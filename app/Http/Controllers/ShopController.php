<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Ukuran;
use App\Warna;
use App\KategoriProduk;
use App\StokProduk;
use DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // $produks = Produk::orderBy('created_at', 'desc')
        //             ->take(4)
        //             ->get();
        if(!$request->session()->has('filter')){
            $filter = [
                'search' => '',
                'warna' => [],
                'ukuran' => [],
                'kategori' => [],
            ];
            $request->session()->put('filter', $filter);
        }

        if($request->isMethod('post')){
            $input = $request->all();
            $filter = [
                'search' => $input['search'],
                'warna' => (isset($input['warna'])) ? $input['warna']:[],
                'ukuran' => (isset($input['ukuran'])) ? $input['ukuran']:[],
                'kategori' => (isset($input['kategori'])) ? $input['kategori']:[],
            ];
            $request->session()->put('filter', $filter);
        }

        $filter = $request->session()->get('filter');

        // $query = "SELECT produk.* FROM produk
        //         WHERE IdProduk IN (
        //             SELECT IdProduk FROM stokproduk ";
        // if (!empty($filter['warna'])) 
        //     $query .= "WHERE IdWarna IN (".join(',',$filter['warna']).") ";
        // if (!empty($filter['ukuran'])) 
        //     $query .= "AND IdUkuran IN (".join(',',$filter['ukuran']).") ";
        // $query .= ") ";
        // if (!empty($filter['kategori'])) 
        //     $query .= " AND IdKategoriProduk IN (".join(',',$filter['kategori']).")  ";
        // if (!empty($filter['search'])) 
        //     $query .= " AND NamaProduk LIKE '%".$filter['search']."%' ";
        // $query .= " ORDER BY created_at DESC";
        // echo $query;   
        // $produks = DB::select(DB::raw($query)->paginate(6));   
        
        $stokprodukid = DB::table('stokproduk');
        if (!empty($filter['warna'])) 
        $stokprodukid = $stokprodukid->whereIn("IdWarna", $filter['warna'], 'and');
        if (!empty($filter['ukuran'])) 
        $stokprodukid = $stokprodukid->whereIn("IdUkuran", $filter['ukuran']);
        $stokprodukid = $stokprodukid->get('IdProduk')->pluck('IdProduk');

        $produks = DB::table('produk');
        if (!empty($filter['kategori'])) 
        $produks = $produks->whereIn("IdKategoriProduk", $filter['kategori'], 'and');
        $produks = $produks->whereIn("IdProduk", $stokprodukid)->orderBy('created_at', 'desc')->paginate(9);
        // print_r($produks);
        // return $produks;

        $ukurans = Ukuran::all();
        $warnas = Warna::all();
        $kategoris = KategoriProduk::all();

        return view('shop', compact('produks','ukurans','warnas','kategoris','filter'));
    }

    public function filterProduk(Request $request){
        
		$request->session()->forget('filter');
		if(!$request->session()->has('filter')){
            $filter = [
                'search' => '',
                'warna' => [],
                'ukuran' => [],
                'kategori' => [],
            ];
            $request->session()->put('filter', $filter);
        }

        $filter = $request->session()->get('filter');
        print_r($filter['warna']);
        //$data = $request->all();

        $produks = StokProduk::join('produk', 'produk.IdProduk', '=', 'stokproduk.IdProduk');

        if (!empty($filter['kategori'])) {
            $produks = $produks->whereIn('IdKategoriProduk', $filter['kategori'], "and");
        }
        
        if (!empty($filter['ukuran'])) {
            $produks = $produks->whereIn('IdUkuran', $filter['ukuran'], "and");
        }

        if (!empty($filter['warna'])) {
            $produks = $produks->whereIn('IdWarna', $filter['warna']);
        }

        $produks = $produks->get('produk.*');
        return $produks;
        return $data;
    }

    public function productdetail($id)
    {
        $produks = Produk::find($id);
        
        return view('product-detail', compact('$produks'));
    }

    public function showcart()
    {
        return view('cart');
    }

    public function showcheckout()
    {
        return view('checkout');
    }
}
