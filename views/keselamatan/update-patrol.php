<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\TimePicker;
use dosamigos\datepicker\DatePicker;
?>

<!--<div class="control-label col-md-12">-->
<div class="x_panel">

    <div class="x_title">
        <h2>Selenggara Kawalan</h2>

        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <div class="form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12">Nama Kawalan : <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'jenis_shifts')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12">Kawalan Mula : <span class="required" style="color:red;">*</span>
            </label>

            <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'start_date',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                ?>
            </div>
            <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                <?=
                    TimePicker::widget([
                        'model' => $model,
                        'attribute' => 'start_time',
                        'pluginOptions' => [
                            'showSeconds' => true,
                            'showMeridian' => false,
                            'minuteStep' => 1,
                            'secondStep' => 5,
                        ]
                    ]);
                ?>
            </div>

        </div>

        <div class="form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12">Kawalan Tamat : <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">

                <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'end_date',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                ?>
            </div>
            <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                <?=
                    TimePicker::widget([
                        'model' => $model,
                        'attribute' => 'end_time',
                        'pluginOptions' => [
                            'showSeconds' => true,
                            'showMeridian' => false,
                            'minuteStep' => 1,
                            'secondStep' => 5,
                        ]
                    ]);
                ?>

            </div>

        </div>

        <div class="form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12">Spesifikasi Kawalan : <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'details')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="reset">Reset</button>
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'url' => ['index']]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<!--</div>-->