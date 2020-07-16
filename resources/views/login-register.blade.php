@extends('layout.layout2')

@section('title-page')
    Login/Register - Dandelion Fashion Shop 
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
                                                <input type="password" class="form-control {{ $errors->has('password') ? 'form-control-danger' : '' }}" id="password" name="password" required> 
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
                                        <form action="#" method="post">
                                            <input type="text" name="user-name" placeholder="Username">
                                            <input type="password" name="user-password" placeholder="Password">
                                            <input name="user-email" placeholder="Email" type="email">
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
