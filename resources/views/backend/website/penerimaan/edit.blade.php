edit.blade.php(resources/views/backed/web/penerimaan)

@extends('layouts.backend.app')

@section('title')
    Edit Penerimaan Siswa
@endsection

@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            <div class="alert-body">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        </div>
    @elseif($message = Session::get('error'))
        <div class="alert alert-danger" role="alert">
            <div class="alert-body">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        </div>
    @endif

<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2>Penerimaan Siswa</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header header-bottom">
                        <h4>Edit Penerimaan Siswa</h4>
                    </div>
                    <div class="card-body">
                        <form action=" {{route('penerimaan.update', $penerimaan->id)}} " method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Tanggal Mulai -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="basicInput">Tanggal Mulai</label> <span class="text-danger">*</span>
                                        <input type="datetime-local" class="form-control @error('tgl_mulai') is-invalid @enderror" name="tgl_mulai" value="{{ $penerimaan->tgl_mulai }}" required />
                                        @error('tgl_mulai')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tanggal Selesai -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="basicInput">Tanggal Selesai</label> <span class="text-danger">*</span>
                                        <input type="datetime-local" class="form-control @error('tgl_selesai') is-invalid @enderror" name="tgl_selesai" value="{{ $penerimaan->tgl_selesai }}" required />
                                        @error('tgl_selesai')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status Penerimaan -->
                                <div class="col-6">
                                        <div class="form-group">
                                            <label for="basicInput">Status Penerimaan</label> <span class="text-danger">*</span>
                                            <select name="status_penerimaan" class="form-control" required>
                                                <option value="dibuka" {{ old('status_penerimaan', $penerimaan->status_penerimaan ?? '') == 'dibuka' ? 'selected' : '' }}>Dibuka</option>
                                                <option value="ditutup" {{ old('status_penerimaan', $penerimaan->status_penerimaan ?? '') == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                                            </select>
                                            @error('status_penerimaan')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                <!-- Keterangan -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="basicInput">Keterangan</label>
                                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan') }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror                                    </div>
                                </div>

                            </div>
                            <button class="btn btn-primary" type="submit">Update Penerimaan</button>
                            <a href="{{route('penerimaan.index')}}" class="btn btn-warning">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection