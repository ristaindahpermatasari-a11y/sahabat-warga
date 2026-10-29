<div class="main-content flex-grow-1">
    <?php $this->load->view('layout/topnav'); ?>

<div class="mb-4">
    <span class="text-primary text-uppercase fw-bold tracking-wider" style="font-size: 0.725rem;">PENGATURAN</span>
    <h3 class="fw-bold mt-1 text-dark mb-1">Profil dan Pengaturan Akun</h3>
    <p class="text-muted small mb-0">Kelola informasi dasar akun dan preferensi notifikasi.</p>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 0.85rem;">
        <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-4" style="width: 55px; height: 55px;">
                    <?= isset($user_initials) ? $user_initials : 'DS'; ?>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0"><?= isset($user['name']) ? $user['name'] : $user_name; ?></h5>
                    <span class="text-muted small">Petugas Kelurahan Sukamaju</span>
                </div>
            </div>

            <form action="<?= base_url('index.php/petugas/update_profil'); ?>" method="POST">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-dark">Nama lengkap / organisasi *</label>
                        <input type="text" name="name" class="form-control py-2" value="<?= isset($user['name']) ? $user['name'] : $user_name; ?>" required style="font-size: 0.85rem;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-dark">Alamat email *</label>
                        <input type="email" name="email" class="form-control py-2" value="<?= isset($user['email']) ? $user['email'] : 'dedi@sukamaju.go.id'; ?>" required style="font-size: 0.85rem;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-dark">Nomor telepon</label>
                        <input type="text" name="phone" class="form-control py-2" value="<?= isset($user['phone']) ? $user['phone'] : '0812-3456-7890'; ?>" style="font-size: 0.85rem;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-dark">Wilayah tugas</label>
                        <input type="text" class="form-control py-2 bg-light" value="Kelurahan Sukamaju" readonly style="font-size: 0.85rem;">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4 py-2.5 fw-bold shadow-sm" style="font-size: 0.875rem;">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-custom mb-4">
            <h6 class="fw-bold text-dark mb-3">Preferensi</h6>
            
            <div class="form-check form-switch mb-3 d-flex justify-content-between align-items-center ps-0">
                <label class="form-check-label small text-dark fw-semibold" for="notifCheck">Notifikasi aktivitas</label>
                <input class="form-check-input ms-0" type="checkbox" id="notifCheck" checked style="width: 2.5em; height: 1.25em;">
            </div>
            <span class="text-muted extra-small d-block mb-3" style="font-size: 0.725rem;">Terima pemberitahuan perubahan status pengajuan.</span>

        </div>
    </div>
</div>

</div>