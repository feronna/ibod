<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\kemudahan\Reftujuan; 
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\hronline\HubunganKeluarga;
use kartik\date\DatePicker;


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
<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1295,1297,1299,1303], 'vars' => []]); ?>

<?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   <?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
 
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>PERMOHONAN PENGANGKUTAN BARANG-BARANG BAGI KAKITANGAN BERSARA / TAMAT <br> <br>KONTRAK DAN DI ARAH BERPINDAH</strong></h2>
             <ul class="nav navbar-right panel_toolbox">
<!--                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>-->
            <li>  <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p></li>
            </ul>
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
            <div align="justify"><strong>PERINGATAN : Kakitangan digalakkan untuk membawa barang-barang seperti pakaian dan buku sahaja </strong><br>
            </div>
        </div>
    </div>

        
        <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
<!--                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>-->
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                  
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model->kakitangan, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                     
                </div>
            </div>
                
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan dan Gred <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                 <?= $form->field($model->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                 
            </div>
             <div class="form-group">
                 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">J/ F/ P/ I/ B <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
            </div>
            <div class="form-group">
                
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Jawatan <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                <?= $form->field($model->kakitangan->statusLantikan, 'ApmtStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                    
                </div>
              
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Emel <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COEmail')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COOffTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ext  <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                <?= $form->field($model->kakitangan, 'COOffTelNoExtn')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div> 
        </div>
    </div> 
</div> 
</div>
        
<div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> PERMOHONAN PEGAWAI</strong></h2>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div> 
         
    <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=8" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT PERMOHONAN PENGANGKUTAN BARANG-BARANG</center></th>

                <tr>
                        <td valign="4">DARI :<span class="required" style="color:red;">*</span></td>
                        <td colspan="3"> 
                            <?= $form->field($model, 'dest_berlepas')->textInput(['maxlength' => true]) ->label(false);?> 
                        </td>
                        <td valign="4">KE :<span class="required" style="color:red;">*</span></td>
                        <td colspan="3">
                            <?= $form->field($model, 'dest_tiba')->textInput(['maxlength' => true]) ->label(false);?> 
                        </td> 
                </tr>
                 <tr>
                        
                     <td colspan="4"><center>(Nama Bandar)</center><span class="required" style="color:red;"></span></td>
                        <td colspan="4"><center>(Nama Bandar)</center><span class="required" style="color:red;"></span></td>
                </tr>
                
                <tr>
                    <td valign="4">Muat Naik<span class="required" style="color:red;">* :</span></td>
                    <td colspan="6"> 
                            <?= $form->field($model, 'dokumen_sokongan')->fileInput()->label(false);?> </td>
                </tr>
                </thead>
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
                            <?php
                                // necessary for update action.
                                if (! $modelAddress->isNewRecord) {
                                    echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                }
                            ?>
                            <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT TANGGUNGAN DAN KELAYAKAN PENGANGKUTAN</center></th>

                <tr> 
                        <td valign="2">NAMA:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2"> 
                            <?=$form->field($modelAddress,  "[{$i}]icno")->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map($queryKeluarga, 'FamilyId', 'FmyNm'),
                                    'options' => ['placeholder' => 'Nama', 'default' => 0],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ], 
                                 ]); ?> 
                        </td>
 
                
                </tr> 
                <tr>
                         
                        
                        <td valign="2">KELAYAKAN METER PADU:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2"> 
                            <?= $form->field($modelAddress, "[{$i}]meter_padu")->textInput(['maxlength' => true]) ->label(false);?> 
                            
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
                    'min' => 0, // 0 or 1 (default 1)
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
                    <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i>Tambah </button>
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
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                       
                 <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <th scope="col" colspan=12"  style="background-color:white;"><center>JADUAL PENERBANGAN YANG DIRANCANG / DITEMPAH <br> 
                        (S - Sendiri, P - Pasangan, A - Anak)
                                         </center></th>

                  <tr>
                      <th scope="col" colspan=12"  style="background-color:white;"><center>PERLEPASAN</th>
                      
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Destinasi:</th>
                        <td colspan="5">   <?= $form->field($modelPenerbangan, "[{$i}]dest_berlepas")->textInput(['maxlength' => 400])->label(false); ?>
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
                                                'startDate'=>date('tarikh_berlepas'),
                                                'minDate'=>'0'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?></td>               
                          <th class="col-md-3 col-sm-3 col-xs-12">Masa:</th>
                          <td> <?= $form->field($modelPenerbangan, "[{$i}]masa_berlepas")->label(false)->widget(\kartik\time\TimePicker::classname(),[
                                            'readonly' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
// 'timeFormat'=> 'HH:mm:ss',                                               
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>  
</td> 
                            </tr>
                            <tr>
                        
                     
                    <tr>
                      <th scope="col" colspan=12"  style="background-color:white;"><center>KETIBAAN</th>
                      
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Destinasi:</th>
                        <td colspan="5">   <?= $form->field($modelPenerbangan, "[{$i}]dest_tiba")->textInput(['maxlength' => 400])->label(false); ?>

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
                                                'startDate'=>date('tarikh_berlepas'), 
                                                'minDate'=>'0'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?></td>  
                    <th class="col-md-3 col-sm-3 col-xs-12">Masa:</th>
                        <td> <?= $form->field($modelPenerbangan, "[{$i}]masa_tiba")->label(false)->widget(\kartik\time\TimePicker::classname(),[
                                            'readonly' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                               
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>  
</td> 
            </tr>          
             <tr>
                      <th scope="col" colspan=12"  style="background-color:white;"></th>
                      
                    </tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Jenis (S/P/A):</th>
                        <td>  <?= $form->field($modelPenerbangan, "[{$i}]idTempahan")->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(app\models\Kemudahan\RefTempahan::find()->all(), 'id', 'jenisTempahan'),  
                                        'options' => ['placeholder' => 'Pilih Jenis Tempahan', 'class' => 'testing form-control col-md-12 col-xs-12',
                                   
                                    ],
                                ])->label(false);
                                    ?>
</td> <th class="col-md-3 col-sm-3 col-xs-12"></th>
                         <td>  <?php
//                        $form->field($modelPenerbangan, "[{$i}]idKelas")->widget(Select2::classname(), [
//                                        'data' => ArrayHelper::map(app\models\Kemudahan\RefPenerbangan::find()->all(), 'id', 'jenisKelas'),  
//                                        'options' => ['placeholder' => 'Pilih Jenis Kelas', 'class' => 'testing form-control col-md-12 col-xs-12',
//                                   
//                                    ],
//                                ])->label(false);
                                    ?>
</td>
                    </tr>
                     
                 
                </table>
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
        
        
        <!--           view dyanamic end here--> 

        
                
            </div>   
        </div>
        </div> 
      
            
            <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> PENGAKUAN PEGAWAI</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div> 
        <div class="x_content">
         <table>
             <tr>
            <td class="col-sm-3 text-right">
                  <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>
            </td>

            <td> 
                    <h5 style="color:black;" >Saya mengesahkan bahawa segala maklumat yang diberikan di atas adalah benar<br/> </h5>


                    
            </td>
        </tr>
    </table>
            
        
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
                    <br>
                    <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['id'=> 'submitb', 'disabled'=> true,'class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
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