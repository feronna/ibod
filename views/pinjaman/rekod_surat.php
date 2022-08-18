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
 <?php if( $model->diterima_oleh != NULL ){?>
<div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-book"></i><strong> Rekod Pengambilan Surat Kakitangan</strong></h2>
                 
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
 
                <div class="col-md-16 col-sm-10 col-xs-12">
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pegawai : <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->diterima_oleh;?>" disabled="disabled">
                      
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh:
                </label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->rekoddt;?>" disabled="disabled">
                </div> 
               </div> 
                  
                
            </div>  
        
    </div>
 </div><?php } ?>
  <?php if( $model->diterima_oleh == NULL ){?>  
    <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-book"></i><strong> Rekod Pengambilan Surat Kakitangan</strong></h2>
                 
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
 
                <div class="col-md-16 col-sm-10 col-xs-12">
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pegawai : <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                         $form->field($model, 'diterima_oleh')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\lppums\Tblprcobiodata::find()->all(), 'CONm', 'CONm'),
                        'options' => ['placeholder' => 'Nama Kakitangan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        ]);
                        ?>
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh:
                </label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->rekoddt;?>" disabled="disabled">
                </div> 
               </div> 
                  
               <div class="form-group">
               <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
               <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
               <button class="btn btn-primary" type="reset">Reset</button>
               </div>
            </div>
            </div>  
        
    </div>
</div>
  <?php }?>
    </div>

            <?php ActiveForm::end(); 
            Pjax::end();?>
