<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Log-Masuk ke HROnline v4.0';
?>
<style>
    .field-icon {
        float: right;
        margin-left: -25px;
        margin-right: 10px;
        margin-top: -52px;
        position: relative;
        z-index: 2;
    }
</style>

<div class="row" style="padding: 10px;">
    <div class="col-md-4 col-sm-4 col-xs-12 col-lg-4">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-user"></i>&nbsp;User Login</h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content text-center">
                <?php echo Html::img('@web/images/logo-umsblack-text-png.png', ['alt' => 'some', 'class' => 'thing', 'width' => '150px']); ?>

                <?php echo Html::img('@web/images/logo_hronline.png', ['alt' => 'some', 'class' => 'thing', 'width' => '180px']); ?>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => " <div class=\"form-group form-md-line-input\">{label}\n\n{input}<div class=\"form-control-focus\"> </div>\n{error}\n</div>",
                        'horizontalCssClasses' => [
                            'wrapper' => 'col-sm-10',
                            'error' => 'has-error',
                            'hint' => 'help-block',
                        ],
                    ],
                ]);
                ?>
                <h3>Log Masuk</h3>
                <div class="col-md-12 col-sm-12  form-group has-feedback">
                    <?=
                    $form->field($model, 'username')->textInput([
                        'maxlength' => true,
                        'class' => 'form-control has-feedback-left',
                        'placeholder' => 'Username',
                        //                        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ])->label(false)
                    ?>
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                </div>
                <div class="col-md-12 col-sm-12 form-group has-feedback mx-auto">
                    <?=
                    $form->field($model, 'password')->passwordInput([
                        'maxlength' => true,
                        'id' => 'password-field',
                        'class' => 'form-control has-feedback-left',
                        'placeholder' => 'Password',
                        //                        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ])->label(false)
                    ?>
                    <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password toggle-password">
                    </span>
                </div>
                <!-- <div class="col-md-12 col-sm-12 form-group align-center">
                    <?php //echo $form->field($model, 'userType', ['wrapperOptions' => ['style' => 'display:inline-block']])->inline(true)->radioList([1 => 'UMS Staff', 2 => 'External User'])->label(false); 
                    ?>
                </div> -->

                <div class="col-md-12 col-sm-12 form-group">
                    <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-warning', 'name' => 'reset-button']) ?>
                    <?= Html::submitButton('<span class="fa fa-sign-in"></span>&nbsp;Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    <button type="button" class="btn btn-sm btn-link" data-toggle="modal" data-target="#forgot-password"><i>Forgot password ?</i></button>
                </div>
                <div class="col-md-12 col-sm-12 form-group">

                    <strong>Protected by</strong>&nbsp;
                    <?php echo Html::img('@web/images/digicert.png', ['alt' => 'CERTIFIED BY DIGICERT', 'class' => 'thing', 'width' => '50px']); ?>

                </div>
                <div class="clearfix"></div>

                <div class="separator">


                </div>
                <?php ActiveForm::end(); ?>
                <!--<div>-->


                <div style="font-size: 10px;">
                    <p>© Intelligent Integrated Campus System, Universiti Malaysia Sabah <?= date('Y') ?></p>
                    <p>For university use only and subject to the <a href="https://www.ums.edu.my/v5/en/pdpa/data-protection-notice"><u>Personal Data Protection Act 2010</u></p>
                </div>

                <!--</div>-->
            </div>
        </div>
    </div>

    <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-bullhorn"></i>&nbsp;Announcements</h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= app\widgets\AnnouncementWidget::widget() ?>
            </div>
        </div>
    </div>
</div>


<!--forgot password-->
<div id="forgot-password" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2"><span class="fa fa-lock"></span>&nbsp;Lupa kata laluan / Forgot password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <h4><span class="fa fa-users"></span>&nbsp;<strong>HRONLINE</strong></h4>
                <p>Sila hubungi sambungan berikut bagi mengemaskini kata laluan akaun <i>HRONLINE</i> anda :-</p>
                <ol>
                    <li>Jackly Mosuning - Penolong Pegawai Teknologi Maklumat (1452)</li>
                    <li>Babbra George - Penolong Pegawai Teknologi Maklumat (1044)</li>
                </ol>

                <h4><span class="fa fa-cloud"></span>&nbsp;<strong>Active Directoy (AD)</strong></h4>
                <p>Sila layari laman http://admgr.ums.edu.my/ atau klik <a class="btn btn-primary btn-sm" href="http://admgr.ums.edu.my/" target="_blank">disini</a></p>
                <p>Sebarang pertanyaan, sila hubungi Helpdesk JTMK d talian : <span class="label label-success">613100 / 3888</span> atau <span class="label label-success">0109329234 (Whatsapp Sahaja)</span></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-window-close"></span>&nbsp;Close</button>
            </div>
        </div>
    </div>
</div>
<!--forgot password-->

<?php
$this->registerJs("jQuery('.toggle-password').click(function() {

                    $(this).toggleClass('fa-eye fa-eye-slash');
                    var input = $($(this).attr('toggle'));
                    if (input.attr('type') == 'password') {
                      input.attr('type', 'text');
                    } else {
                      input.attr('type', 'password');
                    }
                  });");
?>