<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
error_reporting(0);
?>
<?php

Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<h5> <strong><center>PENGESAHAN PENERIMAAN TAWARAN PENGAJIAN LANJUTAN</center></strong> </h5>
<div> 
    <div class="x_panel"> 
     
             <div class="form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Keputusan Permohonan:</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                   <?= $form->field($model, 'status_bsm')->textInput(['maxlength' => true, 'rows' => 4, 'disabled' => 'disabled'])->label(false);
                        ?>
                    </div>         
                </div>
        
        
             
 <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Adakah anda terima?:<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'terima1')->label(false)->widget(Select2::classname(), [
                        'data' => ['Ya' => 'TERIMA TAWARAN', 'Tidak' => 'TIDAK TERIMA'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                        'onchange' => 'javascript:if ($(this).val() == "Tidak"){
                        $("#catatan").show();
                        }
                        else
                        {$("#catatan").hide();
                        }'
                        ],
                        'pluginOptions' => [
                        'allowClear' => true
                        ],
                        
                       
                    ]);
                    ?>
                    
                    
                </div>
        </div>

         <div class="form-group" id="catatan" style="display: none" align="center">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Alasan:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan_terima')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
         <!-- <div class="ln_solid"></div> -->
            <?php 
            if($model->terima != "Ya")
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
