<div class="main-content flex-grow-1">
    <?php $this->load->view('layout/topnav'); ?>

<div class="mb-4">
    <span class="text-primary text-uppercase fw-bold tracking-wider" style="font-size: 0.725rem;">HASIL SELEKSI</span>
    <h3 class="fw-bold mt-1 text-dark mb-1">Hasil Seleksi Mitra</h3>
    <p class="text-muted small mb-0">Lihat keputusan dan alasan seleksi yang telah dicatat oleh Mitra Bantuan.</p>
</div>

<?php if (empty($proposals) || empty($current_proposal)): ?>
    <div class="card-custom text-center py-5">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
            <i class="bi bi-file-earmark-text fs-2"></i>
        </div>
        <h5 class="fw-bold text-dark mb-1">Belum ada hasil seleksi</h5>
        <p class="text-muted small mb-0">Hasil akan tampil setelah Mitra menyelesaikan seleksi penerima.</p>
    </div>
<?php else: ?>
    

    <div class="card-custom mb-4">

        <form method="GET" action="<?= base_url('index.php/petugas/hasil_seleksi'); ?>" class="row align-items-center pb-3 mb-3 border-bottom">
            <div class="col-md-6">
                <label class="form-label small fw-bold text-dark mb-1">Pilih Program Bantuan</label>
                <select name="program_id" class="form-select form-select-sm py-2" onchange="this.form.submit()">
                    <?php foreach ($proposals as $p): ?>
                        <option value="<?= $p['program_id']; ?>" <?= ($selected_program_id == $p['program_id']) ? 'selected' : ''; ?>>
                            <?= $p['program_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <div class="row align-items-center pb-3 border-bottom">
            <div class="col-md-8">
                <span class="text-muted d-block text-uppercase" style="font-size: 0.7rem;">PROGRAM BANTUAN SOSIAL</span>
                <h5 class="fw-bold text-dark mb-0"><?= $current_proposal['program_name']; ?></h5>
            </div>
            <div class="col-md-4 text-md-end">
                <?php 
                    $status_prop = isset($current_proposal['status']) ? strtolower($current_proposal['status']) : '';
                    
                    if ($status_prop == 'approved' || $status_prop == 'selesai diseleksi') {
                        echo '<span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill" style="font-size: 0.75rem;">Selesai Diseleksi</span>';
                    } else if ($status_prop == 'submitted' || $status_prop == 'diajukan') {
                        echo '<span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1.5 rounded-pill" style="font-size: 0.75rem;">Menunggu Seleksi Mitra</span>';
                    } else {
                        echo '<span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1.5 rounded-pill" style="font-size: 0.75rem;">' . ucfirst($status_prop) . '</span>';
                    }
                ?>
            </div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="table-light">
                    <tr>
                        <th class="text-muted fw-semibold py-2">CALON PENERIMA</th>
                        <th class="text-muted fw-semibold py-2">KEPUTUSAN MITRA</th>
                        <th class="text-muted fw-semibold py-2">ALASAN / CATATAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark"><?= $item['full_name']; ?></strong>
                                    <span class="text-muted" style="font-size: 0.725rem;">RT/RW <?= isset($item['rt_rw']) ? $item['rt_rw'] : '-'; ?></span>
                                </td>
                                <td>
                                    <?php if ($item['selection_status'] == 'accepted'): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">Diterima</span>
                                    <?php elseif ($item['selection_status'] == 'rejected'): ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill">Ditolak</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1 rounded-pill">Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted">
                                    <?= ($item['selection_status'] == 'accepted') ? 'Memenuhi seluruh kriteria program.' : 'Belum memenuhi kriteria saat seleksi.'; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">Tidak ada data penerima pada program ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
<?php endif; ?>

</div>