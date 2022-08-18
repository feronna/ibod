<?php

use app\models\hronline\Tblprcobiodata;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\kehadiran\TblRekod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-rekod-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'day')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tarikh')->textInput() ?>

    <?= $form->field($model, 'time_in')->textInput() ?>

    <?= $form->field($model, 'time_out')->textInput() ?>

    <?= $form->field($model, 'total_hours')->textInput() ?>

    <?= $form->field($model, 'reason_id')->textInput() ?>

    <?= $form->field($model, 'late_in')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'early_out')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'incomplete')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'absent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'external')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'app_by')->textInput(['maxlength' => true]) ?>
    <?=
    $form->field($model, 'app_by')->label(false)->widget(Select2::class, [
        'data' => ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
        'options' => ['placeholder' => '--Nama Pelulus --', 'class' => 'form-control col-md-8 col-xs-12'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'app_dt')->textInput() ?>

    <?= $form->field($model, 'remark_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wp_id')->textInput() ?>

    <?= $form->field($model, 'in_lat_lng')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'out_lat_lng')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'in_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'out_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_remark')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>