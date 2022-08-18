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
            <p style="font-size:15px;font-weight: bold;">TAMBAH PERINGKAT</p> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content ">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">PILIH PERINGKAT: <span class="required" style="color:red;">*</span>
                </label>
                          
          <div class="col-md-6 col-sm-6 col-xs-12">

                 <?=
                $form->field($modelmel, 'peringkat')->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\portfolio\RefPeringkat::find()->all(), 'id', 'no'),
                    'options' => ['placeholder' => 'Pilih Peringkat ', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                                </div>
            </div>
     
            
            </div>
    </div>
        <div class="x_panel">
            <div class="customer-form">
               <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 5, // the maximum times, an element can be added (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsBarang[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'description',
                          
                        ],
                    ]); ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            <i class="fa ">SENARAI KAKITANGAN</i>
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">PILIH KAKITANGAN : <span class="required" style="color:red;">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <?=
                $form->field($modelsBarang, "[{$i}]icno")->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['DeptID' => $test->DeptId])->andWhere(['Status' => 1])->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Pilih kakitangan ', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                                                                <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">PILIH STRUKTUR : 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                       <?=
                $form->field($modelsBarang, "[{$i}]section_id")->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\portfolio\RefSection::find()->joinWith('kakitangan')->where(['tblprcobiodata.DeptID' => $test->DeptId])->all(), 'id', 'section_details'),
                    'options' => ['placeholder' => 'Pilih Struktur ', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                                                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">PILIH UNIT : 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                       <?=
                $form->field($modelsBarang, "[{$i}]unit_id")->label(false)->  widget(Select2::classname(), [
                     'data' => ArrayHelper::map(app\models\portfolio\RefUnit::find()->where(['jabatan_id' => $test->DeptId])->all(), 'id', 'unit_details'),
                      'options' => ['placeholder' => 'Pilih Struktur ', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                                                
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        </div>
                                      
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div><!-- .panel -->
                <?php DynamicFormWidget::end(); ?>
                <!--           view dyanamic end here-->
          
     <div class="form-group text-center">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>
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
                        'label' => 'PERINGKAT',
                                 'value' => function ($record) {
                            return $record->refPeringkat->no. '-'. $record->refPeringkat->nama ? 'PERINGKAT'. ' ' .$record->refPeringkat->no. ' '.'-'.' '.$record->refPeringkat->nama : ' ';
                        }, 
                      
                    ],
                      [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'NAMA KAKITANGAN',
                        'format' => 'raw',
                                         'value' => function ($record) {
                            return $record->kakitangan->CONm ? $record->kakitangan->CONm  : ' ';
                        }, 
                  
                    ],
                     [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'STRUKTUR',
                        'format' => 'raw',
                                         'value' => function ($record) {
                            if($record->section_id != null){
                            return $record->section->section_details ? $record->section->section_details   : ' ';
                            }else{
                             return $record->unit->unit_details ? $record->unit->unit_details   : ' ';
 
                            }
                        }, 
                  
                    ],
                                                     
                    [
                        
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'TINDAKAN',
                        'value' => function ($record) {
                            return 
                            //Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['kemaskini-unit','id'=>$record->id], ['class' => 'btn btn-default']).
                                 //   ' ' .
                                    Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-peringkat', 'id' => $record->id, 'title' => 'tambah-unit'], ['class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => 'Anda yakin ingin padam?',
                                            'method' => 'post',
                                ]]) ;
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center','width' => '130px'],
                            ],
                        ],
                    ]);
                    ?> 
                </div> 
            </div>
    </div>
    
  </div>


    <?php ActiveForm::end(); ?>

