@extends('layout.layout')

@section('title-page')
    Invoice - Dandelion Fashion Shop
@endsection

@section('add-css')
    <style>
        .checkout-btn {
            background-color: #a749ff;
            border: medium none;
            color: #fff;
            cursor: pointer;
            font-weight: 500;
            padding: 10px 30px;
            text-transform: uppercase;
            border-radius: 50px;
            z-index: 9; }
        .checkout-btn:hover {
            background-color: #333; }

        @media print {
            html, body {
                border: 1px solid white;
                height: 99%;
                page-break-after: avoid;
                page-break-before: avoid;
            }
        }
    </style>
@endsection

@section('content')
    <nav class="navbar fixed-top navbar-light bg-light justify-content-between">
        <div class="container">
            <a class="btn-hover checkout-btn" href="{{ url('/my-account').'/'.Auth::guard('web')->user()->IdPelanggan }}"><i class="fa fa-angle-double-left"></i> Back</a>

            <button class="btn-hover checkout-btn" type="button" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
        </div>
    </nav>
    <!-- Main page content-->
    <div class="container mt-100">
        <!-- Invoice-->
        <div class="card invoice">
            <div class="card-header p-4 p-md-5 border-bottom-0">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-left">
                        <!-- Invoice branding-->
                        <div class="h2 mb-0">Dandelion Fashion Shop</div>
                    </div>
                    <div class="col-12 col-lg-auto text-center text-lg-right">
                        <!-- Invoice details-->
                        <div class="h3">Id Transaksi : {{ $transaksi->IdTransaksi }}</div>
                        <br />
                        {{ $transaksi->TglTransaksi }}
                    </div>
                </div>
            </div>
            <div class="card-body p-4 p-md-5">
                <!-- Invoice table-->
                <table class="table table-borderless mb-0">
                    <thead class="border-bottom">
                        <tr class="small text-uppercase text-muted">
                            <th scope="col">Nama Barang</th>
                            <th class="text-right" scope="col">Harga</th>
                            <th class="text-right" scope="col">Qty</th>
                            <th class="text-right" scope="col">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody id="detail-trans">
                        
                        @foreach ($detailtransaksis as $detailtransaksi)
                            <tr class="border-bottom append">
                                <td>
                                    <div class="font-weight-bold">{{ $detailtransaksi->produk->NamaProduk }}</div>
                                    <div class="small text-muted d-none d-md-block">{{ $detailtransaksi->IdProduk }} - {{ $detailtransaksi->stokproduk->warna->NamaWarna }} - {{ $detailtransaksi->stokproduk->ukuran->NamaUkuran }}</div>
                                </td>
                                <td class="text-right font-weight-bold">Rp. {{ number_format($detailtransaksi->produk->HargaJual,0,',',',') }}</td>
                                <td class="text-right font-weight-bold">{{ $detailtransaksi->Qty }}</td>
                                <td class="text-right font-weight-bold">Rp. {{ number_format($detailtransaksi->SubTotal,0,',',',') }}</td>
                            </tr>
                        @endforeach

                        <!-- Invoice subtotal-->
                        <tr>
                            <td class="text-right pb-0" colspan="3"><div class="text-uppercase small font-weight-700 text-muted">Total:</div></td>
                            <td class="text-right pb-0"><div class="h5 mb-0 font-weight-700">Rp. {{ number_format($transaksi->Total,0,',',',') }}</div></td>
                        </tr>

                        <!-- Invoice tax column-->
                        <tr>
                            <td class="text-right pb-0" colspan="3"><div class="text-uppercase small font-weight-700 text-muted">Ongkos Kirim:</div></td>
                            <td class="text-right pb-0"><div class="h5 mb-0 font-weight-700">Rp. {{ number_format($transaksi->OngkosKirim,0,',',',') }}</div></td>
                        </tr>

                        <tr>
                            <td class="text-right pb-0" colspan="3"><div class="text-uppercase small font-weight-700 text-muted">Potongan:</div></td>
                            <td class="text-right pb-0"><div class="h5 mb-0 font-weight-700">Rp. {{ number_format($transaksi->Potongan,0,',',',') }}</div></td>
                        </tr>
                        <!-- Invoice total-->
                        <tr>
                            <td class="text-right pb-0" colspan="3"><div class="text-uppercase small font-weight-700 text-muted">Grandtotal:</div></td>
                            <td class="text-right pb-0"><div class="h5 mb-0 font-weight-700 text-green">Rp. {{ number_format($transaksi->GrandTotal,0,',',',') }}</div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer p-4 p-lg-5 border-top-0">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <!-- Invoice - sent to info-->
                        <div class="small text-muted text-uppercase font-weight-700 mb-2">Untuk</div>
                        <div class="h6 mb-1">
                          {{ $transaksi->pelanggan->NamaPelanggan }}
                        </div>
                        <div class="small">
                          {{ $transaksi->pelanggan->Alamat }}
                        </div>
                        <div class="small">
                          {{ $transaksi->pelanggan->NamaKecamatan.", ".$transaksi->pelanggan->NamaKabupaten.", ".$transaksi->pelanggan->NamaProvinsi }}
                        </div>
                        <div class="small">
                          {{ $transaksi->pelanggan->NoHandphone }}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <!-- Invoice - sent from info-->
                        <div class="small text-muted text-uppercase font-weight-700 mb-2">Dari</div>
                        <div class="h6 mb-1">Dandelion Fashion Shop</div>
                        <div class="small">Jln. Raya Abianbase No. 128</div>
                        <div class="small">Badung, Bali, Indonesia</div>
                    </div>
                    <div class="col-lg-4 my-auto">
                        <div class="small text-muted text-uppercase font-weight-700 mb-2">Catatan</div>
                        <div class="small mb-0">Perhatian!, jika terdapat komplain terhadap barang mohon hubungi langsung +6281 2465 8526 9 atau email ke <a href="mailto:dandelionshop128@gmail.com">dandelionshop128@gmail.com</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection