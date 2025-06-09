@extends('layouts.backend.app')

@section('title')
   Hapus Event
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
                    <h2> Hapus Event</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header header-bottom">
                        <h4>Konfirmasi Hapus Event</h4>
                    </div>
                    <div class="card-body">
                        <p>Apakah kamu yakin ingin menghapus event berikut ini?</p>
                        <ul>
                            <li><strong>Judul:</strong> {{ $event->title }}</li>
                            <li><strong>Lokasi:</strong> {{ $event->lokasi }}</li>
                            <li><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($event->acara)->translatedFormat('l, d F Y H:i') }}</li>
                        </ul>

                        <form action="{{ route('backend-event.destroy', $event->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Hapus</button>
                            <a href="{{ route('backend-event.index') }}" class="btn btn-warning">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
