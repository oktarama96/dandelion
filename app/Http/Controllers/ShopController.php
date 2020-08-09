<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Ukuran;
use App\Warna;
use App\KategoriProduk;
use App\StokProduk;
use App\Cart;
use DB;
use Auth;

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
        
        $stokprodukid = DB::table('stokproduk')->where("StokAkhir",">",0);
        if (!empty($filter['warna'])) 
        $stokprodukid = $stokprodukid->whereIn("IdWarna", $filter['warna'], 'and');
        if (!empty($filter['ukuran'])) 
        $stokprodukid = $stokprodukid->whereIn("IdUkuran", $filter['ukuran']);
        $stokprodukid = $stokprodukid->get('IdProduk')->pluck('IdProduk');

        $produks = DB::table('produk')->where("NamaProduk", "LIKE", '%'.$filter['search'].'%');
        if (!empty($filter['kategori'])) 
        $produks = $produks->whereIn("IdKategoriProduk", $filter['kategori'], 'and');
        $produks = $produks->whereIn("IdProduk", $stokprodukid)->orderBy('created_at', 'desc')->paginate(9);
        // print_r($produks);
        // return $produks;

        $ukurans = Ukuran::all();
        $warnas = Warna::all();
        $kategoris = KategoriProduk::all();
        $cart_produk = "[]";
        $cart_total = 0;

        if(Auth::guard('web')->check()){
            $cart_produk = [];
            $cart_produk = $this->getCart();

            foreach($cart_produk as $produk){
                $cart_total+=$produk->sub_total;
            }
        }

        return view('shop', compact('produks','ukurans','warnas','kategoris','filter','cart_produk', 'cart_total'));
    }

    public function addukuran($IdProduk, $IdWarna)
    {
        $stokproduk = StokProduk::with('ukuran')->where([
            ['IdProduk', $IdProduk],
            ['IdWarna', $IdWarna],
        ])->get();
        return response()->json(['stokproduk' => $stokproduk]);
    }

    public function productdetail($id)
    {
        $warnas = '';
        $ukurans = '';
        $produks = Produk::where('IdProduk', $id)->first();
        if($produks){
            $warnas = $produks->warnas()->groupBy('IdWarna')->where('StokAkhir','>',0)->get();
            $ukurans = $this->getUkuran($produks->IdProduk, $warnas[0]->IdWarna);
        }

        // $relatedproduks = Produk::where('IdKategoriProduk', $produks->IdKategoriProduk)
        //                 ->where('')
        //                 ->orderBy('created_at', 'desc')
        //                 ->take(4)
        //                 ->get();

        $stokprodukid = DB::table('stokproduk')->where("StokAkhir",">",0);
        $stokprodukid = $stokprodukid->get('IdProduk')->pluck('IdProduk');
        $relatedproduks = DB::table('produk')->where('IdKategoriProduk', $produks->IdKategoriProduk);
        $relatedproduks = $relatedproduks->whereIn("IdProduk", $stokprodukid)->orderBy('created_at', 'desc')->take(4)->get();

        $cart_produk = "[]";
        $cart_total = 0;

        if(Auth::guard('web')->check()){
            $cart_produk = [];
            $cart_produk = $this->getCart();

            foreach($cart_produk as $produk){
                $cart_total+=$produk->sub_total;
            }
        }
        // dd($relatedproduks);
        
        return view('product-detail', compact('produks','warnas','ukurans','relatedproduks','cart_produk','cart_total'));
    }

    public function getUkuran($IdProduk, $IdWarna){
        $ukuran = StokProduk::join('ukuran', 'ukuran.IdUkuran', '=', 'stokproduk.IdUkuran')
        ->where([
            ['IdProduk',$IdProduk],
            ['IdWarna',$IdWarna],
            ['StokAkhir', '>', 0],
        ])->groupBy('IdUkuran')->select('stokproduk.IdWarna','stokproduk.IdProduk','ukuran.*','stokproduk.StokAkhir')->get();
        return $ukuran;
    }

    public function getCart()
    {
        $id_pelanggan = Auth::guard('web')->user()->IdPelanggan;
        $cart = Cart::join('stokproduk', 'cart.IdStokProduk', '=', 'stokproduk.IdStokProduk')
                ->join('produk', 'stokproduk.IdProduk', '=', 'produk.IdProduk')
                ->join('warna', 'stokproduk.IdWarna', '=', 'warna.IdWarna')
                ->join('ukuran', 'stokproduk.IdUkuran', '=', 'ukuran.IdUkuran')
                ->select('cart.IdStokProduk', 'warna.NamaWarna','ukuran.NamaUkuran','cart.IdCart', 'produk.*', 'cart.Qty', DB::raw('produk.HargaJual * cart.Qty as sub_total, stokproduk.StokAkhir-cart.Qty as selisih_stok'))
                ->where('IdPelanggan', $id_pelanggan)
                ->where('stokproduk.StokAkhir','>', 0)
                ->get();
        return $cart;
    }

    public function deleteCartItem($id_cart){
        Cart::destroy($id_cart);
    }

    public function addCartItem(Request $request){
        if(Auth::guard('web')->check()){
            $id_pelanggan = Auth::guard('web')->user()->IdPelanggan;

            $IdStokProduk = StokProduk::where([
                ['IdProduk', '=', $request->IdProduk],
                ['IdWarna', '=', $request->IdWarna],
                ['IdUkuran', '=', $request->IdUkuran],
            ])->pluck('IdStokProduk')->first();

            $cart_item = Cart::where([
                ['IdPelanggan', $id_pelanggan],
                ['IdStokProduk', $IdStokProduk]
            ])->first();

            if(!$cart_item){
                $cart_item = new Cart;
                $cart_item->IdPelanggan = Auth::guard('web')->user()->IdPelanggan;
                $cart_item->IdStokProduk = $IdStokProduk;
                $cart_item->Qty = $request->Qty;
                $cart_item->save();
            } else {
                $cart_item->Qty += $request->Qty;
                $cart_item->save();
            }
            
            $item = Cart::join('stokproduk', 'cart.IdStokProduk', '=', 'stokproduk.IdStokProduk')
                    ->join('produk', 'stokproduk.IdProduk', '=', 'produk.IdProduk')
                    ->join('warna', 'stokproduk.IdWarna', '=', 'warna.IdWarna')
                    ->join('ukuran', 'stokproduk.IdUkuran', '=', 'ukuran.IdUkuran')
                    ->select('warna.NamaWarna','ukuran.NamaUkuran','cart.IdCart', 'produk.*', 'cart.Qty', DB::raw('produk.HargaJual * cart.Qty as sub_total, stokproduk.StokAkhir-cart.Qty as selisih_stok'))
                    ->where([
                        ['IdPelanggan', $id_pelanggan],
                        ['stokproduk.IdStokProduk', $cart_item->IdStokProduk]
                    ])->first();

            return $item;
        }else{
            return redirect()->route('login');
        } 
    }

    public function showcart()
    {
        $cart_total = 0;
        $id_pelanggan = Auth::guard('web')->user()->IdPelanggan;
        $carts = Cart::join('stokproduk', 'cart.IdStokProduk', '=', 'stokproduk.IdStokProduk')
                ->join('produk', 'stokproduk.IdProduk', '=', 'produk.IdProduk')
                ->join('warna', 'stokproduk.IdWarna', '=', 'warna.IdWarna')
                ->join('ukuran', 'stokproduk.IdUkuran', '=', 'ukuran.IdUkuran')
                ->select('cart.IdStokProduk', 'warna.NamaWarna','ukuran.NamaUkuran','cart.IdCart', 'produk.*', 'cart.Qty', DB::raw('produk.HargaJual * cart.Qty as sub_total, stokproduk.StokAkhir-cart.Qty as selisih_stok'))
                ->where('IdPelanggan', $id_pelanggan)
                ->where('stokproduk.StokAkhir','>', 0)
                ->get();

        foreach($carts as $cart){
            $cart_total+=$cart->sub_total;
        }
        return view('cart', compact('carts', 'cart_total'));
    }

    public function showcheckout()
    {
        $cart_produk = $this->getCart();
        $cart_total = 0;
        $cart_weight = 0;
        foreach($cart_produk as $produk){
            $cart_total+=$produk->sub_total;
            $cart_weight+=$produk->Berat;
        }

        $curl = curl_init();

        $biaya_kirim = $this->getBiayaKirim($cart_weight);
        $biaya_kirim = json_decode($biaya_kirim);
        $cost_jne = $biaya_kirim->rajaongkir->results[0]->costs;
        return view('checkout', compact('cart_produk', 'cart_weight', 'cart_total', 'cart_weight', 'cost_jne'));
    }

    function getBiayaKirim($weight){
        
        $destination = Auth::guard('web')->user()->IdKabupaten;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=17&destination=".$destination."&weight=".$weight."&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 72abbf05000784250caf10ff1742fa2d"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) 
            return $err;
        else 
            return $response;
    }
}
