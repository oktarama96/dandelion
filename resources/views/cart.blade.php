@extends('layout.layout2')

@section('title-page')
    Cart - Dandelion Fashion Shop
@endsection

@section('add-js')

    <script type="text/javascript">
        var CartPlusMinus = $('.cart-plus-minus');
        CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
        CartPlusMinus.append('<div class="inc qtybutton">+</div>');
        $(".qtybutton").on("click", function () {
            var $button = $(this);
            var max = $button.parent().find("input").data("max")
            var oldValue = $button.parent().find("input").val();
            var idCart = $button.parent().parent().parent().find("#IdCart").val();

            if ($button.text() === "+") {
                // console.log(idCart);
                if (oldValue >= max) {
                    if(oldValue == max){
                        var newVal = max;
                        $button.parent().find("input").val(newVal);
                    }else{
                        var selisih = (oldValue - max);

                        $.ajax({
                            type: "GET",
                            url: "{{ url('/shop/cart/balance/') }}/" + idCart,
                            data: "SelisihStok="+selisih ,
                            success: function (msg) {
                                location.reload();
                            }
                        })

                        var newVal = selisih;
                        $button.parent().find("input").val(newVal);
                    }
                    
                }else{
                    swal({
                        title: "Apakah anda yakin menambah kuantitas produk ini ?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "GET",
                                url: "{{ url('/shop/cart/plus/') }}/" + idCart,
                                success: function (msg) {
                                    location.reload();
                                }
                            })

                            var newVal = parseFloat(oldValue) + 1;
                            $button.parent().find("input").val(newVal);
                        }
                    });
                }
            } else {
                
                // Don't allow decrementing below zero
                if (oldValue == 1) {
                    var newVal = 1
                }else{
                    swal({
                        title: "Apakah anda yakin mengurangi kuantitas produk ini ?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "GET",
                                url: "{{ url('/shop/cart/min/') }}/" + idCart,
                                success: function (msg) {
                                    location.reload();
                                }
                            })

                            var newVal = parseFloat(oldValue) - 1;
                            $button.parent().find("input").val(newVal);
                        }
                    });
                }
            }
        });

        function delete_cart(delete_cart) {
            // alert(cart_produk[key].NamaProduk)

            swal({
                title: "Apakah anda yakin ?",
                text: "Ini akan menghapus data secara permanen.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/shop/delete-cart') }}/" + delete_cart,
                        success: function (msg) {
                            swal("Berhasil!", "Berhasil Menghapus Produk dari Keranjang Belanja", "success")
                            .then((value) => {
                                location.reload();
                            });
                            
                        }
                    })
                }
            });
            
        }
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
        <div class="container-fluid pl-70 pr-70">
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
                                                    <input type="hidden" id="IdCart" value="{{ $cart->IdCart }}">
                                                    <td class="product-thumbnail">
                                                        <a href="/shop/product-detail/{{ $cart->IdProduk }}"><img src="/img/produk/{{ $cart->GambarProduk }}" width="82px" height="82px" alt=""></a>
                                                    </td>
                                                    <td class="product-name"><a href="/shop/product-detail/{{ $cart->IdProduk }}">{{ $cart->NamaProduk }}</a><p>{{ $cart->NamaWarna }} / {{ $cart->NamaUkuran }}</p></td>
                                                    <td class="product-price-cart"><span class="amount">Rp. {{ number_format($cart->HargaJual,0,',','.') }}</span></td>
                                                    <td class="product-quantity">
                                                        <div class="cart-plus-minus">
                                                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="{{ $cart->Qty }}" data-max="{{ $cart->StokAkhir }}">
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal">Rp. {{ number_format($cart->sub_total,0,',','.') }}</td>
                                                    <td class="product-remove">
                                                        <a href="#" onclick="delete_cart({{ $cart->IdCart }})"><i class="fa fa-times"></i></a>
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