<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PNBP_DETAIL extends CI_Controller {
	private $filename = "import_pnbp_detail"; // Kita tentukan nama filenya
	
	public function __construct(){
		parent::__construct();
		if ($this->session->userdata('status')<>'login') {
			redirect(site_url('login'));
			{
            redirect(base_url()."pnbp_detail", 'refresh');
        	}
		}
		$this->load->model('PNBPDetailModel');
	}
	
	public function index(){
        $data['pnbpdetail'] = $this->PNBPDetailModel->view();
        $data['pandu'] = $this->PNBPDetailModel->sum_pandu();
        $data['tunda'] = $this->PNBPDetailModel->sum_tunda();
		
		$this->template->load('template','v_pnbp_detail', $data);
		//$this->template->load('template','v_bulanan', $data);
			// echo '<pre>';
			// var_dump($data);die();
			// echo '</pre>';
		
    }
    public function form_import(){
		$this->template->load('template','v_pnbp_detail_form');
	}

	public function form(){
		$data = array(); // Buat variabel $data sebagai array
		
		if(isset($_POST['preview'])){ // Jika menekan tombol Preview pada form
			// lakukan upload file dengan memanggil function upload yang ada di PNBPDetailModel 
			$upload = $this->PNBPDetailModel->upload_file($this->filename); 
			
			if($upload['result'] == "success"){ // Jika proses upload sukses
				// Load plugin PHPExcel nya
				include APPPATH.'third_party/PHPExcel/PHPExcel.php';
				
				$excelreader = new PHPExcel_Reader_Excel5();
				$loadexcel = $excelreader->load('excel/'.$this->filename.'.xls'); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
				
				// Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
				// Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
				$data['sheet'] = $sheet; 
			}else{ // Jika proses upload gagal
				$data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
				$this->template->load('template','v_pnbp_detail_form', $data);
			}
		}
		$this->template->load('template','v_pnbp_detail_form', $data);
	}
	
	public function import(){
		// Load plugin PHPExcel nya
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		
		$excelreader = new PHPExcel_Reader_Excel5();
		$loadexcel = $excelreader->load('excel/'.$this->filename.'.xls'); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		
		// Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
		$data = array();
		
		$numrow = 1;
		foreach($sheet as $row){
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if($numrow > 1){
				// push (add) array data ke variabel data dan looping datetime sesuai format excell dan convert YYYY-MM-DD H24:i:ss ke db
                $ETA = date('Y-m-d H:i:s', strtotime($row['D'])); 
                $ETD = date('Y-m-d H:i:s', strtotime($row['E'])); 
                $TGL_PRANOTA = date('Y-m-d', strtotime($row['J'])); 
                $TGL_NOTA= date('Y-m-d', strtotime($row['K'])); 
                $TGL_MPANDU = date('Y-m-d H:i:s', strtotime($row['W'])); 
                $TGL_SPANDU = date('Y-m-d H:i:s', strtotime($row['X'])); 
                $JAM_PANDU_NAIK = date('Y-m-d H:i:s', strtotime($row['Y'])); 
                $JAM_PANDU_TURUN = date('Y-m-d H:i:s', strtotime($row['Z'])); 



                /********************COVERSI NOMINAL************/

                //$PANDU_IDR = number_format($row['L'],2",",".");


                /*$angka = '15,146';
                $tab = explode(",",$angka);
                $arrayNumber = array_reverse($tab);

                if(intval($arrayNumber[0])!=0) { //seratus
                        $str[] =$arrayNumber[0];
                    }
                    if(intval($arrayNumber[1])!=0) { //ribuan
                        $str[] =$arrayNumber[1];
                    }
                    if(intval($arrayNumber[2])!=0) { //jutaan
                        $str[] =$arrayNumber[2];
                    }

                    $strArr = array_reverse($str);
                    echo join('.', $strArr); */
                   
                $PANDU_IDR = $this->conversi->floatvalue($row['L']); //Catatan nilai yg di upload 1,99.00 misal 
                $TUNDA_IDR = $this->conversi->floatvalue($row['M']);
                $JUMLAH_IDR = $this->conversi->floatvalue($row['N']);
                $PNBP_PANDU = $this->conversi->floatvalue($row['R']);
                $PNBP_TUNDA = $this->conversi->floatvalue($row['S']);
                $PNBP = $this->conversi->floatvalue($row['T']);
				
				array_push($data, array(

					'NO_NOTA'=>$row['A'], 
					'NOMOR_PPKB'=>$row['B'], 
					'NO_PKK_INAPORTNET'=>$row['C'], 
					'ETA'=>$ETA, 
					'ETD'=>$ETD , 
					'NO_UKK'=>$row['F'], 
					'NAMA_KAPAL'=>$row['G'], 
					'NM_AGEN'=>$row['H'], 
                    'KUNJUNGAN'=>$row['I'],
                    'TGL_PRANOTA'=> $TGL_PRANOTA,
                    'TGL_NOTA'=> $TGL_NOTA,
                    'PANDU_IDR'=>$PANDU_IDR, 
                    'TUNDA_IDR'=>$TUNDA_IDR,
                    'JUMLAH_IDR'=>$JUMLAH_IDR,
                    'NOMOR_PPKB1'=>$row['O'],
                    'NO'=>$row['P'],
                    'PERSEN'=>$row['Q'],
                    'PNBP_PANDU'=>$PNBP_PANDU,
                    'PNBP_TUNDA'=>$PNBP_TUNDA,
                    'PNBP'=>$PNBP,
                    'SETOR_PNBP_IDR'=>$row['U'],
                    'SPK_PANDU'=>$row['V'],
                    'TGL_MPANDU'=>$TGL_MPANDU,
                    'TGL_SPANDU'=>$TGL_SPANDU,
                    'JAM_PANDU_NAIK'=>$JAM_PANDU_NAIK,
                    'JAM_PANDU_TURUN'=>$JAM_PANDU_TURUN,
                    'BULAN'=>$row['AA'],
                    'TAHUN'=>$row['AB'],
                    'PORT_CODE'=>$row['AC']
				));
			}
            $numrow++; // Tambah 1 setiap kali looping
            // {
            //     redirect(base_url()."pnbp_detail", 'refresh');
            // }
		}

		// Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
		$this->PNBPDetailModel->insert_multiple($data);
		$data['pnbpdetail'] = $this->PNBPDetailModel->view();
        $data['warning'] = 'success';
        $data['pandu'] = $this->PNBPDetailModel->sum_pandu();
        $data['tunda'] = $this->PNBPDetailModel->sum_tunda();
        
        $this->template->load('template','v_pnbp_detail', $data);
        // echo '<pre>';
		// 	var_dump($data);die();
		// 	echo '</pre>';
       {
           
        redirect(base_url()."pnbp_detail", 'refresh');
        
       }

    }
    
    function export_csv(){

       /* if($this->input->get("from") != null)
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
        }*/

        



        $this->load->library("csv");

        $csv = new PHPExcel();

        $csv->setActiveSheetIndex(0);

        /*1 $csv->getActiveSheet()->setCellValue('A1', 'PT. PELABUHAN INDONESIA II - KANTOR CABANG TANJUNG PRIOK');
        $csv->getActiveSheet()->mergeCells('A1:L1');

        $csv->getActiveSheet()->setCellValue('A2', 'TEKNIK & SISTEM INFORMASI');
        $csv->getActiveSheet()->mergeCells('A2:L2');

        $csv->getActiveSheet()->setCellValue('A3', "Periode : $judulfrom s/d $judulto");
        $csv->getActiveSheet()->mergeCells('A3:L3');

        // set center
        $style = array(
        'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $csv->getDefaultStyle("A1")->applyFromArray($style); 1*/
        // end set center untuk judul

       /* $table_columns = array("NO_NOTA", "NOMOR_PPKB", "NO_PKK_INAPORTNET", "ETA", "ETD", "NO_UKK","NAMA_KAPAL", "NM_AGEN", "KUNJUNGAN","TGL_PRANOTA","TGL_NOTA","PANDU_IDR","TUNDA_IDR","JUMLAH_IDR","NOMOR_PPKB1","NO","PERSEN","PNBP_PANDU","PNBP_TUNDA","PNBP","SETOR_PNBP_IDR","SPK_PANDU",
        "TGL_MPANDU",
        "TGL_SPANDU",
        "JAM_PANDU_NAIK",
        "JAM_PANDU_TURUN",
        "BULAN",
        "TAHUN",
        "PORT_CODE"); 

       $column = 0;

       foreach($table_columns as $field){

        $csv->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field); // column, row, data

        $column++;

       } */

        // set color and bold for column
      /*  $colFrom = "A4"; 
        $colTo = "L4"; 
        $csv->getActiveSheet()->getStyle("$colFrom:$colTo")->getFont()->setBold( true );
        $csv->getActiveSheet()->getStyle("$colFrom:$colTo")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('02d9ef'); */
      
        // set data
        //$result_data = $this->AbsensiModel->report_bulanan($from, $to);
        $result_data = $this->PNBPDetailModel->view();
        $csv_row = 1; // data dimulai dari row 5
        // $num=1;
        foreach($result_data as $row){

        

        // $csv->getActiveSheet()->setCellValueByColumnAndRow(0, $csv_row, $num);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(0, $csv_row, $row->NO_NOTA);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(1, $csv_row, $row->NOMOR_PPKB);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(2, $csv_row, $row->NO_PKK_INAPORTNET);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(3, $csv_row, date("Y-m-d H:i:s", strtotime($row->ETA)));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(4, $csv_row, date("Y-m-d H:i:s", strtotime($row->ETD)));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(5, $csv_row, $row->NO_UKK);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(6, $csv_row, $row->NAMA_KAPAL);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(7, $csv_row, $row->NM_AGEN);
        
        $csv->getActiveSheet()->setCellValueByColumnAndRow(8, $csv_row, $row->KUNJUNGAN);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(10, $csv_row, date("Y-m-d", strtotime($row->TGL_PRANOTA)));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(11, $csv_row, date("Y-m-d", strtotime($row->TGL_NOTA)));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(12, $csv_row, number_format($row->PANDU_IDR, 0, ',','.')); //number_format($total += $data->TUNDA_IDR, 0, ',','.');

        $csv->getActiveSheet()->setCellValueByColumnAndRow(13, $csv_row, number_format($row->TUNDA_IDR, 0, ',','.'));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(14, $csv_row, number_format($row->JUMLAH_IDR, 0, ',','.'));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(15, $csv_row, $row->NOMOR_PPKB1);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(16, $csv_row, $row->NO);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(17, $csv_row, $row->PERSEN);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(18, $csv_row, number_format($row->PNBP_PANDU, 0, ',','.'));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(19, $csv_row, number_format($row->PNBP_TUNDA, 0, ',','.'));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(20, $csv_row, number_format($row->PNBP, 0, ',','.'));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(21, $csv_row, $row->SETOR_PNBP_IDR);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(22, $csv_row, $row->SPK_PANDU);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(23, $csv_row, date("Y-m-d H:i:s", strtotime($row->TGL_MPANDU)));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(24, $csv_row, date("Y-m-d H:i:s", strtotime($row->TGL_SPANDU)));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(25, $csv_row, date("Y-m-d H:i:s", strtotime($row->JAM_PANDU_NAIK)));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(26, $csv_row, date("Y-m-d H:i:s", strtotime($row->JAM_PANDU_TURUN)));

        $csv->getActiveSheet()->setCellValueByColumnAndRow(27, $csv_row, $row->BULAN);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(28, $csv_row, $row->TAHUN);

        $csv->getActiveSheet()->setCellValueByColumnAndRow(29, $csv_row, $row->PORT_CODE);
       
       

        $csv_row++;
        //$num++;
      }

        // set width auto
    /*    foreach (range('A', $csv->getActiveSheet()->getHighestDataColumn()) as $col) {
        $csv->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
               // ->setAutoSize(false);
        } */

      //$judul = "DETAIL_PNBP".$judulfrom."_to-".$judulto.".csv";

      $judul = "DETAIL_PNBP.csv";

      $object_writer = PHPExcel_IOFactory::createWriter($csv, 'CSV');

      header('Content-Type: application/vnd.ms-excel');

      header('Content-Disposition: attachment;filename="'.$judul.'"');

      // header('Content-Disposition: attachment;filename="Employee Data.xls"');

      $object_writer->save('php://output');

    }


    public function delete_all($id){

		$row = $this->PNBPDetailModel->mytruncate($id);
        // $row = $this->AbsensiModel->get_by_id($id);

        if ($row) {
            $this->PNBPDetailModel->mytruncate($id);
            $this->session->set_flashdata('message', '
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>    <i class="icon fa fa-check"></i> Sukses!</h4>Data Berhasil Dihapus
                </div>');
            redirect(site_url('pnbp_detail'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pnbp_detail'));
        }
    }

    
}