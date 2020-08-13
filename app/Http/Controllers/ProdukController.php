<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StokProduk;
use App\Produk;
use App\KategoriProduk;
use App\Warna;
use App\Ukuran;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use DB;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            //User::with(['product:id,user_id,name,slug,price', 'product.comments:id,product_id,comment,created_at'])
            $datas = Produk::with('kategori')
                    ->orderBy('created_at', 'DESC')
                    ->get();
           // $stok = StokProduk::where('IdProduk', $datas->IdProduk)->sum('StokMasuk')->sum('StokKeluar')->sum('StokAkhir');
            

            return Datatables::of($datas)
                    ->editColumn('HargaPokok', function($data){
                        return "Rp. ".number_format($data->HargaPokok,0,',','.')."";
                    })
                    ->editColumn('HargaJual', function($data){
                        return "Rp. ".number_format($data->HargaJual,0,',','.')."";
                    })
                    ->editColumn('Berat', function($data){
                        return "".$data->Berat." Gram";
                    })
                    ->addColumn('Aksi', function($data){
                        $btn = "<button type='button' class='btn btn-success btn-flat' title='Show Data' data-toggle='modal' data-target='#detail' onclick='detail(\"".$data->IdProduk."\")'><i class='fa fa-info'></i></button>";
                        $btn = $btn." <button type='button' class='btn btn-warning btn-flat' title='Edit Data' data-toggle='modal' data-target='#edit' onclick='edit(\"".$data->IdProduk."\")'><i class='fa fa-edit'></i></button>";
                        $btn = $btn." <button type='button' class='btn btn-primary btn-flat' title='Tambah/Kurang Stok' data-toggle='modal' data-target='#stok' onclick='stok(\"".$data->IdProduk."\")'><i class='fa fa-plus'></i> <i class='fa fa-minus'></i></button>";
                        $btn = $btn." <button type='button' class='btn btn-danger btn-flat' title='Delete Data' onclick='deletee(\"".$data->IdProduk."\")'><i class='fa fa-trash'></i></button>";

                        return $btn;
                    })
                    ->rawColumns(['Aksi'])
                    ->make(true);
        }

        
        $kategoris = KategoriProduk::all();
        $warnas = Warna::all();
        $ukurans = Ukuran::all();
        

        return view('pos.pages.produk', compact('kategoris','warnas','ukurans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'IdProduk' => 'required',
            'NamaProduk' => 'required',
            'KategoriProduk' => 'required',
            'HargaPokok' => 'required',
            'HargaJual' => 'required',
            'Berat' => 'required',
            'Ukuran' => 'required',
            'Warna' => 'required',
            'Deskripsi' => 'required',
            'StokMasuk' => 'required',
            'GambarProduk' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable|max:5000',
        ]);

        DB::beginTransaction();
        try {
            $produk = new Produk;

            if($request->hasFile('GambarProduk')) {
                $image       = $request->file('GambarProduk');
                $filename    = $image->getClientOriginalName();
                
                $images = Image::make($image);

                // resize
                $images->fit(1000,1000);
                $images->save(public_path('img/produk/' .$filename));
            }else{
                $filename = "no-image.png";
            }
            
            $produk->IdProduk = $request->IdProduk;
            $produk->NamaProduk = $request->NamaProduk;
            $produk->GambarProduk = $filename;
            $produk->HargaPokok = $request->HargaPokok;
            $produk->HargaJual = $request->HargaJual;
            $produk->Berat = $request->Berat;
            $produk->Deskripsi = $request->Deskripsi;
            $produk->IdKategoriProduk = $request->KategoriProduk;

            $produk->save();

            for($i=0;$i<count($request->StokMasuk);$i++){
                $stokproduk = new StokProduk;

                $stokproduk->IdUkuran = $request->Ukuran[$i];
                $stokproduk->IdWarna = $request->Warna[$i];
                $stokproduk->StokMasuk = $request->StokMasuk[$i];
                $stokproduk->StokKeluar = 0;
                $stokproduk->StokAkhir = ($request->StokMasuk[$i] - $stokproduk->StokKeluar);
                $stokproduk->IdProduk = $request->IdProduk;

                $stokproduk->save();
            }
            
            
            DB::commit();

            return response()->json(['success'=>'sukses']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['error'=> $e ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::select('GambarProduk','Deskripsi')->where('IdProduk', $id)->get();
        $stokproduk = StokProduk::with(['warna','ukuran'])->where('IdProduk', $id)->get();
        return response()->json(['produk' => $produk, 'stokproduk' => $stokproduk]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk = Produk::where('IdProduk', $id)->first();
        $stokproduk = StokProduk::with(['warna','ukuran'])->where('IdProduk', $id)->get();
        return response()->json(['produk' => $produk, 'stokproduk' => $stokproduk]);
    }

    
    public function getDetail($id)
    {
        $warna = '';
        $ukuran = '';
        $produk = Produk::with('kategori')->where('IdProduk', $id)->first();
        if($produk){
            $warna = $produk->warnas()->groupBy('IdWarna')->where('StokAkhir','>',0)->get();
            if($warna->isNotEmpty()){
                $ukuran = $this->getUkuran($produk->IdProduk, $warna[0]->IdWarna);
            }else{
                $produk = null;
            }
        }
        // return $warna;
        return response()->json(['produk' => $produk, 'warna' => $warna, 'ukuran' => $ukuran]);
    }

    public function getUkuran($IdProduk, $IdWarna){
        $ukuran = StokProduk::join('ukuran', 'ukuran.IdUkuran', '=', 'stokproduk.IdUkuran')
        ->where([
            ['IdProduk',$IdProduk],
            ['IdWarna',$IdWarna],
            ['StokAkhir','>',0]
        ])->groupBy('IdUkuran')->select('stokproduk.IdWarna','stokproduk.StokAkhir','stokproduk.IdProduk','ukuran.*')->get();
        return $ukuran;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'IdProduk' => 'required',
            'NamaProduk' => 'required',
            'KategoriProduk' => 'required',
            'HargaPokok' => 'required',
            'HargaJual' => 'required',
            'Berat' => 'required',
            'Ukuran' => 'required',
            'Warna' => 'required',
            'Deskripsi' => 'required',
            'StokMasuk' => 'required',
            'GambarProduk' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable|max:5000',
        ]);

        DB::beginTransaction();
        try {
            $produk = Produk::find($id);
                
            if($request->hasFile('GambarProduk')) {
                $image       = $request->file('GambarProduk');
                $filename    = $image->getClientOriginalName();
                
                $images = Image::make($image);

                // resize
                $images->fit(1000,1000);
                $images->save(public_path('img/produk/' .$filename));
            }else{
                $filename = $produk->GambarProduk;
            }
            
            $produk->IdProduk = $request->IdProduk;
            $produk->NamaProduk = $request->NamaProduk;
            $produk->GambarProduk = $filename;
            $produk->HargaPokok = $request->HargaPokok;
            $produk->HargaJual = $request->HargaJual;
            $produk->Berat = $request->Berat;
            $produk->Deskripsi = $request->Deskripsi;
            $produk->IdKategoriProduk = $request->KategoriProduk;

            $produk->save();
            for($i=0;$i<count($request->StokMasuk);$i++){
                 if(isset($request->IdStokProduk[$i])){
                    $stokproduk = StokProduk::find($request->IdStokProduk[$i]);

                    $stokproduk->IdStokProduk = $request->IdStokProduk[$i];
                    $stokproduk->IdUkuran = $request->Ukuran[$i];
                    $stokproduk->IdWarna = $request->Warna[$i];
                    $stokproduk->StokMasuk = $request->StokMasuk[$i];
                    $stokproduk->StokAkhir = ($request->StokMasuk[$i] - $stokproduk->StokKeluar);
                    $stokproduk->IdProduk = $request->IdProduk;

                    $stokproduk->save();
                }else{
                    $stokproduk = new StokProduk;

                    $stokproduk->IdUkuran = $request->Ukuran[$i];
                    $stokproduk->IdWarna = $request->Warna[$i];
                    $stokproduk->StokMasuk = $request->StokMasuk[$i];
                    $stokproduk->StokKeluar = 0;
                    $stokproduk->StokAkhir = ($request->StokMasuk[$i] - $stokproduk->StokKeluar);
                    $stokproduk->IdProduk = $request->IdProduk;

                    $stokproduk->save();
                }
                
            }
            
            DB::commit();

            return response()->json(['success'=>'sukses']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['error'=> $e ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $produk = Produk::find($id);

            StokProduk::where('IdProduk', $produk->IdProduk)->delete();
            Produk::find($id)->delete();
        
            DB::commit();

            return response()->json(['success'=>'sukses']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['error'=> $e ]);
        }
    }

    public function managestok(Request $request, $id)
    {
        $this->validate($request, [
            'IdStokProduk' => 'required',
            'IdProduk' => 'required',
        ]);
        
        DB::beginTransaction();
        try {
            for($i = 0; $i < count($request->IdStokProduk); $i++){
                $stokproduk = StokProduk::where([
                    ['IdStokProduk', '=', $request->IdStokProduk[$i]],
                    ['IdProduk', '=', $id]
                ])->first();
                
                if(isset($request->StokMasuk[$i])){
                    $StokMasuk = ($stokproduk->StokMasuk) + ($request->StokMasuk[$i]);
            
                    $stokproduk->StokMasuk = $StokMasuk;
                    $stokproduk->StokAkhir = ($stokproduk->StokMasuk - $stokproduk->StokKeluar);
                    
                    $stokproduk->save();
                }
            }
            
            DB::commit();

            return response()->json(['success'=>'sukses']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['error'=> $e ]);
        }
    }

    public function hapusstok($id)
    {
        StokProduk::find($id)->delete();
        return response()->json(['success'=>'sukses']);
    }

}
