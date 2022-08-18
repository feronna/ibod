<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Log-Masuk ke HROnline v4.0';
?> 

<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
    <div class="x_panel"> 
        <div class="x_content text-center"> <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
            <h3>Log Masuk</h3>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"> </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'username')->textInput([
                        'maxlength' => true,
//                        'class' => 'form-control has-feedback-left',
                        'placeholder' => 'Username',
                            //                        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ])->label(false)
                    ?>
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>
            <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12"> </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'password')->passwordInput([
                        'maxlength' => true,
//                        'id' => 'password-field',
//                        'class' => 'form-control has-feedback-left',
                        'placeholder' => 'Password',
                            //                        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ])->label(false)
                    ?>
                    <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span> 
                    </span>
                </div>
            </div> 

            <div class="col-md-12 col-sm-12 form-group">
                <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-warning', 'name' => 'reset-button']) ?>
                <?= Html::submitButton('<span class="fa fa-sign-in"></span>&nbsp;Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
             </div>
               
            <?php ActiveForm::end(); ?> 
        </div>
    </div> 
</div>

 
