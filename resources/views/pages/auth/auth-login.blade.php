@extends('layouts.auth')

@section('title', 'Login')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!--====== Favicon Icon ======-->
    <link
      rel="shortcut icon"
      href="assets/images/favicon.png"
      type="image/png"
    />

    <style>
        /* Latar belakang halaman */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        body {
            background-image: url('{{ asset('img/background.jpg') }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* Media query untuk layar besar */
        @media only screen and (min-width: 1200px) {
            body {
                background-image: url('{{ asset('img/background.jpg') }}');
            }
        }
        
        /* Container untuk memastikan background menutupi seluruh layar */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Card styling */
        .card {
            background-color: rgba(255, 255, 255, 0.95); /* Warna solid dengan sedikit transparansi */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Bayangan opsional */
            border-radius: 10px; /* Sudut melengkung */
            padding: 20px; /* Jarak dalam */
            border: 1px solid #ddd; /* Border tipis */
            max-width: 500px; /* Maksimal lebar card */
            margin: 0 auto; /* Membuat card berada di tengah */
            width: 100%;
        }
        
        /* Logo styling */
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .logo {
            max-height: 80px; /* Sesuaikan dengan kebutuhan */
            max-width: 100%;
        }
        
        /* Card header styling */
        .card-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        /* Styling untuk form pada perangkat mobile */
        @media (max-width: 768px) {
            .card {
                padding: 15px;
            }
            
            .form-group {
                margin-bottom: 15px;
            }
        }
    </style>
@endpush

@section('main')
<div class="login-container">
    <div class="card">
        <div class="logo-container">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo">
        </div>
        
        <div class="card-header text-center">
            <h4>SILAHKAN LOGIN PENGISIAN SURVEI</h4>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" tabindex="1" autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="d-block">
                            <label for="password" class="control-label">Password</label>
                            <!-- <div class="float-right">
                                <a href="#" class="text-small">Forgot Password?</a>
                            </div> -->
                        </div>
                        <div class="input-group">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password" tabindex="2">
                            <button type="button" class="btn btn-outline-secondary toggle-password border-0" data-target="#password">
                                <i class="fas fa-eye"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Login
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-muted mt-1 text-center">
                <a href="{{ url('/') }}">
                    Back to Landing
                </a>
            </div>

            <div class="text-muted mt-5 text-center">
            Form Login
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');

    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetInput = document.querySelector(this.getAttribute('data-target'));
            const icon = this.querySelector('i');

            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                targetInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cari elemen alert
        const alerts = document.querySelectorAll('.alert');

        // Timer untuk menghilangkan alert setelah 5 detik
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.style.transition = "opacity 0.5s ease"; // Animasi memudar
                alert.style.opacity = "0";

                // Hapus elemen dari DOM setelah animasi selesai
                setTimeout(() => {
                    alert.remove();
                }, 500); // Waktu animasi fade-out
            });
        }, 5000); // Waktu delay dalam milidetik (5 detik)
    });
</script>

@endpush