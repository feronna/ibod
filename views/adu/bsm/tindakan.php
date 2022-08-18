<?php

use app\models\lppums\RefBahagian;
use app\models\lppums\RefKriteria;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\widgets\DetailView;
use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$data = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10];
?>

<?= Yii::$app->controller->renderPartial('/adu/_menu'); ?>

<?= Html::a('<i class="fa fa-undo"></i>&nbsp; Kembali ke senarai', ['list-bsm'], ['class' => 'btn btn-primary']) ?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info">&nbsp;<strong>Butiran Aduan</strong></i></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= Yii::$app->controller->renderPartial('/adu/view', ['model' => $model]); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o">&nbsp;<strong>Respon</strong></i></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-striped table-sm jambo_table table-bordered">
                    <thead>
                        <tr class="headings">
                            <th class="text-center">Bil</th>
                            <th class="text-center">Ulasan</th>
                            <th class="text-center">Syor</th>
                            <th class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <?php if ($responList) { ?>
                        <?php foreach ($responList as $v) { ?>
                            <tr>
                                <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                <td><?= $v->ulasan ?></td>
                                <td><?= $v->syor ?></td>
                                <td>
                                    <?= $v->bio->CONm ?>
                                    <br>
                                    <?= $v->create_dt ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <?php $form = ActiveForm::begin([
                        'action' => ['adu/respon-kj'],
                        'method' => 'post',
                        'options' => [
                            'class' => 'form-horizontal form-label-left disable-submit-buttons',
                            'enctype' => 'multipart/form-data'
                        ]
                    ]) ?>
                    <?= $form->errorSummary($respon); ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <?= $form->field($respon, 'ulasan')->widget(TinyMce::className(), [
                                'options' => ['rows' => 10],
                                'language' => 'en',
                                'clientOptions' => [
                                    'menubar' => 'false',
                                    'plugins' => [
                                        "advlist autolink lists link charmap print preview anchor",
                                        "searchreplace visualblocks code fullscreen",
                                        "insertdatetime media table contextmenu paste"
                                    ],
                                    'toolbar' => "bold italic | bullist numlist outdent indent"
                                ]
                            ])->label(false); ?>
                        </td>
                        <td>
                            <?= $form->field($respon, 'syor')->widget(TinyMce::className(), [
                                'options' => ['rows' => 10],
                                'language' => 'en',
                                'clientOptions' => [
                                    'menubar' => 'false',
                                    'plugins' => [
                                        "advlist autolink lists link charmap print preview anchor",
                                        "searchreplace visualblocks code fullscreen",
                                        "insertdatetime media table contextmenu paste"
                                    ],
                                    'toolbar' => "bold italic | bullist numlist outdent indent"
                                ]
                            ])->label(false); ?>
                        </td>
                        <td>
                            <?= $form->field($respon, 'icno')->label(false)->hiddenInput(['value' => $icno]); ?>
                            <?= $form->field($respon, 'main_id')->label(false)->hiddenInput(['value' => $model->id]); ?>
                            <?= $form->field($respon, 'redirectUrl')->label(false)->hiddenInput(['value' => $redirectUrl]); ?>
                            <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Tambah Respon', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                        </td>
                    </tr>
                    <?php ActiveForm::end(); ?>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o">&nbsp;<strong>Status Aduan</strong></i></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
                <?= $form->errorSummary($model); ?>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Aspek Penilaian</th>
                                <th class="text-center">Kriteria</th>
                                <th class="text-center">Skala Aduan</th>
                                <th class="text-center">Skala Respon</th>
                            <tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><strong><?php echo RefBahagian::findOne(['bahagian_id' => $model->bhgn_id])->bahagian; ?></strong></td>
                                <td>
                                    <strong><?php echo RefKriteria::retLabel($model->kriteria_id, 1); ?></strong>
                                    <br>
                                    <?php echo RefKriteria::retLabel($model->kriteria_id, 2); ?>
                                </td>
                                <td class="text-center"><strong><?php echo $model->skala_aduan; ?></strong></td>
                                <td class="text-center"><?= $form->field($model, 'skala_respon')->radioButtonGroup($data, ['class' => '', 'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']]])->label(false); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'respon_detail'); ?>
                        <!-- <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Perincian"></i> -->
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'respon_detail')->widget(TinyMce::class, [
                            'options' => ['rows' => 10],
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'status'); ?>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Type"></i>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?php // Usage with ActiveForm and model
                        echo $form->field($model, 'status')->widget(Select2::classname(), [
                            'data' => $arrStatus,
                            'options' => ['placeholder' => '--Select Status--'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);

                        ?>
                    </div>
                </div>

                <div class="ln_solid"></div>


                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Save', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>