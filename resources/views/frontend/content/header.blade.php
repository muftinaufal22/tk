<div id="header2" class="header4-area">
    <div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="header-top-left" style="display: flex; align-items: center;">
                        <div class="logo-area" style="flex-shrink: 0; margin-right: 15px;">
                            @if (@$footer->logo == NULL)
                                <img class="img-responsive" src="{{asset('Assets/Frontend/img/foto_logo.png')}}" alt="logo" style="max-height: 60px;">
                            @else
                                <img class="img-responsive" src="{{asset('storage/images/logo/' .$footer->logo)}}" alt="logo" style="max-height: 60px;">
                            @endif
                        </div>
                        <div class="logo-text">
                            <h2 style="margin: 0; font-size: 18px; font-weight: bold; color: #333;">RA Al Barokah</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class="header-top-right">
                        <ul>
                            <li><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:{{@$footer->telp}}"> {{@$footer->telp}} </a></li>
                            <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="#">{{@$footer->email}}</a></li>
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

    <!-- Main Menu Area -->
    <div class="main-menu-area bg-primary" id="sticker">
        <div class="container">
            <div class="row justify-content-center"> <!-- Center the menu -->
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                    <nav id="desktop-nav">
                        <ul class="d-flex justify-content-center"> <!-- Center the items -->
                            <li class="{{ (request()->is('/')) ? 'active' : '' }}"><a href="/">Beranda</a></li>
                            <li><a href="#">Tentang Kami</a></li>
                            <li class="{{ (request()->is('berita')) ? 'active' : '' }}"><a href=" {{route('berita')}} ">Berita</a></li>
                            <li><a href="{{url('ppdb')}}" target="_blank">PPDB</a></li>
                            <li><a href="#">Lainnya</a>
                                <ul>
                                    <!-- Add your links here -->
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Mobile Menu Area Start -->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <ul class="d-flex justify-content-center"> <!-- Center the items -->
                            <li class="active"><a href="#">Beranda</a></li>
                            <li><a href="#">Tentang Kami</a>
                                <ul>
                                    <li><a href=" {{route('profile.sekolah')}} ">Profile Sekolah</a></li>
                                    <li><a href=" {{route('visimisi.sekolah')}} ">Visi dan Misi</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Program</a>
                                <ul>
                                    <li class="has-child-menu"><a href="#">Program Studi</a>
                                        <ul class="thired-level">
                                            @foreach ($jurusanM as $jurusans)
                                                <li><a href=" {{ url('program', $jurusans->slug)}} "> {{$jurusans->nama}} </a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="has-child-menu"><a href="#">Kegiatan</a>
                                        <ul class="thired-level">
                                            @foreach ($kegiatanM as $kegiatans)
                                                <li><a href=" {{url('kegiatan', $kegiatans->slug)}} ">{{$kegiatans->nama}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ (request()->is('berita')) ? 'active' : '' }}"><a href=" {{route('berita')}} ">Berita</a></li>
                            <li><a href="{{url('ppdb')}}" target="_blank">PPDB</a></li>
                            <li><a href="#">Lainnya</a>
                                <ul>
                                    <li><a href="">Perpustakaan</a></li>
                                    <li><a href="">Alumni</a></li>
                                </ul>
                            </li>
                            <li>
                                @auth
                                    <a href="">{{Auth::user()->name}}</a>
                                @else
                                    <a href=" {{route('login')}} ">Masuk</a>
                                @endauth
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mobile Menu Area End -->

<style>
    /* Center main menu */
    .main-menu-area {
        display: flex;
        justify-content: center; /* Center the menu */
    }

    /* Center menu items */
    #desktop-nav ul {
        display: flex;
        justify-content: center;
        padding: 0;
        margin: 0;
    }

    #desktop-nav ul li {
        list-style: none;
        margin: 0 15px; /* Space between items */
    }

    #desktop-nav ul li a {
        text-decoration: none;
        color: #fff;
        font-size: 16px;
    }

    #desktop-nav ul li.active a {
        font-weight: bold;
    }

    /* Mobile menu centering */
    .mobile-menu-area {
        display: none;
    }

    @media (max-width: 767px) {
        .mobile-menu-area {
            display: block;
        }
        
        .mobile-menu ul {
            display: flex;
            justify-content: center;
        }

        .mobile-menu ul li {
            list-style: none;
            margin: 0 15px;
        }
    }
</style>
