@extends('layout.layout2')

@section('add-js')

    <script src="{{ !config('services.midtrans.isProduction') ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    
    <script type="text/javascript">
        var cost_jne = {!! json_encode($cost_jne) !!}
        var total = {{ $cart_total }};

        
        function formatNumber (num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
        }

        $( document ).ready(function() {
            $("#btn_checkout").click(function(){
                var formData = new FormData($('#checkout_form')[0]);
                console.log(formData)
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url:  "{{ url('/transaksi/online') }}/",
                    data: formData,
                    success: function(data){
                        snap.pay(data.snap_token, {
                            // Optional
                            onSuccess: function (result) {
                                location.reload();
                            },
                            // Optional
                            onPending: function (result) {
                                location.reload();
                            },
                            // Optional
                            onError: function (result) {
                                location.reload();
                            }
                        });

                    }
                })
            })

            $("#shipping_cost").change(function(){
                var val = $(this).val().split('-');

                var grand_total = parseInt(val[0]) + total
                $("#total_shipping").html('Rp' + formatNumber($(this).val()))
                $("#nama_ekspedisi").val(val[1])
                $("#total_order").html('Rp'+formatNumber(grand_total))
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
                        <a href="index.html">Home</a>
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
                        <h3>Billing Details</h3>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info mb-20">
                                    <label>First Name</label>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info mb-20">
                                    <label>Last Name</label>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Company Name</label>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-select mb-20">
                                    <label>Country</label>
                                    <select>
                                        <option>Select a country</option>
                                        <option>Azerbaijan</option>
                                        <option>Bahamas</option>
                                        <option>Bahrain</option>
                                        <option>Bangladesh</option>
                                        <option>Barbados</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Street Address</label>
                                    <input class="billing-address" placeholder="House number and street name" type="text">
                                    <input placeholder="Apartment, suite, unit etc." type="text">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Town / City</label>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info mb-20">
                                    <label>State / County</label>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info mb-20">
                                    <label>Postcode / ZIP</label>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info mb-20">
                                    <label>Phone</label>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info mb-20">
                                    <label>Email Address</label>
                                    <input type="text">
                                </div>
                            </div>
                        </div>
                        <div class="checkout-account mb-50">
                            <input class="checkout-toggle2" type="checkbox">
                            <span>Create an account?</span>
                        </div>
                        <div class="checkout-account-toggle open-toggle2 mb-30">
                            <input placeholder="Email address" type="email">
                            <input placeholder="Password" type="password">
                            <button class="btn-hover checkout-btn" type="submit">register</button>
                        </div>
                        <div class="additional-info-wrap">
                            <h4>Additional information</h4>
                            <div class="additional-info">
                                <label>Order notes</label>
                                <textarea placeholder="Notes about your order, e.g. special notes for delivery. " name="message"></textarea>
                            </div>
                        </div>
                        <div class="checkout-account mt-25">
                            <input class="checkout-toggle" type="checkbox">
                            <span>Ship to a different address?</span>
                        </div>
                        <div class="different-address open-toggle mt-30">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>First Name</label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>Last Name</label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-20">
                                        <label>Company Name</label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-select mb-20">
                                        <label>Country</label>
                                        <select>
                                            <option>Select a country</option>
                                            <option>Azerbaijan</option>
                                            <option>Bahamas</option>
                                            <option>Bahrain</option>
                                            <option>Bangladesh</option>
                                            <option>Barbados</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-20">
                                        <label>Street Address</label>
                                        <input class="billing-address" placeholder="House number and street name" type="text">
                                        <input placeholder="Apartment, suite, unit etc." type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-20">
                                        <label>Town / City</label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>State / County</label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>Postcode / ZIP</label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>Phone</label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>Email Address</label>
                                        <input type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                        <li><span class="order-middle-left"><b>{{ $produk->NamaProduk }}</b> Rp{{ number_format($produk->HargaJual, 0, '', '.') }} X {{ $produk->Qty }}<br> {{ $produk->NamaWarna }} / {{ $produk->NamaUkuran }} </span> <span class="order-price"><b>Rp{{ number_format($produk->sub_total, 0, '', '.') }} </b></span></li>
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
                                        <li>Rp{{ number_format($cart_total, 0, '', '.') }}</li>
                                        <input type="hidden" id="total_cart_val" name="Total" value="{{ $cart_total }}" />
                                        <input type="text" id="Total2" name="total_cart_val2" value="{{ $cart_total }}" />
                                    </ul>
                                </div>
                                <div class="your-order-bottom">
                                    <ul>
                                        <li class="your-order-shipping">Shipping (JNE)</li>
                                        <li>
                                            <div class='pro-details-color-content'>
                                                <select id="shipping_cost" class='form-control' name="OngkosKirim">
                                                    @foreach($cost_jne as $cost)
                                                    <option value='{{ $cost->cost[0]->value }}-{{ $cost->service }}'>{{ $cost->service }}/Rp{{ number_format($cost->cost[0]->value, 0, '', '.') }}/{{ $cost->cost[0]->etd }} hari</option>"
                                                    @endforeach
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="your-order-total">
                                    <ul>
                                        <li class="order-total">Shipping Cost</li>
                                        <li id="total_shipping">Rp{{ number_format($cost_jne[0]->cost[0]->value, 0, '', '.') }}</li>
                                        <input type="hidden" id="nama_ekspedisi" name="NamaEkspedisi" value="{{ $cost_jne[0]->service }}" />
                                    </ul>
                                </div>
                                <div class="your-order-total">
                                    <ul>
                                        <li class="order-total">Total</li>
                                        <li id="total_order">Rp{{ number_format($cart_total + $cost_jne[0]->cost[0]->value, 0, '', '.') }}</li>
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