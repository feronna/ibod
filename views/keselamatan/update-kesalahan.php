<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\TimePicker;
?>

<?php if ($type == 1) { ?>
	<div class="x_panel">
		<div class="x_title">
			<h2><strong>KemasKini Kesalahan</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">

			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">Sila Tanda Mana-mana Yang Berkenaan :
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">

					<?= $form->field($model, 'THTC')->checkbox(array(
						'label' => 'Tidak Hadir Tanpa Cuti (THTC)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'HH')->checkbox(array(
						'label' => 'Hadir Hakiki (HH)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'THH')->checkbox(array(
						'label' => 'Tidak Hadir Hakiki (THH)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'CK')->checkbox(array(
						'label' => 'Cuti Kecemasan',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CTR')->checkbox(array(
						'label' => 'Cuti Tanpa Rekod',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CGKA')->checkbox(array(
						'label' => 'Cuti Ganti Kelepasan AM',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CG')->checkbox(array(
						'label' => 'Cuti Ganti',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CSG')->checkbox(array(
						'label' => 'Cuti Separuh Gaji',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CTG')->checkbox(array(
						'label' => 'Cuti Tanpa Gaji',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CS')->checkbox(array(
						'label' => 'Cuti Sakit',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CR')->checkbox(array(
						'label' => 'Cuti Rehat',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'TLP')->checkbox(array(
						'label' => 'Tugasan Luar Pejabat',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">Masa Masuk Tugas :
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<?= $form->field($model, 'masa_masuk_tugas')->textInput()->input('masa_masuk_tugas', ['placeholder' => "Tolong gunakan sistem 24 jam cth:(1600)"])->label(false); ?>
	</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">Catatan :
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>


				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">
					<a href="#" data-toggle="tooltip" title="Tanda Hantar STS sekiranya mahu STS dihantar / Tidak perlu STS sekiranya Tidak Perlu STS!"><i class="fa fa-info-circle" aria-hidden="true"></i></a>

				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">


					<?php
					echo $form->field($model, 'sts_sent')->radioList(
						['SIMPAN' => 'Simpan', 'STS' => 'Hantar STS', 'NO_STS' => 'Tidak Perlu STS']
					)->label('STS.');
					?>

				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Hantar', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait.. ']]) ?>
					<button class="btn btn-primary" type="reset">Reset</button>

				</div>
			</div>

			<?php ActiveForm::end(); ?>

			<br>

		</div>
	</div>
<?php } elseif ($type == 2) { ?>
	<div class="x_panel">
		<div class="x_title">
			<h2><strong>KemasKini Kesalahan</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">

			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">Sila Tanda Mana-mana Yang Berkenaan :
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">


					<?= $form->field($model, 'THTC')->checkbox(array(
						'label' => 'Tidak Hadir Tanpa Cuti (THTC)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'HLMJ')->checkbox(array(
						'label' => 'Hadir Lebihan Masa Jadual (HLMJ)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'THLMJ')->checkbox(array(
						'label' => 'Tidak Hadir Lebihan Masa Jadual (THLMJ)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'CK')->checkbox(array(
						'label' => 'Cuti Kecemasan',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CTR')->checkbox(array(
						'label' => 'Cuti Tanpa Rekod',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CGKA')->checkbox(array(
						'label' => 'Cuti Ganti Kelepasan AM',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CG')->checkbox(array(
						'label' => 'Cuti Ganti',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CSG')->checkbox(array(
						'label' => 'Cuti Separuh Gaji',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CTG')->checkbox(array(
						'label' => 'Cuti Tanpa Gaji',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CS')->checkbox(array(
						'label' => 'Cuti Sakit',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CR')->checkbox(array(
						'label' => 'Cuti Rehat',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'TLP')->checkbox(array(
						'label' => 'Tugasan Luar Pejabat',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">Masa Masuk Tugas :
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<?= $form->field($model, 'masa_masuk_tugas')->textInput()->input('masa_masuk_tugas', ['placeholder' => "Tolong gunakan sistem 24 jam cth:(1600)"])->label(false); ?>
			</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">Catatan :
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>


				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">
					<a href="#" data-toggle="tooltip" title="Tanda Hantar STS sekiranya mahu STS dihantar / Tidak perlu STS sekiranya Tidak Perlu STS!"><i class="fa fa-info-circle" aria-hidden="true"></i></a>

				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">


					<?php
					echo $form->field($model, 'sts_sent')->radioList(
						['SIMPAN' => 'Simpan', 'STS' => 'Hantar STS', 'NO_STS' => 'Tidak Perlu STS']
					)->label('STS.');
					?>

				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Hantar', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait.. ']]) ?>
					<button class="btn btn-primary" type="reset">Reset</button>

				</div>
			</div>

			<?php ActiveForm::end(); ?>

			<br>

		</div>
	</div>
<?php } elseif ($type == 3) { ?>
	<div class="x_panel">
		<div class="x_title">
			<h2><strong>KemasKini Kesalahan</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">

			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">Sila Tanda Mana-mana Yang Berkenaan :
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">

					<?= $form->field($model, 'THBH')->checkbox(array(
						'label' => 'Tidak Hadir Baris Hakiki (THBH)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => true
					)); ?>
					<?= $form->field($model, 'THBLMJ')->checkbox(array(
						'label' => 'Tidak Hadir Baris Lebih Masa Jadual (THBLMJ)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => true
					)); ?>
					<?= $form->field($model, 'THTC')->checkbox(array(
						'label' => 'Tidak Hadir Tanpa Cuti (THTC)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'HH')->checkbox(array(
						'label' => 'Hadir Hakiki (HH)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'THH')->checkbox(array(
						'label' => 'Tidak Hadir Hakiki (THH)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'HLMJ')->checkbox(array(
						'label' => 'Hadir Lebihan Masa Jadual (HLMJ)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'THLMJ')->checkbox(array(
						'label' => 'Tidak Hadir Lebihan Masa Jadual (THLMJ)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'HLMT')->checkbox(array(
						'label' => 'Hadir Lebihan Masa Tambahan (HLMT)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'THLMT')->checkbox(array(
						'label' => 'Tidak Hadir Lebihan Masa Tambahan (THLMT)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'HKWLN')->checkbox(array(
						'label' => 'Hadir Kawalan (HKWLN)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'THKWLN')->checkbox(array(
						'label' => 'Tidak Hadir Kawalan(THKWLN)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'THBKWLN')->checkbox(array(
						'label' => 'Tidak Hadir Baris (THBKWLN)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CK')->checkbox(array(
						'label' => 'Cuti Kecemasan',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CTR')->checkbox(array(
						'label' => 'Cuti Tanpa Rekod',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CGKA')->checkbox(array(
						'label' => 'Cuti Ganti Kelepasan AM',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CG')->checkbox(array(
						'label' => 'Cuti Ganti',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CSG')->checkbox(array(
						'label' => 'Cuti Separuh Gaji',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CTG')->checkbox(array(
						'label' => 'Cuti Tanpa Gaji',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CS')->checkbox(array(
						'label' => 'Cuti Sakit',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CR')->checkbox(array(
						'label' => 'Cuti Rehat',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'TLP')->checkbox(array(
						'label' => 'Tugasan Luar Pejabat',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">Masa Masuk Tugas :
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
			
					</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">Catatan :
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>


				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">
					<a href="#" data-toggle="tooltip" title="Tanda Hantar STS sekiranya mahu STS dihantar / Tidak perlu STS sekiranya Tidak Perlu STS!"><i class="fa fa-info-circle" aria-hidden="true"></i></a>

				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">


					<?php
					echo $form->field($model, 'sts_sent')->radioList(
						['SIMPAN' => 'Simpan', 'STS' => 'Hantar STS', 'NO_STS' => 'Tidak Perlu STS']
					)->label('STS.');
					?>

				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Hantar', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait.. ']]) ?>
					<button class="btn btn-primary" type="reset">Reset</button>

				</div>
			</div>

			<?php ActiveForm::end(); ?>

			<br>

		</div>
	</div>
<?php } else { ?>

	<div class="x_panel">
		<div class="x_title">
			<h2><strong>KemasKini Kesalahan</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">

			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">Sila Tanda Mana-mana Yang Berkenaan :
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">

					<?= $form->field($model, 'THBH')->checkbox(array(
						'label' => 'Tidak Hadir Baris Hakiki (THBH)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => true
					)); ?>
					<?= $form->field($model, 'THBLMJ')->checkbox(array(
						'label' => 'Tidak Hadir Baris Lebih Masa Jadual (THBLMJ)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => true
					)); ?>
					<?= $form->field($model, 'THTC')->checkbox(array(
						'label' => 'Tidak Hadir Tanpa Cuti (THTC)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'HH')->checkbox(array(
						'label' => 'Hadir Hakiki (HH)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'THH')->checkbox(array(
						'label' => 'Tidak Hadir Hakiki (THH)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'HLMJ')->checkbox(array(
						'label' => 'Hadir Lebihan Masa Jadual (HLMJ)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'THLMJ')->checkbox(array(
						'label' => 'Tidak Hadir Lebihan Masa Jadual (THLMJ)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'HLMT')->checkbox(array(
						'label' => 'Hadir Lebihan Masa Tambahan (HLMT)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'THLMT')->checkbox(array(
						'label' => 'Tidak Hadir Lebihan Masa Tambahan (THLMT)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'HKWLN')->checkbox(array(
						'label' => 'Hadir Kawalan (HKWLN)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

					<?= $form->field($model, 'THKWLN')->checkbox(array(
						'label' => 'Tidak Hadir Kawalan(THKWLN)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'THBKWLN')->checkbox(array(
						'label' => 'Tidak Hadir Baris (THBKWLN)',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CK')->checkbox(array(
						'label' => 'Cuti Kecemasan',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CTR')->checkbox(array(
						'label' => 'Cuti Tanpa Rekod',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CGKA')->checkbox(array(
						'label' => 'Cuti Ganti Kelepasan AM',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CG')->checkbox(array(
						'label' => 'Cuti Ganti',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CSG')->checkbox(array(
						'label' => 'Cuti Separuh Gaji',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CTG')->checkbox(array(
						'label' => 'Cuti Tanpa Gaji',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CS')->checkbox(array(
						'label' => 'Cuti Sakit',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'CR')->checkbox(array(
						'label' => 'Cuti Rehat',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>
					<?= $form->field($model, 'TLP')->checkbox(array(
						'label' => 'Tugasan Luar Pejabat',
						'labelOptions' => array('style' => 'padding:5px;'),
						'disabled' => false
					)); ?>

				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">Masa Masuk Tugas :
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<?= $form->field($model, 'masa_masuk_tugas')->textInput()->input('masa_masuk_tugas', ['placeholder' => "Tolong gunakan sistem 24 jam cth:(1600)"])->label(false); ?>

				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">Catatan :
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>


				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-6 col-xs-12">
					<a href="#" data-toggle="tooltip" title="Tanda Hantar STS sekiranya mahu STS dihantar / Tidak perlu STS sekiranya Tidak Perlu STS!"><i class="fa fa-info-circle" aria-hidden="true"></i></a>

				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">


					<?php
					echo $form->field($model, 'sts_sent')->radioList(
						['SIMPAN' => 'Simpan', 'STS' => 'Hantar STS', 'NO_STS' => 'Tidak Perlu STS']
					)->label('STS.');
					?>

				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Hantar', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait.. ']]) ?>
					<button class="btn btn-primary" type="reset">Reset</button>

				</div>
			</div>

			<?php ActiveForm::end(); ?>

			<br>

		</div>
	</div>
<?php } ?>
<!--<div class="col-md-12"> -->

<!--</div>-->

<?php
$script = <<< JS

          $('.confirmation').on('click', function () {
        return confirm('Are you sure?');
    });
              
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
JS;
$this->registerJs($script);
?>