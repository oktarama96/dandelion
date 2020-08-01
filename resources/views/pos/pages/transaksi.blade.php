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

        load_data();

        function load_data(from_date = '', to_date = '')
        {
            $('.data-table').DataTable({
                scrollX: true,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    data:{from_date:from_date, to_date:to_date}
                },
                footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api(), data;
        
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\Rp.,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
        
                    // Total over all pages
                    total = api
                        .column( 6 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                
                    // Update footer
                    $( api.column( 6 ).footer() ).html(
                        '$'+ total +' total)'
                    );
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
                // footerCallback: function ( row, data, start, end, display ) {
                //     var api = this.api(), data;

                //     // Total over all pages
                //     // var json = this.api().ajax.json();
                //     // total = json.total;
                    
                //     // Update footer
                //     $( api.column( 6 ).footer() ).html(
                //         // 'Rp. '+ total.toLocaleString()
                //         'Total'
                //     );
                // },
            });
        }

        $('#filter').click(function(){
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if(from_date != '' &&  to_date != '')
            {
                $('.data-table').DataTable().destroy();
                load_data(from_date, to_date);
            }
            else
            {
                alert('Both Date is required');
            }
        });

        $('#refresh').click(function(){
            $('#from_date').val('');
            $('#to_date').val('');
            $('.data-table').DataTable().destroy();
            load_data();
        });

    });

    function detail(a){
        var kode = 'IdTransaksi='+ a;
        $.ajax({
            type: "GET",
            url: "{{ url('/pos/transaksi/detailtransaksi/') }}/"+a+"/",
            data: kode,
            success: function(msg){
                console.log(msg);

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
                        var table = $('.data-table').DataTable(); 
                        table.ajax.reload( null, false );
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

    

  </script>
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Transaksi</h1>
        <a href="#" class="d-sm-inline-block btn btn-sm btn-success shadow-sm" data-toggle="modal" data-target="#pesanan"><i class="fas fa-plus fa-sm text-white-50"></i> Update Status Pesanan</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="row justify-content-md-center input-daterange">
                <div class="col col-lg-2">
                    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
                </div>
                <div class="col col-md-auto">
                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
                </div>
                <div class="col col-lg-2">
                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                </div>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered data-table" width="100%" cellspacing="0" style="white-space: nowrap;">
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pesanan">Update Status Pesanan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Exit</button>
                    <button class="btn btn-primary" type="button" id="Update">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection