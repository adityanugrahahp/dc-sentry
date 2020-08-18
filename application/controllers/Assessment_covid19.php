<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Assessment_covid19 extends MY_Controller
{

    protected $module_name      = 'Assesment Pegawai';
    protected $ws_url           = 'https://portal.pelni.co.id/ess/Ws_ess/';

    public function __construct(){
        parent::__construct();

    

    }

    public function index(){

        $data['extraCss'] = [
        //     "loader.css", 
        //     "sweetalert.css", 
        //     "additional_style.css",
            "select2.min.css",
        //     "bootstrap-datepicker3.css",
        //     "ess-form.css",
        //     "jquery.dataTables.css",
        //     "demo_table.css",
        //     "additional_style.css",
            "sweetalert2.min.css", 
            "animate.min.css"
        ];

        $data['extraJs'] = [
            "select2.min.js",
        //     "bootstrap-datepicker.js",
        //     "jquery.dataTables.min.js",
        //     "DT_bootstrap.js",
            "jquery.validate.min.js",
        //     "metronic.js",
        //     "ui-blockui.js",
        //     "jquery.blockui.min.js",
            "sweetalert2.min.js"
        ];

        // $data['title']      = $this->module_name;
        // $data['img_potret'] = base_url()."theme/dashboard/img/new_normal/potret_perusahaan_desktop_min.jpg";
        //     $data['swal_class'] = 'swal-wide'; 
        // if($this->agent->is_mobile()){
        //     $data['img_potret'] = base_url()."theme/dashboard/img/new_normal/potret_perusahaan_mobile_min.jpg";
        //     $data['swal_class'] = '';
        // }

        $data['file']       = "assessment_covid/V_assessment_covid";
        $this->load->view($data['file'], $data);
        // $this->load->view('layouts/_footer');
        // $this->load->view("template", $data);
    }
    public function select2_pegawai()
    {
    	$unit_kerja = $this->input->post('utk');
    	$param = $this->input->post('param');
    	$mgr   = $this->input->post('mgr');

    	if(!isset($unit_kerja) || $unit_kerja == '')
    	{
    		$unit_kerja = 'false';
    	}
    	if(!isset($mgr) || $mgr == '')
    	{
    		$mgr = '';
    	}
        $data     = array('param'=> $param);
        $url      = $this->ws_url.'select2_pegawai';
        $data_raw = $this->dataCurl($data, $url);
        // var_dump($data_raw);
        // die;
        $response_data = array();

        if ($data_raw != FALSE) {
            foreach ($data_raw as $value) {
                $response_data[] = array(
                    'id'    => $value['pslh_nrp'],
                    'text'  => $value['pslh_nama'].'('.$value['pslh_nrp'].') | '.$value['jab_ket'].' | '.$value['utk_ket']
                );
            }
        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($response_data));
    }
    public function cek_score()
    {
        $nrp    = $this->input->post('nrp');
        $data   = array('nrp'=> $nrp);
        $url    = $this->ws_url.'cek_score';
        $status = $this->dataCurl($data, $url);

        echo json_encode($status);
    }

    public function insert_health_log()
    {
        $post = $this->input->post();
        
        $nrp = $this->input->post('nrp');
        $health_status = $this->input->post('healthy');
        $keterangan = $this->input->post('penyakit');
        $tanggal_sakit = $this->input->post('tanggal_sakit') != null ? date('Y-m-d', strtotime($this->input->post('tanggal_sakit'))): null;
        $tanggal_sembuh = $this->input->post('tanggal_sembuh') != null ? date('Y-m-d', strtotime($this->input->post('tanggal_sembuh'))) : null;
        $tanggal_interaksi = $this->input->post('tanggal_kontak')!= null ? date('Y-m-d', strtotime($this->input->post('tanggal_kontak'))) : null;
        $tempat_interaksi = $this->input->post('tempat_kontak');
        $kegiatan_interaksi = $this->input->post('kegiatan_kontak');
        $penyakit = $this->input->post('penyakit');
        
        // $this->form_validation->set_rules('healthy', 'longitude', 'required');
        // $this->form_validation->set_rules('nrp', 'nrp', 'required');
        $result = array();
        $msg    = null;

        if ($this->form_validation->run() == TRUE) 
        {

            $report_health = array(
                'nrp'=>$nrp,
                'tanggal'=>date('Y-m-d'),
                'healthy' =>$health_status,
                'mood'          => $post['mood'],
                'q1'   => $post['q1'],
                'q2'   => $post['q2'],
                'q3'   => $post['q3'],
                'q4'   => $post['q4'],
                'q5'   => $post['q5'],
                'q6'   => $post['q6'],
                'q7'   => $post['q7'],
                'q8'   => $post['q8'],
                'q9'   => $post['q9'],
                'tempat_kontak'=> $tempat_interaksi,
                'tanggal_kontak'=> $tanggal_interaksi,
                'kegiatan_kontak'=> $kegiatan_interaksi,
                'tanggal_sakit' => $tanggal_sakit,
                'tanggal_sembuh'=> $tanggal_sembuh,
                'penyakit'    => $penyakit,
            );
        $url = $this->ws_url.'insert_health_log';

        $status = $this->dataCurl($report_health, $url);
        //     if($health_status!="sehat")
        //     {
        //         $report_health['keterangan'] = $keterangan;
        //     }
        //      if($health_status!="sehat")
        //     {
        //         $report_health['keterangan'] = $keterangan;
        //     }
        //     if($score >= 5)
        //     {
        //         $msg = '<span>Resiko Besar</span>';
        //     }
        //     else if($score >= 2 && $score < 5)
        //     {
        //         $msg = '<span class="text-warning">Resiko Sedang</span>';
        //     }
        //     else
        //     {
        //         $msg = 'Resiko Kecil';
        //     }
        //     if($this->input->post('act') == 'insert')
        //     {
        //         $result         = $this->Mess->insert_daily_health($report_health);
        //     }
        //     if($this->input->post('act') == 'update')
        //     {
        //          $result         = $this->Mess->update_daily_health($report_health, $this->input->post('id_log_health'));
        //     }
        //     $result['data'] = $score;
        //      $result['status_message']  = $msg;
        // }
        // else
        // {
        //     $result['status']='error';
        //     $result['status_message']='Validation Error, NRP dan status_health tidak boleh kosong';
        //     $result['data'] = [];
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    
    function dataCurl ($data, $url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$eks = curl_exec($ch);
		curl_close($ch);
		$json = json_decode($eks, true);
		return $json;
    }
}


