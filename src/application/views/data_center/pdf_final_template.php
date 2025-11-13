<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .form-table td {
            padding: 8px;
            vertical-align: top;
            border: 1px solid #000;
        }
        .form-table .label {
            font-weight: bold;
            width: 30%;
            background-color: #f0f0f0;
        }
        .section-title {
            background-color: #004080;
            color: white;
            padding: 8px;
            font-weight: bold;
            margin: 15px 0 10px 0;
        }
        .signature-section {
            margin-top: 40px;
        }
        .signature-box {
            display: inline-block;
            width: 45%;
            text-align: center;
            margin: 0 2%;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin: 60px 0 5px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>PT. PELNI (PERSERO)</h2>
        <h3>SURAT PERMOHONAN HAK AKSES FISIK DATA CENTER</h3>
        <p><strong>No. Dokumen: FRM-018 | Page: 1 dari 1 | Versi: 1.0</strong></p>
    </div>

    <div class="section-title">INFORMASI PEMOHON</div>
    <table class="form-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td><?= htmlspecialchars($p->nama_pemohon) ?></td>
        </tr>
        <tr>
            <td class="label">No. Induk Pegawai</td>
            <td><?= htmlspecialchars($p->id_karyawan) ?></td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td><?= htmlspecialchars($p->jabatan) ?></td>
        </tr>
        <tr>
            <td class="label">Unit Kerja</td>
            <td><?= htmlspecialchars($p->unit_kerja) ?></td>
        </tr>
        <tr>
            <td class="label">Telepon</td>
            <td><?= htmlspecialchars($p->telepon) ?> Ext: <?= htmlspecialchars($p->fax) ?></td>
        </tr>
        <tr>
            <td class="label">Status Pegawai</td>
            <td>
                <?= $p->status_pegawai == 'Internal' ? '☑ Pegawai Internal PT PELNI' : '☐ Pegawai Internal PT PELNI' ?>
                <?= $p->status_pegawai == 'Eksternal' ? '☑ Pegawai Eksternal PT PELNI' : '☐ Pegawai Eksternal PT PELNI' ?>
            </td>
        </tr>
        <tr>
            <td class="label">Nama Perusahaan</td>
            <td><?= htmlspecialchars($p->nama_perusahaan) ?></td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td><?= htmlspecialchars($p->alamat) ?></td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td><?= htmlspecialchars($p->email) ?></td>
        </tr>
    </table>

    <div class="section-title">INFORMASI PROYEK</div>
    <table class="form-table">
        <tr>
            <td class="label">Nama Proyek</td>
            <td><?= htmlspecialchars($p->nama_proyek) ?></td>
        </tr>
        <tr>
            <td class="label">Waktu Proyek</td>
            <td><?= htmlspecialchars($p->waktu_proyek) ?></td>
        </tr>
        <tr>
            <td class="label">Contact Person</td>
            <td><?= htmlspecialchars($p->contact_person) ?></td>
        </tr>
    </table>

    <?php if ($staff): ?>
    <div class="section-title">PERSETUJUAN STAFF IT</div>
    <table class="form-table">
        <tr>
            <td class="label">Nama Staff IT</td>
            <td><?= htmlspecialchars($staff->nama_staff_it) ?></td>
        </tr>
        <tr>
            <td class="label">Tanggal Berlaku</td>
            <td><?= date('d F Y', strtotime($staff->tanggal_berlaku)) ?></td>
        </tr>
        <tr>
            <td class="label">Waktu Akses</td>
            <td><?= $staff->jam_mulai ?> - <?= $staff->jam_selesai ?></td>
        </tr>
        <tr>
            <td class="label">Durasi Akses</td>
            <td><?= htmlspecialchars($staff->durasi_akses) ?></td>
        </tr>
        <tr>
            <td class="label">Tanggal TTD Staff</td>
            <td><?= date('d F Y H:i', strtotime($staff->tanggal_ttd)) ?></td>
        </tr>
    </table>
    <?php endif; ?>

    <div class="section-title">PERSETUJUAN MANAGER</div>
    <table class="form-table">
        <tr>
            <td class="label">Status Persetujuan</td>
            <td><strong>DISETUJUI</strong></td>
        </tr>
        <tr>
            <td class="label">Tanggal Persetujuan</td>
            <td><?= date('d F Y H:i') ?></td>
        </tr>
        <tr>
            <td class="label">ID Permohonan</td>
            <td><strong>DC-<?= sprintf("%04d", $id) ?></strong></td>
        </tr>
    </table>

    <!-- QR Code Section -->
    <div class="qr-code">
        <p><strong>SCAN QR CODE UNTUK VERIFIKASI</strong></p>
        <?php
        // Generate QR Code
        $this->load->library('ciqrcode');
        $qr_data = "PT PELNI Data Center\nID: DC-" . sprintf("%04d", $id) . "\nNama: " . $p->nama_pemohon . "\nProyek: " . $p->nama_proyek . "\nStatus: APPROVED";
        $qr_dir = FCPATH . 'uploads/qr_codes/';
        if (!is_dir($qr_dir)) mkdir($qr_dir, 0755, true);
        $qr_file = 'qr_dc_' . $id . '.png';
        $qr_path = $qr_dir . $qr_file;
        
        $params = [
            'data' => $qr_data,
            'level' => 'H',
            'size' => 6,
            'savename' => $qr_path
        ];
        $this->ciqrcode->generate($params);
        ?>
        <img src="<?= $qr_path ?>" width="150" height="150" alt="QR Code">
        <p>ID: <strong>DC-<?= sprintf("%04d", $id) ?></strong></p>
    </div>

    <div class="section-title">PERNYATAAN</div>
    <p style="text-align: justify;">
        Saya yang bertanda tangan di bawah ini, selaku pemohon menyatakan bahwa:
    </p>
    <ul style="text-align: justify;">
        <li>Saya telah mengisi segala informasi permohonan dengan sesungguh-sungguhnya, tanpa ada paksaan dari pihak manapun dan saya mengijinkan bagian Pengelola Sistem Keamanan PT PELNI (Persero) untuk memeriksa pernyataan tersebut. Setiap ketidakbenaran atas pernyataan tersebut dapat mengakibatkan dicabutnya hak akses fisik saya dan pemberian sanksi sesuai dengan peraturan yang diberlakukan oleh PT PELNI (Persero).</li>
        <li>Saya bertanggungjawab sepenuhnya terhadap semua akibat yang berkaitan atas penggunaan hak akses fisik yang diberikan.</li>
        <li>Saya bertanggungjawab sepenuhnya terhadap penggunaan hak akses fisik yang diberikan dan saya tidak akan memberikan hak akses fisik tersebut kepada orang lain untuk keperluan apapun.</li>
    </ul>

    <div class="signature-section">
        <div class="signature-box">
            <p>Jakarta, <?= date('d F Y') ?></p>
            <p>Mengetahui,</p>
            <div class="signature-line"></div>
            <p><strong>Staff TI</strong></p>
            <?php if ($staff && $staff->nama_staff_it): ?>
                <p><?= htmlspecialchars($staff->nama_staff_it) ?></p>
            <?php endif; ?>
        </div>
        
        <div class="signature-box">
            <p>Tanda Tangan Pemohon</p>
            <div class="signature-line"></div>
            <p><strong><?= htmlspecialchars($p->nama_pemohon) ?></strong></p>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh Sistem Data Center PT PELNI</p>
        <p>Tanggal cetak: <?= date('d/m/Y H:i:s') ?> | Hak Cipta © <?= date('Y') ?> PT PELNI (Persero)</p>
    </div>
</body>
</html>