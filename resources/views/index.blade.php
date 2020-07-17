@extends('layout.layout')

@section('title-page')
    Dandelion Fashion Shop
@endsection

@section('add-js')
    <script type="text/javascript">

        function viewUkuran(ini) {
            //console.log(ini);
            $.ajax({
                type: "GET",
                url:  "{{ url('/pos/pages/pos/addukuran') }}/"+$(ini).val()+"/",
                data:  "IdProduk=" + $(ini).val(),
                success: function(msg){
                    //console.log(msg);
                    var ukuran;
                    if(msg.stokproduk.length != 0) {              
                        for(var j = 0; j < msg.stokproduk.length; j++){
                            ukuran = ukuran+"<option value='"+msg.stokproduk[j].IdUkuran+"'>"+msg.stokproduk[j].ukuran.NamaUkuran+"</option>";
                        }
                        $("select[name='Ukuran']").empty().append(ukuran);
                    }
                }
            });
        }

        function detail(a){
            var kode = 'IdProduk='+ a;
            $.ajax({
                type: "GET",
                url: "{{ url('/produk/detail/') }}/"+a+"/",
                data: kode,
                success: function(msg){
                    //console.log(msg.produk.NamaProduk);
                    var imgurl = "{{ asset('img/produk/') }}/";
                    var data = "<div class='row append'>"+
                                    "<div class='col-md-5 col-sm-12 col-xs-12'>"+
                                        "<div class='tab-content quickview-big-img'>"+
                                            "<div id='pro-1' class='tab-pane fade show active'>"+
                                                "<img src='"+imgurl+msg.produk.GambarProduk+"' alt=''>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-md-7 col-sm-12 col-xs-12'>"+
                                        "<div class='product-details-content quickview-content'>"+
                                            "<h2>"+msg.produk.NamaProduk+"</h2>"+
                                            "<div class='product-details-price'>"+
                                                "<span>Rp. "+msg.produk.HargaJual+"</span>"+
                                            "</div>"+
                                            "<div class='pro-details-rating-wrap'>"+
                                                "<div class='pro-details-rating'>"+
                                                    "<i class='fa fa-star-o yellow'></i>"+
                                                    "<i class='fa fa-star-o yellow'></i>"+
                                                    "<i class='fa fa-star-o yellow'></i>"+
                                                    "<i class='fa fa-star-o'></i>"+
                                                    "<i class='fa fa-star-o'></i>"+
                                                "</div>"+
                                                "<span>3 Reviews</span>"+
                                            "</div>"+
                                            "<p>"+msg.produk.Deskripsi+"</p>"+
                                            "<p>Berat : "+msg.produk.Berat+" Gram</p>"+
                                            "<br/>"+
                                            "<div class='pro-details-size-color'>"+
                                                "<div class='pro-details-color-wrap'>"+
                                                    "<span>Color</span>"+
                                                    "<div class='pro-details-color-content'>"+
                                                        "<select class='form-control' name='Warna' onchange='viewUkuran(this)'>";

                                                        for(var i = 0; i < msg.stokproduk.length; i++){
                                                            data = data+"<option value='"+msg.stokproduk[i].IdWarna+"'>"+msg.stokproduk[i].warna.NamaWarna+"</option>";
                                                        }
                                                        
                                                    data = data+"</select>"+
                                                    "</div>"+
                                                "</div>"+
                                                "<div class='pro-details-color-wrap'>"+
                                                    "<span>Size</span>"+
                                                    "<div class='pro-details-color-content'>"+
                                                        "<select class='form-control' name='Ukuran'>";

                                                            for(var j = 0; j < msg.stokproduk.length; j++){
                                                            data = data+"<option value='"+msg.stokproduk[j].IdUkuran+"'>"+msg.stokproduk[j].ukuran.NamaUkuran+"</option>";
                                                        }
                                                        
                                                    data = data+"</select>"+
                                                    "</div>"+
                                                "</div>"+
                                            "</div>"+
                                            "<div class='pro-details-quality'>"+
                                                "<div class='cart-plus-minus'>"+
                                                    "<input class='cart-plus-minus-box' type='number' name='Qty' value='1'>"+
                                                "</div>"+
                                                "<div class='pro-details-cart btn-hover'>"+
                                                    "<a href='#'>Add To Cart</a>"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";

                    $("#detail").append(data);
                }
            })
        }

        $('#exampleModal').on('hidden.bs.modal', function(e){
            $('.append').remove(); 
        });

    </script>
@endsection

@section('content')
    <div class="home-sidebar-left">
        <div class="logo">
            <a href="/">
                <img alt="" src="assets/img/logo/logo.png">
            </a>
        </div>
        <div class="header-right-wrap">
            <div class="same-style account-satting">
                <a class="account-satting-active" href="#"><i class="pe-7s-user-female"></i></a>
                <div class="account-dropdown">
                    @if (Auth::guard('web')->user())
                        <ul>
                            <li>{{Auth::guard('web')->user()->NamaPelanggan}}</li>
                            <li><a ref="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a></li>                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    @else
                        <ul>
                            <li><a href="/login">Login</a></li>
                        </ul>
                    @endif
                    
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <nav>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/shop">Shop</a></li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </nav>
        </div>
        <div class="sidebar-copyright">
            <p>©2020 <a href="#">Dandelion Fashion Shop</a>. All Rights Reserved.</p>
        </div>
    </div>
    <header class="header-area header-padding-1 sticky-bar header-res-padding clearfix header-hm4-none">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-6 col-4">
                    <div class="logo">
                        <a href="/">
                            <img alt="" src="assets/img/logo/logo.png">
                        </a>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-102 col-md-6 col-8">
                    <div class="header-right-wrap">
                        <div class="same-style header-search">
                            <a href="#"><i class="pe-7s-search"></i></a>
                        </div>
                        <div class="same-style account-satting">
                            <a class="account-satting-active" href="#"><i class="pe-7s-user-female"></i></a>
                            <div class="account-dropdown">
                            @if (Auth::guard('web')->user())
                                <ul>
                                    <li>{{Auth::guard('web')->user()->NamaPelanggan}}</li>
                                    <li><a ref="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">Logout</a></li>                            
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            @else
                                <ul>
                                    <li><a href="/login">Login</a></li>
                                </ul>
                            @endif
                            </div>
                        </div>
                        @if (Auth::guard('web')->user())
                        <div class="same-style cart-wrap">
                            <button class="icon-cart">
                                <i class="pe-7s-shopbag"></i>
                                <span class="count-style">02</span>
                            </button>
                            <div class="shopping-cart-content">
                                <ul>
                                    <li class="single-shopping-cart">
                                        <div class="shopping-cart-img">
                                            <a href="#"><img alt="" src="assets/img/cart/cart-1.png"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="#">T- Shart & Jeans </a></h4>
                                            <h6>Qty: 02</h6>
                                            <span>$260.00</span>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fa fa-times-circle"></i></a>
                                        </div>
                                    </li>
                                    <li class="single-shopping-cart">
                                        <div class="shopping-cart-img">
                                            <a href="#"><img alt="" src="assets/img/cart/cart-2.png"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="#">T- Shart & Jeans </a></h4>
                                            <h6>Qty: 02</h6>
                                            <span>$260.00</span>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fa fa-times-circle"></i></a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="shopping-cart-total">
                                    <h4>Shipping : <span>$20.00</span></h4>
                                    <h4>Total : <span class="shop-total">$260.00</span></h4>
                                </div>
                                <div class="shopping-cart-btn btn-hover text-center">
                                    <a class="default-btn" href="cart-page.html">view cart</a>
                                    <a class="default-btn" href="checkout.html">checkout</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
            <div class="mobile-menu-area">
                <div class="mobile-menu">
                    <nav id="mobile-menu-active">
                        <ul class="menu-overflow">
                            <li><a href="/">HOME</a></li>
                            <li><a href="/shop">Shop</a></li>
                            <li><a href="/about">About us</a></li>
                            <li><a href="/contact">Contact</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div class="home-sidebar-right">
        <div class="slider-area ml-10">
            <div class="slider-active owl-carousel nav-style-1">
                <div class="single-slider-3 slider-height-3 bg-gray-2 d-flex align-items-center slider-height-res-hm4">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-7 col-lg-7 col-md-6 col-12 col-sm-6">
                                <div class="slider-content-3 slider-content-4 slider-animated-1 text-center">
                                    <h3 class="animated">Stylish</h3>
                                    <h1 class="animated">Women Fashion</h1>
                                    <p class="animated">Let's Shopping Now</p>
                                    <div class="slider-btn btn-hover">
                                        <a class="animated" href="/shop">SHOP NOW</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-6 col-12 col-sm-6">
                                <div class="single-slider-img4 slider-animated-1">
                                    <img class="animated" src="assets/img/slider/single-slide-2.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-slider-3 slider-height-3 bg-gray-2 d-flex align-items-center slider-height-res-hm4">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-7 col-lg-7 col-md-6 col-12 col-sm-6">
                                <div class="slider-content-3 slider-content-4 slider-animated-1 text-center">
                                    <h3 class="animated">Stylish</h3>
                                    <h1 class="animated">Women Fashion</h1>
                                    <p class="animated">Let's Shopping Now</p>
                                    <div class="slider-btn btn-hover">
                                        <a class="animated" href="/shop">SHOP NOW</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-6 col-12 col-sm-6">
                                <div class="single-slider-img4 slider-animated-1">
                                    <img class="animated" src="assets/img/slider/single-slide-7.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="banner-area banner-area-2 pt-10 pb-85">
            <div class="container-fluid">
                <div class="custom-row-2">
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="single-banner mb-10">
                            <a href="#"><img src="assets/img/banner/banner-1.png" alt=""></a>
                            <div class="banner-content">
                                <h3>Jackets</h3>
                                <a href="product-details.html"><i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="single-banner mb-10">
                            <a href="#"><img src="assets/img/banner/banner-2.png" alt=""></a>
                            <div class="banner-content">
                                <h3>Sweater</h3>
                                <a href="product-details.html"><i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="single-banner mb-10">
                            <a href="#"><img src="assets/img/banner/banner-3.png" alt=""></a>
                            <div class="banner-content">
                                <h3>Blazzer</h3>
                                <a href="product-details.html"><i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="single-banner mb-10">
                            <a href="#"><img src="assets/img/banner/banner-4.png" alt=""></a>
                            <div class="banner-content">
                                <h3>Shirt</h3>
                                <a href="product-details.html"><i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-area hm4-section-padding pb-100">
            <div class="container-fluid">
                <div class="section-title text-center">
                    <h2>DAILY DEALS!</h2>
                </div>
                <div class="product-tab-list nav pt-30 pb-55 text-center">
        
                </div>
                <div class="tab-content active">
                    <div class="tab-pane active" id="product-1">
                        <div class="custom-row-3 item-wrapper3">

                            @foreach ($produks as $produk)
                        
                                <div class="col-xl-3 col-md-6 col-lg-4 col-sm-6 toggle-item-active3">
                                    <div class="product-wrap-2 mb-25">
                                        <div class="product-img">
                                            <a href="product-details.html">
                                                <img class="default-img" src="/img/produk/{{ $produk->GambarProduk }}" alt="">
                                                <img class="hover-img" src="/img/produk/{{ $produk->GambarProduk }}" alt="">
                                            </a>
                                            <div class="product-action-2">
                                                <a title="Add To Cart" href="#"><i class="fa fa-shopping-cart"></i></a>
                                                <a title="Quick View" href="#" data-toggle="modal" data-target="#exampleModal" onclick="detail('{{ $produk->IdProduk }}')"><i class="fa fa-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-2">
                                            <div class="title-price-wrap-2">
                                                <h3>{{ $produk->NamaProduk }}</h3>
                                                <div class="price-2">
                                                    <span>Rp. {{ $produk->HargaJual }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            @endforeach
                            
                            <div class="view-more text-center mt-20 col-12">
                                <a href="/shop">VIEW MORE PRODUCTS</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="subscribe-area pb-100 pl-30 pr-30">
            <div class="row no-gutters">
                <div class="col-xl-6 col-lg-8 ml-auto mr-auto">
                    <div class="subscribe-style-2 text-center">
                        <h2>Subscribe </h2>
                        <p>Subscribe to our newsletter to receive news on update</p>
                        <div class="subscribe-form-2">
                            <form class="validate" novalidate="" target="_blank" name="mc-embedded-subscribe-form" method="post" action="http://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&amp;id=05d85f18ef">
                                <div class="mc-form">
                                    <input class="email" type="email" required="" placeholder="Your Email Address" name="EMAIL" value="">
                                    <div class="mc-news" aria-hidden="true">
                                        <input type="text" value="" tabindex="-1" name="b_6bbb9b6f5827bd842d9640c82_05d85f18ef">
                                    </div>
                                    <div class="clear-2">
                                        <input class="button" type="submit" name="subscribe" value="Subscribe">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer-area bg-gray pt-100 pb-70 ml-10 hm4-footer-padding">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <div class="copyright mb-30">
                            <div class="footer-logo">
                                <a href="index.html">
                                    <img alt="" src="assets/img/logo/logo.png">
                                </a>
                            </div>
                            <p>©2020 <a href="/">Dandelion Fashion Shop</a>.<br> All Rights Reserved</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <div class="footer-widget mb-30 ml-30">
                            <div class="footer-title">
                                <h3>ABOUT US</h3>
                            </div>
                            <div class="footer-list">
                                <ul>
                                    <li><a href="#">About us</a></li>
                                    <li><a href="#">Store location</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <div class="footer-widget mb-30 ml-145">
                            <div class="footer-title">
                                <h3>FOLLOW US</h3>
                            </div>
                            <div class="footer-list">
                                <ul>
                                    <li><a href="about.html">Instagram</a></li>
                                    <li><a href="#">Facebook</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Dandelion Fashion Shop</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body" id="detail">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
@endsection