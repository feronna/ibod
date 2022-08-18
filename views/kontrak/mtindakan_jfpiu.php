<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

error_reporting(0);
$bil=1;

?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


        <div class="col-md-12 col-sm-12 col-xs-12">  
    <div class="x_panel">
        <br>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Status Perakuan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?=
                    $form->field($model, 'status_jfpiu')->label(false)->widget(Select2::classname(), [
                        'data' => ['4' => 'PERMOHOHAN DIPERAKUI', '5' => 'PERMOHONAN DITOLAK'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "4"){
                        $("#tempoh").show();
                        }
                        else{
                        $("#tempoh").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        
        <div class="form-group" id="tempoh" style="display: <?php if($model->status_jfpiu == '4'){echo '';}else {echo 'none';}?>">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Cadangan Tempoh Lantikan Semula Kontrak<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?=
                    $form->field($model, 'tempoh_l_jfpiu')->label(false)->widget(Select2::classname(), [
                        'data' => $model->layaktempohpentadbiran,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Lain-lain"){
                        $("#place-holder").show();
                        }
                        else{
                        $("#place-holder").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
                    <div class="col-md-3 col-sm-8 col-xs-8">
                   <input type="number" id="place-holder" name="tempohs" class="form-control" maxlength="20" style="display: none" placeholder="bulan    cth: 6">
                   
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan <span></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_jfpiu')->textArea(['maxlength' => true, 'rows' => 4, 'required'=> true])->label(false); ?>
                </div>
            </div>
         <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


