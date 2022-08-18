<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\NamaBahasa */

$this->title = 'Nama Bahasa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nama-bahasa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="nama-bahasa-form">

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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">ID: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'LangCd')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Nama Bahasa: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'Lang')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
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
