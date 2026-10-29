<?php $this->load->view('layout/header'); ?>
<?php $this->load->view('layout/sidebar_mitra'); ?>

<div class="main-content">
    <?php $this->load->view('layout/topnav'); ?>

    <div class="d-flex justify-content-between align-items-center mb-4 w-100">
        <div>
            <span class="text-primary text-uppercase fw-bold tracking-wider" style="font-size: 0.725rem;">PROGRAM BANTUAN</span>
            <h3 class="fw-bold mt-1 text-dark mb-0">Program Bantuan Saya</h3>
            <p class="text-muted small mb-0">Kelola program bantuan, kriteria penerima, wilayah, dan kuota program.</p>
        </div>
        <button class="btn btn-primary px-3 py-2 fw-medium d-flex align-items-center gap-2 shadow-sm flex-shrink-0" data-bs-toggle="modal" data-bs-target="#modalTambahProgram" style="border-radius: 10px; font-size: 0.875rem;">
            <i class="bi bi-plus-circle-fill"></i> Tambah Program
        </button>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-4 d-flex align-items-center gap-2" role="alert" style="font-size: 0.85rem; border-radius: 10px;">
            <i class="bi bi-check-circle-fill fs-6"></i>
            <div><?= $this->session->flashdata('success'); ?></div>
            <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex gap-2 mb-4">
        <a href="<?= base_url('index.php/mitra/program_bantuan?status=all'); ?>" 
           class="btn btn-sm <?= (empty($selected_status) || $selected_status == 'all') ? 'btn-primary' : 'btn-light border'; ?> px-3 rounded-pill" style="font-size: 0.8rem;">
            Semua
        </a>
        <a href="<?= base_url('index.php/mitra/program_bantuan?status=active'); ?>" 
           class="btn btn-sm <?= ($selected_status == 'active') ? 'btn-primary' : 'btn-light border'; ?> px-3 rounded-pill" style="font-size: 0.8rem;">
            Aktif
        </a>
        <a href="<?= base_url('index.php/mitra/program_bantuan?status=draft'); ?>" 
           class="btn btn-sm <?= ($selected_status == 'draft') ? 'btn-primary' : 'btn-light border'; ?> px-3 rounded-pill" style="font-size: 0.8rem;">
            Draf
        </a>
        <a href="<?= base_url('index.php/mitra/program_bantuan?status=closed'); ?>" 
           class="btn btn-sm <?= ($selected_status == 'closed') ? 'btn-primary' : 'btn-light border'; ?> px-3 rounded-pill" style="font-size: 0.8rem;">
            Tidak Aktif / Ditutup
        </a>
    </div>

    <div class="row g-4 mb-4">
        <?php if (!empty($programs)): ?>
            <?php foreach ($programs as $row): ?>
                <div class="col-md-4">
                    <div class="card-custom h-100 d-flex flex-column justify-content-between" style="width: 100%;">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-primary fw-bold text-uppercase" style="font-size: 0.7rem;"><?= $row['category'] ? $row['category'] : 'BANTUAN'; ?></span>
                                <?php 
                                    $st = strtolower($row['status']);
                                    if ($st == 'active') {
                                        echo '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-3 py-1.5 rounded-pill fw-medium" style="font-size: 0.75rem;">Aktif</span>';
                                    } else if ($st == 'draft') {
                                        echo '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20 px-3 py-1.5 rounded-pill fw-medium" style="font-size: 0.75rem;">Draf</span>';
                                    } else {
                                        echo '<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-20 px-3 py-1.5 rounded-pill fw-medium" style="font-size: 0.75rem;">Ditutup</span>';
                                    }
                                ?>
                            </div>
                            <h5 class="fw-bold text-dark mb-2"><?= $row['title']; ?></h5>
                            <p class="text-muted small mb-3" style="font-size: 0.825rem; line-height: 1.5;">
                                <?= strlen($row['description']) > 90 ? substr($row['description'], 0, 90) . '...' : $row['description']; ?>
                            </p>
                        </div>

                        <div>
                            <div class="row g-2 pt-3 border-top mb-3" style="font-size: 0.775rem;">
                                <div class="col-6">
                                    <span class="text-muted d-block" style="font-size: 0.7rem;">Wilayah</span>
                                    <strong class="text-dark"><?= $row['coverage_area'] ? $row['coverage_area'] : '-'; ?></strong>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted d-block" style="font-size: 0.7rem;">Kuota</span>
                                    <strong class="text-dark"><?= $row['quota']; ?> penerima</strong>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-light border w-50 rounded-3 py-2 fw-medium" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $row['program_id']; ?>" style="font-size: 0.775rem;">
                                    Lihat Detail
                                </button>
                                <button class="btn btn-sm btn-primary w-50 rounded-3 py-2 fw-medium shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['program_id']; ?>" style="font-size: 0.775rem;">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalDetail<?= $row['program_id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; padding: 10px;">
                            <div class="modal-header border-bottom-0 pb-0">
                                <div>
                                    <span class="text-primary text-uppercase fw-bold" style="font-size: 0.7rem;"><?= $row['category']; ?></span>
                                    <h4 class="modal-title fw-bold text-dark mt-1"><?= $row['title']; ?></h4>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body py-3" style="font-size: 0.85rem;">
                                <p class="text-muted mb-4"><?= $row['description']; ?></p>
                                
                                <div class="bg-light p-3 rounded-3 mb-3">
                                    <span class="text-muted d-block extra-small mb-1" style="font-size: 0.725rem;">Kriteria Kelayakan</span>
                                    <strong class="text-dark"><?= $row['criteria'] ? $row['criteria'] : 'Tidak ada kriteria khusus.'; ?></strong>
                                </div>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="bg-light p-3 rounded-3">
                                            <span class="text-muted d-block extra-small mb-1" style="font-size: 0.725rem;">Wilayah cakupan</span>
                                            <strong class="text-dark"><?= $row['coverage_area']; ?></strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light p-3 rounded-3">
                                            <span class="text-muted d-block extra-small mb-1" style="font-size: 0.725rem;">Kuota tersedia</span>
                                            <strong class="text-dark"><?= $row['quota']; ?> penerima</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 pt-2 d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-secondary px-4 rounded-3" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalEdit<?= $row['program_id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">
                            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                                <div>
                                    <h5 class="modal-title fw-bold text-dark mb-1">Edit Program</h5>
                                    <p class="text-muted extra-small mb-0" style="font-size: 0.775rem;">Ubah informasi program bantuan.</p>
                                </div>
                                <button type="button" class="btn-close align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('index.php/mitra/edit_program/' . $row['program_id']); ?>" method="POST">
                                <div class="modal-body px-4 py-3" style="font-size: 0.85rem;">
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark mb-1">Nama program *</label>
                                            <input type="text" name="title" class="form-control px-3" value="<?= $row['title']; ?>" required style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark mb-1">Kategori</label>
                                            <select name="category" class="form-select px-3" style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                                                <option value="Bantuan Pangan" <?= $row['category'] == 'Bantuan Pangan' ? 'selected' : ''; ?>>Bantuan Pangan</option>
                                                <option value="Pendidikan" <?= $row['category'] == 'Pendidikan' ? 'selected' : ''; ?>>Pendidikan</option>
                                                <option value="Pemberdayaan" <?= $row['category'] == 'Pemberdayaan' ? 'selected' : ''; ?>>Pemberdayaan</option>
                                                <option value="Tunai" <?= $row['category'] == 'Tunai' ? 'selected' : ''; ?>>Tunai</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark mb-1">Deskripsi *</label>
                                        <textarea name="description" class="form-control px-3 py-2" rows="2" required style="font-size: 0.85rem; border-radius: 8px;"><?= $row['description']; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark mb-1">Kriteria kelayakan *</label>
                                        <textarea name="criteria" class="form-control px-3 py-2" rows="2" required style="font-size: 0.85rem; border-radius: 8px;"><?= $row['criteria']; ?></textarea>
                                    </div>
                                    <div class="row g-3 mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark mb-1">Wilayah cakupan *</label>
                                            <input type="text" name="coverage_area" class="form-control px-3" value="<?= $row['coverage_area']; ?>" required style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold text-dark mb-1">Kuota penerima *</label>
                                            <input type="number" name="quota" class="form-control px-3" value="<?= $row['quota']; ?>" min="1" required style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold text-dark mb-1">Status program</label>
                                            <select name="status" class="form-select px-3" style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                                                <option value="active" <?= $row['status'] == 'active' ? 'selected' : ''; ?>>Aktif</option>
                                                <option value="draft" <?= $row['status'] == 'draft' ? 'selected' : ''; ?>>Draf</option>
                                                <option value="closed" <?= $row['status'] == 'closed' ? 'selected' : ''; ?>>Ditutup</option>
                                            </select>
                                        </div>
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

            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card-custom text-center py-5">
                    <i class="bi bi-gift fs-1 text-secondary opacity-50 mb-2 d-block"></i>
                    <h6 class="fw-bold text-dark">Belum Ada Program Bantuan</h6>
                    <p class="text-muted small mb-0">Tidak ada program untuk status ini. Klik tombol <strong>Tambah Program</strong> di atas.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal fade" id="modalTambahProgram" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">
                <div class="modal-header border-bottom px-4 pt-4 pb-3">
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-1">Tambah Program</h5>
                        <p class="text-muted extra-small mb-0" style="font-size: 0.775rem;">Buat program bantuan sosial baru untuk disalurkan.</p>
                    </div>
                    <button type="button" class="btn-close align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('index.php/mitra/tambah_program'); ?>" method="POST">
                    <div class="modal-body px-4 py-3" style="font-size: 0.85rem;">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark mb-1">Nama program *</label>
                                <input type="text" name="title" class="form-control px-3" placeholder="Contoh: Paket Pangan Keluarga 2025" required style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark mb-1">Kategori</label>
                                <select name="category" class="form-select px-3" style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                                    <option value="Bantuan Pangan">Bantuan Pangan</option>
                                    <option value="Pendidikan">Pendidikan</option>
                                    <option value="Pemberdayaan">Pemberdayaan</option>
                                    <option value="Tunai">Tunai</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark mb-1">Deskripsi *</label>
                            <textarea name="description" class="form-control px-3 py-2" rows="2" placeholder="Dukungan bahan pangan pokok bulanan..." required style="font-size: 0.85rem; border-radius: 8px;"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark mb-1">Kriteria kelayakan *</label>
                            <textarea name="criteria" class="form-control px-3 py-2" rows="2" placeholder="Penghasilan di bawah Rp2.000.000..." required style="font-size: 0.85rem; border-radius: 8px;"></textarea>
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark mb-1">Wilayah cakupan *</label>
                                <input type="text" name="coverage_area" class="form-control px-3" placeholder="Kelurahan Sukamaju" required style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold text-dark mb-1">Kuota penerima *</label>
                                <input type="number" name="quota" class="form-control px-3" placeholder="3" required style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold text-dark mb-1">Status program</label>
                                <select name="status" class="form-select px-3" style="font-size: 0.85rem; height: 42px; border-radius: 8px;">
                                    <option value="draft">Draf</option>
                                    <option value="active">Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light border px-4 rounded-3 fw-medium" data-bs-dismiss="modal" style="font-size: 0.85rem; height: 38px;">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 rounded-3 fw-medium shadow-sm" style="font-size: 0.85rem; height: 38px;">Simpan Program</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>