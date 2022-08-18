<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\keselamatan\RefPosLmt;
use app\models\keselamatan\RefUnit;
use dosamigos\datepicker\DatePicker;
?>

<?= $this->render('/keselamatan/_topmenu') ?>


<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Tambah Anggota Dalam Lebihan Masa Tambahan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Nama Anggota: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'icno')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($biodata, 'ICNO', 'CONm'),
                        'options' => ['placeholder' => '-- Pilih Anggota --', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Unit: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'unit_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefUnit::find()->where(['active' => 1])->all(), 'id', 'unit_name'),
                        'options' => ['placeholder' => '-- Pilih Unit --', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Pos Kawalan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'pos_kawalan_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefPosLmt::find()->where(['active' => 1])->all(), 'id', 'pos_kawalan'),
                        'options' => ['placeholder' => 'Pilih Pos Kawalan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Bulan :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'month')->label(false)->widget(Select2::classname(), [
                        'data' => ['01' => 'January', '02' => 'February', '03' => 'Mac', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'],
                        'options' => ['placeholder' => 'Pilih Bulan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Syif :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'lmt_id')->label(false)->widget(Select2::classname(), [
                        'data' => ['3' => 'Syif A', '4' => 'Syif C', '5' => 'Syif B'],
                        'options' => ['placeholder' => 'Pilih Syif', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>

                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Tarikh Bertugas:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?> 
                </div>
            </div>
           

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Add Staff', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <br>
        </div>