@extends('layouts.backend.app')

@section('title')
    Kegiatan
@endsection

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-body d-flex align-items-center">
                <i data-feather="check-circle" class="me-2"></i>
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @elseif($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="alert-body d-flex align-items-center">
                <i data-feather="alert-circle" class="me-2"></i>
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Dokumentasi</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i data-feather="home" class="me-1"></i>Dashboard</a></li>
                            <li class="breadcrumb-item active">Dokumentasi</li>
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
                        <div class="card-header border-bottom bg-light">
                            <h4 class="card-title"><i data-feather="calendar" class="me-2"></i>Daftar Kegiatan</h4>
                            <div class="dt-action-buttons text-right">
                                <div class="dt-buttons">
                                    <a href="{{ route('backend-kegiatan.create') }}" class="btn btn-primary btn-add-record">
                                        <i data-feather="plus-circle" class="me-1"></i>Tambah Kegiatan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-datatable p-2">
                            <table class="dt-responsive table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th style="width: 15%">Nama Kegiatan</th>
                                        <th class="text-center" style="width: 15%">Gambar</th>
                                        <th class="text-center" style="width: 10%">Tanggal</th>
                                        <th style="width: 30%">Deskripsi</th>
                                        <th class="text-center" style="width: 10%">Status</th>
                                        <th class="text-center" style="width: 15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach ($kegiatan as $key => $kegiatans)
                                        <tr>
                                            <td class="text-center">{{ $key+1 }}</td>
                                            <td class="font-weight-bold">{{ $kegiatans->nama_kegiatan }}</td>
                                            <td class="text-center">
                                                @if($kegiatans->gambar)
                                                    <img src="{{ asset('storage/images/kegiatan/' . $kegiatans->gambar) }}" alt="{{ $kegiatans->nama_kegiatan }}" class="img-thumbnail" style="max-height: 80px;">
                                                @else
                                                    <span class="badge bg-light-secondary"><i data-feather="image" class="me-1"></i>Tidak ada gambar</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($kegiatans->tanggal)->format('d M Y') }}</td>
                                            <td>
                                                <div class="description-box" style="max-height: 100px; overflow-y: auto;">
                                                    {{ Str::limit($kegiatans->deskripsi, 150) }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($kegiatans->is_active == 1)
                                                    <span class="badge bg-success"><i data-feather="check-circle" class="me-1"></i>Aktif</span>
                                                @else
                                                    <span class="badge bg-danger"><i data-feather="x-circle" class="me-1"></i>Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{route('backend-kegiatan.edit', $kegiatans->id)}}" class="btn btn-sm btn-success me-1" data-toggle="tooltip" title="Edit">
                                                        <i data-feather="edit-2"></i>
                                                    </a>
                                                    <form action="{{ route('backend-kegiatan.destroy', $kegiatans->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')" data-toggle="tooltip" title="Hapus">
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

@section('scripts')
<script>
    $(document).ready(function() {
        // Check if DataTable is already initialized before initializing
        if (!$.fn.DataTable.isDataTable('.dt-responsive')) {
            $('.dt-responsive').DataTable({
                responsive: true,
                language: {
                    paginate: {
                        previous: '<i data-feather="chevron-left"></i>',
                        next: '<i data-feather="chevron-right"></i>'
                    }
                },
                dom: '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
                    '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
                    '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons text-end"B>>' +
                    '>t' +
                    '<"d-flex justify-content-between mx-2 row mb-1"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    '>',
                drawCallback: function() {
                    // Re-initialize Feather Icons after table draw
                    if (feather) {
                        feather.replace({
                            width: 14,
                            height: 14
                        });
                    }
                    // Re-initialize tooltips after table draw
                    $('[data-toggle="tooltip"]').tooltip({
                        placement: 'top',
                        trigger: 'hover'
                    });
                }
            });
        }

        // Initialize Feather Icons on initial load
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }

        // Initialize tooltips on initial load
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'top',
            trigger: 'hover'
        });

        // Add hover effect to table rows
        $('.table-hover tbody tr').hover(
            function() { $(this).addClass('bg-light'); },
            function() { $(this).removeClass('bg-light'); }
        );
    });
</script>
@endsection
