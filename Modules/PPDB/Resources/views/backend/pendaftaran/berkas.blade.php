@extends('layouts.backend.app')

@section('title')
    Form Pendaftaran
@endsection

@section('content')
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2>Form Pendaftaran PPDB RA Al Barokah</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header header-bottom">
                        <h4>Berkas Pendaftaran</h4>
                    </div>
                    <div class="card-body">
                        <form action=" {{url('ppdb/form-berkas', $berkas->id)}} " method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="basicInput">Kartu Keluarga</label>
                                        <input type="file" class="form-control @error('kartu_keluarga') is-invalid @enderror" name="kartu_keluarga" />
                                        @error('kartu_keluarga')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="basicInput">Akte Kelahiran</label>
                                        <input type="file" class="form-control @error('akte_kelahiran') is-invalid @enderror" name="akte_kelahiran" />
                                        @error('akte_kelahiran')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="basicInput">Ktp</label>
                                        <input type="file" class="form-control @error('ktp') is-invalid @enderror" name="ktp" />
                                        <small class="text-danger">Rapor Semester 1-4, harap satukan pada 1 file .pdf.</small>
                                        @error('ktp')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                               

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="basicInput">foto</label>
                                        <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" />
                                        <small class="text-danger">Dapat menyusul.</small>
                                        @error('foto')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <a href="/home" class="btn btn-warning">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection