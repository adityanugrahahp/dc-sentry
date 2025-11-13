<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_DataCenter extends CI_Model
{

    // ==========================
    // === GET DATA SECTION ====
    // ==========================

    public function get_all_permohonan()
    {
        return $this->db->order_by('id', 'DESC')
            ->get('dc_form')
            ->result();
    }

    public function get_permohonan_staff_it()
    {
        return $this->db->where('status', 'Menunggu Approval')
            ->order_by('id', 'DESC')
            ->get('dc_form')
            ->result();
    }

    public function get_permohonan_manager()
    {
        $this->db->select('f.*, s.nama_staff_it, s.file_ttd_staff_it');
        $this->db->from('dc_form f');
        $this->db->join('dc_staff s', 's.dc_form_id = f.id', 'left');
        $this->db->where('f.status', 'Diteruskan ke Manager');
        $this->db->order_by('f.tanggal_ajukan', 'DESC');
        return $this->db->get()->result();
    }
    public function get_detail($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('dc_form')->row();
    }

    public function get_revisi($id)
    {
        $this->db->where('dc_form_id', $id);
        $this->db->order_by('tanggal_revisi', 'DESC');
        return $this->db->get('dc_revisi')->result();
    }

    // ==========================
    // === INSERT SECTION =======
    // ==========================

    public function insert_permohonan($data)
    {
        if (!isset($data['status'])) {
            $data['status'] = 'Menunggu Approval';
        }
        $data['tanggal_permohonan'] = date('Y-m-d');

        // VALIDASI PANJANG (PASTI MASUK)
        $data['nama_pemohon'] = substr($data['nama_pemohon'], 0, 1000);
        $data['nip_nik_id'] = substr($data['nip_nik_id'], 0, 1000);
        $data['jabatan'] = substr($data['jabatan'], 0, 500);
        $data['unit_kerja'] = substr($data['unit_kerja'], 0, 500);
        $data['nama_perusahaan'] = substr($data['nama_perusahaan'], 0, 500);
        $data['alamat'] = substr($data['alamat'], 0, 1000);
        $data['nama_proyek'] = substr($data['nama_proyek'], 0, 1000);
        $data['waktu_proyek'] = substr($data['waktu_proyek'], 0, 500);

        // Upload TTD
        if (isset($_FILES['file_ttd_pemohon']) && $_FILES['file_ttd_pemohon']['name'] != '') {
            $config = [
                'upload_path'   => './uploads/ttd_pemohon/',
                'allowed_types' => 'jpg|jpeg|png|pdf',
                'max_size'      => 2048,
                'encrypt_name'  => TRUE
            ];
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file_ttd_pemohon')) {
                $data['file_ttd_pemohon'] = $this->upload->data('file_name');
            }
        }

        return $this->db->insert('dc_form', $data);
    }
    // ==========================
    // === STAFF IT AJUKAN ======
    // ==========================

    public function ajukan_oleh_staff($id, $nama_staff, $file_ttd)
    {
        // 1. Simpan ke dc_staff
        $this->db->insert('dc_staff', [
            'dc_form_id' => $id,
            'nama_staff_it' => $nama_staff,
            'file_ttd_staff_it' => $file_ttd,
            'status_staff_it' => 'Diteruskan ke Manager',
            'tanggal_ttd' => date('Y-m-d H:i:s')
        ]);

        // 2. Update dc_form
        return $this->db->where('id', $id)->update('dc_form', [
            'status' => 'Diteruskan ke Manager',
            'tanggal_ajukan' => date('Y-m-d')
        ]);
    }

    // ==========================
    // === GET DATA MANAGER ====
    // ==========================

    public function get_permohonan_manager_sorted()
    {
        $this->db->select('f.*, s.nama_staff_it, s.file_ttd_staff_it, 
                      s.tanggal_ttd,
                      COALESCE(f.tanggal_revisi, f.tanggal_ajukan, s.tanggal_ttd, f.tanggal_permohonan) as sort_date')
            ->from('dc_form f')
            ->join('dc_staff s', 's.dc_form_id = f.id', 'left')
            ->where_in('f.status', ['Diteruskan ke Manager', 'Disetujui', 'Revisi Diperlukan'])
            ->order_by('sort_date', 'DESC')
            ->order_by('f.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_permohonan_manager_paginated_sorted($limit, $start)
    {
        $this->db->select('f.*, s.nama_staff_it, s.file_ttd_staff_it,
                      s.tanggal_ttd,
                      COALESCE(f.tanggal_revisi, f.tanggal_ajukan, s.tanggal_ttd, f.tanggal_permohonan) as sort_date')
            ->from('dc_form f')
            ->join('dc_staff s', 's.dc_form_id = f.id', 'left')
            ->where_in('f.status', ['Diteruskan ke Manager', 'Disetujui', 'Revisi Diperlukan'])
            ->order_by('sort_date', 'DESC')
            ->order_by('f.id', 'DESC')
            ->limit($limit, $start);
        return $this->db->get()->result();
    }

    // ==========================
    // === MANAGER APPROVE / REJECT
    // ==========================

    public function approve_by_manager($id, $status, $catatan = NULL)
    {
        if (!in_array($status, ['Disetujui', 'Revisi Diperlukan'])) return false;

        $this->db->select('f.*, s.nama_staff_it, s.file_ttd_staff_it');
        $this->db->from('dc_form f');
        $this->db->join('dc_staff s', 's.dc_form_id = f.id', 'left');
        $this->db->where('f.id', $id);
        $data = $this->db->get()->row();
        if (!$data) return false;

        $update = ['status' => $status];

        // === REVISI ===
        if ($status == 'Revisi Diperlukan') {
            if ($catatan) $update['catatan_manager'] = $catatan;
            $this->db->where('id', $id)->update('dc_form', $update);
            if ($catatan) {
                $this->db->insert('dc_revisi', [
                    'dc_form_id' => $id,
                    'catatan' => $catatan,
                    'tanggal_revisi' => date('Y-m-d H:i:s')
                ]);
            }
            return true;
        }

        // === DISETUJUI ===
        if ($status == 'Disetujui') {
            // GUNAKAN TANGGAL HARI INI SEBAGAI DEFAULT
            $tgl_mulai = date('Y-m-d');
            $tgl_akhir = date('Y-m-d', strtotime('+30 days')); // atau sesuaikan aturan

            $qr_path = $this->generate_qr("DC-ACCESS-{$id}-" . date('YmdHis'));
            $pdf_path = $this->generate_pdf_final($data, $qr_path, $tgl_mulai, $tgl_akhir);

            $update += [
                'file_pdf_final' => basename($pdf_path),
                'tgl_approve_manager' => date('Y-m-d'),
                'tgl_mulai_akses' => $tgl_mulai,
                'tgl_akhir_akses' => $tgl_akhir
            ];
            $this->db->where('id', $id)->update('dc_form', $update);

            $this->db->where('dc_form_id', $id)->update('dc_staff', ['status_staff_it' => 'Approved']);

            $this->send_email_approval($data, $qr_path, $tgl_mulai, $tgl_akhir, $pdf_path);

            return true;
        }
        return false;
    }

    public function count_permohonan_manager()
    {
        return $this->db->where('status', 'Diteruskan ke Manager')
            ->count_all_results('dc_form');
    }

    // Ambil data dengan limit & offset + JOIN staff
    public function get_permohonan_manager_paginated($limit, $start)
    {
        $this->db->select('f.*, s.nama_staff_it, s.file_ttd_staff_it');
        $this->db->from('dc_form f');
        $this->db->join('dc_staff s', 's.dc_form_id = f.id', 'left');
        $this->db->where('f.status', 'Diteruskan ke Manager');
        $this->db->order_by('f.tanggal_ajukan', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    // ==========================
    // === PRIVATE FUNCTIONS ====
    // ==========================

    private function generate_qr($text)
    {
        $this->load->library('ciqrcode');
        $path = FCPATH . 'uploads/qr/';
        if (!is_dir($path)) mkdir($path, 0755, true);
        $filename = 'qr_' . time() . '.png';
        $file = $path . $filename;
        QRcode::png($text, $file, QR_ECLEVEL_L, 10);
        return $file;
    }

    private function generate_pdf_final($data, $qr_path, $mulai, $akhir)
    {
        $this->load->library('pdf');
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Izin Akses Data Center - PT PELNI');
        $pdf->AddPage();

        $html = $this->load->view('data_center/pdf_final_template', [
            'data' => $data,
            'qr' => base_url('uploads/qr/' . basename($qr_path)),
            'mulai' => $mulai,
            'akhir' => $akhir
        ], true);

        $pdf->writeHTML($html, true, false, true, false, '');

        $path = FCPATH . 'uploads/pdf_final/';
        if (!is_dir($path)) mkdir($path, 0755, true);
        $filename = 'DC-FINAL-' . $data->id . '.pdf';
        $file = $path . $filename;
        $pdf->Output($file, 'F');
        return $file;
    }

    private function send_email_approval($data, $qr_path, $mulai, $akhir, $pdf_path)
    {
        $this->load->library('email');
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_user' => 'your_email@gmail.com',  // GANTI
            'smtp_pass' => 'your_app_password',     // GANTI
            'smtp_port' => 587,
            'smtp_crypto' => 'tls',
            'mailtype' => 'html',
            'charset' => 'utf-8'
        ];
        $this->email->initialize($config);

        $this->email->from('no-reply@pelni.co.id', 'Sistem Data Center PELNI');
        $this->email->to($data->email);
        $this->email->subject('Izin Akses Data Center Disetujui');
        $this->email->message($this->load->view('data_center/email_template', [
            'data' => $data,
            'qr' => base_url('uploads/qr/' . basename($qr_path)),
            'mulai' => $mulai,
            'akhir' => $akhir
        ], true));

        $this->email->attach($pdf_path);
        $this->email->attach($qr_path);
        $this->email->send();
    }
    // EMAIL APPROVE - AMAN
    private function send_email_approve_safe($id)
    {
        try {
            $permohonan = $this->db->get_where('dc_form', ['id' => $id])->row();
            if (!$permohonan || empty($permohonan->email)) return false;

            $this->email->clear(); // Bersihkan email sebelumnya
            $this->email->from('admin@pelni.com', 'Admin Data Center');
            $this->email->to($permohonan->email);
            $this->email->subject('Permohonan DISETUJUI');
            $this->email->message("
            <h3>Permohonan Anda DISETUJUI</h3>
            <p>Proyek: <strong>{$permohonan->nama_proyek}</strong></p>
            <p>Waktu: {$permohonan->waktu_proyek}</p>
            <p>Terima kasih.</p>
        ");

            return $this->email->send();
        } catch (Exception $e) {
            log_message('error', 'Email Approve Gagal: ' . $e->getMessage());
            return false;
        }
    }

    // EMAIL REVISI - AMAN
    private function send_email_revisi_safe($id, $catatan)
    {
        try {
            $permohonan = $this->db->get_where('dc_form', ['id' => $id])->row();
            if (!$permohonan || empty($permohonan->email)) return false;

            $this->email->clear();
            $this->email->from('admin@pelni.com', 'Admin Data Center');
            $this->email->to($permohonan->email);
            $this->email->subject('Revisi Diperlukan');
            $this->email->message("
            <h3>Revisi Diperlukan</h3>
            <p><strong>Catatan:</strong></p>
            <blockquote>" . nl2br(htmlspecialchars($catatan)) . "</blockquote>
            <p>Silakan perbaiki dan ajukan kembali.</p>
        ");

            return $this->email->send();
        } catch (Exception $e) {
            log_message('error', 'Email Revisi Gagal: ' . $e->getMessage());
            return false;
        }
    }
}
