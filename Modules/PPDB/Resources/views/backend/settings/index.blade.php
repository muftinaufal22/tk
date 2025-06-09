@extends('layouts.backend.app')
@section('title', 'Pengaturan PPDB')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Pengaturan PPDB</h4>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                
                <form action="{{ route('ppdb.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Buka Pendaftaran</label>
                                <input type="date" name="tanggal_buka" class="form-control" value="{{ $setting->tanggal_buka ?? '' }}">
                                <small class="text-muted">Kosongkan jika tidak ada batasan tanggal buka</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Tutup Pendaftaran</label>
                                <input type="date" name="tanggal_tutup" class="form-control" value="{{ $setting->tanggal_tutup ?? '' }}">
                                <small class="text-muted">Kosongkan jika tidak ada batasan tanggal tutup</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ $setting->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Aktifkan Pendaftaran PPDB</label>
                        </div>
                        <small class="text-muted">Centang untuk mengaktifkan pendaftaran PPDB</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Pesan saat Pendaftaran Ditutup</label>
                        <textarea name="pesan_nonaktif" class="form-control" rows="3">{{ $setting->pesan_nonaktif ?? 'Pendaftaran PPDB saat ini ditutup.' }}</textarea>
                        <small class="text-muted">Pesan yang akan ditampilkan saat pendaftaran ditutup</small>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
