@extends('layouts.Frontend.app')

@section('title')
Berita & Kegiatan
@endsection

@section('content')
@section('about')
<div class="news-page-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="text-center mb-4" style="color: #006400; margin-bottom: 30px;">Berita dan Kegiatan</h2> <!-- JUDUL HALAMAN: Ubah text dan warna di sini -->

                <!-- SECTION: Form Pencarian -->
                <div class="row mb-4" style="margin-bottom: 2rem !important;"> <!-- JARAK FORM: margin-bottom mengatur jarak form dengan content -->
                    <div class="col-12">
                        <form action="{{ route('berita') }}" method="GET" class="form-inline justify-content-center">
                            <!-- INPUT SEARCH: Field pencarian text -->
                            <div class="form-group mx-sm-3 mb-2">
                                <input type="text" name="search" class="form-control" placeholder="Cari berita atau kegiatan..." value="{{ $search ?? '' }}">
                            </div>
                            <!-- INPUT DATE: Field pencarian tanggal -->
                            <div class="form-group mx-sm-3 mb-2">
                                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal ?? '' }}">
                            </div>
                            <!-- BUTTON SEARCH: Tombol cari -->
                            <button type="submit" class="btn btn-primary mb-2">Cari</button>
                            @if($search || $tanggal)
                            <!-- BUTTON RESET: Tombol reset pencarian -->
                            <a href="{{ route('berita') }}" class="btn btn-secondary mb-2 ml-2">Reset</a>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- SECTION: Grid Layout Cards - Tampilan card berita/kegiatan -->
                <div class="row" style="margin: 0 -8px;"> <!-- ROW CONTAINER: Jarak horizontal antar card -->
                    @forelse ($paginatedItems as $item)
                    <!-- COLUMN: Setiap card item -->
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="padding: 0 8px; margin-bottom: 30px;"> <!-- JARAK VERTIKAL: margin-bottom mengatur jarak antar baris -->
                        <!-- CARD CONTAINER: Styling utama card -->
                        <div class="card h-100" style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border: none;">
                            <!-- IMAGE SECTION: Thumbnail berita/kegiatan -->
                            <div class="card-img-top" style="height: 200px; overflow: hidden;"> <!-- TINGGI GAMBAR: ubah height untuk mengatur tinggi gambar -->
                                @if($item->type == 'kegiatan')
                                <a href="{{ route('detail.kegiatan', $item->id) }}">
                                    <img src="{{asset('storage/images/kegiatan/' .$item->thumbnail)}}" class="img-fluid w-100" alt="{{ $item->title }}" style="object-fit: cover; height: 100%;">
                                </a>
                                @else
                                <img src="{{asset('storage/images/berita/' .$item->thumbnail)}}" class="img-fluid w-100" alt="{{ $item->title }}" style="object-fit: cover; height: 100%;">
                                @endif
                            </div>
                            <!-- CONTENT SECTION: Judul dan meta info -->
                            <div class="card-body" style="padding: 15px;"> <!-- PADDING KONTEN: mengatur jarak dalam card -->
                                <!-- TITLE: Judul berita/kegiatan -->
                                <h5 class="card-title" style="font-weight: 600; margin-bottom: 10px; font-size: 14px; line-height: 1.4;"> <!-- UKURAN JUDUL: font-size mengatur besar kecil judul -->
                                    @if($item->type == 'kegiatan')
                                    <a href="{{route('detail.kegiatan', $item->id)}}" style="color: #333; text-decoration: none;">
                                        {{$item->title}}
                                        @if($item->is_new)
                                        <!-- BADGE BARU: Label untuk item baru -->
                                        <span class="badge badge-danger" style="background-color: #ff5252; font-size: 10px; padding: 3px 6px; border-radius: 3px; color: white; margin-left: 5px;">Baru</span>
                                        @endif
                                    </a>
                                    @else
                                    <a href="{{route('detail.berita', $item->slug)}}" style="color: #333; text-decoration: none;">{{$item->title}}</a>
                                    @endif
                                </h5>

                                <!-- META INFO: Tanggal, author, kategori -->
                                <div class="card-text" style="font-size: 12px; color: #666; margin-top: 8px;"> <!-- UKURAN META: font-size mengatur ukuran text meta -->
                                    @if($item->type == 'kegiatan')
                                    <span><i class="fa fa-calendar" aria-hidden="true"></i> {{Carbon\Carbon::parse($item->tanggal)->format('d M Y')}}</span>
                                    <span class="ml-2"><i class="fa fa-tag" aria-hidden="true"></i> Kegiatan</span>
                                    @else
                                    <span><i class="fa fa-user" aria-hidden="true"></i> {{$item->user->name}}</span>
                                    <span class="ml-2"><i class="fa fa-tags" aria-hidden="true"></i> {{$item->kategori->nama}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <!-- EMPTY STATE: Tampilan ketika tidak ada data -->
                    <div class="col-12 text-center">
                        <img src="{{asset('Assets/Frontend/img/empty.svg')}}" class="img-responsive" style="max-width: 300px; margin: 30px auto;"> <!-- GAMBAR KOSONG: Ubah ukuran dengan max-width -->
                        <p class="text-center">Tidak ada berita atau kegiatan yang ditemukan</p> <!-- PESAN KOSONG: Ubah text pesan di sini -->
                    </div>
                    @endforelse
                </div>

                <!-- SECTION: Pagination -->
                <div class="row">
                    <div class="col-12 d-flex justify-content-center mt-4"> <!-- JARAK PAGINATION: margin-top mengatur jarak pagination -->
                        {{ $paginatedItems->links('frontend.content.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endsection
