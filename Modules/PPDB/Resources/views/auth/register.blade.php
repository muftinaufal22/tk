@extends('auth.layout-auth')

@section('title', 'Register')

@section('content')
<style>
    .auth-wrapper {
        position: relative;
        overflow: hidden;
        background: linear-gradient(120deg, #e8f5e9 0%, #4CAF50 100%);
        height: 100vh;
        max-height: 100vh;
    }

    .floating-circle {
        position: absolute;
        font-size: 4rem;
        opacity: 0.4;
        z-index: 0;
        filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.5));
    }

    .circle-1 { top: 5%; left: 5%; animation: float 4s ease-in-out infinite; color: #4CAF50; }
    .circle-2 { top: 15%; left: 35%; animation: float 3.5s ease-in-out infinite 0.2s; color: #81C784; }
    .circle-3 { top: 35%; left: 15%; animation: float 4.5s ease-in-out infinite 0.4s; color: #66BB6A; }
    .circle-4 { top: 55%; left: 35%; animation: float 3.8s ease-in-out infinite 0.6s; color: #A5D6A7; }
    .circle-5 { top: 75%; left: 5%; animation: float 4.2s ease-in-out infinite 0.8s; color: #2E7D32; }
    .circle-6 { top: 25%; left: 55%; animation: float 3.6s ease-in-out infinite 1s; color: #43A047; }
    .circle-7 { top: 45%; left: 65%; animation: float 4.1s ease-in-out infinite 1.2s; color: #388E3C; }
    .circle-8 { top: 65%; left: 55%; animation: float 3.9s ease-in-out infinite 1.4s; color: #1B5E20; }
    .circle-9 { top: 85%; left: 75%; animation: float 4.3s ease-in-out infinite 1.6s; color: #C8E6C9; }
    .circle-10 { top: 10%; left: 85%; animation: float 4s ease-in-out infinite 1.8s; color: #81C784; }
    .circle-11 { top: 30%; left: 80%; animation: float 3.7s ease-in-out infinite 2s; color: #A5D6A7; }
    .circle-12 { top: 50%; left: 90%; animation: float 4.4s ease-in-out infinite 2.2s; color: #66BB6A; }
    .circle-13 { top: 70%; left: 85%; animation: float 3.8s ease-in-out infinite 2.4s; color: #4CAF50; }
    .circle-14 { top: 90%; left: 90%; animation: float 4.2s ease-in-out infinite 2.6s; color: #2E7D32; }
    .circle-15 { top: 20%; left: 25%; animation: float 3.9s ease-in-out infinite 2.8s; color: #1B5E20; }

    @keyframes float {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
            opacity: 0.4;
        }
        50% {
            transform: translateY(-30px) rotate(10deg);
            opacity: 0.8;
        }
    }

    .auth-inner {
        position: relative;
        z-index: 1;
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);


        margin: 20px auto;
        padding: 30px;
        height: calc(100vh - 40px);
        overflow-y: auto;
        max-width: 1200px;
        display: flex;
        align-items: center;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        padding: 2rem !important;
    }

    .brand-logo {
        text-decoration: none;
        margin-bottom: 2rem;
    }

    .brand-logo img {
        margin-right: 1rem;
    }

    body {
        overflow: hidden;
    }

    .btn-primary {
        background-color: #4CAF50 !important;
        border-color: #4CAF50 !important;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #388E3C !important;
        border-color: #388E3C !important;
    }

    .text-primary {
        color: #4CAF50 !important;
    }

    a {
        color: #4CAF50;
    }

    a:hover {
        color: #388E3C;
    }

    .form-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        padding: 0.75rem 1rem;
        border-radius: 8px;
    }

    .img-side {
        background-image: url('/assets/frontend/img/cover_login.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100%;
        margin: 0;
    }
</style>

<div class="auth-wrapper">
    <div class="floating-circle circle-1">⚪</div>
    <div class="floating-circle circle-2">⚪</div>
    <div class="floating-circle circle-3">⚪</div>
    <div class="floating-circle circle-4">⚪</div>
    <div class="floating-circle circle-5">⚪</div>
    <div class="floating-circle circle-6">⚪</div>
    <div class="floating-circle circle-7">⚪</div>
    <div class="floating-circle circle-8">⚪</div>
    <div class="floating-circle circle-9">⚪</div>
    <div class="floating-circle circle-10">⚪</div>
    <div class="floating-circle circle-11">⚪</div>
    <div class="floating-circle circle-12">⚪</div>
    <div class="floating-circle circle-13">⚪</div>
    <div class="floating-circle circle-14">⚪</div>
    <div class="floating-circle circle-15">⚪</div>

    <div class="auth-inner">


        <div class="col-lg-6">
            <div class="login-card">
                <a class="brand-logo d-flex align-items-center" href="/">
                    <img src="{{asset('assets/frontend/img/foto_logo.png')}}" alt="Logo" width="50" height="50">
                    <h2 class="brand-text text-primary ml-1 mb-0">RA Al Barokah</h2>
                </a>

                @if($message = Session::get('error'))
                    <div class="alert alert-danger">
                        <div class="alert-body">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                    </div>
                @endif

                <h2 class="card-title font-weight-bold mb-1">Welcome to RA Al Barokah! 👋</h2>
                <p class="card-text mb-2">Pendaftaran PPDB RA Al barokah</p>

                <form class="auth-login-form mt-2" action="{{route('register.store')}}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Nama Lengkap</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name')}}" placeholder="Masukan Nama Lengkap" autofocus="" tabindex="1" />
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email')}}" placeholder="Masukan Email" tabindex="2" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">No WhatApp </label>
                            <input class="form-control @error('whatsapp') is-invalid @enderror" type="text" name="whatsapp" value="{{old('whatsapp')}}" placeholder="Masukan No WhatsApp" tabindex="3" />
                            @error('whatsapp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Password Login</label>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input class="form-control form-control-merge @error('password') is-invalid @enderror" type="password" name="password" placeholder="············" tabindex="4" />
                                <div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input class="form-control form-control-merge @error('confirm_password') is-invalid @enderror" type="password" name="confirm_password" placeholder="············" tabindex="5" />
                            <div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
                            @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="remember-me" type="checkbox" tabindex="6" />
                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-block" tabindex="7">Daftar</button>
                </form>
            </div>
        </div>


        <div class="col-lg-6 img-side"></div>
    </div>
</div>
@endsection