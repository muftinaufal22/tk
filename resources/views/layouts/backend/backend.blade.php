<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title> <!-- Add dynamic title -->
    
    <!-- Add your stylesheets here -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('Assets/Backend/css/style.css') }}">
    <!-- Include custom styles if you have any -->
    @stack('styles') <!-- Optional for additional styles from individual pages -->
</head>

<body>

    <!-- Sidebar or Navbar (if any) -->
    @include('layouts.backend.header')  <!-- Include header section -->
    @include('layouts.backend.menu')    <!-- Include sidebar/menu section -->

    <div class="container mt-5">
        @yield('content') <!-- This will display the content of the page using this layout -->
    </div>

    <!-- Footer (if any) -->
    <footer class="footer bg-light text-center mt-5 py-3">
        <p>&copy; 2025 Your School | All Rights Reserved</p>
    </footer>

    <!-- Add your scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    
    <!-- Feather Icons JS -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();  // Replaces feather icons in the page
    </script>

    @stack('scripts') <!-- Optional for additional scripts from individual pages -->
</body>

</html>
