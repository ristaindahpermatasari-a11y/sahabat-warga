<div class="main-content flex-grow-1">
    <?php $this->load->view('layout/topnav'); ?>

    <div class="mb-4">
        <span class="text-primary text-uppercase fw-bold tracking-wider" style="font-size: 0.725rem;">USULAN MASUK</span>
        <h3 class="fw-bold mt-1 text-dark mb-1">Usulan dari Petugas</h3>
        <p class="text-muted small mb-0">Tinjau pengajuan calon penerima yang dikirim oleh Petugas wilayah.</p>
    </div>

    <div class="card-custom">
        <div class="table-responsive">
            <table id="tabelUsulan" class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="table-light">
                    <tr>
                        <th class="text-muted fw-semibold py-3">REFERENSI</th>
                        <th class="text-muted fw-semibold py-3">PROGRAM</th>
                        <th class="text-muted fw-semibold py-3">PETUGAS</th>
                        <th class="text-muted fw-semibold py-3">JUMLAH</th>
                        <th class="text-muted fw-semibold py-3">STATUS</th>
                        <th class="text-muted fw-semibold py-3 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($proposals)): ?>
                        <?php foreach ($proposals as $p): ?>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark"><?= $p['reference_code']; ?></strong>
                                    <span class="text-muted extra-small" style="font-size: 0.725rem;"><?= date('d M Y, H:i', strtotime($p['created_at'])); ?></span>
                                </td>
                                <td class="fw-semibold text-dark"><?= $p['program_name'] ? $p['program_name'] : '-'; ?></td>
                                <td><?= $p['petugas_name'] ? $p['petugas_name'] : 'Petugas Kelurahan'; ?></td>
                                <td><?= $p['total_proposed']; ?> warga</td>
                                <td>
                                    <?php if ($p['status'] == 'submitted'): ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20 px-3 py-1.5 rounded-pill">Diajukan</span>
                                    <?php else: ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-3 py-1.5 rounded-pill">Selesai Diseleksi</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('index.php/mitra/detail_usulan/' . $p['id']); ?>" class="text-primary fw-medium text-decoration-none">
                                        Lihat detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada usulan masuk dari Petugas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SCRIPTS DATATABLES UNTUK MITRA -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
// Mematikan pop-up error DataTables secara global agar tidak mengganggu
$.fn.dataTable.ext.errMode = 'none';

document.addEventListener('DOMContentLoaded', function() {
    $(document).ready(function() {
        if ($('#tabelUsulan').length) {
            $('#tabelUsulan').DataTable({
                "destroy": true, 
                "retrieve": true, 
                "language": {
                    "search": "Cari usulan:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Data usulan tidak ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(disaring dari _MAX_ total data)",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        }
    });
});
</script>