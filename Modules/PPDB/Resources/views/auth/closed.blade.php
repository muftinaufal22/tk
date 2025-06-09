@extends('ppdb::layouts.master')
@section('title', 'Pendaftaran Ditutup')
@section('content')
<div class="inner-page-banner-area" style="background-image: url('img/banner/5.jpg');">
    <div class="container">
        <div class="pagination-area">
            <h1>Pendaftaran PPDB</h1>
            <ul>
                <li><a href="{{ url('/') }}">Beranda</a> -</li>
                <li>Pendaftaran Ditutup</li>
            </ul>
        </div>
    </div>
</div>

<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Pendaftaran Ditutup</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle mr-2"></i> {{ $message }}
                    </div>
                    <p>Silahkan kembali pada waktu yang telah ditentukan atau hubungi pihak sekolah untuk informasi lebih lanjut.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
