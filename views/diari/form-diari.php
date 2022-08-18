<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
use kartik\date\DatePicker;
use kartik\widgets\SwitchInput;

?>



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
                <?= $form->errorSummary($model); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'type'); ?>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Type"></i>
                    </label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?php // Usage with ActiveForm and model
                        echo $form->field($model, 'type')->widget(Select2::classname(), [
                            'data' => $arrType,
                            'options' => ['placeholder' => '--Select type--'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);

                        ?>
                    </div>
                </div>



                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><i><?= Html::activeLabel($model, 'title'); ?></i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Please insert a valid url including the 'http' and 'https'"></i>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'title')->textInput()->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'detail'); ?>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="kandungan Announcement"></i>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'detail')->widget(TinyMce::className(), [
                            'options' => ['rows' => 20],
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
                <hr>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'staf_icno'); ?>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Type"></i>
                    </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?php // Usage with ActiveForm and model
                        echo $form->field($model, 'staf_icno')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($biodata, 'ICNO', 'CONm'),
                            'options' => ['placeholder' => '--PILIH STAF--'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);

                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'due_date'); ?>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?php
                        echo DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'due_date',
                            'options' => ['placeholder' => '--Due date--'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd/mm/yyyy',
                                'todayHighlight' => true,
                                'todayBtn' => true,
                            ]
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
                                'onText' => 'Complete',
                                'offText' => 'In-Progress',
                                'size' => 'small',
                                'onColor' => 'success',
                                'offColor' => 'danger',
                            ]
                        ])->label(false)
                        ?>

                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'fav'); ?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <?=
                        $form->field($model, 'fav')->widget(SwitchInput::classname(), [
                            'pluginOptions' => [
                                'onText' => 'Yes',
                                'offText' => 'No',
                                'size' => 'small',
                                'onColor' => 'success',
                                'offColor' => 'danger',
                            ]
                        ])->label(false)
                        ?>

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