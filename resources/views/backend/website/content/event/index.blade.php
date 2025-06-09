@extends('layouts.backend.app')

@section('title')
    Event 
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
                    <h2 class="content-header-title float-left mb-0">Event</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i data-feather="home" class="me-1"></i>Dashboard</a></li>
                            <li class="breadcrumb-item active">Event</li>
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
                            <h4 class="card-title">Event List</h4>
                            <a href="{{ route('backend-event.create') }}" class="btn btn-primary waves-effect waves-float waves-light">
                               <i data-feather="plus-circle" class="me-1"></i>Tambah Event
                            </a>
                        </div>
                        <div class="card-datatable p-2">
                            <table class="dt-responsive table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Event</th>
                                        <th>Jenis Event</th>                   
                                        <th>Lokasi</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>    
                                <tbody>
                                    @foreach ($event as $key => $events)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="fw-bold">{{ $events->title }}</td>
                                            <td>
                                                <span class="badge rounded-pill 
                                                    @if($events->jenis_event == '1') bg-primary
                                                    @elseif($events->jenis_event == '2') bg-success  
                                                    @else bg-warning
                                                    @endif">
                                                    <i data-feather="calendar" class="me-1"></i>
                                                    Event {{ $events->jenis_event }}
                                                </span>
                                            </td>
                                            <td><i data-feather="map-pin" class="me-1"></i>{{ $events->lokasi }}</td>
                                            <td><i data-feather="clock" class="me-1"></i>{{ \Carbon\Carbon::parse($events->acara)->format('d M Y H:i') }}</td>
                                            <td>
                                                <span class="badge rounded-pill {{ $events->is_active == '0' ? 'bg-success' : 'bg-secondary' }}">
                                                    <i data-feather="{{ $events->is_active == '0' ? 'check-circle' : 'x-circle' }}" class="me-1"></i>
                                                    {{ $events->is_active == '0' ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('backend-event.edit', $events->id) }}" class="btn btn-sm btn-success me-1" data-bs-toggle="tooltip" title="Edit">
                                                        <i data-feather="edit-2"></i>
                                                    </a>
                                                    <form action="{{ route('backend-event.destroy', $events->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
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