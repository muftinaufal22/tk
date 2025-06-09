<header>
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
                                        <a class="apply-now-btn2" href="{{route('login')}}">Masuk</a>
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
                    <div class="col-lg-12">
                        <nav id="desktop-nav">
                            <ul style="display: flex; justify-content: center; list-style: none; padding: 0; margin: 0;">
                                <li class="{{ (request()->is('/')) ? 'active' : '' }}"><a href="/">Beranda</a></li>
                                <li><a href="#">Tentang Kami</a></li>
                                <li class="{{ (request()->is('berita')) ? 'active' : '' }}"><a href="{{route('berita')}}">Berita</a></li>
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
                            <ul>
                                <li class="active"><a href="#">Beranda</a></li>
                                <li><a href="#">Tentang Kami</a></li>
                                <li><a href="#">Program</a>
                                    <ul>
                                        <li><a href="#">Program Studi</a></li>
                                        <li><a href="#">Kegiatan</a></li>
                                    </ul>
                                </li>
                                <li class="{{ (request()->is('berita')) ? 'active' : '' }}"><a href="{{route('berita')}}">Berita</a></li>
                                <li><a href="{{url('ppdb')}}" target="_blank">PPDB</a></li>
                                <li><a href="#">Lainnya</a>
                                    <ul>
                                        <!-- Additional links -->
                                    </ul>
                                </li>
                                <li>
                                    @auth
                                        <a href="">{{Auth::user()->name}}</a>
                                    @else
                                        <a href="{{route('login')}}">Masuk</a>
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
</header>

<style>
    /* ===== Main Menu Area ===== */
    .main-menu-area ul {
        display: flex;
        justify-content: center; /* Center the menu horizontally */
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .main-menu-area ul li {
        margin: 0 15px; /* Space between the menu items */
    }

    .main-menu-area ul li a {
        text-decoration: none;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
    }

    .main-menu-area ul li.active a {
        color: #f39c12; /* Active menu item color */
    }
</style>
