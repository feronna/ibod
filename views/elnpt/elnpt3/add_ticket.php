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
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\elnpt\TblPenyelidikan;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\elnpt\elnpt2\RefAspekSkor;
use app\models\elnpt\TblPenyeliaan;
use app\models\elnpt\simulation\RefPeribadiPelajar;
use yii\db\Expression;
use yii\web\JsExpression;

$url = \yii\helpers\Url::to(['name-list']);

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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'category_id')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                1 => 'Bug',
                                2 => 'Feature Request',
                                3 => 'General',
                                4 => 'How To',
                                5 => 'Technical Issue',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Ticket category',
                                'id' => 'category',
                            ],
                            'pluginOptions' => [
                                'dropdownParent' => new JsExpression('$("#modalTicket")'),
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'title')->textInput([
                            'placeholder' => 'Title of the ticket only',
                        ])->label(false);
                        ?>
                        <p><em>* Please describe your requests under the <b>RESPONSES</b> column in the table below once the ticket is submitted.</em></p>
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