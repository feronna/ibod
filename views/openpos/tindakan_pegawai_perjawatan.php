<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\hronline\GredJawatan;
use yii\helpers\Url;
?>
    <div class="x_panel">
        <h2>Keputusan Mesyuarat</h2>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Jawatan Dipohon <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
<?=
$form->field($model, 'jawatan_dipohon')->label(false)->widget(Select2::classname(), [
    'data' => ArrayHelper::map(GredJawatan::find()->all(), 'id', 'fname'),
    'options' => ['placeholder' => 'Pilih Jawatan', 'class' => 'form-control col-md-7 col-xs-12', 'disabled' => 'disabled'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Justifikasi Permohonan<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
<?= $form->field($model, 'justifikasi')->textarea(['maxlength' => true, 'rows' => 4, 'disabled' => true])->label(false); ?>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Implikasi Kewangan<span class="required">*</span>
    </label>
    <div class="col-md-2 col-md-4 col-sm-3 col-xs-12">
<?= $form->field($model, 'implikasi_kewangan')->textInput(['maxlength' => true, 'rows' => 4, 'disabled' => true])->label(false); ?>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-6 col-xs-12">Dokument Sokongan 
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="<?php echo Url::to('@web/' . $model->doc_sokongan, true); ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-book"></i> Dokument Sokongan</a>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-6 col-xs-12">Ringkasan Perjawatan
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="<?php echo Url::to('@web/' . $model->ringkasan, true); ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-book"></i> Ringkasan Perjawatan</a>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Perakuan <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-6">
<?=
$form->field($model, 'status')->label(false)->widget(Select2::classname(), [
    'data' => ['VERIFIED' => 'PERMOHONAN DISAHKAN','REJECTED' => 'PERMOHONAN DITOLAK',],
    'options' => ['placeholder' => 'Pilih Perakauan', 'class' => 'form-control col-md-7 col-xs-12'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    </div>
</div>

<div class="ln_solid"></div>

<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button class="btn btn-primary" type="reset">Reset</button>
<?= Html::submitButton('Hantar Perakuan', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
    </div>