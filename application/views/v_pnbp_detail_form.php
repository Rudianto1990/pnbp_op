<section class="content-header">
      <h1>
	  	IMPORT PNBP DETAIL
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
<div class="box">
	<div class="row" style="padding-top: 20px">
			<div class="col-md-12">
      <div class="box-body">
					<div class="progress">
					  <div class="progress-bar" id="pro" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"  aria-hidden="true"></div>
					</div>
					<br>
					<p class="alert-success" id="status"></p>
				</div>
			</div>
      </div>
    
 <div class="row">
    <div class="col-lg-12">  
        <div class="box-body">
				<form action="<?php echo site_url('pnbp_detail/form') ?>" enctype="multipart/form-data" method="post">
				<div class="form-group">
					<label>Pilih file excel PNBP Detail:</label>
					<input type="file" name="file" required/>
						<p class="help-block">Pilih file yang akan diimport dengan format .xls</p>
				</div>
                
				<input type='submit' name="preview" value="Preview" class='btn btn-success btn-md' onclick='klik()'>
				</form>
          	</div>
          </div>
          </div>
					</div>
				
					<?php
						if(isset($_POST['preview']) && !isset($upload_error)){ // Jika user menekan tombol Preview pada form
							// if(isset($upload_error)){ // Jika proses upload gagal
							// echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
							// die; // stop skrip
							// }

							$numrow = 1;
							$kosong = 0;
					?>
				<form method='post' action='<?php echo base_url("pnbp_detail/import")?>'>
				<div class="row">
        <div class="col-lg-12">
					<div class="box">
					<div class="box-header">
						<h4>Preview Data</h4>
					</div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
							
              <table id="example1" class="table table-striped table-hover" width="120%">
				  <thead>
					<tr>
                    <th>NO NOTA</th>
                    <th>NOMOR PPKB</th> 
                    <th>NO PKK INAPORTNET</th>
                    <th>ETA</th> 
                    <th>ETD</th>
                    <th>NOUKK</th>
                    <th>NAMA KAPAL</th>
                    <th>NM AGEN</th>
                    <th>KUNJUNGAN</th>
                    <th>TGL PRANOTA</th>
                    <th>TGL NOTA</th>
                    <th>PANDU IDR</th>
                    <th>TUNDA IDR</th>
                    <th>JUMLAH IDR</th>
                    <th>NOMOR PPKB1</th>
                    <th>NO</th>
                    <th>PERSEN</th>
                    <th>PNBP PANDU</th>
                    <th>PNBP TUNDA</th>
                    <th>PNBP</th>
                    <th>SETOR PNBP IDR</th>
                    <th>SPK PANDU</th>
                    <th>TGL MPANDU</th>
                    <th>TGL SPANDU</th>
                    <th>JAM PANDU NAIK</th>
                    <th>JAM PANDU TURUN</th>
                    <th>BULAN</th>
                    <th>TAHUN</th>
                    <th>PORT CODE</th>
					</tr>
				  </thead>
				  <tbody>
				  <?php
				  // Lakukan perulangan dari data yang ada di excel
					// $sheet adalah variabel yang dikirim dari controller
						foreach($sheet as $row){
							// Ambil data pada excel sesuai Kolom
                            $v1 = $row['A']; 
                            $v2 = $row['B']; 
                            $v3 = $row['C']; 
                            $v4 = $row['D']; 
                            $v5 = $row['E']; 
                            $v6 = $row['F']; 
                            $v7 = $row['G']; 
                            $v8 = $row['H']; 
                            $v9 = $row['I']; 
                            $v10 = $row['J'];
                            $v11 = $row['K'];
                            $v12 = $row['L'];
                            $v13 = $row['M'];
                            $v14 = $row['N'];
                            $v15 = $row['O'];
                            $v16 = $row['P'];
                            $v17 = $row['Q'];
                            $v18 = $row['R'];
                            $v19 = $row['S'];
                            $v20 = $row['T'];
                            $v21 = $row['U'];
                            $v22 = $row['V'];
                            $v23 = $row['W'];
                            $v24 = $row['X'];
                            $v25 = $row['Y'];
                            $v26 = $row['Z'];
                            $v27 = $row['AA'];
                            $v28 = $row['AB'];
                            $v29 = $row['AC'];

						
							if($numrow > 1){
                                $v1 = ( ! empty($v1))? $v1 : "-";
                                $v2 = ( ! empty($v2))? $v2 : "-";
                                $v3 = ( ! empty($v3))? $v3 : "-";
                                $v4 = ( ! empty($v4))? $v4 : "-";
                                $v5 = ( ! empty($v5))? $v5 : "-";
                                $v6 = ( ! empty($v6))? $v6 : "-";
                                $v7 = ( ! empty($v7))? $v7 : "-";
                                $v8 = ( ! empty($v8))? $v8 : "-";
                                $v9 = ( ! empty($v9))? $v9 : "-";
                                $v10 = ( ! empty($v10))? $v10 : "-";
                                $v11 = ( ! empty($v11))? $v11 : "-";
                                $v12 = ( ! empty($v12))? $v12 : "-";
                                $v13 = ( ! empty($v13))? $v13 : "-";
                                $v14 = ( ! empty($v14))? $v14 : "-";
                                $v15 = ( ! empty($v15))? $v15 : "-";
                                $v16 = ( ! empty($v16))? $v16 : "-";
                                $v17 = ( ! empty($v17))? $v17 : "-";
                                $v18 = ( ! empty($v18))? $v18 : "-";
                                $v19 = ( ! empty($v19))? $v19 : "-";
                                $v20 = ( ! empty($v20))? $v20 : "-";
                                $v21 = ( ! empty($v21))? $v21 : "-";
                                $v22 = ( ! empty($v22))? $v22 : "-";
                                $v23 = ( ! empty($v23))? $v23 : "-";
                                $v24 = ( ! empty($v24))? $v24 : "-";
                                $v25 = ( ! empty($v25))? $v25 : "-";
                                $v26 = ( ! empty($v26))? $v26 : "-";
                                $v27 = ( ! empty($v27))? $v27 : "-";
                                $v28 = ( ! empty($v28))? $v28 : "-";
                                $v29 = ( ! empty($v29))? $v29 : "-";

                                 /********************COVERSI DATE************/
								
                                //$dateTime = date('Y-m-d H:i:s', strtotime($v1));
                                // $date = date('Y-m-d', strtotime($dateTime));
                                // $time = date('H:i:s', strtotime($dateTime));
                                $ETA = date('Y-m-d H:i:s', strtotime($v4)); 
                                $ETD = date('Y-m-d H:i:s', strtotime($v5)); 
                                $TGL_PRANOTA = date('Y-m-d', strtotime($v10)); 
                                $TGL_NOTA= date('Y-m-d', strtotime($v11)); 
                                $TGL_MPANDU = date('Y-m-d H:i:s', strtotime($v23)); 
                                $TGL_SPANDU = date('Y-m-d H:i:s', strtotime($v24)); 
                                $JAM_PANDU_NAIK = date('Y-m-d H:i:s', strtotime($v25)); 
                                $JAM_PANDU_TURUN = date('Y-m-d H:i:s', strtotime($v26)); 
                                 /********************COVERSI DATE************/


                                
                              /********************COVERSI NOMINAL************/
                               /* $PANDU_IDR = $this->conversi->floatvalue($v12); //Catatan nilai yg di upload 1,99.00 misal 
                                $TUNDA_IDR = $this->conversi->floatvalue($v13);
                                $JUMLAH_IDR = $this->conversi->floatvalue($v14);
                                $PNBP_PANDU = $this->conversi->floatvalue($v18;
                                $PNBP_TUNDA = $this->conversi->floatvalue($v19);
                                $PNBP = $this->conversi->floatvalue($v20);
                               /********************COVERSI NOMINAL************/

                                echo "<tr>";
                                echo "<td>".$v1."</td>";
                                echo "<td>".$v2."</td>";
                                echo "<td>".$v3."</td>";
                                echo "<td>".$ETA."</td>";
                                echo "<td>".$ETD."</td>";
                                echo "<td>".$v6."</td>";
                                echo "<td>".$v7."</td>";
                                echo "<td>".$v8."</td>";
                                echo "<td>".$v9."</td>";
                                echo "<td>".$TGL_PRANOTA."</td>";
                                echo "<td>".$TGL_NOTA."</td>";
                                echo "<td>".$v12."</td>";
                                echo "<td>".$v13."</td>";
                                echo "<td>".$v14."</td>";
                                echo "<td>".$v15."</td>";
                                echo "<td>".$v16."</td>";
                                echo "<td>".$v17."</td>";
                                echo "<td>".$v18."</td>";
                                echo "<td>".$v19."</td>";
                                echo "<td>".$v20."</td>";
                                echo "<td>".$v21."</td>";
                                echo "<td>".$v22."</td>";
                                echo "<td>".$TGL_MPANDU."</td>";
                                echo "<td>".$TGL_SPANDU."</td>";
                                echo "<td>".$JAM_PANDU_NAIK."</td>";
                                echo "<td>".$JAM_PANDU_TURUN."</td>";
                                echo "<td>".$v27."</td>";
                                echo "<td>".$v28."</td>";
                                echo "<td>".$v29."</td>";

								echo "</tr>";
							}
				
							$numrow++; // Tambah 1 setiap kali looping
						}
					?>
				  </tbody>
				</table>
					<button type='submit' name='import' class='btn btn-success btn-md'>Import</button>
					<a href=<?php echo base_url("pnbp_detail") ?> type="button" class="btn btn-default">Cancel</a>
					</form>
					<?php } ?>
			</div>
			</div>
		</div>
	</div>
</div>

    </section>
    <!-- <script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript">
 
			function klik() {
			  var pro = document.getElementById("pro");   
			  var width = 1;
			  var id = setInterval(kondisiPro, 130);
 
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
