<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\lppums\RefAkses;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Maklumat Pegawai</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td><strong>Nama Pegawai</strong></td>
                                <td><?= $bio->CONm; ?></td>
                            </tr>
                            <tr>
                                <td><strong>No. KP/Pasport</strong></td>
                                <td><?= $bio->ICNO; ?></td>
                            </tr>
                            <tr>
                                <td><strong>JAFPIB</strong></td>
                                <td><?= $bio->department->fullname; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jawatan / Gred</strong></td>
                                <td><?= $bio->jawatan->nama; ?> / <?= $bio->jawatan->gred; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Akses Semasa</strong></td>
                                <td><?= is_null($bio->staffAkses) || ($bio->staffAkses->akses_id == 0) ? 'Tiada Akses' : $bio->staffAkses->akses_id; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Kemaskini Akses</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                        <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                    <div class="form-group"> 
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Akses</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                        <?=
                            $form->field($model, 'akses_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(RefAkses::find()->orderBy(['akses_id' => SORT_ASC])->all(), 'akses_id', 'akses_label'),
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Pilih Akses', 
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    //'selected'    => 2,
                                    //'id' => 'senarai',
                                    ],
                                'pluginOptions' => [
                                    //'allowClear' => true
                                ],
                            ])->label(false);
                        ?>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                        <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?></div>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <?php yii\widgets\Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>          