@extends('layout.layout2')

@section('title-page')
    @if (!empty($pelanggans))
        Akun Saya - Dandelion Fashion Shop
    @else
        Tidak Ditemukan - Dandelion Fashion Shop
    @endif
@endsection

@section('add-css')
    <link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.standalone.min.css') }}" rel="stylesheet">
@endsection
@section('add-js')
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    @include('layout.js.cart')

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.tgl').datepicker({
            format: 'yyyy-mm-dd'
        });

        $("select[name='Provinsi']").on('change', function(){
            //alert(this.value);
            $("select[name='Kabupaten'] option").remove();
            $("select[name='Kecamatan'] option").remove();
            $("input[name='NamaProvinsi']").remove();
            $("input[name='NamaKabupaten']").remove();
            $("input[name='NamaKecamatan']").remove();
            $("select[name='Provinsi']").append("<input type='hidden' name='NamaProvinsi' value='"+this.options[this.selectedIndex].text+"'>"); 
            $.ajax({
                type: "POST",
                url: "{{ url('/my-account/add/provinsi/') }}/"+this.value+"/",
                data: "IdPropinsi="+this.value,
                success: function(msg){
                    var data = "<option value='-'>Pilih Kabupaten</option>";
                    for(i = 0; i < msg.results.length; i++){
                        data = data+"<option value='"+msg.results[i].id+"'>"+msg.results[i].name+"</option>"; 
                    };
                    $("select[name='Kabupaten']").append(data);
                }
            })
        })

        $("select[name='Kabupaten']").on('change', function(){
            //alert(this.value);
        
            $("select[name='Kecamatan'] option").remove();
            $("input[name='NamaKabupaten']").remove();
            $("input[name='NamaKecamatan']").remove();

            $("select[name='Kabupaten']").append("<input type='hidden' name='NamaKabupaten' value='"+this.options[this.selectedIndex].text+"'>"); 
            $.ajax({
                type: "POST",
                url: "{{ url('/my-account/add/kabupaten/') }}/"+this.value+"/",
                data: "IdKabupaten="+this.value,
                success: function(msg){
                    var data = "<option value='-'>Pilih Kecamatan</option>";
                    for(i = 0; i < msg.results.length; i++){
                        data = data+"<option value='"+msg.results[i].id+"'>"+msg.results[i].name+"</option>"; 
                    };

                    $("select[name='Kecamatan']").append(data);
                }
            })
        })

        $("select[name='Kecamatan']").on('change', function(){
            //alert(this.value);
            $("input[name='NamaKecamatan']").remove();
            $("select[name='Kecamatan']").append("<input type='hidden' name='NamaKecamatan' value='"+this.options[this.selectedIndex].text+"'>"); 
        })

        $('#edit').on('hidden.bs.modal', function (e) {
            $("select[name='Kabupaten'] option").remove();
            $("select[name='Kecamatan'] option").remove();
            $("input[name='NamaProvinsi']").remove();
            $("input[name='NamaKabupaten']").remove();
            $("input[name='NamaKecamatan']").remove();
        })

        $("#Update").click(function(e){
            e.preventDefault();

            a = $("input[name=IdPelanggan]").val();

            $.ajax({
                type: 'PATCH',
                url: "{{ url('/my-account/') }}/"+a+"/",
                data: $('#form-edit').serialize(),
                
                success: function (data) {
                    swal("Selamat!", "Berhasil Memperbaharui Data", "success");
                },
                error: function (data) {
                    var errors = "";
                    $.each(data.responseJSON.errors, function(key,value) {
                        errors = errors +' '+ value +'\n';
                    });
                    
                    swal("Gagal!","Gagal Mengubah Data : \n"+errors+"","error");
                },
            });
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
                        <a href="index.html">Home</a>
                    </li>
                    <li class="active">My Account </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="checkout-area pb-80 pt-100">
        <div class="container">
            <div class="row">
                <div class="ml-auto mr-auto col-lg-9">
                    <div class="checkout-wrapper">
                        <div id="faq" class="panel-group">
                            <div class="panel panel-default single-my-account">
                                <div class="panel-heading my-account-title">
                                    <h3 class="panel-title"><span>1 .</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Perbaharui Informasi Akun Anda </a></h3>
                                </div>
                                <div id="my-account-1" class="panel-collapse collapse show">
                                    <div class="panel-body">
                                        <div class="myaccount-info-wrapper">
                                            <div class="account-info-wrapper">
                                                <h4>Informasi Akun Anda</h4>
                                                <h5>Halo, {{ $pelanggans->NamaPelanggan }}</h5>
                                            </div>
                                            <form method="post" action="#" id="form-edit">
                                                <div class="row">
                                                    
                                                    <input type="hidden" name="IdPelanggan" value="{{ $pelanggans->IdPelanggan }}" required>
                                                
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Nama Pelanggan</label>
                                                            <input type="text" class="form-control" name="NamaPelanggan" value="{{ $pelanggans->NamaPelanggan }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="billing-info">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" name="Email" value="{{ $pelanggans->email }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="billing-info">
                                                            <label>Password</label>
                                                            <input type="password" class="form-control" name="Password" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="billing-info">
                                                            <label>Jenis Kelamin</label>
                                                            <select class="form-control" name="JenisKelamin" value="{{ $pelanggans->JenisKelamin }}">
                                                                <option value="Laki-laki">Laki-laki</option>
                                                                <option value="Perempuan">Perempuan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="billing-info">
                                                            <label>Tanggal Lahir</label>
                                                            <input type="text" class="form-control tgl" name="TglLahir" value="{{ $pelanggans->TglLahir }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="billing-info">
                                                            <label>No Handphone</label>
                                                            <input type="text" class="form-control" name="NoHandphone" value="{{ $pelanggans->NoHandphone }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Alamat</label>
                                                            <textarea name="Alamat" class="form-control">{{ $pelanggans->Alamat }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Provinsi</label>
                                                            <select class="form-control" name="Provinsi">
                                                                <option value="-">Pilih Provinsi</option>
                                                                @foreach ($provinsis as $provinsi)
                                                                    @if ($provinsi['id'] == $pelanggans->IdProvinsi) 
                                                                        <option value="{{ $provinsi['id'] }}" selected>{{ $provinsi['name'] }}</option>
                                                                    @else 
                                                                        <option value="{{ $provinsi['id'] }}">{{ $provinsi['name'] }}</option>
                                                                    @endif
                                                                @endforeach
                                                                <input type="hidden" name="NamaProvinsi" value="{{ $pelanggans->NamaProvinsi }}">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Kabupaten</label>
                                                            <select class="form-control" name="Kabupaten">
                                                                <option value="-">Pilih Kabupaten</option>
                                                                @foreach ($kabupatens['results'] as $kabupaten)
                                                                    @if ($kabupaten['id'] == $pelanggans->IdKabupaten)
                                                                        <option value="{{ $kabupaten['id'] }}" selected>{{ $kabupaten['name'] }}</option>
                                                                    @else
                                                                        <option value="{{ $kabupaten['id'] }}">{{ $kabupaten['name'] }}</option>
                                                                    @endif
                                                                @endforeach
                                                                <input type="hidden" name="NamaKabupaten" value="{{ $pelanggans->NamaKabupaten }}">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Kecamatan</label>
                                                            <select class="form-control" name="Kecamatan">
                                                                <option value="-">Pilih Kecamatan</option>
                                                                @foreach ($kecamatans['results'] as $kecamatan)
                                                                    @if ($kecamatan['id'] == $pelanggans->IdKecamatan)
                                                                        <option value="{{ $kecamatan['id'] }}" selected>{{ $kecamatan['name'] }}</option>
                                                                    @else
                                                                        <option value="{{ $kecamatan['id'] }}">{{ $kecamatan['name'] }}</option>
                                                                    @endif
                                                                @endforeach
                                                                <input type="hidden" name="NamaKecamatan" value="{{ $pelanggans->NamaKecamatan }}">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                    <a href="#"><i class="fa fa-arrow-up"></i> back</a>
                                                </div>
                                                <div class="billing-btn">
                                                    <button type="button" id="Update">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default single-my-account">
                                <div class="panel-heading my-account-title">
                                    <h3 class="panel-title"><span>2 .</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Pesanan Anda </a></h3>
                                </div>
                                <div id="my-account-2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="myaccount-info-wrapper">
                                            <div class="account-info-wrapper">
                                                <h4>Pesanan Yang Anda Pesan</h4>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Password</label>
                                                        <input type="password">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default single-my-account">
                                <div class="panel-heading my-account-title">
                                    <h3 class="panel-title"><span>3 .</span> <a href="{{ url('/shop/cart') }}">Keranjang Belanja Anda   </a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="tab-content quickview-big-img">
                                <div id="pro-1" class="tab-pane fade show active">
                                    <img src="assets/img/product/quickview-l1.jpg" alt="">
                                </div>
                                <div id="pro-2" class="tab-pane fade">
                                    <img src="assets/img/product/quickview-l2.jpg" alt="">
                                </div>
                                <div id="pro-3" class="tab-pane fade">
                                    <img src="assets/img/product/quickview-l3.jpg" alt="">
                                </div>
                                <div id="pro-4" class="tab-pane fade">
                                    <img src="assets/img/product/quickview-l2.jpg" alt="">
                                </div>
                            </div>
                            <!-- Thumbnail Large Image End -->
                            <!-- Thumbnail Image End -->
                            <div class="quickview-wrap mt-15">
                                <div class="quickview-slide-active owl-carousel nav nav-style-1" role="tablist">
                                    <a class="active" data-toggle="tab" href="#pro-1"><img src="assets/img/product/quickview-s1.jpg" alt=""></a>
                                    <a data-toggle="tab" href="#pro-2"><img src="assets/img/product/quickview-s2.jpg" alt=""></a>
                                    <a data-toggle="tab" href="#pro-3"><img src="assets/img/product/quickview-s3.jpg" alt=""></a>
                                    <a data-toggle="tab" href="#pro-4"><img src="assets/img/product/quickview-s2.jpg" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="product-details-content quickview-content">
                                <h2>Products Name Here</h2>
                                <div class="product-details-price">
                                    <span>$18.00 </span>
                                    <span class="old">$20.00 </span>
                                </div>
                                <div class="pro-details-rating-wrap">
                                    <div class="pro-details-rating">
                                        <i class="fa fa-star-o yellow"></i>
                                        <i class="fa fa-star-o yellow"></i>
                                        <i class="fa fa-star-o yellow"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                    <span>3 Reviews</span>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisic elit eiusm tempor incidid ut labore et dolore magna aliqua. Ut enim ad minim venialo quis nostrud exercitation ullamco</p>
                                <div class="pro-details-list">
                                    <ul>
                                        <li>- 0.5 mm Dail</li>
                                        <li>- Inspired vector icons</li>
                                        <li>- Very modern style  </li>
                                    </ul>
                                </div>
                                <div class="pro-details-size-color">
                                    <div class="pro-details-color-wrap">
                                        <span>Color</span>
                                        <div class="pro-details-color-content">
                                            <ul>
                                                <li class="blue"></li>
                                                <li class="maroon active"></li>
                                                <li class="gray"></li>
                                                <li class="green"></li>
                                                <li class="yellow"></li>
                                                <li class="white"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="pro-details-size">
                                        <span>Size</span>
                                        <div class="pro-details-size-content">
                                            <ul>
                                                <li><a href="#">s</a></li>
                                                <li><a href="#">m</a></li>
                                                <li><a href="#">l</a></li>
                                                <li><a href="#">xl</a></li>
                                                <li><a href="#">xxl</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-details-quality">
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" type="text" name="qtybutton" value="2">
                                    </div>
                                    <div class="pro-details-cart btn-hover">
                                        <a href="#">Add To Cart</a>
                                    </div>
                                    <div class="pro-details-wishlist">
                                        <a href="#"><i class="fa fa-heart-o"></i></a>
                                    </div>
                                    <div class="pro-details-compare">
                                        <a href="#"><i class="pe-7s-shuffle"></i></a>
                                    </div>
                                </div>
                                <div class="pro-details-meta">
                                    <span>Categories :</span>
                                    <ul>
                                        <li><a href="#">Minimal,</a></li>
                                        <li><a href="#">Furniture,</a></li>
                                        <li><a href="#">Electronic</a></li>
                                    </ul>
                                </div>
                                <div class="pro-details-meta">
                                    <span>Tag :</span>
                                    <ul>
                                        <li><a href="#">Fashion, </a></li>
                                        <li><a href="#">Furniture,</a></li>
                                        <li><a href="#">Electronic</a></li>
                                    </ul>
                                </div>
                                <div class="pro-details-social">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                        <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
@endsection