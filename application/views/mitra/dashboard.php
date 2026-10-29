<?php $this->load->view('layout/sidebar_mitra'); ?>

<div class="main-content flex-grow-1">
    <?php $this->load->view('layout/topnav'); ?>

    <div class="mb-4">
        <span class="text-primary text-uppercase fw-bold tracking-wider" style="font-size: 0.725rem;">DASHBOARD MITRA</span>
        <h3 class="fw-bold mt-1 text-dark mb-1">Selamat datang, <?= isset($user_name) ? $user_name : 'Yayasan Peduli'; ?>!</h3>
        <p class="text-muted small mb-0">Kelola program, seleksi usulan, dan pantau penyaluran bantuan dari satu tempat.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-custom p-3 d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 d-flex align-items-center justify-content-center">
                    <i class="bi bi-gift fs-4"></i>
                </div>
                <div>
                    <span class="text-muted d-block" style="font-size: 0.75rem;">Program saya</span>
                    <h4 class="fw-bold text-dark mb-0"><?= isset($total_programs) ? $total_programs : 0; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom p-3 d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3 d-flex align-items-center justify-content-center">
                    <i class="bi bi-inbox fs-4"></i>
                </div>
                <div>
                    <span class="text-muted d-block" style="font-size: 0.75rem;">Usulan masuk</span>
                    <h4 class="fw-bold text-dark mb-0"><?= isset($total_usulan) ? $total_usulan : 0; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom p-3 d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 d-flex align-items-center justify-content-center">
                    <i class="bi bi-check-circle fs-4"></i>
                </div>
                <div>
                    <span class="text-muted d-block" style="font-size: 0.75rem;">Penerima terpilih</span>
                    <h4 class="fw-bold text-dark mb-0"><?= isset($penerima_terpilih) ? $penerima_terpilih : 0; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom p-3 d-flex align-items-center gap-3">
                <div class="bg-info bg-opacity-10 text-info rounded-3 p-3 d-flex align-items-center justify-content-center">
                    <i class="bi bi-truck fs-4"></i>
                </div>
                <div>
                    <span class="text-muted d-block" style="font-size: 0.75rem;">Selesai disalurkan</span>
                    <h4 class="fw-bold text-dark mb-0"><?= isset($penyaluran_selesai) ? $penyaluran_selesai : 0; ?></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card-custom h-100 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="fw-bold text-dark mb-1">Grafik Ringkasan Penyaluran</h5>
                    <span class="text-muted small d-block mb-3">Statistik dan grafik perkembangan bantuan aktif.</span>
                </div>
                
                <div class="position-relative my-auto py-2" style="height: 190px;">
                    <canvas id="dashboardChart"></canvas>
                </div>

                <div class="d-flex justify-content-around border-top pt-3 text-muted" style="font-size: 0.75rem;">
                    <span><i class="bi bi-circle-fill text-primary me-1"></i> Dalam Proses: <strong><?= isset($status_proses) ? $status_proses : 0; ?></strong></span>
                    <span><i class="bi bi-circle-fill text-success me-1"></i> Selesai Disalurkan: <strong><?= isset($status_selesai) ? $status_selesai : 0; ?></strong></span>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card-custom h-100 d-flex flex-column justify-content-between">
                <div>
                    <span class="text-primary text-uppercase fw-bold tracking-wider d-block mb-2" style="font-size: 0.7rem;">AKSI CEPAT</span>
                    <h5 class="fw-bold text-dark mb-3">Akses Cepat</h5>
                </div>
                <div class="d-flex flex-column gap-3">
                    <a href="<?= base_url('index.php/mitra/program_bantuan'); ?>" class="p-3 border rounded-3 text-decoration-none bg-light d-flex justify-content-between align-items-center hover-shadow">
                        <div>
                            <strong class="text-dark d-block" style="font-size: 0.85rem;">Buat program bantuan</strong>
                            <span class="text-muted" style="font-size: 0.725rem;">Atur kriteria dan kuota</span>
                        </div>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>
                    <a href="<?= base_url('index.php/mitra/usulan_masuk'); ?>" class="p-3 border rounded-3 text-decoration-none bg-light d-flex justify-content-between align-items-center hover-shadow">
                        <div>
                            <strong class="text-dark d-block" style="font-size: 0.85rem;">Periksa usulan masuk</strong>
                            <span class="text-muted" style="font-size: 0.725rem;">Tinjau kiriman Petugas</span>
                        </div>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card-custom">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold text-dark mb-1">Aktivitas Pengajuan Terbaru</h5>
                <span class="text-muted extra-small" style="font-size: 0.775rem;">Data usulan bantuan yang dikirimkan oleh Petugas Kelurahan</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="table-light">
                    <tr>
                        <th class="text-muted fw-semibold py-3">REFERENSI</th>
                        <th class="text-muted fw-semibold py-3">PROGRAM</th>
                        <th class="text-muted fw-semibold py-3">JUMLAH WARGA</th>
                        <th class="text-muted fw-semibold py-3">STATUS</th>
                        <th class="text-muted fw-semibold py-3 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recent_proposals)): ?>
                        <?php foreach ($recent_proposals as $p): ?>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark"><?= $p['reference_code']; ?></strong>
                                    <span class="text-muted extra-small" style="font-size: 0.725rem;"><?= date('d M Y, H:i', strtotime($p['created_at'])); ?></span>
                                </td>
                                <td class="fw-semibold text-dark"><?= $p['program_name'] ? $p['program_name'] : '-'; ?></td>
                                <td><?= $p['total_proposed']; ?> orang</td>
                                <td>
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20 px-3 py-1.5 rounded-pill">
                                        <?= ucfirst($p['status']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('index.php/mitra/detail_usulan/' . $p['id']); ?>" class="btn btn-sm btn-outline-primary px-3 py-1 rounded-2" style="font-size: 0.775rem;">
                                        Lihat detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada usulan pengajuan masuk dari Petugas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('dashboardChart').getContext('2d');
    var dashboardChart = new Chart(ctx, {
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
            plugins: {
                legend: { display: false }
            },
            cutout: '75%'
        }
    });
});
</script>