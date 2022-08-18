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
<h5> <strong><center>BUKA BORANG LKP</center></strong> </h5>
<div> 
    <div class="x_panel"> 
     
            
            
 
        

        
       
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">NAME:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                                     <?= $form->field($model->kakitangan, 'CONm')->textInput(['maxlength' => true, 'rows' => 4, 'disabled'=>true])->label(false); ?>


            </div>
            </div>
        
         
        <div class="form-group"> 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">AKSES:</label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                <?=
                    $form->field($model, 'open')->widget(Select2::classname(), [
                        //'data' => ArrayHelper::map(RefAkses::find()->orderBy(['akses_id' => SORT_ASC])->all(), 'akses_id', 'akses_label'),
                        'data' => ['2' => 'BUKA', '1' => 'TUTUP'],
                        'hideSearch' => true,
                        'options' => [
                            'placeholder' => 'Pilih Status Borang', 
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
         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('<i class="fa fa-lock-open"></i> KEMASKINI', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>
         <!-- <div class="ln_solid"></div> -->
            
        </div>
    </div>

            <?php ActiveForm::end(); 
            Pjax::end();?>
