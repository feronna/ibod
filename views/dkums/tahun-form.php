<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use kartik\switchinput\SwitchInput;
?>
<?= Yii::$app->controller->renderPartial('_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-briefcase"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
                <?= $form->errorSummary($model); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'tahun'); ?>
                    </label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?= $form->field($model, 'tahun')->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'fasa'); ?>
                    </label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'fasa')->label(false)->widget(Select2::classname(), [
                            'data' => [1 => '1', 2 => '2'],
                            'options' => ['placeholder' => 'Pilih Fasa', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'status'); ?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <?=
                        $form->field($model, 'status')->widget(SwitchInput::classname(), [
                            'pluginOptions' => [
                                'onText' => 'Aktif',
                                'offText' => 'Tidak Aktif',
                                'size' => 'small',
                                'onColor' => 'success',
                                'offColor' => 'danger',
                            ]
                        ])->label(false)
                        ?>

                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'papar'); ?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <?=
                        $form->field($model, 'papar')->widget(SwitchInput::classname(), [
                            'pluginOptions' => [
                                'onText' => 'Ya',
                                'offText' => 'Tidak',
                                'size' => 'small',
                                'onColor' => 'success',
                                'offColor' => 'danger',
                            ]
                        ])->label(false)
                        ?>

                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'slot_id'); ?>
                    </label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?= $form->field($model, 'slot_id')->label(false); ?>
                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Kembali', ['senarai-tahun', 'id' => $model->id], ['class' => 'btn btn-warning']); ?>
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Simpan', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>