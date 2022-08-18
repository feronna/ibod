<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
use kartik\date\DatePicker;
use kartik\file\FileInput;


$data = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10];
?>

<?= Yii::$app->controller->renderPartial('/smo/_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-book"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">


                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'fungsi_id'); ?>
                    </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?php // Usage with ActiveForm and model
                        echo $form->field($model, 'fungsi_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($fungsi, 'id', 'detail'),
                            'options' => ['placeholder' => '-- PILIH FUNGSI OPERASI --'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);

                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'location'); ?>
                        <!-- <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Lokasi Aduan/Kejadian"></i> -->
                    </label>
                    <div class="col-md-6 col-sm-5 col-xs-12">
                        <?php // Usage with ActiveForm and model
                        echo $form->field($model, 'location')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($department, 'id', 'fullname'),
                            'options' => ['placeholder' => '-- PILIH PTJ --'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);

                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'detail'); ?>
                        <!-- <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Perincian"></i> -->
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'detail')->widget(TinyMce::className(), [
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
                <div class="ln_solid"></div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'file'); ?></label>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                        echo $form->field($model, 'file', ['enableAjaxValidation' => false])->label(false)->widget(FileInput::class, [
                            'options' => [
                                'accept' => ['image/*', 'application/pdf'],
                            ],
                            'pluginOptions' => [
                                'showUpload' => false
                            ],

                        ]);
                        ?>
                    </div>
                    <?= Html::error($model, 'file3'); ?>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <p>Attachment *Only images (jpg, jpeg, png) or PDF is allowed (Max upload: 2MB)</p>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    </div>
                </div>

                <div class="ln_solid"></div>


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
<?= $this->render('_skala'); ?>