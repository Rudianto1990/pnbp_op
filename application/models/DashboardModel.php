<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DashboardModel extends CI_Model {

	public function view() {
		// $this->db->select('*');
		// $this->db->group_by('personnel_id');
		// $this->db->where('personnel_id !=','');
		// $this->db->where('date =','SELECT max(date) from data_absensi'); 
		// $this->db->order_by('first_name','ASC');
		// return $this->db->get('data_absensi')->result(); // Tampilkan semua data yang ada di tabel siswa
		
		$sql = "select * from data_absensi where personnel_id != '' and date =(SELECT max(date) from data_absensi) group by personnel_id order by first_name ASC";
		return $this->db->query($sql)->result();
	}

	public function detail($id){
		$sql = "select * from data_absensi where personnel_id = '$id' and date = (SELECT max(date) from data_absensi)";
		return $this->db->query($sql)->result(); // Tampilkan semua data yang ada di tabel pegawai
	}

	public function detail_tgl($tgl){
		$this->db->select('*');
		$this->db->where('personnel_id !=','');
		$this->db->where('date',$tgl);
		$this->db->group_by('personnel_id');
		$this->db->order_by('first_name', 'ASC');
		return $this->db->get('data_absensi')->result(); // Tampilkan semua data yang ada di tabel  pegawai
	
	}
	function get_data_telat_tepat(){
		$query =$this->db->query("SELECT a.*, 
		TIME_TO_SEC(timediff('08:01:00',a.time))/60  as telat_masuk, 
		TIME_TO_SEC(timediff('16:59:00',a.time))/60 as cepat_pulang, 
		IF(TIME_TO_SEC(timediff('08:01:00',a.time))/60<0,'Telat','Tepat Waktu') as status_masuk,
		IF(TIME_TO_SEC(timediff('16:59:00',a.time))/60>0,'Cepat','Tepat Waktu') as status_pulang
		FROM (SELECT 
		first_name,
		last_name,
		personnel_id,
		date,
		time,
		DATE_FORMAT(date, '%d-%m-%y') AS tanggal, 
		DATE_FORMAT(MIN(time), '%H:%i:%s') AS masuk,
		CASE WHEN MAX(time)<>MIN(time) 
			THEN DATE_FORMAT(MAX(data_absensi.time), '%H:%i:%s') END AS keluar 
		FROM 
		data_absensi ---where DATE_FORMAT(date, '%d-%m-%Y') = '15-07-2020'
		GROUP BY personnel_id, DATE(time)) as a order by personnel_id desc limit 0,20");
		return $query ;
		//print_r($query);exit();
	}

}
