<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\utilities\epos\JenisKhidmatMel;
use app\models\utilities\epos\PosJenisBarang;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;



$js = '
$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
    
    var datePickers = $(this).find("[data-krajee-kvdatepicker]");
        datePickers.each(function(index, el) {
//            $(this).parent().removeData().kvDatepicker("initDPRemove");
            $(this).parent().kvDatepicker(eval($(this).attr("data-krajee-kvdatepicker")));
        });
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Adakah anda ingin menghapus rekod ini?")) {
        return false;
    }
    return true;
});

';

$this->registerJs($js);
error_reporting(0);

?>
    <div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <h2><strong>
                    <center><?= strtoupper('
     PERMOHONAN PERKHIDMATAN MEL RASMI
 '); ?>
                </center>  </strong>
            </span></h2> 
        </div>
    </div>

<div class="pos-tbl-permohonan-form">

    <?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
        
            <div class="panel panel-success">

                <div class="panel-heading">
        <h6><strong><i class="fa fa-th-list"></i> PERMOHONAN BARU</strong></h6> 
                </div>
              
                <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TUJUAN PENGHANTARAN:</th>
                        <td>              <?=      $form->field($modelmel, 'tujuan_mel')->textarea(['rows' => 4], ['class' => 'form-control col-md-7 col-xs-12',])->label(false);?>
                     
                    </tr>
                   
                   
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">ALAMAT PENGIRIM:</th>
                        <td>            
  <?=
                    $form->field($modelmel, 'alamat_penghantar')->textarea(['rows' => 6], ['class' => 'form-control col-md-7 col-xs-12',])->label(false);
                    ?>
                     
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. TEL PENGIRIM:</th>
                        <td>            
  <?=
                    $form->field($modelmel, 'no_tel')->textInput(['rows' => 4], ['class' => 'form-control col-md-7 col-xs-12',])->label(false);
                    ?>
                     
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">ALAMAT PENERIMA:</th>
                        <td>            
  <?=
                    $form->field($modelmel, 'alamat_penerima')->textarea(['rows' => 6], ['class' => 'form-control col-md-7 col-xs-12',])->label(false);
                    ?>
                     
                    </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JENIS KHIDMAT MEL:</th>
                        <td>            
 <?=
                    $form->field($modelmel, 'jenis_khidmat_mel')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(JenisKhidmatMel::find()->all(), 'id', 'jenis'),
                        'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                     
                    </tr>

                     
                </table>
            </div>
            </div>
        </div>
    
    
  
        <div class="x_content ">
            
            <div class="customer-form">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 2, // the maximum times, an element can be added (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsBarang[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'nama_barang',
                        'penerangan_barang',
                        'jenis_barang',
                        'kuantiti',                     
                    ],
                ]); ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            <i class="fa fa-plus"> <b>Tambah Barang</b></i>
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Barang: <span class="required" style="color:red;">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?= $form->field($modelsBarang, "[{$i}]nama_barang")->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Penerangan Barang: <span class="required" style="color:red;">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?=
                                                $form->field($modelsBarang, "[{$i}]penerangan_barang")->textarea(['rows' => 4], ['class' => 'form-control col-md-7 col-xs-12',])->label(false);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Barang: <span class="required" style="color:red;">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?=
                                                $form->field($modelsBarang, "[{$i}]jenis_barang")->label(false)->widget(Select2::classname(), [
                                                    'data' => ArrayHelper::map(PosJenisBarang::find()->all(), 'id', 'jenis_barang'),
                                                    'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12'],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kuantiti: <span class="required" style="color:red;">*</span>
                                            </label>
                                            <div class="col-md-2 col-sm-2 col-xs-6">
       <?= $form->field($modelsBarang, "[{$i}]kuantiti")->textInput(['maxlength' => true,'type'=>"number"], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
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
            </div>
               
        </div>
    </div>
    
    <div class="form-group text-center">
        <?= Html::submitButton('Mohon', ['class' => 'btn btn-success']) ?>
                           <?= \yii\helpers\Html::a('Kembali', ['senarai-permohonan'], ['class' => 'btn btn-primary']) ?>

    </div>

 

    <?php ActiveForm::end(); ?>

</div>