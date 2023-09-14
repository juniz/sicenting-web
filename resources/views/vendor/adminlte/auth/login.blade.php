@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
<link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url',
'password/reset') )

@if (config('adminlte.use_route_url', false))
@php( $login_url = $login_url ? route($login_url) : '' )
@php( $register_url = $register_url ? route($register_url) : '' )
@php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
@php( $login_url = $login_url ? url($login_url) : '' )
@php( $register_url = $register_url ? url($register_url) : '' )
@php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.login_message'))

@section('auth_body')
@include('flash-message')
<form action="{{ $login_url }}" method="post">
    @csrf

    {{-- Email field --}}
    <div class="input-group mb-3">
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}" placeholder="{{ __('Email') }}" autofocus>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Password field --}}
    <div class="input-group mb-3">
        <input id="password" type="password" name="password" type="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="{{ __('adminlte::adminlte.password') }}">

        <div class="input-group-append">
            <div class="input-group-text">
                <span id="password-button" class="fas fa-lock"></span>
            </div>
        </div>

        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- <div class="form-group mb-3">
        <div class="captcha">
            <span>{!! captcha_img() !!}</span>
            <button type="button" class="btn btn-danger" class="reload" id="reload">
                &#x21bb;
            </button>
        </div>
    </div>

    <div class="form-group mb-3">
        <input id="captcha" type="text" class="form-control" placeholder="Masukkan captcha" name="captcha">
        @error('captcha')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div> --}}

    {{-- Login field --}}
    <div class="row">
        <div class="col-7">
            <div class="icheck-primary" title="{{ __('adminlte::adminlte.remember_me_hint') }}">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label for="remember">
                    {{ __('adminlte::adminlte.remember_me') }}
                </label>
            </div>
        </div>

        <div class="col-5">
            <button type=submit class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                <span class="fas fa-sign-in-alt"></span>
                {{ __('adminlte::adminlte.sign_in') }}
            </button>
        </div>
    </div>

</form>
@stop

@section('auth_footer')
<div class="social-auth-links text-center mt-2 mb-3">
    <a href="/auth/google" class="btn btn-block btn-danger">
        <i class="fab fa-google-plus mr-2"></i> Login dengan Google
    </a>
</div>
{{-- Password reset link --}}
{{-- @if($password_reset_url)
<p class="my-0">
    <a href="{{ $password_reset_url }}">
        {{ __('adminlte::adminlte.i_forgot_my_password') }}
    </a>
</p>
@endif --}}

{{-- Register link --}}
{{-- @if($register_url)
<p class="my-0">
    <a href="{{ $register_url }}">
        {{ __('adminlte::adminlte.register_a_new_membership') }}
    </a>
</p>
@endif --}}
@stop

@push('css')
<style>
    /* .social-auth-links{
            display: none;
        } */

    .login-box {
        margin-bottom: 25vh !important;
        padding-left: 25px !important;
        /* height: 25% !important; */
    }

    .login-page {
        background-image: url("{{ url('assets/img/background.jpg') }}") !important;
        background-size: cover !important;
        /* background-attachment: fixed !important; */
        background-repeat: no-repeat !important;
        background-position: center !important;
    }

    @media only screen and (max-width: 1024px) {
        .login-page {
            background-image: url("{{ url('assets/img/mobile.jpg') }}") !important;
            background-size: cover !important;
            background-attachment: fixed !important;
            background-repeat: no-repeat !important;
            background-position: center !important;

        }

        .login-box {
            margin-bottom: 40vh !important;
        }

        .app-name {
            font-size: 1.5rem !important;
            /* padding-top: 10px !important; */
        }

        .logo-app {
            width: 15vw !important;
            height: 15vh !important;
            object-fit: contain !important;
            justify-content: center !important;
            padding-top: 10vh !important;
            /* visibility: hidden !important; */
        }
    }

    .logo-app {
        width: 10vw;
        height: 10vh;
        object-fit: contain;
        justify-content: center;
        padding-top: 10px;
        /* visibility: hidden; */
    }
</style>
@endpush

@push('js')
<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: "{{ url('reload-captcha') }}",
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });

    $('#password-button').click(function () {
        var x = document.getElementById("password");
        if (x.type === "password") {
            $('#password-button').removeClass('fa-lock');
            $('#password-button').addClass('fa-lock-open');
            x.type = "text";
        } else {
            $('#password-button').removeClass('fa-lock-open');
            $('#password-button').addClass('fa-lock');
            x.type = "password";
        }
    });
</script>
@endpush