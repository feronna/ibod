<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\file\FileInput;
use yii\helpers\Url;


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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'location'); ?>
                        <!-- <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Lokasi Aduan/Kejadian"></i> -->
                    </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?php // Usage with ActiveForm and model
                        echo $form->field($model, 'location')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($department, 'id', 'fullname'),
                            'options' => ['placeholder' => '-- PILIH JAFPIB --'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);

                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'complaint_dt'); ?>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?php
                        echo DatePicker::widget([
                            'model' => $model,
                            // 'form' => $form,
                            'attribute' => 'complaint_dt',
                            'options' => ['placeholder' => '-- Pilih Tarikh--'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd/mm/yyyy',
                                'todayHighlight' => true,
                                'todayBtn' => true,
                            ]
                        ]);
                        ?>

                    </div>
                    <?php echo Html::error($model, 'complaint_dt'); ?>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><i><?= Html::activeLabel($model, 'title'); ?></i>
                        <!-- <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tajuak Aduan"></i> -->
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'title')->textInput()->label(false); ?>
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
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'bhgn_id'); ?>
                        <!-- <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Aspek Penilaian"></i> -->
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?php // Usage with ActiveForm and model
                        echo $form->field($model, 'bhgn_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($bhgn, 'bahagian_id', 'bahagian'),
                            'options' => ['placeholder' => '-- PILIH ASPEK PENILAIAN --'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);

                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'kriteria_id'); ?>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Kriteria Penilaian"></i>
                    </label>
                    <div class="col-md-7 col-sm-7 col-xs-12">

                        <?=
                        $form->field($model, 'kriteria_id')->widget(DepDrop::classname(), [
                            'type' => DepDrop::TYPE_SELECT2,
                            'data' => ArrayHelper::map($kriteria, 'kriteria_id', 'kriteria_label'),
                            'options' => [
                                'multiple' => false
                            ],
                            'pluginOptions' => [
                                'depends' => [Html::getInputId($model, 'bhgn_id')],
                                'initialize' => true,
                                'placeholder' => 'Pilih Kriteria Penilaian',
                                'url' => Url::to(['/adu/criteria-list'])
                            ]
                        ])->label(false)
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><i><?= Html::activeLabel($model, 'skala_aduan'); ?></i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Sila Rujuk Skala Penilaian di bahagian bawah"></i>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?php //echo $form->field($model, 'skala_aduan')->textInput(['type' => 'number', 'min' => 1, 'max' => 10])->label(false); ?>
                        <?= $form->field($model, 'skala_aduan')->radioButtonGroup($data, ['class' => '', 'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']]])->label(false); ?>
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
                        <?= Html::a('<i class="fa fa-undo"></i>&nbsp; Back', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Save', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
<?= $this->render('_skala'); ?>