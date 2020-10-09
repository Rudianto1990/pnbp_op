<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PNBPDetailModel extends CI_Model {
	public function view(){
		$this->db->select('*');
		//$this->db->group_by('NO_NOTA');
		$this->db->where('NO_NOTA !=','');
		//$this->db->order_by('NO','ASC');
		return $this->db->get('detail_pnbp')->result(); // Tampilkan semua data 
	}
		// Fungsi untuk melakukan proses upload file
	public function upload_file($filename){
			$this->load->library('upload'); // Load librari upload
			
			$config['upload_path'] = './excel/';
			$config['allowed_types'] = 'xls';
			$config['max_size']	= '2048';
			$config['overwrite'] = true;
			$config['file_name'] = $filename;
		
			$this->upload->initialize($config); // Load konfigurasi uploadnya
			if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
				// Jika berhasil :
				$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
				return $return;
			}else{
				// Jika gagal :
				$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
				return $return;
			}
		}
		
		// Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
	public function insert_multiple($data){
			$this->db->insert_batch('detail_pnbp', $data);
			
		}
    public function mytruncate($data)
		{
			
			$this->db->empty_table('detail_pnbp', $data);//
		}

	public function sum_pandu(){
		$this->db->select_sum('PANDU_IDR');
		//$this->db->select_sum('TUNDA_IDR');
		//$this->db->group_by('NO_NOTA');
		$this->db->where('NO_NOTA !=','');
		//$this->db->order_by('NO','ASC');
		return $this->db->get('detail_pnbp')->result(); // 
		}
	public function sum_tunda(){
			$this->db->select_sum('TUNDA_IDR');
			//$this->db->select_sum('TUNDA_IDR');
			//$this->db->group_by('NO_NOTA');
			$this->db->where('NO_NOTA !=','');
			//$this->db->order_by('NO','ASC');
			return $this->db->get('detail_pnbp')->result(); // Tampilkan semua data yang ada di tabel
			}
}