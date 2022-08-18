<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>KEMASKINI NOMINAL DAMAGES</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
       
       
<div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH PATUT MULA:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
            <?=
                    DatePicker::widget([
                        'model' => $nd,
                        'attribute' => 'dt_nominal',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
</div>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH BERSETUJU:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?=
                    DatePicker::widget([
                        'model' => $nd,
                        'attribute' => 'dt_setuju',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
     
            </div>
            </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH TAMAT:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
 <?=
                    DatePicker::widget([
                        'model' => $nd,
                        'attribute' => 'nd_nominal',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>

            </div>
            </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">JUMLAH NOMINAL DAMAGES (BULANAN):<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?php
            echo $form->field($nd,'j_nd')->
            dropDownList([
                          '700' => 'RM700',
                          '500' => 'RM500 ',
                          '250' => 'RM250', 
                          
                        ],['prompt'=>'Jumlah Bulanan'])->label(false);
?>
     
            </div>
            </div>
        
       
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                                     <?= $form->field($nd, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>


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

