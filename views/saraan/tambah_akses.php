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
        </div>
        <div class="panel-body">
            <div class="form-group"> 
                <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Staff</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                    $form->field($model, 'staf_akses_icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                        // 'hideSearch' => true,
                        'options' => [
                            'placeholder' => 'Pilih Nama', 
                            'class' => 'form-control col-md-7 col-xs-12',
                            //'selected'    => 2,
                            'id' => 'senarai111111',
                            ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
                </div>
                </div>
                
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">AKSES</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                    $form->field($model, 'staf_akses_id')->widget(Select2::classname(), [
//                        'data' => ArrayHelper::map(RefUserAccess::find()->orderBy(['id' => SORT_ASC])->all(), 'id', 'desc'),
                        'data' => [
                            '99' => 'ALL',
                            '88' => 'INSERT, UPDATE, DELETE, VER_STATUS',
                            '77' => 'INSERT, UPDATE, DELETE, APP_STATUS',
                            '60' => 'INSERT, UPDATE, DELETE',
                            '50' => 'VIEW ONLY',
                            ],
                        'hideSearch' => true,
                        'options' => [
                            'placeholder' => 'Pilih Akses', 
                            'class' => 'form-control col-md-7 col-xs-12',
                            //'selected'    => 2,
                            'id' => 'senarai11',
                            ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
                </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Tambah', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                
            <?php ActiveForm::end(); ?>
            <?php yii\widgets\Pjax::end() ?>
        </div>
    </div>
    </div>
</div>