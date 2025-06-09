@extends('layouts.backend.app')

@section('title')
    Jadwal Pelajaran
@endsection

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
                <i data-feather="alert-circle" class="me-2"></i>
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
                    <h2 class="content-header-title float-left mb-0">Jadwal Pelajaran</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i data-feather="home" class="me-1"></i>Dashboard</a></li>
                            <li class="breadcrumb-item active">Jadwal pelajaran</li>
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
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Jadwal Pelajaran</h4>
                            <a href="{{route('program-studi.create')}}" class="btn btn-primary">
                                <i data-feather="plus-circle" class="me-1"></i>
                                <span>Tambah Jadwal</span>
                            </a>
                        </div>
                        <div class="card-datatable p-2">
                            <table class="dt-responsive table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>Hari</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Waktu</th>
                                        <th>Kelas</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>    
                                <tbody>
                                    @foreach ($jurusan as $key => $jurusans)
                                        <tr>
                                            <td></td>
                                            <td>{{$key+1}}</td>
                                            <td>{{$jurusans->hari}}</td>
                                            <td>{{$jurusans->pelajaran}}</td>
                                            <td>{{$jurusans->jam_mulai}} - {{$jurusans->jam_selesai}}</td>
                                            <td>{{$jurusans->kelas ? $jurusans->kelas->nama : 'Tidak ada kelas'}}</td>
                                            <td class="text-center">
                                                @if($jurusans->is_active == 1)
                                                    <span class="badge bg-success"><i data-feather="check-circle" class="me-1"></i>Aktif</span>
                                                @else
                                                    <span class="badge bg-danger"><i data-feather="x-circle" class="me-1"></i>Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-inline-flex">
                                                    <a href="{{route('program-studi.edit', $jurusans->id)}}" class="btn btn-sm btn-icon btn-success me-1" data-bs-toggle="tooltip" title="Edit">
                                                        <i data-feather="edit"></i>
                                                    </a>
                                                    <form action="{{ route('program-studi.destroy', $jurusans->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal pelajaran ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" title="Hapus">
                                                            <i data-feather="trash-2"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach    
                                </tbody>                                   
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection