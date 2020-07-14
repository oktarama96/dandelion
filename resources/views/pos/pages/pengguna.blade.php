@extends('pos.layout.layout')
@section('title-page')
    POS - Data Pengguna
@endsection
@section('add-css')
    <!-- Custom styles for this page -->
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('add-js')
    <!-- Page level plugins -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

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
            {data: 'IdPengguna', name: 'IdPengguna'},
            {data: 'NamaPengguna', name: 'NamaPengguna'},
            {data: 'email', name: 'Email'},
            {data: 'Alamat', name: 'Alamat'},
            {data: 'NoHandphone', name: 'NoHandphone'},
            {data: 'Is_admin', name: 'Is_admin'},
            {data: 'Aksi', name: 'Aksi', orderable: false, searchable: false},
        ]
    });

    $("#TambahPengguna").click(function(e){
        e.preventDefault();
        //var NamaPengguna = $("input[name=NamaPengguna]").val();
       // document.getElementById("demo").innerHTML = name;

        $.ajax({
            type: 'POST',
            url: "{{ url('/pos/admin/pengguna') }}",
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

    $("#EditPengguna").click(function(e){
        e.preventDefault();
        //var NamaPengguna = $("input[name=NamaPengguna]").val();
       // document.getElementById("demo").innerHTML = name;
        a = $("#IdPenggunaE").val();

        $.ajax({
            type: 'PATCH',
            url: "{{ url('/pos/admin/pengguna/') }}/"+a+"/",
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
        var kode = 'IdPengguna='+ a;
        $.ajax({
            type: "GET",
            url: "{{ url('/pos/admin/pengguna/') }}/"+a+"/edit",
            data: kode,
            success: function(msg){
                $("#IdPenggunaE").val(msg.IdPengguna);
                $("#NamaPenggunaE").val(msg.NamaPengguna);
                $("#EmailE").val(msg.email);
                $("#AlamatE").val(msg.Alamat);
                $("#NoHandphoneE").val(msg.NoHandphone);
                $("#jabatanE").val(msg.Is_admin);
            }
        })
    }

    function deletee(a){
        var kode = 'IdPengguna='+ a;

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
                    url: "{{ url('/pos/admin/pengguna/') }}/"+a+"/",
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

  </script>
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pengguna</h1>
        <a href="#" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengguna</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered data-table" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Id Pengguna</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>No Handphone</th>
                    <th>Jabatan</th>
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
                    <h5 class="modal-title" id="add">Tambah Data User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" id="form-tambah">
                        <div class="form-group">
                            <label>Nama Pengguna</label>
                            <input type="text" class="form-control" name="NamaPengguna" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="Email" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="Password" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="Alamat" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>No Handphone</label>
                            <input type="number" class="form-control" name="NoHandphone" required>
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select class="form-control" name="jabatan">
                                <option value="1">Admin</option>
                                <option value="0">Kasir</option>
                              </select>
                        </div>    
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="button" id="TambahPengguna">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <!--Modal edit-->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add">Edit Data User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" id="form-edit">
                        <input type="hidden" class="form-control" name="IdPengguna" id="IdPenggunaE" required>
                        <div class="form-group">
                            <label>Nama Pengguna</label>
                            <input type="text" class="form-control" name="NamaPengguna" id="NamaPenggunaE" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="Email" id="EmailE" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="Password" id="PasswordE" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="Alamat" class="form-control" id="AlamatE"></textarea>
                        </div>
                        <div class="form-group">
                            <label>No Handphone</label>
                            <input type="number" class="form-control" name="NoHandphone" id="NoHandphoneE" required>
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select class="form-control" name="jabatan" id="jabatanE">
                                <option value="1">Admin</option>
                                <option value="0">Kasir</option>
                            </select>
                        </div>    
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="button" id="EditPengguna">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection