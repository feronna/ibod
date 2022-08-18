<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\number\NumberControl;
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">STATUS SEMAKAN <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-6">
            <?=
        $form->field($model, 'status_check')->label(false)->widget(Select2::classname(), [
            'data' => ['DISEMAK' => 'SEMAKAN LAYAK', 'DITOLAK' => 'SEMAKAN TIDAK LAYAK'],
            'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                'onchange' => 'javascript:if ($(this).val() == "Dipersetujui"){
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
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">CATATAN<span class="required">*</span>
        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'catatan_check')->textArea(['maxlength' => true, 'rows' => 2])->label(false); ?>
                       </div>
                       </div>
        <label class="control-label col-md-3 col-sm-3 col-xs-12">JUMLAH LULUS<span class="required">*</span>
        </label>   
        <div class="col-md-4 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'jumlah_lulus')->widget(NumberControl::classname(), [
                         'name' => 'jumlah_lulus',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM ',
                             'rightAlign' => false
                           ],
                         
                         'displayOptions' => [
                            'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                </div>

<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button class="btn btn-primary" type="reset">Reset</button>
        <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
    </div>
</div>
</div>
<?php ActiveForm::end(); ?>

<!--form-->


