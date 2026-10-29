<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SahabatWarga - Ubah Kata Sandi</title>
    <!-- Bootstrap 5 CSS & Icons -->
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
            max-height: 200px;
            width: auto;
            object-fit: contain;
        }

        .hero-title {
            font-size: 1.85rem;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.25;
            letter-spacing: -0.01em;
        }

        .hero-desc {
            font-size: 0.825rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.45;
            font-weight: 400;
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
            padding: 0.6rem 0.9rem;
            font-size: 0.85rem;
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
    </style>
</head>
<body>

<div class="row g-0 vh-100">
    <!-- Sisi Kiri: Panel Biru -->
    <div class="col-lg-6 d-none d-lg-flex login-left">
        <!-- Logo Header -->
        <div class="d-flex align-items-center gap-3">
            <img src="<?= base_url('assets/img/logoP.png'); ?>" alt="Logo SahabatWarga" class="rounded-3 flex-shrink-0 shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
            <div>
                <h5 class="fw-bold mb-0 lh-1 text-white" style="font-size: 1.2rem;">SahabatWarga</h5>
                <span style="font-size: 0.725rem;" class="opacity-75">Peduli, Tepat, Bersama</span>
            </div>
        </div>
        
        <!-- Content Tengah -->
        <div class="my-auto text-start">
            <div class="hero-img-container">
                <img src="<?= base_url('assets/img/home.png'); ?>" 
                     alt="Ilustrasi SahabatWarga" 
                     class="hero-img"
                     onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/619/619153.png';">
            </div>
            <h2 class="hero-title mb-2">
                Pembaruan sandi akun<br>dengan cepat & aman.
            </h2>
            <p class="hero-desc mb-0">
                Masukkan akun resmi Anda beserta kata sandi baru untuk memperbarui akses masuk sistem SahabatWarga.
            </p>
        </div>

        <div class="d-flex gap-4 text-white" style="font-size: 0.775rem;">
            <span><i class="bi bi-shield-check"></i> Keamanan sistem</span>
            <span><i class="bi bi-check2"></i> Pembaruan langsung</span>
        </div>
    </div>

    <div class="col-lg-6 login-right">
        <div class="form-container">
            <span class="subtitle-welcome">RESET KATA SANDI</span>
            <h2 class="title-login">Buat sandi baru</h2>
            <p class="text-sub mb-3">Masukkan akun dan tentukan kata sandi baru Anda.</p>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 py-2 px-3 mb-3" role="alert" style="font-size: 0.8rem; border-radius: 8px;">
                    <i class="bi bi-exclamation-triangle-fill fs-6"></i>
                    <div><?= $this->session->flashdata('error'); ?></div>
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 py-2 px-3 mb-3" role="alert" style="font-size: 0.8rem; border-radius: 8px;">
                    <i class="bi bi-check-circle-fill fs-6"></i>
                    <div><?= $this->session->flashdata('success'); ?></div>
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('index.php/auth/update_password_process'); ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label">Email / Akun Terdaftar</label>
                    <input type="email" name="email" class="form-control" placeholder="petugas@gmail.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kata sandi baru</label>
                    <div class="input-group">
                        <input type="password" name="new_password" id="new_password" class="form-control border-end-0" placeholder="Minimal 6 karakter" required>
                        <span class="input-group-text bg-transparent border-start-0 text-muted" style="border-color: #cbd5e1; cursor: pointer;" onclick="togglePasswordVisibility('new_password', 'icon-new')">
                            <i class="bi bi-eye" id="icon-new" style="font-size: 0.9rem;"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi kata sandi baru</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control border-end-0" placeholder="Ulangi kata sandi baru" required>
                        <span class="input-group-text bg-transparent border-start-0 text-muted" style="border-color: #cbd5e1; cursor: pointer;" onclick="togglePasswordVisibility('confirm_password', 'icon-confirm')">
                            <i class="bi bi-eye" id="icon-confirm" style="font-size: 0.9rem;"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 text-white mb-3">Simpan Sandi Baru</button>

                <div class="text-center" style="font-size: 0.85rem;">
                    <span class="text-muted">Sudah ingat sandi lama?</span> 
                    <a href="<?= base_url('index.php/auth'); ?>" class="text-primary text-decoration-none fw-semibold">Masuk</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, iconId) {
        const inputField = document.getElementById(inputId);
        const iconField = document.getElementById(iconId);

        if (inputField.type === 'password') {
            inputField.type = 'text';
            iconField.classList.remove('bi-eye');
            iconField.classList.add('bi-eye-slash');
        } else {
            inputField.type = 'password';
            iconField.classList.remove('bi-eye-slash');
            iconField.classList.add('bi-eye');
        }
    }
</script>

</body>
</html>