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
<h5> <strong><center>TARIKH MULA NOMINAL DAMAGES</center></strong> </h5>
<div> 
    <div class="x_panel"> 
     
            
            
 

        
        
         <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula Nominal Damages:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

           
            <?=
                    DatePicker::widget([
                        'model' => $model,
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
         <!-- <div class="ln_solid"></div> -->
            <?php 
            if($model->dt_nominal != "NULL")
            {?>
                <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Simpan' ,['class' => 'btn btn-primary','name' => 'simpan']) ?>
                    <a style="color: green; font-weight: bold"><?php echo $message;?></a>
                    
                </div>
            </div>
        <?php }
        ?>
        </div>
    </div>

            <?php ActiveForm::end(); 
            Pjax::end();?>
