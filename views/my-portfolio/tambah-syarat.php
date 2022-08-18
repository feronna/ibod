<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

?>


<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
   <div class="x_panel">
        <div class="x_title">
            <h2>Syarat Tambahan</h2>
            <p align="right" >
                    <?php echo Html::a('Kembali', ['/my-portfolio/lihat-kelayakan', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
               <div class="content">
                   Syarat Tambahan (jika berkaitan):
                    <?= $form->field($syarat, 'syarat_tambahan')->textarea(['maxlength' => true, 'placeholder' => 'Contoh: Memiliki Kepujian (sekurang-kurangnya Gred C) dalam subjek Bahasa Melayu pada peringkat Sijil Pelajaran Malaysia/Sijil Vokasional Malaysia atau kelulusan yang diiktiraf setaraf dengannya oleh Kerajaan.'])->label(false)?>
                   <a class="form-control" style="border:0;box-shadow: none; color:blue" href="<?php echo yii\helpers\Url::to('https://www.interactive.jpa.gov.my/ezskim/'); ?>" target="_blank" >** Nyatakan bidang. Sila semak di pautan : <?= Yii::t('app','https://www.interactive.jpa.gov.my/ezskim/')?></a></p>
               </div>
            
            
           
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>
</div>


