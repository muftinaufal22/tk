@extends('layouts.backend.app')

@section('content')
<div class="container">
    <h1>PPDB Management</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-3">
        <p>Status PPDB: 
            @if($status)
                <span class="badge bg-success">Terbuka</span>
            @else
                <span class="badge bg-danger">Tertutup</span>
            @endif
        </p>
    </div>

    <form action="{{ $status ? route('ppd.close') : route('ppd.open') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-{{ $status ? 'danger' : 'success' }}">
            {{ $status ? 'Tutup PPDB' : 'Buka PPDB' }}
        </button>
    </form>
</div>
@endsection