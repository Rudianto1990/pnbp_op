<section class="content-header">
      <h1>
	  	PNBP DETAIL
        <small>OP & IPC CABANG PRIOK</small>
      </h1>
    </section>
    <!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-lg-12">
					<?php if (@$warning=='error') { ?>
			<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Data Tidak Ditemukan</h4>
                Data yang anda minta tidak dapat ditampilkan. Pastikan data absensi pada tanggal yang anda pilih sudah diinput ke database.
                Pegawai tersebut kemungkinan tidak terdaftar atau tidak melakukan tap absensi acces door pada tanggal serta jam tersebut!!!
            </div>
				<?php	} elseif (@$warning=='success') { ?>
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Data Berhasil Di Import</h4>
									Data berhasil ditambahkan ke database.
			</div>
		<?php } ?>

   <?php 
    $total = 0;
    foreach($pandu as $data){   
   ?>
  <?php } ?>


<div class="row">
     <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-credit-card"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">PANDU IDR</span>
              <span class="info-box-number"><?php echo number_format($total += $data->PANDU_IDR, 0, ',','.');?><div></div></span>
            </div>
           
     </div>
</div>

<?php 
$total = 0;
foreach($tunda as $data){ 
?>

<?php } ?>
<div class="clearfix visible-sm-block"></div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-credit-card"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">TUNDA IDR</span>
              <span class="info-box-number"><?php echo number_format($total += $data->TUNDA_IDR, 0, ',','.');?><div></div></span>
            </div>
        
    </div>
</div>


<div class="box-body table-responsive">
                            <a type='button' class='btn btn-success btn-flat btn-md' href='<?php echo site_url("pnbp_detail/form_import") ?>'><i class='fa fa-plus'></i> Import Data</a>
                            <a type='button' class='btn btn-primary btn-flat btn-md' href='<?php echo site_url("pnbp_detail/export_csv") ?>'><i class='fa fa-file-excel-o'></i> Export CSV</a>
							<a data-toggle="tooltip" title="Hapus Absensi ALL"><a href="#modal-fade" data-toggle="modal" class="btn btn-effect-ripple btn-md btn-danger"><i class="fa fa-times"> Delete All</i></a>
							<hr>
			    <div id="modal-fade" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h3 class="modal-title"><strong>Konfirmasi</strong></h3>
                                        </div>
                                        <div class="modal-body">
                                                Anda yakin akan menghapus data PNBP DETAIL semua?
                                        </div>
                                            <div class="modal-footer">
                                                <a href="<?php echo site_url("pnbp_detail/delete_all") ?>" class="btn btn-effect-ripple btn-danger">Ya</a>
                                                <button type="button" class="btn btn-effect-ripple btn-info" data-dismiss="modal">Tidak</button>
                                             
                                    </div>
                        </div>
             </div>
             
</div>
<?php

?>

<div class="box">
<br/>

<table id="example1" class="table table-striped table-hover" width="120%">
				  <thead>
					<tr>
						<th>No.</th>
						<th>NO NOTA</th>
						<th>NOMOR PPKB</th>
						<th>NO PKK INAPORTNET</th>
                        <th>NO UKK</th>
                        <th>NO</th>
                        <th>TGL NOTA</th>
                        <th>PANDU IDR</th>
                        <th>TUNDA IDR</th>
					</tr>
				  </thead>
				  <tbody>
                  <?php
                 
				  $no=1;
					if( ! empty($pnbpdetail)){ // Jika data pada database tidak sama dengan empty (alias ada datanya)
						foreach($pnbpdetail as $rowColor => $data){ // Lakukan looping pada variabel absensi dari controller
                            if ( $rowColor%2 == 0) { // Looping membuat cell colloring
                               $rowColor = 'style="background-color: #ccc5c5;"'; 
                            }elseif ( $rowColor%2 == 1) {
                               $rowColor = 'style="background-color: #f4f4f4;"';
                            }// Lakukan looping pada variabel siswa dari controller
                           echo "<tr ".$rowColor++.">";
                            // echo "<tr>";
							echo "<td>".$no++."</td>";
							echo "<td>".$data->NO_NOTA."</td>";
							echo "<td>".$data->NOMOR_PPKB."</td>";
                            echo "<td>".$data->NO_PKK_INAPORTNET."</td>";
                            echo "<td>".$data->NO_UKK."</td>";
                            echo "<td>".$data->NO."</td>";
                            echo "<td>".$data->TGL_NOTA."</td>";
                            echo "<td>".number_format($data->PANDU_IDR, 0, ',','.')."</td>";
                            echo "<td>".number_format($data->TUNDA_IDR, 0, ',','.')."</td>";
							echo "</tr>";
						}
					}else{ // Jika data tidak ada
						echo "<tr><td colspan='4'>Data tidak ada</td></tr>";
					}
					?>
				  </tbody>
              </table>
              </div>
			</div>
		</div>
	</div>
</div>

</section>

<script>
	 //Date picker
	//  $('#datepicker<?php //echo $data->personnel_id ?>').datepicker({
    //   autoclose: true
    // })
</script>
<!-- <div class="container">
			<div class="row" style="padding-top: 20px">
				<div class="col-md-12">
					<div class="progress">
					  <div class="progress-bar" id="pro" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<br>
					<button class="btn btn-success" onclick="klik()"> UPLOAD </button> <br> <br>
					<p class="alert-success" id="status"></p>
				</div>
			</div>
		</div>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript">
 
			function klik() {
			  var pro = document.getElementById("pro");   
			  var width = 1;
			  var id = setInterval(kondisiPro, 10);
 
			  function kondisiPro() {
			    if (width >= 100) {
			      clearInterval(id);
			    } else {
			      width++; 
			      pro.style.width = width + '%'; 
			      pro.innerHTML = width + "%"; 
			    }
 
			    if (width == 100 ) {
 
			    	document.getElementById("status").innerHTML = " Berhasil Di Upload ";
			    }
			  }
			}
		</script> -->

<!-- -->
<!-- <script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript">
 
			function klik() {
			  var pro = document.getElementById("pro");   
			  var width = 1;
			  var id = setInterval(kondisiPro, 170);
 
			  function kondisiPro() {
			    if (width >= 1000) {
			      clearInterval(id);
			    } else {
			      width++; 
			      pro.style.width = width + '%'; 
			      pro.innerHTML = width + "%"; 
			    }
 
			    if (width == 1000 ) {
 
			    	document.getElementById("status").innerHTML = " Uploading Complete ";
			    }
			  }
			}
		</script>  -->