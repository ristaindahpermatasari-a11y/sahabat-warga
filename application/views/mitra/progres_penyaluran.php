<div class="main-content flex-grow-1">
    <?php $this->load->view('layout/topnav'); ?>

<div class="mb-4">
    <span class="text-primary text-uppercase fw-bold tracking-wider" style="font-size: 0.725rem;">PROGRES PENYALURAN</span>
    <h3 class="fw-bold mt-1 text-dark mb-1">Kelola Progres Penyaluran</h3>
    <p class="text-muted small mb-0">Perbarui status distribusi agar progres dapat dipantau oleh Petugas.</p>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show small py-2" role="alert">
        <i class="bi bi-check-circle-fill me-1"></i> <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close btn-close-sm py-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-custom mb-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-1"><?= isset($current_proposal) ? $current_proposal['reference_code'] : 'Pilih Pengajuan'; ?></h5>
                    <span class="text-muted small"><?= isset($current_proposal) ? $current_proposal['program_name'] : '-'; ?></span>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill" style="font-size: 0.75rem;">
                    <?= isset($current_proposal) && !empty($current_proposal['status']) ? ucfirst($current_proposal['status']) : 'Menunggu Penyaluran'; ?>
                </span>
            </div>

            <!-- Form Pilih Pengajuan -->
            <form method="GET" action="<?= base_url('index.php/mitra/progres_penyaluran'); ?>" class="mb-4">
                <label class="form-label small fw-bold text-dark">Pilih pengajuan</label>
                <select name="proposal_id" class="form-select form-select-sm py-2" onchange="this.form.submit()">
                    <?php if (!empty($proposals)): ?>
                        <?php foreach ($proposals as $p): ?>
                            <option value="<?= $p['id']; ?>" <?= (isset($selected_proposal_id) && $selected_proposal_id == $p['id']) ? 'selected' : ''; ?>>
                                <?= $p['reference_code']; ?> - <?= $p['program_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </form>

            <div class="row g-3 bg-light p-3 rounded-3 mb-4">
                <div class="col-md-4">
                    <span class="text-muted d-block" style="font-size: 0.7rem;">Penerima</span>
                    <strong class="text-dark"><?= isset($total_penerima) ? $total_penerima : 0; ?> orang</strong>
                </div>
                <div class="col-md-4">
                    <span class="text-muted d-block" style="font-size: 0.7rem;">Status Terbaru</span>
                    <strong class="text-dark"><?= isset($current_proposal) && !empty($current_proposal['status']) ? ucfirst($current_proposal['status']) : 'Menunggu Penyaluran'; ?></strong>
                </div>
                <div class="col-md-4">
                    <span class="text-muted d-block" style="font-size: 0.7rem;">Pembaruan Terakhir</span>
                    <strong class="text-dark">
                        <?= !empty($logs) ? date('d M Y, H:i', strtotime($logs[0]['updated_at'])) : (isset($current_proposal) ? date('d M Y, H:i', strtotime($current_proposal['created_at'])) : '-'); ?>
                    </strong>
                </div>
            </div>

            <h6 class="fw-bold text-dark mb-3">Riwayat Status</h6>
            <div class="ps-2 border-start border-2 ms-2 d-flex flex-column gap-4">
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $log): ?>
                        <div class="position-relative ps-3">
                            <span class="position-absolute bg-primary rounded-circle" style="width: 10px; height: 10px; left: -6px; top: 4px;"></span>
                            <strong class="d-block text-dark small"><?= ucfirst($log['status']); ?></strong>
                            <span class="text-muted extra-small" style="font-size: 0.7rem;"><?= date('d M Y, H:i', strtotime($log['updated_at'])); ?></span>
                            <div class="text-muted small mb-0 mt-1" style="font-size: 0.8rem;"><?= $log['notes']; ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="position-relative ps-3">
                        <span class="position-absolute bg-primary rounded-circle" style="width: 10px; height: 10px; left: -6px; top: 4px;"></span>
                        <strong class="d-block text-dark small">Usulan diterima</strong>
                        <span class="text-muted extra-small" style="font-size: 0.7rem;"><?= isset($current_proposal) ? $current_proposal['created_at'] : ''; ?></span>
                        <p class="text-muted small mb-0 mt-1">Usulan tercatat dan menunggu proses penyaluran.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4" id="form-progres">
        <?php if (isset($current_proposal)): ?>
        <div class="card-custom">
            <span class="text-primary text-uppercase fw-bold tracking-wider d-block mb-1" style="font-size: 0.7rem;">PERBARUI PROGRES</span>
            <h5 class="fw-bold text-dark mb-3">Catat Status Terbaru</h5>

            <form action="<?= base_url('index.php/mitra/update_progres/' . $current_proposal['id']); ?>#form-progres" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Status penyaluran</label>
                    <select name="status" class="form-select py-2" required style="font-size: 0.85rem;">
                        <option value="Menunggu Penyaluran" <?= (isset($current_proposal['status']) && $current_proposal['status'] == 'Menunggu Penyaluran') ? 'selected' : ''; ?>>Menunggu Penyaluran</option>
                        <option value="Sedang Disiapkan" <?= (isset($current_proposal['status']) && $current_proposal['status'] == 'Sedang Disiapkan') ? 'selected' : ''; ?>>Sedang Disiapkan</option>
                        <option value="Dalam Pengiriman" <?= (isset($current_proposal['status']) && $current_proposal['status'] == 'Dalam Pengiriman') ? 'selected' : ''; ?>>Dalam Pengiriman</option>
                        <option value="Selesai Disalurkan" <?= (isset($current_proposal['status']) && $current_proposal['status'] == 'Selesai Disalurkan') ? 'selected' : ''; ?>>Selesai Disalurkan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Catatan</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan informasi penyaluran..." style="font-size: 0.85rem;"></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold shadow-sm" style="font-size: 0.875rem;">
                    Perbarui Status
                </button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>

</div>