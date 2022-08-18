<?php

use app\models\hronline\Department;
use kartik\date\DatePicker;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Carian Profil', Url::to(['data-list'])) ?></li>
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Perincian', Url::to(['perincian-profil', 'icno' => $biodata->ICNO])) ?></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah & Kemaskini Profil</li>
    </ol>
</nav>

<?= $this->render('_detail_staff', [
    'biodata' => $biodata,
]) ?>

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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'jenis_lantikan'); ?>
                    </label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'jenis_lantikan')->label(false)->widget(Select2::classname(), [
                            'data' => ['UMS' => 'UMS', 'HUMS' => 'HUMS'],
                            'options' => ['placeholder' => 'Pilih jenis lantikan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'pusat_kos'); ?>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'pusat_kos')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::findAll(['isActive' => 1]), 'id', 'fullname'),
                            'options' => ['placeholder' => 'Pilih Pusat Kos', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'sumber_peruntukan'); ?>
                    </label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'sumber_peruntukan')->label(false)->widget(Select2::classname(), [
                            'data' => $arrSumberPeruntukan,
                            'options' => ['placeholder' => 'Pilih Sumber Lantikan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'status_kontrak'); ?>
                    </label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'status_kontrak')->label(false)->widget(Select2::classname(), [
                            'data' => $arrStatusKontrak,
                            'options' => ['placeholder' => 'Pilih Status Kontrak', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'start_date'); ?>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?php
                        echo DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'start_date',
                            'options' => ['placeholder' => '--Tarikh mula kuatkuasa--'],
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


                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Kembali', ['perincian-profil', 'icno' => $biodata->ICNO], ['class' => 'btn btn-default']); ?>
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Simpan', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>