<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
?>


<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Add New Staff</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Staff Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'staff_icno')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($biodata, 'ICNO', 'CONm'),
                        'options' => ['placeholder' => '-- Select Staff --', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Add Staff', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <br>
            <?php
            // Control your pjax options
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['class' => 'text-center kv-align-middle'],
                    ],
                    [
                        'attribute' => 'staff.CONm',
                        'vAlign' => 'middle',
//                        'hAlign' => 'center',
                    ],
                    [
                        'attribute' => 'staff.jawatan.fname',
                        'vAlign' => 'middle',
//                        'hAlign' => 'center',
                    ],
                    [
                        'attribute' => 'staff.department.shortname',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Remove Staff',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a('<i class="fa fa-trash-o"></i>', ['kehadiran/remove-staff', 'id' => $data->id], [
                                        'class' => 'btn btn-danger btn-sm',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to remove this staff from your list?',
                                            'method' => 'post',
                                        ],
                            ]);
                        },
                    ],
                ],
//                'responsiveWrap' => true,
                'hover' => true,
//                'floatHeader' => true,
//                'floatHeaderOptions' => ['scrollingTop' => '50'],
                'pjax' => true,
                'pjaxSettings' => [
                    'neverTimeout' => true,
//                        'beforeGrid' => 'My fancy content before.',
//                        'afterGrid' => 'My fancy content after.',
                ]
            ]);
            ?>




        </div>
    </div>
</div>
