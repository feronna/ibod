<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\date\DatePicker;
use app\models\hronline\Negeri;

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


error_reporting(0); 
?> 
   
<?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   <?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
  
    <div class="x_panel">
    <div class="row"> 
   
          
<div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> PENGISIAN PERMOHONAN WILAYAH ASAL</strong></h2>
 
            <div class="clearfix"></div>
        </div> 
        
    <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan="8" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT TAMBANG MENGUNJUNGI WILAYAH ASAL</center></th>
                
                
                <tr>
                        <td valign="4">Nama Pegawai :<span class="required" style="color:red;">*</span></td>
                        <td colspan="3"> 
                           <?= $form->field($model, 'icno')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\elnpt\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => 'Name'],
                            ])->label(false); 
                    ?>
                      
                        </td>
                        <td valign="4">Wilayah Asal :<span class="required" style="color:red;">*</span></td>
                        <td colspan="3">
                      
                             <?=
                            $form->field($model, 'wilayah_asal')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(app\models\hronline\Negeri::find()->all(), 'State', 'State'),
                                'options' => [
                                    'placeholder' => 'Wilayah Asal',
                                ],
                            ])->label(false);
                            ?>

                        </td> 
                </tr>
                
                 <tr>
                        <td valign="4">Tarikh Terakhir Digunakan :<span class="required" style="color:red;"></span></td>
                        <td colspan="3"> 
                            <?= $form->field($model, 'tarikh_terakhir')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true, 
                                                'format' => 'yyyy-mm-dd',  
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'  ],
                                            ]); ?>
                      
                        </td>
                        <td valign="4">Tarikh Kemudahan Akan Digunakan :<span class="required" style="color:red;">*</span></td>
                        <td colspan="3">
                      
                            <?= $form->field($model, 'tarikh_digunakan')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true, 
                                                'format' => 'yyyy-mm-dd', 
                                                'startDate' => date('tarikh_digunakan'),
                                                'minDate'=>'0'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'  ],
                                            ]); ?>

                        </td> 
                </tr>
                <tr>
 
                    <td valign="4">Cuti Rehat :<span class="required" style="color:red;">*</span></td>
                    <td colspan="7"> <?= $form->field($model, 'dokumen_sokongan2')->fileInput()->label(false);?> </td>
                     
                    
                </tr> 
                </thead>
                 <tr class="headings">
                                
                     <td valign="4">Tujuan :<span class="required" style="color:red;">*</span></td>
                     <td colspan="8">
                                <?= $form->field($model, 'tujuan')
                 ->radioList(
                    [
                     'Diri sendiri ke *ibu negeri wilayah asal/bandar utama' => 'Diri sendiri ke *ibu negeri wilayah asal/bandar utama.', 
                     'Diri dan *isteri/suami/anak ke *ibu negeri wilayah asal/bandar utama' => 'Diri dan *isteri/suami/anak ke *ibu negeri wilayah asal/bandar utama.',  
                     'Isteri/suami/anak dari *ibu negeri wilayah asal/bandar utama untuk melawat saya' => '*Isteri/suami/anak dari *ibu negeri wilayah asal/bandar utama untuk melawat saya.'])
                           ->label(false);?>
                                </td>
                                 
                           
                            </tr>
                         </table>
        <div style="color: green; margin-top: 0px;"> 
            <strong>  Sila pastikan maklumat tuntutan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.</strong>
        </div>
    </div>
</div>
        <div class="x_panel">
        <div class="x_title">
            <h2><strong>Maklumat Penumpang</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div> 
        <div class="x_content">
        
        <div class="customer-form"> 
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper1', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items1', // required: css class selector
                    'widgetItem' => '.item1', // required: css class
                    'limit' => 6, // the maximum times, an element can be added (default 999)
                    'min' => 0, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsAddress[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'full_name',
                        'address_line1',
                        'address_line2',
                        'city',
                        'state',
                        'postal_code',
                        'tarikh_lahir',
                    ],
                ]); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-plus-circle"></i> Tambah Penumpang 
                    <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i>Tambah </button>
                </h4>
            </div>
            <div class="panel-body">
                <div class="container-items1"><!-- widgetBody -->
                <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                    <div class="item1 panel panel-default"><!-- widgetItem -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Penumpang</h3>
                            <div class="pull-right">
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <h5 style="color:red">
                                                               * Suami/Isteri  <br/>* Anak berumur 21 tahun ke atas tidak layak mendapat kemudahan ini.</h5>

                            <?php
                                // necessary for update action.
                                if (! $modelAddress->isNewRecord) {
                                    echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                }
                            ?>
                            <table class="table table-sm table-bordered" >
        <thead>
        <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT PASANGAN DAN ANAK<br> JENIS MAKLUMAT: A=Anak S=Suami I=Isteri </center></th>

                <tr>
                         
                        
                        <td valign="2">Nama:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2"> 
                             <?= $form->field($modelAddress, "[{$i}]nama")->textInput(['maxlength' => true]) ->label(false);?> 
                        </td>
 
                
                
                 <td valign="2">ICNO:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2"> 
                          
                            <?= $form->field($modelAddress, "[{$i}]icno")->textInput(['maxlength' => true]) ->label(false);?> 
                        </td>
 
                
                </tr> 
                <tr>
                        <td valign="2">HUBUNGAN:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2">
                            <div class="col-md-12 col-sm-12 col-xs-10"> 
                             
                           
                             <?=$form->field($modelAddress, "[{$i}]hubungan")->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(app\models\hronline\HubunganKeluarga::find()->where(['RelCd' => ['01', '02', '05', '06', '07']])->all(), 'RelNm', 'RelNm'),
                                    'options' => ['placeholder' => 'Hubungan', 'default' => 0],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ], 
                                 ]); ?> 
                            </div>
                        </td>
                        
                        <td valign="2">TARIKH LAHIR:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2"> 
                            <?= $form->field($modelAddress, "[{$i}]tarikh_lahir")->textInput(['maxlength' => true]) ->label(false);?> 
                           <?php
//                            $form->field($modelAddress, "[{$i}]tarikh_lahir")->label(false)->widget(DatePicker::classname(),[
//                                            'readonly' => false,
//                                            'removeButton' => false,
//                                            'pluginOptions' => [
//                                                'autoclose'=>true,
//                                                'format' => 'yyyy-mm-dd'
//                                            ],
//                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
//                                            ]); 
                            ?>
                            
                        </td> 
                </tr>
                  
        </thead>
                          </table> 
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div><!-- .panel -->
        <?php DynamicFormWidget::end(); ?>
        
            </div>   
        </div>
        </div>
        <div class="x_panel">
        <div class="x_title">
            <h2><strong>Maklumat Penerbangan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div> 
        <div class="x_content">
            
        <div class="customer-form"> 
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 6, // the maximum times, an element can be added (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsPenerbangan[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'dest_berlepas'
                    ],
                ]); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-plus-circle"></i> Tambah Maklumat
                    <!--<button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i>Tambah </button>-->
                </h4>
            </div>
            <div class="panel-body">
                <div class="container-items"><!-- widgetBody -->
                <?php foreach ($modelsPenerbangan as $i => $modelPenerbangan): ?>
                    <div class="item panel panel-default"><!-- widgetItem -->
<!--                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Jadual Penerbangan Yang Dirancang</h3>
                            <div class="pull-right">
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>-->
                        <div class="panel-body">
                            <?php
                                // necessary for update action.
                                if (! $modelPenerbangan->isNewRecord) {
                                    echo Html::activeHiddenInput($modelPenerbangan, "[{$i}]id");
                                }
                            ?>
                            <?php // $form->field($modelAddress, "[{$i}]icno")->textInput(['maxlength' => true]) ?>
                          
                            <div class="pull-right">
                                <!--<button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>-->
                            </div>
                            <div class="clearfix"></div>
                       
                 <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <th scope="col" colspan=12"  style="background-color:white;"><center>JADUAL PENERBANGAN YANG DIRANCANG / DITEMPAH <br> 
                        <!--(S - Sendiri, P - Pasangan, A - Anak)-->
                                         </center></th>

                  <tr>
                      <!--<th scope="col" colspan=12"  style="background-color:white;"><center>PERLEPASAN</th>-->
                      
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Destinasi Lapangan Terbang: (From)</th>
                        <td colspan="5">   
                              <?=$form->field($modelPenerbangan, "[{$i}]dest_berlepas")->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(app\models\kemudahan\Refpenerbangan::find()->where(['isActive' => 1])->all(), 'penerbangan', 'penerbangan'),
                                    'options' => ['placeholder' => 'From', 'default' => 0],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ], 
                                 ]); ?> 
                        </td> 
                    </tr>
                    
             
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh:</th>
                        <td><?= $form->field($modelPenerbangan, "[{$i}]tarikh_berlepas")->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd', 
                                                'startDate' => date('tarikh_berlepas'),
                                                'minDate'=>'0'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1' ],
                                            ]); ?></td>               
                          <th class="col-md-3 col-sm-3 col-xs-12">Masa:</th>
                          <td> <?= $form->field($modelPenerbangan, "[{$i}]masa_berlepas")->label(false)->widget(\kartik\time\TimePicker::classname(),[
                                            'readonly' => false,
                                            'pluginOptions' => [
                                                'format' => 'H:m:s',
                                                'autoclose'=>true,
// 'timeFormat'=> 'HH:mm:ss',                                               
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>  
</td> 
                            </tr>
                            <tr>
                        
                     
                    <tr>
                      <!--<th scope="col" colspan=12"  style="background-color:white;"><center>KETIBAAN</th>-->
                      
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Destinasi Lapangan Terbang: (Return)</th>
                        <td colspan="5">    
                       <?=$form->field($modelPenerbangan, "[{$i}]dest_tiba")->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(app\models\kemudahan\Refpenerbangan::find()->where(['isActive' => 1])->all(), 'penerbangan', 'penerbangan'),
                                    'options' => ['placeholder' => 'Return', 'default' => 0],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ], 
                                 ]); ?> 
</td> 
                    </tr>
                  
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh:</th>
                        <td><?= $form->field($modelPenerbangan, "[{$i}]tarikh_tiba")->label(false)->widget(DatePicker::classname(),[
//                                            'readonly' => true,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd', 
                                                'startDate' => date('tarikh_tiba'),
                                                'minDate'=>'0'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?></td>  

                    <th class="col-md-3 col-sm-3 col-xs-12">Masa:</th>
                        <td> <?= $form->field($modelPenerbangan, "[{$i}]masa_tiba")->label(false)->widget(\kartik\time\TimePicker::classname(),[
                                            'readonly' => false,
                                            'pluginOptions' => [
                                                'format' => 'H:m:s',
                                                'autoclose'=>true,
                                               
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>  
</td> 
            </tr>          
              
                </table>
                     <div style="color: green; margin-top: 0px;"> 
            <strong>  Sila pastikan maklumat adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.</strong>
                     </div><br>
                     <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
            <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?> 
            <button class="btn btn-primary" type="reset">Reset</button>
        </div>
        </div>
            </div>
                        </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
            <!-- .panel -->
        <?php DynamicFormWidget::end(); ?>
         
            </div>   
        </div> 
        </div> 
      
            
             
    </div>
</div>    
    
    
</div>
</div>
</div>

 <?php ActiveForm::end(); ?>
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