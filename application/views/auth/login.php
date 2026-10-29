<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SahabatWarga - Masuk ke Akun Anda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        html, body {
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            background-color: #ffffff;
        }
        .login-left {
            background-color: #1d61e8;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem 4rem;
            height: 100vh;
        }
        .login-right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            height: 100vh;
            overflow-y: auto;
        }
        .form-container {
            width: 100%;
            max-width: 380px;
        }
        .hero-img-container {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1rem 0;
        }
        .hero-img {
            max-height: 220px;
            width: auto;
            object-fit: contain;
        }
        .hero-title {
            font-size: 1.85rem;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.25;
        }
        .hero-desc {
            font-size: 0.825rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.45;
        }
        .subtitle-welcome {
            color: #1d61e8;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .title-login {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 4px;
            margin-bottom: 4px;
        }
        .text-sub {
            font-size: 0.85rem;
            color: #64748b;
        }
        .form-label {
            font-size: 0.825rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }
        .form-control {
            border-radius: 8px;
            padding: 0.65rem 0.9rem;
            font-size: 0.875rem;
            border: 1px solid #cbd5e1;
        }
        .btn-primary-custom {
            background-color: #1d61e8;
            border: none;
            border-radius: 8px;
            padding: 0.7rem;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .btn-primary-custom:hover {
            background-color: #154ec2;
        }
        .btn-google-custom {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            color: #334155;
            border-radius: 8px;
            padding: 0.7rem;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s;
        }
        .btn-google-custom:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="row g-0 vh-100">
    <!-- Sisi Kiri -->
    <div class="col-lg-6 d-none d-lg-flex login-left">
        <div class="d-flex align-items-center gap-3">
            <img src="<?= base_url('assets/img/logoP.png'); ?>" alt="Logo SahabatWarga" class="rounded-3 flex-shrink-0 shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
            <div>
                <h5 class="fw-bold mb-0 lh-1 text-white" style="font-size: 1.2rem;">SahabatWarga</h5>
                <span style="font-size: 0.725rem;" class="opacity-75">Peduli, Tepat, Bersama</span>
            </div>
        </div>
        
        <div class="my-auto text-start">
            <div class="hero-img-container">
                <img src="<?= base_url('assets/img/home.png'); ?>" alt="Ilustrasi" class="hero-img" onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/619/619153.png';">
            </div>
            <h2 class="hero-title mb-2">Bersama, bantuan sampai<br>kepada yang membutuhkan.</h2>
            <p class="hero-desc mb-0">Platform kolaborasi petugas wilayah dan mitra bantuan untuk penyaluran yang lebih transparan dan tepat sasaran.</p>
        </div>

        <div class="d-flex gap-4 text-white" style="font-size: 0.775rem;">
            <span><i class="bi bi-check2"></i> Data terpadu</span>
            <span><i class="bi bi-check2"></i> Proses transparan</span>
            <span><i class="bi bi-check2"></i> Progres terpantau</span>
        </div>
    </div>

    <div class="col-lg-6 login-right">
        <div class="form-container">
            <span class="subtitle-welcome">SELAMAT DATANG</span>
            <h2 class="title-login">Masuk ke akun Anda</h2>
            <p class="text-sub mb-4">Kelola bantuan warga dengan mudah dan terarah.</p>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show py-2 px-3 mb-3" style="font-size: 0.8rem; border-radius: 8px;">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('index.php/auth/login_process'); ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label">Alamat email</label>
                    <input type="email" name="email" class="form-control" placeholder="petugas@gmail.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kata sandi</label>
                    <div class="input-group">
                        <input type="password" name="password" id="login_password" class="form-control border-end-0" placeholder="Masukkan kata sandi" required>
                        <span class="input-group-text bg-transparent border-start-0 text-muted" style="cursor: pointer;" onclick="toggleLoginPassword()">
                            <i class="bi bi-eye" id="login-icon"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 text-white mb-3">Masuk</button>
            </form>

            <div class="position-relative text-center my-3">
                <hr class="text-muted opacity-25">
                <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted" style="font-size: 0.75rem;">Atau masuk dengan</span>
            </div>

            <button type="button" id="btnGoogleLogin" class="btn btn-google-custom w-100">
                <svg width="18" height="18" viewBox="0 0 18 18"><path fill="#4285F4" d="M17.64 9.2c0-.63-.06-1.25-.19-1.84H9v3.48h4.84c-.21 1.12-.84 2.07-1.8 2.72v2.26h2.92c1.71-1.57 2.68-3.88 2.68-6.62z"/><path fill="#34A853" d="M9 18c2.43 0 4.47-.8 5.96-2.18l-2.92-2.26c-.81.54-1.84.86-3.04.86-2.34 0-4.32-1.58-5.03-3.71H.96v2.33C2.43 15.98 5.48 18 9 18z"/><path fill="#FBBC05" d="M3.97 10.75c-.18-.54-.28-1.12-.28-1.75s.1-1.21.28-1.75V4.92H.96C.35 6.13 0 7.5 0 9s.35 2.87.96 4.08l3.01-2.33z"/><path fill="#EA4335" d="M9 3.58c1.32 0 2.5.45 3.44 1.35l2.58-2.58C13.46.89 11.43 0 9 0 5.48 0 2.43 2.02.96 4.92l3.01 2.33c.71-2.13 2.69-3.71 5.03-3.71z"/></svg>
                Masuk dengan Google
            </button>
        </div>
    </div>
</div>

<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-app.js";
    import { getAuth, GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-auth.js";

    const firebaseConfig = {
        apiKey: "AIzaSyA9PqjWwq8CNaA61iFRw1cXuxFgz5MzBUI",
        authDomain: "sahabatwarga.firebaseapp.com",
        projectId: "sahabatwarga",
        storageBucket: "sahabatwarga.firebasestorage.app",
        messagingSenderId: "66693455498",
        appId: "1:66693455498:web:1b5bb24ec9fe592e605773"
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const provider = new GoogleAuthProvider();

    document.getElementById('btnGoogleLogin').addEventListener('click', function () {
        signInWithPopup(auth, provider)
            .then(async (result) => {
                const idToken = await result.user.getIdToken();

                const res = await fetch("<?= base_url('index.php/auth/google_login'); ?>", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "id_token=" + encodeURIComponent(idToken)
                });
                const data = await res.json();

                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => {
                alert("Gagal login Google: " + error.message);
            });
    });
</script>

<script>
    function toggleLoginPassword() {
        const passwordInput = document.getElementById('login_password');
        const iconField = document.getElementById('login-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            iconField.classList.remove('bi-eye');
            iconField.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            iconField.classList.remove('bi-eye-slash');
            iconField.classList.add('bi-eye');
        }
    }
</script>

</body>
</html>