<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\hronline\JenisAkaun;
use app\models\hronline\TujuanAkaun;
use app\models\hronline\NamaAkaun;
use app\models\hronline\Bandar;
use app\models\hronline\CawanganAkaun;
use kartik\file\FileInput;
use yii\helpers\Json;

?>

<div class="tblakaun-form">

    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-horizontal form-label-left disable-submit-buttons',
                    'enctype' => 'multipart/form-data']]);
    ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoAkaun">No. Akaun: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?= $form->field($model, 'AccNo')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisAkaun">Jenis Akaun: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'AccTypeCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(JenisAkaun::find()->where(['isActive'=> 1])->all(), 'AccTypeCd', 'AccType'),
                        'options' => ['placeholder' => 'Pilih Jenis Akaun', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TujuanAkaun">Tujuan Akaun: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'AccPurposeCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TujuanAkaun::find()->where(['isActive'=> 1])->all(), 'AccPurposeCd', 'AccPurpose'),
                        'options' => ['placeholder' => 'Pilih Tujuan Akaun', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NamaAkaun">Nama Akaun: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'AccNmCd')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(NamaAkaun::find()->where(['isActive'=> 1])->orderBy(['AccNmCd' => SORT_ASC,])->all(), 'AccNmCd', 'AccNm'),
                        'options' => ['placeholder' => 'Pilih Nama Akaun', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CawanganAkaun">Cawangan Akaun: <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'AccBranchCd')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(CawanganAkaun::find()->all(), 'AccBranchCd', 'AccBranchNm'),
                        'options' => [
                            'multiple' => false],
                        'pluginOptions' => [
                            'depends' => [Html::getInputId($model, 'AccNmCd')],
                            'initialize' => true,
                            'placeholder' => 'Pilih Cawangan',
                            'url' => Url::to(['/akaun/cawangan'])
                        ]
                    ])->label(false)
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="daerah">Daerah: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'CityCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Bandar::find()->where(['isActive'=> 1])->all(), 'CityCd', 'City'),
                        'options' => ['placeholder' => 'Pilih Bandar', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NamaCawanganAkaun">Nama Cawangan Akaun: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'AccBranch')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="StatusAkaun">Status Akaun: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'AccStatus')->checkbox(['label' => 'Tandakan Jika Aktif', 'value' => 1, 'uncheck' => 0])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Upload File: <span class="required" style="color:red;">*</span>
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
</div>

<div class="form-group text-center">
    <?= \yii\helpers\Html::a('Kembali', ['adminview','icno'=>$model->ICNO], ['class' => 'btn btn-primary']) ?>
    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success','data'=>['disabled-text'=>'Please wait..']]) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
