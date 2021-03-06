<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Produk;
use App\Transaksi;
use App\KategoriProduk;
use App\Warna;
use App\Ukuran;
use App\Cart;
use App\DetailTransaksi;
use App\StokProduk;
use Carbon\Carbon;
use DataTables;
use Veritrans_Config;
use Veritrans_Snap;
use Veritrans_Notification;
use Auth;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use App\Item;
use App\ItemDt;

class TransaksiController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
 
        // Set midtrans configuration
        Veritrans_Config::$serverKey = config('services.midtrans.serverKey');
        Veritrans_Config::$isProduction = config('services.midtrans.isProduction');
        Veritrans_Config::$isSanitized = config('services.midtrans.isSanitized');
        Veritrans_Config::$is3ds = config('services.midtrans.is3ds');
    }


    public function pointofsale()
    {
        return view('pos.pages.pointofsale');
    }

    public function acproduk(Request $request)
    {
        $produk = $request->get('query');
        //dd($produk);

        $produks = DB::table('produk')
                ->select('IdProduk', 'NamaProduk')
                ->where('IdProduk', 'like', '%' . $produk . '%')
                ->orWhere('NamaProduk', 'like', '%' . $produk . '%')
                ->get(); 
    
        foreach($produks as $data){
            $returned[] = ['value' => $data->IdProduk." - ".$data->NamaProduk, 'id' => $data->IdProduk];
        }

        if(count($produks) > 0){
            return response()->json(array('suggestions' => $returned));
        }else{
            return response()->json(['suggestions' => '']);
        }        
    }

    public function addproduk($id)
    {
        $produk = Produk::select('IdProduk','NamaProduk','HargaJual')->where('IdProduk', $id)->get();
        $stokproduk = StokProduk::with(['warna','ukuran'])->where('IdProduk', $id)->get();
        return response()->json(['produk' => $produk , 'stokproduk' => $stokproduk]);
    }

    public function addukuran($id)
    {
        $stokproduk = StokProduk::with('ukuran')->where('IdWarna', $id)->get();
        return response()->json(['stokproduk' => $stokproduk]);
    }

    public function simpantransaksi(Request $request)
    {
        $this->validate($request, [
            'IdPengguna' => 'required',
            'Total' => 'required',
            'Potongan' => 'required',
            'Bayar' => 'required',
        ]);

        //dd($request->IdProduk[0]);

        if($request->Total == 0){
            return redirect()->back()->with("alert" , "Error : Form Transaksi Masih Kosong!");
        }else{
            if($request->Bayar == 0 || $request->Kembali < 0){
                return redirect()->back()->with("alert", "Error : Jumlah Pembayaran Tidak Sesuai!"); 
            }else{
                DB::beginTransaction();
                try {
                    $Tgl = Carbon::now();
                    $IdTransaksi = $Tgl->format("YmdHis");
                    $TglTransaksi = $Tgl->format("Y-m-d H:i:s");

                    $transaksi = new Transaksi;

                    $transaksi->IdTransaksi = $IdTransaksi;
                    $transaksi->TglTransaksi = $TglTransaksi;
                    $transaksi->Total = $request->Total;
                    $transaksi->Potongan = $request->Potongan;
                    $transaksi->OngkosKirim = 0;
                    $transaksi->NamaEkspedisi = "-";
                    $transaksi->GrandTotal = $request->GrandTotal;
                    $transaksi->MetodePembayaran = "Cash";
                    $transaksi->StatusPembayaran = 1;
                    $transaksi->StatusPesanan = 3; //0=belumdiproses, 1=diproses, 2=dikirim,  3=selesai
                    $transaksi->Snap_token = "-";
                    $transaksi->IdKuponDiskon = "-";
                    $transaksi->IdPengguna = $request->IdPengguna;
                    $transaksi->IdPelanggan = 1;
                    
                    $transaksi->save();

                    if(!empty($request->IdProduk)){
                        for($i=0;$i<count($request->IdProduk);$i++){
                            // return $request->Ukuran;
                           
                            $stokproduk = StokProduk::where([
                                ['IdProduk', '=', $request->IdProduk[$i]],
                                ['IdWarna', '=', $request->Warna[$i]],
                                ['IdUkuran', '=', $request->Ukuran[$i]],
                            ])->first();

                            if($stokproduk){
                                //dd($stokproduk->StokKeluar);
                                $stokkeluar = $stokproduk->StokKeluar + $request->Qty[$i];
                                
                                $stokproduk->StokKeluar = $stokkeluar;
                                $stokproduk->StokAkhir = $stokproduk->StokMasuk - $stokkeluar;

                                $stokproduk->save();

                                $detailtransaksi = new DetailTransaksi;
                            
                                $detailtransaksi->Qty = $request->Qty[$i];
                                $detailtransaksi->Diskon = $request->Diskon[$i];
                                $detailtransaksi->SubTotal = $request->SubTotal[$i];
                                $detailtransaksi->IdProduk = $request->IdProduk[$i];
                                $detailtransaksi->IdStokProduk = $stokproduk->IdStokProduk;
                                $detailtransaksi->IdTransaksi = $IdTransaksi;

                                $detailtransaksi->save();
                            }                                          
                        }
                        if($request->has('print')){
                            $this->printstruk($IdTransaksi);
                        }
                    }else{
                        return redirect()->back()->with("alert" , "Error : Tidak Ada Barang!");
                    }
                    
                    DB::commit();

                    return redirect()->back()->with("alert", "Data Berhasil Disimpan!");
                }catch(\Exception $e){
                    DB::rollback();
                    return redirect()->back()->with("alert", "Error : $e");
                }
            }
        }
    }

    public function getSnapToken($TrxId, $Total, $Ongkir, $Potongan){
        $Tgl = Carbon::now();
        $Now = $Tgl->format("Y-m-d H:i:s");

        $pelanggan = Auth::guard('web')->user();
        $cart = $this->getCart();

        $transaction_detail = [];
        foreach($cart as $produk){
            $transaction_detail[] = [
                'id'       => $produk->IdStokProduk,
                'price'    => $produk->HargaJual,
                'quantity' => $produk->Qty,
                'name'     => $produk->NamaProduk." (".$produk->NamaWarna." / ".$produk->NamaUkuran.")"
            ];

        }
        
        $transaction_detail[] = [
            'id'       => 0,
            'price'    => $Ongkir,
            'quantity' => 1,
            'name'     => "Ongkos Kirim"
        ];

        $transaction_detail[] = [
            'id'       => 0,
            'price'    => -$Potongan,
            'quantity' => 1,
            'name'     => "Potongan"
        ];
        // Buat transaksi ke midtrans kemudian save snap tokennya.
        $payload = [
            'transaction_details' => [
                'order_id'      => $TrxId,
                'gross_amount'  => $Total,
            ],
            'customer_details' => [
                'first_name'    => $pelanggan->NamaPelanggan,
                'email'         => $pelanggan->email,
                'phone'         => $pelanggan->NoHandphone,
                'address'       => $pelanggan->Alamat,
                // 'phone'         => '08888888888',
                // 'address'       => '',
            ],
            'item_details' => $transaction_detail,
            'expiry' => array (
              "start_time" => $Now." +0800",
              "unit" => "minutes",
              "duration" => 30
            )
        ];
        
        $snapToken = Veritrans_Snap::getSnapToken($payload);
        return $snapToken;
    }

    /**
     * Midtrans notification handler.
     *
     * @param Request $request
     * 
     * @return void
     */
    public function notificationHandler(Request $request)
    {
        $notif = new Veritrans_Notification();
        \DB::transaction(function() use($notif) {
 
          $transaction = $notif->transaction_status;
          $type = $notif->payment_type;
          $orderId = $notif->order_id;
          $fraud = $notif->fraud_status;
          $transaksi = Transaksi::findOrFail($orderId);
 
          if ($transaction == 'capture') {
            if ($type == 'credit_card') {
              if($fraud == 'challenge') {
                $transaksi->setPending();
              } else {
                $transaksi->setSuccess();
              }
            }
          } elseif ($transaction == 'settlement') {
            $transaksi->setSuccess();
          } elseif($transaction == 'pending'){
            $transaksi->setPending();
          } elseif ($transaction == 'deny') {
            $transaksi->setFailed();
          } elseif ($transaction == 'expire') {
              //delete
                $transaksi->StatusPesanan = 4;
                $transaksi->save();

                $details = DetailTransaksi::where('IdTransaksi', $orderId)->get();
            
                foreach ($details as $detail) {
                    $stokproduk = StokProduk::find($detail->IdStokProduk);

                    $stokkeluar = $stokproduk->StokKeluar - $detail->Qty;
                    $stokmasuk = $stokproduk->StokMasuk + $detail->Qty;
                    $stokproduk->StokMasuk = $stokmasuk;
                    $stokproduk->StokKeluar = $stokkeluar;
                    $stokproduk->StokAkhir = $stokproduk->StokMasuk - $stokkeluar;

                    $stokproduk->save();
                }

                DetailTransaksi::where('IdTransaksi', $orderId)->delete();
                $transaksi->setExpired();
          } elseif ($transaction == 'cancel') {
            $transaksi->setFailed();
          }
        });
 
        return ;
    }

    public function getCart()
    {
        $id_pelanggan = Auth::guard('web')->user()->IdPelanggan;
        $cart = Cart::join('stokproduk', 'cart.IdStokProduk', '=', 'stokproduk.IdStokProduk')
                ->join('produk', 'stokproduk.IdProduk', '=', 'produk.IdProduk')
                ->join('warna', 'stokproduk.IdWarna', '=', 'warna.IdWarna')
                ->join('ukuran', 'stokproduk.IdUkuran', '=', 'ukuran.IdUkuran')
                ->select('cart.IdStokProduk', 'warna.NamaWarna','ukuran.NamaUkuran','cart.IdCart', 'produk.*', 'cart.Qty', DB::raw('produk.HargaJual * cart.Qty as sub_total, stokproduk.StokAkhir-cart.Qty as selisih_stok'))
                ->where('IdPelanggan', $id_pelanggan)->get();
        return $cart;
    }

    public function simpantransaksionline(Request $request)
    {
        $id_pelanggan = Auth::guard('web')->user()->IdPelanggan;
        DB::beginTransaction();
        
        for ($j=0; $j < count($request->IdStokProduk); $j++) { 
            $stokproduk = StokProduk::find($request->IdStokProduk[$j]);

            if($request->Qty[$j] <= $stokproduk->StokAkhir){
                try {
                    $Tgl = Carbon::now();
                    $IdTransaksi = $Tgl->format("YmdHis");
                    $TglTransaksi = $Tgl->format("Y-m-d H:i:s");
                    $ongkir = explode("-",$request->OngkosKirim);
        
                    $transaksi = new Transaksi;
        
                    $transaksi->IdTransaksi = $IdTransaksi;
                    $transaksi->TglTransaksi = $TglTransaksi;
                    $transaksi->Total = $request->Total;
                    $transaksi->Potongan = $request->Potongan;
                    $transaksi->OngkosKirim = $ongkir[0];
                    $transaksi->NamaEkspedisi = $request->NamaEkspedisi;
                    $transaksi->GrandTotal = $request->GrandTotal;
                    $transaksi->MetodePembayaran = "Midtrans";
                    $transaksi->StatusPembayaran = 0;
                    $transaksi->StatusPesanan = 0; //0=belumdiproses, 1=diproses, 2=dikirim,  3=selesai, 4=dibatalkan
                    $transaksi->IdKuponDiskon = $request->IdKuponDiskon;
                    $transaksi->IdPengguna = 0;
                    $transaksi->IdPelanggan = $id_pelanggan;
        
                    $snapToken = $this->getSnapToken($IdTransaksi, $request->GrandTotal,$ongkir[0],$request->Potongan);
                    
                    $transaksi->Snap_token = $snapToken;
                    $transaksi->save();
        
                    for($i=0;$i<count($request->IdProduk);$i++){
                        $stokproduk = StokProduk::find($request->IdStokProduk[$i]);
                        
                        if($stokproduk){
                            //dd($stokproduk->StokKeluar);
                            if($stokproduk->StokAkhir <= 0){
                                DB::rollback();
                                $this->response['error'] = "Ada Produk Yang Stoknya Habis!";
                                break;
                            }else{
                                
                                $stokkeluar = $stokproduk->StokKeluar + $request->Qty[$i];
                                
                                $stokproduk->StokKeluar = $stokkeluar;
                                $stokproduk->StokAkhir = $stokproduk->StokMasuk - $stokkeluar;
        
                                $stokproduk->save();
                            
                                $detailtransaksi = new DetailTransaksi;
                            
                                $detailtransaksi->Qty = $request->Qty[$i];
                                $detailtransaksi->Diskon = 0;
                                $detailtransaksi->SubTotal = $request->SubTotal[$i];
                                $detailtransaksi->IdProduk = $request->IdProduk[$i];
                                $detailtransaksi->IdStokProduk = $stokproduk->IdStokProduk;
                                $detailtransaksi->IdTransaksi = $IdTransaksi;
        
                                $detailtransaksi->save();
        
                                $this->deleteCart($id_pelanggan);
                            
                            }
                        }                        
                    }
                    
                    
                    DB::commit();
        
                    $this->response['snap_token'] = $snapToken;
                }catch(\Exception $e){
                    DB::rollback();
                    $this->response['error'] = $e;
                }
            }else{
                DB::rollback();

                $carts = $this->getCart();
                foreach($carts as $cart){
                    $cart->Qty += $cart->selisih_stok;
                    $cart->save();
                }

                $this->response['error'] = "Ada Stok Yang Kurang!";
            }
        }
        

        
        return response()->json($this->response);
    }

    public function deleteCart($id_pelanggan){
        Cart::where('IdPelanggan', $id_pelanggan)->delete();
    }

    public function index()
    {
        return view('pos.pages.transaksi');
    }

    public function loaddata(Request $request)
    {
        $now = Carbon::today();
        // $now->format('Y-m-d')  

        if ($request->ajax()) {
            $method = "";
            if($request->method == 'Cash'){
                $method = "Cash";
            }else{
                $method = "Midtrans";
            }
            if($request->from_date == NULL){
                $datas = Transaksi::with(['pengguna:IdPengguna,NamaPengguna', 'pelanggan:IdPelanggan,NamaPelanggan', 'kupondiskon:IdKuponDiskon,NamaKupon'])
                ->where('MetodePembayaran', $method)
                ->whereBetween('TglTransaksi', [$now, $now->format('Y-m-d').' 23:59:59'])
                ->orderBy('TglTransaksi', 'DESC')
                ->get();

                $sum_total = Transaksi::where('StatusPembayaran', 1)
                ->where('StatusPesanan','!=', 4)
                ->where('MetodePembayaran', $method)
                ->whereBetween('TglTransaksi', [$now, $now->format('Y-m-d').' 23:59:59'])
                ->sum('GrandTotal');
            }else{
                // return $request->to_date;
                $datas = Transaksi::with(['pengguna:IdPengguna,NamaPengguna', 'pelanggan:IdPelanggan,NamaPelanggan', 'kupondiskon:IdKuponDiskon,NamaKupon'])
                ->where('MetodePembayaran', $method)
                ->whereBetween('TglTransaksi', [$request->from_date.' 00:00:00', $request->to_date.' 23:59:59'])
                ->orderBy('TglTransaksi', 'DESC')
                ->get();

                $sum_total = Transaksi::where('StatusPembayaran', 1)
                ->where('StatusPesanan','!=', 4)
                ->where('MetodePembayaran', $method)
                ->whereBetween('TglTransaksi', [$request->from_date.' 00:00:00', $request->to_date.' 23:59:59'])
                ->sum('GrandTotal');
            }
            
            return Datatables::of($datas)
                    ->with(['sum_total' => $sum_total])
                    ->editColumn('Total', function($data){
                        return "Rp. ".number_format($data->Total,0,',',',')."";
                    })
                    ->editColumn('Potongan', function($data){
                        return "Rp. ".number_format($data->Potongan,0,',',',')."";
                    })
                    ->editColumn('OngkosKirim', function($data){
                        return "Rp. ".number_format($data->OngkosKirim,0,',',',')."";
                    })
                    ->editColumn('GrandTotal', function($data){
                        return "Rp. ".number_format($data->GrandTotal,0,',',',')."";
                    })
                    ->editColumn('StatusPembayaran', function($data){
                        if($data->StatusPembayaran == 1){
                            $status = "<span class='badge badge-success'>Lunas</span>";
                        }else if($data->StatusPembayaran == 2){
                            $status = "<span class='badge badge-danger'>Pending</span>";
                        }else if($data->StatusPembayaran == 3){
                            $status = "<span class='badge badge-danger'>Gagal</span>";
                        }else if($data->StatusPembayaran == 4){
                            $status = "<span class='badge badge-danger'>Kadaluarsa</span>";
                        }else{
                            $status = "<span class='badge badge-danger'>Belum Lunas</span>";
                        }
                        return $status;
                    })
                    ->editColumn('StatusPesanan', function($data){
                        if($data->StatusPesanan == 0){
                            $statuspesanan = "<span class='badge badge-danger'>Belum Diproses</span>";
                        }else if($data->StatusPesanan == 1){
                            $statuspesanan = "<span class='badge badge-warning'>Diproses</span>";
                        }else if($data->StatusPesanan == 2){
                            $statuspesanan = "<span class='badge badge-primary'>Dikirim</span>";
                        }else if($data->StatusPesanan == 3){
                            $statuspesanan = "<span class='badge badge-success'>Selesai</span>";
                        }else if($data->StatusPesanan == 4){
                            $statuspesanan = "<span class='badge badge-danger'>Dibatalkan</span>";
                        }
                        return $statuspesanan;
                    })
                    ->addColumn('Aksi', function($data){
                        $btn = "<button type='button' class='btn btn-success btn-flat' title='Show Data' data-toggle='modal' data-target='#detail' onclick='detail(\"".$data->IdTransaksi."\")'><i class='fa fa-info'></i></button>";
                        if ($data->MetodePembayaran == "Midtrans") {
                            $btn = $btn." <button type='button' class='btn btn-primary btn-flat' title='Update Pesanan' data-toggle='modal' data-target='#pesanan' onclick='pesanan(\"".$data->IdTransaksi."\")'><i class='fa fa-edit'></i></button>";
                        }
                        if (auth()->guard('pengguna')->user()->Is_admin == 1) {
                            $btn = $btn." <button type='button' class='btn btn-danger btn-flat' title='Delete Data' onclick='deletee(\"".$data->IdTransaksi."\")'><i class='fa fa-trash'></i></button>";
                        }
                        return $btn;
                    })
                    ->rawColumns(['Aksi', 'StatusPesanan', 'StatusPembayaran'])
                    ->make(true);
        }
    }

    public function showdetailtrans($id)    
    {
        $detailtransaksi = DetailTransaksi::with(['produk','stokproduk','stokproduk.warna','stokproduk.ukuran'])->where('IdTransaksi', $id)->get();
        return response()->json(['detailtransaksi' => $detailtransaksi]);
    }

    public function hapustransaksi($id)
    {
        DB::beginTransaction();
        try {
            $transaksi = Transaksi::find($id);
            $details = DetailTransaksi::where('IdTransaksi', $transaksi->IdTransaksi)->get();
            

            foreach ($details as $detail) {
                $stokproduk = StokProduk::find($detail->IdStokProduk);

                $stokkeluar = $stokproduk->StokKeluar - $detail->Qty;
                $stokmasuk = $stokproduk->StokMasuk + $detail->Qty;
                $stokproduk->StokMasuk = $stokmasuk;
                $stokproduk->StokKeluar = $stokkeluar;
                $stokproduk->StokAkhir = $stokproduk->StokMasuk - $stokkeluar;

                $stokproduk->save();
            }

            DetailTransaksi::where('IdTransaksi', $transaksi->IdTransaksi)->delete();
            Transaksi::find($id)->delete();
        
            DB::commit();

            return response()->json(['success'=>'sukses']);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['error'=> $e ], 400);
        }
    }

    public function printstruk($id)
    {
        if($id == 1){
            $transaksis = Transaksi::with('pengguna')
                    ->where('MetodePembayaran', '=', 'Cash')
                    ->latest()
                    ->first();
        }else{
            $transaksis = Transaksi::with('pengguna')
                    ->where([
                        ['IdTransaksi', '=', $id],
                        ['MetodePembayaran', '=', 'Cash'],
                    ])->first();
        }
        

        $detailtransaksis = DetailTransaksi::with(['produk','stokproduk','stokproduk.warna','stokproduk.ukuran'])->where('IdTransaksi', $transaksis->IdTransaksi)->get();
        // dd($detailtransaksis);
        
        $id_transaksi = new Item('ID TRANSAKSI', $transaksis->IdTransaksi);
        $tgl = new Item('TANGGAL', date('d-m-Y h:m:s', strtotime($transaksis->TglTransaksi)));
        $op = new Item('OPERATOR', $transaksis->pengguna->NamaPengguna);

        $totalp = new Item('TOTAL', "Rp. ".number_format($transaksis->Total,0,',',',')."");
        $potonganp = new Item('POTONGAN', "Rp. ".number_format($transaksis->Potongan,0,',',',')."");
        $grandtotalp = new Item('GRANDTOTAL', "Rp. ".number_format($transaksis->GrandTotal,0,',',',')."");

        $items = array();
        $items_detail = array();

        $i = 0;
        foreach($detailtransaksis as $detailtransaksi){
            $items[$i] = new ItemDt($detailtransaksi->produk->NamaProduk, $detailtransaksi->Qty." x Rp. ".number_format($detailtransaksi->produk->HargaJual,0,',',','), $detailtransaksi->Diskon."%    Rp. ".number_format($detailtransaksi->SubTotal,0,',',','));
            $items_detail[$i] = new ItemDt($detailtransaksi->stokproduk->ukuran->NamaUkuran ." - ". $detailtransaksi->stokproduk->warna->NamaWarna ,"");
            $i++;
        }

        $connector = new WindowsPrintConnector("tmu");
        $printer = new Printer($connector);

        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> text("Dandelion Fashion Shop\n");
        $printer -> selectPrintMode();
        $printer -> text("Jl. Raya Abianbase No. 128\n");
        $printer -> text("0812 4658 5269\n");
        $printer -> text("================================\n");
        $printer -> setJustification();

        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> setEmphasis(true);
        $printer -> text($id_transaksi);
        $printer -> setEmphasis(false);
        $printer -> text($tgl);
        $printer -> text($op);
        $printer -> setJustification();


        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("================================\n");
        $printer -> setJustification();

        $printer -> setJustification(Printer::JUSTIFY_LEFT);

        foreach ($items as $key => $item) {
                $printer -> text($items[$key]);
                $printer -> text($items_detail[$key]);
        }
        $printer -> setJustification();

        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("================================\n");
        $printer -> setJustification();

        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text($totalp);
        $printer -> text($potonganp);
        $printer -> setEmphasis(true);
        $printer -> text($grandtotalp);
        $printer -> setEmphasis(false);
        $printer -> setJustification();

        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("================================\n");
        $printer -> setJustification();

        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("Terima Kasih\n");
        $printer -> text("Barang yang telah dibeli\n");
        $printer -> text("tidak bisa ditukar/dikembalikan\n");
        $printer -> text("IG: dandelionshop128\n");
        $printer -> setJustification();

        $printer -> cut();
        $printer -> close();

        if($id == 1){
            return redirect()->back();
        }
    }

    public function updatetransaksi(Request $request, $id)        
    {
        $id_pengguna = Auth::guard('pengguna')->user()->IdPengguna;
        $transaksi = Transaksi::find($id);

        $transaksi->StatusPesanan = $request->StatusPesanan;
        $transaksi->IdPengguna = $id_pengguna;
        $transaksi->save();

        if($request->StatusPesanan == 4){
            $details = DetailTransaksi::where('IdTransaksi', $transaksi->IdTransaksi)->get();
            

            foreach ($details as $detail) {
                $stokproduk = StokProduk::find($detail->IdStokProduk);

                $stokkeluar = $stokproduk->StokKeluar - $detail->Qty;
                $stokmasuk = $stokproduk->StokMasuk + $detail->Qty;
                $stokproduk->StokMasuk = $stokmasuk;
                $stokproduk->StokKeluar = $stokkeluar;
                $stokproduk->StokAkhir = $stokproduk->StokMasuk - $stokkeluar;

                $stokproduk->save();
            }

            DetailTransaksi::where('IdTransaksi', $transaksi->IdTransaksi)->delete();
        }

        return response()->json(['success'=>'sukses']);
    }

    public function printinvoice($id_transaksi)
    {
        $transaksi = Transaksi::with('pelanggan')->where('IdTransaksi', $id_transaksi)->first();
        $detailtransaksis = DetailTransaksi::with(['produk','stokproduk','stokproduk.warna','stokproduk.ukuran'])->where('IdTransaksi', $id_transaksi)->get();

        return view('invoice', compact('transaksi','detailtransaksis'));
    }

}
