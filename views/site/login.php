<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login Masuk Ke HROnline v4';
$this->params['breadcrumbs'][] = $this->title;
?>



<div>

    <div class="login_wrapper">
        
        <div class="animate form login_form">
            <section class="login_content">
                <?= Html::img('@web/images/LOGO_UMS_hitam2.png', ['alt'=>'some', 'class'=>'thing','width'=>'100px']);?>
                <?= Html::img('@web/images/logo_hronline.png', ['alt'=>'some', 'class'=>'thing','width'=>'200px']);?>
                <?php
                $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'layout' => 'horizontal',
                            'fieldConfig' => [
                                'template' => " <div class=\"form-group form-md-line-input\">{label}\n\n{input}<div class=\"form-control-focus\"> </div>\n{error}\n</div>",
                                'horizontalCssClasses' => [
//                                    'label' => 'col-md-2 control-label',
//                                    'offset' => 'col-sm-offset-4',
                                    'wrapper' => 'col-sm-10',
                                    'error' => 'has-error',
                                    'hint' => 'help-block',
                                ],
                            ],
                ]);
                ?>
                <h1>Log Masuk</h1>
                <div>
                    <!--<input type="text" class="form-control" placeholder="Username" required="" />-->

                    <?=
                    $form->field($model, 'username')->textInput([
                        'maxlength' => true,
                        'class' => 'form-control',
                        'placeholder' => 'Username',
//                        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ])->label(false)
                    ?>
                </div>
                <div>
                    <?=
                    $form->field($model, 'password')->passwordInput([
                        'maxlength' => true,
                        'class' => 'form-control',
                        'placeholder' => 'Password',
//                        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ])->label(false)
                    ?>
                </div>
                <div>
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    <a class="reset_pass" href="#">Lupa Kata Laluan ?</a>
                </div>

                <div class="clearfix"></div>

                <div class="separator">
                    <div>
                        <!--<h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>-->
                        <p>© Jabatan Pendaftar, Universiti Malaysia Sabah <?= date('Y') ?></p>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </section>
        </div>


    </div>
</div>
