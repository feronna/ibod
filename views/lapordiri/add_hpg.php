<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

use yii\widgets\Pjax;

error_reporting(0);
?>
<?php

Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<h5> <strong><center>REKOD PERGERAKAN GAJI</center></strong> </h5>
<div> 
    <div class="x_panel"> 
     
            
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12"> TARIKH MULA:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
  <?=
                    DatePicker::widget([
                        'model' => $nd,
                        'attribute' => 'SalMoveMthStDt',
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
     <label class="control-label col-md-3 col-sm-3 col-xs-12">PERGERAKAN GAJI TAHUNAN <B>BARU</b>:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                                     <?= $form->field($nd, 'tahunb')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>


            </div>
            </div>
         <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12"> BULAN PERGERAKAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?php
            echo $form->field($nd,'bulan_barukgt')->
            dropDownList(['01' => 'JANUARI ',
                          '04' => 'APRIL', 
                          '07' => 'JULAI',
                          '10' => 'OKTOBER',
                        ],['prompt'=>'Pilih Bulan'])->label(false);
?>
     
            </div>
            </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12"> JENIS PERGERAKAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?php
            echo $form->field($nd,'movtype')->
            dropDownList(['2' => 'HADIAH PERGERAKAN GAJI ',
                        
                        ],['prompt'=>'Pilih Jenis Pergerakan'])->label(false);
?>
     
            </div>
            </div>
           
         
       
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">CATATAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                                     <?= $form->field($nd, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>


            </div>
            </div>
        
         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>
         <!-- <div class="ln_solid"></div> -->
            
        </div>
    </div>

            <?php ActiveForm::end(); 
            Pjax::end();?>
