index.blade.php(resources/views/backed/web/penerimaan)

@extends('layouts.backend.app')

@section('title')
    Penerimaan Siswa
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
                    <h2>Penerimaan Siswa</h2>
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
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">Penerimaan Siswa <a href=" {{route('penerimaan.create')}} " class="btn btn-primary">Tambah</a> </h4>
                                </div>
                                <div class="card-datatable">
                                    <table class="dt-responsive table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Status Penerimaan</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>    
                                        <tbody>
                                           @foreach ($penerimaan as $key => $data)
                                                <tr>
                                                    <td> {{$key+1}} </td>
                                                    <td> {{$data->tgl_mulai}} </td>
                                                    <td> {{$data->tgl_selesai}} </td>
                                                    <td> 
                                                        @if($data->status_penerimaan == 'dibuka')
                                                            Dibuka
                                                        @elseif($data->status_penerimaan == 'ditutup')
                                                            Ditutup
                                                        @else
                                                            Status Tidak Diketahui
                                                        @endif
                                                    </td>
                                                    <td> {{$data->keterangan}} </td>
                                                    <td class="d-flex">
                                                        <a href="{{ route('penerimaan.edit', $data->id) }}" class="btn btn-success btn-sm mr-1">Edit</a>
                                                        <form action="{{ route('penerimaan.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data penerimaan ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                        </form>
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