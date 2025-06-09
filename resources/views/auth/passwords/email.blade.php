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

                @if (session('status'))
                    <div class="alert alert-success">
                        <div class="alert-body">
                            <strong>{{ session('status') }}</strong>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                    </div>
                @endif

                <h2 class="card-title font-weight-bold mb-1">Reset Password</h2>
                <p class="card-text mb-2">Masukkan email Anda untuk menerima link reset password</p>

                <form class="auth-login-form mt-2" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Masukan Email" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Kirim Link Reset Password
                    </button>
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
