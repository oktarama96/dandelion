@extends('layout.layout2')

@section('title-page')
    Cart - Dandelion Fashion Shop
@endsection

@section('add-js')
    <script type="text/javascript">
        
    </script>
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray-3">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li class="active">Cart Page </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cart-main-area pt-90 pb-100">
        <div class="container">
            <h3 class="cart-page-title">Keranjang Belanja Anda</h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <form action="#">
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <div class="table-content table-responsive cart-table-content">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Gambar</th>
                                                <th>Nama Produk</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Subtotal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($carts->isNotEmpty())
                                                @foreach ($carts as $cart)
                                                <tr>
                                                    <td class="product-thumbnail">
                                                        <a href="#"><img src="/img/produk/{{ $cart->GambarProduk }}" width="82px" height="82px" alt=""></a>
                                                    </td>
                                                    <td class="product-name"><a href="#">{{ $cart->NamaProduk }}</a></td>
                                                    <td class="product-price-cart"><span class="amount">Rp. {{ number_format($cart->HargaJual,0,',','.') }}</span></td>
                                                    <td class="product-quantity">
                                                        <div class="cart-plus-minus">
                                                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="{{ $cart->Qty }}">
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal">Rp. {{ number_format($cart->sub_total,0,',','.') }}</td>
                                                    <td class="product-remove">
                                                        <a href="#"><i class="fa fa-times"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6">Keranjang Belanja Anda Kosong! Ayo Tambah Produk Kita <a href="{{ url('/shop') }}" style="text-decoration: underline">Disini!</a></td>
                                                </tr>
                                            @endif
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="grand-totall">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                                    </div>
                                    <br/>
                                    <h4 class="grand-totall-title">Total  <span>Rp. {{ number_format($cart_total,0,',','.') }}</span></h4>

                                    @if ($carts->isNotEmpty())
                                        <a href="/shop/checkout">Checkout</a>
                                    @else 
                                        <a href="/shop/">Tambah Produk ?</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-shiping-update-wrapper">
                                    <div class="cart-shiping-update">
                                        <a href="/shop">Lanjutkan Berbelanja</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection