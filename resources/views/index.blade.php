@extends('layout.layout')

@section('title-page')
    Dandelion Fashion Shop
@endsection

@section('add-css')
    <style>
        .product-wrap-2 .product-img .product-action-2 a {
            padding: 5px;
            width: auto;
            height: auto;
        }

        .login-text {
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            vertical-align: middle;
        }
    </style>
@endsection

@section('add-js')
    <script type="text/javascript">

        function viewUkuran(IdProduk, ini) {
            //console.log(ini);
            $.ajax({
                type: "GET",
                url:  "{{ url('/shop/get-ukuran') }}/"+IdProduk+"/"+$(ini).val()+"/",
                success: function(data){
                    //console.log(msg);
                    var ukuran;
                    if(data.length != 0) {              
                        for(var j = 0; j < data.length; j++){
                            ukuran = ukuran+"<option value='"+data[j].IdUkuran+"'>"+data[j].NamaUkuran+"</option>";
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
                                            "<input type='hidden' id='IdProduk' value='"+msg.produk.IdProduk+"'>"+
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
                                                        `<select class='form-control' name="Warna" id='IdWarna' onchange='viewUkuran("`+msg.produk.IdProduk+`", this)'>`;

                                                        for(var i = 0; i < msg.warna.length; i++){
                                                            data = data+"<option value='"+msg.warna[i].IdWarna+"'>"+msg.warna[i].NamaWarna+"</option>";
                                                        }
                                                        
                                                    data = data+"</select>"+
                                                    "</div>"+
                                                "</div>"+
                                                "<div class='pro-details-color-wrap'>"+
                                                    "<span>Size</span>"+
                                                    "<div class='pro-details-color-content'>"+
                                                        "<select class='form-control' name='Ukuran'>";

                                                            for(var j = 0; j < msg.ukuran.length; j++){
                                                            data = data+"<option value='"+msg.ukuran[j].IdUkuran+"'>"+msg.ukuran[j].NamaUkuran+"</option>";
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
                @if (Auth::guard('web')->user())
                    <a class="account-satting-active" href="#"><i class="pe-7s-user-female"></i> - <span class="login-text">{{Auth::guard('web')->user()->NamaPelanggan}}</span></a>
                @else
                    <a class="account-satting-active" href="#"><i class="pe-7s-user-female"></i> - <span class="login-text">Login</span></a>
                @endif
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
                        <div class="same-style account-satting">
                            @if (Auth::guard('web')->user())
                                <a class="account-satting-active" href="#"><i class="pe-7s-user-female"></i> - <span>{{Auth::guard('web')->user()->NamaPelanggan}}</span></a>
                            @else
                                <a class="account-satting-active" href="#"><i class="pe-7s-user-female"></i> - <span>Login</span></a>
                            @endif
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

        <div class="product-area hm4-section-padding pt-80 pb-100">
            <div class="container-fluid">
                <div class="section-title text-center">
                    <h2>NEWEST PRODUCT!</h2>
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
                                                <a title="View Detail Product" href="/shop">Detail Product</a>
                                            </div>
                                        </div>
                                        <div class="product-content-2">
                                            <div class="title-price-wrap-2">
                                                <h3>{{ $produk->NamaProduk }}</h3>
                                                <div class="price-2">
                                                    <span>Rp. {{ number_format($produk->HargaJual,0,',',',') }}</span>
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
                                    <li><a href="/about">About us</a></li>
                                    <li><a href="/contact">Contact</a></li>
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
                                    <li><a href="#">Instagram</a></li>
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