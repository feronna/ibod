<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\kehadiran\RefWp;
//use dosamigos\datepicker\DatePicker;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use app\widgets\TopMenuWidget;
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">
	<div class="x_panel">
		<div class="x_title">
			<br>
			</br>
			<h2><strong><i class="fa fa-list"></i> Ringkasan Laporan Kehadiran</strong></h2>

			<div class="clearfix"></div>

			<div class="col-xs-12 col-md-12 col-lg-12">
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-striped table-sm jambo_table table-bordered">
						<thead>
							<tr class="headings">
								<th class="text-center">Bil</th>
								<th class="text-center">Nama Anggota</th>
								<th class="text-center">Pos Kawalan</th>
								<th class="text-center">Jenis Tugas </th>
								<th class="text-center">Jenis Kesalahan</th>
								<th class="text-center">Catatan</th>


							</tr>
						</thead>
						<!-- THH -->

						<?php foreach ($thh as $k) { ?>
							<tr>
								<td class="text-center" style="text-align:center"><?= $bil++ ?></td>
								<td class="text-center" style="text-align:center"><?= $k->staff->CONm ?></td>
								<td class="text-center" style="text-align:center"><?= $k->poskawalan ?></td>
								<td class="text-center" style="text-align:center"><?= $k->type ?></td>
								<td class="text-center" style="text-align:center"><?php
																					if ($k->THH == '1') {
																						echo 'THH';
																					} elseif ($k->THLMJ == '1') {
																						echo 'THLMJ';
																					} elseif ($k->THLMT == '1') {
																						echo 'THLMT';
																					}
																					?></td>
								<td class="text-center" style="text-align:center"><?= $k->catatan ?></td>


							</tr>
						<?php } ?>

						<!-- THLMJ -->

						<?php foreach ($thlmj as $k) { ?>
							<tr>
								<td class="text-center" style="text-align:center"><?= $bil++ ?></td>
								<td class="text-center" style="text-align:center"><?= $k->staff->CONm ?></td>
								<td class="text-center" style="text-align:center"><?= $k->poskawalan ?></td>
								<td class="text-center" style="text-align:center"><?= $k->type ?></td>
								<td class="text-center" style="text-align:center"><?php
																					if ($k->THH == '1') {
																						echo 'THH';
																					} elseif ($k->THLMJ == '1') {
																						echo 'THLMJ';
																					} elseif ($k->THLMT == '1') {
																						echo 'THLMT';
																					}
																					?></td>
								<td class="text-center" style="text-align:center"><?= $k->catatan ?></td>

							</tr>
						<?php } ?>

						<!-- THLMT -->

						<?php foreach ($thlmt as $k) { ?>
							<tr>
								<td class="text-center" style="text-align:center"><?= $bil++ ?></td>
								<td class="text-center" style="text-align:center"><?= $k->staff->CONm ?></td>
								<td class="text-center" style="text-align:center"><?= $k->poskawalan ?></td>
								<td class="text-center" style="text-align:center"><?= $k->type ?></td>
								<td class="text-center" style="text-align:center"><?php
																					if ($k->THH == '1') {
																						echo 'THH';
																					} elseif ($k->THLMJ == '1') {
																						echo 'THLMJ';
																					} elseif ($k->THLMT == '1') {
																						echo 'THLMT';
																					}
																					?></td>
								<td class="text-center" style="text-align:center"><?= $k->catatan ?></td>

							</tr>
						<?php } ?>


					</table>
				</div>
			</div>
			<!--THB-->
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-striped table-sm jambo_table table-bordered">
						<thead>
							<tr class="headings">
								<th class="text-center">Bil</th>
								<th class="text-center">Nama Anggota</th>
								<th class="text-center">Pos Kawalan</th>
								<th class="text-center">Jenis Tugas(H/LMJ/LMT/KAWALAN)</th>
								<th class="text-center">Masa Masuk Tugas</th>
								<th class="text-center">Catatan</th>

							</tr>
						</thead>
						<?php foreach ($thb as $k) { ?>
							<tr>
								<td class="text-center" style="text-align:center"><?= $bil++ ?></td>
								<td class="text-center" style="text-align:center"><?= $k->staff->CONm ?></td>
								<td class="text-center" style="text-align:center"><?= $k->poskawalan ?></td>
								<td class="text-center" style="text-align:center"><?= $k->type ?></td>
								<td class="text-center" style="text-align:center"><?= $k->masa_masuk_tugas ?></td>
								<td class="text-center" style="text-align:center"><?= $k->catatan ?></td>

							</tr>
						<?php } ?>

					</table>
				</div>

			</div>
			<!--end of ringkasan-->

			<!--start of kekuatan anggota dan odometer-->
			<div class="x_title">
				<h2><strong><i class="fa fa-list"></i> Jumlah Kehadiran</strong></h2>

				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-striped table-sm jambo_table table-bordered">
						<thead>
							<tr class="headings">
								<th class="text-center">Kakitangan Jadual</th>
								<th class="text-center">Tidak Hadir</th>
								<th class="text-center">(+)LMT</th>
								<th class="text-center">(+)Tukar Syif</th>
								<th class="text-center">Jumlah Hadir</th>
							</tr>
						</thead>

						<tr>
							<td class="text-center" style="text-align:center"><?= $jumlah ?></td>
							<td class="text-center" style="text-align:center"><?= $Thadir ?></td>
							<td class="text-center" style="text-align:center"></td>
							<td class="text-center" style="text-align:center"></td>
							<td class="text-center" style="text-align:center"><?= $hadir ?></td>

						</tr>

					</table>
				</div>
			</div>

			<div class="x_title">
				<h2><strong><i class="fa fa-list"></i> Bacaan Odometer Kenderaan</strong></h2>

				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-striped table-sm jambo_table table-bordered">
						<thead>
							<tr class="headings">
								<th class="text-center">No Plate</th>
								<th class="text-center">Akhir</th>
								<th class="text-center">Mula</th>
								<th class="text-center">Jumlah Jarak (KM)</th>
							</tr>
						</thead>
						<?php foreach ($odometer as $k) { ?>
							<tr>
								<td class="text-center" style="text-align:center"><?= $k->plate_num ?></td>
								<td class="text-center" style="text-align:center"><?= $k->end_odo ?></td>
								<td class="text-center" style="text-align:center"><?= $k->start_odo ?></td>
								<td class="text-center" style="text-align:center"><?= $k->distance ?></td>

							</tr>
						<?php } ?>


					</table>
				</div>
			</div>
			<div class="x_title">
				<h2><strong><i class="fa fa-list"></i> Ulasan Penyelia Bertugas</strong></h2>

				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-striped table-sm jambo_table table-bordered">
						<thead>
							<tr class="headings">
								<th class="text-center">Ulasan</th>

							</tr>
						</thead>
						<?php foreach ($ulasan as $k) { ?>
							<tr>
								<td class="text-center" style="text-align:left"><?= $k->laporan ?></td>

							</tr>
						<?php } ?>


					</table>
				</div>
			</div>


			<div class="x_title">
				<h2><strong><i class="fa fa-list"></i> Ulasan Pegawai Medan</strong></h2>

				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-striped table-sm jambo_table table-bordered">
						<thead>
							<tr class="headings">
								<th class="text-center">Ulasan</th>

							</tr>
						</thead>
						<tr>
							<td class="text-center" style="text-align:left"><?= $pm ?></td>

						</tr>


					</table>
				</div>
			</div>

			<div class="clearfix"></div>

			<div class="x_panel">
				<div class="form-group">

					<div class="div1" style="text-align:left; float:left; width:35%;">
						<input type="text" class="form-control" value="<?= $s_name->CONm . ' ' . $v_sender->report_dt ?>" disabled="">

						<label style="text-align:center;" class="control-label col-md-6 col-sm-6 col-xs-12">Pegawai Bertugas</label>

						<label style="text-align:center;" class="control-label col-md-6 col-sm-6 col-xs-12">
					</div>

					<div class="div1" style="text-align:right; float:right; width:50%;">
						<input type="text" class="form-control" value="<?= $v_name . ' ' . $v_date ?>" disabled="">

						<?php if ($verifier) { ?>
							<label style="text-align:center;" class="control-label col-md-6 col-sm-6 col-xs-12">Pegawai Medan Bertugas</label>

						<?php } else { ?>
							<label style="text-align:center;" class="control-label col-md-6 col-sm-6 col-xs-12">

								<?php

								echo Html::button('Klik Untuk Pengesahan Laporan', ['value' => Url::to([
									'/keselamatan/verifying', 'id' => Yii::$app->user->identity->ICNO, 'syif' => Yii::$app->getRequest()->getQueryParam('syif'),
									'date' => Yii::$app->getRequest()->getQueryParam('date')
								]), 'class' => 'fa fa-edit mapBtn ', 'id' => 'modalButton']);
								?></label>

						<?php } ?>

						</label>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>