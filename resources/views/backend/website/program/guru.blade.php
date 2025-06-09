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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jurusan as $key => $item)
                                            <tr>
                                                <td></td>
                                                <td>{{$key+1}}</td>
                                                <td>{{$item->hari}}</td>
                                                <td>{{$item->pelajaran}}</td>
                                                <td>{{ Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}</td>
                                                <td>{{$item->kelas ? $item->kelas->nama : 'Tidak ada kelas'}}</td>
                                                <td class="text-center">
                                                    @if($item->is_active == 1)
                                                        <span class="badge bg-success"><i data-feather="check-circle" class="me-1"></i>Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger"><i data-feather="x-circle" class="me-1"></i>Tidak Aktif</span>
                                                    @endif
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

@push('styles')
<style>
    .badge {
        font-size: 0.875em;
    }

    .info-box {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        border-radius: .25rem;
        margin-bottom: 1rem;
    }

    .card-outline.card-primary {
        border-top: 3px solid #007bff;
    }

    .table th {
        border-top: none;
        font-weight: 600;
    }

    .table td {
        vertical-align: middle;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush