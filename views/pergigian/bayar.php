<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\kontrak\Kontrak;
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">STATUS SEMAKAN <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-6">
            <?=
        $form->field($model, 'status_check')->label(false)->widget(Select2::classname(), [
            'data' => ['DISEMAK' => 'SEMAKAN LAYAK', 'DITOLAK' => 'SEMAKAN TIDAK LAYAK'],
            'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                'onchange' => 'javascript:if ($(this).val() == "Dipersetujui"){
                        $("#tempoh").show();
                        }
                        else{
                        $("#tempoh").hide();
                        }',
                'disabled' => TRUE],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div></div>
    
    <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">CATATAN PENYEMAK<span class="required">*</span>
                        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'catatan_check')->textArea(['maxlength' => true, 'rows' => 2,'disabled'=>TRUE])->label(false); ?>
                        </div></div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">DISEMAK OLEH<span class="required">*</span>
                        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= Html::textInput('nama', $model->kakitanganCheck->CONm, ['disabled'=>true, 'class'=>'form-control']); ?>
                        </div></div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">DISEMAK PADA<span class="required">*</span>
                        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'check_dt')->textInput(['maxlength' => true, 'rows' => 2,'disabled'=>TRUE])->label(false); ?>
                        </div></div>
    
    <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">STATUS KELULUSAN <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-6">
        
            <?=
        $form->field($model, 'status_app')->label(false)->widget(Select2::classname(), [
            'data' => ['DILULUSKAN' => 'DILULUSKAN', 'DITOLAK' => 'TIDAK DILULUSKAN'],
            'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                'onchange' => 'javascript:if ($(this).val() == "Dipersetujui"){
                        $("#tempoh").show();
                        }
                        else{
                        $("#tempoh").hide();
                        }',
              'disabled'=>true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div></div>
    
        <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">CATATAN PELULUS<span class="required">*</span>
                        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'catatan_app')->textArea(['maxlength' => true, 'rows' => 2, 'disabled'=>true])->label(false); ?>
                        </div>
    
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">STATUS KELULUSAN OLEH</label>
        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= Html::textArea('nama', $model->kakitanganApp->CONm, ['disabled'=>true, 'class'=>'form-control']); ?>
                        </div></div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">STATUS KELULUSAN PADA<span class="required">*</span>
                        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'app_dt')->textInput(['maxlength' => true, 'rows' => 2,'disabled'=>TRUE])->label(false); ?>
                        </div></div>


        


<?php ActiveForm::end(); ?>

<!--form-->
