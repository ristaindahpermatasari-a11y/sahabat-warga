<div class="main-content flex-grow-1">
    <?php $this->load->view('layout/topnav'); ?>

<div class="mb-4">
    <span class="text-primary text-uppercase fw-bold tracking-wider" style="font-size: 0.725rem;">PENGAJUAN BANTUAN</span>
    <h3 class="fw-bold mt-1 text-dark mb-1">Buat Pengajuan Bantuan</h3>
    <p class="text-muted small mb-0">Pilih program dan calon penerima terverifikasi, lalu tinjau sebelum dikirim.</p>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-4 d-flex align-items-center gap-2" role="alert" style="font-size: 0.85rem; border-radius: 10px;">
        <i class="bi bi-check-circle-fill fs-6"></i>
        <div><?= $this->session->flashdata('success'); ?></div>
        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show py-2 px-3 mb-4 d-flex align-items-center gap-2" role="alert" style="font-size: 0.85rem; border-radius: 10px;">
        <i class="bi bi-exclamation-triangle-fill fs-6"></i>
        <div><?= $this->session->flashdata('error'); ?></div>
        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form action="<?= base_url('index.php/petugas/submit_pengajuan'); ?>" method="POST">
    
    <div class="row g-4 mb-5 align-items-start">
        
        <div class="col-lg-8">
            <div class="card-custom mb-4">
                <label class="form-label fw-bold text-dark mb-2">Program Bantuan</label>
                <select name="program_id" id="selectProgram" class="form-select px-3 py-2 mb-3" required style="font-size: 0.875rem; border-radius: 10px;">
                    <option value="" disabled <?= empty($selected_program_id) ? 'selected' : ''; ?>>-- Pilih Program Bantuan --</option>
                    <?php foreach ($programs as $prog): ?>
                        <option value="<?= $prog['program_id']; ?>" 
                                data-title="<?= $prog['title']; ?>" 
                                data-area="<?= $prog['coverage_area']; ?>" 
                                data-quota="<?= $prog['quota']; ?>"
                                <?= (isset($selected_program_id) && $selected_program_id == $prog['program_id']) ? 'selected' : ''; ?>>
                            <?= $prog['title']; ?> (Kuota: <?= $prog['quota']; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                
                <div id="boxPreviewProgram" class="p-3 bg-light rounded-3 border d-flex align-items-center gap-3 d-none">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2.5 d-flex align-items-center justify-content-center">
                        <i class="bi bi-gift fs-4"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold text-uppercase extra-small" style="font-size: 0.7rem;">BANTUAN SOSIAL</span>
                        <h6 class="fw-bold text-dark mb-0" id="previewTitle">-</h6>
                        <span class="text-muted extra-small" style="font-size: 0.75rem;"><span id="previewArea">-</span> Kuota: <strong id="previewQuota">0</strong> penerima</span>
                    </div>
                </div>
            </div>

            
            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Pilih Calon Penerima</h6>
                        <span class="text-muted extra-small" style="font-size: 0.75rem;">Hanya data berstatus terverifikasi yang dapat dipilih.</span>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill" style="font-size: 0.775rem;">
                        <span id="txtJumlahTerpilih">0</span>/<span id="txtMaxKuota">0</span> dipilih
                    </span>
                </div>

                <div class="mb-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0" style="border-radius: 8px 0 0 8px;">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="inputCariWarga" class="form-control border-start-0 bg-light" placeholder="Cari nama warga atau RT/RW..." style="font-size: 0.825rem; border-radius: 0 8px 8px 0;">
                    </div>
                </div>

                <div class="d-flex flex-column gap-2" style="max-height: 380px; overflow-y: auto;">
                    <?php if (!empty($recipients)): ?>
                        <?php foreach ($recipients as $rec): ?>
                            
                            <label class="item-warga p-3 border rounded-3 d-flex align-items-center justify-content-between bg-white cursor-pointer hover-shadow" 
                                data-name="<?= strtolower($rec['full_name'] . ' rt/rw ' . $rec['rt_rw']); ?>" 
                                style="transition: all 0.2s;">
                                <div class="d-flex align-items-center gap-3">
                                    <input type="checkbox" name="recipient_ids[]" value="<?= $rec['id']; ?>" class="form-check-input check-penerima m-0" style="width: 20px; height: 20px;">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle fw-bold d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 0.8rem;">
                                        <?= strtoupper(substr($rec['full_name'], 0, 2)); ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.875rem;"><?= $rec['full_name']; ?></div>
                                        <span class="text-muted extra-small" style="font-size: 0.75rem;">RT/RW <?= $rec['rt_rw']; ?></span>
                                    </div>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-2.5 py-1 rounded-pill extra-small">
                                    Terverifikasi
                                </span>
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">Belum ada data warga terverifikasi.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4" style="align-self: flex-start; position: sticky; top: 90px;">
            <div class="card-custom">
                <span class="text-primary text-uppercase fw-bold tracking-wider d-block mb-1" style="font-size: 0.7rem;">RINGKASAN PENGAJUAN</span>
                <h5 class="fw-bold text-dark mb-4">Tinjau Pengajuan</h5>

                <div class="mb-3">
                    <span class="text-muted extra-small d-block mb-1" style="font-size: 0.75rem;">Program</span>
                    <strong class="text-dark d-block" id="summaryProgramName" style="font-size: 0.875rem;">Belum dipilih</strong>
                </div>

                <div class="mb-3">
                    <span class="text-muted extra-small d-block mb-1" style="font-size: 0.75rem;">Wilayah</span>
                    <strong class="text-dark d-block" id="summaryArea" style="font-size: 0.875rem;">-</strong>
                </div>

                <div class="mb-4 pb-3 border-bottom">
                    <span class="text-muted extra-small d-block mb-1" style="font-size: 0.75rem;">Calon Penerima</span>
                    <strong class="text-dark d-block" id="summaryRecipientCount" style="font-size: 0.875rem;">0 dari 0 kuota</strong>
                </div>

                <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary extra-small mb-4" style="font-size: 0.75rem; line-height: 1.4;">
                    <i class="bi bi-info-circle me-1"></i> Pastikan data telah benar. Pengajuan akan langsung terlihat oleh Mitra.
                </div>

                <button type="submit" id="btnSubmit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-bold shadow-sm" disabled style="font-size: 0.875rem;">
                    Kirim Pengajuan
                </button>
            </div>
        </div>
    </div>
</form>

<div class="card-custom">
    <div class="mb-3">
        <h5 class="fw-bold text-dark mb-1">Riwayat Pengajuan</h5>
        <span class="text-muted extra-small" style="font-size: 0.775rem;">Pengajuan yang telah dikirim ke Mitra</span>
    </div>

    <div class="table-responsive">
        <table id="tabelRiwayat" class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
            <thead class="table-light">
                <tr>
                    <th class="text-muted fw-semibold py-3">REFERENSI</th>
                    <th class="text-muted fw-semibold py-3">PROGRAM</th>
                    <th class="text-muted fw-semibold py-3">PENERIMA</th>
                    <th class="text-muted fw-semibold py-3">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proposals as $p): ?>
                    <tr>
                        <td>
                            <strong class="d-block text-dark"><?= $p['reference_code']; ?></strong>
                            <span class="text-muted extra-small" style="font-size: 0.725rem;"><?= date('d M Y, H:i', strtotime($p['created_at'])); ?></span>
                        </td>
                        <td class="fw-semibold text-dark"><?= $p['program_name'] ? $p['program_name'] : '-'; ?></td>
                        <td><?= $p['total_proposed']; ?> orang</td>
                        <td>
                            <?php 
                                $st = strtolower($p['status']);
                                if ($st == 'approved' || $st == 'selesai diseleksi') {
                                    echo '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-3 py-1.5 rounded-pill">Selesai Diseleksi</span>';
                                } else if ($st == 'submitted' || $st == 'diajukan') {
                                    echo '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20 px-3 py-1.5 rounded-pill">Diajukan</span>';
                                } else {
                                    echo '<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-20 px-3 py-1.5 rounded-pill">' . ucfirst($st) . '</span>';
                                }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    $(document).ready(function() {
        if ($('#tabelRiwayat').length) {
            $('#tabelRiwayat').DataTable({
                "language": {
                    "search": "Cari riwayat:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Riwayat pengajuan tidak ditemukan",
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

    const inputCariWarga = document.getElementById('inputCariWarga');
    
    if (inputCariWarga) {
        inputCariWarga.addEventListener('input', function() {
            const keyword = this.value.toLowerCase().trim();
            const itemWarga = document.querySelectorAll('.item-warga');

            itemWarga.forEach(item => {
                const dataName = item.getAttribute('data-name') || '';
                if (dataName.includes(keyword)) {
                    item.style.setProperty('display', 'flex', 'important');
                } else {
                    item.style.setProperty('display', 'none', 'important');
                }
            });
        });
    }

    const selectProgram = document.getElementById('selectProgram');
    const boxPreview = document.getElementById('boxPreviewProgram');
    const previewTitle = document.getElementById('previewTitle');
    const previewArea = document.getElementById('previewArea');
    const previewQuota = document.getElementById('previewQuota');
    
    const summaryProgramName = document.getElementById('summaryProgramName');
    const summaryArea = document.getElementById('summaryArea');
    const summaryRecipientCount = document.getElementById('summaryRecipientCount');
    const txtJumlahTerpilih = document.getElementById('txtJumlahTerpilih');
    const txtMaxKuota = document.getElementById('txtMaxKuota');
    const btnSubmit = document.getElementById('btnSubmit');

    const checkboxes = document.querySelectorAll('.check-penerima');

    let maxQuota = 0;

    if (selectProgram) {
        selectProgram.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            if (!selected.value) return;

            const title = selected.getAttribute('data-title');
            const area = selected.getAttribute('data-area') || 'Semua Wilayah';
            maxQuota = parseInt(selected.getAttribute('data-quota')) || 0;

            if(boxPreview) boxPreview.classList.remove('d-none');
            if(previewTitle) previewTitle.textContent = title;
            if(previewArea) previewArea.textContent = area;
            if(previewQuota) previewQuota.textContent = maxQuota;

            if(summaryProgramName) summaryProgramName.textContent = title;
            if(summaryArea) summaryArea.textContent = area;
            if(txtMaxKuota) txtMaxKuota.textContent = maxQuota;

            updateCount();
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            updateCount();
        });
    });

    function updateCount() {
        const checkedCount = document.querySelectorAll('.check-penerima:checked').length;
        if(txtJumlahTerpilih) txtJumlahTerpilih.textContent = checkedCount;

        if(summaryRecipientCount) summaryRecipientCount.textContent = `${checkedCount} dari ${maxQuota} kuota`;

        if (selectProgram && selectProgram.value !== "" && checkedCount > 0) {
            if(btnSubmit) btnSubmit.removeAttribute('disabled');
        } else {
            if(btnSubmit) btnSubmit.setAttribute('disabled', 'disabled');
        }
    }

    if (selectProgram && selectProgram.value !== "") {
        selectProgram.dispatchEvent(new Event('change'));
    }
});
</script>