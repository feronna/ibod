<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\JenisKecacatan;
use app\models\hronline\PuncaKecacatan;

?>

<div class="tblkecacatan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
         
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoFailKebajikan">No. Fail Kebajikan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'SocialWelfareNo')->textInput(['maxlength' => true])->label(false); ?>
        </div>
        </div> 
         
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoLaporanDoktor">No. Laporan Doktor: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'DrRptNo')->textInput(['maxlength' => true])->label(false); ?>
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisKecacatan">Jenis Kecacatan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
 
            <?=
            $form->field($model, 'DisabilityTypeCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(JenisKecacatan::find()->all(), 'DisabilityTypeCd', 'DisabilityType'),
                'options' => ['placeholder' => 'Pilih Jenis Kecacatan', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="PuncaKecacatan">Punca Kecacatan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
 
            <?=
            $form->field($model, 'DisabilityCauseCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(PuncaKecacatan::find()->all(), 'DisabilityCauseCd', 'DisabilityCause'),
                'options' => ['placeholder' => 'Pilih Punca Kecacatan', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhKecacatan">Tarikh Kecacatan: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'DisabilityDt',
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
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhSembuh">Tarikh Sembuh: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'HealDt',
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Upload Kad Kebajikan: <span class="required" style="color:red;">*</span>
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
        <?= \yii\helpers\Html::a( 'Kembali', ['view'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
