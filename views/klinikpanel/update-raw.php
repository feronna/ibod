<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>

<div class="col-md-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Kemaskini Raw Data</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA KAKITANGAN<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($query->kakitangan, 'CONm')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NO.KP <span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($query, 'max_icno')->textArea(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">PERUNTUKAN TAHUNAN<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($query, 'max_tuntutan')->textArea(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">BAKI PERUNTUKAN<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($query, 'current_balance')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
            </div>
                   

            </div>
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end();?>
     </div>


