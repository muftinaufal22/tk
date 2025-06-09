@extends('layouts.backend.app')

@section('title')
    Detail Murid - {{ $murid->name }}
@endsection

@section('content')
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Detail Murid</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Daftar Murid</a></li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="row match-height">
            <!-- Kolom Kanan - Foto Profile & Info Sistem -->
            <div class="col-md-4 order-md-2">
                <!-- Foto Profil Card -->
                <div class="card" style="max-height: 350px;">
                    <div class="card-body text-center">
                        <h5 class="text-primary d-flex align-items-center justify-content-center gap-2 mb-3">
                             <span style="font-size: 24px; color: #333; font-weight: bold; text-transform: uppercase;">Foto Profil</span>
                        </h5>
                        @if($murid->foto_profile)
                            <img src="{{ asset('storage/images/profile/' . $murid->foto_profile) }}" 
                                 alt="Foto Profil" 
                                 class="img-fluid rounded-circle mb-3"
                                 style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" 
                                 style="width: 200px; height: 200px; margin: 0 auto;">
                                <i data-feather="user" style="width: 80px; height: 80px;" class="text-muted"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informasi Kelas Card -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="card-title mb-0 d-flex align-items-center gap-2">
                            <i data-feather="users" class="text-primary"></i>
                            Informasi Kelas
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Kelas</th>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $murid->kelas ? $murid->kelas->nama : '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tahun Ajaran</th>
                                    <td>{{ $murid->muridDetail->tahun_ajaran ?? '2023/2024' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-{{ $murid->status == 'Aktif' ? 'success' : 'danger' }}">
                                            {{ $murid->status }}
                                        </span>
                                    </td>
                                 
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kolom Kiri - Data Murid & Orang Tua -->
            <div class="col-md-8 order-md-1">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">Informasi Detail Murid</h4>
                        <div class="card-header-elements">

                          <div class="col-md-8 order-md-1">
    <div class="card">
        <div class="card-header border-bottom">

            <div class="card-header-elements">
                {{-- Tombol kembali yang mengarah ke kelas sesuai dengan kelas murid --}}
                @if(isset($murid->muridDetail->kelas) && $murid->muridDetail->kelas->nama == 'A')
                    <a href="{{ route('muridA') }}" class="btn btn-secondary btn-sm">
                        <i data-feather="arrow-left" class="me-1"></i> Kembali ke Kelas A
                    </a>
                @elseif(isset($murid->muridDetail->kelas) && $murid->muridDetail->kelas->nama == 'B')
                    <a href="{{ route('muridB') }}" class="btn btn-secondary btn-sm">
                        <i data-feather="arrow-left" class="me-1"></i> Kembali ke Kelas B
                    </a>
                @else
                    {{-- Fallback jika kelas tidak diketahui --}}
                    <button onclick="history.back()" class="btn btn-secondary btn-sm">
                        <i data-feather="arrow-left" class="me-1"></i> Kembali
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Data Murid Section -->
                        <div class="section-data mb-4">
                            <h5 class="text-primary d-flex align-items-center gap-2 mb-3">
                                <span class="fw-bold mt-2">📚 BIODATA SISWA</span>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Nama Lengkap</th>
                                        <td>{{ $murid->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $murid->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIS</th>
                                        <td>{{ $murid->muridDetail->nis ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>NISN</th>
                                        <td>{{ $murid->muridDetail->nisn ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td>{{ $murid->muridDetail->tempat_lahir ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>{{ $murid->muridDetail->tgl_lahir ? date('d F Y', strtotime($murid->muridDetail->tgl_lahir)) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>
                                            @if($murid->muridDetail && $murid->muridDetail->jenis_kelamin)
                                                {{ $murid->muridDetail->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Agama</th>
                                        <td>{{ $murid->muridDetail->agama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No WhatsApp</th>
                                        <td>{{ $murid->muridDetail->whatsapp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ $murid->muridDetail->alamat ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($murid->dataOrtu)
                        <!-- Data Ayah Section -->
                        <div class="section-data mb-4">
                            <h5 class="text-primary d-flex align-items-center gap-2 mb-3">
                                <span class="fw-bold">👨 DATA AYAH</span>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Nama Ayah</th>
                                        <td>{{ $murid->dataOrtu->nama_ayah ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pendidikan Ayah</th>
                                        <td>{{ $murid->dataOrtu->pendidikan_ayah ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan Ayah</th>
                                        <td>{{ $murid->dataOrtu->pekerjaan_ayah ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Ayah</th>
                                        <td>{{ $murid->dataOrtu->alamat_ayah ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Data Ibu Section -->
                        <div class="section-data">
                            <h5 class="text-primary d-flex align-items-center gap-2 mb-3">
                                <span class="fw-bold">👩 DATA IBU</span>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Nama Ibu</th>
                                        <td>{{ $murid->dataOrtu->nama_ibu ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pendidikan Ibu</th>
                                        <td>{{ $murid->dataOrtu->pendidikan_ibu ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan Ibu</th>
                                        <td>{{ $murid->dataOrtu->pekerjaan_ibu ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Ibu</th>
                                        <td>{{ $murid->dataOrtu->alamat_ibu ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @endif

                        <!-- Informasi Tambahan untuk Guru -->
                        <div class="section-data mt-4">
                            <h5 class="text-info d-flex align-items-center gap-2 mb-3">
                                <span class="fw-bold">ℹ️ CATATAN GURU</span>
                            </h5>
                            <div class="alert alert-info">
                                <p class="mb-0">
                                    <strong>Informasi:</strong> Sebagai guru, Anda dapat melihat data lengkap murid untuk keperluan pembelajaran dan evaluasi. 
                                    Untuk perubahan data, silakan hubungi bagian Tata Usaha.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .data-item {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.5rem;
    }
    .data-item label {
        color: #6e6b7b;
        margin-bottom: 0.25rem;
    }
    .data-item p {
        color: #5e5873;
    }
    .section-data {
        padding: 1rem;
        border: 1px solid #ebe9f1;
        border-radius: 0.5rem;
        background-color: #fafafa;
    }
    .info-item {
        padding: 0.5rem;
        border-radius: 0.25rem;
        background-color: #f8f9fa;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #5e5873;
    }
    .table td {
        color: #6e6b7b;
    }
    .card-header-elements {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .content-header-title {
        font-weight: 600;
        color: #5e5873;
    }
</style>
@endsection

@section('scripts')
<script>
    // Initialize feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
</script>

@endsection