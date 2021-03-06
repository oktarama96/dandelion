@extends('pos.layout.layout')
@section('title-page')
    POS - Point Of Sale
@endsection
@section('add-css')
    <!-- Custom styles for this page -->
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <style>
    .sidebar {
        width: 6.5rem;
        min-height: 100vh;
    }
    .autocomplete-suggestions { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; border: 1px solid #999; background: #FFF; cursor: default; overflow: auto; -webkit-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); -moz-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); }
    .autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
    .autocomplete-no-suggestion { padding: 2px 5px;}
    .autocomplete-selected { background: #F0F0F0; }
    .autocomplete-suggestions strong { font-weight: bold; color: #000; }
    .autocomplete-group { padding: 2px 5px; font-weight: bold; font-size: 16px; color: #000; display: block; border-bottom: 1px solid #000; }
  </style>
@endsection
@section('add-js')
    <!-- Page level plugins -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery-autocomplete/jquery.autocomplete.min.js') }}"></script>

  <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("input[name='NamaProduk\\[\\]']").autocomplete({
       serviceUrl : "{{ url('/pos/pages/pos/acproduk/') }}",
       dataType : "JSON",
       showNoSuggestionNotice : true,
       onSelect : function(suggestions){
           //console.log(suggestions);
           $("input[name='IdProduk\\[\\]']").val(suggestions.id);

           viewProduk($("input[name='IdProduk\\[\\]']"));
           $("input[name='Qty\\[\\]']").focus();
       }
   });
    
    $('#tmpl_jl').on('hidden.bs.modal', function(e){
       $('.append').remove(); 
    });

    function reprint(){
        window.location="re-print.php";
    }

    //delete line
    function del(a) {
        e	= event;
        if (e.keyCode==46) {
            var m	= confirm("Yakin menghapus?");
            if(m) {
                $(a).remove();
            }
        }
        Ttl();
    }

    //dbl tab
    function dblTab(ini,name) {
        e	= event;
        var index	=	$(ini).parent().parent().index();

        var el		= "input[name="+name+"\\[\\]]";
        if(e.keyCode==9) {
            $(el)[index].focus();
        }
    }

    //change tab with enter
    $("input[name='IdProduk\\[\\]']").keydown(function(e){
        dblTab($(this),"NamaProduk");
        if (e.keyCode == 13){
            $("input[name='Qty\\[\\]']").focus();
            return false;
        }
    });

    $("input[name='Qty\\[\\]']").keydown(function(e){
        dblTab($(this),"HargaJual");
        if (e.keyCode == 13){
            $("input[name='Diskon\\[\\]']").focus();
            return false;
        }
    });
    
    var i = 1;
    var Ttal = 0;

    //append new line
    function subTtl(ini) {
        i++;
        e	= event;
        
        if($("input[name='IdProduk\\[\\]']:eq("+(i-2)+")").val() != "" && e.keyCode==13) {
            var tbody	= $(ini).parent().parent().parent();
            var rangka	= 	"<tr onkeydown='del(this)'>"+
                                "<td>"+i+"</td>"+
                                "<td><input type='text' name='IdProduk[]' class='form-control  txt-id' onchange='viewProduk(this)'></td>"+
                                "<td><input type='text' name='NamaProduk[]' class='form-control  txt-nama'></td>"+
                                "<td><input type='number' name='Qty[]' step='0.1' class='form-control  txt-qty' value=1 onkeydown=\"dblTab(this,'HargaJual')\" onfocus='this.select()' onblur='calculate(this)'></td>"+
                                "<td><input type='number' name='HargaJual[]' class='form-control ' value=0 onblur='calculate(this)' readonly></td>"+
                                "<td><input type='number' name='Diskon[]' class='form-control ' id='enter' value=0 onblur='calculate(this)' onfocus='this.select()' onkeydown='subTtl(this)'></td>"+
                                "<td><input type='number' name='SubTotal[]' class='form-control '  readonly></td>"+
                            "</tr>";
            tbody.append(rangka);
            
            /*
             * create event
             * for each element of Input Type Name Id Produk
             */ 
            
            $("input[name='IdProduk\\[\\]']").each(function(index){
                $("input[name='IdProduk\\[\\]']:eq("+index+")").focus();
                $(this).keydown(function(e){
                    dblTab($(this),"NamaProduk");
                    if (e.keyCode == 13){
                        $("input[name='Qty\\[\\]']:eq("+index+")").focus();
                        return false;
                    }
                });
            });

            $("input[name='Qty\\[\\]']").each(function(index){
                $(this).keydown(function(e){
                    dblTab($(this),"HargaJual");
                    if (e.keyCode == 13){
                        $("input[name='Diskon\\[\\]']:eq("+index+")").focus();
                        return false;
                    }
                });
            });
            
            $("input[name='NamaProduk\\[\\]']").each(function(index){
                $(this).autocomplete({
                   serviceUrl : "{{ url('/pos/pages/pos/acproduk/') }}",
                   dataType : "JSON",
                   showNoSuggestionNotice : true,
                   onSelect : function(suggestions){
                       //console.log(suggestions.id);
                       $("input[name='IdProduk\\[\\]']:eq("+index+")").val(suggestions.id);

                       viewProduk($("input[name='IdProduk\\[\\]']:eq("+index+")"));
                       $("input[name='Qty\\[\\]']:eq("+index+")").focus();
                   }
               });
            });

            e.preventDefault();
            return false;
        }else if($("input[name='IdProduk\\[\\]']:eq("+(i-2)+")").val() == "" && e.keyCode==13){
            //enter
            e.preventDefault();

            $("#pnj").modal("show");
            $("#pnj").on("shown.bs.modal", function(){
            $("#Ptngan").focus(); 
            });
            
            $("#TotalForm").val(Ttal);
            $("#grndTtal").val(Ttal);
            
            /*POP UP FUNCTION*/  

            $("#Ptngan").keyup(function(e){
                x = (Ttal-$(this).val());
                $("#grndTtal").val(x);
                
                if(e.keyCode == 13){
                    $("#byr").focus();
                    $("#kmbl").val($("#byr").val()-$("#grndTtal").val());
                }
                
            });

            $("#byr").keyup(function(){
                $("#kmbl").val($("#byr").val()-$("#grndTtal").val());
            });

            //console.log($("#grndTtal").val());
            
            e.preventDefault();
            return false; 
        }
    }

    //calculate
    function calculate(ini){
        var index	= $(ini).parent().parent().index();
        var qty		= ($("input[name='Qty\\[\\]']:eq("+index+")").val()=="")?0:$("input[name='Qty\\[\\]']:eq("+index+")").val();
        var hj		= ($("input[name='HargaJual\\[\\]']:eq("+index+")").val()=="")?0:$("input[name='HargaJual\\[\\]']:eq("+index+")").val();
        var disc	= ($("input[name='Diskon\\[\\]']:eq("+index+")").val()=="")?0:$("input[name='Diskon\\[\\]']:eq("+index+")").val();
        var subTtl	= $("input[name='SubTotal\\[\\]']:eq("+index+")");

        var total = qty*hj;

        var diskon = total*disc/100;

        var subTotal = total-diskon;

        subTtl.val(parseInt(subTotal));
        Ttl();
    }

    //show GrandTotal
    function Ttl(){
        var subTtl	= $("input[name='SubTotal[]']");

        Ttal = 0;
        for (i=0;i<subTtl.length;i++){
            var a = ($("input[name='SubTotal[]']:eq("+i+")").val()=="")?0:$("input[name='SubTotal[]']:eq("+i+")").val();
            Ttal+=parseInt(a);
        }
        $("#Total").html(Ttal);
    }

    function viewProduk(ini) {
        var index = $(ini).parent().parent().index();

        $.ajax({
            type: "GET",
            url:  "{{ url('/pos/pages/pos/addproduk') }}/"+$(ini).val()+"/",
            data:  "IdProduk=" + $(ini).val(),
            success: function(msg){
                //console.log(msg);
                if(msg.length != 0) {
                    $("input[name='IdProduk\\[\\]']:eq("+index+")").val(msg[0].IdProduk);
                    $("input[name='NamaProduk\\[\\]']:eq("+index+")").val(msg[0].NamaProduk);
                    $("input[name='HargaJual\\[\\]']:eq("+index+")").val(msg[0].HargaJual);

                    calculate(ini);
                    Ttl();
                } else {
                    alert('Produk Tidak Ada!');
                    $("input[name='IdProduk\\[\\]']:eq("+index+")").val("").focus();
                }
            }
        });
    }

    $("#btnSimpan").click(function(e){
        e.preventDefault();
        //var NamaPengguna = $("input[name=NamaPengguna]").val();
       // document.getElementById("demo").innerHTML = name;
        //console.log($('#form-transaksi').serialize());
        $.ajax({
            type: "POST",
            url: "{{ url('/pos/pages/pos/addtransaksi') }}",
            data: $('#form-transaksi').serialize(),
            
            success: function (data) {
                alert('Berhasil Menambah Data');
                $('#form-transaksi').trigger("reset");
            },
            error: function (data) {
                var errors = "";
                $.each(data.responseJSON.errors, function(key,value) {
                    errors = errors +' '+ value +'\n';
                });
                
                alert('Gagal Menambah Data : \n'+errors);
            },
        });
    });
    
  </script>
@endsection
@section('content')

    <div class="card shadow md-4">
        <form action="{{ url('/pos/pages/pos/addtransaksi') }}" method="post" id="form-transaksi">
            @csrf
            <div class="card-header py-3">
                <h1 class="page-header"><i class="fas fa-fw fa-cash-register"></i> Point Of Sale</h1>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <table class="table tbl">
                            <tr>
                                <td>Nama Penasdgguna</td>
                                <td>
                                    <input type="text" name="NamaPengguna" class="form-control " value="Rama" readonly>
                                    <input type="hidden" name="IdPengguna" class="form-control " value="1">
                                </td>
                            </tr>
                            
                            <tr>
                                <td>Tanggal</td>
                                <td><input type="text" name="Tanggal" class="form-control " value="{{ date('d-m-Y') }}" readonly></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-sm-6">
                        <p id="Total" class="text-right" style="font-size: 100px;">0</p>
                    </div>
                </div>
            </div>
            
            <div style="clear:both;"></div>
            <div class="col-lg-12 style-col pad">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Id Produk</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Diskon (%)</th>
                            <th>Sub Total</th>
                        </thead>

                        <tbody>
                            <tr onkeydown="del(this)">
                                <td>1</td>
                                <td><input type="text" name="IdProduk[]" class="form-control " onchange='viewProduk(this)'></td>
                                <td><input type="text" name="NamaProduk[]" class="form-control "></td>
                                <td><input type="number" name="Qty[]" step="0.1" class="form-control " value=1 onkeydown="dblTab(this,'HargaJual')" onfocus="this.select()" onblur="calculate(this)"></td>
                                <td><input type="number" name="HargaJual[]" class="form-control " value=0 onblur="calculate(this)" readonly></td>
                                <td><input type="number" name="Diskon[]" class="form-control " id='enter' value=0 onblur="calculate(this)" onfocus="this.select()" onkeydown="subTtl(this)"></td>
                                <td><input type="number" name="SubTotal[]" class="form-control "  readonly></td>
                            </tr>
                        </tbody>
                    </table>    
                </div>
            </div>
            
            <!--PopupPenjualan-->
            <div class="modal fade" id="pnj" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add">Penjualan</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="text-center">Total</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="number" id="TotalForm" name="Total" class="form-control " readonly required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Potongan</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="number" id="Ptngan" name="Potongan" value="0" class="form-control " onfocus="this.select()" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Grand Total</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="number" id="grndTtal" name="GrandTotal" class="form-control " readonly required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Bayar</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="number" id="byr" name="Bayar" value="0" class="form-control " onfocus="this.select()" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Kembali</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="number" id="kmbl" name="Kembali" class="form-control " readonly required>
                                </div>
                            </div>
        
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" id="btnSimpanPrint" class="btn btn-success">Simpan & Print</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--End-->
        </form>
    </div>
@endsection