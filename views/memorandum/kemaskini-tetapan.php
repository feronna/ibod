<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
error_reporting(0);
use kartik\time\TimePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
?>

<div class="row"> 
     
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Kemaskini Tetapan</strong></h2>
  
            <div class="clearfix"></div>
        </div>
    <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
              
                             
             <div class="form-group">
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">BIL.JPU :<span class="required" style="color:red;">*</span>
                </label>
                    <div class="col-md-6 col-sm-5 col-xs-12">
                        <?php // Usage with ActiveForm and model
                        echo $form->field($model, 'id_rekod')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($rekod, 'id', 'bil_jpu'),
                            'options' => ['placeholder' => '-- Pilih Bil JPU --'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);

                        ?>
                    </div>
                </div>
              
              

              
                      <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tutup :<span class="required" style="color:red;">*</span></label>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                             
<!--                         $form->field($model, 'tarikh_tutup')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Pilih Tarikh ...'],
    'pluginOptions' => [
        'autoclose' => true,
           'format' => 'yyyy-mm-dd H:i'
    ]
])->label(false);
                        -->
                        
                
                    <?= $form->field($model, 'tarikh_tutup')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                  ])->label(false);?>
              
            </div>
        </div>
              
          

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>

    </div>
</div>

</div>
</div>
