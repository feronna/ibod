<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\JenisPasport;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use yii\helpers\Url;

?>

<div class="tblpasport-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoPasport">Passport Number: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($paspot, 'PassportNo')->textInput(['maxlength' => true])->label(false) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisPasport">Passport Type: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                        $form->field($paspot, 'PassportTypeCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(JenisPasport::find()->all(), 'PassportTypeCd', 'PassportType'),
                            'options' => ['placeholder' => 'Select Type', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                </div>
            </div>

            <div class="form-group" id="negara">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Negara">Nationality: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($paspot, 'CountryCd')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Negara::find()->where(['isActive' => 1])->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                            'options' => [
                                'placeholder' => 'Select Country'
                            ],
                        ])->label(false);
                    ?>
                </div>
            </div>

            <div class="form-group" id="negeri">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Negeri">Place of Birth: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($paspot, 'StateCd')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Negeri::find()->orderBy(['StateCd' => SORT_ASC,])->all(), 'StateCd', 'State'),
                            'options' => [
                                'placeholder' => 'Select State'
                            ],
                        ])->label(false);
                    ?>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Date of Issue: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                    <?=
                        DatePicker::widget([
                            'model' => $paspot,
                            'attribute' => 'IssuedDt',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12','required'=>true],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Date of Expiry: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                    <?=
                        DatePicker::widget([
                            'model' => $paspot,
                            'attribute' => 'PassportExpiryDt',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12','required'=>true],
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
                    if ($paspot->isNewRecord ? $msg = 'Please provide file in pdf,jpg,jpeg or png format.' : ($paspot->filename ? $msg =  Yii::$app->FileManager->NameFile($paspot->filename) : $msg = 'Please provide related file.'));
                    echo $form->field($paspot, 'file')->fileInput()->label($msg . " (Max size 6.0 MB)"); ?>
                </div>
                <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                    <text>If you have more than one PDF file, please combine into one unified document. Uploading new file will replace the old file. The file size must be less than 10Mb.</text>
                </div>
            </div>

        </div>
    </div>


    <div class="form-group text-center">
        <?= Html::a('Back', ['view'],  ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>