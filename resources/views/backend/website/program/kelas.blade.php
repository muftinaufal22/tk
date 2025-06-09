@extends('layouts.backend.app')

@section('title')
    Daftar Murid {{ $kelas->nama ?? 'A' }}
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
                    <h2 class="content-header-title float-start mb-0">Daftar Murid {{ $kelas->nama ?? 'A' }}</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Kelas {{ $kelas->nama ?? 'A' }}</li>
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
                            <h4 class="card-title">Daftar Murid Kelas {{ $kelas->nama ?? 'A' }}</h4>
                            <div class="card-header-elements">
                                <span class="badge bg-primary">Total: {{ $murid->count() }} Murid</span>
                            </div>
                        </div>
                        <div class="card-datatable p-2">
                            <table class="dt-responsive table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>    
                                <tbody>
                                    @forelse ($murid as $key => $item)
                                        <tr>
                                            <td></td>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <span>{{$item->name}}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($item->muridDetail && $item->muridDetail->jenis_kelamin)
                                                    <span class="badge bg-{{ $item->muridDetail->jenis_kelamin == 'L' ? 'primary' : 'warning' }}">
                                                        {{ $item->muridDetail->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary">{{$item->muridDetail->tahun_ajaran ?? '2023/2024'}}</span>
                                            </td>
                                            <td class="text-center">
                                               <span class="badge bg-{{ $item->status == 'Aktif' ? 'success' : 'danger' }}">
                                                            {{$item->status}}
                                                        </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('guru.detail.murid', $item->id) }}" 
                                                   class="btn btn-sm btn-primary"
                                                   data-bs-toggle="tooltip" 
                                                   title="Lihat Detail">
                                                    <i data-feather="eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        
                                      
                                    @endforelse
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

@section('styles')
<style>
    .content-header-title {
        font-weight: 600;
        color: #5e5873;
    }
    
    .card-header-elements {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #5e5873;
        border-color: #ebe9f1;
    }
    
    .table td {
        border-color: #ebe9f1;
        vertical-align: middle;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .empty-state {
        padding: 2rem;
    }
    
    .btn-group .btn {
        margin-right: 2px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    .bg-light-primary {
        background-color: rgba(115, 103, 240, 0.12) !important;
    }
    
    .alert-body {
        padding: 0.75rem 1.25rem;
    }
</style>
@endsection

@section('scripts')
<script>
    // Initialize feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

@endsection