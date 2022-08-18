<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;


$this->title = $model->fullname ?? 'Sila Lengkapkan Maklumat Diperlukan.';
?>
<div class="bandar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="bandar-form">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div class="x_panel">
            <div class="x_title">
                <h2><?= $model->isNewRecord ? 'Tambah':'Kemaskini' ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Chief: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model, 'chief')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => 'Cari Staf', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">P.A. Email: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <?= $form->field($model, 'pa_email')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">Office No.: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tel_no')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">UC No.: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'uc_no')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">Fax No.: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <?= $form->field($model, 'fax_no')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Address: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'address')->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="form-group text-center">
            <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
