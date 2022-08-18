<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;

?>

<div class="tbllesen-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


    <div class="x_panel">
        <div class="x_title">
            <h2><?= "Kemaskini Katalaluan" ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <p style="color:royalblue">*Nota: Selepas anda berjaya menukar katalaluan, anda perlu log masuk semula kedalam sistem menggunakan katalaluan baru anda.</p>
        </br>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoLese">Katalaluan Lama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="form-group col-md-5 col-sm-5 col-xs-12">
                    <?= $form->field($reset_password, 'old_pass')->passwordInput(['id'=>'loginform-password','maxlength' => true, 'placeholder' => 'Tulis katalaluan lama', 'autocomplete' => 'off'])->label(false) ?>
                    
                </div>
                <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('invalid_old_password'); ?></span>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Katalaluan Baru: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-9 col-xs-12">
                    <?= $form->field($reset_password, 'new_pass1')->label(false)->widget(PasswordInput::classname(), [
                        'pluginOptions' => [
                            'showMeter' => true,
                            'toggleMask' => false,
                            'autocomplete' => 'off'
                        ],
                        'options' => [
                            'placeholder' => 'Tulis katalaluan',
                            'autocomplete' => 'off'
                        ]
                    ]); ?>
                </div>
                <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('invalid_password'); ?></span>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Katalaluan Baru: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-12 col-xs-12">
                    <?= $form->field($reset_password, 'new_pass2')->label(false)->widget(PasswordInput::classname(), [
                        'pluginOptions' => [
                            'showMeter' => true,
                            'toggleMask' => false
                        ],
                        'options' => [
                            'placeholder' => 'Tulis semula katalaluan',
                            'autocomplete' => 'off'
                        ]
                    ]); ?>
                </div>
                <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('invalid_password'); ?></span>
            </div>
            </br>
            <div class="form-group text-center">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>