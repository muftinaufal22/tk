@extends('layouts.backend.app')

@section('title')
    Guru
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
                      <h2 class="content-header-title float-left mb-0">Data Guru</h2>
                      <div class="breadcrumb-wrapper">
                          <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i data-feather="home" class="me-1"></i>Dashboard</a></li>
                              <li class="breadcrumb-item active">Guru</li>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Daftar Guru</h4>
                                    <a href="{{route('backend-pengguna-pengajar.create')}}" class="btn btn-primary">
                                        <i data-feather="plus-circle" class="me-1"></i>
                                        <span>Tambah Guru</span>
                                    </a>
                                </div>
                                <div class="card-datatable p-2">
                                    <table class="dt-responsive table table-hover table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%"></th>
                                                <th width="5%">No</th>
                                                <th>Nama</th>
                                                <th>Mengajar</th>
                                                <th>NIP</th>
                                                <th>Email</th>
                                                <th width="10%">Status</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>    
                                        <tbody>
                                           @foreach ($pengajar as $key => $pengajars)
                                                <tr>
                                                    <td></td>
                                                    <td class="text-center">{{$key+1}}</td>
                                                    <td>{{$pengajars->name}}</td>
                                                    <td>{{$pengajars->userDetail->mengajar}}</td>
                                                    <td>{{$pengajars->userDetail->nip}}</td>
                                                    <td>{{$pengajars->email}}</td>
                                                    <td class="text-center">
                                                        @if($pengajars->status == 'Aktif')
                                                            <span class="badge bg-success"><i data-feather="check-circle" class="me-1"></i>Aktif</span>
                                                        @else
                                                            <span class="badge bg-danger"><i data-feather="x-circle" class="me-1"></i>Tidak Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-1">
                                                            <a href="{{ route('backend-pengguna-pengajar.edit', $pengajars->id) }}" 
                                                               class="btn btn-sm btn-success" 
                                                               data-bs-toggle="tooltip" 
                                                               title="Edit">
                                                                <i data-feather="edit-2"></i>
                                                            </a>
                                                            <form action="{{ route('backend-pengguna-pengajar.destroy', $pengajars->id) }}" 
                                                                  method="POST" 
                                                                  onsubmit="return confirm('Yakin ingin menghapus pengajar ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="btn btn-sm btn-danger" 
                                                                        data-bs-toggle="tooltip" 
                                                                        title="Hapus">
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
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection