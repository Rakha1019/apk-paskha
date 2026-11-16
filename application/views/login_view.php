<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMELEK PA SKH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        /* ==========================================
           1. BACKGROUND MULTI-WARNA BERGERAK
        ============================================= */
        body {
            background: linear-gradient(120deg, #00695c, #2e7d32, #c0ca33, #00838f);
            background-size: 300% 300%;
            animation: backgroundGerak 12s ease-in-out infinite alternate;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
        }

        @keyframes backgroundGerak {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        /* ==========================================
           2. EFEK TEKS LOMPAT BERGELOMBANG (BARU)
        ============================================= */
        .text-brand {
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .text-brand span {
            display: inline-block;
            color: #ffffff;
            text-shadow: 2px 4px 6px rgba(0,0,0,0.3);
            animation: hurufLompat 3s ease-in-out infinite;
        }

        @keyframes hurufLompat {
            0%, 30%, 100% {
                transform: translateY(0);
                color: #ffffff;
                text-shadow: 2px 4px 6px rgba(0,0,0,0.3);
            }
            15% {
                transform: translateY(-8px); /* Bergerak naik tipis */
                color: #ffca28; /* Berubah menjadi Emas */
                text-shadow: 0 10px 15px rgba(255, 202, 40, 0.5), 2px 4px 6px rgba(0,0,0,0.3);
            }
        }

        /* Jeda waktu animasi untuk setiap huruf agar berurutan */
        .text-brand span:nth-child(1) { animation-delay: 0.0s; }
        .text-brand span:nth-child(2) { animation-delay: 0.15s; }
        .text-brand span:nth-child(3) { animation-delay: 0.3s; }
        .text-brand span:nth-child(4) { animation-delay: 0.45s; }
        .text-brand span:nth-child(5) { animation-delay: 0.6s; }
        .text-brand span:nth-child(6) { animation-delay: 0.75s; }
        .text-brand span:nth-child(7) { animation-delay: 0.9s; }

        /* ==========================================
           3. KOMPONEN LOGIN LAINNYA
        ============================================= */
        @keyframes floatLogo {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }
        .animasi-melayang {
            animation: floatLogo 4s ease-in-out infinite;
        }
        
        .glass-pill {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 10px 30px;
            color: #ffffff;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 15px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
            padding: 40px;
        }

        .form-label-custom {
            font-size: 0.85rem;
            font-weight: 700;
            color: #1b5e20;
            margin-bottom: 5px;
        }
        .custom-input {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 15px;
            background-color: #f8fafc;
        }
        .custom-input:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
            background-color: #ffffff;
        }
        .input-group-text-custom {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: none;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            cursor: pointer;
        }

        .btn-login {
            background: linear-gradient(to right, #1b5e20, #2e7d32);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
            color: white;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: linear-gradient(to right, #144d18, #1b5e20);
            transform: translateY(-2px);
            color: white;
        }

        .divider-gradient {
            height: 4px;
            width: 80px;
            background: linear-gradient(to right, #ffb300, #ffca28);
            margin: 0 auto 25px auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <div class="container" style="z-index: 1; position: relative;">
        <div class="row justify-content-center align-items-center py-5">
            
            <!-- BAGIAN KIRI: Logo & Judul -->
            <div class="col-lg-6 text-center mb-5 mb-lg-0 pe-lg-5">
                <img src="<?= base_url('assets/img/PA SKH Glossy.png'); ?>" alt="Logo PA SKH" width="130" class="mb-3 animasi-melayang" style="filter: drop-shadow(0 10px 15px rgba(0,0,0,0.3));">
                
                <!-- Teks SIMELEK dipecah per huruf untuk animasi -->
                <h1 class="text-brand">
                    <span>S</span><span>I</span><span>M</span><span>E</span><span>L</span><span>E</span><span>K</span>
                </h1>
                <div class="divider-gradient mt-3"></div>
                
                <div class="glass-pill">
                    Sistem Monitoring Elektronik
                </div>
                <div class="glass-pill" style="opacity: 0.9;">
                    Pengadilan Agama Sukoharjo
                </div>
                
                <p class="mt-4 text-white" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
                    <small>Silakan gunakan akun Anda untuk masuk ke dalam sistem</small>
                </p>
            </div>

            <!-- BAGIAN KANAN: Form Login -->
            <div class="col-lg-5 col-md-8">
                <div class="login-card">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-dark mb-1">Masuk Aplikasi</h4>
                        <p class="text-muted small">Lengkapi formulir di bawah</p>
                    </div>

                    <?php if($this->session->flashdata('pesan')) { echo $this->session->flashdata('pesan'); } ?>

                    <form action="<?= base_url('index.php/auth/proses_login'); ?>" method="POST">
                        
                        <div class="mb-4">
                            <label class="form-label-custom">
                                <i class="bi bi-person-fill me-1"></i> Username
                            </label>
                            <input type="text" name="username" class="form-control custom-input" placeholder="Masukkan username Anda" required autocomplete="off">
                        </div>

                        <div class="mb-4">
                            <label class="form-label-custom">
                                <i class="bi bi-lock-fill me-1"></i> Password
                            </label>
                            <div class="input-group">
                                <input type="password" name="password" id="inputPassword" class="form-control custom-input border-end-0" placeholder="Masukkan password Anda" required>
                                <span class="input-group-text input-group-text-custom" onclick="tampilkanPassword()">
                                    <i class="bi bi-eye text-muted" id="ikonMata"></i>
                                </span>
                            </div>
                        </div>

                        <!-- reCAPTCHA -->
                        <div class="mb-4 d-flex justify-content-center">
                            <div class="g-recaptcha" data-sitekey="6LeHC7UtAAAAAFFH7rJ-PNwr8FKzFlNn8nq3NrXX"></div>
                        </div>

                        <button type="submit" class="btn btn-login w-100">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke SIMELEK
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted" style="font-size: 0.75rem;">
                            &copy; <?= date('Y'); ?> SIMELEK - Pengadilan Agama Sukoharjo
                        </small>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Script Show Password -->
    <script>
        function tampilkanPassword() {
            var passwordInput = document.getElementById("inputPassword");
            var ikonMata = document.getElementById("ikonMata");
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                ikonMata.classList.remove("bi-eye");
                ikonMata.classList.add("bi-eye-slash"); 
            } else {
                passwordInput.type = "password";
                ikonMata.classList.remove("bi-eye-slash");
                ikonMata.classList.add("bi-eye"); 
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>