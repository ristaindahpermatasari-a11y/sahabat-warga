<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            color: #212529;
            font-family: Arial, sans-serif;
            font-size: 12.5px;
        }
        .kop-surat {
            border-bottom: 3px double #212529;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        /* Header tabel tegas dan senada */
        .table-custom-header {
            background-color: #343a40 !important;
            color: #ffffff !important;
            text-align: center;
            font-size: 0.8rem;
        }
        table th, table td {
            vertical-align: middle;
            font-size: 0.8rem;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container my-4" style="max-width: 900px;">
        <!-- Tombol Aksi di Layar (Hilang Saat Diprint) -->
        <div class="text-end mb-4 no-print">
            <button onclick="window.print()" class="btn btn-primary btn-sm fw-bold">Cetak / Simpan PDF</button>
            <a href="<?= base_url('index.php/mitra/laporan'); ?>" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        <div class="kop-surat text-center">
            <h4 class="fw-bold text-uppercase mb-1" style="letter-spacing: 0.5px;">YAYASAN PEDULI KELURAHAN - SAHABATWARGA</h4>
            <p class="mb-1 text-muted small">Jl. Raya Warga No. 45, Kelurahan Sejahtera, Kota Bekasi</p>
            <p class="mb-0 text-muted" style="font-size: 0.75rem;">Laporan Resmi Rekapitulasi Program dan Penyaluran Bantuan Sosial</p>
        </div>

        <div class="row mb-3" style="font-size: 0.85rem;">
            <div class="col-7">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td style="width: 110px;">Perihal</td><td>: <strong>Laporan Penyaluran Bantuan</strong></td></tr>
                    <tr><td>Diterbitkan oleh</td><td>: <?= $user_name; ?> (Mitra Bantuan)</td></tr>
                </table>
            </div>
            <div class="col-5 text-end">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-end">Bekasi, <?= date('d F Y'); ?></td></tr>
                </table>
            </div>
        </div>

        <?php
            $jml_diterima = 0;
            $jml_ditolak = 0;
            if (!empty($detail_laporan)) {
                foreach ($detail_laporan as $row_chk) {
                    $st = isset($row_chk['selection_status']) ? strtolower($row_chk['selection_status']) : '';
                    if ($st == 'accepted' || $st == 'diterima') {
                        $jml_diterima++;
                    } else if ($st == 'rejected' || $st == 'ditolak') {
                        $jml_ditolak++;
                    }
                }
            }
            $jml_total = count($detail_laporan);
        ?>

        <div class="row g-2 mb-3 text-center" style="font-size: 0.8rem;">
            <div class="col-4">
                <div class="p-2 bg-light border rounded">
                    <span class="text-muted d-block" style="font-size: 0.7rem;">TOTAL DATA</span>
                    <strong class="text-dark fs-6"><?= $jml_total; ?> Warga</strong>
                </div>
            </div>
            <div class="col-4">
                <div class="p-2 bg-success bg-opacity-10 border border-success border-opacity-25 rounded">
                    <span class="text-success d-block fw-bold" style="font-size: 0.7rem;">TOTAL DITERIMA</span>
                    <strong class="text-success fs-6"><?= $jml_diterima; ?> Orang</strong>
                </div>
            </div>
            <div class="col-4">
                <div class="p-2 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded">
                    <span class="text-danger d-block fw-bold" style="font-size: 0.7rem;">TOTAL DITOLAK</span>
                    <strong class="text-danger fs-6"><?= $jml_ditolak; ?> Orang</strong>
                </div>
            </div>
        </div>

        <!-- Tabel Rincian Data Penerima -->
        <h6 class="fw-bold mb-2" style="font-size: 0.9rem;">Rincian Data Penerima & Keputusan Seleksi</h6>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr class="table-custom-header">
                        <th style="width: 40px;" class="py-2">No</th>
                        <th class="py-2">Ref Proposal</th>
                        <th class="py-2">Nama Program</th>
                        <th class="py-2">Nama Warga</th>
                        <th class="py-2">RT/RW</th>
                        <th class="py-2">Keterangan Ekonomi</th>
                        <th class="py-2">Keputusan</th>
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
                                <td class="text-center fw-bold <?= ($row['selection_status'] == 'accepted') ? 'text-success' : 'text-danger'; ?>">
                                    <?= ($row['selection_status'] == 'accepted') ? 'DITERIMA' : 'DITOLAK'; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-3 text-muted">Tidak ada data rincian yang sesuai dengan filter.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="row mt-5" style="font-size: 0.85rem;">
            <div class="col-4 offset-8 text-center">
                <p class="mb-1">Mengetahui,</p>
                <p class="fw-bold mb-5">Penanggung Jawab / Mitra Bantuan,</p>
                <br><br>
                <p class="fw-bold text-decoration-underline mb-0"><?= $user_name; ?></p>
                <span class="text-muted" style="font-size: 0.75rem;">Mitra Pelaksana SahabatWarga</span>
            </div>
        </div>
    </div>

</body>
</html>