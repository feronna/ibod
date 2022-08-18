<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use app\models\utilities\epos\JenisKhidmatMel;
use yii\helpers\ArrayHelper;

error_reporting(0);

?>


<div class="pos-tbl-permohonan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="x_panel">
        <div class="x_title">
            <h4><?= "Maklumat Mel" ?></h4>
            <div class="clearfix"></div>
        </div>
        <div class="x_content ">
            </br>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Tracking: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($modelmel, 'tracking_no')->textarea(['rows' => 4], ['class' => 'form-control col-md-7 col-xs-12',])->label(false);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Penghantaran: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                <?=
                    DatePicker::widget([
                        'model' => $modelmel,
                        'attribute' => 'tarikh_dihantar',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12','required'=>true],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Bayaran: RM <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <?= $form->field($modelmel, 'bayaran_mel')->textInput(['placeholder'=>'0.00','maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>