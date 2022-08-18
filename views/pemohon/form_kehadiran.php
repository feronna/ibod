<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $iklan app\iklans\ejobs\Iklan */
/* @var $form yii\widgets\ActiveForm */
?> 


<div class="x_panel"> 

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Status Kehadiran <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <?php
                if($title == 'iv'){
                    if($model->iklan->status_skype_iv == 1){
                        $query = app\models\ejobs\KehadiranTemuduga::find()->all();
                    }  else { // x skype iv
                        $query = app\models\ejobs\KehadiranKompetensi::find()->all();
                    }
                } else{ // kompetensi
                    $query = app\models\ejobs\KehadiranKompetensi::find()->all();
                }
            
            echo $form->field($model, 'status_kehadiran_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($query, 'id', 'name'),
                'options' => ['placeholder' => 'Pilih'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
            ?>
        </div>
    </div> 
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Ulasan
        </label>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <?= $form->field($model, 'ulasan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>  
            <small><span class="required" style="color:red;">*</span> Sabab tidak hadir (jika berkaitan).</small>
        </div>
    </div>   
    <div class="form-group"> 
        <div class="col-sm-12 text-center">
            <?php echo Html::a('Batal', ['temuduga'], ['class' => 'btn btn-danger']); ?>
            <?= Html::submitButton('Hantar', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>  
    <?php ActiveForm::end(); ?>

</div>           

