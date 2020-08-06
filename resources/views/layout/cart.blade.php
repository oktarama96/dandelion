@if (Auth::guard('web')->user())
    <div class="same-style cart-wrap">
        <button class="icon-cart">
            <i class="pe-7s-shopbag"></i>
            <span class="count-style" id='cart_count'>{{ count($cart_produk) }}</span>
        </button>
        <div class="shopping-cart-content">
            <ul id="cart_content">
                @if (count($cart_produk) == 0)
                    <li class="text-center"><span>Cart Kosong!</span></li>                    
                @else
                    @foreach($cart_produk as $key=>$produk)
                    <li class="single-shopping-cart">
                        <div class="shopping-cart-img">
                            <a href="#"><img alt="" width="82px" height="82px" src="/img/produk/{{ $produk->GambarProduk }}"></a>
                        </div>
                        <div class="shopping-cart-title">
                            <h4><a href="#">{{ $produk->NamaProduk }} ({{ $produk->NamaWarna }}/{{ $produk->NamaUkuran }}) </a></h4>
                            <h6 class='qty'>Qty: {{ $produk->Qty }} </h6>
                            <span class='sub_total'>Rp {{ number_format($produk->sub_total,0,"",".") }}</span>
                        </div>
                        <div class="shopping-cart-delete">
                            <a href="#" class="delete_cart" onclick="delete_cart(this)"><i class="fa fa-times-circle"></i></a>
                        </div>
                    </li>
                    @endforeach
                @endif
            </ul>
            <div class="shopping-cart-total">
                <h4>Total : <span class="shop-total" id="cart_total">Rp {{ number_format($cart_total,0,"",".") }}</span></h4>
            </div>
            <div class="shopping-cart-btn btn-hover text-center">
                <a class="default-btn" href="/shop/cart">view cart</a>
                <a class="default-btn" href="/shop/checkout">checkout</a>
            </div>
        </div>
    </div>
@endif