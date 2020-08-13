@extends('layout.layout2')

@section('title-page')
    Checkout - Dandelion Fashion Shop
@endsection

@section('add-js')

    <script src="{{ !config('services.midtrans.isProduction') ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var cost_jne = {!! json_encode($cost_jne) !!}
        var total = {{ $cart_total }};

        
        function formatNumber (num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
        }

        $("#CekKupon").click(function() {
            var id_coupon = $("input[name='IdKuponDiskon']").val();

            $.ajax({
                type: "POST",
                url:  "{{ url('/shop/cek-kupon') }}/",
                data: "IdKuponDiskon="+id_coupon,
                success: function(data){
                    // console.log(data);
                    if(data.kupondiskon == null){
                        $("#alert-kupon").html('<div class="alert alert-danger alert-dismissible" id="myAlert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Gagal!</strong> Kode Kupon tersebut tidak tersedia.</div>');
                        
                        var potongan = 0;
                        $("#NamaPotongan").html("-")
                        $("#JumlahPotongan").html("0")
                        $("#id_kupon").val("-")
                        $("#potongan").val(0)

                    }else{
                        // console.log(data.MinimalTotal);
                        if($('#total_cart_val').val() < data.kupondiskon.MinimalTotal){
                            $("#alert-kupon").html('<div class="alert alert-danger alert-dismissible" id="myAlert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Gagal!</strong> Anda tidak memenuhi syarat Minimal Belanja.</div>');
                        
                            var potongan = 0;
                            $("#NamaPotongan").html("-")
                            $("#JumlahPotongan").html("0")
                            $("#id_kupon").val("-")
                            $("#potongan").val(0)
                        }else{
                            $("#alert-kupon").html('<div class="alert alert-success alert-dismissible" id="myAlert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Berhasil!</strong> Kode Kupon tersebut berhasil digunakan.</div>');
                            
                            var potongan = data.kupondiskon.JumlahPotongan;
                            $("#NamaPotongan").html(data.kupondiskon.NamaKupon)
                            $("#JumlahPotongan").html(new Number(data.kupondiskon.JumlahPotongan).toLocaleString())
                            $("#id_kupon").val(data.kupondiskon.IdKuponDiskon)
                            $("#potongan").val(data.kupondiskon.JumlahPotongan)
                        }
                    }

                    var val = $("#shipping_cost").val().split('-');
                    var grand_total = ((parseInt(val[0]) + total) - potongan);

                    $("#total_order").html('Rp. '+formatNumber(grand_total))
                    $("#total_order_val").val(grand_total)
                }
            })
        });

        function delete_coupon() {
            swal({
                title: "Apakah anda yakin ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#NamaPotongan").html("-")
                    $("#JumlahPotongan").html("0")
                    $("#id_kupon").val("-")
                    $("#potongan").val(0)

                    var potongan = 0;
                    var val = $("#shipping_cost").val().split('-');
                    var grand_total = ((parseInt(val[0]) + total) - potongan);

                    $("#total_order").html('Rp. '+formatNumber(grand_total))
                    $("#total_order_val").val(grand_total)
                }
            });
        }

        $( document ).ready(function() {
            $("#btn_checkout").click(function(){
                swal({
                    title: "Apakah anda yakin ?",
                    text: " Pastikan Pesanan Anda Sudah Sesuai.",
                    icon: "info",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var formData = new FormData($('#checkout_form')[0]);
                        // console.log(formData)
                        $.ajax({
                            type: "POST",
                            processData: false,
                            contentType: false,
                            url:  "{{ url('/transaksi/online') }}/",
                            data: formData,
                            success: function(data){
                                
                                if(data.error){
                                    swal("Gagal!", data.error, "error")
                                    .then((value) => {
                                        window.location.replace("{{ route('cart') }}");
                                    });
                                }else{
                                    snap.pay(data.snap_token, {
                                        // Optional
                                        onSuccess: function (result) {
                                            window.location.replace("{{ route('shop') }}");
                                        },
                                        // Optional
                                        onPending: function (result) {
                                            window.location.replace("{{ route('shop') }}");
                                        },
                                        // Optional
                                        onError: function (result) {
                                            window.location.replace("{{ route('shop') }}");
                                        }
                                    });
                                }
                                

                            }
                        })
                    }
                });
            })

            $("#shipping_cost").change(function(){
                var val = $(this).val().split('-');
                var potongan = $("#potongan").val();

                var grand_total = (parseInt(val[0]) + total) - potongan
                $("#total_shipping").html('Rp. ' + formatNumber(val[0]))
                $("#nama_ekspedisi").val('JNE - '+val[1])
                $("#total_order").html('Rp. '+formatNumber(grand_total))
                $("#total_order_val").val(grand_total)
            })
        });
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
                    <li class="active">Checkout </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="checkout-area pt-95 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="billing-info-wrap">
                        <h3>Detail Pengiriman</h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Nama Pelanggan</label>
                                    <input type="text" name="NamaPelanggan" value="{{Auth::guard('web')->user()->NamaPelanggan}}" readonly>
                                    <input type="hidden" name="IdPelanggan" value="{{Auth::guard('web')->user()->IdPelanggan}}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Email</label>
                                    <input type="email" name="Email" value="{{Auth::guard('web')->user()->email}}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Alamat</label>
                                    <input type="text" name="Alamat" value="{{Auth::guard('web')->user()->Alamat}}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="billing-info mb-20">
                                    <label>Nama Kecamatan</label>
                                    <input type="text" name="NamaKecamatan" value="{{Auth::guard('web')->user()->NamaKecamatan}}" readonly>
                                    <input type="hidden" name="IdKecamatan" value="{{Auth::guard('web')->user()->IdKecamatan}}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="billing-info mb-20">
                                    <label>Nama Kabupaten</label>
                                    <input type="text" name="NamaKabupaten" value="{{Auth::guard('web')->user()->NamaKabupaten}}" readonly>
                                    <input type="hidden" name="IdKabupaten" value="{{Auth::guard('web')->user()->IdKabupaten}}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="billing-info mb-20">
                                    <label>Nama Provinsi</label>
                                    <input type="text" name="NamaProvinsi" value="{{Auth::guard('web')->user()->NamaProvinsi}}" readonly>
                                    <input type="hidden" name="IdProvinsi" value="{{Auth::guard('web')->user()->IdProvinsi}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="billing-info-wrap">
                        <h3>Punya Kode Kupon Diskon ?</h3>
                        <div class="billing-info checkout-account-toggle mb-20">
                            <form id="coupon_form" action="#" method="POST">
                                <label>Masukan Disini</label>
                                <input type="text" name="IdKuponDiskon" placeholder="Ex: DFS10">
                                <button class="btn-hover checkout-btn" type="button" id="CekKupon">Check</button>
                            </form>
                        </div>
                        <div id="alert-kupon"></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="your-order-area">
                        <h3>Your order</h3>
                        <form id="checkout_form" action="#" method="POST">
                        @csrf
                        <div class="your-order-wrap gray-bg-4">
                            <div class="your-order-product-info">
                                <div class="your-order-top">
                                    <ul>
                                        <li>Product</li>
                                        <li>Total</li>
                                    </ul>
                                </div>
                                <div class="your-order-middle">
                                    <ul>
                                        @foreach($cart_produk as $produk)
                                        <li>
                                            <span class="order-middle-left"><b>{{ $produk->NamaProduk }}</b></span>
                                            <span class="order-middle-left">{{ $produk->NamaWarna }} / {{ $produk->NamaUkuran }} </span>
                                            <span class="order-middle">Rp. {{ number_format($produk->HargaJual, 0, '', '.') }} X {{ $produk->Qty }}</span>
                                            <span class="order-price"><b>Rp. {{ number_format($produk->sub_total, 0, '', '.') }} </b></span>
                                        </li>
                                        <input type="hidden" name="IdProduk[]" value="{{ $produk->IdProduk }}"/>
                                        <input type="hidden" name="IdStokProduk[]" value="{{ $produk->IdStokProduk }}"/>
                                        <input type="hidden" name="Qty[]" value="{{ $produk->Qty }}"/>
                                        <input type="hidden" name="SubTotal[]" value="{{ $produk->sub_total }}"/>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="your-order-total">
                                    <ul>
                                        <li class="order-total">Sub Total</li>
                                        <li>Rp. {{ number_format($cart_total, 0, '', '.') }}</li>
                                        <input type="hidden" id="total_cart_val" name="Total" value="{{ $cart_total }}" />
                                    </ul>
                                </div>
                                <div class="your-order-total">
                                    <ul>
                                        <li class="order-total">Coupon Code</li>
                                        <li>
                                            <div class="shopping-cart-delete text-right">
                                                <span id="NamaPotongan">-</span>
                                                <input type="hidden" id="id_kupon" name="IdKuponDiskon" value="-"/>
                                                <a href="#" onclick="delete_coupon()"><i class="fa fa-times-circle"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="order-total">Discount</li>
                                        <li>- Rp. <span id="JumlahPotongan">0</span></li>
                                        <input type="hidden" id="potongan" name="Potongan" value=0 />
                                    </ul>
                                </div>
                                <div class="your-order-total">
                                    <ul>
                                        <li class="your-order-shipping" style="font-weight: 500;color: #212121;font-size: 18px;">Shipping (JNE)</li>
                                        <li>
                                            <div class='pro-details-color-content'>
                                                <select id="shipping_cost" class='form-control' name="OngkosKirim">
                                                    @foreach($cost_jne as $cost)
                                                    <option value='{{ $cost->cost[0]->value }}-{{ $cost->service }}'>{{ $cost->service }} / Rp. {{ number_format($cost->cost[0]->value, 0, '', '.') }} / {{ $cost->cost[0]->etd }} hari</option>"
                                                    @endforeach
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="your-order-total">
                                    <ul>
                                        <li class="order-total">Shipping Cost</li>
                                        <li id="total_shipping">Rp. {{ number_format($cost_jne[0]->cost[0]->value, 0, '', '.') }}</li>
                                        <input type="hidden" id="nama_ekspedisi" name="NamaEkspedisi" value="JNE - {{ $cost_jne[0]->service }}" />
                                    </ul>
                                </div>
                                <div class="your-order-total">
                                    <ul>
                                        <li class="order-total">Total</li>
                                        <li id="total_order">Rp. {{ number_format($cart_total + $cost_jne[0]->cost[0]->value, 0, '', '.') }}</li>
                                        <input type="hidden" name="GrandTotal" id="total_order_val" value="{{ ($cart_total + $cost_jne[0]->cost[0]->value) }}" />
                                    </ul>
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="Place-order mt-25">
                            <a class="btn-hover" id="btn_checkout" href="#">CHECKOUT</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection