@extends('layout.layout2')

@section('title-page')
    Login/Register - Dandelion Fashion Shop 
@endsection

@section('add-css')
    <link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.standalone.min.css') }}" rel="stylesheet">
@endsection

@section('add-js')
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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
                url: "{{ url('/register/add/provinsi/') }}/"+this.value+"/",
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
                url: "{{ url('/register/add/kabupaten/') }}/"+this.value+"/",
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
    </script>
@endsection

@section('content')
    <div class="login-register-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4> login </h4>
                            </a>
                            <a data-toggle="tab" href="#lg2">
                                <h4> register </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{route('login')}}" method="post">
                                            @csrf
                                            <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                                                <label for="email">Email Address</label>
                                                <input type="email" class="form-control {{ $errors->has('email') ? ' form-control-danger' : '' }}" id="email" name="email" placeholder="Masukkan email anda" value="{{ old('email') }}" required autofocus> 
                                                @if ($errors->has('email'))
                                                <label class="error mt-2 text-danger">{{ $errors->first('email') }}</label>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control {{ $errors->has('password') ? 'form-control-danger' : '' }}" id="password" name="password" placeholder="Masukkan password anda" required> 
                                                @if ($errors->has('password'))
                                                <label class="error mt-2 text-danger">{{ $errors->first('password') }}</label>
                                                @endif
                                            </div> 
                                            <div class="button-box">
                                                <button type="submit"><span>Login</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="lg2" class="tab-pane">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{route('register')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label>Nama Pelanggan</label>
                                                <input type="text" class="form-control" name="NamaPelanggan" placeholder="Masukkan Nama anda" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="Email" placeholder="Masukkan Email anda" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" name="Password" placeholder="Masukkan Password anda" required>
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
                                                <input type="text" class="form-control tgl" name="TglLahir" placeholder="Masukkan Tanggal Lahir anda" required>
                                            </div> 
                                            <div class="form-group">
                                                <label>No Handphone</label>
                                                <input type="text" class="form-control" name="NoHandphone" placeholder="Masukkan No Handphone anda" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <textarea name="Alamat" class="form-control" placeholder="Masukkan Alamat anda"></textarea>
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
                                            <div class="button-box">
                                                <button type="submit"><span>Register</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
