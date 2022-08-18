<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\JenisLesen;
use app\models\hronline\KelasLesen;

?>

<div class="tbllesen-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoLese">No. Lesen: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'LicNo')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Nama Pemilik Lesen:</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'Name')->textInput(['placeholder'=>'Perlu sekiranya lesen dimasukkan bukan milik sendiri'],['maxlength' => true])->label(false); ?>
                </div>
                <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                    <text>Isi sekirnya lesen yang dimasukkan bukan milik sendiri.</text>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisLesen">Jenis Lesen: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'LicCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(JenisLesen::find()->all(), 'LicCd', 'LicType'),
                        'options' => ['placeholder' => 'Pilih Jenis Lesen', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="KelasLesen">Kelas Lesen: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'LicClassCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(KelasLesen::find()->all(), 'LicClassCd', 'LicClass'),
                        'options' => ['placeholder' => 'Pilih Kelas Lesen', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhDikeluarkan">Tarikh Dikeluarkan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'FirstLicIssuedDt',
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhLuput">Tarikh Luput: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'LicExpiryDt',
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="YuranPembaharuan">Yuran Pembaharuan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'LicRnwlFee')->textInput(['placeholder' => 'RM'], ['maxlength' => true])->label(false); ?>
                </div>

            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Upload Lesen: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php
                    if ($model->isNewRecord ? $msg = 'Please provide file in pdf format.' : ($model->filename ? $msg =  Yii::$app->FileManager->NameFile($model->filename) : $msg = 'Please provide related file.'));
                    echo $form->field($model, 'file')->fileInput()->label($msg . " (Max size 6.0 MB)"); ?>
                </div>
                <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                    <text>If you have more than one PDF file, please combine into one unified document. Uploading new file will replace the old file.</text>
                </div>
            </div>

        </div>
    </div>


    <div class="form-group text-center">
        <?= Html::a('Kembali', ['view'],  ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>