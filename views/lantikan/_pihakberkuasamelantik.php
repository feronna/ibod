<?php

use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Pihak Berkuasa Melantik</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <p style="color: green">
                Petak dengan tanda * wajib diisi.
            </p>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Dilantik<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'AptAthyStDt',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>
                </div>
                <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                    <text>Tarikh mula Lantikan untuk lantikan pertama.</text>
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