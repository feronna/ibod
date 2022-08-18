<?php

use app\models\penamatanperkhidmatan\TblPengesahan;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;

error_reporting(0);
$bil=1;

$this->registerJs($js);
?>
<?= $this->render('_topmenu') ?>
<?= $this->render('_maklumatpemohon',['model'=> $model]) ?>
<?= $this->render('belumselesai', ['title' => 'Pengesahan Jabatan Bendahari '.$model->statusbn, 'tarikh' => $model->tarikhbn,'model' => TblPengesahan::find()->where(['permohonan_id' => $model->id, 'dept_id' => 8])->all()]) ?>
<?= $this->render('belumselesai', ['title' => 'Pengesahan Perpustakaan '.$model->statusperpustakaan, 'tarikh' => $model->tarikhperpustakaan,'model' => TblPengesahan::find()->where(['permohonan_id' => $model->id, 'dept_id' => 13])->all()]) ?>
<?= $this->render('belumselesai', ['title' => 'Pengesahan Jabatan Teknologi Maklumat Dan Komunikasi '.$model->statusjtmk,'tarikh' => $model->tarikhjtmk,'model' => TblPengesahan::find()->where(['permohonan_id' => $model->id, 'dept_id' => 35])->all()]) ?>
<?= $this->render('belumselesai', ['title' => 'Pengesahan Pejabat Penasihat Undang-undang '.$model->statusppuu,'tarikh' => $model->tarikhppuu,'model' => TblPengesahan::find()->where(['permohonan_id' => $model->id, 'dept_id' => 181])->all()]) ?>
<?= $this->render('belumselesai', ['title' => 'Pengesahan JFPIU '.$model->statusjfpiu,'tarikh' => $model->tarikhjfpiu,'model' => TblPengesahan::find()->where(['permohonan_id' => $model->id, 'dept_id' => 0])->all()]) ?>
<?= $this->render('belumselesai', ['title' => 'Pengesahan Bahagian Sumber Manusia [Seksyen Pengajian Lanjutan] '.$model->statusbsm,'tarikh' => $model->tarikhbsm,'model' => TblPengesahan::find()->where(['permohonan_id' => $model->id, 'dept_id' => 158])->all()]) ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Pengesahan Bahagian Sumber Manusia</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div> <br>
        <div class="x_content">
            
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH ARAHAN PEMBERHENTIAN GAJI<span class="required" style="color : red"> *</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'tarikh_hentigaji')->label(false)->widget(DatePicker::classname(), [
                    'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d'
                ]
                ]); ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH BERHENTI<span class="required" style="color : red"> *</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'tarikh_berhenti')->label(false)->widget(DatePicker::classname(), [
                    'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d'
                ]
                ]); ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">TUTUP FAIL<span class="required" style="color : red"> *</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'tarikh_tutupfail')->label(false)->widget(DatePicker::classname(), [
                    'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d'
                ]
                ]); ?>
            </div>
        </div>
            
        <div class="form-group">
            <div align="center" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('<i class="fa fa-paper-plane"></i> Hantar', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>