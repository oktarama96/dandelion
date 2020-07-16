@extends('layout.layout')

@section('content')
    <header class="header-area header-in-container clearfix">
        <div class="header-bottom sticky-bar header-res-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-6 col-4">
                        <div class="logo">
                            <a href="/">
                                <img alt="" src="assets/img/logo/logo.png">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 d-none d-lg-block">
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li><a href="/">Home</a></li>
                                    <li><a href="/shop">Shop</a></li>
                                    <li><a href="/about">About</a></li>
                                    <li><a href="/contact">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="mobile-menu-area">
                    <div class="mobile-menu">
                        <nav id="mobile-menu-active">
                            <ul class="menu-overflow">
                                <li><a href="/">HOME</a></li>
                                <li><a href="/shop">Shop</a></li>
                                <li><a href="/about">About us</a></li>
                                <li><a href="/contact">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="breadcrumb-area pt-35 pb-35 bg-gray-3">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li class="active">login/Register </li>
                </ul>
            </div>
        </div>
    </div>
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
    <footer class="footer-area bg-gray pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-4">
                    <div class="copyright mb-30">
                        <div class="footer-logo">
                            <a href="/">
                                <img alt="" src="assets/img/logo/logo.png">
                            </a>
                        </div>
                        <p>© 2020 <a href="#">Dandelion Fashion Shop</a>.<br> All Rights Reserved</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4">
                    <div class="footer-widget mb-30 ml-30">
                        <div class="footer-title">
                            <h3>ABOUT US</h3>
                        </div>
                        <div class="footer-list">
                            <ul>
                                <li><a href="/about">About us</a></li>
                                <li><a href="/contact">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-widget mb-30 ml-75">
                        <div class="footer-title">
                            <h3>FOLLOW US</h3>
                        </div>
                        <div class="footer-list">
                            <ul>
                                <li><a href="#">Facebook</a></li>
                                <li><a href="#">Instagram</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endsection
