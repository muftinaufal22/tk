@extends('layouts.backend.app')

@section('title')
    Edit Murid
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
                    <h2> Murid</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header header-bottom">
                        <h4>Edit Murid</h4>
                    </div>
                    <div class="card-body">
                        <form action=" {{route('backend-pengguna-murid.update', $murid->id)}} " method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="name">Nama</label> <span class="text-danger">*</span>
                                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $murid->name) }}" placeholder="Nama" />
                                        @error('name')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label> <span class="text-danger">*</span>
                                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $murid->email) }}" placeholder="Email" />
                                        @error('email')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="status">Status</label> <span class="text-danger">*</span>
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="">-- Pilih --</option>
                                            <option value="Aktif" {{ old('status', $murid->status) == 'Aktif' ? 'selected' : '' }} >Aktif</option>
                                            <option value="Tidak Aktif" {{ old('status', $murid->status) == 'Tidak Aktif' ? 'selected' : '' }} >Tidak Aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="kelas">Kelas</label> <span class="text-danger">*</span>
                                        <select name="kelas" id="kelas" class="form-control @error('kelas') is-invalid @enderror">
                                            <option value="">-- Pilih --</option>
                                            @foreach($kelas as $k)
                                                <option value="{{ $k->id }}" {{ old('kelas', $murid->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('kelas')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nis">NIS</label> <span class="text-danger">*</span>
                                        <input type="text" id="nis" class="form-control @error('nis') is-invalid @enderror" name="nis" value="{{ old('nis', $murid->muridDetail->nis ?? '') }}" placeholder="NIS" />
                                        @error('nis')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nisn">NISN</label> <span class="text-danger">*</span>
                                        <input type="text" id="nisn" class="form-control @error('nisn') is-invalid @enderror" name="nisn" value="{{ old('nisn', $murid->muridDetail->nisn ?? '') }}" placeholder="NISN" />
                                        @error('nisn')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="whatsapp">Whatsapp</label> <span class="text-danger">*</span>
                                        <input type="text" id="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ old('whatsapp', $murid->muridDetail->whatsapp ?? '') }}" placeholder="Whatsapp" />
                                        @error('whatsapp')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="{{ old('tempat_lahir', $murid->muridDetail->tempat_lahir ?? '') }}" placeholder="Tempat Lahir" />
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                        <input type="date" id="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror" name="tgl_lahir" value="{{ old('tgl_lahir', $murid->muridDetail->tgl_lahir ?? '') }}" />
                                        @error('tgl_lahir')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label> <span class="text-danger">*</span>
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                            <option value="">-- Pilih --</option>
                                            <option value="L" {{ old('jenis_kelamin', $murid->muridDetail->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }} >Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin', $murid->muridDetail->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }} >Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="agama">Agama</label>
                                        <input type="text" id="agama" class="form-control @error('agama') is-invalid @enderror" name="agama" value="{{ old('agama', $murid->muridDetail->agama ?? '') }}" placeholder="Agama" />
                                        @error('agama')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Alamat">{{ old('alamat', $murid->muridDetail->alamat ?? '') }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="tahun_ajaran">Tahun Ajaran</label>
                                        <input type="text" id="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror" name="tahun_ajaran" value="{{ old('tahun_ajaran', $murid->muridDetail->tahun_ajaran ?? '') }}" placeholder="Tahun Ajaran" />
                                        @error('tahun_ajaran')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="foto_profile">Foto Profil</label>
                                        <input type="file" id="foto_profile" class="form-control-file @error('foto_profile') is-invalid @enderror" name="foto_profile" />
                                        @error('foto_profile')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                        @if($murid->foto_profile)
                                            <small class="form-text text-muted mt-1">Current: <a href="{{ Storage::url('public/images/profile/' . $murid->foto_profile) }}" target="_blank">{{ $murid->foto_profile }}</a></small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <h4>Data Orang Tua</h4>
                                    <hr>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama_ayah">Nama Ayah</label>
                                        <input type="text" id="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" name="nama_ayah" value="{{ old('nama_ayah', $murid->dataOrtu->nama_ayah ?? '') }}" placeholder="Nama Ayah" />
                                        @error('nama_ayah')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="pendidikan_ayah">Pendidikan Ayah</label>
                                        <input type="text" id="pendidikan_ayah" class="form-control @error('pendidikan_ayah') is-invalid @enderror" name="pendidikan_ayah" value="{{ old('pendidikan_ayah', $murid->dataOrtu->pendidikan_ayah ?? '') }}" placeholder="Pendidikan Ayah" />
                                        @error('pendidikan_ayah')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                                        <input type="text" id="pekerjaan_ayah" class="form-control @error('pekerjaan_ayah') is-invalid @enderror" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $murid->dataOrtu->pekerjaan_ayah ?? '') }}" placeholder="Pekerjaan Ayah" />
                                        @error('pekerjaan_ayah')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="alamat_ayah">Alamat Ayah</label>
                                        <textarea class="form-control @error('alamat_ayah') is-invalid @enderror" id="alamat_ayah" name="alamat_ayah" rows="3" placeholder="Alamat Ayah">{{ old('alamat_ayah', $murid->dataOrtu->alamat_ayah ?? '') }}</textarea>
                                        @error('alamat_ayah')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama_ibu">Nama Ibu</label>
                                        <input type="text" id="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror" name="nama_ibu" value="{{ old('nama_ibu', $murid->dataOrtu->nama_ibu ?? '') }}" placeholder="Nama Ibu" />
                                        @error('nama_ibu')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="pendidikan_ibu">Pendidikan Ibu</label>
                                        <input type="text" id="pendidikan_ibu" class="form-control @error('pendidikan_ibu') is-invalid @enderror" name="pendidikan_ibu" value="{{ old('pendidikan_ibu', $murid->dataOrtu->pendidikan_ibu ?? '') }}" placeholder="Pendidikan Ibu" />
                                        @error('pendidikan_ibu')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                        <input type="text" id="pekerjaan_ibu" class="form-control @error('pekerjaan_ibu') is-invalid @enderror" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $murid->dataOrtu->pekerjaan_ibu ?? '') }}" placeholder="Pekerjaan Ibu" />
                                        @error('pekerjaan_ibu')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="alamat_ibu">Alamat Ibu</label>
                                        <textarea class="form-control @error('alamat_ibu') is-invalid @enderror" id="alamat_ibu" name="alamat_ibu" rows="3" placeholder="Alamat Ibu">{{ old('alamat_ibu', $murid->dataOrtu->alamat_ibu ?? '') }}</textarea>
                                        @error('alamat_ibu')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <h4>Berkas Murid</h4>
                                    <hr>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="kartu_keluarga">Kartu Keluarga (PDF, JPG, PNG)</label>
                                        <input type="file" id="kartu_keluarga" class="form-control-file @error('kartu_keluarga') is-invalid @enderror" name="kartu_keluarga" />
                                        @error('kartu_keluarga')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                        @if($murid->berkas && $murid->berkas->kartu_keluarga)
                                            <small class="form-text text-muted mt-1">Current: <a href="{{ Storage::url('public/images/berkas_murid/' . $murid->berkas->kartu_keluarga) }}" target="_blank">{{ $murid->berkas->kartu_keluarga }}</a></small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="akte_kelahiran">Akte Kelahiran (PDF, JPG, PNG)</label>
                                        <input type="file" id="akte_kelahiran" class="form-control-file @error('akte_kelahiran') is-invalid @enderror" name="akte_kelahiran" />
                                        @error('akte_kelahiran')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                        @if($murid->berkas && $murid->berkas->akte_kelahiran)
                                            <small class="form-text text-muted mt-1">Current: <a href="{{ Storage::url('public/images/berkas_murid/' . $murid->berkas->akte_kelahiran) }}" target="_blank">{{ $murid->berkas->akte_kelahiran }}</a></small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="ktp">KTP (PDF, JPG, PNG)</label>
                                        <input type="file" id="ktp" class="form-control-file @error('ktp') is-invalid @enderror" name="ktp" />
                                        @error('ktp')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                        @if($murid->berkas && $murid->berkas->ktp)
                                            <small class="form-text text-muted mt-1">Current: <a href="{{ Storage::url('public/images/berkas_murid/' . $murid->berkas->ktp) }}" target="_blank">{{ $murid->berkas->ktp }}</a></small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="foto">Foto (PDF, JPG, PNG)</label>
                                        <input type="file" id="foto" class="form-control-file @error('foto') is-invalid @enderror" name="foto" />
                                        @error('foto')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                        @if($murid->berkas && $murid->berkas->foto)
                                            <small class="form-text text-muted mt-1">Current: <a href="{{ Storage::url('public/images/berkas_murid/' . $murid->berkas->foto) }}" target="_blank">{{ $murid->berkas->foto }}</a></small>
                                        @endif
                                    </div>
                                </div>


                            </div>
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{route('backend-pengguna-murid.index')}}" class="btn btn-warning">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection