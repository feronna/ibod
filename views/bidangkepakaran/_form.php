<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\hronline\BidangKepakaran;

?>

<div class="tblbidangkepakaran-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Kluster">Kluster: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <?=
                $form->field($model, 'klusterid')->label(false)->widget(Select2::classname(), [
                   'data' => ArrayHelper::map(BidangKepakaran::find()->all(), 'id', 'kluster'),
                   'options' => ['placeholder' => 'Pilih Kluster Kepakaran', 'class' => 'form-control col-md-7 col-xs-12'],
                   'pluginOptions' => [
                       'allowClear' => true
                   ],
               ]);
               ?>
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="BidangKepakaran">Bidang Kepakaran: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <?= $form->field($model, 'bidang')->textInput(['maxlength' => true])->label(false); ?>
            </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Upload File: <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php 
                    if( $model->isNewRecord ? $msg = 'Please provide file in pdf format.' : ($model->filename ? $msg =  Yii::$app->FileManager->NameFile($model->filename) : $msg = 'Please provide related file.'));
                    echo $form->field($model, 'file')->fileInput()->label($msg. " (Max size 6.0 MB)");?>
                </div>
                <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                    <text>If you have more than one PDF file, please combine into one unified document. Uploading new file will replace the old file.</text>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group text-center">
         <?= Html::a('Kembali', ['view'],  ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
