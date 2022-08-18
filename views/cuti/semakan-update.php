<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\widgets\SwitchInput;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>
<div class="align-center text-center title bg-success" style="padding: 1px"><h4>MAKLUMAT PEMOHON</h4></div>
<?=
DetailView::widget([
    'model' => $model,
    'attributes' => [
        'kakitangan.CONm',
        'kakitangan.jawatan.fname',
        'kakitangan.department.fullname',
        'jenisCuti.fullname',
        'full_date',
        'remark',
        'tempoh',
        'jenis',
        [
            'attribute' => 'viewDoc',
            'format' => 'raw',
        ],
    ],
])
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enableAjaxValidation' => true]]); ?>
<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Diluluskan oleh(Ketua BSM/Pendaftar/NC)</label>
    <div class="col-md-6 col-sm-6 col-xs-10">
        <?=
        $form->field($model, 'lulus_by')->label(false)->widget(Select2::classname(), [
            'data' => ArrayHelper::map($biodata, 'ICNO', 'CONm'),
            'options' => ['placeholder' => 'Pilih Peg. Pelulus', 'class' => 'form-control col-md-7 col-xs-12'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Diperakukan oleh (Ketua Jabatan)</label>
    <div class="col-md-6 col-sm-6 col-xs-10">
        <?=
        $form->field($model, 'peraku_by')->label(false)->widget(Select2::classname(), [
            'data' => ArrayHelper::map($biodata, 'ICNO', 'CONm'),
            'options' => ['placeholder' => 'Pilih Peg. Peraku', 'class' => 'form-control col-md-7 col-xs-12'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
</div>



<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'status'); ?>
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
           title="Status"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">

        <?php
        echo $form->field($model, 'status')->dropDownList(
                ['RETURNED' => 'PULANGKAN KEPADA PEMOHON', 'CHECKED' => 'DISEMAK', 'REJECTED' => 'DITOLAK'], ['prompt' => 'Sila Pilih...']
        )->label(false);
        ?>
    </div>
</div> 

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'semakan_remark'); ?>
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
           title="Catatan penyemak"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'semakan_remark')->textarea(['rows' => 4])->label(false); ?>
    </div>

</div> 

<div class="ln_solid"></div>


<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>