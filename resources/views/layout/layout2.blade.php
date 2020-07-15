<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>@yield('title-page')</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
        
        <!-- CSS
        ============================================ -->
    
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <!-- Icon Font CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}">
        <!-- Plugins CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
        <!-- Main Style CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

        @yield('add-css')
        <!-- Modernizer JS -->
        <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    </head>

    <body>
        <header class="header-area header-in-container clearfix">
            <div class="header-bottom sticky-bar header-res-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-2 col-lg-2 col-md-6 col-4">
                            <div class="logo">
                                <a href="/">
                                    <img alt="" src="{{ asset('assets/img/logo/logo.png') }}">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 d-none d-lg-block">
                            <div class="main-menu">
                                <nav>
                                    <ul>
                                        <li><a href="/">Home</a></li>
                                        <li><a href="/shop">Shop</a></li>
                                        <li><a href="/about">About </a></li>
                                        <li><a href="/contact">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6 col-8">
                            <div class="header-right-wrap">
                                <div class="same-style account-satting">
                                    <a class="account-satting-active" href="#"><i class="pe-7s-user-female"></i></a>
                                    <div class="account-dropdown">
                                    @if (Auth::guard('web')->user())
                                        <ul>
                                            <li>{{Auth::guard('web')->user()->NamaPelanggan}}</li>
                                            <li><a ref="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">Logout</a></li>                            
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </ul>
                                    @else
                                        <ul>
                                            <li><a href="/login">Login</a></li>
                                        </ul>
                                    @endif
                                    </div>
                                </div>
                                @yield('cart')
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area">
                        <div class="mobile-menu">
                            <nav id="mobile-menu-active">
                                <ul class="menu-overflow">
                                    <li><a href="/">Home</a></li>
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
        @yield('content')

        <footer class="footer-area bg-gray pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="copyright mb-30">
                            <div class="footer-logo">
                                <a href="/">
                                    <img alt="" src="{{ asset('assets/img/logo/logo.png') }}">
                                </a>
                            </div>
                            <p>© 2020 <a href="#">Dandelion Fashion Shop</a>.<br> All Rights Reserved</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="footer-widget mb-30 ml-30">
                            <div class="footer-title">
                                <h3>ABOUT US</h3>
                            </div>
                            <div class="footer-list">
                                <ul>
                                    <li><a href="about.html">About us</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 col-sm-6">
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

        @yield('modal')

        <!-- JS
        ============================================ -->

        <!-- jQuery JS -->
        <script src="{{ asset('assets/js/vendor/jquery-v3.4.1.min.js') }}"></script>
        <!-- Popper JS -->
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <!-- Bootstrap JS -->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <!-- Plugins JS -->
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <!-- Ajax Mail -->
        <script src="{{ asset('assets/js/ajax-mail.js') }}"></script>
        <!-- Main JS -->
        <script src="{{ asset('assets/js/main.js') }}"></script>

        @yield('add-js')

    </body>

</html>