<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;
?>

<?= Yii::$app->controller->renderPartial('/smo/_menu'); ?>

<?= Html::a('<i class="fa fa-undo"></i>&nbsp; Kembali ke senarai', ['list-k2'], ['class' => 'btn btn-primary']) ?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info-circle">&nbsp;<strong>Butiran Maklumbalas</strong></i></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= Yii::$app->controller->renderPartial('/smo/view-k2', ['model' => $model]); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o">&nbsp;<strong>Status maklumbalas</strong></i></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
                <?= $form->errorSummary($model); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'detail_pyd'); ?>
                        <!-- <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Perincian"></i> -->
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'detail_pyd')->widget(TinyMce::class, [
                            'options' => ['rows' => 15],
                            'language' => 'en',
                            'clientOptions' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table contextmenu paste"
                                ],
                                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                            ]
                        ])->label(false); ?>
                    </div>
                </div>

                <?= $form->field($model, 'status')->hiddenInput(['value'=>'COMPLETED'])->label(false); ?>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Hantar', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>