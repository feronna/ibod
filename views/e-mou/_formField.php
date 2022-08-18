<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Html;

use app\models\e_mou\RefMemorandumProgram;
?>

<div class="row">
    <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <?php $form = ActiveForm::begin(['id' => 'search', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => false]]); ?>



                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Bidang Kerjasama</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'field_desc')->textInput([
                            'placeholder' => 'Bidang Kerjasama',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <?php yii\widgets\Pjax::end() ?>
</div>