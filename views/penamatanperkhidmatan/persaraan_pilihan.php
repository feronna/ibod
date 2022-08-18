<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\Select2;
use app\models\penamatanperkhidmatan\TblJenispenamatan;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use app\models\penamatanperkhidmatan\RefSebabpendeknotis;
use app\models\penamatanperkhidmatan\TblPermohonan;
use wbraganca\dynamicform\DynamicFormWidget;

echo $this->render('_topmenu');
$form = ActiveForm::begin(['options' => ['id' => 'dynamic-form', 'class' => 'form-horizontal form-label-left']]); 
?>

<div class="row">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>PERMOHONAN PENAMATAN PERKHIDMATAN</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
        <?= $this->render('_jenispermohonan',['model'=>$model1]) ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Terakhir Bekerja<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=  $form->field($model1, 'tarikh_terakhirbekerja')->label(false)->widget(DatePicker::classname(), [
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ],
                'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:
                        var selected = ($(this).val()).substr(3,2)+"/"+($(this).val()).substr(0,2)+"/"+($(this).val()).substr(6,4);
                        var t = new Date($(this).val());
                        var today = new Date();
                        today.setHours(0);
                        today.setMinutes(0);
                        today.setSeconds(0);
                        if (Date.parse(today)+2592000000 > Date.parse(t)) {
                            $("#tempoh").show();
                        } else {
                            $("input[name=radio]").prop("checked",false);
                            $("#tempoh").hide();
                            $("#mohon").hide();
                        }'],
                ]); ?>
            </div>
        </div>
        
        <div style="display:none" class="form-group" id="tempoh">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
            </label>
            <div style="color: red" class="col-md-6 col-sm-6 col-xs-12">
                Anda tidak menepati tempoh notis yang ditetapkan. Sila pilih salah satu antara di bawah <br>
                <?= $form->field($model1, 'pendeknotis')->label(false)->widget(Select2::classname(), [
                'data' => ([0=>'Notis Dengan Membayar Sebulan Gaji', 1=>'Mohon Pemendekan Tempoh Notis']),
                'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                    'onchange' => 'javascript: if($(this).val() === "1"){
                                $("#mohon").show();
                            }else{$("#mohon").hide();}'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                    ]); ?><br>
            </div>
        </div>
        <div style="display:none;" id="mohon" class="row"> 
       <div style="background-color: #F7F7F7" class="x_panel">
        <div class="x_title">
            <h2><strong>Permohonan Pemendekan Tempoh Notis</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Sebab Pemendekan Tempoh Notis<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model1, 'sebabpendeknotis_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefSebabpendeknotis::find()->all(), 'id', 'sebab'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript: if($(this).val() === "5"){
                                $("#lainpendek").show();
                            }else{$("#lainpendek").hide();}'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
            </div>
        </div>
        <div style="display:none" id="lainpendek" class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Lain-lain<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea id="tblpermohonan-sebab" class="form-control" name="TblPermohonan[sebab]" rows="2"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model1, 'file')->fileInput()->label(false); ?>
            </div>
        </div>
        </div></div></div>

        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Baki Kontrak Berkhidmat Dengan Kerajaan<span style="color: red" class="required">*</span> :
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model1, 'baki_kontrak')->label(false)->widget(Select2::classname(), [
                'data' => ([1=>'Ada', 0=>'Tiada']),
                'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                    'onchange' => 'javascript: if($(this).val() === "1"){
                                $("#kontrakpendek").show();
                                $("#button").show();
                            }else{$("#kontrakpendek").hide();$("#button").hide();}'],
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
                        'model' => $model2[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'perkara',
                            'baki'
                        ],
                    ]); ?><div style="display:none" id="kontrakpendek" class="form-group">
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
                            <?php $in=1; foreach ($model2 as $i => $modelAddress): ?>
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Memohon Penamatan Perkhidmatan :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model1, 'sebab')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>
                            
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
        </div></div></div>
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



