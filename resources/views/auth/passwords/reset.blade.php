@extends('auth.layout-auth')

@section('title', 'Reset Password')

@section('content')
<div class="auth-wrapper">
    <div class="auth-inner">
        <!-- Reset Password Section -->
        <div class="col-lg-6 d-flex align-items-center auth-bg">
            <div class="login-card mx-auto w-100 p-3">
                <a class="brand-logo d-flex align-items-center" href="/">
                    <img src="{{ asset('assets/frontend/img/foto_logo.png') }}" alt="Logo" width="50" height="50">
                    <h2 class="brand-text text-primary ml-1 mb-0">RA Al Barokah</h2>
                </a>

                <h2 class="card-title font-weight-bold mb-1">Reset Password</h2>
                <p class="card-text mb-2">Masukkan email dan password baru Anda</p>

                <form class="auth-reset-form mt-2" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="Masukan Email" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input id="password" type="password" class="form-control form-control-merge @error('password') is-invalid @enderror" name="password" placeholder="············" required autocomplete="new-password">
                            <div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">Konfirmasi Password Baru</label>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input id="password-confirm" type="password" class="form-control form-control-merge" name="password_confirmation" placeholder="············" required autocomplete="new-password">
                            <div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                </form>
            </div>
        </div>
        <!-- /Reset Password Section -->

        <!-- Image Section -->
        <div class="col-lg-6 img-side d-none d-lg-flex">
            <!-- Image by CSS -->
        </div>
        <!-- /Image Section -->
    </div>
</div>
@endsection