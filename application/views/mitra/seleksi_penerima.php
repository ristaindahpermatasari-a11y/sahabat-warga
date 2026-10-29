<div class="main-content flex-grow-1">
    <?php $this->load->view('layout/topnav'); ?>

<div class="mb-4">
    <div class="mb-3">
        <a href="<?= base_url('index.php/mitra/usulan_masuk'); ?>" class="text-muted text-decoration-none small d-inline-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i> Kembali ke Usulan Masuk
        </a>
    </div>
    
    <span class="text-primary text-uppercase fw-bold tracking-wider d-block" style="font-size: 0.725rem;">SELEKSI PENERIMA</span>
    <h3 class="fw-bold mt-1 text-dark mb-1">Tinjau Kelayakan Calon Penerima</h3>
    <p class="text-muted small mb-0">Bandingkan data warga dengan kriteria program dan catat keputusan.</p>
</div>

<form action="<?= base_url('index.php/mitra/simpan_seleksi/' . $proposal['id']); ?>" method="POST">

    <div class="card-custom mb-4 bg-light">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-2.5 py-1 rounded-pill" style="font-size: 0.75rem;">Ref: <?= $proposal['reference_code']; ?></span>
                <h5 class="fw-bold text-dark mb-1"><?= $proposal['program_name']; ?></h5>
                <p class="text-muted small mb-0">Diajukan oleh <strong><?= $proposal['petugas_name'] ? $proposal['petugas_name'] : 'Petugas Kelurahan'; ?></strong> pada <?= date('d M Y', strtotime($proposal['created_at'])); ?></p>
            </div>
            <div class="col-md-4 border-start ps-4">
                <span class="text-muted d-block" style="font-size: 0.725rem;">Kriteria Program</span>
                <strong class="text-dark small"><?= $proposal['criteria'] ? $proposal['criteria'] : 'Tidak ada kriteria khusus.'; ?></strong>
            </div>
        </div>
    </div>

    <div class="card-custom mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-dark mb-0">Daftar Calon Penerima Bantuan</h6>
            <span class="text-muted small">Pilih status keputusan untuk tiap warga di bawah ini</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 text-muted fw-semibold" style="width: 5%;">NO</th>
                        <th class="py-3 text-muted fw-semibold" style="width: 30%;">NAMA WARGA & RT/RW</th>
                        <th class="py-3 text-muted fw-semibold" style="width: 25%;">KONDISI EKONOMI</th>
                        <th class="py-3 text-muted fw-semibold text-center" style="width: 40%;">KEPUTUSAN SELEKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $index => $item): ?>
                            <tr>
                                <td class="fw-bold text-muted"><?= $index + 1; ?></td>
                                <td>
                                    <strong class="d-block text-dark"><?= $item['full_name']; ?></strong>
                                    <span class="text-muted" style="font-size: 0.725rem;">RT/RW <?= isset($item['rt_rw']) ? $item['rt_rw'] : '-'; ?></span>
                                </td>
                                <td>
                                    <span class="text-dark"><?= isset($item['economic_status']) && !empty($item['economic_status']) ? $item['economic_status'] : 'Tidak ada keterangan'; ?></span>
                                    <div class="text-success" style="font-size: 0.7rem;"><i class="bi bi-check-circle"></i> Terverifikasi Kelurahan</div>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex align-items-center gap-3 bg-light px-3 py-1.5 rounded-pill border">
                                        <label class="d-flex align-items-center gap-1 text-success fw-bold m-0" style="font-size: 0.8rem; cursor: pointer;">
                                            <input type="radio" name="decision[<?= $item['id']; ?>]" value="accepted" <?= ($item['selection_status'] == 'accepted') ? 'checked' : ''; ?> required> Diterima
                                        </label>
                                        <span class="text-muted">|</span>
                                        <label class="d-flex align-items-center gap-1 text-danger fw-bold m-0" style="font-size: 0.8rem; cursor: pointer;">
                                            <input type="radio" name="decision[<?= $item['id']; ?>]" value="rejected" <?= ($item['selection_status'] == 'rejected') ? 'checked' : ''; ?>> Ditolak
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Tidak ada data warga dalam usulan ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-custom d-flex justify-content-between align-items-center">
        <span class="text-muted small">Pastikan keputusan telah sesuai dengan kuota dan kriteria program.</span>
        <button type="submit" class="btn btn-primary px-4 py-2.5 rounded-3 fw-bold shadow-sm" style="font-size: 0.875rem;">
            Simpan Hasil Seleksi
        </button>
    </div>
</form>

</div>