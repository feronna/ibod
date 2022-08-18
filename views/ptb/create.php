<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ptb\TblTugasBelumSelesai */

$this->title = 'Nota Serah Tugas';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Tugas Belum Selesais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

       <?php echo $this->render('/ptb/_menu'); ?>
   
<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Nota Serah  Tugas</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <p style="color: green">
                * Senarai serah tugas hanya untuk kakitangan yang berpindah ke JFPIU baru
            </p>
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>



            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Senarai Tugas<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'senarai_tugas')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tugas yang belum selesai<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tugas_belum_selesai')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kedudukan Sekarang<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'kedudukan_sekarang')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tindakan Susulan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tindakan_susulan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Rujukan Fail<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'rujukan_fail')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Senarai Harta Benda<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'senarai_harta_benda')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            
           <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kedudukan Kewangan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'kedudukan_kewangan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
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

