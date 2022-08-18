<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\esticker\TblStickerStaf */
/* @var $form yii\widgets\ActiveForm */
?>
 

<div class="x_panel">  
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?> 
    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Permohonan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-6">  
                <?=
                $form->field($model, 'apply_type')->label(false)->widget(Select2::classname(), [
                    'data' => ['LANJUTAN' => 'LANJUTAN', 'ROSAK' => 'ROSAK', 'HILANG' => 'HILANG'],
                    'options' => ['placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
    </div> 
      
    <br/>
    <div class="form-group text-center">
        <div class="row">
            <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Sila Tunggu..']]) ?>
        </div>
    </div> 
    <?php ActiveForm::end(); ?> 
</div> 
