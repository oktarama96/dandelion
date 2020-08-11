@extends('pos.layout.layout')
@section('title-page')
    POS - Data Transaksi
@endsection
@section('add-css')
    <!-- Custom styles for this page -->
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.standalone.min.css') }}" rel="stylesheet">
@endsection
@section('add-js')
    <!-- Page level plugins -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

  <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){
        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd"
        });

        load_data_pos();
        load_data_online();

        function load_data_pos(from_date = '', to_date = '', method = 'Cash')
        {
            $('.data-table-pos').DataTable({
                scrollX: true,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ url('/pos/transaksi/') }}"+"/"+method+"/",
                    data:{from_date:from_date, to_date:to_date, method:method}
                },
                columns: [
                    {data: 'IdTransaksi', name: 'IdTransaksi'},
                    {data: 'TglTransaksi', name: 'TglTransaksi'},
                    {data: 'Total', name: 'Total'},
                    {data: 'Potongan', name: 'Potongan'},
                    {data: 'OngkosKirim', name: 'OngkosKirim'},
                    {data: 'NamaEkspedisi', name: 'NamaEkspedisi'},
                    {data: 'GrandTotal', name: 'GrandTotal'},
                    {data: 'MetodePembayaran', name: 'MetodePembayaran'},
                    {data: 'StatusPembayaran', name: 'StatusPembayaran'},
                    {data: 'StatusPesanan', name: 'StatusPesanan'},
                    {data: 'kupondiskon.NamaKupon', name: 'NamaKuponDiskon'},
                    {data: 'pelanggan.NamaPelanggan', name: 'NamaPelanggan'},
                    {data: 'pengguna.NamaPengguna', name: 'NamaPengguna'},
                    {data: 'Aksi', name: 'Aksi', orderable: false, searchable: false},
                ],
                footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Total over all pages
                    var json = this.api().ajax.json();
                    total = json.sum_total;
                    
                    // Update footer
                    $( api.column( 6 ).footer() ).html(
                        'Rp. '+ parseInt(total).toLocaleString()
                        // 'Total'
                    );
                },
            });
        }

        $('#filter_pos').click(function(){
            var from_date = $('#from_date_pos').val();
            var to_date = $('#to_date_pos').val();
            if(from_date != '' &&  to_date != '')
            {
                $('.data-table-pos').DataTable().destroy();
                load_data_pos(from_date, to_date);
            }
            else
            {
                swal("Peringatan!", "Both Date is required", "warning");
            }
        });

        $('#refresh_pos').click(function(){
            $('#from_date_pos').val('');
            $('#to_date_pos').val('');
            $('.data-table-pos').DataTable().destroy();
            load_data_pos();
        });

        function load_data_online(from_date = '', to_date = '', method = 'Midtrans')
        {
            $('.data-table-online').DataTable({
                scrollX: true,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ url('/pos/transaksi/') }}"+"/"+method+"/",
                    data:{from_date:from_date, to_date:to_date, method:method}
                },
                columns: [
                    {data: 'IdTransaksi', name: 'IdTransaksi'},
                    {data: 'TglTransaksi', name: 'TglTransaksi'},
                    {data: 'Total', name: 'Total'},
                    {data: 'Potongan', name: 'Potongan'},
                    {data: 'OngkosKirim', name: 'OngkosKirim'},
                    {data: 'NamaEkspedisi', name: 'NamaEkspedisi'},
                    {data: 'GrandTotal', name: 'GrandTotal'},
                    {data: 'MetodePembayaran', name: 'MetodePembayaran'},
                    {data: 'StatusPembayaran', name: 'StatusPembayaran'},
                    {data: 'StatusPesanan', name: 'StatusPesanan'},
                    {data: 'kupondiskon.NamaKupon', name: 'NamaKuponDiskon'},
                    {data: 'pelanggan.NamaPelanggan', name: 'NamaPelanggan'},
                    {data: 'pengguna.NamaPengguna', name: 'NamaPengguna'},
                    {data: 'Aksi', name: 'Aksi', orderable: false, searchable: false},
                ],
                footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Total over all pages
                    var json = this.api().ajax.json();
                    total = json.sum_total;
                    
                    // Update footer
                    $( api.column( 6 ).footer() ).html(
                        'Rp. '+ parseInt(total).toLocaleString() + ' (Yang Lunas)'
                        // 'Total'
                    );
                },
            });
        }

        $('#filter_online').click(function(){
            var from_date = $('#from_date_online').val();
            var to_date = $('#to_date_online').val();
            if(from_date != '' &&  to_date != '')
            {
                $('.data-table-online').DataTable().destroy();
                load_data_online(from_date, to_date);
            }
            else
            {
                swal("Peringatan!", "Both Date is required", "warning");
            }
        });

        $('#refresh_online').click(function(){
            $('#from_date_online').val('');
            $('#to_date_online').val('');
            $('.data-table-online').DataTable().destroy();
            load_data_online();
        });

    });

    function detail(a){
        var kode = 'IdTransaksi='+ a;
        $.ajax({
            type: "GET",
            url: "{{ url('/pos/transaksi/detailtransaksi/') }}/"+a+"/",
            data: kode,
            success: function(msg){
                // console.log(msg);
                if(msg.detailtransaksi.length == 0){
                    var dataa = "<tr class='append'>"+
                        "<td colspan=8 class='text-center'>Maaf Data Produk Tidak Tersedia!</td>"+
                    "</tr>";
                }else{
                    var dataa = "";
                    for(var i = 0; i < msg.detailtransaksi.length; i++){
                        var dataa = dataa+"<tr class='append'>"+
                            "<td>"+msg.detailtransaksi[i].IdProduk+"</td>"+
                            "<td>"+msg.detailtransaksi[i].produk.NamaProduk+"</td>"+
                            "<td>"+msg.detailtransaksi[i].stokproduk.warna.NamaWarna+"</td>"+
                            "<td>"+msg.detailtransaksi[i].stokproduk.ukuran.NamaUkuran+"</td>"+
                            "<td>Rp. "+msg.detailtransaksi[i].produk.HargaJual.toLocaleString()+"</td>"+
                            "<td>"+msg.detailtransaksi[i].Qty+"</td>"+
                            "<td>"+msg.detailtransaksi[i].Diskon+"</td>"+
                            "<td>Rp. "+msg.detailtransaksi[i].SubTotal.toLocaleString()+"</td>"+
                        "</tr>";
                    }
                }
                
            
                $("#detail-trans").append(dataa);
            }
        })
    }
    $('#detail').on('hidden.bs.modal', function(e){
        $('.append').remove(); 
    });

    function deletee(a){
        var kode = 'IdTransaksi='+ a;

        swal({
            title: "Apakah anda yakin ?",
            text: "Ini akan menghapus data secara permanen.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('/pos/admin/transaksi/') }}/"+a+"/",
                    data: kode,
                    success: function (data) {
                        swal("Selamat!", "Berhasil Menghapus Data", "success");
                        var table_pos = $('.data-table-pos').DataTable(); 
                        table_pos.ajax.reload( null, false );
                        var table_online = $('.data-table-online').DataTable(); 
                        table_online.ajax.reload( null, false );
                    },
                    error: function (data) {
                        var errors = "";
                        $.each(data.responseJSON.errors, function(key,value) {
                            errors = errors +' '+ value +'\n';
                        });
                        
                        swal("Gagal!","Gagal Menghapus Data : \n"+errors+"","error");
                    },
                })
            }
        });
    }

    function pesanan(a){
        var kode = 'IdTransaksi='+ a;
        $.ajax({
            type: "GET",
            url: "{{ url('/pos/detailtransaksi/') }}/"+a+"/",
            data: kode,
            success: function(msg){
                //console.log(msg);
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

                var dataa = "";
                for(var i = 0; i < msg.detailtransaksi.length; i++){
                    var dataa = '<tr class="border-bottom append">'+
                                    '<td>'+
                                        '<div class="font-weight-bold">'+msg.detailtransaksi[i].produk.NamaProduk+'</div>'+
                                        '<div class="small text-muted d-none d-md-block">'+msg.detailtransaksi[i].IdProduk+' - '+msg.detailtransaksi[i].stokproduk.warna.NamaWarna+' - '+msg.detailtransaksi[i].stokproduk.ukuran.NamaUkuran+'</div>'+
                                    '</td>'+
                                    '<td class="text-right font-weight-bold">Rp. '+msg.detailtransaksi[i].produk.HargaJual.toLocaleString()+'</td>'+
                                    '<td class="text-right font-weight-bold">'+msg.detailtransaksi[i].Qty+'</td>'+
                                    '<td class="text-right font-weight-bold">'+msg.detailtransaksi[i].SubTotal.toLocaleString()+'</td>'+
                                '</tr>';
                }
            
                $("#detail-trans-pesanan").prepend(dataa);
            }
        })
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
    });

    $("#Update").click(function(e){
        e.preventDefault();

        a = $("input[name=IdTransaksi]").val();

        $.ajax({
            type: 'PATCH',
            url: "{{ url('/pos/updatetransaksi/') }}/"+a+"/",
            data: $('#form-updatepesanan').serialize(),
            
            success: function (data) {
                swal("Selamat!", "Berhasil Mengupdate Pesanan", "success");
                $('#pesanan').modal('hide');
                var table_pos = $('.data-table-pos').DataTable(); 
                table_pos.ajax.reload( null, false );
                var table_online = $('.data-table-online').DataTable(); 
                table_online.ajax.reload( null, false );
            },
            error: function (data) {
                var errors = "";
                $.each(data.responseJSON.errors, function(key,value) {
                    errors = errors +' '+ value +'\n';
                });
                
                swal("Gagal!","Gagal Mengupdate Pesanan : \n"+errors+"","error");
            },
        });
    });


    

  </script>
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Transaksi</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi Point Of Sale</h6>
        </div>
        <div class="card-body">
            <div class="row justify-content-md-center input-daterange">
                <div class="col col-lg-2">
                    <input type="text" name="from_date" id="from_date_pos" class="form-control" placeholder="From Date" readonly />
                </div>
                <div class="col col-md-auto">
                    <input type="text" name="to_date" id="to_date_pos" class="form-control" placeholder="To Date" readonly />
                </div>
                <div class="col col-lg-2">
                    <button type="button" name="filter" id="filter_pos" class="btn btn-primary">Filter</button>
                    <button type="button" name="refresh" id="refresh_pos" class="btn btn-default">Refresh</button>
                </div>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered data-table-pos" width="100%" cellspacing="0" style="white-space: nowrap;">
                <thead>
                <tr>
                    <th>Id Transaksi</th>
                    <th>Tgl Transaksi</th>
                    <th>Total</th>
                    <th>Potongan</th>
                    <th>Ongkos Kirim</th>
                    <th>Nama Ekspedisi</th>
                    <th>Grand Total</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Status Pesanan</th>
                    <th>Nama Kupon Diskon</th>
                    <th>Nama Pelanggan</th>
                    <th>Nama Pengguna</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align:right">Total:</th>
                        <th colspan="8"></th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi Online Shop</h6>
        </div>
        <div class="card-body">
            <div class="row justify-content-md-center input-daterange">
                <div class="col col-lg-2">
                    <input type="text" name="from_date" id="from_date_online" class="form-control" placeholder="From Date" readonly />
                </div>
                <div class="col col-md-auto">
                    <input type="text" name="to_date" id="to_date_online" class="form-control" placeholder="To Date" readonly />
                </div>
                <div class="col col-lg-2">
                    <button type="button" name="filter" id="filter_online" class="btn btn-primary">Filter</button>
                    <button type="button" name="refresh" id="refresh_online" class="btn btn-default">Refresh</button>
                </div>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered data-table-online" width="100%" cellspacing="0" style="white-space: nowrap;">
                <thead>
                <tr>
                    <th>Id Transaksi</th>
                    <th>Tgl Transaksi</th>
                    <th>Total</th>
                    <th>Potongan</th>
                    <th>Ongkos Kirim</th>
                    <th>Nama Ekspedisi</th>
                    <th>Grand Total</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Status Pesanan</th>
                    <th>Nama Kupon Diskon</th>
                    <th>Nama Pelanggan</th>
                    <th>Nama Pengguna</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align:right">Total:</th>
                        <th colspan="8"></th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>

    <!--Modal detail-->
    <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="detail" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add">Detail Transaksi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                              <th>Id Produk</th>
                              <th>Nama Produk</th>
                              <th>Warna</th>
                              <th>Ukuran</th>
                              <th>Harga</th>
                              <th>Qty</th>
                              <th>Diskon</th>
                              <th>Subtotal</th>
                            </tr>  
                        </thead>  
                        <tbody id="detail-trans">
                        </tbody>
                      </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!--Modal pesanan-->
    <div class="modal fade" id="pesanan" tabindex="-1" role="dialog" aria-labelledby="pesanan" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pesanan">Update Status Pesanan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" id="form-updatepesanan">
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
                                      <tbody id="detail-trans-pesanan">                                          
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
                                      <div class="small">Badung, Bali, Indonesia</div>
                                  </div>
                                  <div class="col-lg-4 mt-1">
                                      <!-- Invoice - additional notes-->
                                      <div class="form-group">
                                        <label>Status Pesanan</label>
                                        <select class="form-control" name="StatusPesanan">
                                          <option value="1">DiProses</option>
                                          <option value="2">DiKirim</option>
                                          <option value="4">Dibatalkan</option>
                                        </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Exit</button>
                    <button class="btn btn-primary" type="button" id="Update">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection