<?php

use yii\helpers\Html; 
use yii\helpers\ArrayHelper;
//use yii\bootstrap\ActiveForm;
use app\models\myidp\KlusterKursus;
use app\models\myidp\IdpKategoriJawatan;
use app\models\myidp\Kategori;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\myidp\VIdpSenaraiKursus */
/* @var $form ActiveForm */

echo $this->render('/idp/_topmenu');

?>
<div class="form_update_latihan">
    <div class="col-md-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2>Borang Kemaskini Latihan</h2> 
                    <div class="clearfix"></div>
                </div>
            <div class="x_content">
            
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT PENGGUBAL MODUL</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">Penggubal Modul: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'penggubalModul')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
<!--                        type, model, model attribute name, options-->
                        <?php Html::activeInput('text', $model, 'penggubalModul', ['class' => 'form-control col-md-7 col-xs-12']) ?>
                    </div>
                </div>
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT KURSUS LATIHAN</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Tajuk Kursus: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'tajukLatihan')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

    <?php ActiveForm::end(); ?>
            </div>
            </div>
        </div>
</div><!-- form_update_latihan -->

