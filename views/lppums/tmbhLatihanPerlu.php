<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>
            
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        
        <div class="panel-body">
            <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama / Bidang Latihan</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                    <?=
                        $form->field($model, "lat_perlu")
                    ->textInput(['class' => 'form-control'])
                    ->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Diperlukan</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                    <?=
                        $form->field($model, "lat_sebab_perlu")
                    ->textInput(['class' => 'form-control'])
                    ->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group pull-right">
                    <div>
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Tambah', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
            <?php yii\widgets\Pjax::end() ?>
        </div>
    </div>
    </div>
</div>       
