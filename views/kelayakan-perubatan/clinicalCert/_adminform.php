<?php

use app\models\hronline\certificateType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\Institut;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\Penaja;
use app\models\hronline\MajorMinor;
use yii\helpers\Url;


?>

<div class="tblpendidikan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $model->isNewRecord ?'New Certificate' : 'Update Certificate'?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Title: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'title')->textInput(['placeholder' => 'title'], ['maxlength' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Type: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'type')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(certificateType::find()->where(['isActive' => 1])->all(), 'id', 'certType'),
                        'options' => ['placeholder' => 'choose..', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Certificate No.: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <?= $form->field($model, 'certNo')->textInput(['placeholder' => 'Cert. No.'], ['maxlength' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Awarded Date: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dateAwd',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'required' => true],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'startDt',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'id' => 'tarikhmulapengajian'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">End Date: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'endDt',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'required' => true],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Award By: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'awardBy')->textArea(['placeholder' => 'Orgs Name..'], ['maxlength' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Upload Proof: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-10 ">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php
                    if ($model->isNewRecord ? $msg = 'Please provide file in pdf format.' : ($model->proof ? $msg =  Yii::$app->FileManager->NameFile($model->proof) : $msg = 'Please provide related file.'));
                    echo $form->field($model, 'file')->fileInput()->label($msg . " (Max size 6.0 MB)"); ?>
                </div>
                <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                    <text>If you have more than one PDF file, please combine into one unified document. Uploading new file will replace the old file.</text>
                </div>
            </div>
        </div>

    </div>
    <div class="form-group text-center">
    <?= Html::a('Kembali', ['admin-view','icno'=>$model->icno],  ['class' => 'btn btn-primary']) ?>
    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>
</div>

<?php ActiveForm::end(); ?>
</div>
