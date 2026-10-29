<div class="main-content flex-grow-1">
    <?php $this->load->view('layout/topnav'); ?>

    <div class="mb-4">
        <span class="text-primary text-uppercase fw-bold tracking-wider" style="font-size: 0.725rem;">DASHBOARD PETUGAS</span>
        <h3 class="fw-bold mt-1 text-dark">Selamat datang, <?= isset($user_name) ? $user_name : 'Petugas'; ?>!</h3>
        <p class="text-muted small mb-0">Pantau data warga dan perkembangan pengajuan bantuan di wilayah Anda.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-custom d-flex align-items-center gap-3">
                <div class="stat-icon-box bg-primary bg-opacity-10 text-primary fs-5">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="text-muted extra-small" style="font-size: 0.75rem;">Calon penerima</div>
                    <h4 class="fw-bold mb-0"><?= isset($total_recipients) ? $total_recipients : 0; ?></h4>
                    <div class="text-muted" style="font-size: 0.675rem;">Total warga terdaftar</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom d-flex align-items-center gap-3">
                <div class="stat-icon-box fs-5" style="background-color: #f3e8ff; color: #9333ea;">
                    <i class="bi bi-gift"></i>
                </div>
                <div>
                    <div class="text-muted extra-small" style="font-size: 0.75rem;">Program aktif</div>
                    <h4 class="fw-bold mb-0"><?= isset($active_programs) ? $active_programs : 0; ?></h4>
                    <div class="text-muted" style="font-size: 0.675rem;">Tersedia untuk diajukan</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom d-flex align-items-center gap-3">
                <div class="stat-icon-box bg-warning bg-opacity-10 text-warning fs-5">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div>
                    <div class="text-muted extra-small" style="font-size: 0.75rem;">Usulan diajukan</div>
                    <h4 class="fw-bold mb-0"><?= isset($total_proposals) ? $total_proposals : 0; ?></h4>
                    <div class="text-muted" style="font-size: 0.675rem;">Total pengajuan dibuat</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom d-flex align-items-center gap-3">
                <div class="stat-icon-box bg-success bg-opacity-10 text-success fs-5">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="text-muted extra-small" style="font-size: 0.75rem;">Penerima terpilih</div>
                    <h4 class="fw-bold mb-0"><?= isset($approved_proposals) ? $approved_proposals : 0; ?></h4>
                    <div class="text-muted" style="font-size: 0.675rem;">Disetujui oleh Mitra</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Grafik Ringkasan Penyaluran -->
        <div class="col-md-7">
            <div class="card-custom h-100 d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="fw-bold mb-1">Ringkasan Penyaluran</h6>
                        <span class="text-muted extra-small" style="font-size: 0.75rem;">Perkembangan bantuan enam bulan terakhir</span>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-bold" style="font-size: 0.75rem;">2026</span>
                </div>

                <div class="position-relative my-3" style="height: 220px;">
                    <canvas id="ringkasanPenyaluranChart"></canvas>
                </div>

                <div class="d-flex justify-content-between align-items-center border-top pt-3 text-muted" style="font-size: 0.75rem;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="bg-primary rounded-circle d-inline-block" style="width: 10px; height: 10px;"></span>
                        <span>Bantuan tersalurkan</span>
                    </div>
                    <strong class="text-dark"><?= isset($total_tersalurkan) ? $total_tersalurkan : 0; ?> keluarga</strong>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card-custom h-100">
                <h6 class="fw-bold mb-1">Aksi Cepat</h6>
                <span class="text-muted extra-small d-block mb-3" style="font-size: 0.75rem;">Akses fitur yang sering digunakan</span>

                <div class="d-flex flex-column gap-3">
                    <a href="<?= base_url('index.php/petugas/calon_penerima'); ?>" class="action-item p-3 border rounded-3 text-decoration-none bg-light d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box bg-primary bg-opacity-10 text-primary fs-6 p-2 rounded-2">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark" style="font-size: 0.85rem;">Tambah calon penerima</div>
                                <div class="text-muted extra-small" style="font-size: 0.725rem;">Lengkapi data warga baru</div>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted small"></i>
                    </a>

                    <a href="<?= base_url('index.php/petugas/pengajuan_bantuan'); ?>" class="action-item p-3 border rounded-3 text-decoration-none bg-light d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box bg-primary bg-opacity-10 text-primary fs-6 p-2 rounded-2">
                                <i class="bi bi-file-earmark-plus"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark" style="font-size: 0.85rem;">Buat pengajuan bantuan</div>
                                <div class="text-muted extra-small" style="font-size: 0.725rem;">Pilih program dan warga</div>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted small"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card-custom">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="fw-bold mb-1">Aktivitas Pengajuan Terbaru</h6>
                <span class="text-muted extra-small" style="font-size: 0.75rem;">Data realtime dari tabel proposals</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.825rem;">
                <thead class="table-light">
                    <tr>
                        <th class="text-muted fw-semibold">REFERENSI</th>
                        <th class="text-muted fw-semibold">PROGRAM</th>
                        <th class="text-muted fw-semibold">JUMLAH WARGA</th>
                        <th class="text-muted fw-semibold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recent_proposals)): ?>
                        <?php foreach ($recent_proposals as $row): ?>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark"><?= $row['reference_code']; ?></strong>
                                    <span class="text-muted extra-small" style="font-size: 0.7rem;"><?= date('d M Y', strtotime($row['created_at'])); ?></span>
                                </td>
                                <td class="fw-semibold text-dark"><?= $row['program_name'] ? $row['program_name'] : '-'; ?></td>
                                <td><?= $row['total_proposed']; ?> orang</td>
                                <td>
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20 px-3 py-1.5 rounded-pill">
                                        <?= ucfirst($row['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada pengajuan bantuan yang dibuat.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div> 

<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('ringkasanPenyaluranChart').getContext('2d');
    var ringkasanChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= isset($chart_labels) ? $chart_labels : "['Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt']"; ?>,
            datasets: [{
                label: 'Bantuan tersalurkan',
                data: <?= isset($chart_monthly_data) ? $chart_monthly_data : '[0,0,0,0,0,0]'; ?>,
                backgroundColor: '#0d6efd',
                borderRadius: 6,
                barThickness: 28
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f3f5' },
                    ticks: { font: { size: 10 }, stepSize: 1 }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10 } }
                }
            }
        }
    });
});
</script>