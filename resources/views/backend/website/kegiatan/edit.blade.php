@extends('layouts.backend.app')

@section('title')
   Edit Dokumentasi Kegiatan
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
                    <h2> Dokumentasi</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header header-bottom">
                        <h4>Edit Dokumentasi</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('backend-kegiatan.update', $kegiatan->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="basicInput">Nama Kegiatan</label> <span class="text-danger">*</span>
                                        <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" value="{{$kegiatan->nama_kegiatan}}" name="nama_kegiatan" placeholder="Nama Kegiatan" />
                                        @error('nama_kegiatan')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="basicInput">Tanggal</label> <span class="text-danger">*</span>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" value="{{$kegiatan->tanggal}}" name="tanggal" />
                                        @error('tanggal')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="basicInput">Gambar</label>
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar" placeholder="gambar" />
                                        @error('gambar')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="basicInput">Deskripsi</label> <span class="text-danger">*</span>
                                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" cols="30" rows="10">{{$kegiatan->deskripsi}}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                              
                              <div class="col-6">
                                  <div class="form-group">
                                      <label for="basicInput">Status</label>
                                      <select name="is_active" class="form-control">
                                          <option value="1" {{ $kegiatan->is_active == 1 ? 'selected' : '' }}>Aktif</option>
                                          <option value="0" {{ $kegiatan->is_active == 0 ? 'selected' : '' }}>Non-Aktif</option>
                                      </select>
                                  </div>
                              </div>

                            </div>
                            <div class="text-right">
                                <a href="{{route('backend-kegiatan.index')}}" class="btn btn-warning">Batal</a>
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