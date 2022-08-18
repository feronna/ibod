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
            <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Status Kenderaan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-6">  
                <?=
                $form->field($model, 'status_kenderaan')->label(false)->widget(Select2::classname(), [
                    'data' => ['AKTIF' => 'AKTIF', 'TIDAK AKTIF' => 'TIDAK AKTIF'],
                    'options' => ['placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Catatan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-6">  
                <?= $form->field($model, 'catatan')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>        
            <div class="col-md-offset-3 col-sm-offset-3 col-xs-offset-3 col-md-6 col-sm-6 col-xs-6">  
                <small>(Mandatori untuk status kenderaan <i>"TIDAK AKTIF"</i>)</small>  
            </div> 
        </div> 
            
    </div>    
    <br/>
    <div class="form-group text-center">
        <div class="row">
            <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Tambah / Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Sila Tunggu..']]) ?>
        </div>
    </div> 
    <?php ActiveForm::end(); ?> 
</div> 
