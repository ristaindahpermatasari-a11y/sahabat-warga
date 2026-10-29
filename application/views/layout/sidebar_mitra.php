<div class="sidebar p-3 d-flex flex-column justify-content-between">
    <div>
        <div class="d-flex align-items-center gap-3 mb-4 px-2 pt-2">
            <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo SahabatWarga" class="rounded-3 flex-shrink-0 shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
            <div>
                <h6 class="fw-bold mb-0 text-dark" style="font-size: 1.05rem; line-height: 1.2;">SahabatWarga</h6>
                <span style="font-size: 0.725rem;" class="text-muted">Peduli, Tepat, Bersama</span>
            </div>
        </div>

        <div class="bg-light rounded-3 p-3 d-flex align-items-center gap-3 mb-4 border">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; font-size: 0.85rem;">
                YP
            </div>
            <div style="min-width: 0;">
                <div class="fw-bold text-dark text-truncate" style="font-size: 0.85rem;"><?= $this->session->userdata('name') ? $this->session->userdata('name') : 'Yayasan Peduli'; ?></div>
                <div class="text-muted text-truncate" style="font-size: 0.725rem;">Mitra Bantuan</div>
            </div>
        </div>

        <?php $page = isset($active_menu) ? $active_menu : ''; ?>
        <nav>
            <a href="<?= base_url('index.php/mitra/dashboard'); ?>" class="nav-link-custom <?= $page == 'dashboard' ? 'active' : ''; ?>">
                <i class="bi bi-grid-fill fs-6"></i> Dashboard
            </a>
            <a href="<?= base_url('index.php/mitra/program_bantuan'); ?>" class="nav-link-custom <?= $page == 'program_bantuan' ? 'active' : ''; ?>">
                <i class="bi bi-gift-fill fs-6"></i> Program Bantuan Saya
            </a>
            <a href="<?= base_url('index.php/mitra/usulan_masuk'); ?>" class="nav-link-custom <?= $page == 'usulan_masuk' ? 'active' : ''; ?>">
                <i class="bi bi-inbox-fill fs-6"></i> Usulan & Seleksi
            </a>
            <a href="<?= base_url('index.php/mitra/progres_penyaluran'); ?>" class="nav-link-custom <?= $page == 'progres_penyaluran' ? 'active' : ''; ?>">
                <i class="bi bi-truck fs-6"></i> Progres Penyaluran
            </a>
            <a href="<?= base_url('index.php/mitra/laporan'); ?>" class="nav-link-custom <?= $page == 'laporan' ? 'active' : ''; ?>">
                <i class="bi bi-bar-chart-fill fs-6"></i> Laporan
            </a>
            <a href="<?= base_url('index.php/mitra/pengaturan'); ?>" class="nav-link-custom <?= $page == 'pengaturan' ? 'active' : ''; ?>">
                <i class="bi bi-gear-fill fs-6"></i> Pengaturan
            </a>
        </nav>
    </div>

    <div class="pt-3 border-top text-center text-muted" style="font-size: 0.725rem;">
        <span>SahabatWarga v1.0</span>
    </div>
</div>