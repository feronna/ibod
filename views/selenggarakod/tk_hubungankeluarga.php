<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\HubunganKeluarga */

$this->title = 'Hubungan Keluarga';
?>
<div class="badan-profesional-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="hubungan-keluarga-form">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div class="x_panel">
            <div class="x_title">
                <h2><?= $this->title; ?></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">ID: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'RelCd')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">Badan Hubungan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'RelNm')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'isActive')->checkbox(['label' => 'Tandakan jika aktif', 'value' => 1, 'uncheck' => 0])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-center">
            <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>