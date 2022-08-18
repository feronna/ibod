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
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

?>
 <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>

<div class="form-group">
    <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Back On Duty 
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Bercuti"></i>
    </label>

    <div class="col-md-5 col-sm-5 col-xs-12">
        <?php
     echo DatePicker::widget([
        'model' => $model, 
        'attribute' => 'date_bod',
        // 'convertFormat' => true,
        'options' => ['placeholder' => 'Tarikh Kembali Bertugas ...'],
        'readonly' => true,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
        ]
    ]);
        ?>

    </div>
</div>


<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Remark
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'remark')->textarea(['rows' => 4, 'placeholder' => 'Sila Isi Catatan'])->label(false); ?>
    </div>

</div>


        <div class="ln_solid"></div>


<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/individu/pilih'], ['class' => 'btn btn-warning']) ?>
        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
        <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>