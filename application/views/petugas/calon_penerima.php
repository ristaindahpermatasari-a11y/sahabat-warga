<div class="main-content flex-grow-1">
    <?php $this->load->view('layout/topnav'); ?>

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <span class="text-primary text-uppercase fw-bold tracking-wider" style="font-size: 0.725rem;">KELOLA DATA</span>
            <h3 class="fw-bold mt-1 text-dark mb-0">Data Calon Penerima</h3>
            <p class="text-muted small mb-0">Kelola daftar warga calon penerima bantuan di wilayah Anda.</p>
        </div>
        <button class="btn btn-primary px-3 py-2 fw-medium d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahWarga" style="border-radius: 10px; font-size: 0.875rem;">
            <i class="bi bi-person-plus-fill"></i> Tambah Warga Baru
        </button>
    </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-4 d-flex align-items-center gap-2" role="alert" style="font-size: 0.85rem; border-radius: 10px;">
        <i class="bi bi-check-circle-fill fs-6"></i>
        <div><?= $this->session->flashdata('success'); ?></div>
        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card-custom">
    <div class="table-responsive p-2">
        <table id="tabelWarga" class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
            <thead class="table-light">
                <tr>
                    <th class="text-muted fw-semibold py-3">NAMA LENGKAP</th>
                    <th class="text-muted fw-semibold py-3">RT/RW & ALAMAT</th>
                    <th class="text-muted fw-semibold py-3">NO. TELEPON</th>
                    <th class="text-muted fw-semibold py-3">STATUS EKONOMI</th>
                    <th class="text-muted fw-semibold py-3 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recipients)): ?>
                    <?php foreach ($recipients as $row): ?>
                        <tr>
                            <td class="fw-semibold text-dark"><?= $row['full_name']; ?></td>
                            <td>
                                <div class="fw-medium">RT/RW <?= $row['rt_rw']; ?></div>
                                <span class="text-muted extra-small" style="font-size: 0.75rem;"><?= $row['address']; ?></span>
                            </td>
                            <td><?= $row['phone'] ? $row['phone'] : '-'; ?></td>
                            <td>
                                <?php 
                                    $status = strtolower($row['economic_status']);
                                    if ($status == 'sangat kurang mampu' || $status == 'sangat_miskin') {
                                        $badge_class = 'bg-danger bg-opacity-10 text-danger border-danger';
                                    } else if ($status == 'kurang mampu' || $status == 'kurang_mampu') {
                                        $badge_class = 'bg-warning bg-opacity-10 text-warning border-warning';
                                    } else {
                                        $badge_class = 'bg-primary bg-opacity-10 text-primary border-primary';
                                    }
                                ?>
                                <span class="badge <?= $badge_class; ?> border border-opacity-20 px-3 py-1.5 rounded-pill fw-medium" style="font-size: 0.75rem;">
                                    <?= ucfirst(str_replace('_', ' ', $row['economic_status'])); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <!-- Tombol Detail -->
                                    <button class="btn btn-sm btn-outline-primary p-1 px-2 rounded-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalDetailWarga<?= $row['id']; ?>" 
                                            title="Detail" style="font-size: 0.75rem;">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-sm btn-light border p-1 px-2 rounded-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditWarga<?= $row['id']; ?>" 
                                            title="Edit" style="font-size: 0.75rem;">
                                        <i class="bi bi-pencil text-secondary"></i>
                                    </button>
                                    
                                    <button class="btn btn-sm btn-light border p-1 px-2 rounded-2 text-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalHapusWarga<?= $row['id']; ?>" 
                                            title="Hapus" style="font-size: 0.75rem;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalDetailWarga<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; padding: 10px;">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <div>
                                            <span class="text-primary text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">DETAIL WARGA</span>
                                            <h4 class="modal-title fw-bold text-dark mt-1"><?= $row['full_name']; ?></h4>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body py-3" style="font-size: 0.85rem;">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="bg-light p-3 rounded-3">
                                                    <span class="text-muted d-block extra-small mb-1" style="font-size: 0.725rem;">Status</span>
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-2.5 py-1 rounded-pill">
                                                        Terverifikasi
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-light p-3 rounded-3">
                                                    <span class="text-muted d-block extra-small mb-1" style="font-size: 0.725rem;">Nomor telepon</span>
                                                    <strong class="text-dark"><?= $row['phone'] ? $row['phone'] : '-'; ?></strong>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="bg-light p-3 rounded-3">
                                                    <span class="text-muted d-block extra-small mb-1" style="font-size: 0.725rem;">Alamat</span>
                                                    <strong class="text-dark"><?= $row['address']; ?> RT/RW <?= $row['rt_rw']; ?></strong>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-light p-3 rounded-3">
                                                    <span class="text-muted d-block extra-small mb-1" style="font-size: 0.725rem;">Status Ekonomi</span>
                                                    <strong class="text-dark"><?= ucfirst(str_replace('_', ' ', $row['economic_status'])); ?></strong>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-light p-3 rounded-3">
                                                    <span class="text-muted d-block extra-small mb-1" style="font-size: 0.725rem;">Pendaftaran</span>
                                                    <strong class="text-dark"><?= date('d M Y', strtotime($row['created_at'])); ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 pt-2 d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-outline-secondary px-4 rounded-3" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalEditWarga<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">
                                    <div class="modal-header border-bottom px-4 pt-4 pb-3">
                                        <div>
                                            <h5 class="modal-title fw-bold text-dark mb-1">Edit Data Calon Penerima</h5>
                                            <p class="text-muted extra-small mb-0" style="font-size: 0.775rem;">Ubah informasi data warga di bawah ini.</p>
                                        </div>
                                        <button type="button" class="btn-close align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('index.php/petugas/edit_penerima/' . $row['id']); ?>" method="POST">
                                        <div class="modal-body px-4 py-3 text-start" style="font-size: 0.85rem;">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark mb-1">Nama Lengkap</label>
                                                <input type="text" name="full_name" class="form-control px-3" value="<?= $row['full_name']; ?>" required style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-dark mb-1">RT / RW</label>
                                                    <input type="text" name="rt_rw" class="form-control px-3" value="<?= $row['rt_rw']; ?>" required style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-dark mb-1">No. Telepon / WA</label>
                                                    <input type="text" name="phone" class="form-control px-3" value="<?= $row['phone']; ?>" style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark mb-1">Status Ekonomi</label>
                                                <select name="economic_status" class="form-select px-3" required style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                                                    <option value="Kurang Mampu" <?= ($row['economic_status'] == 'Kurang Mampu' || $row['economic_status'] == 'kurang_mampu') ? 'selected' : ''; ?>>Kurang Mampu / Rentan</option>
                                                    <option value="Sangat Kurang Mampu" <?= ($row['economic_status'] == 'Sangat Kurang Mampu' || $row['economic_status'] == 'sangat_kurang_mampu') ? 'selected' : ''; ?>>Sangat Kurang Mampu</option>
                                                    <option value="Lansia Tunggal" <?= ($row['economic_status'] == 'Lansia Tunggal' || $row['economic_status'] == 'lansia_tunggal') ? 'selected' : ''; ?>>Lansia Tunggal</option>
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label fw-semibold text-dark mb-1">Alamat Lengkap</label>
                                                <textarea name="address" class="form-control px-3 py-2" rows="2" required style="font-size: 0.85rem; border-radius: 8px;"><?= $row['address']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4 d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-light border px-4 rounded-3 fw-medium" data-bs-dismiss="modal" style="font-size: 0.85rem; height: 38px;">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4 rounded-3 fw-medium shadow-sm" style="font-size: 0.85rem; height: 38px;">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalHapusWarga<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg text-center p-3" style="border-radius: 18px;">
                                    <div class="modal-body pt-4">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                            <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">Hapus Data Warga?</h5>
                                        <p class="text-muted small mb-0">Apakah Anda yakin ingin menghapus data <strong><?= $row['full_name']; ?></strong>? Tindakan ini tidak dapat dibatalkan.</p>
                                    </div>
                                    <div class="modal-footer border-top-0 justify-content-center pb-3 gap-2">
                                        <button type="button" class="btn btn-light border px-4 rounded-3 fw-medium" data-bs-dismiss="modal" style="font-size: 0.85rem;">Batal</button>
                                        <a href="<?= base_url('index.php/petugas/hapus_penerima/' . $row['id']); ?>" class="btn btn-danger px-4 rounded-3 fw-medium shadow-sm" style="font-size: 0.85rem;">Ya, Hapus Data</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-people fs-2 text-secondary opacity-50 mb-2 d-block"></i>
                            Belum ada data calon penerima. Klik tombol <strong>Tambah Warga Baru</strong> untuk memasukkan data.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambahWarga" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">
            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1">Tambah Calon Penerima</h5>
                    <p class="text-muted extra-small mb-0" style="font-size: 0.775rem;">Isi formulir di bawah untuk mendaftarkan warga baru ke sistem.</p>
                </div>
                <button type="button" class="btn-close align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('index.php/petugas/tambah_penerima'); ?>" method="POST">
                <div class="modal-body px-4 py-3" style="font-size: 0.85rem;">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark mb-1">Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control px-3" placeholder="Sesuai KTP" required style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark mb-1">RT / RW</label>
                            <input type="text" name="rt_rw" class="form-control px-3" placeholder="001/002" required style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark mb-1">No. Telepon / WA</label>
                            <input type="text" name="phone" class="form-control px-3" placeholder="08123456789" style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark mb-1">Status Ekonomi</label>
                        <select name="economic_status" class="form-select px-3" required style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Kurang Mampu">Kurang Mampu / Rentan</option>
                            <option value="Sangat Kurang Mampu">Sangat Kurang Mampu</option>
                            <option value="Lansia Tunggal">Lansia Tunggal</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold text-dark mb-1">Alamat Lengkap</label>
                        <textarea name="address" class="form-control px-3 py-2" rows="2" placeholder="Jl. Anggrek No. 12..." required style="font-size: 0.85rem; border-radius: 8px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light border px-4 rounded-3 fw-medium" data-bs-dismiss="modal" style="font-size: 0.85rem; height: 38px;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3 fw-medium shadow-sm" style="font-size: 0.85rem; height: 38px;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tabelWarga').DataTable({
            "language": {
                "search": "Cari data:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data warga tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
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
    });
</script>