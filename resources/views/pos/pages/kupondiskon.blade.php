@extends('pos.layout.layout')
@section('title-page')
    POS - Data Kupon Diskon
@endsection
@section('add-css')
    <!-- Custom styles for this page -->
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection
@section('add-js')
    <!-- Page level plugins -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

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
        columns: [
            {data: 'IdKuponDiskon', name: 'IdKuponDiskon'},
            {data: 'NamaKupon', name: 'NamaKupon'},
            {data: 'TglMulai', name: 'TglMulai'},
            {data: 'TglSelesai', name: 'TglSelesai'},
            {data: 'Status', name: 'Status'},
            {data: 'JumlahPotongan', name: 'JumlahPotongan'},
            {data: 'Aksi', name: 'Aksi', orderable: false, searchable: false},
        ]
    });

    $("#Tambah").click(function(e){
        e.preventDefault();
        //var NamaPengguna = $("input[name=NamaPengguna]").val();
       // document.getElementById("demo").innerHTML = name;

        $.ajax({
            type: 'POST',
            url: "{{ url('/pos/pages/kupondiskon') }}",
            data: $('#form-tambah').serialize(),
            
            success: function (data) {
                swal("Selamat!", "Berhasil Menambah Data", "success");
                $('#form-tambah').trigger("reset");
                table.draw();
            },
            error: function (data) {
                var errors = "";
                $.each(data.responseJSON.errors, function(key,value) {
                    errors = errors +' '+ value +'\n';
                });
                
                swal("Gagal!","Gagal Menambah Data : \n"+errors+"","error");
            },
        });
    });

    $("#Edit").click(function(e){
        e.preventDefault();

        a = $("#IdKuponDiskonE").val();

        $.ajax({
            type: 'PATCH',
            url: "{{ url('/pos/pages/kupondiskon/') }}/"+a+"/",
            data: $('#form-edit').serialize(),
            
            success: function (data) {
                swal("Selamat!", "Berhasil Mengubah Data", "success");
                $('#form-edit').trigger("reset");
                $('#edit').modal('hide');
                table.draw();
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

    function edit(a){
        var kode = 'IdKuponDiskon='+ a;
        $.ajax({
            type: "GET",
            url: "{{ url('/pos/pages/kupondiskon/') }}/"+a+"/edit",
            data: kode,
            success: function(msg){
                $("#IdKuponDiskonE").val(msg.IdKuponDiskon);
                $("#NamaKuponE").val(msg.NamaKupon);
                $("#TglMulaiE").val(msg.TglMulai);
                $("#TglSelesaiE").val(msg.TglSelesai);
                $("#JumlahPotonganE").val(msg.JumlahPotongan);
            }
        })
    }

    function deletee(a){
        var kode = 'IdKuponDiskon='+ a;

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
                    url: "{{ url('/pos/pages/kupondiskon/') }}/"+a+"/",
                    data: kode,
                    success: function (data) {
                        swal("Selamat!", "Berhasil Menghapus Data", "success");
                        table.draw();
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


    $('.tgl').datetimepicker({
        format: 'yyyy-mm-dd hh:ii:ss'
    });

  </script>
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Kupon Diskon</h1>
        <a href="#" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Kupon Diskon</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Id Kupon Diskon</th>
                        <th>Nama Kupon</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Jumlah Potongan</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--Modal tambah-->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add">Tambah Data Kupon Diskon</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" id="form-tambah">
                        <div class="form-group">
                            <label>Id Kupon Diskon</label>
                            <input type="text" class="form-control" name="IdKuponDiskon" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Kupon Diskon</label>
                            <input type="text" class="form-control" name="NamaKuponDiskon" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Tanggal Mulai</label>
                                <input type="text" class="form-control tgl" name="TglMulai" required>                        
                            </div>
                            <div class="col">
                                <label>Tanggal Selesai</label>
                                <input type="text" class="form-control tgl" name="TglSelesai" required> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Potongan</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">Rp.</div>
                                </div>
                                <input type="number" class="form-control" name="JumlahPotongan" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="button" id="Tambah">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <!--Modal edit-->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add">Edit Data Kupon Diskon</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" id="form-edit">
                        <div class="form-group">
                            <label>Id Kupon Diskon</label>
                            <input type="text" class="form-control" name="IdKuponDiskon" id="IdKuponDiskonE" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Kupon Diskon</label>
                            <input type="text" class="form-control" name="NamaKuponDiskon" id="NamaKuponE" required>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label>Tanggal Mulai</label>
                                <input type="text" class="form-control tgl" name="TglMulai" id="TglMulaiE" required>
                            </div>
                            <div class="col form-group">
                                <label>Tanggal Selesai</label>
                                <input type="text" class="form-control tgl" name="TglSelesai" id="TglSelesaiE" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Potongan</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">Rp.</div>
                                </div>
                                <input type="number" class="form-control" name="JumlahPotongan" id="JumlahPotonganE" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="button" id="Edit">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection