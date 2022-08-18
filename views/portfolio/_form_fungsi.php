<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
    
    var datePickers = $(this).find("[data-krajee-kvdatepicker]");
        datePickers.each(function(index, el) {
//            $(this).parent().removeData().kvDatepicker("initDPRemove");
            $(this).parent().kvDatepicker(eval($(this).attr("data-krajee-kvdatepicker")));
        });
});
';

$this->registerJs($js);
error_reporting(0);
?>


<div class="pos-tbl-permohonan-form">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?php echo $this->render('menu_info_tugas'); ?> 
    </div>

    <div class="col-md-3 col-sm-12 col-xs-12"> 
        <?php echo $this->render('menu_services'); ?>   
    </div>
    <?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
    <div class="col-md-9 col-sm-12 col-xs-12">

        <div class="x_panel">
            <div class="x_title">
                <p style="font-size:15px;font-weight: bold;">TAMBAH SENARAI UNIT DAN FUNGSI UNIT DALAM JABATAN</p> 
                <div class="clearfix"></div>
            </div>
            <div class="x_content ">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA SEKSYEN: <span class="required" style="color:red;">*</span>
                    </label>

                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <?=
                        $form->field($modelmel, 'section_id')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\portfolio\RefSection::find()->joinWith('kakitangan')->where(['tblprcobiodata.DeptID' => $test->DeptId])->all(), 'id', 'section_details'),
                            'options' => ['placeholder' => 'Pilih Seksyen ', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA UNIT: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($modelmel, 'unit_details')->textarea(['rows' => 4], ['class' => 'form-control col-md-7 col-xs-12',])->label(false);
                        ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="x_panel">
            <div class="customer-form">
                <?php
                DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 10, // the maximum times, an element can be added (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsBarang[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'description',
                    ],
                ]);
                ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            <i class="fa ">Tambah Fungsi</i>
                            <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i>Tambah </button>
                            <?php // Html::a('<i class="glyphicon glyphicon-plus"></i> <span class="btn-label">Tambah</span>', ['borangehsan/form-family',  'id' => $model->id ], ['class' => 'btn btn-success btn-sm pull-right']) 
                            ?>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="container-items">
                            <!-- widgetBody -->
                            <?php foreach ($modelsBarang as $i => $modelsBarang) : ?>
                                <div class="item panel panel-default">
                                    <!-- widgetItem -->
                                    <div class="panel-heading">
                                        <div class="pull-right">
                                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                        // necessary for update action.
                                        if (!$modelsBarang->isNewRecord) {
                                            echo Html::activeHiddenInput($modelsBarang, "[{$i}]id");
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan: <span class="required" style="color:red;">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?= $form->field($modelsBarang, "[{$i}]description")->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div><!-- .panel -->

            <!--           view dyanamic end here-->


        </div>
        <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">REKOD</p> 
            <div class="clearfix"></div>
        </div> 
        <div class="table-responsive">
            <?=
            GridView::widget([
                'dataProvider' => $record,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//                      [
//                        'class' => 'yii\grid\DataColumn',
//                        'label' => 'NAMA SEKSYEN',
//                        'value' => function ($record) {
//                            return $record->sectionID->section_details ? $record->sectionID->section_details  : ' ';
//                        }, 
//                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'NAMA UNIT',
                        'value' => function ($record) {
                            return $record->unit_details ? $record->unit_details : ' ';
                        },
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'FUNGSI UNIT',
                        'format' => 'raw',
                        'value' => function ($record) {
                            //      return $record->catatan ? $record->catatan : ' ';
                            //   return $record->TugasUtama3($record->id); 
                            return Html::a($record->TugasUtama2($record->id));
                        },
                    ],
                    [

                        'class' => 'yii\grid\DataColumn',
                        'label' => 'TINDAKAN',
                        'value' => function ($record) {
                            return Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['kemaskini-unit', 'id' => $record->id], ['class' => 'btn btn-default'])
                            ;
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'width' => '130px'],
                            ],
                        ],
                    ]);
                    ?> 
        </div> 
    </div> 
    
    <?php ActiveForm::end(); ?>

    
    </div>


</div>




