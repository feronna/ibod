<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\elnpt\testing\RefUserAccess;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="panel-heading">
            <h3 class="panel-title">Maklumat Pengguna</h3>
        </div>
        <div class="panel-body">
            <table class="table table-sm table-bordered">
                <tr>
                    <td><strong>Nama</strong></td>
                    <td><?= $bio->CONm; ?></td>
                </tr>
                <tr>
                    <td><strong>No. KP/Pasport</strong></td>
                    <td><?= $bio->ICNO; ?></td>
                </tr>
                <tr>
                    <td><strong>JSPIU</strong></td>
                    <td><?= $bio->department->fullname; ?></td>
                </tr>
                <tr>
                    <td><strong>Jawatan / Gred</strong></td>
                    <td><?= $bio->jawatan->nama; ?> / <?= $bio->jawatan->gred; ?></td>
                </tr>
            </table>
        </div>
    </div>
    </div>
</div>
    

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="panel-heading">
            <h3 class="panel-title">Kemaskini Akses</h3>
        </div>
        <div class="panel-body">
            <div class="form-group"> 
                <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">AKSES</label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                <?=
                    $form->field($model, 'access')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefUserAccess::find()->orderBy(['id' => SORT_ASC])->all(), 'id', 'desc'),
//                        'data' => ['0' => 'TIADA', '1' => 'ADA'],
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