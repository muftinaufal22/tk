@extends('layouts.Frontend.app')

@section('title')
    Detail Kegiatan - {{ $kegiatan->nama_kegiatan }}
@endsection

@section('content')
@section('about')
<div class="news-details-page-area" style="padding: 40px 0; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh;">
    <div class="container" style="max-width: 1200px; width: 100%; margin: 0 auto;">
        {{-- Row to center the main content column --}}
        <div class="row justify-content-center">
            {{-- Main Content Area (col-lg-9) --}}
            <div class="row justify-content-center" style="margin-top: 30px;">
                {{-- Content Box - Centered container with all content centered --}}
                <div class="news-details-content" style="background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; margin: 0 auto; max-width: 800px;">

                    {{-- 1. Title (Centered) --}}
                    <h2 style="font-weight: bold; margin-bottom: 15px; color: #333; font-size: 28px; line-height: 1.4;">{{ $kegiatan->nama_kegiatan }}</h2>

                    {{-- 2. Metadata (Date) - Centered --}}
                    <p style="color: #888; font-size: 14px; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; display: inline-block;">
                        <i class="fa fa-calendar" aria-hidden="true" style="margin-right: 8px;"></i> {{ Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('j F Y') }}
                    </p>

                    {{-- 3. Image (Perfectly centered) --}}
                    <div class="news-img-holder" style="margin-bottom: 30px; text-align: center;">
                        @if($kegiatan->gambar)
                            <img src="{{ asset('storage/images/kegiatan/' . $kegiatan->gambar) }}" class="img-responsive" alt="{{ $kegiatan->nama_kegiatan }}" style="max-width: 100%; height: auto; border-radius: 8px; display: inline-block; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        @endif
                    </div>

                    {{-- 4. Description (Centered text with better readability) --}}
                    <div class="news-details-text" style="font-size: 16px; line-height: 1.8; color: #555; text-align: center; max-width: 700px; margin: 0 auto;">
                        {!! $kegiatan->deskripsi !!}
                    </div>

                    {{-- Optional: Back button (centered) --}}
                    <div style="margin-top: 40px; text-align: center;">
                        <a href="{{ url()->previous() }}" class="btn btn-primary" style="padding: 10px 25px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; display: inline-block; transition: background-color 0.3s;">
                            <i class="fa fa-arrow-left" style="margin-right: 8px;"></i> Kembali
                        </a>
                    </div>

                    {{-- Commented out "Kegiatan Lainnya" section --}}
                    <!-- 
                    <hr style="margin-top: 40px; margin-bottom: 40px; border-top: 1px solid #eee;">
                    <div class="course-details-comments">
                        ...
                    </div> 
                    -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endsection