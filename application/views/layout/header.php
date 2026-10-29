<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - SahabatWarga' : 'SahabatWarga'; ?></title>
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            overflow-x: hidden;
        }

        /* Sidebar Styling & Mobile Responsive */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            transition: all 0.3s ease-in-out;
        }

        .main-content {
            margin-left: 260px;
            padding: 2rem 2.5rem;
            min-height: 100vh;
            flex: 1 1 0%;
            min-width: 0;
            transition: all 0.3s ease-in-out;
        }

        /* Media Query untuk Layar Kecil / Mobile */
        @media (max-width: 992px) {
            .sidebar {
                left: -260px; /* Sembunyikan sidebar ke kiri */
            }
            .sidebar.show {
                left: 0; /* Munculkan saat kelas show aktif */
            }
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 1.5rem 1rem;
            }
            #sidebarToggle {
                display: inline-block !important;
            }
        }

        #sidebarToggle {
            display: none;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1rem;
            color: #64748b;
            font-weight: 500;
            font-size: 0.875rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 4px;
        }

        .nav-link-custom:hover {
            background-color: #f1f5f9;
            color: #1d61e8;
        }

        .nav-link-custom.active {
            background-color: #1d61e8;
            color: #ffffff;
        }

        .card-custom {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #ffffff;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            height: 100%;
        }

        .stat-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="d-flex w-100">