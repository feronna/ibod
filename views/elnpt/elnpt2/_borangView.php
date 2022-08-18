<?php
/* @var $this yii\web\View */

use yii\widgets\DetailView;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\dialog\Dialog;
use yii\bootstrap\Modal;
use app\models\elnpt\elnpt2\TblPnP;

$abc = 1;

?>



<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Maklumat Guru</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<?=
				DetailView::widget([
					'model' => $lpp,
					'attributes' => [
						[
							'label' => 'Tahun Penilaian',
							'value' => function ($model) {
								return $model->tahun;
							},
							'captionOptions' => ['style' => 'width:20%'],
						],
						[
							'label' => 'Tempoh Pengisian',
							'value' => function ($model) {
								return Yii::$app->formatter->asDate($model->tahunLpp->lpp_trkh_hantar, 'dd/MM/yyyy') . ' hingga ' . Yii::$app->formatter->asDate($model->tahunLpp->pengisian_PYD_tamat, 'dd/MM/yyyy');
							},

						],
						[
							'label' => 'Nama',
							'value' => function ($model) {
								return $model->guru->CONm;
							},
						],
						[
							'label' => 'Gred / Jawatan',
							'value' => function ($model) {
								return $model->gredGuru->fname;
							}
						],
						[
							'label' => 'No. UMSPER',
							'value' => function ($model) {
								return $model->guru->COOldID;
							},
						],
						[
							'label' => 'No. Kad Pengenalan / No. Passport',
							'value' => function ($model) {
								return $model->guru->ICNO;
							},
						],
						[
							'label' => 'J/S/P/I/U',
							'value' => function ($model) {
								return $model->deptGuru->fullname;
							},
						],
						[
							'label' => 'PPP',
							'value' => function ($model) {
								return is_null($model->ppp) ? '<b>Pegawai Penilai Pertama Belum Ditetapkan. Sila Berhubung dengan Penetap Penilai di J/S/P/I/U anda.</b>' : $model->ppp->CONm;
							},
							'format' => 'html',
						],
						[
							'label' => 'PPK',
							'value' => function ($model) {
								return is_null($model->ppk) ? '<b>Pegawai Penilai Kedua Belum Ditetapkan. Sila Berhubung dengan Penetap Penilai di J/S/P/I/U anda.</b>' : $model->ppk->CONm;
								return $model->ppk->CONm;
							},
							'format' => 'html',
						],
						[
							'label' => 'PEER',
							'value' => function ($model) {
								return is_null($model->peer) ? '<b>Peer Belum Ditetapkan. Sila Berhubung dengan Penetap Penilai di J/S/P/I/U anda.</b>' : '<b>Peer Sudah Ditetapkan.</b>';
							},
							'format' => 'html',
						],
						[
							'label' => 'CATATAN',
							'value' => function ($model) {
								return $model->catatan;
							},
						],
					],
				]);
				?>
			</div>
		</div>
	</div>
</div>

<pagebreak />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Bahagian 1 : Pengajaran & Pembelajaran (P&P)</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">

					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center" rowspan="2">BIL.</th>
							<th class="text-center" rowspan="2">KOD KURSUS</th>
							<th class="text-center" rowspan="2">NAMA KURSUS</th>
							<th class="text-center" rowspan="2">SKOP TUGAS</th>
							<th class="text-center" rowspan="2">STATUS PENGENDALIAN</th>
							<th class="text-center" rowspan="2">PENGLIBATAN TUTOR / DEMONSTRATOR</th>
							<th class="text-center" rowspan="2">SEKSYEN</th>
							<th class="text-center" rowspan="2">BIL. PELAJAR</th>
							<th class="text-center" rowspan="2">SEMESTER</th>
							<th class="text-center" rowspan="2">STATUS KURSUS</th>
							<th class="text-center" colspan="3">JAM F2F UNTUK 14 MINGGU</th>

							<th class="text-center" rowspan="2">STATUS FAIL PENGAJARAN</th>

							<th class="text-center" rowspan="2">STATUS Smartv3</th>
							<th class="text-center" rowspan="2">PK07 (DELIVERY OF LECTURES)</th>
							<th class="text-center" rowspan="2">DOKUMEN SOKONGAN</th>
							<?php if ($lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0) { ?>
								<th class="text-center" rowspan="2">TINDAKAN</th>
							<?php } ?>

						</tr>
						<tr>
							<th class="text-center" colspan="1">JAM SYARAHAN
								<small><a data-toggle="tooltip" data-placement="top" title="Per Semester (Face-to-face)">
										<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									</a></small>
							</th>
							<th class="text-center" colspan="1">JAM TUTORIAL
								<small><a data-toggle="tooltip" data-placement="top" title="Per Semester (Face-to-face)">
										<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									</a></small>
							</th>
							<th class="text-center" colspan="1">JAM MAKMAL / LAIN-LAIN
								<small><a data-toggle="tooltip" data-placement="top" title="Per Semester (Face-to-face)">
										<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									</a></small>
							</th>
						</tr>

						<?php if (empty($dataBhg1)) { ?>
							<tr>
								<td colspan="17">Tiada rekod dijumpai.</td>
							</tr>

							<?php } else {
							foreach ($dataBhg1 as $ind => $dt) {
								if (!isset($inputBhg1[$ind])) {

									$inputBhg1[$ind] = new TblPnP();
								}
							?>

								<?php


								echo Html::activeHiddenInput($inputBhg1[$ind], "[$ind]id_pnp");

								?>

								<tr>
									<td class="col-md-1 text-center" style="text-align:center"><?= $abc++; ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['kod_kursus']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['nama_kursus']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center">
										<?= $dt['skop_tugas'] == 'Pensyarah_Penyelaras' ? 'Pensyarah & Penyelaras' : $dt['skop_tugas'];
										?>
									</td>
									<td class="col-md-1 text-center" style="text-align:center">
										<?= $dt['status_pengendalian'];
										?>

									</td>
									<td class="col-md-1 text-center" style="text-align:center">
										<?= $dt['penglibatan'];
										?>

									</td>
									<td class="col-md-1 text-center" style="text-align:center">
										<?= ($dt['manual'] == '0') ? $dt['SEKSYEN'] :  $dt['seksyen']; ?>
									</td>
									<td class="col-md-1 text-center" style="text-align:center">
										<?= $dt['bil_pelajar'] ?>
									</td>
									<td class="col-md-1 text-center" style="text-align:center">
										<?= $dt['semester']; ?>
									</td>
									<td class="text-center" style="text-align:center">
										<?= $dt['status_kursus']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['jam_syarahan']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['jam_tutorial']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['jam_amali']; ?></td>

									<td class="text-center" style="text-align:center">
										<?= $dt['status_fail']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center">
										<?php if (isset($dt['status'])) { ?>
											<?= ($dt['status'] == 'Pass') ? '<font color="green">PASS</font>' :
												'<font color="red">FAIL</font>'; ?>
										<?php } else {
											echo '<font color="orange">UNAVAILABLE</font>';
										}
										?>
									</td>

									<td class="col-md-1 text-center" style="text-align:center">
										<?= Yii::$app->formatter->asDecimal($dt['pk07']); ?>
									</td>

									<?php if ($dt['manual'] == '1') {
									?>
										<td class="col-md-2 text-center" style="text-align:center"><?= (!$check) ? Html::button('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',  ['value' => Url::to(['elnpt2/update-pnp', 'id' => $ind, 'lppid' => $lppid]), 'class' => 'btn btn-default btn-sm modalButton']) : ''; ?>
											<?= (!$check) ? Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['elnpt2/delete-pnp', 'id' => $ind, 'lppid' => $lppid]), [
												'class' => 'btn btn-default btn-sm',
											]) : ''; ?></td>
									<?php
									} else { ?>
										<td class="col-md-2 text-center" style="text-align:center">SMP UMS</td>

									<?php }
									?>

								</tr>
						<?php }
						} ?>
					</table>

				</div>
				<div style="clear: both;"><br>
					<hr>
					<dl class="dl-horizontal">
						<dt>Jenis Syarahan</dt>
						<dd></dd>
						<dt>Hakiki</dt>
						<dd>Subjek yang tidak dibayar elaun tambahan.</dd>
						<dt>Berbayar</dt>
						<dd>Subjek yang dibayar elaun tambahan selain gaji bulanan.</dd>
					</dl>
					<p><strong>Nota : Skor PK07 (Delivery of Lectures) bagi subjek Semester 1 Sesi 2020 / 2021 dikira berdasarkan data yang diterima setakat 11 Februari 2021 sahaja.</strong></p>

				</div>
			</div>
		</div>
	</div>
</div>

<hr />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Aspek Penilaian</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center">Aspek Penilaian</th>
							<?php if ($bahagian1->id != 10) { ?>
								<th class="text-center col-md-2">Markah PYD</th>
								<th class="text-center col-md-2">Markah PPP</th>
								<th class="text-center col-md-2">Markah PPK</th>
							<?php } ?>
							<?php if ($bahagian1->id == 10) { ?>
								<th class="text-center col-md-2">Markah PEER</th>
							<?php } ?>
						</tr>
						<?php foreach ($mrkh_bhg1 as $ind => $all) { ?>
							<tr>
								<th><?= $all['desc']; ?></th>
								<?php if ($bahagian1->id != 10) { ?>
									<th class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDecimal($all['markah_pyd']); ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub> </th>

									<th class="col-md-1 text-center" style="text-align:center">

										<?= is_null($all['markah_ppp']) ? 'PPP' : $all['markah_ppp'] ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

									</th>
									<th class="col-md-1 text-center" style="text-align:center">

										<?= is_null($all['markah_ppk']) ? 'PPK' : $all['markah_ppk'] ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

									</th>
								<?php } ?>
								<?php if ($bahagian1->id == 10) { ?>
									<th class="col-md-1 text-center" style="text-align:center">

										<?= is_null($all['markah_peer']) ? 'PEER' : $all['markah_peer'] ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

									</th>
								<?php } ?>
							</tr>
						<?php } ?>
						<tr>
							<th style="text-align:right">JUMLAH</th>
							<?php if ($bahagian1->id != 10) { ?>
								<th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg1, 'markah_pyd')), 2); ?></th>
							<?php } ?>
							<?php if ($bahagian1->id != 10) { ?>
								<th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg1, 'markah_ppp')), 2); ?></th>
								<th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg1, 'markah_ppk')), 2); ?></th>
							<?php } ?>
							<?php if ($bahagian1->id == 10) { ?>
								<th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg1, 'markah_peer')), 2); ?></th>
							<?php } ?>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<hr />

<?= $this->render('//elnpt/elnpt2/_skor', ['bahagian' => $bahagian1, 'ruberik' => $aspek1]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_rubrik', ['bahagian' => $bahagian1, 'ruberik' => $aspek1, 'lpp' => isset($lpp) ? $lpp : false]); ?>

<pagebreak />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Bahagian 2 : Penyeliaan</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center" rowspan="3">BIL.</th>
							<th class="text-center col-md-4" rowspan="3">TAHAP PENYELIAAN</th>
							<th class="text-center" colspan="6">BILANGAN PELAJAR DISELIA YANG AKTIF (TERKUMPUL)</th>
							<!-- <th class="text-center" rowspan="3">DOKUMEN SOKONGAN</th> -->

							<th class="text-center" rowspan="3">VERIFIKASI (PPP)</th>
						</tr>
						<tr>
							<th class="text-center" colspan="3">SEBAGAI PENYELIA UTAMA/PENGERUSI</th>
							<th class="text-center" colspan="3">SEBAGAI PENYELIA BERSAMA/AHLI</th>
						</tr>
						<tr>
							<th class="text-center">BELUM PERLANJUTAN</th>
							<th class="text-center">TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)</th>
							<th class="text-center">TELAH PERLANJUTAN</th>
							<th class="text-center">BELUM PERLANJUTAN</th>
							<th class="text-center">TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)</th>
							<th class="text-center">TELAH PERLANJUTAN</th>
						</tr>
						<?php
						$cnt = 1;
						foreach ($dataBhg2 as $ind => $data) { ?>
							<tr>
								<td class="text-center"><?= $cnt; ?></td>
								<td><?php
									switch ($data['tahap_penyeliaan']) {
										case 1:
											echo 'Sarjana (Penyelidikan)';
											break;
										case 2:
											echo 'DrPH (Doctor of Public Health)';
											break;
										case 3:
											echo 'PhD (Penyelidikan)';
											break;
										case 4:
											echo 'Sarjana (Kerja Kursus)';
											break;
										case 5:
											echo 'Sarjana Muda (Projek Tahun Akhir/ Latihan Industri/ Latihan Amali/ Praktikum/ PUPUK)';
											break;
										case 6:
											echo 'PhD (Penyelidikan) - Penyeliaan Luar';
											break;
										case 7:
											echo 'Sarjana (Penyelidikan) - Penyeliaan Luar';
											break;
										case 8:
											echo 'DrPH (Doctor of Public Health) - Penyeliaan Luar';
											break;
									}
									?></td>
								<td class="text-center"><?= $data['utama_belum'] ?></td>
								<td class="text-center"><?= $data['utama_telah_sem'] ?></td>
								<td class="text-center"><?= $data['utama_telah'] ?></td>
								<td class="text-center"><?= $data['sama_belum'] ?></td>
								<td class="text-center"><?= $data['sama_telah_sem'] ?></td>
								<td class="text-center"><?= $data['sama_telah'] ?></td>
								<!-- <td class="text-center"><?= isset($data['verified_by']) ? (($data['verified_by'] != 'SYSTEM') ? 'VERIFIED BY PPP' : 'SYSTEM') : 'UNVERIFIED'; ?></td> -->
								<td class="text-center"><?= isset($data['verified_by']) ? (($data['verified_by'] != 'SYSTEM') ? 'VERIFIED' : 'SYSTEM') : 'UNVERIFIED'; ?></td>
							</tr>
						<?php $cnt++;
						} ?>

					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<hr />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Aspek Penilaian</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center">Aspek Penilaian</th>
							<?php if ($bahagian2->id != 10) { ?>
								<th class="text-center col-md-2">Markah PYD</th>
								<th class="text-center col-md-2">Markah PPP</th>
								<th class="text-center col-md-2">Markah PPK</th>
							<?php } ?>
							<?php if ($bahagian2->id == 10) { ?>
								<th class="text-center col-md-2">Markah PEER</th>
							<?php } ?>
						</tr>
						<?php foreach ($mrkh_bhg2 as $ind => $all) { ?>
							<tr>
								<th><?= $all['desc']; ?></th>
								<?php if ($bahagian2->id != 10) { ?>
									<th class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDecimal($all['markah_pyd']); ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub> </th>

									<th class="col-md-1 text-center" style="text-align:center">

										<?= is_null($all['markah_ppp']) ? 'PPP' :  $all['markah_ppp'] ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

									</th>
									<th class="col-md-1 text-center" style="text-align:center">

										<?= is_null($all['markah_ppk']) ? 'PPK' :  $all['markah_ppk'] ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

									</th>
								<?php } ?>
								<?php if ($bahagian2->id == 10) { ?>
									<th class="col-md-1 text-center" style="text-align:center">

										<?= is_null($all['markah_peer']) ? 'PEER' :  $all['markah_peer'] ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

									</th>
								<?php } ?>
							</tr>
						<?php } ?>
						<tr>
							<th style="text-align:right">JUMLAH</th>
							<?php if ($bahagian2->id != 10) { ?>
								<th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg2, 'markah_pyd')), 2); ?></th>
							<?php } ?>
							<?php if ($bahagian2->id != 10) { ?>
								<th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg2, 'markah_ppp')), 2); ?></th>
								<th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg2, 'markah_ppk')), 2); ?></th>
							<?php } ?>
							<?php if ($bahagian2->id == 10) { ?>
								<th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg2, 'markah_peer')), 2); ?></th>
							<?php } ?>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<hr />

<?= $this->render('//elnpt/elnpt2/_skor', ['bahagian' => $bahagian2, 'ruberik' => $aspek2]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_rubrik', ['bahagian' => $bahagian2, 'ruberik' => $aspek2, 'lpp' => isset($lpp) ? $lpp : false]); ?>

<pagebreak />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Bahagian 3 : Penyelidikan</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center">BIL.</th>
							<th class="text-center">PROJEK ID</th>
							<th class="text-center col-md-4">TAJUK PROJEK</th>
							<th class="text-center">PERANAN</th>
							<th class="text-center col-md-2">PEMBIAYA</th>
							<th class="text-center col-md-2">KATEGORI PEMBIAYA</th>
							<th class="text-center col-md-2">JUMLAH BIAYA (RM)</th>
							<th class="text-center">MULA</th>
							<th class="text-center">TAMAT</th>
							<th class="text-center">STATUS</th>
							<th class="text-center">DOKUMEN SOKONGAN</th>
						</tr>
						<?php if (empty($dataBhg3)) { ?>
							<tr>
								<td colspan="10">Tiada rekod dijumpai.</td>
							</tr>
							<?php } else {
							foreach ($dataBhg3 as $ind => $dt) { ?>
								<tr>
									<td class="col-md-2 text-center" style="text-align:center">
										<?= $ind + 1; ?>
										<?= ($dt['Display'] == 1 && $lpp->PYD == Yii::$app->user->identity->ICNO  && $lpp->PYD_sah == 0 and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)
											or ($dt['Display'] == 1 and $lpp->PYD == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt2/update-penyelidikan', 'id' => $dt['ID'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt2/delete-penyelidikan', 'id' => $dt['ID'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
									</td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['ProjectID']; ?></td>
									<td class="col-md-2"><?= $dt['Title']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['Peranan']; ?></td>
									<td class="col-md-1 text-center"><?= $dt['AgencyName']; ?></td>
									<td class="col-md-3 text-center"><?php
																		switch ($dt['Tahap_geran']):
																			case '1':
																				echo 'GERAN UNIVERSITI';
																				break;
																			case '2':
																				echo 'GERAN LUAR (TEMPATAN)';
																				break;
																			case '3':
																				echo 'GERAN LUAR (ANTARABANGSA)';
																				break;
																			default:
																				echo $dt['Tahap_geran'];
																				break;
																		endswitch;
																		?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= is_null($dt['Amount']) ? 'RM 0' : Yii::$app->formatter->asCurrency($dt['Amount'], 'RM '); ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDate($dt['StartDate'], 'yyyy'); ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDate($dt['EndDate'], 'yyyy'); ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['Status_geran']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center">
										<?= empty($dt['file_hash']) ? 'SYSTEM' : Html::a("<i class='fa fa-file ' aria-hidden='true'></i>
                        ", Url::to(Yii::$app->FileManager->DisplayFile($dt['file_hash']), true), ['target' => '_blank', 'class' => 'btn btn-xs btn-default']) . '<br>' . (!empty($dt['ver_by']) ? '<font color="green">Verified</font>' : '<font color="red">Unverified</font>') . '<br>' . Html::checkbox('agree', !empty($dt['ver_by']) ? true : false, [
											'label' => 'Verify',
											'onclick' => "
                                            $.ajax({
                                                type: 'POST',
                                                url: '" . Url::to(['elnpt2/verify-document', 'lppid' => $lppid, 'filehash' => $dt['file_hash']]) . "',

                                                success: function(result) {
                                                    if(result == 1) {
                                                            setTimeout(function(){
                                                            location.reload(); // then reload the page.(3)
                                                        }, 1); 
                                                    } else {
                                                    }
                                                }, 
                                                error: function(result) {
                                                    console.log(\"Ada Error\");
                                                }
                                            });
                                        ",

										]); ?>
									</td>
								</tr>
						<?php

								$sum += $dt['Amount'];
							}
						} ?>
						<tr>
							<th colspan="7" style="text-align:right">Jumlah Geran (RM)</th>
							<td style="text-align:center"><?= Yii::$app->formatter->asDecimal($sum); ?></td>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</table>
				</div>

				<p><b>Bilangan Permohonan : </b><?= $grant; ?>
			</div>
		</div>
	</div>
</div>

<hr />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Aspek Penilaian</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center">Aspek Penilaian</th>
							<?php if ($bahagian3->id != 10) { ?>
								<th class="text-center col-md-2">Markah PYD</th>
								<th class="text-center col-md-2">Markah PPP</th>
								<th class="text-center col-md-2">Markah PPK</th>
							<?php } ?>
							<?php if ($bahagian3->id == 10) { ?>
								<th class="text-center col-md-2">Markah PEER</th>
							<?php } ?>
						</tr>
						<?php foreach ($mrkh_bhg3 as $ind => $all) { ?>
							<tr>
								<th><?= $all['desc']; ?></th>
								<?php if ($bahagian3->id != 10) { ?>
									<th class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDecimal($all['markah_pyd']); ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub> </th>

									<th class="col-md-1 text-center" style="text-align:center">

										<?= is_null($all['markah_ppp']) ? 'PPP' :  $all['markah_ppp'] ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

									</th>
									<th class="col-md-1 text-center" style="text-align:center">

										<?= is_null($all['markah_ppk']) ? 'PPK' :  $all['markah_ppk'] ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

									</th>
								<?php } ?>
								<?php if ($bahagian3->id == 10) { ?>
									<th class="col-md-1 text-center" style="text-align:center">

										<?= is_null($all['markah_peer']) ? 'PEER' :  $all['markah_peer'] ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

									</th>
								<?php } ?>
							</tr>
						<?php } ?>
						<tr>
							<th style="text-align:right">JUMLAH</th>
							<?php if ($bahagian3->id != 10) { ?>
								<th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg2, 'markah_pyd')), 2); ?></th>
							<?php } ?>
							<?php if ($bahagian3->id != 10) { ?>
								<th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg2, 'markah_ppp')), 2); ?></th>
								<th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg2, 'markah_ppk')), 2); ?></th>
							<?php } ?>
							<?php if ($bahagian3->id == 10) { ?>
								<th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg2, 'markah_peer')), 2); ?></th>
							<?php } ?>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<hr />

<?= $this->render('//elnpt/elnpt2/_skor', ['bahagian' => $bahagian3, 'ruberik' => $aspek3]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_rubrik', ['bahagian' => $bahagian3, 'ruberik' => $aspek3, 'lpp' => isset($lpp) ? $lpp : false]); ?>

<pagebreak />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Bahagian 4 : Penerbitan</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center">BIL.</th>
							<th class="text-center">JENIS PENERBITAN</th>
							<th class="text-center">TAJUK</th>
							<th class="text-center">TAHUN TERBIT</th>
							<th class="text-center">STATUS PENULIS</th>
							<th class="text-center">STATUS INDEKS</th>
							<th class="text-center">STATUS PENERBITAN</th>
						</tr>
						<?php if (empty($dataBhg4)) { ?>
							<tr>
								<td colspan="9">Penerbitan yang tidak tersenarai sila semak dengan pihak PPPI.</td>
							</tr>
							<?php } else {
							foreach ($dataBhg4 as $ind => $dt) { ?>
								<tr>
									<td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1 ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['Bilangan_penerbitan'] ?></td>
									<td class="col-md-2"><?= $dt['Title'] ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['PublicationYear'] ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['Status_penulis'] ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['Status_indeks'] ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?php
																								echo $dt['Status_penerbitan'];
																								?></td>

								</tr>
						<?php }
						} ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<hr />

<?= $this->render('//elnpt/elnpt2/_aspek_nilai', ['bahagian' => $bahagian4, 'mrkh_bhg' => $mrkh_bhg4]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_skor', ['bahagian' => $bahagian4, 'ruberik' => $aspek4]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_rubrik', ['bahagian' => $bahagian4, 'ruberik' => $aspek4, 'lpp' => isset($lpp) ? $lpp : false]); ?>

<pagebreak />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Bahagian 5 : Persidangan</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center">BIL.</th>
							<th class="text-center">KATEGORI</th>
							<th class="text-center">NAMA PERSIDANGAN</th>
							<th class="text-center">PERANAN</th>
							<th class="text-center">TAHAP PENYERTAAN</th>
							<th class="text-center">STATUS PENYERTAAN</th>
							<th class="text-center">DOKUMEN SOKONGAN</th>
						</tr>
						<?php if (empty($dataBhg5)) { ?>
							<tr>
								<td colspan="6">Tiada rekod dijumpai.</td>
							</tr>
							<?php } else {
							foreach ($dataBhg5 as $ind => $dt) { ?>
								<tr>
									<td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1 ?> <?= ($dt['id'] != '0' && $lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0
																													or ($dt['id'] != '0' and $lpp->PYD == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt2/update-persidangan', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt2/delete-persidangan', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
										<?= ($dt['id'] != '0' && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
									<td class="col-md-1 text-center"><?= $dt['Bilangan_Persidangan_dan_Inovasi']; ?></td>
									<td class="col-md-5"><?= $dt['ConferenceTitle']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= ($lppid == '21809' && $ind == 0) ? 'Pembentang' : $dt['Peranan_dalam_projek_Inovasi']; ?></td>
									<td class="col-md-1 text-center"><?= $dt['Tahap_penyertaan']; ?></td>
									<td class="col-md-1 text-center">
										<?= $dt['StatusConference'] != 'Verified' ? '<font style="color:orange">' : '<font style="color:green">'; ?><?= $dt['StatusConference'] != 'Verified' ? '-' : $dt['StatusConference']; ?></font>
									</td>
									<td class="col-md-1 text-center" style="text-align:center">
										<?= empty($dt['file_hash']) ? 'SYSTEM' : Html::a("<i class='fa fa-file ' aria-hidden='true'></i>
                        ", Url::to(Yii::$app->FileManager->DisplayFile($dt['file_hash']), true), ['target' => '_blank', 'class' => 'btn btn-xs btn-default']) . '<br>' . (!empty($dt['ver_by']) ? '<font color="green">Verified</font>' : '<font color="red">Unverified</font>') . '<br>' . Html::checkbox('agree', !empty($dt['ver_by']) ? true : false, [
											'label' => 'Verify',
											'onclick' => "
                                            $.ajax({
                                                type: 'POST',
                                                url: '" . Url::to(['elnpt2/verify-document', 'lppid' => $lppid, 'filehash' => $dt['file_hash']]) . "',

                                                success: function(result) {
                                                    if(result == 1) {
                                                            setTimeout(function(){
                                                            location.reload(); // then reload the page.(3)
                                                        }, 1); 
                                                    } else {
                                                    }
                                                }, 
                                                error: function(result) {
                                                    console.log(\"Ada Error\");
                                                }
                                            });
                                        ",

										]); ?>
									</td>
								</tr>
						<?php }
						} ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<hr />

<?= $this->render('//elnpt/elnpt2/_aspek_nilai', ['bahagian' => $bahagian5, 'mrkh_bhg' => $mrkh_bhg5]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_skor', ['bahagian' => $bahagian5, 'ruberik' => $aspek5]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_rubrik', ['bahagian' => $bahagian5, 'ruberik' => $aspek5, 'lpp' => isset($lpp) ? $lpp : false]); ?>

<pagebreak />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Bahagian 6 : Outreaching</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center">BIL.</th>
							<th class="text-center">KATEGORI PERUNDINGAN</th>
							<th class="text-center">NAMA PROJEK/AKTIVITI</th>
							<th class="text-center">PERANAN</th>
							<th class="text-center">TAHAP PENYERTAAN</th>
							<th class="text-center">AMAUN GERAN</th>
							<th class="text-center">DOKUMEN SOKONGAN</th>
						</tr>
						<?php if (empty($dataBhg6)) { ?>
							<tr>
								<td colspan="7">Tiada rekod dijumpai.</td>
							</tr>
							<?php } else {
							foreach ($dataBhg6 as $ind => $dt) { ?>
								<tr>
									<td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1 ?> <?= ($dt['id'] != '0' && ($lpp->PYD == \Yii::$app->user->identity->ICNO ? !$check : false)
																													// or ($dt['id'] != '0' and $lpp->PYD == \Yii::$app->user->identity->ICNO  
																													// // and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO)
																													// )
																												) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt2/update-outreaching', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt2/delete-outreaching', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
										<?= ($dt['id'] != '0' && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['Bilangan_outreaching']; ?></td>
									<td class="col-md-2 "><?= $dt['Title']; ?></td>
									<td class="col-md-2 text-center"><?= $dt['Peranan_outreaching']; ?></td>
									<td class="col-md-1 text-center"><?= $dt['Tahap_outreaching']; ?></td>
									<td class="col-md-1 text-center"><?= is_numeric($dt['Amaun_outreaching']) ? Yii::$app->formatter->asCurrency($dt['Amaun_outreaching'], 'RM ') : $dt['Amaun_outreaching']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center">
										<?= empty($dt['file_hash']) ? 'SYSTEM' : Html::a("<i class='fa fa-file ' aria-hidden='true'></i>
                        ", Url::to(Yii::$app->FileManager->DisplayFile($dt['file_hash']), true), ['target' => '_blank', 'class' => 'btn btn-xs btn-default']) . '<br>' . (!empty($dt['ver_by']) ? '<font color="green">Verified</font>' : '<font color="red">Unverified</font>') . '<br>' ?>
										<?php
										echo $this->render('_verifyPPP', [
											'ind' => $ind,
											'lpp' => $lpp,
											'check' => $check,
											'lppid' => $lppid,
											'file_hash' => $dt['file_hash'],
											'ver_by' => $dt['ver_by'],
										]);
										?>
									</td>
								</tr>
						<?php }
						} ?>
					</table>
				</div>

				<div style="clear: both;"><br>
					<hr>
					<p><i>* Kursus yang ditambah secara manual oleh PYD.</i></p>
				</div>
			</div>
		</div>
	</div>
</div>

<hr />

<?= $this->render('//elnpt/elnpt2/_aspek_nilai', ['bahagian' => $bahagian6, 'mrkh_bhg' => $mrkh_bhg6]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_skor', ['bahagian' => $bahagian6, 'ruberik' => $aspek6]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_rubrik', ['bahagian' => $bahagian6, 'ruberik' => $aspek6, 'lpp' => isset($lpp) ? $lpp : false]); ?>

<pagebreak />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Bahagian 7 : Pengurusan dan Pentadbiran</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center">BIL.</th>
							<th class="text-center">KATEGORI JAWATANKUASA</th>
							<th class="text-center">NAMA JAWATANKUASA</th>
							<th class="text-center">PERANAN</th>
							<th class="text-center">TAHAP LANTIKAN</th>
							<th class="text-center">DOKUMEN SOKONGAN</th>
						</tr>
						<?php if (empty($dataBhg7)) { ?>
							<tr>
								<td colspan="5">Tiada rekod dijumpai.</td>
							</tr>
							<?php } else {
							foreach ($dataBhg7 as $ind => $dt) { ?>
								<tr>
									<td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1 ?> <?= ($dt['id'] != '0' && ($lpp->PYD == \Yii::$app->user->identity->ICNO ? !$check : false)
																													// or ($dt['id'] != '0' and $lpp->PYD == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))
																												) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt2/update-urus-tadbir', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt2/delete-urus-tadbir', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
										<?= ($dt['id'] != '0' && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
									<td class="col-md-2 text-center" style="text-align:center"><?= $dt['Bilangan_jawatankuasa']; ?></td>
									<td class="col-md-2 "><?= $dt['nama_jawatan']; ?></td>
									<td class="col-md-1 text-center"><?= !isset($dt['Peranan_jawatankuasa']) ? '(not set)' : $dt['Peranan_jawatankuasa']; ?></td>
									<td class="col-md-1 text-center"><?= !isset($dt['Tahap_jawatankuasa']) ? '(not set)' : $dt['Tahap_jawatankuasa']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center">
										<?php if (empty($dt['file_hash'])) {
											echo 'SYSTEM';
										} else {
											try {
												echo  Html::a("<i class='fa fa-file ' aria-hidden='true'></i>
                        ", Url::to(Yii::$app->FileManager->DisplayFile($dt['file_hash']), true), ['target' => '_blank', 'class' => 'btn btn-xs btn-default']) . '<br>' . (!empty($dt['ver_by']) ? '<font color="green">Verified</font>' : '<font color="red">Unverified</font>') . '<br>' .  $this->render('_verifyPPP', [
													'ind' => $ind,
													'lpp' => $lpp,
													'check' => $check,
													'lppid' => $lppid,
													'file_hash' => $dt['file_hash'],
													'ver_by' => $dt['ver_by'],
												]);
											} catch (Exception $e) {
												echo '<font color="orange">Error fetching file!</font>';
											}
										} ?>
									</td>
								</tr>
						<?php }
						} ?>
					</table>
				</div>

				<div style="clear: both;"><br>
					<hr>
					<p><i>* Kursus yang ditambah secara manual oleh PYD.</i></p>
				</div>
			</div>
		</div>
	</div>
</div>

<hr />

<?= $this->render('//elnpt/elnpt2/_aspek_nilai', ['bahagian' => $bahagian7, 'mrkh_bhg' => $mrkh_bhg7]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_skor', ['bahagian' => $bahagian7, 'ruberik' => $aspek7]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_rubrik', ['bahagian' => $bahagian7, 'ruberik' => $aspek7, 'lpp' => isset($lpp) ? $lpp : false]); ?>

<pagebreak />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Bahagian 8 : Pemindahan Teknologi dan Inovasi</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center">BIL.</th>
							<th class="text-center">KATEGORI HARTA INTELEK</th>
							<th class="text-center">NAMA PROJEK</th>
							<th class="text-center">PERANAN</th>
							<th class="text-center">TAHAP PENYERTAAN</th>
							<th class="text-center">BIL. PENERIMA IMPAK</th>
							<th class="text-center">AMAUN PROJEK</th>
							<th class="text-center">DOKUMEN SOKONGAN</th>
						</tr>
						<?php if (empty($dataBhg8)) { ?>
							<tr>
								<td colspan="8">Tiada rekod dijumpai.</td>
							</tr>
							<?php } else {
							foreach ($dataBhg8 as $ind => $dt) { ?>
								<tr>
									<td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1 ?> <?= ($dt['id'] != '0' && ($lpp->PYD == \Yii::$app->user->identity->ICNO ? !$check : false)
																													// or ($dt['id'] != '0' and $lpp->PYD == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))
																												) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt2/update-inovasi', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt2/delete-inovasi', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
										<?= ($dt['id'] != '0' && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
									<td class="col-md-3 text-center" style="text-align:center"><?= $dt['Bilangan_Persidangan_dan_Inovasi']; ?></td>
									<td class="col-md-5"><?= $dt['ConferenceTitle']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center"><?= $dt['Peranan_dalam_projek_Inovasi']; ?></td>
									<td class="col-md-1 text-center"><?= $dt['Tahap_penyertaan']; ?></td>
									<td class="col-md-1 text-center"><?= $dt['Bilangan_individu']; ?></td>
									<td class="col-md-1 text-center"><?= 'RM ' . $dt['Julat_amaun']; ?></td>
									<td class="col-md-1 text-center" style="text-align:center">
										<?= empty($dt['file_hash']) ? 'SYSTEM' : Html::a("<i class='fa fa-file ' aria-hidden='true'></i>
                        ", Url::to(Yii::$app->FileManager->DisplayFile($dt['file_hash']), true), ['target' => '_blank', 'class' => 'btn btn-xs btn-default']) . '<br>' . (!empty($dt['ver_by']) ? '<font color="green">Verified</font>' : '<font color="red">Unverified</font>') . '<br>' ?>
										<?php
										echo $this->render('_verifyPPP', [
											'ind' => $ind,
											'lpp' => $lpp,
											'check' => $check,
											'lppid' => $lppid,
											'file_hash' => $dt['file_hash'],
											'ver_by' => $dt['ver_by'],
										]);
										?>
									</td>
								</tr>
						<?php }
						} ?>
					</table>
				</div>
				<div style="clear: both;"><br>
					<hr>
					<p><i>* Kursus yang ditambah secara manual oleh PYD.</i></p>
				</div>
			</div>
		</div>
	</div>
</div>

<hr />

<?= $this->render('//elnpt/elnpt2/_aspek_nilai', ['bahagian' => $bahagian8, 'mrkh_bhg' => $mrkh_bhg8]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_skor', ['bahagian' => $bahagian8, 'ruberik' => $aspek8]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_rubrik', ['bahagian' => $bahagian8, 'ruberik' => $aspek8, 'lpp' => isset($lpp) ? $lpp : false]); ?>

<pagebreak />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Bahagian 9 : Kepimpinan Akademik</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center">BIL.</th>
							<th class="text-center">KATEGORI KEPIMPINAN</th>
							<th class="text-center">SUMBER INPUT</th>
							<th class="text-center">BILANGAN</th>
						</tr>
						<?php
						if (empty($dataBhg9)) {
						?>
							<tr>
								<td colspan="6">Tiada rekod dijumpai.</td>
							</tr>
							<?php } else {
							$cnt = 1;
							foreach ($dataBhg9 as $ind => $dt) { ?>
								<tr>
									<td class="text-center"><?= $cnt; ?></td>
									<td><?= $dt['desc']; ?></td>
									<td class="text-center"><?= $dt['sumber']; ?></td>
									<td class="text-center"><?= $dt['bilangan']; ?></td>
								</tr>
						<?php $cnt++;
							}
						} ?>
					</table>
				</div>
				<hr>
				<p><i>* Skor mentoring diambil kira untuk pensyarah gred DS53/DS54/DG54/DU54/DU56/VK sahaja.</i></p>
			</div>
		</div>
	</div>
</div>

<hr />

<?= $this->render('//elnpt/elnpt2/_aspek_nilai', ['bahagian' => $bahagian9, 'mrkh_bhg' => $mrkh_bhg9]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_skor', ['bahagian' => $bahagian1, 'ruberik' => $aspek1]); ?>

<pagebreak />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong> Bahagian 10 : Kualiti Peribadi</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center" rowspan="2">BIL.</th>
							<th class="text-center" rowspan="2">KATEGORI KUALITI</th>
							<th class="text-center" colspan="3">SUMBER INPUT</th>
						</tr>
						<tr>
							<th class="text-center">PPP <sub>/ 100%</sub></th>
							<th class="text-center">PPK <sub>/ 100%</sub></th>
							<th class="text-center">PEER <sub>/ 100%</sub></th>
						</tr>
						<?php
						$abc = 1;
						foreach ($dataBhg10 as $ind => $data) { ?>
							<tr>
								<td class="col-md-1 text-center" style="text-align:center"><?= $abc ?></td>
								<td><?= $data['desc']; ?></td>
								<td class="col-md-1 text-center"><?= (($lpp->PPP != Yii::$app->user->identity->ICNO)) ? 'PPP' : $data['markah_ppp'] ?></td>
								<td class="col-md-1 text-center"><?= (($lpp->PPK != Yii::$app->user->identity->ICNO)) ? 'PPK' : $data['markah_ppk'] ?></td>
								<td class="col-md-1 text-center"><?= (($lpp->PEER != Yii::$app->user->identity->ICNO)) ? 'PEER' : $data['markah_peer'] ?></td>
							</tr>
						<?php
							$abc++;
						} ?>

					</table>
				</div>
				<dl class="dl-horizontal">
					<dt>Late In</dt>
					<dd><?= $late; ?> day(s)</dd>
					<dt>Absent</dt>
					<dd><?= $absent; ?> day(s)</dd>
					<dt></dt>
					<dd><i>*Taken from STARS Attendance Report</i></dd>
				</dl>
			</div>
		</div>
	</div>
</div>

<hr />

<?= $this->render('//elnpt/elnpt2/_aspek_nilai', ['bahagian' => $bahagian10, 'mrkh_bhg' => $mrkh_bhg10]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_skor', ['bahagian' => $bahagian10, 'ruberik' => $aspek10]); ?>

<hr />

<?= $this->render('//elnpt/elnpt2/_rubrik', ['bahagian' => $bahagian10, 'ruberik' => $aspek10, 'lpp' => isset($lpp) ? $lpp : false]); ?>

<pagebreak />

<?php if ($dataBhg11) { ?>

	<div class="row v2">
		<div class="col-xs-12 col-md-12 col-lg-12">
			<div class="x_panel">
				<div class="x_title">
					<h4><strong> Bahagian 11 : Perkhidmatan Klinikal</strong></h4>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<div class="table-responsive">
						<table class="table table-sm table-bordered">
							<tr>
								<th class="col-md-1 text-center">BIL.</th>
								<th class="text-center">PARAMETER</th>
								<th class="col-md-2 text-center">BILANGAN JAM</th>
							</tr>
							<tr>
								<td class="text-center"><?= 1; ?></td>
								<td>Clinical Consultation (Clinic / Ward Round / Procedure)</td>
								<td class="text-center"><?= $dataBhg11['clinic_consult']; ?></td>
							</tr>

							<tr>
								<td class="text-center"><?= 2; ?></td>
								<td>Annual Practicing Certificate Renewal (APC - MMC)</td>
								<td class="text-center">
									<!-- <?php if ($lpp->PPP == Yii::$app->user->identity->ICNO) { ?>
                    <?= $form->field($input, 'apc')->checkbox(['label' => '', 'disabled' => $check]); ?>
                <?php } else {
												if ($input->apc == 0 or is_null($input->apc)) {
													echo 'Unverified';
												} else {
													echo 'Verified';
												}
											} ?> -->

									<?= $dataBhg11['apc'] ? 'Ya' : 'Tidak'; ?>
								</td>
							</tr>
						</table>

					</div>

				</div>
			</div>
		</div>
	</div>

	<hr />

	<?= $this->render('//elnpt/elnpt2/_aspek_nilai', ['bahagian' => $bahagian11, 'mrkh_bhg' => $mrkh_bhg11]); ?>

	<hr />

	<?= $this->render('//elnpt/elnpt2/_skor', ['bahagian' => $bahagian11, 'ruberik' => $aspek11]); ?>

	<hr />

	<?= $this->render('//elnpt/elnpt2/_rubrik', ['bahagian' => $bahagian11, 'ruberik' => $aspek11, 'lpp' => isset($lpp) ? $lpp : false]); ?>

	<pagebreak />

<?php } ?>

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong>Jumlah Markah Keseluruhan PYD</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="table-responsive">
						<div class="col-md-9">
							<?= \dosamigos\chartjs\ChartJs::widget([
								'type' => 'radar',
								'id' => 'structureDoughnut',
								'options' => [
									'height' => 300,
									'width' => 500,
								],
								'data' => [
									//'radius' =>  "90%",
									'labels' => array_values(ArrayHelper::getColumn($markah, 'aspek')),
									'datasets' => [
										[
											'data' => array_values(ArrayHelper::getColumn($markah, function ($element) {
												$mark = $element['markah'] * 100;
												if ($mark > 100) {
													return 100;
												} else {
													return  $mark;
												}
											})),
											'label' => 't',
											'fill' => true,
											'backgroundColor' => "rgba(255,99,132,0.2)",
											'borderColor' => "rgba(255,99,132,1)",
											'pointBorderColor' => "#fff",
											'pointBackgroundColor' => "rgba(255,99,132,1)",
											//'hoverBorderColor'=>["#999","#999","#999"],                
										]
									]
								],
								'clientOptions' => [
									'animation' => [
										'onAnimationComplete' => 'function(){
											var url = document.getElementById(\'structureDoughnut\').getContext(\'2d\').toBase64Image();
  											document.getElementById("url").src = url;
										}'
									],
									'responsive' => true,
									'legend' => [
										'display' => false,
										'position' => 'bottom',
										'labels' => [
											'fontSize' => 14,
											'fontColor' => "#425062",
										]
									],
									'tooltips' => [
										//                                    'enabled' => true,
										//                                    'intersect' => true,
										'callbacks' => [
											'label' => new \yii\web\JsExpression("function(t, d) {
                     var label = d.labels[t.index];
                     var data = d.datasets[t.datasetIndex].data[t.index];
                     if (t.datasetIndex === 0)
                     return label + ': ' + data;
                     else if (t.datasetIndex === 1)
                     return label + ': $' + data.toLocaleString();
              }"),
											'title' => new \yii\web\JsExpression('function(){}')
											//                                        'title' => '',
										]
									],
									'hover' => [
										'mode' => false
									],
									'maintainAspectRatio' => false,
									'scale' => [
										'ticks' => [
											'beginAtZero' => true,
											'precision' => 0,
											// 'suggestedMax' => max(array_values(ArrayHelper::getColumn($pemberat, 'pemberat'))),
											'suggestedMax' => 100,
											'stepSize' => 20
											//                                        'maxTicksLimit' => 10
										],
										//                                    'pointLabels' => [
										//                                        'fontColor' => ArrayHelper::getColumn($markah, 'warna')
										//                                    ]
									]

								],
							]);
							?>
						</div>

						<br>
						<img id="url" />
						<br />

						<div class="col-md-3">
							<p><strong>Jumlah Markah Purata (PPP + PPK)</strong></p>
							<?=
							\yiister\gentelella\widgets\StatsTile::widget(
								[
									// 'icon' => 'star',
									'header' => 'Kategori',
									'text' => '<b>' . strtoupper($kategori) . '</b><br>'
										. '- Better than <b>' . Yii::$app->formatter->asDecimal($rankDept) . '   %</b> of all results in ' . $lpp->guru->department->fullname . '<br>'
										. '- Better than <b>' . Yii::$app->formatter->asDecimal($rankGred) . '%</b> of all results within ' . $lpp->guru->jawatan->gred . ' in ' . $lpp->guru->department->fullname . '<br>'
										. '- Better than <b>' . Yii::$app->formatter->asDecimal($rankWhole) . '%</b> of all results',
									// 'number' => Yii::$app->formatter->asDecimal($total * 100) . '%',
									// 'number' => Yii::$app->formatter->asDecimal(array_sum(array_column($pyd, 'mrkh_bhg'))) . '%',
									'number' => Yii::$app->formatter->asDecimal((array_sum(array_column($ppp, 'mrkh_bhg')) - $ppp[10]['mrkh_bhg']) + $markah[10]['markah'] * $pemberat[10]['pemberat']) . '%',
								]
							)
							?>
						</div>
					</div>
				</div>
				<br>
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
						<tr>
							<th class="text-center"></th>
							<?php foreach (array_column($mrkh_all, 'bahagian') as $ind => $b) {
								if ($ind == 9)
									continue; ?>
								<th class="text-center"><?= $b; ?></th>
							<?php } ?>
							<th class="text-center">Markah Purata </th>
							<th class="text-center">Kualiti Peribadi</th>
							<th class="text-center">Jumlah Markah Purata (PPP + PPK) </th>
						</tr>
						<tr>
							<th class="text-center">PYD</th>
							<?php foreach ($pyd as $ind => $m) {
								if ($ind == 10) { ?>
									<!-- <th class="text-center">-</th> -->
								<?php continue;
								} else {
								?>
									<th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
							<?php }
							} ?>
							<th class="text-center"><?= Yii::$app->formatter->asDecimal(array_sum(array_column($pyd, 'mrkh_bhg'))); ?></th>
							<th class="text-center">-</th>
							<th class="text-center">-</th>
						</tr>
						<tr>
							<th class="text-center">PPP</th>
							<?php foreach ($ppp as $ind => $m) {
								if ($ind == 10) {
									continue; ?>
									<!-- <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / 3.75</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . ($pemberat[1]['tbl_kump_dept_id'] == 3 ? '<sub> / 6.00</sub>' : '<sub> / 4.00</sub>'); ?></th> -->
								<?php } else { ?>
									<th class="text-center">
										<?php
										// if ($lpp->PPP_sah != 1) {
										//     echo '-';
										// } else {
										echo is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>';
										// }
										?>
									</th>
							<?php }
							} ?>
							<th class="text-center">
								<?php
								// echo '-';
								// if ($lpp->PPP_sah != 1) {
								//     echo '-';
								// } else {
								echo  Yii::$app->formatter->asDecimal(array_sum(array_column($ppp, 'mrkh_bhg')) - $ppp[10]['mrkh_bhg']);
								// }
								?>
							</th>
							<th class="text-center"><?= Yii::$app->formatter->asDecimal($ppp[10]['mrkh_bhg'], 2) . ($pemberat[1]['tbl_kump_dept_id'] == 3 ? '<sub> / 6.00</sub>' : '<sub> / 4.00</sub>') ?></th>
							<th class="text-center">-</th>
						</tr>
						<tr>
							<th class="text-center">PPK</th>
							<?php foreach ($ppk as $ind => $m) {
								if ($ind == 10) {
									continue; ?>
									<!-- <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / 8.25</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . ($pemberat[1]['tbl_kump_dept_id'] == 3 ? '<sub> / 6.00</sub>' : '<sub> / 4.00</sub>'); ?></th> -->
								<?php } else { ?>
									<th class="text-center">
										<?php
										// echo '-';
										// is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; 
										// if ($lpp->PPK_sah != 1) {
										//     echo '-';
										// } else {
										echo is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>';
										// }
										?>
									</th>
							<?php }
							} ?>
							<th class="text-center">
								<?php
								// echo '-';
								// if ($lpp->PPK_sah != 1) {
								//     echo '-';
								// } else {
								echo Yii::$app->formatter->asDecimal(array_sum(array_column($ppk, 'mrkh_bhg')) - $ppk[10]['mrkh_bhg']);
								// }
								?>
							</th>
							<th class="text-center"><?= Yii::$app->formatter->asDecimal($ppk[10]['mrkh_bhg'], 2) . ($pemberat[1]['tbl_kump_dept_id'] == 3 ? '<sub> / 6.00</sub>' : '<sub> / 4.00</sub>') ?></th>
							<th class="text-center">-</th>
						</tr>
						<tr>
							<th class="text-center">PEER</th>
							<?php foreach ($peer as $ind => $m) {
								if ($ind == (count(array_column($mrkh_all, 'bahagian')) > 10 ? 12 : 11)) {
									continue; ?>
									<!-- <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / 8.25</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . ($pemberat[1]['tbl_kump_dept_id'] == 3 ? '<sub> / 3.00</sub>' : '<sub> / 2.00</sub>'); ?></th> -->
								<?php } else { ?>
									<th class="text-center">
										<?php
										echo '-';
										// is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; 
										?>
									</th>
							<?php }
							} ?>
							<th class="text-center">
								<?php
								// echo '-';
								echo Yii::$app->formatter->asDecimal($peer[10]['mrkh_bhg']) . ($pemberat[1]['tbl_kump_dept_id'] == 3 ? '<sub> / 3.00</sub>' : '<sub> / 2.00</sub>');
								?>
							</th>
							<th class="text-center">-</th>
						</tr>
						<!-- <?php if ($lpp->PPP_sah == 1 and $lpp->PPK_sah == 1) { ?>
                                <tr>
                                    <th class="text-center">PPP + PPK</th>
                                    <?php foreach ($ppk as $ind => $m) { ?>
                                        <th class="text-center"><?= is_null($markah[$ind]['markah']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($markah[$ind]['markah'] * $pemberat[$ind]['pemberat']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                    <?php } ?>
                                    <th class="text-center"><?= Yii::$app->formatter->asDecimal(array_sum(array_map(
																function ($x, $y) {
																	return $x * $y;
																},
																array_column($markah, 'markah'),
																array_column($pemberat, 'pemberat')
															))); ?></th>
                                </tr>
                            <?php } ?> -->
						<tr>
							<th colspan=<?= count(array_column($mrkh_all, 'bahagian')) > 10 ? "11" : "10" ?> style="text-align:right">Total</sub></th>

							<th class="text-center">
								<?php
								// echo '-';
								echo  Yii::$app->formatter->asDecimal(array_sum(array_column($ppp, 'mrkh_bhg')) - $ppp[10]['mrkh_bhg']);
								?>
							</th>
							<th class="text-center">
								<?= is_null($markah[10]['markah']) ? '0' : Yii::$app->formatter->asDecimal($markah[10]['markah'] * $pemberat[10]['pemberat'], 2); ?>
							</th>
							<th class="text-center">
								<?= Yii::$app->formatter->asDecimal((array_sum(array_column($ppp, 'mrkh_bhg')) - $ppp[10]['mrkh_bhg']) + $markah[10]['markah'] * $pemberat[10]['pemberat']); ?>
							</th>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<pagebreak />

<div class="row v2">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="x_panel">
			<div class="x_title">
				<h4><strong>Pengesahan Borang</strong></h4>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />

				<p align="center"><strong>PYD <?= ($lpp->PYD_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MENGHANTAR BORANG eLNPT <?= $lpp->tahun; ?> <?= ($lpp->PYD_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PYD_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>

				<hr />

				<p align="center"><strong>PPP <?= ($lpp->PPP_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN BORANG eLNPT <?= $lpp->tahun; ?> <?= ($lpp->PPP_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PPP_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>

				<hr />

				<p align="center"><strong>PPK <?= ($lpp->PPK_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN BORANG eLNPT <?= $lpp->tahun; ?> <?= ($lpp->PPK_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PPK_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>

				<hr />

				<p align="center"><strong>PEER <?= ($lpp->PEER_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN BORANG eLNPT <?= $lpp->tahun; ?> <?= ($lpp->PEER_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PEER_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>

				<br />
			</div>
		</div>
	</div>
</div>