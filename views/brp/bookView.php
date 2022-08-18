<body>

<div class="flipbook-viewport">
	<div class="container">
		<div class="flipbook">
                    <div class="page" style="background-image: url('<?= Yii::$app->request->baseUrl ?>/images/eBook/cover1.png');">
				<div class="body">
<!--					<div class="logo-container">
                                            <?= yii\bootstrap\Html::img('@web/images/eBook/logo.png', ['alt'=>'UMS Logo', 'class'=>'ums-logo']);?>
					</div>
					<div class="main-page-title">
						BUKU REKOD PERKHIDMATAN
					</div>-->
				</div>
			</div>
			<div class="double">
				<div class="body">
					<h3 class="title">MAKLUMAT PERIBADI</h3>

					<div class="left">
						<div class="body-info">
						<p class="info-title">Nama Kakitangan<span class="info-data"><?= ucwords(strtolower($nama->CONm))?></span>
						</p>
					</div>
					<div class="body-info">
						<p class="info-title">Rujukan No. Fail<span class="info-data"><?=  $nama->COOldID ?></span>
						</p>
					</div>
					<div class="body-info">
						<p class="info-title">Jantina<span class="info-data"> <?=  $nama->jantina->Gender ?></span>
						</p>
					</div>
					<div class="body-info">
						<p class="info-title">Taraf Perkahwinan<span class="info-data"><?=  $nama->tarafPerkahwinan->MrtlStatus ?></span>
						</p>
					</div>
					<div class="body-info">
						<p class="info-title">Tarikh Lahir<span class="info-data"><?=  $nama->tarikhLahir?></span>
						</p>
					</div>
					<div class="body-info">
						<p class="info-title">Tempat Lahir<span class="info-data"><?=  $nama->tempatLahir->State ?></span>
						</p>
					</div>
                                        <div class="body-info">
						<p class="info-title">Negara Lahir<span class="info-data"> <?=  $nama->negaraLahir->Country ?></span>
						</p>
					</div>
                                                   

					<p class="info-subtitle">Maklumat Jawatan Sekarang</p>

					<div class="body-info">
						<p class="info-title">(a) Jawatan Sekarang<span class="info-data"><?= $nama->jawatan->nama . " (" . $nama->jawatan->gred . ")";?></span>
						</p>
					</div>

					<div class="body-info">
                                                <p class="info-title">(b) Tarikh Dilantik
                                                    <span class="info-data">
                                                        <?php  if ($nama->tarikhDilantik->tarikhMula != null){
                                                            echo ": \n";   echo  $nama->tarikhDilantik->tarikhMula;  
                                                        }else{
                                                            echo ': Tiada Rekod';
                                                        } ?>
                                                    </span>
						</p>
					</div>

					<div class="body-info">
						<p class="info-title">(c) Tarikh Disahkan Dalam Jawatan
                                                    <span class="info-data">
                                                         <?php  if ($nama->sahJawatan->tarikhMula != null){
                                                             echo ": \n"; echo $nama->sahJawatan->tarikhMula;  
                                                            } else {
                                                                echo ': Tiada Rekod';
                                                                
                                                            } ?>
                                                    </span>
						</p>
					</div>

					<div class="body-info">
						<p class="info-title">(d) Jabatan Sekarang
                                                    <span class="info-data">
                                                         <?=  $nama->department->fullname ?>
                                                    </span>
						</p>
					</div>

					<p class="info-subtitle">Butir-butir Jawatan sebelum Lantikan ke UMS</p>

					<div class="body-info">
						<p class="info-title">(a) Jawatan
                                                    <span class="info-data">
                                                        <?php if($pengalaman) {
                                                            $pengalamans->PrevEmpRemarks;
                                                        } else {
                                                            echo '-';
                                                        } ?>
                                                    </span>
						</p>
					</div>

					<div class="body-info">
						<p class="info-title">(b) Tarikh Dilantik
                                                    <span class="info-data">
                                                        <?php if($pengalaman) {
                                                            $pengalamans->tarikhDilantik;
                                                        } else {
                                                            echo '-';
                                                        } ?>
                                                    </span>
						</p>
					</div>

					<div class="body-info">
						<p class="info-title">(c) Nama Majikan
                                                    <span class="info-data">
                                                        <?php if($pengalaman) {
                                                            $pengalamans->OrgNm;
                                                        } else {
                                                            echo '-';
                                                        } ?>
                                                    </span>
						</p>
					</div>

					<div class="body-info">
						<p class="info-title">Tarikh Had Umur Bersara
                                                    <span class="info-data">
                                                        <?=  $pencen->tarikhMula ?>
                                                    </span>
						</p>
					</div>

					<div class="body-info">
						<p class="info-title">Agama<span class="info-data">Islam</span>
						</p>
					</div>

					<div class="body-info">
						<p class="info-title">Bangsa<span class="info-data">Melayu</span>
						</p>
					</div>

					<div class="body-info">
						<p class="info-title">No. Kad Pengenalan<span class="info-data">1234124323</span>
						</p>
					</div>

					<div class="body-info">
						<p class="info-title">No. Sijil Kerakyatan Persekutuan dan Tarikh<span class="info-data">-</span>
						</p>
					</div>

					<div class="body-info">
						<p class="info-title">No. Pendaftaran Kumpulan Wang 
							Simpanan Pekerja<span class="info-data">-</span>
						</p>
					</div>

					<div class="body-info">
						<p class="info-title">No. Kira-kira Cukai Pendapatan (Hasil
						 Dalam Negeri)<span class="info-data">-</span>
						</p>
					</div>
					</div>
					<div class="right">
                                            <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($nama->ICNO)); ?>.jpeg" alt="gambar passport" class="passport-img">
             
					</div>

				</div>
			</div>

			<div class="double">
				<div class="body">
					<p class="info-subtitle">Waris Dekat</p>

					<div>
						<table class="table-border">
							<tr>
								<th width="15%">Bil.</th>
								<th>Nama</th>
								<th>Persaudaraan</th>
								<th>Alamat</th>
							</tr>
							<tbody>
								<tr>
									<td>1</td>
									<td>Mohd. Ali</td>
									<td>Anak Kandung</td>
									<td>UMS Kampus Labuan</td>
							</tbody>
						</table>
					</div>

					<div class="body-info">
						<p class="info-title">Kelayakan Akademik, Ijazah, Diploma dan Kelayakan Ikhtisas
                                                    <span class="info-data">
                                                        <?php foreach ($sijil as $key=>$sijils) { ?>
                                                            <?= $sijils->pendidikanTertinggi->HighestEduLevel?>,
                                                        <?php } ?>
                                                    </span>
						</p>
					</div>
				</div>
			</div>

			<div class="double">
				<div class="body">
					<h3 class="title-center">KENYATAAN PERKHIDMATAN</h3>

					<table class="table-noborder">
						<tr>
							<td style="width: 50px">Nama Kakitangan</td>
							<td>: A. ROSLEE BIN ABDUL KARIM</td>
						</tr>
						<tr>
							<td>UMS(PER)</td>
							<td>: 011111-232434</td>
						</tr>
						<tr>
							<td>Tarikh Layak Dimasukan Ke Dalam Perjawatan Berpencen</td>
							<td>: 01.11.2004</td>
						</tr>
						<tr>
							<td>Tarikh Sampai Umur Dihadkan</td>
							<td> : 19.05.2003 </td>
						</tr>
					</table>
                                        

					<div class="mt-10">
						<table class="table-border">
						<tr>
                                                    <td>Kebenaran</td>
                                                    <td>Butir-butir perubahan atau lain-lain hal mengenai Kakitangan(Lihat Panduan 5)</td>
                                                    <td>Nama Jawatan, Peringkatdan/atau Kelas(LihatPanduan5) dan/atau Kelas (Lihat Panduan 5) Tarikh Mulai Daripada</td>
                                                    <td>Berpencen, TakBerpencen, Peruntukan Terbuka</td>
                                                    <td>Gaji Sebulan (Lihat Panduan 6)</td>
                                                    <td>Tandatangan dan Tarikh</td>
						</tr>
						<tbody>
                                                    <?php foreach ($maklumat as $key => $maklumats) { ?>
                                                        <?php if($key <= 2) { ?>
                                                    
                                                    <tr>
                                                        <td>
                                                            <?php  if ($maklumats->rujukan_surat != null){
                                                                echo  $maklumats->rujukan_surat;  echo 'bth:';
                                                                   echo date("d.m.Y",  strtotime($maklumats->tarikh_surat));
                                                               }else{
                                                                   echo 'UMS(PER)';echo $maklumats->kakitangan->COOldID; "\n"; echo 'bth:';
                                                                   echo date("d.m.Y",  strtotime($maklumats->tarikh_surat));
                                                                   echo $maklumats->t_lpg_id;
                                                              }
                                                             ?>
                                                        </td>
                                                        <td>
                                                          <?= $maklumats->jenisBrp->brpTitle?> <br>
                                                          <?= $maklumats->remark?>
                                                        </td>
                                                        <td><?= $maklumats->jawatan->nama . " (" . $maklumats->jawatan->gred . ")";?></td>
                                                        <td><?= $maklumats->tarikhMulai?></td>
                                                        <td><?= $statusLabel[$maklumats->isPencen]?></td>
                                                        <td></td>
                                                        </tr>
                                                    
                                                        <?php } else { break; } ?>

                                                 <?php } ?>
					</tbody>
					</table>
					</div>
				</div>
			</div>
                    
                    <?php while($additional_page > 0){ ?>
                    
                    <div class="double">
                        <div class="body">
                            <?php 
                                array_shift($maklumat);
                                array_splice($maklumat, 0, 2); 
                            ?>
                            
                            <table class="table-border">
						
                                <tbody>
                                     <?php foreach ($maklumat as $key => $maklumats) { ?>
                                            <?php if($key <= 2) { ?>
                                    <tr>
                                        <td style="width: 35px">
                                       
                                                <?php  if ($maklumats->rujukan_surat != null){
                                                    echo  $maklumats->rujukan_surat;  echo 'bth:';
                                                       echo date("d.m.Y",  strtotime($maklumats->tarikh_surat));
                                                   }else{
                                                       echo 'UMS(PER)';echo $maklumats->kakitangan->COOldID; "<br>"; echo 'bth:';
                                                       echo date("d.m.Y",  strtotime($maklumats->tarikh_surat));
                                                       echo $maklumats->t_lpg_id;
                                                   }
                                        ?>
                                    </td>
                                            <td>
                                              <?= $maklumats->jenisBrp->brpTitle?> <br>
                                              <?= $maklumats->remark?>
                                            </td>
                                            <td><?= $maklumats->jawatan->nama . " (" . $maklumats->jawatan->gred . ")";?></td>
                                            <td><?= $maklumats->tarikhMulai?></td>
                                            <td><?= $statusLabel[$maklumats->isPencen]?></td>
                                            <td></td>
                                            </tr>

                                            <?php } else { break; } ?>

                                     <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <?php $additional_page--; } ?>
                
                    
                    
			<!-- new page  -->
		</div>
	</div>
</div>
    
    <script type="text/javascript">

function loadApp() {


	$('.flipbook').turn({
			width:922,
			
			// Height

			height:600,

			// Elevation

			elevation: 50,
			
			// Enable gradients

			gradients: true,
			
			// Auto center this flipbook

			autoCenter: true

	});
}

// Load the HTML4 version if there's not CSS transform

yepnope({
	test : Modernizr.csstransforms,
	yep: ['<?= Yii::$app->request->baseUrl ?>/js/eBook/lib/turn.js'],
	nope: ['<?= Yii::$app->request->baseUrl ?>/js/eBook/lib/turn.html4.min.js'],
	both: ['<?= Yii::$app->request->baseUrl ?>/css/basic.css'],
	complete: loadApp
});

</script>
</body>