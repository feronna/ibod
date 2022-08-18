
<?php
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
error_reporting(0);
?>
<div class="row">
<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
     
        
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Kata Kerja (Membuat Sesuatu)<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?=
                    $form->field($model, 'kata_kerja')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\myportfolio\RefAkauntabiliti::find()->orderBy(['id' => SORT_ASC])->all(), 'name', 'name'),
                        'options' => ['placeholder' => 'Pilih Kata Kerja (Membuat Sesuatu)', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true,
                             'multiple' => true
                        ],
                    ]);
                    ?>
                
                </div>
                       
                 </div>
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Objek<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <?= $form->field($model, 'object')->textarea(['maxlength' => true, 'rows' => 4, 'placeholder' => 'Objek (Kepada Sesuatu) Contoh:  hal ehwal pengurusan perjawatan, pelantikan dan kenaikan pangkat kakitangan pentadbiran serta pelantikan dan kenaikan pangkat kakitangan akademik'])->label(false); ?>
                </div>
            </div>
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Hasil<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tujuan')->textarea(['maxlength' => true, 'rows' => 4, 'placeholder' => 'Hasil (Untuk Mencapai) Contoh: bagi membolehkan agensi menjalankan fungsi ditetapkan dengan cekap dan berkesan.'])->label(false); ?>
                </div>
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
