<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\web\JsExpression;

$url = \yii\helpers\Url::to(['name-list']);

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">STAF</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?=
                            $form->field($model, 'icno')->widget(Select2::classname(), [
                                'options' => [
                                    'id' => '_test',
                                    'placeholder' => 'Pilih Staff',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $url,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term, page:params.page || 1}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                                ],
                            ])->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">PERKARA</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?=
                            $form->field($model, 'content')->textArea(['class' => 'form-control', 'rows' => 5, 'placeholder' => '------------------------- Perkara -------------------------', 'style' => "resize: none;"])->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile"><?= ($model->isNewRecord) ? 'Muat Naik Dokumen Sokongan: ' : 'Dokumen Sokongan: ' ?><span class="required" style="color:red;"><?= ($model->isNewRecord) ? '*' : '' ?></span><br /><sub>Limit saiz fail 5MB<br />Hanya format png dan pdf diterima</sub>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                            <?php
                            if (!($model->isNewRecord)) {
                                echo $form->field($model, 'file')->widget(FileInput::classname(), [
                                    'options' => [
                                        'accept' => 'application/pdf, image/jpg, image/png',
                                        'multiple' => false,
                                    ],
                                    'pluginOptions' => [
                                        'allowedFileExtensions' => ['pdf', 'jpg', 'png'],
                                        'showUpload' => false,
                                        'overwriteInitial' => true,
                                        'initialPreview' => [
                                            Url::to(Yii::$app->FileManager->DisplayFile($model->filehash), true),
                                        ],
                                        'initialPreviewAsData' => true,
                                        'initialCaption' => $model->file_name,
                                    ],
                                ])->label(false);
                            } else {
                                echo $form->field($model, 'file')->widget(FileInput::classname(), [
                                    'options' => [
                                        'accept' => 'application/pdf, image/jpg, image/png',
                                        'multiple' => false,
                                    ],
                                    'pluginOptions' => [
                                        'allowedFileExtensions' => ['pdf', 'jpg', 'png'],
                                        'showUpload' => false,
                                        'overwriteInitial' => true,
                                    ]
                                ])->label(false);
                            }
                            ?>
                        </div>
                    </div>

                    <hr />

                    <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Kemaskini', ['class' => 'btn btn-primary pull-right']) ?>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>