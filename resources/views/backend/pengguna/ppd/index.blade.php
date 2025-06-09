@extends('layouts.backend.app')
@section('title', 'Pengaturan PPDB')
@section('content')
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="alert-body d-flex align-items-center">
            <i data-feather="check-circle" class="me-2"></i>
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@elseif($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="alert-body d-flex align-items-center">
            <i data-feather="x-circle" class="me-2"></i>
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Pengaturan PPDB</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}" class="text-decoration-none"><i data-feather="home" class="me-1"></i>Dashboard</a></li>
                            <li class="breadcrumb-item active">Pengaturan PPDB</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <section>
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Pengaturan Buka/Tutup Pendaftaran PPDB</h4>
                        </div>
                        <div class="card-datatable p-2">
                            <form action="{{ route('ppd.update') }}" method="POST" class="mt-1">
                                @csrf
                                @method('PUT')
                                
                                <div class="row mb-2">
                                    <div class="col-12 col-sm-6 mb-1 mb-sm-0">
                                        <label class="form-label" for="tanggal_buka">Tanggal Buka Pendaftaran</label>
                                        <input type="date" id="tanggal_buka" name="tanggal_buka" class="form-control" value="{{ $setting->tanggal_buka ?? '' }}">
                                        <small class="text-muted">Kosongkan jika tidak ada batasan tanggal buka.</small>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label" for="tanggal_tutup">Tanggal Tutup Pendaftaran</label>
                                        <input type="date" id="tanggal_tutup" name="tanggal_tutup" class="form-control" value="{{ $setting->tanggal_tutup ?? '' }}">
                                        <small class="text-muted">Kosongkan jika tidak ada batasan tanggal tutup.</small>
                                    </div>
                                </div>
                                
                                <div class="mb-2">
                                    <label class="form-label" for="pesan_nonaktif">Pesan saat Pendaftaran Ditutup</label>
                                    <textarea id="pesan_nonaktif" name="pesan_nonaktif" class="form-control" rows="3" placeholder="Contoh: Pendaftaran PPDB tahun ajaran baru akan dibuka pada tanggal...">{{ $setting->pesan_nonaktif ?? 'Pendaftaran PPDB saat ini ditutup.' }}</textarea>
                                    <small class="text-muted">Pesan ini akan ditampilkan kepada calon pendaftar saat pendaftaran ditutup.</small>
                                </div>
                                
                                <div class="mb-2">
                                    <div class="custom-control custom-switch custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ $setting->is_active ? 'checked' : '' }} value="1">
                                        <label class="custom-control-label" for="is_active">Aktifkan Pendaftaran PPDB</label>
                                    </div>
                                    <small class="text-muted d-block mt-1">Centang untuk mengaktifkan pendaftaran PPDB. Jika tidak dicentang, pendaftaran akan ditutup terlepas dari pengaturan tanggal.</small>
                                </div>
                                
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary mr-1">Simpan Pengaturan</button>
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection