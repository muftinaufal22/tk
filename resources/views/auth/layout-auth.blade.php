<!DOCTYPE html>
<html class="loading semi-dark-layout" lang="en" data-layout="semi-dark-layout" data-textdirection="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Sekolahku adalah aplikasi manajemen sekolah berbasis website yang di bangun dan di kembangkan dengan Framework Laravel">
    <meta name="author" content="RA Al Barokah">
    <title>@yield('title', 'Login') - RA Al Barokah</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" href="{{ asset('Assets/Backend/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" href="{{ asset('Assets/Backend/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Backend/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Backend/css/colors.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Backend/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Backend/css/themes/semi-dark-layout.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" href="{{ asset('Assets/Backend/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Backend/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Backend/css/pages/page-auth.css') }}">
    <!-- END: Page CSS-->

    <!-- Custom Style -->
    <style>
        body {
            background: #f0f2f5;
        }
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .auth-inner {
            width: 100%;
            max-width: 900px;
            background: #fff;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            display: flex;
        }
        .img-side {
            background: url('{{ asset("assets/frontend/img/cover_login.png") }}') no-repeat center center;
            background-size: cover;
            width: 100%;
            min-height: 400px;
            border-radius: 1.5rem 0 0 1.5rem;
            transition: transform 0.3s ease;
        }
        .img-side:hover {
            transform: scale(1.05);
        }
        @media (max-width: 992px) {
            .auth-inner {
                flex-direction: column;
            }
            .img-side {
                border-radius: 1.5rem 1.5rem 0 0;
                min-height: 250px;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static">
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
