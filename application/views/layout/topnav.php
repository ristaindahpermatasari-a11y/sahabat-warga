<?php
$CI =& get_instance();
$current_uri = uri_string();
$role = (strpos($current_uri, 'petugas') !== false) ? 'petugas' : 'mitra';

$notifs = $CI->db->get_where('notifications', ['user_type' => $role, 'is_read' => 0])->result_array();
$unread_count = count($notifs);
$role_label = ($role == 'petugas') ? 'Petugas Kelurahan' : 'Mitra Bantuan';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="text-muted small d-flex align-items-center gap-2">
        <button class="btn btn-light border btn-sm p-1 d-flex align-items-center justify-content-center" id="sidebarToggle" style="width: 34px; height: 34px; border-radius: 8px;">
            <i class="bi bi-list fs-5 text-secondary"></i>
        </button>
        
        <div>
            <?= $role_label; ?> <i class="bi bi-chevron-right extra-small mx-1"></i> <strong class="text-dark"><?= isset($title) ? $title : 'Dashboard'; ?></strong>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <div class="dropdown">
            <a href="#" class="btn btn-light rounded-circle border p-0 d-flex align-items-center justify-content-center position-relative text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false" style="width: 38px; height: 38px;">
                <i class="bi bi-bell text-secondary"></i>
                <?php if ($unread_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.5rem;">
                        <?= $unread_count; ?>
                    </span>
                <?php endif; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-2 mt-2" style="width: 300px; border-radius: 12px; font-size: 0.8rem;">
                <li class="dropdown-header fw-bold text-dark px-2 py-1">Notifikasi Terbaru</li>
                <li><hr class="dropdown-divider my-1"></li>
                
                <?php if (!empty($notifs)): ?>
                    <?php foreach ($notifs as $n): ?>
                        <li>
                            <a class="dropdown-item py-2 px-2 rounded-2 text-wrap border-bottom mb-1" href="<?= base_url('index.php/' . $role . '/baca_notif/' . $n['id']); ?>">
                                <strong class="d-block text-dark"><?= $n['title']; ?></strong>
                                <span class="text-muted" style="font-size: 0.75rem;"><?= $n['message']; ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><span class="dropdown-item text-center text-muted py-3">Tidak ada notifikasi baru</span></li>
                <?php endif; ?>
            </ul>
        </div>

        <a href="<?= base_url('index.php/auth/logout'); ?>" class="btn btn-outline-danger btn-sm rounded-3 px-3 fw-medium" style="font-size: 0.8rem;">
            <i class="bi bi-box-arrow-right me-1"></i> Keluar
        </a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar');

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('show');
            });
        }
    });
</script>