<?php

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery("input:hidden[name*=jenis_lpg_id]").each(function(index) {
        $(this).val( $( "#jenis-lpg" ).select2("data")[0]["id"] );
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1));
    });
});
';

$this->registerJs($js);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\gaji\RefRocReason;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\gaji\RefElaunName;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\db\Expression;
use kartik\widgets\SwitchInput;

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">

            <div class="panel-body">
                <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['class' => 'form-horizontal form-label-left'], 'enableAjaxValidation' => true]); ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4> LPG</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis LPG</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?=
                                $form->field($model, 'jenis_lpg')->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(RefRocReason::find()
                                        ->all(), 'RR_REASON_CODE', 'RR_REASON_DESC'),
                                    'hideSearch' => false,
                                    'options' => [
                                        'id' => 'jenis-lpg',
                                        'placeholder' => 'Carian ...',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'pluginEvents' => [
                                        "select2:select" => "function() { $( \"input:hidden[name*='jenis_lpg_id']\" ).val($(this).val()); }",
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4> Elaun</h4>
                    </div>
                    <div class="panel-body">
                        <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-items', // required: css class selector
                            'widgetItem' => '.item', // required: css class
                            // 'limit' => 4, // the maximum times, an element can be cloned (default 999)
                            'min' => 1, // 0 or 1 (default 1)
                            'insertButton' => '.add-item', // css class
                            'deleteButton' => '.remove-item', // css class
                            'model' => $modelsElaun[0],
                            'formId' => 'dynamic-form',
                            'formFields' => [
                                'elaun_id',
                                'status',
                            ],
                        ]); ?>

                        <div class="container-items">
                            <!-- widgetContainer -->
                            <?php foreach ($modelsElaun as $i => $modelElaun) : ?>
                                <div class="item panel panel-default">
                                    <!-- widgetBody -->
                                    <div class="panel-heading">
                                        <h3 class="panel-title pull-left">Senarai Elaun</h3>
                                        <div class="pull-right">
                                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                        // necessary for update action.
                                        if (!$modelElaun->isNewRecord) {
                                            echo Html::activeHiddenInput($modelElaun, "[{$i}]id");
                                        }
                                        ?>

                                        <?= Html::activeHiddenInput($modelElaun, "[{$i}]jenis_lpg_id", ['id' => 'jenis_lpg_id']); ?>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Elaun</label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <?=
                                                $form->field($modelElaun, "[{$i}]elaun_id")->label(false)->widget(Select2::classname(), [
                                                    'data' => ArrayHelper::map(RefElaunName::find()
                                                        ->select(new Expression('id, CONCAT(nama_ringkas , \' - \' , nama_penuh) as nama_ringkas'))
                                                        ->all(), 'id', 'nama_ringkas'),
                                                    'hideSearch' => false,
                                                    'pluginLoading' => false,
                                                    'options' => [
                                                        'placeholder' => 'Carian ...',
                                                    ],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ]);
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <?=
                                                $form->field($modelElaun, "[{$i}]status")->widget(SwitchInput::classname(), [
                                                    'pluginOptions' => [
                                                        'onText' => 'Active',
                                                        'offText' => 'Inactive'
                                                    ]
                                                ])->label(false);
                                                ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php DynamicFormWidget::end(); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary', 'id' => 'resetBhg1']) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'id' => 'buttonBhg1']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>