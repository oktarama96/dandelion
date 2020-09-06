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
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <style>
        .swal-text {
            background-color: #FEFAE3;
            padding: 17px;
            border: 1px solid #F0E1A1;
            display: block;
            margin: 22px;
            text-align: center;
            color: #61534e;
        }
    </style>
@endsection
@section('add-js')
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ !config('services.midtrans.isProduction') ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

    @include('layout.js.cart')

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
            order: [[1, 'DESC']],
            columns: [
                {data: 'IdTransaksi', name: 'IdTransaksi'},
                {data: 'TglTransaksi', name: 'TglTransaksi'},
                {data: 'Total', name: 'Total'},
                {data: 'Potongan', name: 'Potongan'},
                {data: 'OngkosKirim', name: 'OngkosKirim'},
                {data: 'NamaEkspedisi', name: 'NamaEkspedisi'},
                {data: 'GrandTotal', name: 'GrandTotal'},
                {data: 'StatusPembayaran', name: 'StatusPembayaran'},
                {data: 'StatusPesanan', name: 'StatusPesanan'},
                {data: 'Aksi', name: 'Aksi', orderable: false, searchable: false},
            ]
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

        function detail(a){
            var kode = 'IdTransaksi='+ a;
            $.ajax({
                type: "GET",
                url: "{{ url('/pos/detailtransaksi/') }}/"+a+"/",
                data: kode,
                success: function(msg){
                    // console.log(msg.detailtransaksi.length);

                    if(msg.detailtransaksi.length == 0){
                        document.getElementById("IdTransaksi").innerHTML = msg.transaksi[0].IdTransaksi;
                        $("input[name=IdTransaksi]").val(msg.transaksi[0].IdTransaksi);
                        document.getElementById("TglTransaksi").innerHTML = msg.transaksi[0].TglTransaksi;

                        document.getElementById("Total").innerHTML = "";
                        document.getElementById("OngkosKirim").innerHTML = "";
                        document.getElementById("Potongan").innerHTML = "";
                        document.getElementById("GrandTotal").innerHTML = "";

                        document.getElementById("NamaPelanggan").innerHTML = msg.transaksi[0].pelanggan.NamaPelanggan;
                        document.getElementById("Alamat").innerHTML = msg.transaksi[0].pelanggan.Alamat;
                        document.getElementById("Kota").innerHTML = msg.transaksi[0].pelanggan.NamaKecamatan +", "+ msg.transaksi[0].pelanggan.NamaKabupaten +", "+ msg.transaksi[0].pelanggan.NamaProvinsi;
                        document.getElementById("NoHandphone").innerHTML = msg.transaksi[0].pelanggan.NoHandphone;

                        
                        document.getElementById("btninvoice").innerHTML = "";

                     
                        
                        var dataa = '<tr class="border-bottom append">'+
                                        '<td colspan=4 >'+
                                            '<div class="font-weight-bold text-center">Maaf Data Produk Anda Tidak Tersedia!</div>'+
                                        '</td>'+
                                    '</tr>';

                    }else{
                        document.getElementById("IdTransaksi").innerHTML = msg.transaksi[0].IdTransaksi;
                        $("input[name=IdTransaksi]").val(msg.transaksi[0].IdTransaksi);
                        document.getElementById("TglTransaksi").innerHTML = msg.transaksi[0].TglTransaksi;

                        document.getElementById("Total").innerHTML = "Rp. "+msg.transaksi[0].Total.toLocaleString();
                        document.getElementById("OngkosKirim").innerHTML = "Rp. "+msg.transaksi[0].OngkosKirim.toLocaleString();
                        document.getElementById("Potongan").innerHTML = "Rp. "+msg.transaksi[0].Potongan.toLocaleString();
                        document.getElementById("GrandTotal").innerHTML = "Rp. "+msg.transaksi[0].GrandTotal.toLocaleString();

                        document.getElementById("NamaPelanggan").innerHTML = msg.transaksi[0].pelanggan.NamaPelanggan;
                        document.getElementById("Alamat").innerHTML = msg.transaksi[0].pelanggan.Alamat;
                        document.getElementById("Kota").innerHTML = msg.transaksi[0].pelanggan.NamaKecamatan +", "+ msg.transaksi[0].pelanggan.NamaKabupaten +", "+ msg.transaksi[0].pelanggan.NamaProvinsi;
                        document.getElementById("NoHandphone").innerHTML = msg.transaksi[0].pelanggan.NoHandphone;

                        if(msg.transaksi[0].StatusPesanan == 3)
                        document.getElementById("btninvoice").innerHTML = "<button type='button' class='btn btn-primary' id='cetak'>Cetak Invoice</button>";

                        var dataa = "";
                        for(var i = 0; i < msg.detailtransaksi.length; i++){
                            var dataa = '<tr class="border-bottom append">'+
                                            '<td>'+
                                                '<div class="font-weight-bold">'+msg.detailtransaksi[i].produk.NamaProduk+'</div>'+
                                                '<div class="small text-muted d-none d-md-block">'+msg.detailtransaksi[i].IdProduk+' - '+msg.detailtransaksi[i].stokproduk.warna.NamaWarna+' - '+msg.detailtransaksi[i].stokproduk.ukuran.NamaUkuran+'</div>'+
                                            '</td>'+
                                            '<td class="text-right font-weight-bold">Rp. '+msg.detailtransaksi[i].produk.HargaJual.toLocaleString()+'</td>'+
                                            '<td class="text-right font-weight-bold">'+msg.detailtransaksi[i].Qty+'</td>'+
                                            '<td class="text-right font-weight-bold">Rp. '+msg.detailtransaksi[i].SubTotal.toLocaleString()+'</td>'+
                                        '</tr>';
                        }
                    }
                
                    $("#detail-trans").prepend(dataa);
                    $("#cetak").on('click',function(e){
                        a = $("input[name=IdTransaksi]").val();

                        // console.log('asd');
                        window.location.href = "{{ url('/invoice/') }}/"+a+"/";
                    });
                }
            });
        }

        $('#pesanan').on('hidden.bs.modal', function(e){
            $('.append').remove();
            document.getElementById("IdTransaksi").innerHTML = "";
            $("input[name=IdTransaksi]").val("");
            document.getElementById("TglTransaksi").innerHTML = "";

            document.getElementById("Total").innerHTML = "";
            document.getElementById("OngkosKirim").innerHTML = "";
            document.getElementById("Potongan").innerHTML = "";
            document.getElementById("GrandTotal").innerHTML = "";

            document.getElementById("NamaPelanggan").innerHTML = "";
            document.getElementById("Alamat").innerHTML = "";
            document.getElementById("Kota").innerHTML = "";
            document.getElementById("NoHandphone").innerHTML = "";
            
            document.getElementById("btninvoice").innerHTML = "";
        });

        function pembayaran(token){    
            snap.show();
            snap.pay(token, {
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
        
        function pesanan(IdTransaksi){
            swal({
                title: "Apakah anda yakin ?",
                text: " Pastikan Barang yang sudah diterima dan sesuai. \n\n Jika ada keluhan, bisa menghubungi kontak yang tersedia.",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'PATCH',
                        url: "{{ url('/my-account/updatetransaksi/') }}/"+IdTransaksi+"/",
                        
                        success: function (data) {
                            $.ajax({
                                type: 'GET',
                                url: "{{ url('/mail/') }}/"+IdTransaksi+"/"
                            });
                            swal("Selamat!", "Pesanan Anda Sudah Selesai!", "success");
                            table.draw();
                        },
                        error: function (data) {
                            var errors = "";
                            $.each(data.responseJSON.errors, function(key,value) {
                                errors = errors +' '+ value +'\n';
                            });
                            
                            swal("Gagal!","Gagal Mengupdate Pesanan : \n"+errors+"","error");
                        },
                    });
                }
            });
        }
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
                                            <div class="account-info-wrapper" style="margin-bottom: 13px">
                                                <h4>Pesanan Yang Anda Pesan</h4>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-condense data-table" width="100%" cellspacing="0" style="white-space: nowrap;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Id Transaksi</th>
                                                                    <th>Tgl Transaksi</th>
                                                                    <th>Total</th>
                                                                    <th>Potongan</th>
                                                                    <th>Ongkos Kirim</th>
                                                                    <th>Nama Ekspedisi</th>
                                                                    <th>Grand Total</th>
                                                                    <th>Status Pembayaran</th>
                                                                    <th>Status Pesanan</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            
                                                            </tbody>
                                                        </table>
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
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->

    <!--Modal detail pesanan-->
    <div class="modal fade" id="pesanan" tabindex="-1" role="dialog" aria-labelledby="pesanan" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pesanan">Detail Pesanan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                      <!-- Invoice-->
                      <div class="card invoice">
                          <div class="card-header p-4 p-md-5 border-bottom-0">
                              <div class="row justify-content-between align-items-center">
                                  <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-left">
                                      <!-- Invoice branding-->
                                      <div class="h2 mb-0">Dandelion Fashion Shop</div>
                                  </div>
                                  <div class="col-12 col-lg-auto text-center text-lg-right">
                                      <!-- Invoice details-->
                                      <div class="h3">Id Transaksi : <div id="IdTransaksi"></div></div>
                                      <input type="hidden" name="IdTransaksi">
                                      <br />
                                      <div id="TglTransaksi"></div>
                                  </div>
                              </div>
                          </div>
                          <div class="card-body p-4 p-md-5">
                              <!-- Invoice table-->
                              <div class="table-responsive">
                                  <table class="table table-borderless mb-0">
                                      <thead class="border-bottom">
                                          <tr class="small text-uppercase text-muted">
                                              <th scope="col">Nama Barang</th>
                                              <th class="text-right" scope="col">Harga</th>
                                              <th class="text-right" scope="col">Qty</th>
                                              <th class="text-right" scope="col">SubTotal</th>
                                          </tr>
                                      </thead>
                                      <tbody id="detail-trans">                                          
                                        <!-- Invoice subtotal-->
                                        <tr>
                                            <td class="text-right pb-0" colspan="3"><div class="text-uppercase small font-weight-700 text-muted">Total:</div></td>
                                            <td class="text-right pb-0"><div class="h5 mb-0 font-weight-700" id="Total"></div></td>
                                        </tr>

                                        <!-- Invoice tax column-->
                                        <tr>
                                            <td class="text-right pb-0" colspan="3"><div class="text-uppercase small font-weight-700 text-muted">Ongkos Kirim:</div></td>
                                            <td class="text-right pb-0"><div class="h5 mb-0 font-weight-700" id="OngkosKirim"></div></td>
                                        </tr>

                                        <tr>
                                            <td class="text-right pb-0" colspan="3"><div class="text-uppercase small font-weight-700 text-muted">Potongan:</div></td>
                                            <td class="text-right pb-0"><div class="h5 mb-0 font-weight-700" id="Potongan"></div></td>
                                        </tr>
                                        <!-- Invoice total-->
                                        <tr>
                                            <td class="text-right pb-0" colspan="3"><div class="text-uppercase small font-weight-700 text-muted">Grandtotal:</div></td>
                                            <td class="text-right pb-0"><div class="h5 mb-0 font-weight-700 text-green" id="GrandTotal"></div></td>
                                        </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                          <div class="card-footer p-4 p-lg-5 border-top-0">
                              <div class="row">
                                  <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                                      <!-- Invoice - sent to info-->
                                      <div class="small text-muted text-uppercase font-weight-700 mb-2">Untuk</div>
                                      <div class="h6 mb-1">
                                        <div id="NamaPelanggan"></div>
                                      </div>
                                      <div class="small">
                                        <div id="Alamat"></div>
                                      </div>
                                      <div class="small">
                                        <div id="Kota"></div>
                                      </div>
                                      <div class="small">
                                        <div id="NoHandphone"></div>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                                      <!-- Invoice - sent from info-->
                                      <div class="small text-muted text-uppercase font-weight-700 mb-2">Dari</div>
                                      <div class="h6 mb-1">Dandelion Fashion Shop</div>
                                      <div class="small">Jln. Raya Abianbase No. 128</div>
                                      <div class="small">Mengwi, Badung, Bali</div>
                                      <div class="small">081246585269</div>
                                  </div>
                                  <div class="col-lg-4 my-auto text-center">
                                      <!-- Invoice - additional notes-->
                                      <div class="form-group">
                                        <div id="btninvoice"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Exit</button>
                </div>
            </div>
        </div>
    </div>
@endsection