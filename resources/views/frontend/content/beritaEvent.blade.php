<!-- <div id="header2" class="header4-area">
    <div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="header-top-left" style="display: flex; align-items: center;">
                        <div class="logo-area" style="flex-shrink: 0; margin-right: 15px;">
                            @if (@$footer->logo == NULL)
                                <img class="img-responsive" src="{{asset('Assets/Frontend/img/foto_logo.jpg')}}" alt="logo" style="max-height: 70px;">
                            @else
                                <img class="img-responsive" src="{{asset('storage/images/logo/' .$footer->logo)}}" alt="logo" style="max-height: 70px;">
                            @endif
                        </div>
                        <div class="logo-text">
                            <h2 style="margin: 0; font-size: 22px; font-weight: bold; color: #333;">TK Vianney</h2>
                            <p style="margin: 5px 0 0; font-size: 14px; color: #666; max-width: 300px;">Taman Kanak-Kanak berkualitas dengan fasilitas lengkap dan pengajar kompeten</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class="header-top-right">
                        <ul>
                            <li><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:{{@$footer->telp}}"> {{@$footer->telp}} </a></li>
                            <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:{{@$footer->email}}">{{@$footer->email}}</a></li>
                            <li>
                                @auth
                                    <a href="/home" class="apply-now-btn2">Home</a>
                                @else
                                    <a class="apply-now-btn2" href="{{route('login')}}"> Masuk</a>
                                @endauth
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-menu-area bg-primary" id="sticker">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <nav id="desktop-nav">
                        <ul>
                            <li class="{{ (request()->is('/')) ? 'active' : '' }}"><a href="/">BERANDA</a></li>
                            <li><a href="#">TENTANG KAMI</a>
                                <ul>
                                    <li><a href="{{route('profile.sekolah')}}">Profil Sekolah</a></li>
                                    <li><a href="{{route('visimisi.sekolah')}}">Visi dan Misi</a></li>
                                </ul>
                            </li>
                            <li><a href="#">JADWAL</a>
                                <ul>
                                    <li class="has-child-menu"><a href="#">Jadwal Pelajaran</a>
                                        <ul class="thired-level">
                                            @foreach ($jurusanM as $jurusans)
                                                <li><a href="{{ url('program', $jurusans->slug)}}">{{$jurusans->nama}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="has-child-menu"><a href="#">Kegiatan</a>
                                        <ul class="thired-level">
                                            @foreach ($kegiatanM as $kegiatans)
                                                <li><a href="{{url('kegiatan', $kegiatans->slug)}}">{{$kegiatans->nama}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ (request()->is('berita')) ? 'active' : '' }}"><a href="{{route('berita')}}">BERITA</a></li>
                            <li><a href="{{url('ppdb')}}" target="_blank">PPDB</a></li>
                            <li><a href="#">LAINNYA</a></ul>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

Konten Profil dengan Gambar
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center mb-4" style="font-size: 30px;">Profil Singkat RA AL Barokah</h2>
            
            <div class="profile-content" style="display: flex; background-color: #f9f9f9; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div style="flex: 0 0 200px; margin-right: 30px;">
                    <img src="{{asset('Assets/Frontend/img/foto_logo.jpg')}}" alt="RA Al Barokah" style="width: 100%; border-radius: 8px; object-fit: cover; height: 250px;">
                </div>
                <div style="flex: 1;">
                    <p style="font-size: 16px; line-height: 1.8; color: #34495e; text-align: justify;">
                        RA AL Barokah berdiri pada tahun 2011. Taman kanak-kanak ini menyelenggarakan pendidikan untuk anak-anak usia 2 tahun sampai dengan 5 tahun, terakreditasi dengan kualifikasi "A" dan diakui sebagai sekolah Islam dari Kementerian Agama.
                    </p>
                    <p style="font-size: 16px; line-height: 1.8; color: #34495e; text-align: justify; margin-top: 15px;">
                        Dilengkapi dengan berbagai fasilitas dan sarana pendukung aktivitas belajar yang aman, nyaman, dan ramah bagi anak-anak. Didukung pula dengan suasana belajar yang menyenangkan dan interaktif serta didampingi oleh guru pengajar yang sangat kompeten dan berpengalaman dalam hal pengembangan anak-anak usia dini.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style untuk header */
    .header-top-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .logo-area img {
        max-height: 70px;
        width: auto;
    }

    .logo-text h2 {
        margin: 0;
        font-size: 22px;
        font-weight: bold;
        color: #333;
    }

    .logo-text p {
        margin: 5px 0 0;
        font-size: 14px;
        color: #666;
        max-width: 300px;
    }

    /* Style untuk menu navigasi */
    #desktop-nav > ul > li > a {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 14px;
        color: #333;
        padding: 15px 20px;
    }

    #desktop-nav > ul > li:hover > a {
        color: #007bff;
    }

    /* Style untuk konten profil */
    .profile-content {
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .profile-content p {
        font-size: 16px;
        margin-bottom: 15px;
        text-align: justify;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .profile-content {
            flex-direction: column;
        }
        .profile-content > div {
            flex: 1 1 100%;
            margin-right: 0;
            margin-bottom: 20px;
        }
    }
</style> -->