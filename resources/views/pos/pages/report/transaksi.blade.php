@extends('pos.layout.layout')
@section('title-page')
    POS - Laporan Transaksi
@endsection
@section('add-css')
    <!-- Custom styles for this page -->
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.standalone.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
  
@endsection
@section('add-js')
    <!-- Page level plugins -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

  <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

  <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>

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

        var to = moment().endOf('month').format("YYYY-MM-DD");
        var from = moment().startOf('month').format("YYYY-MM-DD");

        $('#from_date').val(from);
        $('#to_date').val(to);

        document.getElementById("fromm").innerHTML = $('#from_date').val();
        document.getElementById("too").innerHTML = $('#to_date').val();

        load_data(from, to);

        function load_data(from_date = '', to_date = '')
        {
            $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            scrollX: true,
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            ajax: {
                data:{from_date:from_date, to_date:to_date},
            },
            dom: 'lBfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
                {
                    extend: 'pdfHtml5',
                    messageTop: 'Data Transaksi dari tanggal '+from_date+' sampai '+to_date,
                    orientation: 'landscape',
                    footer: true
                },
                {
                    extend: 'print',
                    messageTop: 'Data Transaksi dari tanggal '+from_date+' sampai '+to_date,
                    footer: true
                }
            ],
            footerCallback: function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Total over all pages
                var json = this.api().ajax.json();
                gtotal = json.sum_gtotal;
                total = json.sum_total;
                potongan = json.sum_potongan;
                ongkir = json.sum_ongkir;
           
                document.getElementById("untung").innerHTML = (json.sum_untung.untungkotor - json.sum_untung.sumpotongan).toLocaleString();
                
                // Update footer
                $( api.column( 2 ).footer() ).html(
                    'Rp. '+ parseInt(total).toLocaleString()
                    // 'Total'
                );
                $( api.column( 3 ).footer() ).html(
                    'Rp. '+ parseInt(potongan).toLocaleString()
                    // 'Total'
                );
                $( api.column( 4 ).footer() ).html(
                    'Rp. '+ parseInt(ongkir).toLocaleString()
                    // 'Total'
                );
                $( api.column( 6 ).footer() ).html(
                    'Rp. '+ parseInt(gtotal).toLocaleString()
                    // 'Total'
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
                {data: 'pengguna.NamaPengguna', name: 'NamaPengguna'}
            ]
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

  </script>
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Transaksi & Keuntungan</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Transaksi Keseluruhan</h6>
        </div>
        <div class="card-body">
            <div class="row justify-content-md-center input-daterange mb-2">
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
            <table class="table table-condensed data-table" width="100%" cellspacing="0" style="white-space: nowrap;">
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
                </tr>
                </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id Transaksi</th>
                        <th>Tgl Transaksi</th>
                        <th>Total</th>
                        <th>Potongan</th>
                        <th>Ongkos Kirim</th>
                        <th>Nama Ekspedisi</th>
                        <th>GrandTotal</th>
                        <th>Metode Pembayaran</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pesanan</th>
                        <th>Nama Kupon Diskon</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Pengguna</th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Keuntungan Transaksi</h6>
        </div>
        <div class="card-body">
            <h4>Keuntungan yang diperoleh pada penjualan periode <strong id="fromm"></strong> sampai <strong id="too"></strong> adalah Rp. <strong id="untung"></strong></h4>
        </div>
    </div>
@endsection