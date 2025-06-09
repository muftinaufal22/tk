@extends('layouts.backend.app')

@section('title')
   Edit Jadwal Pelajaran
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
                    <h2> Jadwal Pelajaran</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header header-bottom">
                        <h4>Edit Jadwal Pelajaran</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('program-studi.update', $jurusan->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="basicInput">Hari</label> <span class="text-danger">*</span>
                                        <select class="form-control @error('hari') is-invalid @enderror" name="hari">
                                            <option value="">Pilih Hari</option>
                                            <option value="Senin" {{$jurusan->hari == 'Senin' ? 'selected' : ''}}>Senin</option>
                                            <option value="Selasa" {{$jurusan->hari == 'Selasa' ? 'selected' : ''}}>Selasa</option>
                                            <option value="Rabu" {{$jurusan->hari == 'Rabu' ? 'selected' : ''}}>Rabu</option>
                                            <option value="Kamis" {{$jurusan->hari == 'Kamis' ? 'selected' : ''}}>Kamis</option>
                                            <option value="Jumat" {{$jurusan->hari == 'Jumat' ? 'selected' : ''}}>Jumat</option>
                                            <option value="Sabtu" {{$jurusan->hari == 'Sabtu' ? 'selected' : ''}}>Sabtu</option>
                                        </select>
                                        @error('hari')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="basicInput">Waktu</label> <span class="text-danger">*</span>
                                        <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" name="jam_mulai" value="{{$jurusan->jam_mulai}}" placeholder="Jam Mulai" />
                                        <input type="time" class="form-control mt-1 @error('jam_selesai') is-invalid @enderror" name="jam_selesai" value="{{$jurusan->jam_selesai}}" placeholder="Jam Selesai" />
                                        @error('jam_mulai')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                        @error('jam_selesai')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="basicInput">Mata Pelajaran</label> <span class="text-danger">*</span>
                                        <textarea name="pelajaran" class="form-control @error('pelajaran') is-invalid @enderror" cols="30" rows="10">{{$jurusan->pelajaran}}</textarea>
                                        @error('pelajaran')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="basicInput">Kelas</label> <span class="text-danger">*</span>
                                        <select name="kelas" class="form-control @error('kelas') is-invalid @enderror">
                                            <option value="">-- Pilih --</option>
                                            @foreach($kelas as $k)
                                                <option value="{{ $k->id }}" {{ $jurusan->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('kelas')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="basicInput">Status</label> <span class="text-danger">*</span>
                                        <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                            <option value="1" {{$jurusan->is_active == 1 ? 'selected' : ''}}>Aktif</option>
                                            <option value="0" {{$jurusan->is_active == 0 ? 'selected' : ''}}>Tidak Aktif</option>
                                        </select>
                                        @error('is_active')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="{{route('program-studi.index')}}" class="btn btn-warning">Batal</a>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection