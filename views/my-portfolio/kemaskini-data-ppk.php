<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
?>
<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/my-portfolio/_menu'); ?>
</div>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Kemaskini Data Pegawai Melulus</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
 <div class="table-responsive">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left'], 'method' => 'post']); ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Melulus<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'kj')->label(false)->widget(Select2::classname(), [
                        'data' => $pegawai,
                        'options' => ['placeholder' => 'Pilih Pegawai', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
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

