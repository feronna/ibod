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
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'data-pjax' => true ]]); ?>
<div style="display: <?php echo $displaytempoh;?>"> 
    <div class="x_panel"> 
        <div class="form-group" id="tempoh" >
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Tempoh Lantikan Semula Kontrak<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'tempoh_l_bsm')->label(false)->widget(Select2::classname(), [
                        'data' => $model->layaktempohpentadbiran,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                        'onchange' => 'javascript:if ($(this).val() == "Lain-lain"){
                        $("#place-holder").show();
                        $("#lain").show();
                        }
                        else{
                        $("#place-holder").hide();
                                                $("#lain").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
                    <div class="col-md-3 col-sm-8 col-xs-8" style="display: inline">
                       <input type="number" id="place-holder" name="tempohs" style="display: <?php echo $display;?>" class="form-control" maxlength="2" value="<?php echo (float)$lain;?>">
                    </div><div id="lain" style="padding:0px;float: left;display: <?php echo $display;?>" class="col-md-6 col-sm-6 col-xs-12"style="padding:-5px; margin: 0px; display: inline; font-size: 14px;">Bulan   
                    </div>
                </div>
            </div>
           
         <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Simpan' ,['class' => 'btn btn-primary','name' => 'simpan']) ?>
                    <a style="color: green; font-weight: bold"><?php echo $message;?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12" style="display: <?php echo $displaylapor;?>"> 
    <div class="x_panel"> 
        <div class="form-group" id="tempoh" >
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Lapor Diri:<span class="required"></span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-6" style="padding-top :5px;">
                <input type="radio" name="lapordiri" value="ya" ><i class="fa fa-check"></i>
                &nbsp;<input type="radio" name="lapordiri" value="tidak" ><i class="fa fa-remove"></i>
                </div>
            </div>
           
         <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-paper-plane"></i>&nbsp;Hantar' ,['class' => 'btn btn-primary', 'name' => 'hantar']) ?>
                    <a style="color: green; font-weight: bold"><?php echo $message;?></a>
                </div>
            </div>
        </div>
    </div>
            <?php ActiveForm::end(); 
            Pjax::end();?>
