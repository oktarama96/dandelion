@extends('layout.layout2')

@section('title-page')
    @if (!empty($produks))
        {{ $produks->NamaProduk }} - Dandelion Fashion Shop
    @else
        Tidak Ditemukan - Dandelion Fashion Shop
    @endif
    
@endsection

@section('add-js')
    @include('layout.js.cart')

    <script type="text/javascript">
        var dataUkuran = {!! $ukurans !!}
        var data_stok = []

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
                        $("#Qty").data("max", data[0].StokAkhir)
                        $("#QtyDetail").data("max", data[0].StokAkhir)
                        $("#Qty").val("1")
                        $("#QtyDetail").val("1")
                        dataUkuran = data
                        data_stok = data
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
                                                "<span>Rp. "+msg.produk.HargaJual.toLocaleString()+"</span>"+
                                            "</div>"+
                                            "<div class='pro-details-rating-wrap'>"+
                                            "</div>"+
                                            '<div class="pro-details-list">'+
                                                "<p>"+msg.produk.Deskripsi+"</p>"+
                                                "<br/>"+
                                                "<p>Berat : "+msg.produk.Berat+" Gram</p>"+
                                            '</div>'+
                                            "<div class='pro-details-size-color'>"+
                                                "<div class='pro-details-color-wrap'>"+
                                                    "<span>Warna</span>"+
                                                    "<div class='pro-details-color-content'>"+
                                                        `<select class='form-control' name="Warna" id='IdWarna' onchange='viewUkuran("`+msg.produk.IdProduk+`", this)'>`;

                                                        for(var i = 0; i < msg.warna.length; i++){
                                                            data = data+"<option value='"+msg.warna[i].IdWarna+"'>"+msg.warna[i].NamaWarna+"</option>";
                                                        }
                                                        
                                                    data = data+"</select>"+
                                                    "</div>"+
                                                "</div>"+
                                                "<div class='pro-details-color-wrap'>"+
                                                    "<span>Ukuran</span>"+
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
                                                    "<input class='cart-plus-minus-box' type='text' id='Qty' value='1' data-max='"+msg.ukuran[0].StokAkhir+"'>"+
                                                "</div>"+
                                                "<div class='pro-details-cart btn-hover'>"+
                                                    "<a href='#' onclick='addToCart()'>Add To Cart</a>"+
                                                "</div>"+
                                            "</div>"+
                                            '<div class="pro-details-meta">'+
                                                '<span>Kategori :</span>'+
                                                '<ul>'+
                                                    '<li><span>'+msg.produk.kategori.NamaKategori+'</span></li>'+
                                                '</ul>'+
                                            '</div>'+
                                        "</div>"+
                                    "</div>"+
                                "</div>";
                                                    
                    $("#detail").append(data);
                    data_stok = msg.ukuran                                   
                    
                    $("#IdUkuran").change(function(){
                        var selected_index = $(this).prop('selectedIndex')
                        $("#Qty").data("max", data_stok[selected_index].StokAkhir)
                        $("#Qty").val("1")
                    })
                    var CartPlusMinus = $('.cart-plus-minus');
                    CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
                    CartPlusMinus.append('<div class="inc qtybutton">+</div>');
                    $(".qtybutton").on("click", function () {
                        var $button = $(this);
                        var max = $button.parent().find("input").data("max")
                        var oldValue = $button.parent().find("input").val();
                        if ($button.text() === "+") {
                            var newVal = parseFloat(oldValue) + 1;
                            
                            if (newVal > max) {
                                newVal = max;
                            }
                        } else {
                            var newVal = parseFloat(oldValue) - 1;
                            // Don't allow decrementing below zero
                            if (newVal <= 0) {
                                var newVal = 1
                            } 
                        }
                        $button.parent().find("input").val(newVal);
                    });
                }
            });
        }

        $('#exampleModal').on('hidden.bs.modal', function(e){
            $('.append').remove(); 
        });

        $("#IdUkuranDetail").change(function(){
            var selected_index = $(this).prop('selectedIndex')
            $("#QtyDetail").data("max", dataUkuran[selected_index].StokAkhir)
            $("#QtyDetail").val("1")
        })

        var CartPlusMinus = $('.cart-plus-minus');
        CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
        CartPlusMinus.append('<div class="inc qtybutton">+</div>');
        $(".qtybutton").on("click", function () {
            var $button = $(this);
            var max = $button.parent().find("input").data("max")
            var oldValue = $button.parent().find("input").val();
            if ($button.text() === "+") {
                var newVal = parseFloat(oldValue) + 1;
                
                if (newVal > max) {
                    newVal = max;
                }
            } else {
                var newVal = parseFloat(oldValue) - 1;
                // Don't allow decrementing below zero
                if (newVal <= 0) {
                    var newVal = 1
                } 
            }
            $button.parent().find("input").val(newVal);
        });

    </script>
@endsection

@section('cart')
    @include('layout.cart')
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray-3">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li class="active">Shop Details </li>
                </ul>
            </div>
        </div>
    </div>
    @if (!empty($produks))
        <div class="shop-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-7 col-md-12">
                        <div class="product-details">
                            <div class="product-details-img">
                                <div id="shop-details-2" class="tab-pane active large-img-style">
                                    <img src="{{ asset('img/produk/'.$produks->GambarProduk) }}" alt="">
                                    
                                    <div class="img-popup-wrap">
                                        <a class="img-popup" href="{{ asset('img/produk/'.$produks->GambarProduk) }}"><i class="pe-7s-expand1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-lg-5 col-md-12">
                        <div class="product-details-content">
                            <h2>{{ $produks->NamaProduk }}</h2>
                            <div class="product-details-price">
                                <span>Rp. {{ number_format($produks->HargaJual,0,',',',') }}</span>
                            </div>
                            <div class='pro-details-rating-wrap'></div>
                            <div class="pro-details-list">
                                <p>{{ $produks->Deskripsi }}</p>
                                <br/>
                                <p>Berat : {{ $produks->Berat }} Gram</p>
                            </div>
                            <div class="pro-details-size-color">
                                <div class="pro-details-color-wrap">
                                    <span>Color</span>
                                    <div class="pro-details-color-content">
                                        <select class='form-control' name="Warna" id='IdWarnaDetail' onchange='viewUkuran("{{ $produks->IdProduk }}", this)'>
                                            @foreach ($warnas as $warna)
                                                <option value="{{ $warna->IdWarna }}">{{ $warna->NamaWarna }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="pro-details-color-wrap">
                                    <span>Size</span>
                                    <div class="pro-details-color-content">
                                        <select class='form-control' name='Ukuran' id='IdUkuranDetail'>
                                            @foreach ($ukurans as $ukuran)
                                                <option value="{{ $ukuran->IdUkuran }}">{{ $ukuran->NamaUkuran }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="pro-details-quality">
                                <div class="cart-plus-minus">
                                    <input id="QtyDetail" class="cart-plus-minus-box" type="text" value="1" data-max="{{ $ukurans[0]->StokAkhir }}">
                                </div>
                                <div class="pro-details-cart btn-hover">
                                    <a href="#" onclick='addToCart()'>Add To Cart</a>
                                </div>
                            </div>
                            <div class="pro-details-meta">
                                <span>Kategori :</span>
                                <ul>
                                    <li><span>{{ $produks->kategori->NamaKategori }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    <div class="related-product-area pb-95">
        <div class="container">
            <div class="section-title text-center mb-50">
                <h2>Produk Terkait</h2>
            </div>
            <div class="related-product-active owl-carousel">
                @foreach ($relatedproduks as $relatedproduk)
                    <div class="product-wrap">
                        <div class="product-img">
                            <a href="{{ url('/shop/product-detail/').'/'.$relatedproduk->IdProduk }}">
                                <img class="default-img" src="{{ asset('img/produk/'.$relatedproduk->GambarProduk) }}" alt="">
                                <img class="hover-img" src="{{ asset('img/produk/'.$relatedproduk->GambarProduk) }}" alt="">
                            </a>
                            <div class="product-action">
                                <div class="pro-same-action pro-cart">
                                    <a title="Add To Cart" href="#" data-toggle="modal" data-target="#exampleModal" onclick="detail('{{ $relatedproduk->IdProduk }}')"><i class="pe-7s-cart"></i> Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content text-center">
                            <h3><a href="{{ url('/shop/product-detail/').'/'.$relatedproduk->IdProduk }}">{{ $relatedproduk->NamaProduk }}</a></h3>
                            <div class="product-rating">
                            </div>
                            <div class="product-price">
                                <span>Rp. {{ number_format($relatedproduk->HargaJual,0,',',',') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
        <div class="error-area col-lg-12 pt-40 pb-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <div class="error">
                            <h1>204</h1>
                            <h2>OPPS! Konten Tidak Tersedia</h2>
                            <p>Maaf, konten produk dari Dandelion Fashion Shop tidak tersedia, kami akan bekerja untuk ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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