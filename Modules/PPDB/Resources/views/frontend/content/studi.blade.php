<!-- Tetap gunakan Poppins font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
        min-height: 100vh;
    }
    .about-title {
        font-size: 2.8rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 30px;
        position: relative;
        display: inline-block;
    }
    .about-title::after {
        content: '';
        display: block;
        width: 60%;
        height: 4px;
        background: linear-gradient(90deg, #38bdf8, #6366f1);
        margin: 10px auto 0;
        border-radius: 2px;
    }
    .alur-card {
        position: relative;
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 30px;
        border-radius: 25px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        display: inline-block;
        margin-top: 40px;
        transition: all 0.5s ease;
    }
    .alur-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25);
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .alur-image {
        max-width: 100%;
        height: auto;
        border-radius: 20px;
        transition: transform 0.4s ease;
    }
    .alur-card:hover .alur-image {
        transform: scale(1.01);
    }
    .container {
        animation: fadeInUp 1s ease forwards;
    }
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container text-center my-5">
    <h1 class="about-title">Alur Pendaftaran</h1>

    <div class="alur-card">
        <img src="{{asset('Assets/Frontend/img/banner/alur.png')}}" 
             alt="Alur Pendaftaran" 
             class="img-fluid d-block mx-auto alur-image">
    </div>
</div>

<div class="container my-5">
    <div class="row justify-content-center">
        <!-- Konten tambahan tetap di sini -->
    </div>
</div>
