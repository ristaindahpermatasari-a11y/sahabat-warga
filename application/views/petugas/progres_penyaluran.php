<div class="main-content flex-grow-1">
    <?php $this->load->view('layout/topnav'); ?>

<div class="mb-4">
    <span class="text-primary text-uppercase fw-bold tracking-wider" style="font-size: 0.725rem;">PROGRES PENYALURAN</span>
    <h3 class="fw-bold mt-1 text-dark mb-1">Pantau Penyaluran Bantuan</h3>
    <p class="text-muted small mb-0">Pantau status terbaru dan riwayat penyaluran bantuan untuk warga terpilih.</p>
</div>

<?php if (empty($proposals) || empty($current_proposal)): ?>
    <div class="card-custom text-center py-5">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
            <i class="bi bi-truck fs-2"></i>
        </div>
        <h5 class="fw-bold text-dark mb-1">Belum ada penyaluran</h5>
        <p class="text-muted small mb-0">Data penyaluran tersedia setelah Mitra menyelesaikan proses seleksi.</p>
    </div>
<?php else: ?>
    <div class="card-custom mb-4">
        <!-- Form Pilih Pengajuan -->
        <form method="GET" action="<?= base_url('index.php/petugas/progres_penyaluran'); ?>" class="mb-4">
            <label class="form-label small fw-bold text-dark">Pilih pengajuan</label>
            <select name="proposal_id" class="form-select form-select-sm py-2" onchange="this.form.submit()">
                <?php foreach ($proposals as $p): ?>
                    <option value="<?= $p['id']; ?>" <?= ($selected_proposal_id == $p['id']) ? 'selected' : ''; ?>>
                        <?= $p['reference_code']; ?> - <?= $p['program_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <div class="d-flex justify-content-between align-items-start mb-4 pb-3 border-bottom">
            <div>
                <h5 class="fw-bold text-dark mb-1"><?= $current_proposal['reference_code']; ?></h5>
                <span class="text-muted small"><?= $current_proposal['program_name']; ?></span>
            </div>
            
            <!-- Badge Status (Disesuaikan otomatis jika rejected) -->
            <?php if (isset($current_proposal['status']) && strtolower($current_proposal['status']) == 'rejected'): ?>
                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1.5 rounded-pill" style="font-size: 0.75rem;">
                    Rejected
                </span>
            <?php else: ?>
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill" style="font-size: 0.75rem;">
                    <?= !empty($current_proposal['status']) ? ucfirst($current_proposal['status']) : 'Menunggu Penyaluran'; ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="row g-3 bg-light p-3 rounded-3 mb-4">
            <div class="col-md-4">
                <span class="text-muted d-block" style="font-size: 0.7rem;">Penerima</span>
                <strong class="text-dark"><?= isset($total_penerima) ? $total_penerima : 0; ?> orang</strong>
            </div>
            <div class="col-md-4">
                <span class="text-muted d-block" style="font-size: 0.7rem;">Status terbaru</span>
                <strong class="text-dark"><?= !empty($current_proposal['status']) ? ucfirst($current_proposal['status']) : '-'; ?></strong>
            </div>
            <div class="col-md-4">
                <span class="text-muted d-block" style="font-size: 0.7rem;">Pembaruan</span>
                <strong class="text-dark"><?= !empty($logs) ? date('d M Y, H:i', strtotime($logs[0]['updated_at'])) : date('d M Y, H:i', strtotime($current_proposal['created_at'])); ?></strong>
            </div>
        </div>

        <!-- Riwayat Status Timeline -->
        <h6 class="fw-bold text-dark mb-3">Riwayat Status</h6>
        <div class="ps-2 border-start border-2 ms-2 d-flex flex-column gap-4">
            <?php if (!empty($logs)): ?>
                <?php foreach ($logs as $log): ?>
                    <div class="position-relative ps-3">
                        <span class="position-absolute bg-primary rounded-circle" style="width: 10px; height: 10px; left: -6px; top: 4px;"></span>
                        <strong class="d-block text-dark small"><?= ucfirst($log['status']); ?></strong>
                        <span class="text-muted extra-small" style="font-size: 0.7rem;"><?= date('d M Y, H:i', strtotime($log['updated_at'])); ?></span>
                        <p class="text-muted small mb-0 mt-1"><?= $log['notes']; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Jika status rejected, jangan tampilkan teks menunggu penyaluran -->
                <?php if (isset($current_proposal['status']) && strtolower($current_proposal['status']) == 'rejected'): ?>
                    <div class="position-relative ps-3">
                        <span class="position-absolute bg-danger rounded-circle" style="width: 10px; height: 10px; left: -6px; top: 4px;"></span>
                        <strong class="d-block text-danger small">Usulan Ditolak</strong>
                        <span class="text-muted extra-small" style="font-size: 0.7rem;"><?= $current_proposal['created_at']; ?></span>
                        <p class="text-danger small mb-0 mt-1">Pengajuan ditolak dan tidak dilanjutkan ke proses penyaluran.</p>
                    </div>
                <?php else: ?>
                    <div class="position-relative ps-3">
                        <span class="position-absolute bg-primary rounded-circle" style="width: 10px; height: 10px; left: -6px; top: 4px;"></span>
                        <strong class="d-block text-dark small">Usulan diterima</strong>
                        <span class="text-muted extra-small" style="font-size: 0.7rem;"><?= $current_proposal['created_at']; ?></span>
                        <p class="text-muted small mb-0 mt-1">Usulan tercatat dan menunggu proses penyaluran.</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
</div>