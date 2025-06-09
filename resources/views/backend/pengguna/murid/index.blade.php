@extends('layouts.backend.app')

@section('title')
    Murid
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
                    <h2 class="content-header-title float-left mb-0">Data Murid</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i data-feather="home" class="me-1"></i>Dashboard</a></li>
                            <li class="breadcrumb-item active">Murid</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <section>
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Daftar Murid</h4>
                        </div>
                        <div class="card-datatable p-2">
                            <table class="dt-responsive table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>NISN</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No WhatsApp</th>
                                        <th>Status</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>    
                                <tbody>
                                    @foreach ($murid as $key => $murids)
                                        <tr>
                                            <td></td>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{$murids->muridDetail->nisn ?? '-'}}</td>
                                            <td>{{$murids->name}}</td>
                                            <td>{{$murids->kelas ? $murids->kelas->nama : '-'}}</td>
                                            <td>{{$murids->muridDetail->jenis_kelamin ?? '-'}}</td>
                                            <td>{{$murids->muridDetail->whatsapp ?? '-'}}</td>
                                            <td class="text-center">
                                                @if($murids->status == 'Aktif')
                                                    <span class="badge bg-success"><i data-feather="check-circle" class="me-1"></i>Aktif</span>
                                                @else
                                                    <span class="badge bg-danger"><i data-feather="x-circle" class="me-1"></i>Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{$murids->role == 'Guest' ? 'Calon Murid' : 'Murid'}}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{route('backend-pengguna-murid.show', $murids->id)}}" class="btn btn-sm btn-primary">
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                  
                                                    <form action="{{ route('backend-pengguna-murid.destroy', $murids->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
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