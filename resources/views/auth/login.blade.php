@extends('layouts.header')
@section('title','Login | ProdEmailTrackr')
@section('main_content')
<div class="page-wraper">

    <!-- Content -->
    <div class="browse-job login-style3">
        <!-- Coming Soon -->
        <div class="bg-img-fix overflow-hidden" style="background:#fff url('{{ asset('images/background/bg6.jpg') }}'); height: 100vh;">
            <div class="row gx-0">
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12 vh-100 bg-white ">
                    <div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: 653px;" tabindex="0">
                        <div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
                            <div class="login-form style-2">


                                <div class="card-body">
                                    <div class="logo-header">
                                        <a href="#" class="logo"><img src="{{ asset('images/logo/PET-196x47.png') }}" alt="" class="width-230 light-logo"></a>
                                        <a href="#" class="logo"><img src="{{ asset('images/logo/logofull-white.png') }}" alt="" class="width-230 dark-logo"></a>
                                    </div>

                                    <nav>
                                        <div class="nav nav-tabs border-bottom-0" id="nav-tab" role="tablist">

                                            <div class="tab-content w-100" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="nav-personal" role="tabpanel" aria-labelledby="nav-personal-tab">
                                                    <form  method="POST" action="{{ route('login') }}" class=" dz-form pb-3">
                                                        @csrf
                                                        <h3 class="form-title m-t0">Personal Information</h3>
                                                        <div class="dz-separator-outer m-b5">
                                                            <div class="dz-separator bg-primary style-liner"></div>
                                                        </div>
                                                        <p>Enter your e-mail address and your password. </p>
                                                        <div class="form-group mb-3">
                                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                                            @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group text-left mb-5 forget-main">
                                                            <button type="submit" class="btn btn-primary button-md btn-block">Sign Me In</button>
                                                            @if (Route::has('password.request'))
                                                                <a class="nav-link m-auto btn tp-btn-light btn-primary forget-tab" href="{{ route('password.request') }}">
                                                                    {{ __('Forgot Your Password?') }}
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </form>
                                                    <div class="text-center bottom">
                                                        <a class="btn btn-primary button-md btn-block"  href="{{ route('register') }}">Create an account</a>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="nav-forget" role="tabpanel" aria-labelledby="nav-forget-tab">
                                                    <form class="dz-form">
                                                        <h3 class="form-title m-t0">Forget Password ?</h3>
                                                        <div class="dz-separator-outer m-b5">
                                                            <div class="dz-separator bg-primary style-liner"></div>
                                                        </div>
                                                        <p>Enter your e-mail address below to reset your password. </p>
                                                        <div class="form-group mb-4">
                                                            <input name="dzName" required="" class="form-control" placeholder="Email Address" type="text">
                                                        </div>
                                                        <div class="form-group clearfix text-left">
                                                            <button class=" active btn btn-primary" id="nav-personal-tab" data-bs-toggle="tab" data-bs-target="#nav-personal" type="button" role="tab" aria-controls="nav-personal" aria-selected="true">Back</button>
                                                            <button class="btn btn-primary float-end">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </nav>
                                </div>
                                <div class="card-footer">
                                    <div class=" bottom-footer clearfix m-t10 m-b20 row text-center">
                                        <div class="col-lg-12 text-center">
												<span> © Copyright by
												<a href="javascript:void(0);">More Ideas </a> All rights reserved.</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: block;">
                            <div class="mCSB_draggerContainer">
                                <div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 0px; display: block; height: 652px; max-height: 643px; top: 0px;">
                                    <div class="mCSB_dragger_bar" style="line-height: 0px;"></div><div class="mCSB_draggerRail"></div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Full Blog Page Contant -->
    </div>
    <!-- Content END-->
</div>
@endsection

