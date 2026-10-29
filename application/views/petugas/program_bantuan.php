<div class="main-content flex-grow-1">
    <?php $this->load->view('layout/topnav'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <span class="text-primary text-uppercase fw-bold tracking-wider" style="font-size: 0.725rem;">LIHAT PROGRAM</span>
        <h3 class="fw-bold mt-1 text-dark mb-0">Program Bantuan</h3>
        <p class="text-muted small mb-0">Daftar program bantuan sosial yang tersedia untuk pengajuan warga.</p>
    </div>
</div>

<!-- Filter Tabs (Semua, Aktif, Tidak Aktif) - Tombol Draf Dihapus -->
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="<?= base_url('index.php/petugas/program_bantuan?status=all'); ?>" 
       class="btn btn-sm <?= (empty($selected_status) || $selected_status == 'all') ? 'btn-primary' : 'btn-light border'; ?> px-3 rounded-pill" style="font-size: 0.8rem;">
        Semua Program
    </a>
    <a href="<?= base_url('index.php/petugas/program_bantuan?status=active'); ?>" 
       class="btn btn-sm <?= ($selected_status == 'active') ? 'btn-primary' : 'btn-light border'; ?> px-3 rounded-pill" style="font-size: 0.8rem;">
        <i class="bi bi-check-circle-fill me-1"></i> Aktif
    </a>
    <a href="<?= base_url('index.php/petugas/program_bantuan?status=closed'); ?>" 
       class="btn btn-sm <?= ($selected_status == 'closed') ? 'btn-primary' : 'btn-light border'; ?> px-3 rounded-pill" style="font-size: 0.8rem;">
        <i class="bi bi-x-circle-fill me-1"></i> Tidak Aktif
    </a>
</div>

<!-- Grid Cards Program Bantuan -->
<div class="row g-4 mb-4">
    <?php if (!empty($programs)): ?>
        <?php foreach ($programs as $row): ?>
            <div class="col-md-4">
                <div class="card-custom h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <?php 
                                $st = strtolower($row['status']);
                                if ($st == 'active') {
                                    $badge_status = '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-3 py-1.5 rounded-pill fw-medium" style="font-size: 0.75rem;">Aktif</span>';
                                } else {
                                    $badge_status = '<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-20 px-3 py-1.5 rounded-pill fw-medium" style="font-size: 0.75rem;">Tidak Aktif</span>';
                                }
                                echo $badge_status;
                            ?>

                            <span class="text-muted extra-small" style="font-size: 0.75rem;">
                                Kuota: <strong class="text-dark"><?= $row['quota']; ?> Warga</strong>
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-2"><?= $row['title']; ?></h5>
                        <div class="mb-2">
                            <span class="badge bg-light text-muted border px-2 py-1 extra-small" style="font-size: 0.7rem;">
                                <i class="bi bi-tag me-1"></i><?= $row['category'] ? $row['category'] : 'Umum'; ?>
                            </span>
                        </div>
                        <p class="text-muted small mb-3" style="font-size: 0.825rem; line-height: 1.5;">
                            <?= strlen($row['description']) > 90 ? substr($row['description'], 0, 90) . '...' : $row['description']; ?>
                        </p>
                    </div>
                    <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                        <span class="text-muted extra-small" style="font-size: 0.725rem;">
                            <?= date('d M Y', strtotime($row['created_at'])); ?>
                        </span>
                        <?php if (strtolower($row['status']) == 'active'): ?>
                            <a href="<?= base_url('index.php/petugas/pengajuan_bantuan?program_id=' . $row['program_id']); ?>" class="btn btn-sm btn-outline-primary px-3 rounded-3" style="font-size: 0.775rem;">
                                Ajukan Warga <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        <?php else: ?>
                            <button class="btn btn-sm btn-light border px-3 rounded-3 text-muted" disabled style="font-size: 0.775rem;">
                                Tidak Aktif
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="card-custom text-center py-5">
                <i class="bi bi-gift fs-1 text-secondary opacity-50 mb-2 d-block"></i>
                <h6 class="fw-bold text-dark">Tidak Ada Program Bantuan</h6>
                <p class="text-muted small mb-0">Belum ada program bantuan yang sesuai dengan filter ini.</p>
            </div>
        </div>
    <?php endif; ?>
</div>
</div>