@extends('layout.layout2')

@section('title-page')
    Shop - Dandelion Fashion Shop
@endsection

@section('add-css')

    <style>
        .page-item.active .page-link {
            background-color: #a749ff;
            border-color: #a749ff;
            color: #fff;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
    </style>
    
@endsection

@section('add-js')
    <script type="text/javascript">
        $("#form-filter input[type=checkbox]").click(function(){
            $("#form-filter").submit();
        })

        function formatNumber (num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
        }


        var cart_produk = {!! $cart_produk !!}
        var cart_total = {{ $cart_total }}

        function delete_cart(delete_cart){
            key = $('.delete_cart').index($(delete_cart))

            alert(cart_produk[key].NamaProduk)
            $.ajax({
                type: "GET",
                url:  "{{ url('/shop/delete-cart') }}/"+cart_produk[key].IdCart,
                success: function(msg){
                    
                    cart_total-=cart_produk[key].sub_total
                    cart_produk.splice(key, 1)

                    $('#cart_total').html('Rp'+formatNumber(cart_total))
                    $('#cart_count').html(cart_produk.length)
                    $('#cart_content li').eq(key).remove()

                    alert('sukses menghapus item dari cart')
                }
            });
        }
        
        function addToCart(){
            alert($('#IdProduk').val() + " " + $('#IdWarna').val() + " " + $('#IdUkuran').val() + " " + $('#Qty').val())

            data = {
                "_token": "{{ csrf_token() }}",
                'IdProduk': $('#IdProduk').val(),
                'IdWarna': $('#IdWarna').val(),
                'IdUkuran': $('#IdUkuran').val(),
                'Qty': $('#Qty').val(),
            }

            $.ajax({
                type: "POST",
                url:  "{{ url('/shop/add-cart') }}/",
                data: data,
                success: function(data){
                    var new_item = true
                    var sub_total = data.sub_total
                    var key = -1;

                    cart_produk.forEach(function(produk, index){
                        if(produk.IdCart == data.IdCart){
                            new_item = false
                            sub_total -= produk.sub_total
                            cart_produk[index] = data
                            key = index
                        }
                    })

                    if(new_item){
                        cart_produk.push(data)
                    }
                    
                    cart_count = cart_produk.length
                    cart_total+=sub_total

                    content = `
                    <li class="single-shopping-cart">
                        <div class="shopping-cart-img">
                            <a href="#"><img alt="" width="82px" height="82px" src="img/produk/`+ data.GambarProduk +`"></a>
                        </div>
                        <div class="shopping-cart-title">
                            <h4><a href="#">`+ data.NamaProduk +`(`+data.NamaWarna+`/`+data.NamaUkuran+`)</a></h4>
                            <h6 class='qty'>Qty: `+ data.Qty +`</h6>
                            <span class='sub_total'>Rp`+ formatNumber(data.sub_total) +`</span>
                        </div>
                        <div class="shopping-cart-delete">
                            <a href="#" class='delete_cart' onclick="delete_cart(this)"><i class="fa fa-times-circle"></i></a>
                        </div>
                    </li>
                    `   

                    $('#cart_total').html('Rp'+formatNumber(cart_total))
                    $('#cart_count').html(cart_count)
                    
                    if(new_item){
                        alert('new item')
                        $('#cart_content').append(content)
                    } else {
                        $('#cart_content .qty').eq(key).html('Qty: '+ data.Qty)
                        $('#cart_content .sub_total').eq(key).html('Rp: '+ formatNumber(data.sub_total))
                    }
                    alert('sukses menambah item ke cart')
                }
            });
        }

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
                url: "{{ url('/shop/get-warna') }}/"+a+"/",
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
                                                        "<select class='form-control' name='Ukuran' id='IdUkuran'>";

                                                        for(var j = 0; j < msg.ukuran.length; j++){
                                                            data = data+"<option value='"+msg.ukuran[j].IdUkuran+"'>"+msg.ukuran[j].NamaUkuran+"</option>";
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

        $('#exampleModal').on('hidden.bs.modal', function(e){
            $('.append').remove(); 
        });

    </script>
@endsection

@section('cart')

    @if (Auth::guard('web')->user())
        <div class="same-style cart-wrap">
            <button class="icon-cart">
                <i class="pe-7s-shopbag"></i>
                <span class="count-style" id='cart_count'>{{ count($cart_produk) }}</span>
            </button>
            <div class="shopping-cart-content">
                <ul id="cart_content">
                    @foreach($cart_produk as $key=>$produk)
                    <li class="single-shopping-cart">
                        <div class="shopping-cart-img">
                            <a href="#"><img alt="" width="82px" height="82px" src="img/produk/{{ $produk->GambarProduk }}"></a>
                        </div>
                        <div class="shopping-cart-title">
                            <h4><a href="#">{{ $produk->NamaProduk }} ({{ $produk->NamaWarna }}/{{ $produk->NamaUkuran }}) </a></h4>
                            <h6 class='qty'>Qty: {{ $produk->Qty }}</h6>
                            <span class='sub_total'>Rp{{ number_format($produk->sub_total,0,"",".") }}</span>
                        </div>
                        <div class="shopping-cart-delete">
                            <a href="#" class="delete_cart" onclick="delete_cart(this)"><i class="fa fa-times-circle"></i></a>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="shopping-cart-total">
                    <h4>Total : <span class="shop-total" id="cart_total">Rp{{ number_format($cart_total,0,"",".") }}</span></h4>
                </div>
                <div class="shopping-cart-btn btn-hover text-center">
                    <a class="default-btn" href="cart-page.html">view cart</a>
                    <a class="default-btn" href="/shop/checkout">checkout</a>
                </div>
            </div>
        </div>
    @endif
    
@endsection

@section('content')
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
                        <div class="pro-pagination-style row justify-content-center mt-30">
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
@endsection

@section('modal')
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


