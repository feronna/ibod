<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\MajorMinor */

$this->title = 'Tambah Major/Minor';
?>
<div class="major-minor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="major-minor-form">

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
                        <?= $form->field($model, 'MajorMinorCd')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nmm">Nama Major/Minor: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'MajorMinor')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhDikeluarkan"> Tarikh Major/Minor Mula: <span class="required" style="color:red;"></span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'MajorMinorStDt',
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhAkhir"> Tarikh Major/Minor Akhir: <span class="required" style="color:red;"></span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'MajorMinorEndDt',
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
            <?= Html::submitButton('simpan', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
