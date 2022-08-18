<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

?>

<div class="tblpermitkerja-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
         
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoPermit">Work Permit Number: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($permit, 'WrkPermitNo')->textInput(['maxlength' => true])->label(false) ;?>
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoRujukanImigresen">Immigration Reference Number: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($permit, 'ImigRefNo')->textInput(['maxlength' => true])->label(false) ; ?>
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhDikeluarkan">Date of Issue: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <?=
            DatePicker::widget([
                'model' => $permit,
                'attribute' => 'WrkPermitIssueDt',
                'template' => '{input}{addon}',
                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'required'=>'true'],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhLuput">Date of Expiry: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <?=
            DatePicker::widget([
                'model' => $permit,
                'attribute' => 'WrkPermitExpiryDt',
                'template' => '{input}{addon}',
                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'required'=>'true'],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>
        </div>
        </div>
            
       <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Upload File: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php 
                    if( $permit->isNewRecord ? $msg = 'Please provide file in pdf format.' : ($permit->filename ? $msg =  Yii::$app->FileManager->NameFile($permit->filename) : $msg = 'Please provide related file.'));
                    echo $form->field($permit, 'file')->fileInput()->label($msg . " (Max size 6.0 MB)");?>
                </div>
                <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                    <text>If you have more than one PDF file, please combine into one unified document. Uploading new file will replace the old file. The file size must be less than 10MB.</text>
                </div>
            </div>
            
            
        </div>
    </div>

    <div class="form-group text-center">
        <?= \yii\helpers\Html::a( 'Back', ['adminview','icno'=>$permit->ICNO], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
