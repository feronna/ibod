<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<style>
    textarea {
  resize: none;
  height:100%;
}
</style>
        <?php $form = ActiveForm::begin(['options' => ['id' => 'dynamic-form', 'class' => 'form-horizontal form-label-left']]); 
            $model->scenario = 'bm';?>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan Baru<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'jawatan_baru')->textInput(['required' => true])->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jabatan Baru<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'jabatan_baru')->textInput(['required' => true])->label(false); ?>
            </div>
        </div>
            
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula Lapor Diri<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= DatePicker::widget([
                'name'  => 'tarikhlapordiri',
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'mm-dd-yyyy',
                    'required' => TRUE
                ],
                'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            ],
                ]); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Surat Tawaran Jawatan Baru<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'file')->fileInput(['required' => TRUE])->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Baki Kontrak Berkhidmat Dengan Kerajaan<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= Select2::widget([
                    'name' => 'bakikontrak',
                    'data' => ([1=>'Ada', 0=>'Tiada']),
                    'options' => ['placeholder' => 'Pilih','required'=> TRUE, 'class' => 'form-control col-md-7 col-xs-12',
                        'onchange' => 'javascript: if($(this).val() === "1"){
                                    $("#form").show();
                                    $("#button").show();
                                }else{$("#form").hide();$("#button").hide();}'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
        </div>
        <?php

error_reporting(0);
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
jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});
';

$this->registerJs($js);
?>
        
        <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 20, // the maximum times, an element can be cloned (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsAddress[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'perkara',
                            'baki'
                        ],
                    ]); ?><div style="display:none" id="form" class="form-group">
            <label class="control-label col-md-1 col-sm-1 col-xs-12"> <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
            </label>
        <style>
            .table{
                margin-bottom: 0px;
            }
            .table-responsive{
                margin-bottom: 0px;
            }
        </style>
        <div class="col-md-9 col-sm-9 col-xs-12">
        <div class="container-items"><br>
                                 
                                 <div class="table-responsive">
                         <table class="table table-striped table-sm table-bordered">
                            <thead>
                                <tr style="background-color:#eeeeee;" class="headings">
                                    <th style="width: 8%" class="text-center">Bil</th>
                                    <th style="width: 44%" class="text-center">Program / Penaja</th>
                                    <th style="width: 20%" class="text-center">Tempoh Kontrak</th>
                                    <th style="width: 20%" class="text-center">Tarikh Berkuat Kuasa</th>
                                    <th style="width: 8%" class="text-center"></th>
                                </tr>
                            </thead>
                         </table>
                    </div>
                                 <div class="clearfix"></div>
                            <?php $in=1; foreach ($modelsAddress as $i => $modelAddress): ?>
                                <div class="item"><!-- widgetBody -->
                                        <?php
                                            // necessary for update action.
                                            if (! $modelAddress->isNewRecord) {
                                                echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                            }
                                        ?>
                                    <div class="table-responsive">
                         <table class="table table-striped table-sm jambo_table table-bordered">
                                <tr>
                                    <td style="width: 8%;" class="text-center"><span class="panel-title-address"><?= $in++ ?></span></td>
                                    <td style="width: 44%;" class="text-center"><?= $form->field($modelAddress, "[{$i}]program")->textarea(['maxlength' => true,'required' => true])->label(false) ?></td>
                                    <td style="width: 20%" class="text-center"><?= $form->field($modelAddress, "[{$i}]tempoh_kontrak")->textarea(['maxlength' => true, 'required' => true])->label(false) ?></td>
                                    <td style="width: 20%" class="text-center">
                                        <?= $form->field($modelAddress, "[{$i}]tarikh_kuatkuasa")->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => true,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?></td>
                                    <td style="width: 8%" class="text-center"><button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button></td>
                                </tr>
                         </table>
                    </div>
                                </div>
                            <?php endforeach; ?>
        </div><br><div class="col-md-12 col-sm-12 col-xs-12" style="color: green; margin-top: -15px;">
                 *Program: Hadiah Latihan Persekutuan (HLP), Skim Latihan Akademik Bumiputra (SLAB)/ Skim Latihan Akademik IPTA (SLAI) dan lain-lain.
                    Penaja: JPA, KKM, MOSTI, KPT, NRE dan lain-lain

            </div></div></div>
                            <?php DynamicFormWidget::end(); ?><br>
                            
       <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                Dengan peletakan jawatan ini, saya bertanggungjawab menguruskan segala tanggungan hutang dan ikatan perjanjian saya dengan pihak berkuasa yang berkaitan. 
                <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>Saya Setuju
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['id'=> 'submitb','class' => 'btn btn-primary', 'disabled'=> true,'data'=>['confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Teruskan?']]) ?>
            </div>
        </div>
         <script>
                function checkTerms() {
                  // Get the checkbox
                  var checkBox = document.getElementById("checkbox1");

                  // If the checkbox is checked, display the output text
                  if (checkBox.checked === true){
                    document.getElementById("submitb").disabled = false;
                  } else {
                    document.getElementById("submitb").disabled = true;
                  }
                }
                    </script>
            <?php ActiveForm::end();?>



