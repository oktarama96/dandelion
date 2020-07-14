@extends('layout.layout')

@section('title-page')
    Shop - Dandelion Fashion Shop
@endsection

@section('add-js')
    <script type="text/javascript">
        $("#form-filter input[type=checkbox]").click(function(){
            $("#form-filter").submit();
        })
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
                                                        "<select class='form-control' id='IdWarna' onchange='viewUkuran(this)'>";

                                                        for(var i = 0; i < msg.stokproduk.length; i++){
                                                            data = data+"<option value='"+msg.stokproduk[i].IdWarna+"'>"+msg.stokproduk[i].warna.NamaWarna+"</option>";
                                                        }
                                                        
                                                    data = data+"</select>"+
                                                    "</div>"+
                                                "</div>"+
                                                "<div class='pro-details-color-wrap'>"+
                                                    "<span>Size</span>"+
                                                    "<div class='pro-details-color-content'>"+
                                                        "<select class='form-control' id='IdUkuran'>";

                                                            for(var j = 0; j < msg.stokproduk.length; j++){
                                                            data = data+"<option value='"+msg.stokproduk[j].IdUkuran+"'>"+msg.stokproduk[j].ukuran.NamaUkuran+"</option>";
                                                        }
                                                        
                                                    data = data+"</select>"+
                                                    "</div>"+
                                                "</div>"+
                                            "</div>"+
                                            "<div class='pro-details-quality'>"+
                                                "<div class='cart-plus-minus'>"+
                                                    "<input class='cart-plus-minus-box' type='number' id='Qty' value='1'>"+
                                                "</div>"+
                                                "<div class='pro-details-cart btn-hover'>"+
                                                    "<a href='#' onclick='addToCart()'>Add To Cart</a>"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";

                    $("#detail").append(data);
                }
            })
        }

        function addToCart(){
            alert($('#IdProduk').val() + " " + $('#IdWarna').val() + " " + $('#IdUkuran').val() + " " + $('#Qty').val())

        }

        $('#exampleModal').on('hidden.bs.modal', function(e){
            $('.append').remove(); 
        });

    </script>
@endsection

@section('content')
    <header class="header-area header-in-container clearfix">
        <div class="header-bottom sticky-bar header-res-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-6 col-4">
                        <div class="logo">
                            <a href="/">
                                <img alt="" src="assets/img/logo/logo.png">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 d-none d-lg-block">
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li><a href="/">Home</a></li>
                                    <li><a href="/shop">Shop</a></li>
                                    <li><a href="/about">About </a></li>
                                    <li><a href="/contact">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-8">
                        <div class="header-right-wrap">
                            <div class="same-style account-satting">
                                <a class="account-satting-active" href="#"><i class="pe-7s-user-female"></i></a>
                                <div class="account-dropdown">
                                    <ul>
                                        <li><a href="login-register.html">Login</a></li>
                                        <li><a href="login-register.html">Register</a></li>
                                        <li><a href="my-account.html">my account</a></li>
                                    </ul>
                                </div>
                            </div>
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
                        </div>
                    </div>
                </div>
                <div class="mobile-menu-area">
                    <div class="mobile-menu">
                        <nav id="mobile-menu-active">
                            <ul class="menu-overflow">
                                <li><a href="/">Home</a></li>
                                <li><a href="/shop">Shop</a></li>
                                <li><a href="/about">About us</a></li>
                                <li><a href="/contact">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="breadcrumb-area pt-35 pb-35 bg-gray-3">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li class="active">Shop </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="shop-area pt-95 pb-100">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9">
                    <div class="shop-top-bar">
                        <div class="select-shoing-wrap">
                            <div class="shop-select">
                                <select>
                                    <option value="">Sort by newness</option>
                                    <option value="">A to Z</option>
                                    <option value=""> Z to A</option>
                                    <option value="">In stock</option>
                                </select>
                            </div>
                            <p>Showing 1–12 of 20 result</p>
                        </div>
                    </div>
                    <div class="shop-bottom-area mt-35">
                        <div class="tab-content jump">
                            <div id="shop-1" class="tab-pane active">
                                <div class="row">
                                    @foreach ($produks as $produk)
                                        <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
                                            <div class="product-wrap mb-25 scroll-zoom">
                                                <div class="product-img">
                                                    <a href="/shop/product-detail/{{ $produk->IdProduk }}">
                                                        <img class="default-img" src="img/produk/{{ $produk->GambarProduk }}" alt="">
                                                        <img class="hover-img" src="img/produk/{{ $produk->GambarProduk }}" alt="">
                                                    </a>
                                                    <div class="product-action">
                                                        <div class="pro-same-action pro-quickview">
                                                            <a title="Add To Cart" href="#"><i class="pe-7s-cart"></i></a>
                                                        </div>
                                                        <div class="pro-same-action pro-quickview">
                                                            <a title="Quick View" href="#" data-toggle="modal" data-target="#exampleModal" onclick="detail('{{ $produk->IdProduk }}')"><i class="pe-7s-look"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-content text-center">
                                                    <h3>{{ $produk->NamaProduk }}</h3>
                                                    <div class="product-rating">
                                                        <i class="fa fa-star-o yellow"></i>
                                                        <i class="fa fa-star-o yellow"></i>
                                                        <i class="fa fa-star-o yellow"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="product-price">
                                                        <span>Rp. {{ $produk->HargaJual }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="pro-pagination-style text-center mt-30">
                            {{-- <ul>
                                <li><a class="prev" href="#"><i class="fa fa-angle-double-left"></i></a></li>
                                <li><a class="active" href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a class="next" href="#"><i class="fa fa-angle-double-right"></i></a></li>
                            </ul> --}}
                            {{ $produks->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <form id="form-filter" method="post" action='http://127.0.0.1:8000/shop'>
                    @csrf
                    <div class="sidebar-style mr-30">
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title">Search </h4>
                            <div class="pro-sidebar-search mb-50 mt-25">
                                <form class="pro-sidebar-search-form" action="#">
                                    <input name="search" value="{{ $filter['search'] }}" type="text" placeholder="Search here...">
                                    <button>
                                        <i class="pe-7s-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!--<div class="sidebar-widget mt-45">
                            <h4 class="pro-sidebar-title">Filter By Price </h4>
                            <div class="price-filter mt-10">
                                <div class="price-slider-amount">
                                    <input type="text" id="amount" name="price"  placeholder="Add Your Price" />
                                </div>
                                <div id="slider-range"></div>
                            </div>
                        </div>-->
                        <div class="sidebar-widget mt-50">
                            <h4 class="pro-sidebar-title">Colour </h4>
                            <div class="sidebar-widget-list mt-20">
                                <ul>
                                    @foreach ($warnas as $warna)
                                        <li>
                                            <div class="sidebar-widget-list-left">
                                                <input name="warna[]" type="checkbox" {{ (in_array($warna->IdWarna, $filter['warna']))?"checked":"" }} value="{{ $warna->IdWarna }}"><a href="#">{{ $warna->NamaWarna }}</a>
                                                <span class="checkmark"></span> 
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget mt-40">
                            <h4 class="pro-sidebar-title">Size </h4>
                            <div class="sidebar-widget-list mt-20">
                                <ul>
                                    @foreach ($ukurans as $ukuran)
                                        <li>
                                            <div class="sidebar-widget-list-left">
                                                <input name="ukuran[]" type="checkbox" {{ (in_array($ukuran->IdUkuran, $filter['ukuran']))?"checked":"" }} value="{{ $ukuran->IdUkuran }}"><a href="#">{{ $ukuran->NamaUkuran }}</a>
                                                <span class="checkmark"></span> 
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget mt-40">
                            <h4 class="pro-sidebar-title">Categories </h4>
                            <div class="sidebar-widget-list mt-20">
                                <ul>
                                    @foreach ($kategoris as $kategori)
                                    <!--<li><a href="#">{{ $kategori->NamaKategori }}</a></li>-->
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input name="kategori[]" type="checkbox" {{ (in_array($kategori->IdKategoriProduk, $filter['kategori']))?"checked":"" }} value="{{ $kategori->IdKategoriProduk }}"><a href="#">{{ $kategori->NamaKategori }}</a>
                                            <span class="checkmark"></span> 
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer-area bg-gray pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="copyright mb-30">
                        <div class="footer-logo">
                            <a href="/">
                                <img alt="" src="assets/img/logo/logo.png">
                            </a>
                        </div>
                        <p>© 2020 <a href="#">Dandelion Fashion Shop</a>.<br> All Rights Reserved</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="footer-widget mb-30 ml-30">
                        <div class="footer-title">
                            <h3>ABOUT US</h3>
                        </div>
                        <div class="footer-list">
                            <ul>
                                <li><a href="about.html">About us</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-widget mb-30 ml-75">
                        <div class="footer-title">
                            <h3>FOLLOW US</h3>
                        </div>
                        <div class="footer-list">
                            <ul>
                                <li><a href="#">Facebook</a></li>
                                <li><a href="#">Instagram</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body" id="detail">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
@endsection


