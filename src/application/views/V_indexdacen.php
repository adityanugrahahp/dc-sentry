<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Form Permohonan Akses Fisik Data Center</title>
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
            --card-bg: rgba(255, 255, 255, 0.95);
            --text: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            background-attachment: fixed;
            color: var(--text);
            position: relative;
            padding: 2rem 0;
        }

        /* EFEK DATA MELAYANG */
        .floating-data {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .floating-icon {
            position: absolute;
            color: rgba(255, 255, 255, 0.05);
            opacity: 0;
            animation: float linear infinite;
            font-size: 2rem;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.8;
            }

            90% {
                opacity: 0.8;
            }

            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .form-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18);
            border: none !important;
            overflow: hidden;
            backdrop-filter: blur(10px);
            position: relative;
        }

        .card-header {
            background: linear-gradient(135deg,
                    #003050 0%,
                    #004070 20%,
                    #004080 40%,
                    #0050a0 60%,
                    #0060c0 80%,
                    #0066cc 100%);
            background-size: 400% 400%;
            color: white;
            padding: 1.5rem;
            text-align: center;
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
            animation: gradient 8s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .required::after {
            content: " *";
            color: #ef4444;
            font-weight: bold;
        }

        .form-control,
        .form-select {
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            color: var(--text);
            background: white;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.15);
            background: white;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-select {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 14px;
        }

        .declaration {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-left: 5px solid var(--primary-light);
            padding: 1.2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            color: #0c4a6e;
        }

        .declaration p {
            margin: 0 0 0.8rem;
            font-weight: 600;
        }

        .declaration ul {
            margin: 0;
            padding-left: 1.2rem;
        }

        .declaration li {
            margin-bottom: 0.4rem;
        }

        .upload-area {
            border: 2px dashed #94a3b8;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            background: #f8fafc;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .upload-area:hover,
        .upload-area.dragover {
            border-color: var(--primary-light);
            background: #e0f2fe;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-8px);
            }

            75% {
                transform: translateX(8px);
            }
        }

        .upload-area.error {
            border-color: var(--danger) !important;
            background: #fee2e2 !important;
            animation: shake 0.5s ease !important;
        }

        .upload-area.error::before {
            content: '⚠️ ';
            color: var(--danger);
            font-weight: bold;
            margin-right: 5px;
        }

        .upload-area i {
            font-size: 2.5rem;
            color: var(--primary-light);
            margin-bottom: 0.5rem;
        }

        .upload-area p {
            margin: 0.5rem 0;
            font-weight: 600;
            color: var(--text);
        }

        .upload-area small {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .upload-preview {
            margin-top: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: white;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            min-height: 80px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .upload-preview .file-icon {
            font-size: 2.5rem;
            color: var(--primary-light);
        }

        .upload-preview .file-info {
            flex: 1;
            min-width: 0;
        }

        .upload-preview .file-name {
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }

        .upload-preview .file-size {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .upload-preview .btn-remove {
            background: var(--danger);
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .upload-preview .btn-remove:hover {
            background: #dc2626;
            transform: scale(1.1);
        }

        .btn-submit {
            background: var(--primary-light);
            color: white;
            border: none;
            padding: 0.9rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 102, 204, 0.3);
        }

        .btn-submit:hover {
            background: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 102, 204, 0.4);
        }

        .btn-submit:disabled {
            opacity: 0.7 !important;
            cursor: not-allowed !important;
            transform: none !important;
            box-shadow: 0 2px 8px rgba(0, 102, 204, 0.2) !important;
        }

        .btn-submit:disabled:hover {
            background: var(--primary-light) !important;
            transform: none !important;
            box-shadow: 0 2px 8px rgba(0, 102, 204, 0.2) !important;
        }

        .btn-submit.loading {
            position: relative;
        }

        .btn-submit.loading .fa-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* TOAST */
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            display: flex;
            align-items: center;
            gap: 0.8rem;
            min-width: 300px;
            opacity: 0;
            transform: translateX(120%) scale(0.9);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .toast.show {
            opacity: 1;
            transform: translateX(0) scale(1);
        }

        .toast.hide {
            opacity: 0;
            transform: translateX(120%) scale(0.9);
        }

        .toast.success {
            border-left: 5px solid var(--success);
        }

        .toast.error {
            border-left: 5px solid var(--danger);
        }

        .toast.warning {
            border-left: 5px solid var(--warning);
            background: #fff3cd;
            color: #856404;
        }

        .toast.warning i {
            color: #ffc107;
        }

        .toast i {
            font-size: 1.4rem;
            transition: transform 0.3s ease;
        }

        .toast.success i {
            color: var(--success);
            animation: checkmark 0.6s ease 0.4s forwards;
        }

        @keyframes checkmark {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Error message styling */
        .error-message {
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: none;
        }

        .error-message.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        /* OVERLAY STYLES */
        #formOverlay {
            animation: fadeIn 0.3s ease;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(2px);
            z-index: 10;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* STYLE UNTUK DOKUMEN VERTICAL FULL */
        .dokumen-vertical-full {
            background: linear-gradient(135deg, #ffffff, #fafbfc);
            border: 1px solid #e1e5e9 !important;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 1rem;
        }

        .dokumen-vertical-full:hover {
            border-color: #004080 !important;
            box-shadow: 0 4px 15px rgba(0, 64, 128, 0.1);
            transform: translateY(-1px);
        }

        .dokumen-header {
            border-bottom: 2px solid #004080;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }

        .dokumen-vertical-full .nama-dokumen-input {
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .dokumen-vertical-full .nama-dokumen-input:focus {
            border-color: #004080;
            box-shadow: 0 0 0 3px rgba(0, 64, 128, 0.1);
            background: #f8fbff;
        }

        /* File info section */
        .file-info-section {
            margin-top: 1rem;
        }

        .file-detail {
            border: 1px solid #e9ecef;
            background: linear-gradient(135deg, #f8f9fa, #ffffff) !important;
        }

        .file-detail:hover {
            border-color: #004080;
            background: linear-gradient(135deg, #f0f7ff, #ffffff) !important;
        }

        .file-name {
            font-size: 0.95rem;
            color: #1a1a1a;
            margin-bottom: 0.25rem;
        }

        .file-meta {
            font-size: 0.8rem;
        }

        .file-type-badge .badge {
            font-size: 0.7rem;
            padding: 0.3em 0.6em;
        }

        /* Tombol hapus */
        .dokumen-vertical-full .btn-remove {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: #e53e3e;
        }

        .dokumen-vertical-full .btn-remove:hover {
            background: #e53e3e;
            border-color: #e53e3e;
            transform: scale(1.1);
            color: white;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .card-header {
                font-size: 1.2rem;
                padding: 1.2rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .btn-submit {
                width: 100%;
            }

            .upload-preview {
                flex-direction: column;
                text-align: center;
            }

            .upload-preview .btn-remove {
                margin-top: 0.5rem;
            }

            .toast {
                min-width: auto;
                width: calc(100% - 2rem);
            }

            .dokumen-vertical-full {
                padding: 1rem;
            }

            .file-detail .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .file-type-badge {
                margin-top: 0.5rem;
                align-self: flex-end;
            }
        }

        /* Style untuk label */
        .dokumen-vertical-full .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #004080 !important;
        }

        /* Tambahan untuk upload area dokumen */
        #uploadAreaDokumen {
            border: 2px dashed #004080;
            background: #f0f7ff;
            transition: all 0.3s ease;
        }

        #uploadAreaDokumen:hover {
            border-color: #003366;
            background: #e6f2ff;
        }

        #uploadAreaDokumen.dragover {
            border-color: #002244;
            background: #d9ebff;
            transform: scale(1.02);
        }

        /* Style untuk preview kosong dokumen */
        .empty-preview {
            display: flex;
            align-items: center;
            gap: 1rem;
            min-height: 80px;
        }

        .empty-preview .file-icon {
            font-size: 2.5rem;
            color: var(--primary-light);
        }

        .empty-preview .file-info {
            flex: 1;
            min-width: 0;
        }

        .empty-preview .file-name {
            font-weight: 600;
            color: var(--text);
            display: block;
        }

        .empty-preview .file-size {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        /* PAKSA DOKUMEN TAMBAHAN SELALU VERTIKAL */
        .dokumen-list-vertical {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .dokumen-list-vertical>.dokumen-vertical-full {
            width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        /* Responsif: pastikan tidak ada grid atau flex row */
        #previewContainerDokumen {
            display: block !important;
        }
    </style>
</head>

<body>

    <!-- EFEK DATA MELAYANG -->
    <div class="floating-data" id="floatingData"></div>

    <div class="container">
        <div class="form-card">
            <div class="card-header">
                FORM PERMOHONAN AKSES FISIK DATA CENTER
            </div>

            <div class="card-body">
                <div class="declaration">
                    <p><strong>Saya yang bertanda tangan di bawah ini, selaku pemohon menyatakan bahwa:</strong></p>
                    <ul>
                        <li>Saya telah mengisi segala informasi permohonan dengan sesungguh-sungguhnya, tanpa ada paksaan dari pihak manapun dan saya mengijinkan bagian Pengelola Sistem Keamanan PT PELNI (Persero) untuk memeriksa pernyataan tersebut. Setiap ketidakbenaran atas pernyataan tersebut dapat mengakibatkan dicabutnya hak akses fisik saya dan pemberian sanksisesuai dengan peraturan yang diberlakukan oleh PT PELNI (Persero).</li>
                        <li>Saya bertanggung jawab sepenuhnya terhadap semua akibat yang berkaitan atas penggunaan hak akses fisik yang diberikan.</li>
                        <li>Saya bertanggungjawab sepenuhnya terhadap penggunaan hak akses fisik yang diberikan dan saya tidak akan memberikan hak akses fisik tersebut kepada orang lain untuk keperluan apapun.</li>
                    </ul>
                </div>

                <form id="form_dacen" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label required">Nama Lengkap Pemohon</label>
                            <input type="text" name="nama_pemohon" class="form-control" required placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">NIP / NIK / ID Karyawan / Vendor</label>
                            <input type="number" name="id_karyawan" class="form-control" required placeholder="Contoh: 123456789">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" required placeholder="Contoh: IT Manager">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Unit Kerja / Perusahaan Asal</label>
                            <input type="text" name="unit_kerja" class="form-control" required placeholder="Contoh: Divisi IT">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Telepon</label>
                            <input type="number" name="telepon" class="form-control" required placeholder="Contoh: 08123456789">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fax</label>
                            <input type="number" name="fax" class="form-control" placeholder="Opsional">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Status Pegawai</label>
                            <select name="status_pegawai" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Status --</option>
                                <option value="Internal">Internal</option>
                                <option value="Eksternal">Eksternal</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Nama Perusahaan</label>
                            <input type="text" name="nama_perusahaan" class="form-control" required placeholder="Contoh: PT ABC">
                        </div>

                        <div class="col-12">
                            <label class="form-label required">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" required placeholder="Masukkan alamat lengkap"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Email</label>
                            <input type="email" name="email" class="form-control" required placeholder="Contoh: nama@perusahaan.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Person</label>
                            <input type="number" name="contact_person" class="form-control" placeholder="Nomor lain (opsional)">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Nama Proyek</label>
                            <input type="text" name="nama_proyek" class="form-control" required placeholder="Contoh: Upgrade Server DC-01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Waktu Proyek</label>
                            <input type="text" name="waktu_proyek" class="form-control" required placeholder="Contoh: 4 November 2025 Pukul 12.00 - 13.00">
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Input KTP -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">
                            Upload KTP <span class="text-danger">*</span>
                        </h6>
                        <div class="upload-area" id="uploadAreaKtp">
                            <i class="fas fa-id-card"></i>
                            <p><strong>Drag & drop file KTP di sini</strong></p>
                            <small>Format: PNG, JPG, JPEG, PDF (Maks. 2MB)</small>
                            <input type="file" name="ktp" id="fileInputKtp" accept=".png,.jpg,.jpeg,.pdf" required style="display: none;">
                        </div>

                        <div class="upload-preview" id="previewContainerKtp">
                            <div class="empty-preview">
                                <i class="fas fa-file-alt file-icon"></i>
                                <div class="file-info">
                                    <span class="file-name">Belum ada file KTP yang dipilih</span>
                                    <small class="file-size">Pilih file KTP untuk melanjutkan</small>
                                </div>
                            </div>
                        </div>

                        <div id="fileErrorKtp" class="error-message">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <span id="fileErrorTextKtp">KTP wajib diupload</span>
                        </div>
                    </div>

                    <!-- Input Dokumen Tambahan -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">
                            Dokumen Tambahan
                            <small class="text-muted">(Opsional)</small>
                        </h6>
                        <div class="upload-area" id="uploadAreaDokumen">
                            <i class="fas fa-folder-open"></i>
                            <p><strong>Drag & drop multiple file di sini</strong></p>
                            <small>Format: PNG, JPG, JPEG, PDF (Maks. 2MB per file)</small>
                            <input type="file" name="dokumen_tambahan[]" id="fileInputDokumen" multiple accept=".png,.jpg,.jpeg,.pdf" style="display: none;">
                        </div>

                        <div class="upload-preview" id="previewContainerDokumen">
                            <div class="empty-preview">
                                <i class="fas fa-file-alt file-icon"></i>
                                <div class="file-info">
                                    <span class="file-name">Belum ada file dokumen tambahan</span>
                                    <small class="file-size">Pilih file untuk menambahkan dokumen pendukung</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3">
                        Upload Tanda Tangan Pemohon <span class="text-danger">*</span>
                        <small class="text-danger ms-2"></small>
                    </h6>

                    <div class="upload-area" id="uploadArea">
                        <i class="fas fa-signature"></i>
                        <p><strong>Drag & drop file tanda tangan di sini</strong></p>
                        <small>Format: PNG, JPG, PDF, P7S, P7M, SIG, ASC, GPG, XAdES, CAdES, PAdES (Maks. 2MB)</small>
                        <input type="file" name="ttd_pemohon" id="fileInput" accept=".png,.jpg,.jpeg,.pdf,.p7s,.p7m,.sig,.asc,.gpg,.xades,.cades,.pades" required style="display: none;">
                    </div>

                    <div class="upload-preview" id="previewContainer">
                        <div class="empty-preview">
                            <i class="fas fa-file-alt file-icon"></i>
                            <div class="file-info">
                                <span class="file-name">Belum ada file yang dipilih</span>
                                <small class="file-size">Pilih file tanda tangan untuk melanjutkan</small>
                            </div>
                        </div>
                    </div>

                    <!-- Pesan error untuk file -->
                    <div id="fileError" class="error-message">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        <span id="fileErrorText">Tanda tangan wajib diupload</span>
                    </div>

                    <div class="text-center mt-5">
                        <button type="submit" class="btn-submit" id="submitBtn">
                            Kirim Permohonan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TOAST -->
    <div class="toast-container" id="toastContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // === VARIABEL GLOBAL UNTUK MENCEGAH DUPLIKAT ===
        let isSubmitting = false;
        let currentFile = null;
        let currentFileKtp = null;
        let dokumenFiles = [];

        // === EFEK DATA MELAYANG – 30 IKON ACAK ===
        const icons = [
            'fas fa-server', 'fas fa-database', 'fas fa-network-wired', 'fas fa-shield-alt',
            'fas fa-microchip', 'fas fa-hdd', 'fas fa-cloud', 'fas fa-code',
            'fas fa-lock', 'fas fa-key', 'fas fa-cogs', 'fas fa-terminal',
            'fas fa-laptop-code', 'fas fa-sitemap', 'fas fa-router', 'fas fa-firewall',
            'fas fa-globe', 'fas fa-project-diagram', 'fas fa-hard-drive', 'fas fa-memory',
            'fas fa-cpu', 'fas fa-ethernet', 'fas fa-wifi', 'fas fa-broadcast-tower',
            'fas fa-satellite', 'fas fa-signal', 'fas fa-chart-network', 'fas fa-code-branch',
            'fas fa-plug', 'fas fa-bolt'
        ];

        const container = document.getElementById('floatingData');
        const totalIcons = 30;

        for (let i = 0; i < totalIcons; i++) {
            const el = document.createElement('i');
            const icon = icons[Math.floor(Math.random() * icons.length)];
            const size = (Math.random() * 1.5 + 1.5).toFixed(2) + 'rem';
            const duration = (Math.random() * 15 + 10).toFixed(2) + 's';
            const delay = Math.random() * 10 + 's';
            const left = Math.random() * 100 + '%';

            el.className = `${icon} floating-icon`;
            el.style.fontSize = size;
            el.style.left = left;
            el.style.animationDuration = duration;
            el.style.animationDelay = delay;

            container.appendChild(el);
        }

        // === UPLOAD LOGIC ===
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('previewContainer');
        const fileError = document.getElementById('fileError');

        const uploadAreaKtp = document.getElementById('uploadAreaKtp');
        const fileInputKtp = document.getElementById('fileInputKtp');
        const previewContainerKtp = document.getElementById('previewContainerKtp');
        const fileErrorKtp = document.getElementById('fileErrorKtp');

        const uploadAreaDokumen = document.getElementById('uploadAreaDokumen');
        const fileInputDokumen = document.getElementById('fileInputDokumen');
        const previewContainerDokumen = document.getElementById('previewContainerDokumen');

        // Fungsi untuk menampilkan error message file
        function showFileError(errorElement, message) {
            if (errorElement) {
                errorElement.querySelector('span').textContent = message;
                errorElement.classList.add('show');
            }
        }

        function hideFileError(errorElement) {
            if (errorElement) {
                errorElement.classList.remove('show');
            }
        }

        // Setup upload area untuk semua jenis file
        function setupUploadArea(uploadArea, fileInput, previewContainer, fileError, isMultiple = false, handleFileFunction) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
                uploadArea.addEventListener(event, e => {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            });

            ['dragenter', 'dragover'].forEach(event => {
                uploadArea.addEventListener(event, () => uploadArea.classList.add('dragover'), false);
            });

            ['dragleave', 'drop'].forEach(event => {
                uploadArea.addEventListener(event, () => uploadArea.classList.remove('dragover'), false);
            });

            uploadArea.addEventListener('drop', e => {
                const files = e.dataTransfer.files;
                if (files.length) {
                    if (isMultiple) {
                        handleMultipleFiles(files);
                    } else {
                        handleFileFunction(files[0]);
                    }
                }
            });

            uploadArea.addEventListener('click', () => fileInput.click());
        }

        // Handle file TTD
        function handleFile(file) {
            if (!file) return;

            // Validasi tipe file - DIPERBARUI dengan format tanda tangan digital
            const allowedTypes = [
                'image/jpeg', 'image/jpg', 'image/png', 'application/pdf',
                'application/pkcs7-signature', 'application/pkcs7-mime',
                'application/pgp-signature', 'application/pgp-keys',
                'application/x-pkcs7-signature', 'application/x-pkcs7-mime'
            ];

            const allowedExtensions = ['.p7s', '.p7m', '.sig', '.asc', '.gpg', '.xades', '.cades', '.pades'];
            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();

            if (!allowedTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
                showToast('Format file tidak didukung. Gunakan PNG, JPG, PDF, atau format tanda tangan digital (P7S, P7M, SIG, ASC, GPG, XAdES, CAdES, PAdES).', 'error');
                showFileError(fileError, 'Format file tidak didukung');
                return;
            }

            // Validasi ukuran file (max 2MB)
            const maxSize = 2 * 1024 * 1024;
            if (file.size > maxSize) {
                showToast('Ukuran file maksimal 2MB.', 'error');
                showFileError(fileError, 'Ukuran file terlalu besar (maks. 2MB)');
                return;
            }

            currentFile = file;
            const size = (file.size / 1024).toFixed(1) + ' KB';
            const ext = file.name.split('.').pop().toUpperCase();

            let fileIcon = 'fa-file-alt';
            if (file.type.includes('image')) fileIcon = 'fa-file-image';
            else if (file.type.includes('pdf')) fileIcon = 'fa-file-pdf';
            else fileIcon = 'fa-file-signature';

            previewContainer.innerHTML = `
                <i class="fas ${fileIcon} file-icon"></i>
                <div class="file-info">
                    <span class="file-name" title="${file.name}">${file.name}</span>
                    <small class="file-size">${size} • ${ext}</small>
                </div>
                <button type="button" class="btn-remove" onclick="removeFile()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            uploadArea.classList.remove('error');
            hideFileError(fileError);
            showToast('File tanda tangan berhasil diupload!', 'success');
        }

        function removeFile() {
            currentFile = null;
            fileInput.value = '';
            previewContainer.innerHTML = `
                <div class="empty-preview">
                    <i class="fas fa-file-alt file-icon"></i>
                    <div class="file-info">
                        <span class="file-name">Belum ada file yang dipilih</span>
                        <small class="file-size">Pilih file tanda tangan untuk melanjutkan</small>
                    </div>
                </div>
            `;
        }

        // Handle file KTP
        function handleFileKtp(file) {
            if (!file) return;

            // Validasi tipe file
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            if (!allowedTypes.includes(file.type)) {
                showToast('Format file KTP tidak didukung. Gunakan PNG, JPG, JPEG, atau PDF.', 'error');
                showFileError(fileErrorKtp, 'Format file tidak didukung');
                return;
            }

            // Validasi ukuran file (max 2MB)
            const maxSize = 2 * 1024 * 1024;
            if (file.size > maxSize) {
                showToast('Ukuran file KTP maksimal 2MB.', 'error');
                showFileError(fileErrorKtp, 'Ukuran file terlalu besar (maks. 2MB)');
                return;
            }

            currentFileKtp = file;
            const size = (file.size / 1024).toFixed(1) + ' KB';
            const ext = file.name.split('.').pop().toUpperCase();

            previewContainerKtp.innerHTML = `
                <i class="fas ${file.type === 'application/pdf' ? 'fa-file-pdf' : 'fa-file-image'} file-icon"></i>
                <div class="file-info">
                    <span class="file-name" title="${file.name}">${file.name}</span>
                    <small class="file-size">${size} • ${ext}</small>
                </div>
                <button type="button" class="btn-remove" onclick="removeFileKtp()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            uploadAreaKtp.classList.remove('error');
            hideFileError(fileErrorKtp);
            showToast('File KTP berhasil diupload!', 'success');
        }

        function removeFileKtp() {
            currentFileKtp = null;
            fileInputKtp.value = '';
            previewContainerKtp.innerHTML = `
                <div class="empty-preview">
                    <i class="fas fa-file-alt file-icon"></i>
                    <div class="file-info">
                        <span class="file-name">Belum ada file KTP yang dipilih</span>
                        <small class="file-size">Pilih file KTP untuk melanjutkan</small>
                    </div>
                </div>
            `;
            hideFileError(fileErrorKtp);
        }

        // Handle multiple files untuk dokumen tambahan
        function handleMultipleFiles(files) {
            const validFiles = [];
            const invalidFiles = [];

            for (let file of files) {
                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                const file_type = file.type;

                if (!allowedTypes.includes(file_type)) {
                    invalidFiles.push(file.name);
                    continue;
                }

                // Validasi ukuran file
                const maxSize = 2 * 1024 * 1024;
                if (file.size > maxSize) {
                    invalidFiles.push(`${file.name} (terlalu besar)`);
                    continue;
                }

                validFiles.push(file);
            }

            // Tambahkan file yang valid
            if (validFiles.length > 0) {
                validFiles.forEach(file => {
                    dokumenFiles.push({
                        file: file,
                        nama: file.name.replace(/\.[^/.]+$/, "")
                    });
                });

                updateDokumenPreview();

                if (validFiles.length === 1) {
                    showToast(`1 dokumen berhasil ditambahkan!`, 'success');
                } else {
                    showToast(`${validFiles.length} dokumen berhasil ditambahkan!`, 'success');
                }

                // Reset file input
                fileInputDokumen.value = '';
            }

            // Tampilkan warning untuk file yang tidak valid
            if (invalidFiles.length > 0) {
                const invalidList = invalidFiles.slice(0, 3).join(', ');
                const moreText = invalidFiles.length > 3 ? ` dan ${invalidFiles.length - 3} lainnya` : '';

                showToast(
                    `${invalidFiles.length} file tidak valid: ${invalidList}${moreText}. Format: JPG, PNG, PDF (maks. 2MB)`,
                    'warning'
                );
            }
        }

        function updateDokumenPreview() {
            if (dokumenFiles.length === 0) {
                previewContainerDokumen.innerHTML = `
            <div class="empty-preview">
                <i class="fas fa-file-alt file-icon"></i>
                <div class="file-info">
                    <span class="file-name">Belum ada file dokumen tambahan</span>
                    <small class="file-size">Pilih file untuk menambahkan dokumen pendukung</small>
                </div>
            </div>
        `;
                return;
            }

            let previewHTML = '<div class="dokumen-list-vertical">'; // Tambah wrapper

            dokumenFiles.forEach((dokumen, index) => {
                const file = dokumen.file;
                const size = (file.size / 1024).toFixed(1) + ' KB';
                const ext = file.name.split('.').pop().toUpperCase();

                previewHTML += `
            <div class="dokumen-vertical-full mb-4 p-3 border rounded">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-primary">Dokumen ${index + 1}</span>
                    <button type="button" class="btn-remove btn-sm" onclick="removeDokumenFile(${index})" title="Hapus dokumen">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark mb-1">
                        <i class="fas fa-tag me-1"></i>Nama Dokumen
                    </label>
                    <input type="text" 
                           class="form-control nama-dokumen-input" 
                           name="nama_dokumen[${index}]" 
                           placeholder="Contoh: Surat Izin, Proposal, dll."
                           value="${dokumen.nama}"
                           onchange="updateNamaDokumen(${index}, this.value)">
                    <small class="text-muted">Berikan nama yang deskriptif untuk dokumen ini</small>
                </div>
                
                <div class="file-info-section">
                    <label class="form-label small fw-bold text-dark mb-1">
                        <i class="fas fa-file me-1"></i>File Terupload
                    </label>
                    <div class="file-detail p-2 bg-light rounded">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center flex-grow-1">
                                <i class="fas ${file.type === 'application/pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-primary'} me-3 fs-5"></i>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="file-name fw-bold text-dark text-truncate">${file.name}</div>
                                    <div class="file-meta text-muted small">
                                        <span class="me-3"><i class="fas fa-weight me-1"></i>${size}</span>
                                        <span><i class="fas fa-code me-1"></i>${ext}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="file-type-badge">
                                <span class="badge ${file.type === 'application/pdf' ? 'bg-danger' : 'bg-success'}">
                                    ${file.type === 'application/pdf' ? 'PDF' : 'Gambar'}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
            });

            previewHTML += `
        </div>
        <div class="text-center mt-3">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('fileInputDokumen').click()">
                <i class="fas fa-plus me-1"></i>Tambah Dokumen Lainnya
            </button>
        </div>
    `;

            previewContainerDokumen.innerHTML = previewHTML;
        }

        function updateNamaDokumen(index, nama) {
            if (dokumenFiles[index]) {
                dokumenFiles[index].nama = nama;
            }
        }

        function removeDokumenFile(index) {
            if (confirm('Hapus dokumen ini?')) {
                dokumenFiles.splice(index, 1);
                updateDokumenPreview();
                showToast('Dokumen berhasil dihapus', 'success');
            }
        }

        // === TOAST DENGAN EFEK HILANG LEMBUT ===
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;

            let icon = 'check-circle';
            if (type === 'error') icon = 'exclamation-triangle';
            if (type === 'warning') icon = 'exclamation-circle';

            toast.innerHTML = `<i class="fas fa-${icon}"></i><div>${message}</div>`;
            const container = document.getElementById('toastContainer');
            container.appendChild(toast);

            setTimeout(() => toast.classList.add('show'), 10);

            const duration = type === 'error' ? 5000 : 4000;
            setTimeout(() => {
                toast.classList.add('hide');
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 500);
            }, duration);
        }

        // === FUNGSI UNTUK MENGATUR STATE SUBMIT BUTTON ===
        function setSubmitButtonState(submitting) {
            const btn = document.getElementById('submitBtn');
            isSubmitting = submitting;

            if (submitting) {
                btn.disabled = true;
                btn.classList.add('loading');
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
                addFormOverlay();
            } else {
                btn.disabled = false;
                btn.classList.remove('loading');
                btn.innerHTML = 'Kirim Permohonan';
                removeFormOverlay();
            }
        }

        // === OVERLAY UNTUK MENCEGAH INTERAKSI SAAT LOADING ===
        function addFormOverlay() {
            if (document.getElementById('formOverlay')) return;

            const overlay = document.createElement('div');
            overlay.id = 'formOverlay';
            overlay.innerHTML = `
                <div style="text-align: center; color: #004080;">
                    <div class="spinner-border text-primary mb-2" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p style="font-weight: 600; margin: 0;">Mengirim data...</p>
                    <small style="color: #666;">Harap tunggu</small>
                </div>
            `;

            document.querySelector('.form-card').appendChild(overlay);
        }

        function removeFormOverlay() {
            const overlay = document.getElementById('formOverlay');
            if (overlay) {
                overlay.remove();
            }
        }

        // === VALIDASI & SUBMIT ===
        function validateForm() {
            if (isSubmitting) {
                showToast('Sedang mengirim data, harap tunggu...', 'warning');
                return false;
            }

            let valid = true;
            let errorMessages = [];

            // Reset semua
            document.querySelectorAll('.form-control, .form-select').forEach(el => {
                el.style.borderColor = '#cbd5e1';
            });
            uploadArea.classList.remove('error');
            uploadAreaKtp.classList.remove('error');
            hideFileError(fileError);
            hideFileError(fileErrorKtp);

            // Cek input required
            const inputs = document.querySelectorAll('input[required], select[required], textarea[required]');
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = 'var(--danger)';
                    valid = false;
                    const label = input.previousElementSibling?.textContent?.replace('*', '').trim() || 'Field';
                    errorMessages.push(`${label} wajib diisi`);
                }
            });

            // Cek file TTD
            if (!currentFile) {
                uploadArea.classList.add('error');
                valid = false;
                errorMessages.push('Tanda tangan pemohon wajib diupload');
                showFileError(fileError, 'Tanda tangan pemohon wajib diupload');

                uploadArea.style.animation = 'shake 0.5s ease';
                setTimeout(() => {
                    uploadArea.style.animation = '';
                }, 500);
            }

            // Cek file KTP
            if (!currentFileKtp) {
                uploadAreaKtp.classList.add('error');
                valid = false;
                errorMessages.push('KTP wajib diupload');
                showFileError(fileErrorKtp, 'KTP wajib diupload');

                uploadAreaKtp.style.animation = 'shake 0.5s ease';
                setTimeout(() => {
                    uploadAreaKtp.style.animation = '';
                }, 500);
            }

            // Tampilkan semua error messages
            if (errorMessages.length > 0) {
                showToast('<strong>Perbaiki error berikut:</strong><br>' + errorMessages.join('<br>'), 'error');
            }

            return valid;
        }

        // === FUNGSI SUBMIT YANG AMAN DARI DUPLIKAT ===
        function safeFormSubmit(e) {
            e.preventDefault();

            if (isSubmitting) {
                showToast('Sedang mengirim data, harap tunggu...', 'warning');
                return;
            }

            if (!validateForm()) {
                if (!currentFile) {
                    uploadArea.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
                if (!currentFileKtp) {
                    uploadAreaKtp.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
                return;
            }

            // Set state submitting
            setSubmitButtonState(true);

            // Buat FormData dari form yang ada
            const formData = new FormData();

            // **TAMBAHKAN TOKEN KE FORM DATA**
            const formToken = '<?php echo isset($token) ? $token : ''; ?>';
            console.log('Token yang dikirim:', formToken); // Debug
            formData.append('form_token', formToken);

            // Tambahkan semua field text dari form
            const formElements = this.elements;
            for (let element of formElements) {
                if (element.name && element.type !== 'file' && element.value) {
                    if (element.type === 'checkbox' || element.type === 'radio') {
                        if (element.checked) {
                            formData.append(element.name, element.value);
                        }
                    } else {
                        formData.append(element.name, element.value);
                    }
                }
            }

            // Append file manual dengan nama yang benar
            formData.append('ttd_pemohon', currentFile);
            formData.append('ktp', currentFileKtp);

            // Tambahkan dokumen tambahan
            dokumenFiles.forEach((dokumen, index) => {
                formData.append('dokumen_tambahan[]', dokumen.file);
                formData.append(`nama_dokumen[${index}]`, dokumen.nama);
            });

            // Tambahkan jumlah dokumen
            formData.append('total_dokumen', dokumenFiles.length);

            // Tambahkan timestamp untuk mencegah duplikat
            formData.append('submit_timestamp', Date.now());

            // Debug: Log FormData contents
            console.log('FormData contents:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ', pair[1]);
            }

            // Timeout protection (30 detik)
            const timeoutDuration = 30000;
            const timeoutPromise = new Promise((_, reject) => {
                setTimeout(() => reject(new Error('Timeout: Request took too long')), timeoutDuration);
            });

            // Fetch request
            const fetchPromise = fetch("<?= site_url('data_center/simpan_permohonan') ?>", {
                method: "POST",
                body: formData
            });

            // Race between fetch and timeout
            Promise.race([fetchPromise, timeoutPromise])
                .then(r => {
                    if (!r.ok) {
                        throw new Error(`HTTP error! status: ${r.status}`);
                    }
                    return r.json();
                })
                .then(res => {
                    if (res.status === 'success') {
                        showToast(res.message || 'Permohonan berhasil dikirim! ID: ' + res.id, 'success');

                        // Reset form setelah sukses
                        this.reset();
                        removeFile();
                        removeFileKtp();
                        dokumenFiles = [];
                        updateDokumenPreview();
                        hideFileError(fileError);
                        hideFileError(fileErrorKtp);

                        // Tambahkan delay sebelum enable button
                        setTimeout(() => {
                            setSubmitButtonState(false);
                        }, 2000);

                    } else {
                        showToast(res.message || 'Gagal kirim permohonan', 'error');
                        setSubmitButtonState(false);
                    }
                })
                .catch(err => {
                    console.error('Fetch error:', err);

                    if (err.message.includes('Timeout')) {
                        showToast('Koneksi timeout. Silakan coba lagi.', 'error');
                    } else {
                        showToast('Koneksi gagal: ' + err.message, 'error');
                    }

                    setSubmitButtonState(false);
                });
        }

        // === INISIALISASI ===
        document.addEventListener('DOMContentLoaded', function() {
            // Setup upload areas
            setupUploadArea(uploadArea, fileInput, previewContainer, fileError, false, handleFile);
            setupUploadArea(uploadAreaKtp, fileInputKtp, previewContainerKtp, fileErrorKtp, false, handleFileKtp);
            setupUploadArea(uploadAreaDokumen, fileInputDokumen, previewContainerDokumen, null, true, handleMultipleFiles);

            // Event listener untuk file input
            fileInput.addEventListener('change', () => {
                if (fileInput.files[0]) {
                    handleFile(fileInput.files[0]);
                } else {
                    removeFile();
                }
            });

            fileInputKtp.addEventListener('change', () => {
                if (fileInputKtp.files[0]) {
                    handleFileKtp(fileInputKtp.files[0]);
                } else {
                    removeFileKtp();
                }
            });

            fileInputDokumen.addEventListener('change', () => {
                if (fileInputDokumen.files.length > 0) {
                    handleMultipleFiles(Array.from(fileInputDokumen.files));
                }
            });

            // Event listener untuk form submit
            document.getElementById('form_dacen').addEventListener('submit', safeFormSubmit);

            // Mencegah double click
            document.getElementById('submitBtn').addEventListener('click', function(e) {
                if (isSubmitting) {
                    e.preventDefault();
                    e.stopPropagation();
                    showToast('Sedang mengirim data, harap tunggu...', 'warning');
                    return false;
                }
            });

            // Mencegah form submit multiple dengan keyboard
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && isSubmitting) {
                    e.preventDefault();
                    showToast('Sedang mengirim data, harap tunggu...', 'warning');
                }
            });
        });
    </script>
</body>

</html>