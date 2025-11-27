<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Monitoring Aktivitas Data Center</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="<?php echo base_url(THEME_PATH) ?>favicon1.ico">

    <style>
        :root {
            --primary: #004080;
            --primary-dark: #003366;
            --primary-light: #0066cc;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
            --dark: #343a40;
            --light: #f8f9fa;
            --gray: #6c757d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            background-attachment: fixed;
            color: #e9ecef;
            min-height: 100vh;
            overflow: hidden;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .main-container {
            height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .card-header,
        .modal-header {
            background: linear-gradient(135deg, #003050 0%, #004070 20%, #004080 40%, #0050a0 60%, #0060c0 80%, #0066cc 100%);
            background-size: 400% 400%;
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: none;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .card-header::before,
        .modal-header::before {
            display: none !important;
        }

        .card-header h3 {
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0;
            z-index: 1;
        }

        .card-header .date {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .refresh-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1.5rem 0.5rem 1.2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            gap: 0.8rem;
            position: relative;
            overflow: hidden;
        }

        .refresh-btn:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .refresh-btn i {
            transition: transform 0.3s ease;
            flex-shrink: 0;
            width: 16px;
            text-align: center;
        }

        .refresh-btn:hover i {
            transform: rotate(360deg);
        }

        .card-body {
            padding: 2rem;
            flex: 1;
            overflow-y: auto;
            background: #f8f9fa;
        }

        .section-title {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            font-size: 1.5rem;
        }

        .table {
            margin-bottom: 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .table th {
            background: var(--primary);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border: none;
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .table tr {
            transition: all 0.2s ease;
        }

        .table tr:hover {
            background: #f1f3f5;
            transform: scale(1.005);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .badge {
            font-weight: 600;
            padding: 0.5em 0.8em;
            border-radius: 50px;
            font-size: 0.8rem;
        }

        /* TOMBOL AKSI */
        .btn-action {
            width: 38px;
            height: 38px;
            padding: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-action:hover {
            transform: translateY(-3px) scale(1.15);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
        }

        .btn-action:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-detail {
            background: linear-gradient(135deg, #17a2b8, #0dcaf0);
            color: white !important;
            border: none;
        }

        .btn-ajukan {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white !important;
            border: none;
        }

        .btn-reject {
            background: linear-gradient(135deg, #dc3545, #e4606d);
            color: white !important;
            border: none;
        }

        .btn-revisi {
            background: linear-gradient(135deg, #fd7e14, #e67e22);
            color: white !important;
            border: none;
        }

        .btn-pdf {
            background: linear-gradient(135deg, #6f42c1, #8b5cf6);
            color: white !important;
            border: none;
        }

        .btn-action i {
            font-size: 1rem;
        }

        /* POPUP */
        .popup-detail .modal-dialog,
        .popup-ajukan .modal-dialog,
        .popup-revisi .modal-dialog,
        .popup-detail-revisi .modal-dialog {
            max-width: 700px !important;
            margin: 1.75rem auto;
        }

        .popup-detail .modal-content,
        .popup-ajukan .modal-content,
        .popup-revisi .modal-content,
        .popup-detail-revisi .modal-content {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .popup-detail .modal-header {
            background: var(--info);
            color: white;
        }

        .popup-ajukan .modal-header {
            background: var(--success);
            color: white;
        }

        .popup-revisi .modal-header {
            background: var(--danger);
            color: white;
        }

        /* POPUP CATATAN REVISI - WARNA ORANGE SAMA DENGAN TOMBOL REVISI */
        .popup-detail-revisi .modal-header {
            background: linear-gradient(135deg, #fd7e14, #e67e22) !important;
            color: white !important;
            border-bottom: none;
        }

        /* Untuk memastikan tombol close berwarna putih */
        .popup-detail-revisi .modal-header .btn-close {
            filter: invert(1) brightness(100);
        }

        .info-box {
            background: #e8f5e8;
            border: 1px solid #c3e6c3;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #155724 !important;
        }

        .modal-body,
        .modal-body * {
            color: #000 !important;
            font-weight: 600 !important;
        }

        .modal-body .info-box {
            color: #155724 !important;
        }

        /* PAGINATION */
        .pagination .page-link {
            padding: 0.35rem 0.75rem !important;
            font-size: 0.875rem !important;
            min-width: 38px;
            text-align: center;
            border-radius: 50px !important;
            margin: 0 3px;
            border: 1.5px solid #dee2e6;
            color: #004080;
            background: white;
            transition: all 0.3s ease;
        }

        .pagination .page-item.active .page-link {
            background: #004080 !important;
            color: white !important;
            border-color: #004080 !important;
            transform: translateY(-1px);
        }

        .pagination .page-link:hover:not(.active) {
            background: #e3f2fd !important;
            color: #003366 !important;
            border-color: #0066cc !important;
        }

        .pagination {
            margin-bottom: 0;
        }

        /* TOAST STYLES */
        .custom-toast {
            animation: slideInRight 0.3s ease-out;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .custom-toast .btn-close {
            padding: 0.75rem;
        }

        @media (max-width: 768px) {
            .card-header {
                padding: 1rem;
            }

            .card-header h3 {
                font-size: 1.4rem;
            }

            .card-body {
                padding: 1rem;
            }

            .popup-detail .modal-dialog,
            .popup-ajukan .modal-dialog,
            .popup-revisi .modal-dialog,
            .popup-detail-revisi .modal-dialog {
                max-width: 95% !important;
            }
        }

        /* DETAIL ITEM CARD */
        .detail-container {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .detail-item {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .detail-label {
            background: #e8f0ff;
            color: #004080;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            margin-bottom: 0.4rem;
            display: inline-block;
            font-weight: 700;
            font-size: 0.85rem;
            width: fit-content;
        }

        .detail-value {
            background: #f9fafc;
            color: #212529;
            padding: 0.5rem 0.7rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            word-break: break-word;
        }

        /* LOADING SPINNER */
        .btn-loading {
            position: relative;
        }

        .btn-loading .spinner-border {
            width: 1rem;
            height: 1rem;
            border-width: 2px;
        }

        /* POPUP PDF */
        .popup-pdf .modal-dialog {
            max-width: 90% !important;
            margin: 1.75rem auto;
        }

        .popup-pdf .modal-content {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .popup-pdf .modal-header {
            background: linear-gradient(135deg, #6f42c1, #8b5cf6);
            color: white;
        }

        /* TOMBOL PDF MERAH */
        .btn-pdf-red {
            background: linear-gradient(135deg, #dc2626, #ef4444) !important;
            color: white !important;
            border: none;
            width: 38px;
            height: 38px;
            padding: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }

        .btn-pdf-red:hover {
            background: linear-gradient(135deg, #b91c1c, #dc2626) !important;
            transform: translateY(-3px) scale(1.15);
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.4);
        }

        .btn-pdf-red i {
            font-size: 1rem;
        }

        /* TOMBOL PREVIEW PDF */
        .btn-pdf-preview-red {
            background: linear-gradient(135deg, #ea580c, #f97316) !important;
            color: white !important;
            border: none;
            width: 38px;
            height: 38px;
            padding: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(234, 88, 12, 0.3);
        }

        .btn-pdf-preview-red:hover {
            background: linear-gradient(135deg, #c2410c, #ea580c) !important;
            transform: translateY(-3px) scale(1.15);
            box-shadow: 0 10px 20px rgba(234, 88, 12, 0.4);
        }

        /* TOMBOL DOWNLOAD PDF */
        .btn-pdf-download-red {
            background: linear-gradient(135deg, #16a34a, #22c55e) !important;
            color: white !important;
            border: none;
            width: 38px;
            height: 38px;
            padding: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
        }

        .btn-pdf-download-red:hover {
            background: linear-gradient(135deg, #15803d, #16a34a) !important;
            transform: translateY(-3px) scale(1.15);
            box-shadow: 0 10px 20px rgba(34, 197, 94, 0.4);
        }

        /* TOMBOL LOGOUT */
        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1.5rem 0.5rem 1.2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            backdrop-filter: blur(5px);
            text-decoration: none;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            gap: 0.8rem;
        }

        .logout-btn:hover {
            background: #dc3545 !important;
            border-color: #dc3545 !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        .logout-btn i {
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform-origin: center;
            margin-right: 0;
            flex-shrink: 0;
            width: 16px;
            text-align: center;
        }

        .logout-btn:hover i {
            transform: translateX(3px) scale(1.05);
            color: white !important;
        }

        .logout-btn.loading {
            position: relative;
            pointer-events: none;
            background: #dc3545 !important;
            border-color: #dc3545 !important;
            color: transparent !important;
        }

        .logout-btn.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 18px;
            height: 18px;
            margin: -9px 0 0 -9px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-right: 2px solid white;
            border-radius: 50%;
            animation: spin-smooth 0.8s linear infinite;
        }

        @keyframes spin-smooth {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @-webkit-keyframes spin-smooth {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @media (max-width: 768px) {
            .logout-btn {
                padding: 0.4rem 1.2rem 0.4rem 1rem;
                gap: 0.6rem;
                font-size: 0.9rem;
            }

            .logout-btn.loading::after {
                width: 16px;
                height: 16px;
                margin: -8px 0 0 -8px;
            }
        }

        /* Style untuk info user di header */
        .card-header .date {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 500;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .card-header .date i {
            opacity: 0.8;
        }

        .card-header .badge {
            font-size: 0.75rem;
            padding: 0.3em 0.6em;
        }

        @media (max-width: 768px) {
            .card-header .date {
                font-size: 0.9rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }

            .card-header .date i {
                min-width: 16px;
            }
        }

        /* FILTER STYLES - MODERN & ELEGANT */
        .filter-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e8f0fe;
            overflow: hidden;
        }

        .filter-header {
            background: linear-gradient(135deg, #003050 0%, #004070 20%, #004080 40%);
            color: white;
            padding: 1.2rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .filter-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .filter-body {
            padding: 1.5rem;
        }

        .filter-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .filter-btn {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 2px solid #f1f5f9;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            background: white;
            cursor: pointer;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            text-decoration: none;
        }

        .filter-btn.active {
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .filter-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.3rem;
            background: #f8fafc;
            color: #64748b;
            transition: all 0.3s ease;
        }

        .filter-btn.active .filter-icon {
            color: white;
        }

        /* WARNA UNTUK SETIAP STATUS FILTER */
        .filter-btn.active[href*="status=Menunggu Approval"] {
            background: #fff7ed;
            border-color: #f59e0b;
        }

        .filter-btn.active[href*="status=Menunggu Approval"] .filter-icon {
            background: #f59e0b;
        }

        .filter-btn.active[href*="status=Diteruskan ke Manager"] {
            background: #f0fdf4;
            border-color: #22c55e;
        }

        .filter-btn.active[href*="status=Diteruskan ke Manager"] .filter-icon {
            background: #22c55e;
        }

        .filter-btn.active[href*="status=Revisi Diperlukan"] {
            background: #fef2f2;
            border-color: #ef4444;
        }

        .filter-btn.active[href*="status=Revisi Diperlukan"] .filter-icon {
            background: #ef4444;
        }

        .filter-btn.active[href*="status=Disetujui"] {
            background: #f0f9ff;
            border-color: #0ea5e9;
        }

        .filter-btn.active[href*="status=Disetujui"] .filter-icon {
            background: #0ea5e9;
        }

        /* Filter Semua (tanpa status) */
        .filter-btn.active[href="<?= site_url('data_center/index_staff') ?>"] {
            background: #f8fafc;
            border-color: #004080;
        }

        .filter-btn.active[href="<?= site_url('data_center/index_staff') ?>"] .filter-icon {
            background: #004080;
        }

        /* Hover state untuk setiap status */
        .filter-btn[href*="status=Menunggu Approval"]:hover {
            border-color: #f59e0b;
        }

        .filter-btn[href*="status=Diteruskan ke Manager"]:hover {
            border-color: #22c55e;
        }

        .filter-btn[href*="status=Revisi Diperlukan"]:hover {
            border-color: #ef4444;
        }

        .filter-btn[href*="status=Disetujui"]:hover {
            border-color: #0ea5e9;
        }

        .filter-btn[href="<?= site_url('data_center/index_staff') ?>"]:hover {
            border-color: #004080;
        }

        /* Filter active info */
        .filter-active {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 4px solid #004080;
        }

        .active-filter-text {
            color: #004080;
            font-weight: 500;
        }

        .clear-filter {
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .clear-filter:hover {
            color: #004080;
        }

        .filter-text {
            flex: 1;
        }

        .filter-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .filter-count {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
        }

        .filter-btn.active .filter-title,
        .filter-btn.active .filter-count {
            color: #1e293b;
        }

        /* TOMBOL DOWNLOAD TXT - WARNA UNGU */
        .btn-download-txt {
            background: linear-gradient(135deg, #7c3aed, #6d28d9) !important;
            color: white !important;
            border: none;
            width: 38px;
            height: 38px;
            padding: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(124, 58, 237, 0.3);
            text-decoration: none !important;
        }

        .btn-download-txt:hover {
            background: linear-gradient(135deg, #6d28d9, #5b21b6) !important;
            transform: translateY(-3px) scale(1.15);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
            color: white !important;
            text-decoration: none !important;
        }

        .btn-download-txt i {
            font-size: 1rem;
        }
    </style>
</head>

<body>

    <div class="main-container">
        <div class="dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h3><i class="fas fa-server me-2"></i>MONITORING DATA CENTER - STAFF IT</h3>
                    <div class="date mt-1">
                        <i class="far fa-calendar-alt me-1"></i><b><?= date('d F Y'); ?></b> |
                        <i class="fas fa-user me-1 ms-2"></i><?= htmlspecialchars($this->session->userdata('dc_nama_lengkap') ?? 'User') ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="refresh-btn">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="<?= site_url('dc-auth/logout') ?>" class="btn btn-outline-light logout-btn" id="logoutBtn">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="section-title">
                    <i class="fas fa-clipboard-list"></i> DAFTAR PERMOHONAN AKSES FISIK
                </div>

                <!-- FILTER STATUS - URUTAN SESUAI WORKFLOW -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="filter-card">
                            <div class="filter-header">
                                <i class="fas fa-filter me-2"></i>Filter Status
                                <span class="filter-badge"><?= $count_all ?> total</span>
                            </div>
                            <div class="filter-body">
                                <div class="filter-buttons">
                                    <a href="<?= site_url('data_center/index_staff') ?>"
                                        class="filter-btn <?= !$status_filter ? 'active' : '' ?>">
                                        <div class="filter-icon">
                                            <i class="fas fa-th-large"></i>
                                        </div>
                                        <div class="filter-text">
                                            <div class="filter-title">Semua</div>
                                            <div class="filter-count"><?= $count_all ?></div>
                                        </div>
                                    </a>

                                    <a href="<?= site_url('data_center/index_staff?status=Menunggu Approval') ?>"
                                        class="filter-btn <?= $status_filter == 'Menunggu Approval' ? 'active' : '' ?>">
                                        <div class="filter-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="filter-text">
                                            <div class="filter-title">Menunggu</div>
                                            <div class="filter-count"><?= $count_menunggu ?></div>
                                        </div>
                                    </a>

                                    <a href="<?= site_url('data_center/index_staff?status=Diteruskan ke Manager') ?>"
                                        class="filter-btn <?= $status_filter == 'Diteruskan ke Manager' ? 'active' : '' ?>">
                                        <div class="filter-icon">
                                            <i class="fas fa-paper-plane"></i>
                                        </div>
                                        <div class="filter-text">
                                            <div class="filter-title">Diajukan</div>
                                            <div class="filter-count"><?= $count_diajukan ?></div>
                                        </div>
                                    </a>

                                    <a href="<?= site_url('data_center/index_staff?status=Disetujui') ?>"
                                        class="filter-btn <?= $status_filter == 'Disetujui' ? 'active' : '' ?>">
                                        <div class="filter-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="filter-text">
                                            <div class="filter-title">Disetujui</div>
                                            <div class="filter-count"><?= $count_disetujui ?></div>
                                        </div>
                                    </a>

                                    <a href="<?= site_url('data_center/index_staff?status=Revisi Diperlukan') ?>"
                                        class="filter-btn <?= $status_filter == 'Revisi Diperlukan' ? 'active' : '' ?>">
                                        <div class="filter-icon">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="filter-text">
                                            <div class="filter-title">Revisi</div>
                                            <div class="filter-count"><?= $count_revisi ?></div>
                                        </div>
                                    </a>
                                </div>

                                <?php if ($status_filter): ?>
                                    <div class="filter-active">
                                        <span class="active-filter-text">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Filter aktif: <strong><?= $status_filter ?></strong>
                                        </span>
                                        <a href="<?= site_url('data_center/index_staff') ?>" class="clear-filter">
                                            <i class="fas fa-times"></i> Hapus filter
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama Pemohon</th>
                                <th>Unit / Perusahaan</th>
                                <th>Proyek</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $start = ($this->uri->segment(3) && is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
                            if (!empty($permohonan)):
                                foreach ($permohonan as $i => $p):
                            ?>
                                    <tr>
                                        <td class="text-center fw-bold"><?= $start + $i + 1 ?></td>
                                        <td>
                                            <strong title="<?= htmlspecialchars($p->nama_pemohon) ?>">
                                                <?= strlen($p->nama_pemohon) > 25 ? htmlspecialchars(substr($p->nama_pemohon, 0, 25)) . '...' : htmlspecialchars($p->nama_pemohon) ?>
                                            </strong>
                                        </td>
                                        <td><?= htmlspecialchars($p->unit_kerja) ?></td>
                                        <td>
                                            <strong title="<?= htmlspecialchars($p->nama_proyek) ?>">
                                                <?= strlen($p->nama_proyek) > 25 ? htmlspecialchars(substr($p->nama_proyek, 0, 25)) . '...' : htmlspecialchars($p->nama_proyek) ?>
                                            </strong>
                                        </td>
                                        <td class="text-center">
                                            <?= date('d/m/Y', strtotime($p->tanggal_permohonan)) ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $status = $p->status;
                                            $tgl = '';
                                            if ($status == 'Diteruskan ke Manager' && $p->tanggal_ajukan) {
                                                $tgl = date('d/m/Y', strtotime($p->tanggal_ajukan));
                                                echo "<span class='badge bg-success'>Diajukan ($tgl)</span>";
                                            } elseif ($status == 'Disetujui' && $p->tgl_approve_manager) {
                                                $tgl = date('d/m/Y', strtotime($p->tgl_approve_manager));
                                                echo "<span class='badge bg-primary'>Disetujui ($tgl)</span>";
                                            } elseif ($status == 'Revisi Diperlukan' && $p->tanggal_revisi) {
                                                $tgl = date('d/m/Y', strtotime($p->tanggal_revisi));
                                                echo "<span class='badge bg-danger'>Revisi ($tgl)</span>";
                                            } else {
                                                echo "<span class='badge bg-warning text-dark'>Menunggu Diajukan</span>";
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center" id="aksi-<?= $p->id ?>">
                                            <!-- TOMBOL DETAIL - SELALU ADA DI SEMUA STATUS -->
                                            <button class="btn btn-action btn-detail" data-id="<?= $p->id ?>" title="Lihat Detail">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            <?php if ($p->status == 'Menunggu Approval'): ?>
                                                <button class="btn btn-action btn-ajukan" data-id="<?= $p->id ?>" title="Ajukan ke Manager">
                                                    <i class="fa fa-paper-plane"></i>
                                                </button>
                                                <button class="btn btn-action btn-reject" data-id="<?= $p->id ?>" title="Tolak & Revisi">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            <?php elseif ($p->status == 'Revisi Diperlukan'): ?>
                                                <button class="btn btn-action btn-revisi" data-id="<?= $p->id ?>" title="Lihat Catatan Revisi">
                                                    <i class="fa fa-comment-dots"></i>
                                                </button>
                                            <?php elseif ($p->status == 'Disetujui'): ?>
                                                <!-- TOMBOL DOWNLOAD TXT - HANYA UNTUK STATUS DISETUJUI -->
                                                <a href="<?= site_url('data_center/download_detail_txt/' . $p->id) ?>"
                                                    class="btn btn-action btn-download-txt"
                                                    title="Download Detail (TXT)">
                                                    <i class="fas fa-file-download"></i>
                                                </a>

                                                <!-- Bisa tambahkan tombol PDF jika ada -->
                                                <?php if (!empty($p->file_pdf_final)): ?>
                                                    <a href="<?= base_url('uploads/pdf_final/' . $p->file_pdf_final) ?>" target="_blank" class="btn btn-action btn-pdf" title="Unduh PDF">
                                                        <i class="fa fa-file-pdf"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php elseif ($p->status == 'Diteruskan ke Manager'): ?>
                                                <!-- Status diajukan ke manager - hanya tombol detail -->
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            else:
                                ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        <strong>TIDAK ADA PERMOHONAN SAAT INI</strong>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <div class="d-flex justify-content-center mt-4">
                    <?php if (isset($pagination_permohonan) && !empty($pagination_permohonan)): ?>
                        <nav>
                            <ul class="pagination mb-0">
                                <?= $pagination_permohonan ?>
                            </ul>
                        </nav>
                    <?php else: ?>
                        <!-- Tampilkan info jika tidak ada pagination -->
                        <nav>
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                    <span class="page-link">1</span>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- POPUP DETAIL -->
    <div id="modalDetail" class="modal fade popup-detail" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-file-alt me-2"></i>Detail Permohonan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="detail-container">
                        <div class="detail-item">
                            <div class="detail-label">Nama</div>
                            <div class="detail-value" id="detail-nama">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">NIP/ID</div>
                            <div class="detail-value" id="detail-id">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Jabatan</div>
                            <div class="detail-value" id="detail-jabatan">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Unit</div>
                            <div class="detail-value" id="detail-unit">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Telepon</div>
                            <div class="detail-value" id="detail-telepon">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Fax</div>
                            <div class="detail-value" id="detail-fax">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status Pegawai</div>
                            <div class="detail-value" id="detail-statuspegawai">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Perusahaan</div>
                            <div class="detail-value" id="detail-perusahaan">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Alamat</div>
                            <div class="detail-value" id="detail-alamat">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Email</div>
                            <div class="detail-value" id="detail-email">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Contact Person</div>
                            <div class="detail-value" id="detail-contact">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Proyek</div>
                            <div class="detail-value" id="detail-proyek">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Waktu</div>
                            <div class="detail-value" id="detail-waktu">-</div>
                        </div>

                        <!-- DOKUMEN - URUTAN SESUAI FORM -->
                        <div class="detail-item" id="detail-ktp"></div>
                        <div class="detail-item" id="detail-dokumen"></div>
                        <div class="detail-item" id="detail-ttd-pemohon"></div>
                        <div class="detail-item" id="detail-ttd-staff"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- POPUP AJUKAN - PERBAIKAN: TAMBAHKAN FIELD YANG MISSING -->
    <div id="modalAjukan" class="modal fade popup-ajukan" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-clipboard-check me-2"></i>Review & Ajukan ke Manager</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama:</strong> <span id="modal-nama"></span></p>
                    <p><strong>Unit:</strong> <span id="modal-unit"></span></p>
                    <p><strong>Proyek:</strong> <span id="modal-proyek"></span></p>
                    <p><strong>Tanggal:</strong> <span id="modal-tanggal"></span></p>
                    <div class="info-box">
                        <i class="fas fa-info-circle"></i> Lengkapi data untuk mengajukan ke manager.
                    </div>

                    <!-- FIELD YANG HARUS ADA -->
                    <div class="mb-3 mt-3">
                        <label class="form-label fw-bold"><i class="fas fa-user me-1"></i>Nama Staff TI *</label>
                        <input type="text" class="form-control" id="namaStaff" placeholder="Masukkan nama lengkap">
                    </div>

                    <!-- TAMBAHKAN FIELD INI YANG MISSING -->
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-calendar me-1"></i>Tanggal Berlaku *</label>
                        <input type="date" class="form-control" id="tanggalBerlaku" min="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-clock me-1"></i>Jam Mulai *</label>
                            <input type="time" class="form-control" id="jamMulai">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-clock me-1"></i>Jam Selesai *</label>
                            <input type="time" class="form-control" id="jamSelesai">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-hourglass me-1"></i>Durasi Akses (Otomatis)</label>
                        <input type="text" class="form-control" id="durasiAkses" placeholder="Akan terisi otomatis" readonly>
                        <small class="text-muted">Durasi akan terhitung otomatis berdasarkan jam mulai dan selesai</small>
                    </div>
                    <!-- END TAMBAHAN FIELD -->

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-signature me-1"></i>Tanda Tangan *</label>
                        <input type="file" class="form-control" id="fileTandaTangan"
                            accept=".png,.jpg,.jpeg,.pdf,.p7s,.p7m,.sig,.asc,.gpg,.xades,.cades,.pades">
                        <small class="text-muted">Format: PNG, JPG, PDF, P7S, P7M, SIG, ASC, GPG, XAdES, CAdES, PAdES (Maks. 2MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="confirm-ajukan"><i class="fas fa-check me-1"></i>Submit & Ajukan</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- POPUP REVISI -->
    <div id="modalRevisi" class="modal fade popup-revisi" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Tolak dan Beri Catatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <textarea id="catatanRevisi" class="form-control" rows="5" placeholder="Tuliskan alasan revisi..."></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" id="submitRevisi"><i class="fas fa-paper-plane me-1"></i>Kirim Revisi</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- POPUP CATATAN REVISI -->
    <div id="modalDetailRevisi" class="modal fade popup-detail-revisi" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-history me-2"></i>Catatan Revisi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="revisi-content">
                    <p class="text-center text-primary"><i class="fa fa-spinner fa-spin"></i> Memuat...</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- POPUP PREVIEW PDF -->
    <div id="modalPdfPreview" class="modal fade popup-pdf" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #dc2626, #ef4444); color: white;">
                    <h5 class="modal-title"><i class="fas fa-file-pdf me-2"></i>Preview PDF Izin Akses Data Center</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center" id="pdf-preview-container">
                        <p class="text-muted"><i class="fas fa-spinner fa-spin"></i> Memuat PDF...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="download-pdf-btn" class="btn btn-success">
                        <i class="fas fa-download me-1"></i>Download PDF
                    </button>
                    <button id="print-pdf-btn" class="btn btn-primary">
                        <i class="fas fa-print me-1"></i>Print PDF
                    </button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const BASE_URL = '<?= site_url() ?>';
        let selectedId = null;

        // ✅ FUNGSI UNTUK HITUNG DURASI OTOMATIS
        function hitungDurasiOtomatis() {
            const jamMulai = document.getElementById('jamMulai').value;
            const jamSelesai = document.getElementById('jamSelesai').value;
            const durasiAkses = document.getElementById('durasiAkses');

            if (!jamMulai || !jamSelesai) {
                if (durasiAkses) durasiAkses.value = '';
                return;
            }

            // Konversi ke menit
            const [mulaiJam, mulaiMenit] = jamMulai.split(':').map(Number);
            const [selesaiJam, selesaiMenit] = jamSelesai.split(':').map(Number);

            const totalMulai = mulaiJam * 60 + mulaiMenit;
            const totalSelesai = selesaiJam * 60 + selesaiMenit;

            // Hitung selisih dalam menit
            let selisihMenit = totalSelesai - totalMulai;

            if (selisihMenit < 0) {
                durasiAkses.value = 'Jam tidak valid';
                return;
            }

            // Konversi ke format jam:menit
            const jam = Math.floor(selisihMenit / 60);
            const menit = selisihMenit % 60;

            let durasiText = '';
            if (jam > 0) {
                durasiText += `${jam} jam`;
            }
            if (menit > 0) {
                if (durasiText) durasiText += ' ';
                durasiText += `${menit} menit`;
            }

            if (!durasiText) {
                durasiText = '0 menit';
            }

            if (durasiAkses) durasiAkses.value = durasiText;
        }

        // ✅ FUNGSI showToast
        function showToast(message, type = 'success') {
            const existingToasts = document.querySelectorAll('.custom-toast');
            existingToasts.forEach(toast => toast.remove());

            const toast = document.createElement('div');
            toast.className = `custom-toast alert alert-${type === 'success' ? 'success' : 'danger'}`;
            toast.innerHTML = `
            <strong>${type === 'success' ? '✓ Sukses!' : '✗ Gagal!'}</strong> ${message}
            <button type="button" class="btn-close ms-2" onclick="this.parentElement.remove()"></button>
        `;

            document.body.appendChild(toast);

            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 3000);
        }

        // ✅ FUNGSI UNTUK LOADING BUTTON
        function setButtonLoading(button, isLoading) {
            if (isLoading) {
                const originalHTML = button.innerHTML;
                button.setAttribute('data-original-html', originalHTML);
                button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                button.disabled = true;
                button.classList.add('btn-loading');
            } else {
                const originalHTML = button.getAttribute('data-original-html');
                if (originalHTML) {
                    button.innerHTML = originalHTML;
                }
                button.disabled = false;
                button.classList.remove('btn-loading');
            }
        }

        // ==================== VALIDASI FILE TANDA TANGAN STAFF ====================
        function validateStaffSignature(file) {
            if (!file) return false;

            // Daftar format yang diizinkan - SAMA DENGAN FOR
            const allowedTypes = [
                'image/jpeg', 'image/jpg', 'image/png', 'application/pdf',
                'application/pkcs7-signature', 'application/pkcs7-mime',
                'application/pgp-signature', 'application/pgp-keys',
                'application/x-pkcs7-signature', 'application/x-pkcs7-mime'
            ];

            const allowedExtensions = ['.p7s', '.p7m', '.sig', '.asc', '.gpg', '.xades', '.cades', '.pades'];
            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();

            // Validasi tipe MIME dan extension
            if (!allowedTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
                return false;
            }

            // Validasi ukuran file (max 2MB)
            const maxSize = 2 * 1024 * 1024;
            if (file.size > maxSize) {
                return false;
            }

            return true;
        }

        // Refresh
        document.querySelector('.refresh-btn').addEventListener('click', function() {
            const icon = document.querySelector('.refresh-btn i');
            icon.style.transform = 'rotate(360deg)';
            setTimeout(() => location.reload(), 500);
        });

        // ==================== DETAIL ====================
        document.addEventListener('click', function(e) {
            // DETAIL
            if (e.target.closest('.btn-detail')) {
                const btn = e.target.closest('.btn-detail');
                const id = btn.getAttribute('data-id');

                if (!id) {
                    showToast('ID tidak valid', 'error');
                    return;
                }

                setButtonLoading(btn, true);

                // Di dalam fetch detail, ganti bagian pengisian data:
                fetch(`${BASE_URL}data_center/get_detail/${id}`)
                    .then(r => r.json())
                    .then(d => {
                        if (!d) {
                            showToast('Data tidak ditemukan', 'error');
                            return;
                        }

                        // Isi data - setiap field dalam baris terpisah
                        const elements = {
                            'detail-nama': d.nama_pemohon,
                            'detail-id': d.id_karyawan,
                            'detail-jabatan': d.jabatan,
                            'detail-unit': d.unit_kerja,
                            'detail-telepon': d.telepon,
                            'detail-fax': d.fax,
                            'detail-statuspegawai': d.status_pegawai,
                            'detail-perusahaan': d.nama_perusahaan,
                            'detail-alamat': d.alamat,
                            'detail-email': d.email,
                            'detail-contact': d.contact_person,
                            'detail-proyek': d.nama_proyek,
                            'detail-waktu': d.waktu_proyek
                        };

                        for (const [elementId, value] of Object.entries(elements)) {
                            const el = document.getElementById(elementId);
                            if (el) el.textContent = value || '-';
                        }

                        // TTD Pemohon
                        const ttdPemohonDiv = document.getElementById('detail-ttd-pemohon');
                        if (d.file_ttd_pemohon) {
                            ttdPemohonDiv.innerHTML = `
        <div class="detail-label">TTD Pemohon</div>
        <div class="detail-value">
            <a href="${BASE_URL}preview/file/ttd_pemohon/${d.file_ttd_pemohon}" target="_blank" class="text-primary">
                <i class="fas fa-external-link-alt"></i> Preview TTD
            </a>
        </div>`;
                        } else {
                            ttdPemohonDiv.innerHTML = '<div class="detail-label">TTD Pemohon</div><div class="detail-value">-</div>';
                        }

                        // TTD Staff
                        const ttdStaffDiv = document.getElementById('detail-ttd-staff');
                        if (d.file_ttd_staff) {
                            ttdStaffDiv.innerHTML = `
        <div class="detail-label">TTD Staff IT</div>
        <div class="detail-value">
            <a href="${BASE_URL}preview/file/tanda_tangan/${d.file_ttd_staff}" target="_blank" class="text-primary">
                <i class="fas fa-external-link-alt"></i> Preview TTD
            </a>
        </div>`;
                        } else {
                            ttdStaffDiv.innerHTML = '<div class="detail-label">TTD Staff IT</div><div class="detail-value">-</div>';
                        }

                        // KTP
                        const ktpDiv = document.getElementById('detail-ktp');
                        if (d.ktp_path) {
                            ktpDiv.innerHTML = `
        <div class="detail-label">KTP</div>
        <div class="detail-value">
            <a href="${BASE_URL}preview/file/ktp/${d.ktp_path}" target="_blank" class="text-primary">
                <i class="fas fa-external-link-alt"></i> Preview KTP
            </a>
        </div>`;
                        } else {
                            ktpDiv.innerHTML = '<div class="detail-label">KTP</div><div class="detail-value">-</div>';
                        }

                        // Dokumen Tambahan
                        const dokumenDiv = document.getElementById('detail-dokumen');
                        if (d.dokumen_tambahan && d.dokumen_tambahan.length > 0) {
                            let dokumenHTML = '<div class="detail-label">Dokumen Tambahan</div>';
                            d.dokumen_tambahan.forEach(dok => {
                                dokumenHTML += `
            <div class="detail-value mb-2">
                <strong>${dok.nama}</strong><br>
                <small class="text-muted">${dok.original_name}</small><br>
                <a href="${BASE_URL}preview/file/dokumen_tambahan/${dok.file_path}" target="_blank" class="text-primary small">
                    <i class="fas fa-external-link-alt"></i> Preview Dokumen
                </a>
            </div>`;
                            });
                            dokumenDiv.innerHTML = dokumenHTML;
                        } else {
                            dokumenDiv.innerHTML = '<div class="detail-label">Dokumen Tambahan</div><div class="detail-value">-</div>';
                        }

                        new bootstrap.Modal('#modalDetail').show();
                    })
                    .catch(err => {
                        console.error('Detail error:', err);
                        showToast('Gagal memuat detail', 'error');
                    })
                    .finally(() => {
                        setButtonLoading(btn, false);
                    });
            }

            // AJUKAN - FIXED VERSION
            if (e.target.closest('.btn-ajukan')) {
                const btn = e.target.closest('.btn-ajukan');
                selectedId = btn.getAttribute('data-id');

                console.log('Tombol ajukan diklik, ID:', selectedId);

                // Dapat data dari row table
                const row = btn.closest('tr');
                const cells = row.querySelectorAll('td');

                // Isi data ke modal
                const modalNama = document.getElementById('modal-nama');
                const modalUnit = document.getElementById('modal-unit');
                const modalProyek = document.getElementById('modal-proyek');
                const modalTanggal = document.getElementById('modal-tanggal');

                if (modalNama) modalNama.textContent = cells[1].querySelector('strong')?.textContent || '-';
                if (modalUnit) modalUnit.textContent = cells[2].textContent || '-';
                if (modalProyek) modalProyek.textContent = cells[3].textContent || '-';
                if (modalTanggal) modalTanggal.textContent = cells[4].textContent || '-';

                // Reset form values
                document.getElementById('namaStaff').value = '';
                document.getElementById('fileTandaTangan').value = '';
                document.getElementById('tanggalBerlaku').value = '';
                document.getElementById('jamMulai').value = '';
                document.getElementById('jamSelesai').value = '';
                document.getElementById('durasiAkses').value = '';

                // Show modal
                const modal = new bootstrap.Modal('#modalAjukan');
                modal.show();
            }

            // REJECT/REVISI
            if (e.target.closest('.btn-reject')) {
                const btn = e.target.closest('.btn-reject');
                selectedId = btn.getAttribute('data-id');
                document.getElementById('catatanRevisi').value = '';
                new bootstrap.Modal('#modalRevisi').show();
            }

            // LIHAT REVISI
            if (e.target.closest('.btn-revisi')) {
                const btn = e.target.closest('.btn-revisi');
                const revisiId = btn.getAttribute('data-id');
                const content = document.getElementById('revisi-content');

                content.innerHTML = '<p class="text-center text-primary"><i class="fa fa-spinner fa-spin"></i> Memuat...</p>';
                setButtonLoading(btn, true);

                fetch(BASE_URL + 'data_center/get_revisi/' + revisiId)
                    .then(r => r.json())
                    .then(data => {
                        let html = '';
                        if (data && data.length > 0) {
                            data.forEach(r => {
                                const tgl = r.tanggal_revisi ?
                                    new Date(r.tanggal_revisi).toLocaleDateString('id-ID', {
                                        day: '2-digit',
                                        month: 'long',
                                        year: 'numeric'
                                    }) :
                                    'Tanggal tidak tersedia';
                                const catatan = r.catatan ? r.catatan.trim() || '<em>(Tidak ada keterangan)</em>' : '<em>(Tidak ada keterangan)</em>';

                                html += `
                                <div class="item-card mb-3">
                                    <div class="label"><i class="far fa-calendar-alt me-1"></i>${tgl}</div>
                                    <div class="value">${catatan.replace(/\n/g, '<br>')}</div>
                                </div>`;
                            });
                        } else {
                            html = '<div class="text-center py-4 text-muted"><i class="fas fa-comment-slash fa-2x mb-3 d-block"></i>Belum ada catatan revisi.</div>';
                        }
                        content.innerHTML = html;
                        new bootstrap.Modal('#modalDetailRevisi').show();
                    })
                    .catch(() => {
                        content.innerHTML = '<p class="text-danger text-center">Gagal memuat data.</p>';
                        new bootstrap.Modal('#modalDetailRevisi').show();
                    })
                    .finally(() => {
                        setButtonLoading(btn, false);
                    });
            }
        });

        // ==================== EVENT LISTENER UNTUK HITUNG DURASI OTOMATIS ====================
        document.addEventListener('DOMContentLoaded', function() {
            // Tambahkan event listener untuk jam mulai dan jam selesai
            const jamMulai = document.getElementById('jamMulai');
            const jamSelesai = document.getElementById('jamSelesai');

            if (jamMulai) {
                jamMulai.addEventListener('change', hitungDurasiOtomatis);
            }

            if (jamSelesai) {
                jamSelesai.addEventListener('change', hitungDurasiOtomatis);
            }

            // Juga hitung saat modal dibuka (jika ada nilai default)
            document.getElementById('modalAjukan').addEventListener('shown.bs.modal', function() {
                // Tunggu sebentar agar form ter-render
                setTimeout(hitungDurasiOtomatis, 100);
            });
        });

        // ==================== PREVIEW PDF ====================
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-pdf-preview')) {
                const btn = e.target.closest('.btn-pdf-preview');
                const pdfFile = btn.getAttribute('data-pdf');
                const pdfUrl = BASE_URL + 'uploads/pdf_final/' + pdfFile;

                // Set download button
                document.getElementById('download-pdf-btn').onclick = function() {
                    window.open(pdfUrl, '_blank');
                };

                // Show PDF in iframe
                const container = document.getElementById('pdf-preview-container');
                container.innerHTML = `
            <iframe 
                src="${pdfUrl}" 
                width="100%" 
                height="600" 
                style="border: none; border-radius: 8px;"
                title="PDF Preview"
            ></iframe>
            <p class="mt-2 text-muted">
                <small>Jika PDF tidak tampil, 
                    <a href="${pdfUrl}" target="_blank">klik di sini untuk membuka di tab baru</a>
                </small>
            </p>
        `;

                new bootstrap.Modal('#modalPdfPreview').show();
            }
        });

        // ==================== SUBMIT AJUKAN ====================
        document.getElementById('confirm-ajukan').addEventListener('click', function() {
            const nama = document.getElementById('namaStaff').value.trim();
            const tanggalBerlaku = document.getElementById('tanggalBerlaku').value;
            const jamMulai = document.getElementById('jamMulai').value;
            const jamSelesai = document.getElementById('jamSelesai').value;
            const durasiAkses = document.getElementById('durasiAkses').value;
            const file = document.getElementById('fileTandaTangan').files[0];

            // Validasi field
            if (!nama || !file || !tanggalBerlaku || !jamMulai || !jamSelesai) {
                showToast('Lengkapi semua field yang wajib!', 'error');
                return;
            }

            // VALIDASI FILE TANDA TANGAN - SAMA DENGAN FORM
            if (!validateStaffSignature(file)) {
                showToast(
                    'Format file tanda tangan tidak didukung. Gunakan JPG, PNG, PDF, atau format tanda tangan digital (P7S, P7M, SIG, ASC, GPG, XAdES, CAdES, PAdES). Maksimal 2MB.',
                    'error'
                );
                return;
            }

            // Validasi tanggal
            const today = new Date().toISOString().split('T')[0];
            if (tanggalBerlaku < today) {
                showToast('Tanggal berlaku tidak boleh kurang dari hari ini!', 'error');
                return;
            }

            // Validasi jam
            if (jamSelesai <= jamMulai) {
                showToast('Jam selesai harus setelah jam mulai!', 'error');
                return;
            }

            // Validasi durasi akses (harus terisi otomatis)
            if (!durasiAkses) {
                showToast('Durasi akses belum terhitung. Pastikan jam mulai dan selesai sudah diisi!', 'error');
                return;
            }

            const fd = new FormData();
            fd.append('id', selectedId);
            fd.append('nama_staff', nama);
            fd.append('tanggal_berlaku', tanggalBerlaku);
            fd.append('jam_mulai', jamMulai);
            fd.append('jam_selesai', jamSelesai);
            fd.append('durasi_akses', durasiAkses);
            fd.append('tanda_tangan', file);

            // Tampilkan loading
            const btn = document.getElementById('confirm-ajukan');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Mengirim...';
            btn.disabled = true;

            console.log('Mengirim data ke server...');

            fetch(BASE_URL + 'data_center/ajukan', {
                    method: 'POST',
                    body: fd
                })
                .then(r => {
                    if (!r.ok) throw new Error(`HTTP error! status: ${r.status}`);
                    return r.json();
                })
                .then(res => {
                    console.log('Response dari server:', res);
                    if (res.status === 'success') {
                        // Update UI tanpa refresh
                        const row = document.querySelector(`tr td[id="aksi-${selectedId}"]`).parentElement;
                        if (row) {
                            const statusCell = row.cells[5];
                            const aksiCell = row.cells[6];

                            statusCell.innerHTML = `<span class="badge bg-success">Diajukan (${res.tgl_ajukan})</span>`;

                            aksiCell.innerHTML = `
                        <button class="btn btn-action btn-detail" data-id="${selectedId}" title="Lihat Detail">
                            <i class="fa fa-eye"></i>
                        </button>
                    `;
                        }

                        const modal = bootstrap.Modal.getInstance('#modalAjukan');
                        modal.hide();
                        showToast(res.message || 'Berhasil diajukan ke Manager!', 'success');

                    } else {
                        showToast(res.message || 'Terjadi kesalahan', 'error');
                    }
                })
                .catch(err => {
                    console.error('Ajukan error:', err);
                    showToast('Koneksi gagal: ' + err.message, 'error');
                })
                .finally(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
        });

        // ==================== SUBMIT REVISI ====================
        document.getElementById('submitRevisi').addEventListener('click', function() {
            const catatan = document.getElementById('catatanRevisi').value.trim();
            if (!catatan) {
                showToast('Isi alasan revisi!', 'error');
                return;
            }

            const btn = document.getElementById('submitRevisi');
            setButtonLoading(btn, true);

            const fd = new FormData();
            fd.append('id', selectedId);
            fd.append('catatan', catatan);
            fd.append('oleh', 'Staff IT');

            fetch(BASE_URL + 'data_center/revisi', {
                    method: 'POST',
                    body: fd
                })
                .then(r => {
                    if (!r.ok) throw new Error(`HTTP ${r.status}`);
                    return r.json();
                })
                .then(res => {
                    if (res.status === 'success') {
                        const row = document.querySelector(`tr td[id="aksi-${selectedId}"]`).parentElement;
                        if (row) {
                            const statusCell = row.cells[5];
                            const aksiCell = row.cells[6];

                            const tglRevisi = new Date(res.tgl_revisi).toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });
                            statusCell.innerHTML = `<span class="badge bg-danger">Revisi (${tglRevisi})</span>`;

                            aksiCell.innerHTML = `
                        <button class="btn btn-action btn-detail" data-id="${selectedId}" title="Lihat Detail">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-action btn-revisi" data-id="${selectedId}" title="Lihat Catatan Revisi">
                            <i class="fa fa-comment-dots"></i>
                        </button>
                    `;
                        }

                        const modal = bootstrap.Modal.getInstance('#modalRevisi');
                        modal.hide();
                        showToast('Revisi berhasil dikirim!', 'success');
                    } else {
                        showToast('Gagal: ' + (res.message || 'Data tidak valid'), 'error');
                    }
                })
                .catch(err => {
                    console.error('Revisi error:', err);
                    showToast('Koneksi gagal: ' + err.message, 'error');
                })
                .finally(() => {
                    setButtonLoading(btn, false);
                });
        });

        // Debug info
        console.log('JavaScript loaded successfully');
        console.log('BASE_URL:', BASE_URL);

        // LOGOUT CONFIRMATION DENGAN SPINNER SMOOTH
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault();

            const logoutUrl = this.href;
            const button = this;

            // Sweet confirmation
            if (confirm('Apakah Anda yakin ingin logout?')) {
                // Show loading state dengan spinner smooth
                button.classList.add('loading');
                button.style.pointerEvents = 'none';

                // Simpan teks asli untuk backup
                const originalText = button.innerHTML;
                button.setAttribute('data-original-text', originalText);

                // Sembunyikan teks dan icon, tampilkan spinner via CSS
                const icon = button.querySelector('i');
                const text = button.querySelector('.logout-text');

                if (icon) icon.style.opacity = '0';
                if (text) text.style.opacity = '0';

                console.log('Logging out...');

                // Redirect setelah delay singkat untuk menunjukkan spinner
                setTimeout(() => {
                    window.location.href = logoutUrl;
                }, 1500);

                // Fallback - jika redirect gagal, reset button setelah 5 detik
                setTimeout(() => {
                    if (document.body.contains(button)) {
                        resetLogoutButton(button);
                        showToast('Logout timeout, silakan coba lagi', 'error');
                    }
                }, 5000);
            }
        });

        // Fungsi untuk reset tombol logout
        function resetLogoutButton(button) {
            button.classList.remove('loading');
            button.style.pointerEvents = 'auto';

            const originalText = button.getAttribute('data-original-text');
            if (originalText) {
                button.innerHTML = originalText;
            }

            // Reset opacity
            const icon = button.querySelector('i');
            const text = button.querySelector('.logout-text');
            if (icon) icon.style.opacity = '1';
            if (text) text.style.opacity = '1';
        }

        // Refresh button enhancement
        document.querySelector('.refresh-btn').addEventListener('click', function() {
            const icon = this.querySelector('i');
            icon.style.transform = 'rotate(360deg)';
            this.disabled = true;

            setTimeout(() => {
                location.reload();
            }, 500);
        });
    </script>
    <style>
        .watermark {
            position: fixed;
            bottom: 20px;
            right: 20px;
            opacity: 0.25;
            z-index: 9999;
            pointer-events: none;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #004080;
            text-align: right;
            line-height: 1.4;
        }

        .watermark-main {
            font-weight: 700;
            font-size: 13px;
        }

        .watermark-sub {
            font-weight: 500;
            opacity: 0.8;
        }
    </style>

    <div class="watermark">
        <div class="watermark-main">Made With Anger 🤬 - DIV TI</div>
        <div class="watermark-sub" id="watermarkTimestamp"></div>
    </div>
</body>

</html>