<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Subjek;
use app\models\hronline\Gred;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblsubjek */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblsubjek-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Subjek">Subjek: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'Subject_id')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Subjek::find()->where(['isActive'=>1])->all(), 'subject_id', 'subject_name'),
                'options' => ['placeholder' => 'Pilih Subjek', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Subjek">Subjek: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'grade_id')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Gred::find()->where(['isActive'=>1])->all(), 'grade_id', 'grade_name'),
                'options' => ['placeholder' => 'Pilih Grade', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        </div>  
    </div>

    <div class="form-group text-center">
        <?= Html::a('Kembali', Yii::$app->request->referrer,  ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
