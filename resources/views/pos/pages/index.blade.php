@extends('pos.layout.layout')

@section('title-page')
    POS - Dashboard
@endsection

@section('add-css')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('add-js')
  <!-- Page level plugins -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('/vendor/chart.js/Chart.min.js') }}"></script>

  <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    var dataaoff = @php echo $totaltransaksioff; @endphp;
    var dataaon = @php echo $totaltransaksion; @endphp;

    // alert(data);

    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
      // *     example: number_format(1234.56, 2, ',', ' ');
      // *     return: '1 234,56'
      number = (number + '').replace(',', '').replace(' ', '');
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + Math.round(n * k) / k;
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }

    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Earnings",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: dataaon,
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function(value, index, values) {
                return 'Rp. ' + number_format(value);
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
            }
          }
        }
      }
    });

    // Area Chart Example
    var ctx1 = document.getElementById("myAreaChart1");
    var myLineChart1 = new Chart(ctx1, {
      type: 'line',
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Earnings",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: dataaoff,
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function(value, index, values) {
                return 'Rp. ' + number_format(value);
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
            }
          }
        }
      }
    });

    //console.log("{{ $kategoriChartLabel }}");
    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: {!! $kategoriChartLabel !!},
        datasets: [{
          data: {!! $kategoriChartCount !!},
          backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#245DEF', '#8247AE'],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 80,
      },
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "",
        ordering: false,
        paging: false,
        keys: true,
        columns: [
            {data: 'IdTransaksi', name: 'IdTransaksi'},
            {data: 'NamaPelanggan', name: 'NamaPelanggan'},
            {data: 'StatusPesanan', name: 'StatusPesanan'},
            {data: 'Aksi', name: 'Aksi', orderable: false, searchable: false},
        ]
    });


    function detail(a){
        var kode = 'IdTransaksi='+ a;
        $.ajax({
            type: "GET",
            url: "{{ url('/pos/detailtransaksi/') }}/"+a+"/",
            data: kode,
            success: function(msg){
                console.log(msg.detailtransaksi);
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
                    var dataa = dataa+'<tr class="border-bottom append">'+
                                    '<td>'+
                                        '<div class="font-weight-bold">'+msg.detailtransaksi[i].produk.NamaProduk+'</div>'+
                                        '<div class="small text-muted d-none d-md-block">'+msg.detailtransaksi[i].IdProduk+' - '+msg.detailtransaksi[i].stokproduk.warna.NamaWarna+' - '+msg.detailtransaksi[i].stokproduk.ukuran.NamaUkuran+'</div>'+
                                    '</td>'+
                                    '<td class="text-right font-weight-bold">Rp. '+msg.detailtransaksi[i].produk.HargaJual.toLocaleString()+'</td>'+
                                    '<td class="text-right font-weight-bold">'+msg.detailtransaksi[i].Qty+'</td>'+
                                    '<td class="text-right font-weight-bold">Rp. '+msg.detailtransaksi[i].SubTotal.toLocaleString()+'</td>'+
                                '</tr>';
                }
            
                $("#detail-trans").prepend(dataa);
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
    });

  </script>
  @if(session()->has('alert'))
    <script type="text/javascript" >
        swal('Error!', '{{ session()->get('alert') }}', 'error');
    </script>
  @endif
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      </div>

      <!-- Content Row -->
      <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pendapatan Hari Ini</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    @foreach($pendapatanSum as $p)
                    Rp. {{ number_format($p->pendapatanSum,0,',',',') }}
                    @endforeach  
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Produk Terjual Hari Ini</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    @foreach($qtySum as $q)
                    {{ $q->qtySum }} Pcs
                    @endforeach
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-tshirt fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Transaksi Hari Ini</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    @foreach($transaksiCount as $t)
                    {{ $t->transaksiCount }} Transaksi
                    @endforeach
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-clipboard fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Online Order Belum Selesai</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    @foreach($pesananbelumselesai as $p)
                    {{ $p->pesananbelumselesai }} Transaksi
                    @endforeach  
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-comments fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Content Row -->

      <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Penjualan Online Shop Tahun 2020</h6>
              <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                  <div class="dropdown-header">Dropdown Header:</div>
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Kategori Terlaris</h6>
              <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                  <div class="dropdown-header">Dropdown Header:</div>
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-pie pt-4 pb-2">
                <canvas id="myPieChart"></canvas>
              </div>
              <div class="mt-4 text-center small">

                @php
                  $warna = array('#4e73df', '#1cc88a', '#36b9cc', '#245DEF', '#8247AE');
                  $i = 0;
                @endphp
                @foreach ($kategoriTerlaris as $label)
                  
                  <span class="mr-2">
                  <i class="fas fa-circle" style="color: {{ $warna[$i] }}"></i> {{ $label->NamaKategori }}
                  </span>
                  @php
                      $i++;
                  @endphp
                @endforeach

              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Content Row -->

      <div class="row">

        <!-- Last Order -->
        <div class="col-xl-6 col-lg-12">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Pesanan Terbaru Yang Harus Diproses</h6>
              <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                  <div class="dropdown-header">Dropdown Header:</div>
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover data-table" style="white-space: nowrap;">
                  <thead>
                  <tr>
                    <th>Id Transaksi</th>
                    <th>Nama Pelanggan</th>
                    <th>Status Pesanan</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <a href="/pos/transaksi/" class="btn btn-info btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-arrow-right"></i>
                </span>
                <span class="text">Lihat Pesanan Hari Ini</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Area Chart -->
        <div class="col-xl-6 col-lg-12">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Penjualan Point Of Sale Tahun 2020</h6>
              <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                  <div class="dropdown-header">Dropdown Header:</div>
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-area">
                <canvas id="myAreaChart1"></canvas>
              </div>
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