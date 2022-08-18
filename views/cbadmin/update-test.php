<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>KEMASKINI MAKLUMAT PEMBAYARAN ELAUN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
       
       
<div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">JENIS ELAUN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
<?= $form->field($model, 'jenis_elaun')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(app\models\cbelajar\RefElaun::find()->orderBy(['id' => SORT_DESC,])->all(), 'id', 'elaun'),
                        'options' => [
                            'placeholder' => 'Pilih Elaun'],
                    ])->label(false); ?>
                </div>
</div>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">BAYARAN OLEH:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
                     <?php
            echo $form->field($model,'bayaran')->
            dropDownList(['KPT' => 'KEMENTERIAN PENGAJIAN TINGGI ',
                          'UMS' => 'UNIVERSITI MALAYSIA SABAH', 
                          
                        ],['prompt'=>'Dibayar Oleh'])->label(false);
?>
                </div>
</div>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">AMAUN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                                       <?= $form->field($model, 'amaun')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>

                </div>
            </div>
        

        
        

    </div>
    </div>
</div>
</div>


  
        
        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>




