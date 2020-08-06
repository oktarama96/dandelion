@extends('pos.layout.layout')
@section('title-page')
    POS - Data Produk
@endsection
@section('add-css')
    <!-- Custom styles for this page -->
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('add-js')
    <!-- Page level plugins -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  <!-- Page level custom scripts -->
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
        order: [],
        columns: [
            {data: 'IdProduk', name: 'IdProduk'},
            {data: 'NamaProduk', name: 'NamaProduk'},
            {data: 'HargaPokok', name: 'HargaPokok'},
            {data: 'HargaJual', name: 'HargaJual'},
            {data: 'kategori.NamaKategori', name: 'Kategori'},
            {data: 'Berat', name: 'Berat'},
            {data: 'Aksi', name: 'Aksi', orderable: false, searchable: false},
        ]
    });

    $("#form-tambah").submit(function(e){
        e.preventDefault();
        //var NamaPengguna = $("input[name=NamaPengguna]").val();
       // document.getElementById("demo").innerHTML = name;
       var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{ url('/pos/admin/produk') }}",
            data: formData,
            processData: false,
            contentType: false,
            
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

        a = $("#IdProdukE").val();
        //console.log($('#form-edit').serialize());
        $.ajax({
            type: 'PATCH',
            url: "{{ url('/pos/admin/produk/') }}/"+a+"/",
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

    $("#Stok").click(function(e){
        e.preventDefault();

        a = $("#form-stok input[name='IdProduk']").val();

        $.ajax({
            type: 'PATCH',
            url: "{{ url('/pos/admin/produk/') }}/"+a+"/stok",
            data: $('#form-stok').serialize(),
            
            success: function (data) {
                swal("Selamat!", "Berhasil Mengubah Data", "success");
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

    $('#detail').on('hidden.bs.modal', function(e){
        $('.append').remove(); 
    });
    $('#add').on('hidden.bs.modal', function(e){
        $('.append').remove(); 
    });
    $('#edit').on('hidden.bs.modal', function(e){
        $('.append').remove(); 
    });
    $('#stok').on('hidden.bs.modal', function(e){
        $('.append').remove(); 
    });

    function detail(a){
        var kode = 'IdProduk='+ a;
        $.ajax({
            type: "GET",
            url: "{{ url('/pos/admin/produk/') }}/"+a+"/",
            data: kode,
            success: function(msg){
                //console.log(msg[0].GambarProduk);
                var imgurl = "{{ asset('img/produk/') }}/";
                var data = "<div class='card append'>"+
                                "<img class='card-img-top' src='"+imgurl+msg.produk[0].GambarProduk+"'>"+
                                "<div class='card-body'>"+
                                    "<h3>Deskripsi</h3>"+
                                    "<p class='card-text'>"+msg.produk[0].Deskripsi+"</p>"+
                                    "<div class='table-responsive'>"+
                                        "<table class='table table-bordered' width='100%' cellspacing='0' style='white-space: nowrap;'>"+
                                            "<thead>"+
                                            "<tr>"+
                                                "<th>Ukuran</th>"+
                                                "<th>Warna</th>"+
                                                "<th>Stok Masuk</th>"+
                                                "<th>Stok Keluar</th>"+
                                                "<th>Stok Akhir</th>"+
                                            "</tr>"+
                                            "</thead>"+
                                            "<tbody>";
                                                for(var i = 0; i < msg.stokproduk.length; i++){
                                                    data = data+
                                                    "<tr>"+
                                                        "<td>"
                                                            + msg.stokproduk[i].ukuran.NamaUkuran +  
                                                        "</td>"+
                                                        "<td>"
                                                            + msg.stokproduk[i].warna.NamaWarna +
                                                        "</td>"+
                                                        "<td>"
                                                            + msg.stokproduk[i].StokMasuk +
                                                        "</td>"+
                                                        "<td>"
                                                            + msg.stokproduk[i].StokKeluar +
                                                        "</td>"+
                                                        "<td>"
                                                            + msg.stokproduk[i].StokAkhir +
                                                        "</td>"+
                                                    "</tr>";
                                                }

                                        data = data+"</tbody>"+
                                        "</table>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";

                $("#detail-produk").append(data);
            }
        })
    }
  
    function edit(a){
        var kode = 'IdProduk='+ a;
        $.ajax({
            type: "GET",
            url: "{{ url('/pos/admin/produk/') }}/"+a+"/edit",
            data: kode,
            success: function(msg){
                $("#IdProdukE").val(msg.produk.IdProduk);
                $("#NamaProdukE").val(msg.produk.NamaProduk);
                $("#KategoriProdukE").val(msg.produk.IdKategoriProduk);
                $("#HargaPokokE").val(msg.produk.HargaPokok);
                $("#HargaJualE").val(msg.produk.HargaJual);
                $("#BeratE").val(msg.produk.Berat);
                $("#UkuranE").val(msg.produk.IdUkuran);
                $("#WarnaE").val(msg.produk.IdWarna);
                $("#DeskripsiE").val(msg.produk.Deskripsi);

                var dataa = "";
                for(var i = 0; i < msg.stokproduk.length; i++){
                    var dataa = dataa+"<tr class='append'>"+
                        "<input type='hidden' name='IdStokProduk["+i+"]' value='"+msg.stokproduk[i].IdStokProduk+"'>"+
                        "<td>"+
                            "<select class='form-control' name='Ukuran["+i+"]'>"+
                                @foreach ($ukurans as $ukuran)
                                "<option value='{{ $ukuran->IdUkuran }}'>{{ $ukuran->NamaUkuran }}</option>"+
                                @endforeach
                            "</select>"+  
                        "</td>"+
                        "<td>"+
                            "<select class='form-control' name='Warna["+i+"]'>"+
                                @foreach ($warnas as $warna)
                                "<option value='{{ $warna->IdWarna }}'>{{ $warna->NamaWarna }}</option>"+
                                @endforeach
                            "</select>"+
                        "</td>"+
                        "<td>"+
                            "<input type='number' name='StokMasuk["+i+"]' class='form-control' required>"+
                        "</td>"+  
                        "<td>"+
                            "<button type='button' name='ButtonTambah[]' onclick='hapus(this)' class='btn btn-danger'><i class='fas fa-minus text-white'></i></button>"+
                        "</td>"+
                    "</tr>";
                }
            
            $(".add-row").append(dataa);

            for(var j = 0; j < msg.stokproduk.length; j++){
                $("select[name='Ukuran["+j+"]']").val(msg.stokproduk[j].ukuran.IdUkuran);
                $("select[name='Warna["+j+"]']").val(msg.stokproduk[j].warna.IdWarna); 
                $("input[name='StokMasuk["+j+"]']").val(msg.stokproduk[j].StokMasuk); 
                }
            }
        }) 
    }

    function deletee(a){
        var kode = 'IdProduk='+ a;

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
                    url: "{{ url('/pos/admin/produk/') }}/"+a+"/",
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

    $('.button-tambah').click(function(){
        var rangka	= 	"<tr class='append new'>"+
                           "<td>"+
                                "<select class='form-control' name='Ukuran[]'>"+
                                    @foreach ($ukurans as $ukuran)
                                    "<option value='{{ $ukuran->IdUkuran }}'>{{ $ukuran->NamaUkuran }}</option>"+
                                    @endforeach
                                "</select>"+  
                            "</td>"+
                            "<td>"+
                                "<select class='form-control' name='Warna[]'>"+
                                    @foreach ($warnas as $warna)
                                    "<option value='{{ $warna->IdWarna }}'>{{ $warna->NamaWarna }}</option>"+
                                    @endforeach
                                "</select>"+
                            "</td>"+
                            "<td>"+
                                "<input type='number' name='StokMasuk[]' class='form-control' required>"+
                            "</td>"+
                            "<td>"+
                                "<button type='button' onclick='hapus(this)' class='btn btn-danger'><i class='fas fa-minus text-white'></i></button>"+
                            "</td>"+
                        "</tr>";
        $('.add-row').append(rangka);
    });

    function hapus(e){
        var tr = $(e).parent().parent();
        
        swal({
            title: "Apakah anda yakin ?",
            text: "Ini akan menghapus data secara permanen.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                if(tr.hasClass('new')){
                    $(tr).remove();
                }else{
                    var idstok = $(tr).children('input').val();
                    var kode = 'IdStokProduk='+ idstok;

                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('/pos/admin/produk/') }}/"+idstok+"/stok",
                        data: kode,
                        success: function (data) {
                            $(tr).remove();
                            swal("Selamat!", "Berhasil Menghapus Data", "success");
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
            }
        });
    }

    function stok(a){
        var kode = 'IdProduk='+ a;
        $.ajax({
            type: "GET",
            url: "{{ url('/pos/admin/produk/') }}/"+a+"/edit",
            data: kode,
            success: function(msg){
                var dataa = "";
                for(var i = 0; i < msg.stokproduk.length; i++){
                    dataa = dataa+"<tr class='append'>"+
                        "<input type='hidden' name='IdStokProduk["+i+"]' value='"+msg.stokproduk[i].IdStokProduk+"'>"+
                        "<input type='hidden' name='IdProduk' value='"+msg.produk.IdProduk+"'>"+
                        "<td>"+
                            "<input type='text' name='NamaWarna["+i+"]' class='form-control' value='"+msg.stokproduk[i].warna.NamaWarna+"' readonly>"+  
                        "</td>"+
                        "<td>"+
                            "<input type='text' name='NamaUkuran["+i+"]' class='form-control' value='"+msg.stokproduk[i].ukuran.NamaUkuran+"' readonly>"+
                        "</td>"+
                        "<td>"+
                            "<input type='number' name='StokMasuk["+i+"]' class='form-control' value=0 required>"+
                        "</td>"+
                    "</tr>";
                }
                
            
                $("#manajemen-stok").append(dataa);
            }
        }) 
    }

  </script>
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 flex-grow-1 text-gray-800">Data Produk</h1>
        <a href="#" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Produk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table" width="100%" cellspacing="0" style="white-space: nowrap;">
                    <thead>
                    <tr>
                        <th>Id Produk</th>
                        <th>Nama Produk</th>
                        <th>HargaPokok</th>
                        <th>HargaJual</th>
                        <th>Kategori</th>
                        <th>Berat</>
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
            <form method="post" action="#" id="form-tambah" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="add">Tambah Data Produk</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label>Id Produk</label>
                            <input type="text" name="IdProduk" class="form-control" id="IdProduk" required>
                        </div>

                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="NamaProduk" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Kategori Produk</label>
                            <select class="form-control" name="KategoriProduk">
                                @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->IdKategoriProduk }}">{{ $kategori->NamaKategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>Harga Pokok</label>
                                <input type="number" class="form-control" name="HargaPokok" required>                        
                            </div>
                            <div class="col">
                                <label>Harga Jual</label>
                                <input type="number" class="form-control" name="HargaJual" required> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Berat (g)</label>
                            <input type="number" name="Berat" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0" style="white-space: nowrap;">
                                    <thead>
                                    <tr>
                                        <th>Ukuran</th>
                                        <th>Warna</th>
                                        <th>Stok Masuk</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody class="add-row">
                                        <tr>
                                            <td>
                                                <select class="form-control" name="Ukuran[]">
                                                    @foreach ($ukurans as $ukuran)
                                                    <option value="{{ $ukuran->IdUkuran }}">{{ $ukuran->NamaUkuran }}</option>
                                                    @endforeach
                                                </select>  
                                            </td>
                                            <td>
                                                <select class="form-control" name="Warna[]">
                                                    @foreach ($warnas as $warna)
                                                    <option value="{{ $warna->IdWarna }}">{{ $warna->NamaWarna }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="StokMasuk[]" class="form-control" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success button-tambah"><i class="fas fa-plus text-white"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="Deskripsi" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Pilih gambar</label>
                            <input type="file" name="GambarProduk" class="form-control-file">
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" id="Tambah">Tambah</button>
                </div>
            </form>
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
                        <div class="form-group">
                            <label>Id Produk</label>
                            <input type="text" name="IdProduk" class="form-control" id="IdProdukE" readonly>
                        </div>

                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="NamaProduk" class="form-control" id="NamaProdukE" required>
                        </div>

                        <div class="form-group">
                            <label>Kategori Produk</label>
                            <select class="form-control" name="KategoriProduk" id="KategoriProdukE">
                                @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->IdKategoriProduk }}">{{ $kategori->NamaKategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label>Harga Pokok</label>
                                <input type="number" class="form-control" name="HargaPokok" id="HargaPokokE" required>                        
                            </div>
                            <div class="col">
                                <label>Harga Jual</label>
                                <input type="number" class="form-control" name="HargaJual" id="HargaJualE" required> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Berat (g)</label>
                            <input type="number" name="Berat" class="form-control" id="BeratE" required>
                        </div>

                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0" style="white-space: nowrap;">
                                    <thead>
                                    <tr>
                                        <th>Ukuran</th>
                                        <th>Warna</th>
                                        <th>Stok Masuk</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody class="add-row">
                                        
                                    
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>
                                            <button type="button" class="btn btn-success button-tambah"><i class="fas fa-plus text-white"></i></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="Deskripsi" class="form-control" id="DeskripsiE"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Pilih gambar</label>
                            <input type="file" name="GambarProduk" class="form-control-file">
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

    <!--Modal detail-->
    <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="detail" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add">Detail Produk</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detail-produk"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Exit</button>
                </div>
            </div>
        </div>
    </div>

    <!--Modal stok-->
    <div class="modal fade" id="stok" tabindex="-1" role="dialog" aria-labelledby="stok" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add">Tambah atau Kurang Stok</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" id="form-stok">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Warna</th>
                                        <th>Ukuran</th>
                                        <th>Stok Masuk</th>
                                    </tr>
                                    </thead>
                                    <tbody id="manajemen-stok">
                                        
                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p><small>*Bilangan Positif berarti Menambahkan & Negatif berarti Mengurangkan</small></p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="button" id="Stok">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection