@extends('pos.layout.layout')
@section('title-page')
    POS - Laporan Transaksi
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
            format: "dd/mm/yyyy"
        });

        load_data();

        function load_data(from_date = '', to_date = '')
        {
            $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                data:{from_date:from_date, to_date:to_date}
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
        <h1 class="h3 mb-0 text-gray-800">Laporan Transaksi</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Transaksi</h6>
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
                </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
            </div>
        </div>
    </div>
@endsection