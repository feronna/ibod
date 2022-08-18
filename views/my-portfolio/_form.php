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


<div class="row">

<div class="col-md-12">

    <?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>


    <div class="x_panel">
              <p align="right" >
                    <?php echo Html::a('Kembali', ['/my-portfolio/lihat-akauntabiliti', 'id' => $deskripsi->id], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">TAMBAH AKAUNTABILITI</p> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content ">
       
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">AKAUNTABILITI: <span class="required" style="color:red;">*</span>
                </label>
                               
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($modelmel, 'kata_kerja')->textInput(['maxlength' => true, 'rows' => 4, 'placeholder' => 'Kata Kerja (Membuat Sesuatu) Contoh: Menguruskan'])->label(false) ?>     
                
                 <?= $form->field($modelmel, 'object')->textArea(['maxlength' => true, 'rows' => 4, 'placeholder' => 'Objek (Kepada Sesuatu) Contoh: Naziran Perjawatan'])->label(false) ?>  
                 <?= $form->field($modelmel, 'description')->textArea(['maxlength' => true, 'rows' => 4, 'placeholder' => 'Hasil (Untuk Mencapai) Contoh:  bagi memastikan keperluan sumber manusia JFPIB di universiti adalah mencukupi dan tepat'])->label(false) ?> 
              
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
                            <i class="fa ">TAMBAH TUGAS UTAMA</i>
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

    </div>
    
</div>


    <?php ActiveForm::end(); ?>

