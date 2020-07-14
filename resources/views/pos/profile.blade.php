@extends('pos.layout.layout')
@section('title-page')
    POS - Profile Management
@endsection
@section('add-css')
  
@endsection
@section('add-js')
    <script src="{{ asset('vendor/fileinput/fileinput.min.js') }}"></script>
    <script>
        $("#profile-photo").fileinput({
            overwriteInitial: true,
            maxFileSize: 1500,
            showClose: false,
            showCaption: false,
            showBrowse: false,
            browseOnZoneClick: true,
            removeLabel: '',
            removeIcon: '<i class="fa fa-trash"></i>',
            removeTitle: 'Cancel or reset changes',
            elErrorContainer: '#error-photo',
            msgErrorClass: 'alert alert-danger alert-dismissible fade show',
            defaultPreviewContent: '<img class="img-fluid px-3 px-sm-4 mt-3 mb-4" src="{{ asset('img/undraw_posting_photo.svg') }}" alt=""><h6 class="text-muted">Click to select</h6>',
            layoutTemplates: {main2: '{preview} {remove} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif"]
        });
    </script>
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data User</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="row">
            
            <div class="col-lg-12 mb-4">

                <!-- Profile Picture -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Profile Picture</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 border-right">
                                <div class="text-center">
                                    <input type="file" name="" id="profile-photo">

                                    <div id="error-photo" role="alert"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Email address</label>
                                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Email address</label>
                                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Email address</label>
                                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Email address</label>
                                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Email address</label>
                                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
    </form>
@endsection