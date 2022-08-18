<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;

error_reporting(0);
?>
<?php

Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<h5> <strong><center>STATUS PENERIMAAN TAWARAN CUTI BELAJAR </center></strong> </h5>
<div> 
    <div class="x_panel"> 
     
            
            
 
        

        
       
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                                     <?= $form->field($model->kakitangan, 'CONm')->textInput(['maxlength' => true, 'rows' => 4, 'disabled'=>true])->label(false); ?>


            </div>
            </div>
        
         
        <div class="form-group"> 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">STATUS:</label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                <?=
                    $form->field($model, 'tawaran')->widget(Select2::classname(), [
                        //'data' => ArrayHelper::map(RefAkses::find()->orderBy(['akses_id' => SORT_ASC])->all(), 'akses_id', 'akses_label'),
                        'data' => ['2' => 'TERIMA TAWARAN','1'=>"TOLAK TAWARAN"],
                        'hideSearch' => true,
                        'options' => [
                            'placeholder' => 'Status Penerimaan', 
                            'class' => 'form-control col-md-7 col-xs-12',
                            //'selected'    => 2,
                            //'id' => 'senarai',
                            ],
                        'pluginOptions' => [
                            //'allowClear' => true
                        ],
                    ])->label(false);
                ?>
                   
                </div>
               
            </div>
          <div class="form-group" align="center">
            <h5 style="font-size:120%;" class="text-justify"> 
                </h5>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">CATATAN : <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan_tawaran')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('<i class="fa fa-lock-open"></i> Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>
         <!-- <div class="ln_solid"></div> -->
            
        </div>
    </div>

            <?php ActiveForm::end(); 
            Pjax::end();?>
