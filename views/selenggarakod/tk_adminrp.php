<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


$this->title = 'Admin Reset Password';
?>
<div class="gelaran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="gelaran-form">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div class="x_panel">
            <div class="x_title">
                <h2><?= "Assign Access to User" ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">IC / KP / Name: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($model, 'icno')->label(false)->widget(Select2::classname(), [
                                'data' => $user_set,
                                'options' => ['placeholder' => 'Assign', 'class' => 'form-control col-md-7 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">Access Type: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($model, 'access_type')->label(false)->widget(Select2::classname(), [
                                'data' => ["1" => "View Only", "2" => "View and Reset Password"],
                                'options' => ['placeholder' => 'Select Access', 'class' => 'form-control col-md-7 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'isActive')->checkbox(['label' => ' is Active', 'value' => 1, 'uncheck' => 0])->label(false) ?>
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