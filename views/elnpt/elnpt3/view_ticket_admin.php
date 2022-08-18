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
/* @var $ticket app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="panel-body">
                <?=
                \kartik\detail\DetailView::widget([
                    'model' => $ticket,
                    'attributes' => [
                        [
                            'label' => 'ID BORANG',
                            'value' => $ticket->lpp_id,
                            'labelColOptions' => ['style' => 'width: 20%', 'class' => 'text-center'],
                            // 'valueColOptions' => ['class' => 'text-center'],
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'TITLE',
                            'value' => $ticket->title,
                            'labelColOptions' => ['style' => 'width: 20%', 'class' => 'text-center'],
                            // 'valueColOptions' => ['class' => 'text-center'],
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'CATEGORY',
                            'value' => $ticket->ticketCategory(),
                            'labelColOptions' => ['style' => 'width: 20%', 'class' => 'text-center'],
                            // 'valueColOptions' => ['class' => 'text-center'],
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'CREATED AT',
                            'value' => $ticket->created_at,
                            'labelColOptions' => ['style' => 'width: 20%', 'class' => 'text-center'],
                            // 'valueColOptions' => ['class' => 'text-center'],
                            'format' => 'raw',
                        ],
                    ]
                ])
                ?>

                <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($ticket, 'status')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                0 => 'Open',
                                10 => 'Waiting',
                                100 => 'Close',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                // 'placeholder' => 'Carian ...',
                                'id' => 'status1',
                            ],
                            'pluginOptions' => [
                                'dropdownParent' => new JsExpression('$("#modalttt")'),
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Priority</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($ticket, 'priority')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                0 => 'LOW',
                                10 => 'MIDDLE',
                                100 => 'HIGH',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                // 'placeholder' => 'Carian ...',
                                'id' => 'priority2',
                            ],
                            'pluginOptions' => [
                                'dropdownParent' => new JsExpression('$("#modalttt")'),
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary', 'id' => 'resetBhg1']) ?>
                        <?= Html::submitButton('Update', ['class' => 'btn btn-success', 'id' => 'buttonBhg1']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                <?php yii\widgets\Pjax::end() ?>
            </div>
        </div>
    </div>
</div>