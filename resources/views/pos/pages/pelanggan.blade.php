@extends('pos.layout.layout')
@section('title-page')
    POS - Data Pelanggan
@endsection
@section('add-css')
    <!-- Custom styles for this page -->
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
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

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "",
        columns: [
            {data: 'IdPelanggan', name: 'IdPelanggan'},
            {data: 'NamaPelanggan', name: 'NamaPengguna'},
            {data: 'Email', name: 'Email'},
            {data: 'JenisKelamin', name: 'JenisKelamin'},
            {data: 'TglLahir', name: 'TglLahir'},
            {data: 'Alamat', name: 'Alamat'},
            {data: 'NoHandphone', name: 'NoHandphone'},
            {data: 'Aksi', name: 'Aksi', orderable: false, searchable: false},
        ]
    });

    $("#Tambah").click(function(e){
        e.preventDefault();
       
        $.ajax({
            type: 'POST',
            url: "{{ url('/pos/pages/pelanggan') }}",
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
        //var NamaPengguna = $("input[name=NamaPengguna]").val();
       // document.getElementById("demo").innerHTML = name;
        a = $("#IdPelangganE").val();

        $.ajax({
            type: 'PATCH',
            url: "{{ url('/pos/pages/pelanggan/') }}/"+a+"/",
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
        var kode = 'IdPelanggan='+ a;
        $.ajax({
            type: "GET",
            url: "{{ url('/pos/pages/pelanggan/') }}/"+a+"/edit",
            data: kode,
            success: function(msg){
                var kabupaten = "<option value='-'>Pilih Kabupaten</option>";
                for(i = 0; i < msg.kabupatens.results.length; i++){
                    kabupaten = kabupaten+"<option value='"+msg.kabupatens.results[i].id+"'>"+msg.kabupatens.results[i].name+"</option>"; 
                };
                $("select[name='Kabupaten']").append(kabupaten);

                var kecamatan = "<option value='-'>Pilih Kecamatan</option>";
                for(i = 0; i < msg.kecamatans.results.length; i++){
                    kecamatan = kecamatan+"<option value='"+msg.kecamatans.results[i].id+"'>"+msg.kecamatans.results[i].name+"</option>"; 
                };

                $("select[name='Kecamatan']").append(kecamatan);

                $("#IdPelangganE").val(msg.tabel.IdPelanggan);
                $("#NamaPelangganE").val(msg.tabel.NamaPelanggan);
                $("#EmailE").val(msg.tabel.Email);
                $("#JenisKelaminE").val(msg.tabel.JenisKelamin);
                $("#TglLahirE").val(msg.tabel.TglLahir);
                $("#NoHandphoneE").val(msg.tabel.NoHandphone);
                $("#AlamatE").val(msg.tabel.Alamat);
                $("#ProvinsiE").val(msg.tabel.IdProvinsi);
                $("#KabupatenE").val(msg.tabel.IdKabupaten);
                $("#KecamatanE").val(msg.tabel.IdKecamatan);

                $("select[name='Provinsi']").append("<input type='hidden' name='NamaProvinsi' value='"+msg.tabel.NamaProvinsi+"'>");
                $("select[name='Kabupaten']").append("<input type='hidden' name='NamaKabupaten' value='"+msg.tabel.NamaKabupaten+"'>"); 
                $("select[name='Kecamatan']").append("<input type='hidden' name='NamaKecamatan' value='"+msg.tabel.NamaKecamatan+"'>"); 
            }
        })
    }

    function deletee(a){
        var kode = 'IdPelanggan='+ a;

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
                    url: "{{ url('/pos/pages/pelanggan/') }}/"+a+"/",
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
            url: "{{ url('/pos/pages/pelanggan/add/provinsi/') }}/"+this.value+"/",
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
            url: "{{ url('/pos/pages/pelanggan/add/kabupaten/') }}/"+this.value+"/",
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

  </script>
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pelanggan</h1>
        <a href="#" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pelanggan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered data-table" width="100%" cellspacing="0" style="white-space: nowrap;">
                <thead>
                <tr>
                    <th>Id Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>Email</th>
                    <th>Jenis Kelamin</th>
                    <th>Tgl Lahir</th>
                    <th>Alamat</th>
                    <th>No Handphone</th>
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
                    <h5 class="modal-title" id="add">Tambah Data Pelanggan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" id="form-tambah">
                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <input type="text" class="form-control" name="NamaPelanggan" required>
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
                            <label>Jenis Kelamin</label>
                            <select class="form-control" name="JenisKelamin">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tgl Lahir</label>
                            <input type="text" class="form-control tgl" name="TglLahir" required>
                        </div> 
                        <div class="form-group">
                            <label>No Handphone</label>
                            <input type="text" class="form-control" name="NoHandphone" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="Alamat" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Provinsi</label>
                            <select class="form-control" name="Provinsi">
                                <option value="-">Pilih Provinsi</option>
                                @foreach ($provinsis as $provinsi)
                                    <option value="{{ $provinsi['id'] }}">{{ $provinsi['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kabupaten</label>
                            <select class="form-control" name="Kabupaten">

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select class="form-control" name="Kecamatan">

                            </select>
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
                    <h5 class="modal-title" id="add">Edit Data User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" id="form-edit">
                        <input type="hidden" class="form-control" name="IdPelanggan" id="IdPelangganE" required>
                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <input type="text" class="form-control" name="NamaPelanggan" id="NamaPelangganE" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="Email" id="EmailE" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="Password" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-control" name="JenisKelamin" id="JenisKelamin">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tgl Lahir</label>
                            <input type="text" class="form-control tgl" name="TglLahir" id="TglLahirE" required>
                        </div> 
                        <div class="form-group">
                            <label>No Handphone</label>
                            <input type="text" class="form-control" name="NoHandphone" id="NoHandphoneE" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="Alamat" class="form-control" id="AlamatE"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Provinsi</label>
                            <select class="form-control" name="Provinsi" id="ProvinsiE">
                                <option value="-">Pilih Provinsi</option>
                                @foreach ($provinsis as $provinsi)
                                    <option value="{{ $provinsi['id'] }}">{{ $provinsi['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kabupaten</label>
                            <select class="form-control" name="Kabupaten" id="KabupatenE">

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select class="form-control" name="Kecamatan" id="KecamatanE">

                            </select>
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