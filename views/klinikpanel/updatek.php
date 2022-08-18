<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>

<div class="col-md-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Kemaskini Maklumat Klinik</strong></h2>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA KLINIK<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($klinik, 'nama')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">ALAMAT KLINIK<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($klinik, 'alamat')->textArea(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NO. TELEFON<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($klinik, 'telefon')->textArea(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">EMEL<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($klinik, 'klinik_email')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
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


