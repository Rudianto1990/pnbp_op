<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_absen_month extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		if ($this->session->userdata('status')<>'login') {
			redirect(site_url('login'));
			{
            redirect(base_url()."dashboard", 'refresh');
        	}
		}
		 $this->load->model('AbsensiModel');
	}

public function index(){

		if($this->input->get("from") != null)
        {
        	$from = date("Y-m-d", strtotime($this->input->get("from")));
        }
        else
        {
        	$from = null;
        }

        if($this->input->get("to") != null)
        {
        	$to = date("Y-m-d", strtotime($this->input->get("to")));
        }
        else
        {
        	$to = null;
        }

        // $data['view'] = $this->AbsensiModel->view();

        $data['monthreport'] = $this->AbsensiModel->report_bulanan($from, $to);
  		
		// $data['absensi'] = $this->AbsensiModel->view();
		// $data['bulanan'] = $this->AbsensiModel->data_bulanan($start_date,$end_date);
		$this->template->load('template','laporan/index', $data);
		// $this->template->load('template','v_bulanan', $data);
			// echo '<pre>';
			// var_dump($data);die();
			// echo '</pre>';
        // echo '<pre>';
        // var_dump($data);die();
        // echo '</pre>';
		
	   }

function export_excel(){

        if($this->input->get("from") != null)
        {
            $from = date("Y-m-d", strtotime($this->input->get("from")));
            $judulfrom = date("d-m-Y", strtotime($this->input->get("from")));
        }
        else
        {
            $from = null;
            $judulfrom = null;
        }

        if($this->input->get("to") != null)
        {
            $to = date("Y-m-d", strtotime($this->input->get("to")));
            $judulto = date("d-m-Y", strtotime($this->input->get("to")));
        }
        else
        {
            $to = null;
            $judulto = null;
        }

        // if($this->input->get("id") != null)
        // {
        //     $id = $this->input->get("id");
        // }
        // else
        // {
        //     $id = null;
        // }
        // if($this->input->get("tgl") != null)
        // {
        //     $tgl = date("Y-m-d", strtotime($this->input->get("tgl")));
        //     $judultgl = date("d-m-Y", strtotime($this->input->get("tgl")));
        // }
        // else
        // {
        //     $tgl = null;
        //     $judultgl = null;
        // }



        $this->load->library("excel");

        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $object->getActiveSheet()->setCellValue('A1', 'PT. PELABUHAN INDONESIA II - KANTOR CABANG TANJUNG PRIOK');
        $object->getActiveSheet()->mergeCells('A1:L1');

        $object->getActiveSheet()->setCellValue('A2', 'MONTH REPORT ABSENSI AKSES DOOR TEKNIK & SISTEM INFORMASI');
        $object->getActiveSheet()->mergeCells('A2:L2');

        $object->getActiveSheet()->setCellValue('A3', "Periode : $judulfrom s/d $judulto");
        $object->getActiveSheet()->mergeCells('A3:L3');

        // set center
        $style = array(
        'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $object->getDefaultStyle("A1")->applyFromArray($style);
        // end set center untuk judul

        $table_columns = array("NO", "NIPP", "FIRST NAME", "LAST NAME", "TANGGAL TAPPING", "PERIODE FROM","PERIODE TO", "IN", "OUT");

        $column = 0;

      foreach($table_columns as $field){

        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 4, $field); // column, row, data

        $column++;

      }

        // set color and bold for column
        $colFrom = "A4"; 
        $colTo = "L4"; 
        $object->getActiveSheet()->getStyle("$colFrom:$colTo")->getFont()->setBold( true );
        $object->getActiveSheet()->getStyle("$colFrom:$colTo")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('02d9ef');

        // set data
        $result_data = $this->AbsensiModel->report_bulanan($from, $to);
        $excel_row = 5; // data dimulai dari row 5
        $num=1;
        foreach($result_data as $row){

        

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $num);

        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->personnel_id);

        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->first_name);

        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->last_name);

        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, date("d-m-Y", strtotime($row->tgl_absen)));

        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $judulfrom);

        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $judulto);

        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->wk_in);

        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->wk_out);

       

        $excel_row++;
        $num++;
      }

        // set width auto
        foreach (range('A', $object->getActiveSheet()->getHighestDataColumn()) as $col) {
        $object->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
               // ->setAutoSize(false);
        }

      $judul = "REPORT_MONTH_AKSES_DOOR_from-".$judulfrom."_to-".$judulto.".xls";

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');

      header('Content-Type: application/vnd.ms-excel');

      header('Content-Disposition: attachment;filename="'.$judul.'"');

      // header('Content-Disposition: attachment;filename="Employee Data.xls"');

      $object_writer->save('php://output');

    }

    function export_csv(){

        if($this->input->get("from") != null)
        {
            $from = date("Y-m-d", strtotime($this->input->get("from")));
            $judulfrom = date("d-m-Y", strtotime($this->input->get("from")));
        }
        else
        {
            $from = null;
            $judulfrom = null;
        }

        if($this->input->get("to") != null)
        {
            $to = date("Y-m-d", strtotime($this->input->get("to")));
            $judulto = date("d-m-Y", strtotime($this->input->get("to")));
        }
        else
        {
            $to = null;
            $judulto = null;
        }

        



        $this->load->library("csv");

        $csv = new PHPExcel();

        $csv->setActiveSheetIndex(0);

        $csv->getActiveSheet()->setCellValue('A1', 'PT. PELABUHAN INDONESIA II - KANTOR CABANG TANJUNG PRIOK');
        $csv->getActiveSheet()->mergeCells('A1:L1');

        $csv->getActiveSheet()->setCellValue('A2', 'MONTH REPORT ABSENSI AKSES DOOR TEKNIK & SISTEM INFORMASI');
        $csv->getActiveSheet()->mergeCells('A2:L2');

        $csv->getActiveSheet()->setCellValue('A3', "Periode : $judulfrom s/d $judulto");
        $csv->getActiveSheet()->mergeCells('A3:L3');

        // set center
        $style = array(
        'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $csv->getDefaultStyle("A1")->applyFromArray($style);
        // end set center untuk judul

        $table_columns = array("NO", "NIPP", "FIRST NAME", "LAST NAME", "TANGGAL TAPPING", "PERIODE FROM","PERIODE TO", "IN", "OUT");

        $column = 0;

      foreach($table_columns as $field){

        $csv->getActiveSheet()->setCellValueByColumnAndRow($column, 4, $field); // column, row, data

        $column++;

      }

        // set color and bold for column
        $colFrom = "A4"; 
        $colTo = "L4"; 
        $csv->getActiveSheet()->getStyle("$colFrom:$colTo")->getFont()->setBold( true );
        $csv->getActiveSheet()->getStyle("$colFrom:$colTo")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('02d9ef');

        // set data
        $result_data = $this->AbsensiModel->report_bulanan($from, $to);
        $csv_row = 5; // data dimulai dari row 5
        $num=1;
        foreach($result_data as $row){

        

        $csv->getActiveSheet()->setCellValueByColumnAndRow(0, $csv_row, $num);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(1, $csv_row, $row->personnel_id);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(2, $csv_row, $row->first_name);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(3, $csv_row, $row->last_name);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(4, $csv_row, date("d-m-Y", strtotime($row->tgl_absen)));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(5, $csv_row, $judulfrom);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(6, $csv_row, $judulto);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(7, $csv_row, $row->wk_in);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(8, $csv_row, $row->wk_out);

       

        $csv_row++;
        $num++;
      }

        // set width auto
        foreach (range('A', $csv->getActiveSheet()->getHighestDataColumn()) as $col) {
        $csv->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
               // ->setAutoSize(false);
        }

      $judul = "REPORT_MONTH_AKSES_DOOR_from-".$judulfrom."_to-".$judulto.".csv";

      $object_writer = PHPExcel_IOFactory::createWriter($csv, 'CSV');

      header('Content-Type: application/vnd.ms-excel');

      header('Content-Disposition: attachment;filename="'.$judul.'"');

      // header('Content-Disposition: attachment;filename="Employee Data.xls"');

      $object_writer->save('php://output');

    }



 public function read(){ 
    // $this->load->helper('url'); 
    // {
         // redirect("absensi/read", 'refresh'); 
    // }
    
        $id = $_POST['id'];
        $date = DateTime::createFromFormat('d/m/Y',$_POST['tgl_absen']);
        $tgl = $date->format("Y-m-d");
        $data['wk'] = $this->AbsensiModel->view_wk_in_out($id,$tgl);
        // $data['absensi'] = $this->AbsensiModel->detail_month($id,$end_date,$start_date);
        $data['absensi'] = $this->AbsensiModel->detail($id,$tgl);
        if ($data['absensi']==null) {
            $data['warning'] = 'error';
            
            $data['absensi'] = $this->AbsensiModel->view();
            $this->template->load('template','v_absensi', $data);
        }
        else{
            // $data['warning'] = 1;
            $this->template->load('template','v_absensi_detail', $data);
            // redirect('absensi/read'); 
            // echo '<pre>';
            // var_dump($data);die();
            // echo '</pre>';
        }
         // redirect('absensi/read', 'refresh'); 
        

    }


}