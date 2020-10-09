<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {
	// private $filename = "import_data_absensi"; // Kita tentukan nama filenya
	
	public function __construct(){
		parent::__construct();
		if ($this->session->userdata('status')<>'login') {
			redirect(site_url('login'));
			{
            redirect(base_url()."report", 'refresh');
        	}
		}
		$this->load->model('AbsensiModel');
	}
	
	public function index(){
		// $data['absensi'] = $this->AbsensiModel->view();
	    // $data['bulanan'] = $this->AbsensiModel->report_bulanan($start, $end);
		$this->template->load('template','v_report');
		// $this->template->load('template','v_bulanan', $data);
		
	}

	public function proses(){

		$valid = $this->form_validation;
		$valid->set_error_delimiters('<i style="color: red;">', '</i>');
        $valid->set_rules('start', 'Field Start Date', 'required|trim|strip_tags|htmlspecialchars');
		$valid->set_rules('end', 'Field Start Date', 'required|trim|strip_tags|htmlspecialchars');
		
		if ($valid->run() === TRUE)
        {
			$input = $this->input->post(NULL, TRUE);
			$data = $this->AbsensiModel->report_bulanan("data",$input["start"], $input["end"]);
			return $this->response([
                    'data'      => array_values($data)
        	]);
		} else return  $this->response(['success' => FALSE, 'error' => validation_errors()]);
	}

	public function response($data)
    {
        $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
        exit();
    }
}
