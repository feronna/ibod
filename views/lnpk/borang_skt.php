<?php
$js = <<< JS
$("#login-form").on("beforeSubmit",function(e){
    // alert('test');
    $("#buttonBhg1").prop('disabled', true);
    $("#resetBhg1").prop('disabled', true);
    e.preventDefault();
    $("#login-form").css({pointerEvents:'none'});
    return true;
});

JS;
$this->registerJs($js, \yii\web\View::POS_READY);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\elnpt\RefPnpKursus;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">

            <div class="panel-body">
                <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Aktiviti/ Projek/ Keterangan</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($skt, 'skt_aktiviti')->textInput([
                            // 'placeholder' => 'Aktiviti/ Projek/ Keterangan',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kuantiti</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($skt, 'skt_kuantiti')->textInput([
                            // 'placeholder' => 'Kuantiti',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kualiti</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($skt, 'skt_kualiti')->textInput([
                            // 'placeholder' => 'Kualiti',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Masa</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($skt, 'skt_masa')->textInput([
                            // 'placeholder' => 'Masa',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kos</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($skt, 'skt_kos')->textInput([
                            // 'placeholder' => 'Kos',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sasaran Kerja</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($skt, 'skt_sasar')->textInput([
                            'placeholder' => 'Untuk tempoh penilaian',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pencapaian Sebenar</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($skt, 'skt_capai')->textInput([
                            'placeholder' => 'Diisi pada akhir tempoh penilaian',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($skt, 'skt_ulasan_PYD')->textarea([
                            'placeholder' => 'Diisi pada PYD sekiranya berkaitan',
                            'style' => 'resize: none;',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary', 'id' => 'resetBhg1']) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'id' => 'buttonBhg1']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                <?php yii\widgets\Pjax::end() ?>
            </div>
        </div>
    </div>
</div>