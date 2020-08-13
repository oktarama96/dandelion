@extends('layout.layout2')

@section('title-page')
    Contact - Dandelion Fashion Shop
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray-3">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li class="active">Contact us</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="contact-area pt-100 pb-100">
        <div class="container">
            <div class="contact-map mb-10">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31560.105788169527!2d115.17897995078529!3d-8.594726114571477!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x540a38a983a84cf3!2sDandelion%20Fashion%20Shop!5e0!3m2!1sid!2sid!4v1597343581707!5m2!1sid!2sid" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
            <div class="custom-row-2">
                <div class="col-lg-4 col-md-5">
                    <div class="contact-info-wrap">
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="contact-info-dec">
                                <p>+6281 2465 8526 9</p>
                            </div>
                        </div>
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="contact-info-dec">
                                <p><a href="mailto:dandelionshop128@gmail.com">dandelionshop128@gmail.com</a></p>
                            </div>
                        </div>
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="contact-info-dec">
                                <p>Abianbase Street, 128 </p>
                                <p>Mengwi, Badung, Bali.</p>
                            </div>
                        </div>
                        <div class="contact-social text-center">
                            <h3>Follow Us</h3>
                            <ul>
                                <li><a href="https://www.facebook.com/dandelion.butik"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://www.instagram.com/dandelionshop128/"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="contact-form">
                        <div class="contact-title mb-30 text-center">
                            <h2>Happy Shopping!</h2>
                            <p>Toko fisik kita buka setiap hari mulai dari jam 09.00 sampai dengan jam 22.00.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection