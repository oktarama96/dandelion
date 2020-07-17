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
            <h3 class="cart-page-title">Your cart items</h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <form action="#">
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <div class="table-content table-responsive cart-table-content">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Nama Produk</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Subtotal</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($carts as $cart)
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <a href="#"><img src="/img/produk/{{ $cart->GambarProduk }}" width="82px" height="82px" alt=""></a>
                                                </td>
                                                <td class="product-name"><a href="#">{{ $cart->NamaProduk }}</a></td>
                                                <td class="product-price-cart"><span class="amount">Rp. {{ $cart->HargaJual }}</span></td>
                                                <td class="product-quantity">
                                                    <div class="cart-plus-minus">
                                                        <input class="cart-plus-minus-box" type="text" name="qtybutton" value="{{ $cart->Qty }}">
                                                    </div>
                                                </td>
                                                <td class="product-subtotal">Rp. {{ ($cart->sub_total) }}</td>
                                                <td class="product-remove">
                                                    <a href="#"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
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
                                    <h4 class="grand-totall-title">Total  <span>Rp. {{ $cart_total }}</span></h4>
                                    <a href="/shop/checkout">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-shiping-update-wrapper">
                                    <div class="cart-shiping-update">
                                        <a href="/shop">Continue Shopping</a>
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