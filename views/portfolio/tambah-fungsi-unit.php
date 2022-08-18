<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\portfolio\RefUnit;
use yii\grid\GridView;

/* @var $this yii\web\View */
 
/* @var $modelCustomer app\modules\yii2extensions\models\Customer */
 
/* @var $modelsAddress app\modules\yii2extensions\models\Address */
 
 
$js = '
 
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
 
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
 
        jQuery(this).html("Address: " + (index + 1))
 
    });
 
});
 
 
jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
 
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
 
        jQuery(this).html("Address: " + (index + 1))
 
    });
 
});
 
';
error_reporting(0);
?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php echo $this->render('menu_info_tugas'); ?> 
</div>

<div class="col-md-3 col-sm-12 col-xs-12"> 
    <?php echo $this->render('menu_services'); ?>   
</div>

<div class="col-md-9 col-sm-12 col-xs-12">
    <div class="x_panel"> 
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">TAMBAH SENARAI UNIT DAN FUNGSI UNIT DALAM JABATAN</p> 
            <div class="clearfix"></div>
                 <div class="x_content">
           
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
          
            
            <div class="person-form">

     <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
                
          
    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.house-item',
        'limit' => 5,
        'min' => 1,
        'insertButton' => '.add-house',
        'deleteButton' => '.remove-house',
        'model' => $modelsHouse[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'description',
        ],
    ]); ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>NAMA UNIT</th>
                <th style="width: 450px;">FUNGSI UNIT</th>
                <th class="text-center" style="width: 90px;">
                    <button type="button" class="add-house btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($modelsHouse as $indexHouse => $modelHouse): ?>
            <tr class="house-item">
      
        
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $modelHouse->isNewRecord) {
                            echo Html::activeHiddenInput($modelHouse, "[{$indexHouse}]id");
                        }
                    ?>
                       <?=
                $form->field($modelHouse, "[{$indexHouse}]section_id")->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\portfolio\RefSection::find()->joinWith('kakitangan')->where(['tblprcobiodata.DeptID' => $test->DeptId])->all(), 'id', 'section_details'),
                    'options' => ['placeholder' => 'Pilih Seksyen ', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                 <?= $form->field($modelHouse, "[{$indexHouse}]unit_details")->textInput(['maxlength' => true, 'rows' => 4, 'placeholder' => 'Nama Unit'])->label(false) ?>     
                </td>
                <td>
                    <?= $this->render('_form-rooms', [
                        'form' => $form,
                        'indexHouse' => $indexHouse,
                        'modelsRoom' => $modelsRoom[$indexHouse],
                    ]) ?>
                </td>
                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-house btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                </td>
            </tr>
            
            
         <?php endforeach; ?>
            
            
            
        </tbody>
        
    </table>
            
                <?php DynamicFormWidget::end(); ?>
               
 
                <div class="form-group">
            
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        
           
        </div>

 <?php ActiveForm::end(); ?>

</div>
         
           
           
         
           

            <!--form-->
        </div>
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
                      [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'NAMA SEKSYEN',
                        'value' => function ($record) {
                            return $record->sectionID->section_details ? $record->sectionID->section_details  : ' ';
                        }, 
                    ],
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
                              return Html::a($record->TugasUtama2($record->id) ) ;
                            
                        }, 
                    ],
                                                     
                    [
                        
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'TINDAKAN',
                        'value' => function ($record) {
                            return  Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['tambah-fungsi', 'id' => $record->id, 'title' => 'tambah-fungsi'], ['class' => 'btn btn-default']) .
                                    ' ' . Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $record->id, 'title' => 'tambah-fungsi'], ['class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => 'Anda yakin ingin padam?',
                                            'method' => 'post',
                                ]]) . ' ' . Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-carta', 'id' => $record->id, 'title' => 'tambah-fungsi-unit'], ['class' => 'btn btn-default']);
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

