<?php

use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Tempoh Percubaan</h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <p style="color: green">
                    Petak dengan tanda * wajib diisi.
                </p>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh Percubaan<span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?= $form->field($model, 'ProbtnPeriod')->textInput(['placeholder'=>'Jumlah bulan','maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                    <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                        <text>Tempoh maximum percubaan adalah 36 bulan.</text>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh Percubaan Min<span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?= $form->field($model, 'ProbtnPeriodMin')->textInput(['placeholder'=>'Jumlah bulan','maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                    <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                        <text>Tempoh minimum percubaan adalah 12 bulan.</text>
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula<span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'ProbtnStDt',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-3 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat<span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'ProbtnEndDt',
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
                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= \yii\helpers\Html::a('Kembali', ['view-lantikan', 'id' => $model->ICNO], ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Tunggu..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>