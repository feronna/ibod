<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
error_reporting(0);
?>
<?php

//Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<div > 
    <div class="x_panel"> 
        <div id="post" class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Status
                        </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <?=
                    $form->field($model, 'status_bsm')->label(false)->widget(Select2::classname(), [
                        'data' => ['4' => 'Approve', '5' => 'Reject', '7' => 'Resignation', '15' => 'Completion of Service'],
                        'options' => ['required' => true,'placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript: if($(this).val() === "7"){
                                $("#statusdate").show();
                                $("#jawatan").hide();
                            $("#tempoh").hide();
                            }
                            else if($(this).val() === "15"){
                            $("#statusdate").hide();
                            $("#jawatan").hide();
                            $("#tempoh").hide();
                            }
                            else{
                            $("#statusdate").hide();
                            $("#jawatan").show();
                            $("#tempoh").show();}'
                           ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?></div>
                </div>
        
        
        <div id="statusdate" class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Date
                        </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <?=
                            $form->field($model, 'status_date')->label(false)->widget(kartik\date\DatePicker::classname(), [
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ],
                'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                ]); ?></div>
        </div>
        
        <div id="jawatan" class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Suggestion Post
                        </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <?=
                            $form->field($model, 'jawatan_diperakui')->label(false)->widget(Select2::classname(), [
                        'data' => $model->getCadanganjawatan('bsm'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            
                           ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
?></div>
                </div>
        <div class="form-group" id="tempoh" >
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Proposed Contract Re-appointment Period<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?php
                    $tempoh =$model->layaktempohakademik;
                    
//                    if($model->markahkeseluruhan1->markah_PP >=85){
//                        $tempoh =ArrayHelper::map(\app\models\Kontrak\RefTempoh::find()->orderBy('tempoh')->all(), 'tempoh', 'tempoh');
//                    }?>
                    <?=
                    $form->field($model, 'tempoh_l_bsm')->label(false)->widget(Select2::classname(), [
                        'data' => $tempoh,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                        'onchange' => 'javascript:if ($(this).val() == "Others"){
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
                    </div><div id="lain" style="padding:0px;float: left;display: <?php echo $display;?>" class="col-md-6 col-sm-6 col-xs-12"style="padding:-5px; margin: 0px; display: inline; font-size: 14px;">Months   
                    </div>
                </div>
            </div>
           
         <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-paper-plane"></i>&nbsp;Submit' ,['class' => 'btn btn-primary','name' => 'hantar', 'value' => '1']) ?>
                    <a style="color: green; font-weight: bold"><?php echo $message;?></a>
                </div>
            </div>
        </div>
    </div>
            <?php ActiveForm::end(); 
//            Pjax::end();
            ?>
