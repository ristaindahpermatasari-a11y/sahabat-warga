<div class="main-content flex-grow-1">
    <?php $this->load->view('layout/topnav'); ?>

<div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
    <div>
        <span class="text-primary text-uppercase fw-bold tracking-wider" style="font-size: 0.725rem;">LAPORAN</span>
        <h3 class="fw-bold mt-1 text-dark mb-1">Ringkasan Penyaluran Bantuan</h3>
        <p class="text-muted small mb-0">Pantau capaian program dan hasil proses bantuan dalam sesi aktif.</p>
    </div>
    <a href="<?= base_url('index.php/mitra/cetak_laporan?' . $_SERVER['QUERY_STRING']); ?>" target="_blank" class="btn btn-primary px-3 py-2 fw-semibold rounded-3 shadow-sm text-decoration-none" style="font-size: 0.85rem;">
        <i class="bi bi-printer me-1"></i> Cetak Ringkasan (PDF)
    </a>
</div>


<div class="d-none d-print-block text-center border-bottom pb-3 mb-4">
    <h4 class="fw-bold text-dark mb-1 text-uppercase">YAYASAN PEDULI KELURAHAN - SAHABATWARGA</h4>
    <p class="text-muted small mb-0">Laporan Resmi Rekapitulasi Program dan Penyaluran Bantuan Sosial</p>
    <p class="text-muted extra-small" style="font-size: 0.75rem;">Dicetak pada: <?= date('d F Y, H:i'); ?> WIB oleh <?= isset($user_name) ? $user_name : 'Mitra Bantuan'; ?></p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-inbox fs-4"></i>
            </div>
            <div>
                <span class="text-muted d-block" style="font-size: 0.725rem;">Total usulan</span>
                <h4 class="fw-bold text-dark mb-0"><?= isset($total_usulan) ? $total_usulan : 0; ?></h4>
                <span class="text-muted extra-small" style="font-size: 0.7rem;">Pengajuan diterima</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-check-circle fs-4"></i>
            </div>
            <div>
                <span class="text-muted d-block" style="font-size: 0.725rem;">Penerima terpilih</span>
                <h4 class="fw-bold text-dark mb-0"><?= isset($penerima_terpilih) ? $penerima_terpilih : 0; ?></h4>
                <span class="text-muted extra-small" style="font-size: 0.7rem;">Lolos seleksi</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-people fs-4"></i>
            </div>
            <div>
                <span class="text-muted d-block" style="font-size: 0.725rem;">Tidak terpilih</span>
                <h4 class="fw-bold text-dark mb-0"><?= isset($tidak_terpilih) ? $tidak_terpilih : 0; ?></h4>
                <span class="text-muted extra-small" style="font-size: 0.7rem;">Keputusan tercatat</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="bg-info bg-opacity-10 text-info rounded-3 p-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-truck fs-4"></i>
            </div>
            <div>
                <span class="text-muted d-block" style="font-size: 0.725rem;">Penyaluran selesai</span>
                <h4 class="fw-bold text-dark mb-0"><?= isset($penyaluran_selesai) ? $penyaluran_selesai : 0; ?></h4>
                <span class="text-muted extra-small" style="font-size: 0.7rem;">Pengajuan tuntas</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="card-custom h-100">
            <h5 class="fw-bold text-dark mb-1">Rekap per Program</h5>
            <span class="text-muted small d-block mb-4">Perbandingan usulan dan penerima terpilih.</span>
            <div class="d-flex flex-column gap-3">
                <?php if (!empty($programs)): ?>
                    <?php foreach ($programs as $prog): ?>
                        <div class="p-3 bg-light rounded-3">
                            <div class="d-flex justify-content-between mb-1">
                                <strong class="text-dark small"><?= $prog['title']; ?></strong>
                                <span class="text-muted small fw-bold"><?= $prog['percentage']; ?>%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $prog['percentage']; ?>%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 text-muted" style="font-size: 0.725rem;">
                                <span>Usulan: <?= $prog['total_usulan_prog']; ?> pengajuan</span>
                                <span>Penerima lolos: <?= $prog['penerima_prog']; ?> orang</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card-custom h-100 d-flex flex-column justify-content-between">
            <div>
                <h5 class="fw-bold text-dark mb-1">Status Pengajuan</h5>
                <span class="text-muted small d-block mb-3">Distribusi proses saat ini.</span>
            </div>
            <div class="position-relative my-auto" style="height: 180px;">
                <canvas id="statusProposalChart"></canvas>
            </div>
            <div class="d-flex justify-content-around border-top pt-3 text-muted" style="font-size: 0.75rem;">
                <span><i class="bi bi-circle-fill text-primary me-1"></i> Dalam Proses: <strong><?= isset($status_proses) ? $status_proses : 0; ?></strong></span>
                <span><i class="bi bi-circle-fill text-success me-1"></i> Selesai: <strong><?= isset($status_selesai) ? $status_selesai : 0; ?></strong></span>
            </div>
        </div>
    </div>
</div>

<div class="card-custom mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0">Rincian Data & Filter Tanggal</h5>
    </div>

    <form method="GET" action="<?= base_url('index.php/mitra/laporan'); ?>" class="row g-3 align-items-end mb-4 bg-light p-3 rounded-3 d-print-none">
        <div class="col-md-3">
            <label class="form-label small fw-bold text-dark">Filter Program</label>
            <select name="program_id" class="form-select form-select-sm">
                <option value="">-- Semua Program --</option>
                <?php foreach ($programs_list as $prog): ?>
                    <option value="<?= $prog['program_id']; ?>" <?= (isset($filter_program) && $filter_program == $prog['program_id']) ? 'selected' : ''; ?>>
                        <?= $prog['title']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-bold text-dark">Status Seleksi</label>
            <select name="selection_status" class="form-select form-select-sm">
                <option value="">-- Semua --</option>
                <option value="accepted" <?= (isset($filter_status) && $filter_status == 'accepted') ? 'selected' : ''; ?>>Diterima</option>
                <option value="rejected" <?= (isset($filter_status) && $filter_status == 'rejected') ? 'selected' : ''; ?>>Ditolak</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-bold text-dark">Dari Tanggal</label>
            <input type="date" name="start_date" value="<?= isset($start_date) ? $start_date : ''; ?>" class="form-control form-control-sm">
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-bold text-dark">Sampai Tanggal</label>
            <input type="date" name="end_date" value="<?= isset($end_date) ? $end_date : ''; ?>" class="form-control form-control-sm">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold py-1.5">Terapkan</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0" style="font-size: 0.8rem;">
            <thead class="table-light">
                <tr>
                    <th class="text-center">No</th>
                    <th>Ref Proposal</th>
                    <th>Nama Program</th>
                    <th>Nama Warga</th>
                    <th class="text-center">RT/RW</th>
                    <th>Keterangan Ekonomi</th>
                    <th class="text-center">Keputusan Mitra</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($detail_laporan)): ?>
                    <?php $no = 1; foreach ($detail_laporan as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= $row['reference_code']; ?></td>
                            <td><?= $row['program_name']; ?></td>
                            <td><strong><?= $row['full_name']; ?></strong></td>
                            <td class="text-center"><?= $row['rt_rw']; ?></td>
                            <td><?= $row['economic_status']; ?></td>
                            <td class="text-center">
                                <?php if ($row['selection_status'] == 'accepted'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">Diterima</span>
                                <?php elseif ($row['selection_status'] == 'rejected'): ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">Ditolak</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1">Menunggu</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada data rincian yang sesuai dengan filter.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</div>

<!-- Tanda Tangan (Hanya Muncul Saat Dicetak) -->
<div class="d-none d-print-block row mt-5">
    <div class="col-6 offset-6 text-center" style="font-size: 0.85rem;">
        <p class="mb-1">Bekasi, <?= date('d F Y'); ?></p>
        <p class="fw-bold mb-5">Penanggung Jawab / Mitra Bantuan,</p>
        <br>
        <p class="fw-bold text-decoration-underline mb-0"><?= isset($user_name) ? $user_name : 'Natania'; ?></p>
        <span class="text-muted small">Mitra Pelaksana SahabatWarga</span>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('statusProposalChart').getContext('2d');
    var statusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Dalam Proses', 'Selesai Disalurkan'],
            datasets: [{
                data: [<?= isset($status_proses) ? $status_proses : 0; ?>, <?= isset($status_selesai) ? $status_selesai : 0; ?>],
                backgroundColor: ['#0d6efd', '#198754'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            cutout: '75%'
        }
    });
});
</script>

<style>
@media print {
    aside, nav, header, footer, .d-print-none {
        display: none !important;
    }
    body, main, .main-content {
        background-color: #ffffff !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }
    .d-none.d-print-block {
        display: block !important;
    }
}
</style>