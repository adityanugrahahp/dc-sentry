<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_center extends CI_Controller
{
    private $current_user;

    public function __construct()
    {
        parent::__construct();

        // Load dengan session
        $this->load->database();
        $this->load->library(['session', 'upload', 'email', 'pagination']);
        $this->load->helper(['url', 'form']);

        date_default_timezone_set('Asia/Jakarta');

        // Check auth untuk method protected
        $this->check_auth_access();
    }

    private function check_auth_access()
    {
        $current_method = $this->router->fetch_method();
        $public_methods = ['form', 'simpan_permohonan', 'get_detail', 'verify', 'fix_upload_folder', 'debug_upload_path', 'test_email', 'index'];

        // Skip auth check untuk public methods
        if (in_array($current_method, $public_methods)) {
            return;
        }

        // Check session untuk method protected
        if (!$this->session->userdata('dc_logged_in')) {
            redirect('dc-auth');
            exit;
        }

        $this->current_user = [
            'id' => $this->session->userdata('dc_id'),
            'username' => $this->session->userdata('dc_username'),
            'nama_lengkap' => $this->session->userdata('dc_nama_lengkap'),
            'role' => $this->session->userdata('dc_role'),
            'department' => $this->session->userdata('dc_department')
        ];

        // Role validation
        if ($current_method == 'index_staff' && $this->current_user['role'] != 'staff') {
            show_error('Akses Ditolak. Hanya untuk Staff IT.', 403);
            exit;
        }

        if ($current_method == 'index_manager' && $this->current_user['role'] != 'manager') {
            show_error('Akses Ditolak. Hanya untuk Manager.', 403);
            exit;
        }
    }

    private function get_current_user()
    {
        return $this->current_user;
    }

    // ======================
    // === FORM USER ===
    // ======================
    public function form()
    {
        $this->load->view('v_indexdacen');
    }

    public function index()
    {
        $this->load->view('data_center/V_datacentermg');
    }

    public function simpan_permohonan()
    {
        // Cek method
        if ($this->input->method() !== 'post') {
            show_404();
        }

        try {
            // **PROTECTION: Cek timestamp untuk prevent double submission**
            $submit_timestamp = $this->input->post('submit_timestamp');
            $current_time = time();

            // Untuk double submission protection, kita gunakan database-based check
            if ($submit_timestamp) {
                $time_diff = $current_time - ($submit_timestamp / 1000);

                // Cek jika request datang terlalu cepat (dalam 2 detik)
                if ($time_diff < 2) {
                    $request_hash = md5($submit_timestamp . $this->input->post('nama_pemohon') . $this->input->post('email'));

                    // Cek di database temporary
                    $existing = $this->db->where('hash', $request_hash)
                        ->where('created_at >', date('Y-m-d H:i:s', time() - 5))
                        ->get('dc_temp_requests')
                        ->row();

                    if ($existing) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Permohonan sedang diproses, harap tunggu...'
                        ]);
                        return;
                    }

                    // Simpan hash request ke database temporary
                    $this->db->insert('dc_temp_requests', [
                        'hash' => $request_hash,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }

            // Validasi wajib
            $required = ['nama_pemohon', 'id_karyawan', 'jabatan', 'unit_kerja', 'telepon', 'status_pegawai', 'nama_proyek', 'waktu_proyek', 'email'];
            foreach ($required as $field) {
                if (!$this->input->post($field)) {
                    echo json_encode(['status' => 'error', 'message' => "$field wajib diisi"]);
                    return;
                }
            }

            // **PROTECTION: Cek duplikat data berdasarkan nama dan proyek dalam 5 menit terakhir**
            $recent_duplicate = $this->db
                ->where('nama_pemohon', $this->input->post('nama_pemohon'))
                ->where('nama_proyek', $this->input->post('nama_proyek'))
                ->where('tanggal_permohonan', date('Y-m-d'))
                ->where('status', 'Menunggu Approval')
                ->order_by('id', 'DESC')
                ->get('dc_form')
                ->row();

            if ($recent_duplicate) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Anda sudah mengajukan permohonan dengan nama dan proyek yang sama hari ini. Silakan tunggu proses verifikasi.'
                ]);
                return;
            }

            // Upload KTP
            $ktp_path = '';
            if (isset($_FILES['ktp']) && $_FILES['ktp']['error'] == 0) {
                $upload_dir = FCPATH . 'uploads/ktp/';

                // Pastikan folder ada
                if (!is_dir($upload_dir)) {
                    if (!mkdir($upload_dir, 0755, true)) {
                        echo json_encode(['status' => 'error', 'message' => 'Gagal membuat folder upload KTP']);
                        return;
                    }
                }

                $file_name = $_FILES['ktp']['name'];
                $file_tmp = $_FILES['ktp']['tmp_name'];
                $file_size = $_FILES['ktp']['size'];
                $file_error = $_FILES['ktp']['error'];

                // Validasi file type
                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                $file_type = mime_content_type($file_tmp);

                if (!in_array($file_type, $allowed_types)) {
                    echo json_encode(['status' => 'error', 'message' => 'Format file KTP tidak didukung. Gunakan JPG, PNG, atau PDF.']);
                    return;
                }

                // Validasi file size (max 2MB)
                if ($file_size > 2 * 1024 * 1024) {
                    echo json_encode(['status' => 'error', 'message' => 'Ukuran file KTP maksimal 2MB']);
                    return;
                }

                // Generate unique filename
                $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
                $new_filename = 'ktp_' . uniqid() . '_' . time() . '.' . $file_extension;
                $file_path = $upload_dir . $new_filename;

                // Move uploaded file
                if (move_uploaded_file($file_tmp, $file_path)) {
                    $ktp_path = $new_filename;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan file KTP. Pastikan folder upload memiliki permission yang tepat.']);
                    return;
                }
            } else {
                $upload_error = isset($_FILES['ktp']) ? $_FILES['ktp']['error'] : 'No file';
                echo json_encode(['status' => 'error', 'message' => 'KTP wajib diupload']);
                return;
            }

            // Upload TTD Pemohon
            $ttd_file = null;
            if (isset($_FILES['ttd_pemohon']) && $_FILES['ttd_pemohon']['error'] == 0) {
                $upload_dir = FCPATH . 'uploads/ttd_pemohon/';

                // Pastikan folder ada
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                $file_name = $_FILES['ttd_pemohon']['name'];
                $file_tmp = $_FILES['ttd_pemohon']['tmp_name'];
                $file_size = $_FILES['ttd_pemohon']['size'];
                $file_error = $_FILES['ttd_pemohon']['error'];

                // Daftar format yang diizinkan
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'p7s', 'p7m', 'sig', 'asc', 'gpg', 'xades', 'cades', 'pades'];
                $allowed_mime_types = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'application/pdf',
                    'application/pkcs7-signature',
                    'application/pkcs7-mime',
                    'application/pgp-signature',
                    'application/pgp-keys',
                    'application/x-pkcs7-signature',
                    'application/x-pkcs7-mime'
                ];

                $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $file_mime_type = mime_content_type($file_tmp);

                // Validasi extension dan MIME type
                if (!in_array($file_extension, $allowed_extensions) && !in_array($file_mime_type, $allowed_mime_types)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Format file tanda tangan tidak didukung. Gunakan JPG, PNG, PDF, atau format tanda tangan digital (P7S, P7M, SIG, ASC, GPG, XAdES, CAdES, PAdES).'
                    ]);
                    return;
                }

                // Validasi ukuran file (max 2MB)
                if ($file_size > 2 * 1024 * 1024) {
                    echo json_encode(['status' => 'error', 'message' => 'Ukuran file tanda tangan maksimal 2MB']);
                    return;
                }

                // Generate unique filename dengan extension asli
                $new_filename = 'ttd_' . uniqid() . '_' . time() . '.' . $file_extension;
                $file_path = $upload_dir . $new_filename;

                // Move uploaded file
                if (move_uploaded_file($file_tmp, $file_path)) {
                    $ttd_file = $new_filename;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan file tanda tangan. Pastikan folder upload memiliki permission yang tepat.']);
                    return;
                }
            } else {
                $upload_error = isset($_FILES['ttd_pemohon']) ? $_FILES['ttd_pemohon']['error'] : 'No file';
                echo json_encode(['status' => 'error', 'message' => 'Tanda tangan wajib diupload']);
                return;
            }

            // Handle multiple dokumen tambahan
            $dokumen_tambahan = [];
            if (isset($_FILES['dokumen_tambahan']) && !empty($_FILES['dokumen_tambahan']['name'][0])) {
                $dokumen_files = $_FILES['dokumen_tambahan'];
                $total_dokumen = $this->input->post('total_dokumen') ?? count($dokumen_files['name']);

                $upload_dir = FCPATH . 'uploads/dokumen_tambahan/';

                // Pastikan folder ada
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                // Loop melalui setiap file
                for ($i = 0; $i < $total_dokumen; $i++) {
                    if (isset($dokumen_files['name'][$i]) && $dokumen_files['error'][$i] == 0) {
                        $file_name = $dokumen_files['name'][$i];
                        $file_tmp = $dokumen_files['tmp_name'][$i];
                        $file_size = $dokumen_files['size'][$i];

                        // Validasi file type
                        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                        $file_type = mime_content_type($file_tmp);

                        if (!in_array($file_type, $allowed_types)) {
                            continue;
                        }

                        // Validasi file size (max 2MB)
                        if ($file_size > 2 * 1024 * 1024) {
                            continue;
                        }

                        // Generate unique filename
                        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
                        $new_filename = 'dokumen_' . uniqid() . '_' . $i . '.' . $file_extension;
                        $file_path = $upload_dir . $new_filename;

                        // Move uploaded file
                        if (move_uploaded_file($file_tmp, $file_path)) {
                            $nama_dokumen = $this->input->post("nama_dokumen[{$i}]") ?? pathinfo($file_name, PATHINFO_FILENAME);

                            $dokumen_tambahan[] = [
                                'nama' => $nama_dokumen,
                                'file_path' => $new_filename,
                                'original_name' => $file_name
                            ];
                        }
                    }
                }
            }

            // Data insert
            $data = [
                'nama_pemohon'       => $this->input->post('nama_pemohon'),
                'id_karyawan'        => $this->input->post('id_karyawan'),
                'jabatan'            => $this->input->post('jabatan'),
                'unit_kerja'         => $this->input->post('unit_kerja'),
                'telepon'            => $this->input->post('telepon'),
                'fax'                => $this->input->post('fax'),
                'status_pegawai'     => $this->input->post('status_pegawai'),
                'nama_perusahaan'    => $this->input->post('nama_perusahaan'),
                'alamat'             => $this->input->post('alamat'),
                'email'              => $this->input->post('email'),
                'contact_person'     => is_array($this->input->post('contact_person'))
                    ? implode(', ', $this->input->post('contact_person'))
                    : $this->input->post('contact_person'),
                'nama_proyek'        => $this->input->post('nama_proyek'),
                'waktu_proyek'       => $this->input->post('waktu_proyek'),
                'file_ttd_pemohon'   => $ttd_file,
                'ktp_path'           => $ktp_path,
                'dokumen_tambahan'   => !empty($dokumen_tambahan) ? json_encode($dokumen_tambahan) : null,
                'tanggal_permohonan' => date('Y-m-d'),
                'status'             => 'Menunggu Approval'
            ];

            // Simpan ke database
            $insert_success = $this->db->insert('dc_form', $data);

            if ($insert_success) {
                $insert_id = $this->db->insert_id();

                // **KIRIM EMAIL KONFIRMASI SUBMIT**
                $email_sent = $this->send_email_submit_success($insert_id, $data);

                if (!$email_sent) {
                    log_message('error', 'Gagal mengirim email konfirmasi untuk ID: ' . $insert_id);
                }

                echo json_encode([
                    'status' => 'success',
                    'id' => $insert_id,
                    'message' => 'Permohonan berhasil dikirim! ID: DC-' . sprintf("%04d", $insert_id)
                ]);
            } else {
                $error = $this->db->error();
                log_message('error', 'Insert dc_form gagal: ' . $error['message']);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan data: ' . $error['message']
                ]);
            }
        } catch (Exception $e) {
            log_message('error', 'Exception in simpan_permohonan: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

    // ======================
    // === STAFF IT ===
    // ======================
    public function index_staff()
    {
        $user = $this->get_current_user();

        $this->load->library('pagination');

        // FILTER STATUS
        $status_filter = $this->input->get('status');

        // **AMBIL SEMUA DATA TANPA PAGINATION DI QUERY - SAMA DENGAN MANAGER**
        $this->db->select('f.*, s.nama_staff_it, s.file_ttd_staff, s.tanggal_ttd, f.file_pdf_final')
            ->from('dc_form f')
            ->join('dc_staff s', 's.dc_form_id = f.id', 'left')
            ->where_in('f.status', ['Menunggu Approval', 'Diteruskan ke Manager', 'Revisi Diperlukan', 'Disetujui']);

        // APPLY FILTER JIKA ADA
        if ($status_filter) {
            $this->db->where('f.status', $status_filter);
        }

        $this->db->order_by('f.id', 'DESC');

        $all_permohonan = $this->db->get()->result();

        // **HITUNG TOTAL UNTUK FILTER - SAMA DENGAN MANAGER**
        $count_all = count($all_permohonan);

        // Hitung per status
        $count_menunggu = 0;
        $count_diajukan = 0;
        $count_revisi = 0;
        $count_disetujui = 0;

        foreach ($all_permohonan as $p) {
            if ($p->status == 'Menunggu Approval') {
                $count_menunggu++;
            } elseif ($p->status == 'Diteruskan ke Manager') {
                $count_diajukan++;
            } elseif ($p->status == 'Revisi Diperlukan') {
                $count_revisi++;
            } elseif ($p->status == 'Disetujui') {
                $count_disetujui++;
            }
        }

        // **SETUP PAGINATION MANUAL - SAMA DENGAN MANAGER**
        $config['base_url'] = site_url('data_center/index_staff');
        $config['total_rows'] = count($all_permohonan);
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['reuse_query_string'] = TRUE; // Penting untuk menjaga parameter filter

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        // **AMBIL DATA UNTUK HALAMAN SAAT INI - SAMA DENGAN MANAGER**
        $permohonan = array_slice($all_permohonan, $page, $config['per_page']);

        $data = [
            'permohonan' => $permohonan,
            'pagination_permohonan' => $this->pagination->create_links(),
            'user' => $user,
            'status_filter' => $status_filter,
            'count_all' => $count_all,
            'count_menunggu' => $count_menunggu,
            'count_diajukan' => $count_diajukan,
            'count_revisi' => $count_revisi,
            'count_disetujui' => $count_disetujui,
        ];

        $this->load->view('data_center/V_datacenterit', $data);
    }

    public function ajukan()
    {
        if ($this->input->method() !== 'post') {
            echo json_encode(['status' => 'error', 'message' => 'Invalid method']);
            return;
        }

        try {
            $id = $this->input->post('id');
            $nama_staff = $this->input->post('nama_staff');
            $tanggal_berlaku = $this->input->post('tanggal_berlaku');
            $jam_mulai = $this->input->post('jam_mulai');
            $jam_selesai = $this->input->post('jam_selesai');
            $durasi_akses = $this->input->post('durasi_akses');

            // Validasi field
            if (!$id || !$nama_staff || !$tanggal_berlaku || !$jam_mulai || !$jam_selesai) {
                echo json_encode(['status' => 'error', 'message' => 'Lengkapi semua field!']);
                return;
            }

            if (empty($_FILES['tanda_tangan']['name'])) {
                echo json_encode(['status' => 'error', 'message' => 'File tanda tangan wajib diupload!']);
                return;
            }

            // Upload file
            $upload_dir = FCPATH . 'uploads/tanda_tangan/';

            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0755, true)) {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal membuat folder upload']);
                    return;
                }
            }

            $file = $_FILES['tanda_tangan'];
            $max_size = 2 * 1024 * 1024;

            // Validasi format file
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'p7s', 'p7m', 'sig', 'asc', 'gpg', 'xades', 'cades', 'pades'];
            $allowed_mime_types = [
                'image/jpeg',
                'image/jpg',
                'image/png',
                'application/pdf',
                'application/pkcs7-signature',
                'application/pkcs7-mime',
                'application/pgp-signature',
                'application/pgp-keys',
                'application/x-pkcs7-signature',
                'application/x-pkcs7-mime'
            ];

            $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $file_mime_type = mime_content_type($file['tmp_name']);

            if (!in_array($file_extension, $allowed_extensions) && !in_array($file_mime_type, $allowed_mime_types)) {
                echo json_encode(['status' => 'error', 'message' => 'Format file tidak didukung']);
                return;
            }

            if ($file['size'] > $max_size) {
                echo json_encode(['status' => 'error', 'message' => 'Ukuran file maksimal 2MB.']);
                return;
            }

            // Generate unique filename
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . $ext;
            $filepath = $upload_dir . $filename;

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                // File berhasil diupload - lanjut ke database
                $staff_data = [
                    'dc_form_id'        => $id,
                    'nama_staff_it'     => $nama_staff,
                    'file_ttd_staff_it' => $filename,
                    'tanggal_ttd'       => date('Y-m-d H:i:s'),
                    'status_staff_it'   => 'Diajukan',
                    'tanggal_berlaku'   => $tanggal_berlaku,
                    'jam_mulai'         => $jam_mulai,
                    'jam_selesai'       => $jam_selesai,
                    'durasi_akses'      => $durasi_akses
                ];

                $insert_staff = $this->db->insert('dc_staff', $staff_data);

                $form_data = [
                    'status' => 'Diteruskan ke Manager',
                    'tanggal_ajukan' => date('Y-m-d H:i:s'),
                    'tanggal_berlaku' => $tanggal_berlaku,
                    'jam_mulai' => $jam_mulai,
                    'jam_selesai' => $jam_selesai,
                    'durasi_akses' => $durasi_akses
                ];

                $update_form = $this->db->where('id', $id)->update('dc_form', $form_data);

                if ($insert_staff && $update_form) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Berhasil diajukan ke Manager!',
                        'tgl_ajukan' => date('d/m/Y')
                    ]);
                } else {
                    // Rollback: hapus file
                    @unlink($filepath);
                    $error = $this->db->error();
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data: ' . $error['message']]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal upload file.']);
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

    public function revisi()
    {
        if ($this->input->method() !== 'post') show_404();

        $id = $this->input->post('id');
        $catatan = trim($this->input->post('catatan'));
        $oleh = $this->input->post('oleh');

        if (!$id || !$catatan || !$oleh) {
            return $this->output->set_status_header(400)->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Lengkapi data!']));
        }

        if (!in_array($oleh, ['Staff IT', 'Manager'])) {
            return $this->output->set_status_header(400)->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Pengirim tidak valid!']));
        }

        $form = $this->db->get_where('dc_form', ['id' => $id])->row();
        if (!$form) {
            return $this->output->set_status_header(404)->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Permohonan tidak ditemukan!']));
        }

        // IZINKAN REVISI DARI Menunggu Approval ATAU Revisi Diperlukan
        if (!in_array($form->status, ['Menunggu Approval', 'Revisi Diperlukan']) && $oleh === 'Staff IT') {
            return $this->output->set_status_header(400)->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Hanya status "Menunggu Approval" atau "Revisi Diperlukan" yang bisa direvisi oleh Staff!'
                ]));
        }

        // INSERT CATATAN REVISI
        $this->db->insert('dc_revisi', [
            'dc_form_id' => $id,
            'catatan' => $catatan,
            'oleh' => $oleh,
            'tanggal_revisi' => date('Y-m-d H:i:s')
        ]);

        $this->db->where('id', $id)->update('dc_form', [
            'status' => 'Revisi Diperlukan',
            'tanggal_revisi' => date('Y-m-d H:i:s')
        ]);

        // **KIRIM EMAIL REVISI**
        if ($form && $catatan) {
            $email_sent = $this->send_email_rejected($form, $catatan);
        }

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Revisi berhasil dikirim!',
                'tgl_revisi' => date('d/m/Y H:i')
            ]));
    }

    public function get_detail($id)
    {
        $this->db->select('f.*, s.file_ttd_staff_it, s.nama_staff_it, s.tanggal_berlaku, s.jam_mulai, s.jam_selesai, s.durasi_akses')
            ->from('dc_form f')
            ->join('dc_staff s', 's.dc_form_id = f.id', 'left')
            ->where('f.id', $id);

        $p = $this->db->get()->row();

        if (!$p) {
            echo json_encode(null);
            return;
        }

        // Decode dokumen tambahan
        $dokumen_tambahan = [];
        if (!empty($p->dokumen_tambahan)) {
            $dokumen_tambahan = json_decode($p->dokumen_tambahan, true);
        }

        // Format response dengan data baru
        $response = [
            'nama_pemohon'    => $p->nama_pemohon,
            'id_karyawan'     => $p->id_karyawan,
            'jabatan'         => $p->jabatan,
            'unit_kerja'      => $p->unit_kerja,
            'telepon'         => $p->telepon,
            'fax'             => $p->fax,
            'status_pegawai'  => $p->status_pegawai,
            'nama_perusahaan' => $p->nama_perusahaan,
            'alamat'          => $p->alamat,
            'email'           => $p->email,
            'contact_person'  => $p->contact_person,
            'nama_proyek'     => $p->nama_proyek,
            'waktu_proyek'    => $p->waktu_proyek,
            'file_ttd_pemohon' => $p->file_ttd_pemohon,
            'file_ttd_staff'  => $p->file_ttd_staff_it,
            'ktp_path'        => $p->ktp_path,
            'dokumen_tambahan' => $dokumen_tambahan,
            'tanggal_permohonan' => $p->tanggal_permohonan,
            'status'          => $p->status,
            // Tambahan data durasi
            'tanggal_berlaku' => $p->tanggal_berlaku,
            'jam_mulai'       => $p->jam_mulai,
            'jam_selesai'     => $p->jam_selesai,
            'durasi_akses'    => $p->durasi_akses
        ];

        echo json_encode($response);
    }

    /// ======================
    // === MANAGER ===
    // ======================
    public function index_manager()
    {
        $user = $this->get_current_user();

        $this->load->library('pagination');

        // FILTER STATUS
        $status_filter = $this->input->get('status');

        // AMBIL SEMUA DATA TANPA PAGINATION DI QUERY
        $this->db->select('f.*, s.nama_staff_it, s.file_ttd_staff, s.tanggal_ttd')
            ->from('dc_form f')
            ->join('dc_staff s', 's.dc_form_id = f.id', 'left')
            ->where_in('f.status', ['Diteruskan ke Manager', 'Disetujui', 'Revisi Diperlukan']);

        // APPLY FILTER JIKA ADA
        if ($status_filter) {
            $this->db->where('f.status', $status_filter);
        }

        $this->db->order_by('f.id', 'DESC');

        $all_permohonan = $this->db->get()->result();

        // SORTING MANUAL - BERDASARKAN TIMESTAMP TERAKHIR AKTIVITAS STAFF
        usort($all_permohonan, function ($a, $b) {
            $timestampA = $this->get_last_activity_timestamp($a);
            $timestampB = $this->get_last_activity_timestamp($b);
            return $timestampB - $timestampA; // DESC: terbaru dulu
        });

        // HITUNG TOTAL UNTUK FILTER
        $count_all = count($all_permohonan);

        // Hitung per status
        $count_diajukan = 0;
        $count_disetujui = 0;
        $count_revisi = 0;

        foreach ($all_permohonan as $p) {
            if ($p->status == 'Diteruskan ke Manager') {
                $count_diajukan++;
            } elseif ($p->status == 'Disetujui') {
                $count_disetujui++;
            } elseif ($p->status == 'Revisi Diperlukan') {
                $count_revisi++;
            }
        }

        // SETUP PAGINATION MANUAL
        $config['base_url'] = site_url('data_center/index_manager');
        $config['total_rows'] = count($all_permohonan);
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['reuse_query_string'] = TRUE; // Penting untuk menjaga parameter filter

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        // AMBIL DATA UNTUK HALAMAN SAAT INI
        $permohonan = array_slice($all_permohonan, $page, $config['per_page']);

        $data = [
            'permohonan' => $permohonan,
            'pagination_permohonan' => $this->pagination->create_links(),
            'user' => $user,
            'status_filter' => $status_filter,
            'count_all' => $count_all,
            'count_diajukan' => $count_diajukan,
            'count_disetujui' => $count_disetujui,
            'count_revisi' => $count_revisi,
        ];

        $this->load->view('data_center/V_datacentermg', $data);
    }

    // HELPER FUNCTION - DAPATKAN TIMESTAMP AKTIVITAS TERAKHIR STAFF
    private function get_last_activity_timestamp($data)
    {
        $timestamps = [];

        // Tanggal revisi (aktivitas staff terbaru)
        if (!empty($data->tanggal_revisi)) {
            $timestamps[] = strtotime($data->tanggal_revisi);
        }

        // Tanggal pengajuan ke manager (aktivitas staff) 
        if (!empty($data->tanggal_ajukan)) {
            $timestamps[] = strtotime($data->tanggal_ajukan);
        }

        // Tanggal TTD staff (aktivitas staff)
        if (!empty($data->tanggal_ttd)) {
            $timestamps[] = strtotime($data->tanggal_ttd);
        }

        // Jika ada aktivitas staff, ambil yang TERBARU
        if (!empty($timestamps)) {
            return max($timestamps);
        }

        // Fallback ke tanggal permohonan (jika tidak ada aktivitas staff)
        return !empty($data->tanggal_permohonan) ? strtotime($data->tanggal_permohonan) : 0;
    }

    public function approve_manager()
    {
        if ($this->input->method() !== 'post') show_404();

        $id = $this->input->post('id');
        $nama_manager = $this->input->post('nama_manager') ?: 'Manager IT';

        // Insert ke dc_manager
        $this->db->insert('dc_manager', [
            'dc_form_id' => $id,
            'nama_manager' => $nama_manager,
            'tanggal_approve' => date('Y-m-d H:i:s'),
            'keputusan' => 'Disetujui'
        ]);

        // Update dc_form
        $this->db->where('id', $id)->update('dc_form', [
            'status' => 'Disetujui',
            'tgl_approve_manager' => date('Y-m-d H:i:s')
        ]);

        // **KIRIM EMAIL APPROVAL**
        $permohonan = $this->db->get_where('dc_form', ['id' => $id])->row();
        if ($permohonan) {
            $email_sent = $this->send_email_approved($permohonan);
        }

        echo json_encode([
            'status' => 'success',
            'tgl_approve' => date('d/m/Y')
        ]);
    }

    public function reject_manager()
    {
        $input = json_decode($this->input->raw_input_stream, true);
        $id = $input['id'] ?? null;
        $alasan = $input['alasan'] ?? null;

        if (!$id || !$alasan) {
            echo json_encode(['status' => 'error', 'message' => 'ID dan alasan wajib']);
            return;
        }

        $this->db->insert('dc_revisi', [
            'dc_form_id' => $id,
            'catatan' => $alasan,
            'tanggal_revisi' => date('Y-m-d'),
            'oleh' => 'Manager'
        ]);

        $this->db->where('id', $id)->update('dc_form', [
            'status' => 'Revisi Diperlukan',
            'tanggal_revisi' => date('Y-m-d')
        ]);

        // Update dc_manager (opsional)
        $this->db->where('dc_form_id', $id)->update('dc_manager', [
            'keputusan' => 'Ditolak',
            'catatan_manager' => $alasan
        ]);

        // **KIRIM EMAIL REVISI**
        $permohonan = $this->db->get_where('dc_form', ['id' => $id])->row();
        if ($permohonan && $alasan) {
            $email_sent = $this->send_email_rejected($permohonan, $alasan);
        }

        echo json_encode(['status' => 'success']);
    }

    public function export_excel()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (ob_get_level()) ob_clean();

        require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Data Center System");
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setTitle('Permohonan');

        $headers = ['No', 'Nama Pemohon', 'Unit Kerja', 'Proyek', 'Tanggal Permohonan', 'Status', 'Tanggal Status'];
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '1', $h);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getStyle($col . '1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setRGB('004080');
            $sheet->getStyle($col . '1')->getFont()->getColor()->setRGB('FFFFFF');
            $col++;
        }

        $this->db->select('f.*, f.tanggal_ajukan, f.tanggal_revisi, f.tanggal_approve');
        $this->db->from('dc_form f');
        $this->db->join('dc_staff s', 's.dc_form_id = f.id', 'left');
        $this->db->where_in('f.status', ['Menunggu Approval', 'Diteruskan ke Manager', 'Revisi Diperlukan', 'Disetujui']);
        $this->db->order_by('f.id', 'DESC');
        $permohonan = $this->db->get()->result();

        $row = 2;
        foreach ($permohonan as $i => $p) {
            $status = $p->status;
            $tanggal_status = '-';

            if ($status == 'Diteruskan ke Manager' && $p->tanggal_ajukan) {
                $status = 'Diajukan';
                $tanggal_status = date('d/m/Y', strtotime($p->tanggal_ajukan));
            } elseif ($status == 'Revisi Diperlukan' && $p->tanggal_revisi) {
                $status = 'Revisi';
                $tanggal_status = date('d/m/Y', strtotime($p->tanggal_revisi));
            } elseif ($status == 'Disetujui' && $p->tanggal_approve) {
                $status = 'Disetujui';
                $tanggal_status = date('d/m/Y', strtotime($p->tanggal_approve));
            } else {
                $status = 'Menunggu';
            }

            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $p->nama_pemohon);
            $sheet->setCellValue('C' . $row, $p->unit_kerja);
            $sheet->setCellValue('D' . $row, $p->nama_proyek);
            $sheet->setCellValue('E' . $row, date('d/m/Y', strtotime($p->tanggal_permohonan)));
            $sheet->setCellValue('F' . $row, $status);
            $sheet->setCellValue('G' . $row, $tanggal_status);
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = "Permohonan_Akses_DC_" . date('Ymd') . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function get_revisi($id)
    {
        $this->db->select('catatan, DATE(tanggal_revisi) as tanggal_revisi, oleh');
        $this->db->where('dc_form_id', $id);
        $this->db->order_by('tanggal_revisi', 'DESC');
        $data = $this->db->get('dc_revisi')->result_array();
        echo json_encode($data);
    }

    public function verify($id)
    {
        $data = $this->db->get_where('dc_form', ['id' => $id, 'status' => 'Disetujui'])->row();
        if ($data) {
            echo "<h2 style='color:green'>Izin Akses SAH</h2>
                <p><strong>Nama:</strong> {$data->nama_pemohon}<br>
                <strong>Proyek:</strong> {$data->nama_proyek}<br>
                <strong>Waktu:</strong> {$data->waktu_proyek}</p>";
        } else {
            echo "<h2 style='color:red'>Izin TIDAK SAH</h2>";
        }
    }
    public function fix_upload_folder()
    {
        echo "<h3>Fix Upload Folder</h3>";

        $folders = [
            FCPATH . 'uploads/',
            FCPATH . 'uploads/tanda_tangan/',
            FCPATH . 'uploads/ttd_pemohon/',
            FCPATH . 'uploads/pdf_final/',
            FCPATH . 'uploads/qr/'
        ];

        foreach ($folders as $folder) {
            echo "<b>Folder: " . str_replace(FCPATH, '', $folder) . "</b><br>";

            if (!is_dir($folder)) {
                echo "- ❌ Tidak ada<br>";
                echo "- 🔧 Membuat folder... ";
                $created = mkdir($folder, 0755, true);
                echo $created ? "✅ Berhasil" : "❌ Gagal";
                echo "<br>";
            } else {
                echo "- ✅ Ada<br>";
            }

            echo "- 📝 Writable: " . (is_writable($folder) ? "✅ Ya" : "❌ Tidak") . "<br>";

            // Coba buat test file
            $test_file = $folder . 'test.txt';
            $test = @file_put_contents($test_file, 'test');
            echo "- ✏️  Bisa tulis file: " . ($test ? "✅ Ya" : "❌ Tidak") . "<br>";

            if ($test) {
                unlink($test_file);
            }

            echo "<br>";
        }

        echo "<hr>";
        echo "<b>FCPATH:</b> " . FCPATH . "<br>";
        echo "<b>BASEPATH:</b> " . BASEPATH . "<br>";
        echo "<b>APPPATH:</b> " . APPPATH . "<br>";
        echo "<b>Current Dir:</b> " . getcwd() . "<br>";
    }
    public function debug_upload_path()
    {
        echo "<h3>Upload Path Debug</h3>";

        // Relative path (yang seharusnya digunakan)
        $relative_path = './uploads/tanda_tangan/';
        echo "<b>Relative Path:</b> " . $relative_path . "<br>";
        echo "<b>Relative Path exists:</b> " . (is_dir($relative_path) ? '✅ YES' : '❌ NO') . "<br>";

        if (is_dir($relative_path)) {
            echo "<b>Writable:</b> " . (is_writable($relative_path) ? '✅ YES' : '❌ NO') . "<br>";
        }

        echo "<hr>";

        // Absolute paths
        $paths = [
            'FCPATH' => FCPATH,
            'getcwd()' => getcwd(),
            'DOCUMENT_ROOT' => $_SERVER['DOCUMENT_ROOT'] ?? 'Not set'
        ];

        foreach ($paths as $name => $path) {
            echo "<b>$name:</b> " . htmlspecialchars($path) . "<br>";
        }

        echo "<hr><h4>Test File Upload Config</h4>";

        $config = [
            'upload_path'   => './uploads/tanda_tangan/',
            'allowed_types' => 'jpg|jpeg|png|pdf|p7s|p7m|sig|asc|gpg|xades|cades|pades', // ← DIPERBARUI
            'max_size'      => 2048,
            'encrypt_name'  => true,
        ];

        $this->load->library('upload', $config);

        echo "<b>Upload Path in Library:</b> " . $this->upload->upload_path . "<br>";
        echo "<b>Upload Path exists:</b> " . (is_dir($this->upload->upload_path) ? '✅ YES' : '❌ NO') . "<br>";
        echo "<b>Upload Path writable:</b> " . (is_writable($this->upload->upload_path) ? '✅ YES' : '❌ NO') . "<br>";
    }
    // Tambahkan di Data_center.php controller atau buat controller baru
    public function preview_file($folder, $filename)
    {
        $allowed_folders = ['ktp', 'ttd_pemohon', 'tanda_tangan', 'dokumen_tambahan'];

        if (!in_array($folder, $allowed_folders)) {
            show_404();
        }

        $file_path = FCPATH . "uploads/{$folder}/{$filename}";

        if (!file_exists($file_path)) {
            show_404();
        }

        // Get file mime type
        $mime_type = mime_content_type($file_path);

        // Set header berdasarkan tipe file
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($file_path));
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        readfile($file_path);
        exit;
    }

    public function download_detail_txt($id)
    {
        try {
            // Ambil data permohonan
            $this->db->select('f.*, s.nama_staff_it, s.file_ttd_staff_it, s.tanggal_berlaku, s.jam_mulai, s.jam_selesai, s.durasi_akses')
                ->from('dc_form f')
                ->join('dc_staff s', 's.dc_form_id = f.id', 'left')
                ->where('f.id', $id);

            $permohonan = $this->db->get()->row();

            if (!$permohonan) {
                show_404();
            }

            // Format nama file: nama_pemohon_nama_proyek_tanggal_permohonan.txt
            $filename = str_replace(' ', '_', $permohonan->nama_pemohon) . '_' .
                str_replace(' ', '_', $permohonan->nama_proyek) . '_' .
                date('Y-m-d', strtotime($permohonan->tanggal_permohonan)) . '.txt';

            // Header untuk download
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');

            // Generate content TXT
            $content = "DETAIL PERMOHONAN AKSES DATA CENTER PT PELNI\n";
            $content .= "===============================================\n\n";

            // Data Pemohon
            $content .= "DATA PEMOHON:\n";
            $content .= "-------------\n";
            $content .= "Nama Lengkap     : " . ($permohonan->nama_pemohon ?? '-') . "\n";
            $content .= "NIP/NIK/ID       : " . ($permohonan->id_karyawan ?? '-') . "\n";
            $content .= "Jabatan          : " . ($permohonan->jabatan ?? '-') . "\n";
            $content .= "Unit Kerja       : " . ($permohonan->unit_kerja ?? '-') . "\n";
            $content .= "Telepon          : " . ($permohonan->telepon ?? '-') . "\n";
            $content .= "Fax              : " . ($permohonan->fax ?? '-') . "\n";
            $content .= "Status Pegawai   : " . ($permohonan->status_pegawai ?? '-') . "\n";
            $content .= "Perusahaan       : " . ($permohonan->nama_perusahaan ?? '-') . "\n";
            $content .= "Alamat           : " . ($permohonan->alamat ?? '-') . "\n";
            $content .= "Email            : " . ($permohonan->email ?? '-') . "\n";
            $content .= "Contact Person   : " . ($permohonan->contact_person ?? '-') . "\n\n";

            // Data Proyek
            $content .= "DATA PROYEK:\n";
            $content .= "------------\n";
            $content .= "Nama Proyek      : " . ($permohonan->nama_proyek ?? '-') . "\n";
            $content .= "Waktu Proyek     : " . ($permohonan->waktu_proyek ?? '-') . "\n";
            $content .= "Tanggal Permohonan : " . ($permohonan->tanggal_permohonan ? date('d/m/Y', strtotime($permohonan->tanggal_permohonan)) : '-') . "\n\n";

            // Data Akses
            if (!empty($permohonan->tanggal_berlaku)) {
                $content .= "DATA AKSES YANG DISETUJUI:\n";
                $content .= "--------------------------\n";
                $content .= "Tanggal Berlaku  : " . ($permohonan->tanggal_berlaku ? date('d/m/Y', strtotime($permohonan->tanggal_berlaku)) : '-') . "\n";
                $content .= "Jam Mulai        : " . ($permohonan->jam_mulai ?? '-') . "\n";
                $content .= "Jam Selesai      : " . ($permohonan->jam_selesai ?? '-') . "\n";
                $content .= "Durasi Akses     : " . ($permohonan->durasi_akses ?? '-') . "\n\n";
            }

            // Status dan Timeline
            $content .= "STATUS PERMOHONAN:\n";
            $content .= "------------------\n";
            $content .= "Status           : " . ($permohonan->status ?? '-') . "\n";

            if (!empty($permohonan->tanggal_ajukan)) {
                $content .= "Tanggal Diajukan  : " . date('d/m/Y', strtotime($permohonan->tanggal_ajukan)) . "\n";
            }

            if (!empty($permohonan->tgl_approve_manager)) {
                $content .= "Tanggal Disetujui : " . date('d/m/Y', strtotime($permohonan->tgl_approve_manager)) . "\n";
            }

            if (!empty($permohonan->tanggal_revisi)) {
                $content .= "Tanggal Revisi    : " . date('d/m/Y', strtotime($permohonan->tanggal_revisi)) . "\n";
            }

            // Staff IT yang menangani
            if (!empty($permohonan->nama_staff_it)) {
                $content .= "Staff IT          : " . $permohonan->nama_staff_it . "\n";
            }

            $content .= "\n";

            // Dokumen
            $content .= "DOKUMEN:\n";
            $content .= "--------\n";
            $content .= "KTP               : " . (!empty($permohonan->ktp_path) ? "Ada" : "Tidak Ada") . "\n";
            $content .= "TTD Pemohon       : " . (!empty($permohonan->file_ttd_pemohon) ? "Ada" : "Tidak Ada") . "\n";
            $content .= "TTD Staff IT      : " . (!empty($permohonan->file_ttd_staff_it) ? "Ada" : "Tidak Ada") . "\n";

            // Dokumen tambahan
            if (!empty($permohonan->dokumen_tambahan)) {
                $dokumen_tambahan = json_decode($permohonan->dokumen_tambahan, true);
                if (is_array($dokumen_tambahan) && count($dokumen_tambahan) > 0) {
                    $content .= "Dokumen Tambahan  : " . count($dokumen_tambahan) . " file\n";
                    foreach ($dokumen_tambahan as $index => $dok) {
                        $content .= "  - " . ($dok['nama'] ?? 'Dokumen ' . ($index + 1)) . "\n";
                    }
                }
            }

            $content .= "\n";
            $content .= "===============================================\n";
            $content .= "Generated on: " . date('d/m/Y H:i:s') . "\n";
            $content .= "System: Data Center PT PELNI\n";

            // Output content
            echo $content;
            exit;
        } catch (Exception $e) {
            log_message('error', 'Download TXT error: ' . $e->getMessage());
            show_404();
        }
    }

    // ======================
    // === EMAIL METHODS ===
    // ======================

    private function send_email_notification($to, $subject, $title, $content)
    {
        try {
            $this->load->library('email');

            $email_template = "
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #004080; color: white; padding: 20px; text-align: center; }
                        .content { background: #f9f9f9; padding: 20px; border-radius: 5px; }
                        .footer { margin-top: 20px; padding: 20px; background: #f1f1f1; text-align: center; font-size: 12px; }
                        .status-box { background: #e8f5e8; border: 1px solid #c3e6c3; padding: 15px; border-radius: 5px; margin: 15px 0; }
                        .rejection-box { background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px; margin: 15px 0; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>PT PELNI (Persero)</h2>
                            <h3>Data Center Access System</h3>
                        </div>
                        <div class='content'>
                            <h4>$title</h4>
                            $content
                        </div>
                        <div class='footer'>
                            <p><strong>Tim Teknologi Informasi</strong><br>
                            PT PELNI (Persero)<br>
                            Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";

            $this->email->from('adityanugrahap23@gmail.com', 'Data Center PT PELNI');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($email_template);

            if ($this->email->send()) {
                log_message('info', 'Email berhasil dikirim ke: ' . $to);
                return true;
            } else {
                log_message('error', 'Gagal mengirim email: ' . $this->email->print_debugger());
                return false;
            }
        } catch (Exception $e) {
            log_message('error', 'Error send_email_notification: ' . $e->getMessage());
            return false;
        }
    }

    // Email saat submit form berhasil
    private function send_email_submit_success($id, $data)
    {
        $subject = "Konfirmasi Pengajuan Akses Data Center - " . $data['nama_proyek'];
        $title = "Permohonan Berhasil Dikirim";

        $content = "
            <p>Halo <strong>" . $data['nama_pemohon'] . "</strong>,</p>
            
            <div class='status-box'>
                <p>Terima kasih telah mengajukan permohonan akses ke Data Center PT PELNI.</p>
            </div>
            
            <h4>Detail pengajuan Anda:</h4>
            <table style='width: 100%; border-collapse: collapse;'>
                <tr>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'><strong>Nama</strong></td>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'>: " . $data['nama_pemohon'] . "</td>
                </tr>
                <tr>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'><strong>NIP/NIK</strong></td>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'>: " . $data['id_karyawan'] . "</td>
                </tr>
                <tr>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'><strong>Divisi/Pekerjaan</strong></td>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'>: " . $data['unit_kerja'] . "</td>
                </tr>
                <tr>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'><strong>Tanggal Pengajuan</strong></td>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'>: " . date('d F Y', strtotime($data['tanggal_permohonan'])) . "</td>
                </tr>
            </table>
            
            <p style='margin-top: 20px;'>
                Permohonan Anda saat ini sedang <strong>menunggu proses verifikasi dan persetujuan</strong> dari pihak terkait.<br>
                Anda akan menerima notifikasi melalui email ini setelah permohonan <strong>disetujui</strong> atau <strong>memerlukan revisi</strong>.
            </p>
            
            <p>Terima kasih atas kerja samanya.</p>
        ";

        return $this->send_email_notification($data['email'], $subject, $title, $content);
    }

    // Email saat disetujui oleh Manager
    private function send_email_approved($permohonan_data)
    {
        $subject = "Persetujuan Akses Data Center - " . $permohonan_data->nama_proyek;
        $title = "Permohonan DISETUJUI";

        $content = "
            <p>Halo <strong>" . $permohonan_data->nama_pemohon . "</strong>,</p>
            
            <div class='status-box'>
                <p>Permohonan akses Anda ke Data Center PT PELNI telah <strong>DISETUJUI</strong>.</p>
            </div>
            
            <h4>Detail Persetujuan:</h4>
            <table style='width: 100%; border-collapse: collapse;'>
                <tr>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'><strong>Nama Proyek</strong></td>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'>: " . $permohonan_data->nama_proyek . "</td>
                </tr>
                <tr>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'><strong>Periode Berlaku</strong></td>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'>: " . date('d F Y', strtotime($permohonan_data->tanggal_berlaku)) . "</td>
                </tr>
                <tr>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'><strong>Waktu Akses</strong></td>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'>: " . $permohonan_data->jam_mulai . " - " . $permohonan_data->jam_selesai . "</td>
                </tr>
            </table>
            
            <p>
                Harap tunjukkan Email ini kepada petugas keamanan di pintu masuk Data Center.<br>
                Jaga kerahasiaan email ini dan jangan membagikannya kepada pihak lain.
            </p>
        ";

        return $this->send_email_notification($permohonan_data->email, $subject, $title, $content);
    }

    // Email saat ditolak/direvisi
    private function send_email_rejected($permohonan_data, $catatan)
    {
        $subject = "Revisi Permohonan Akses Data Center - " . $permohonan_data->nama_proyek;
        $title = "Permohonan Memerlukan Revisi";

        $content = "
            <p>Halo <strong>" . $permohonan_data->nama_pemohon . "</strong>,</p>
            
            <div class='rejection-box'>
                <p>Permohonan akses Anda ke Data Center PT PELNI <strong>belum dapat kami setujui</strong> saat ini.</p>
            </div>
            
            <h4>Alasan revisi:</h4>
            <div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>
                <p><strong>" . nl2br(htmlspecialchars($catatan)) . "</strong></p>
            </div>
            
            <p style='margin-top: 20px;'>
                Apabila Anda ingin memperbaiki data permohonan, silakan lakukan revisi melalui sistem.<br>
                Anda juga dapat melakukan pengajuan ulang apabila kebutuhan akses masih diperlukan,<br>
                atau menghubungi tim TI untuk klarifikasi lebih lanjut.
            </p>
            
            <p>Terima kasih atas pengertian dan kerja sama Anda.</p>
        ";

        return $this->send_email_notification($permohonan_data->email, $subject, $title, $content);
    }

    // Method untuk testing email
    public function test_email()
    {
        $test_data = (object)[
            'nama_pemohon' => 'John Doe',
            'email' => 'adityanugrahap23@gmail.com',
            'id_karyawan' => '123456',
            'unit_kerja' => 'Divisi IT',
            'nama_proyek' => 'Test Project',
            'tanggal_berlaku' => date('Y-m-d'),
            'jam_mulai' => '08:00',
            'jam_selesai' => '17:00',
            'tanggal_permohonan' => date('Y-m-d')
        ];

        // Test email submit
        $result1 = $this->send_email_submit_success(1, (array)$test_data);

        // Test email approved
        $result2 = $this->send_email_approved($test_data);

        // Test email rejected
        $result3 = $this->send_email_rejected($test_data, 'Data yang dimasukkan belum lengkap. Silakan lengkapi semua field yang required.');

        echo "Submit Email: " . ($result1 ? "SUCCESS" : "FAILED") . "<br>";
        echo "Approved Email: " . ($result2 ? "SUCCESS" : "FAILED") . "<br>";
        echo "Rejected Email: " . ($result3 ? "SUCCESS" : "FAILED") . "<br>";
    }
}
