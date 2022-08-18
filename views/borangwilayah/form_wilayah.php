<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
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
<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->

<!--<script type ="text/javascript">
   function cal() {
   // Parse the entries
   var startDate = new Date(document.getElementById("tarikh_berlepas").value);
   var endDate = new Date(document.getElementById("tarikh_tiba").value); 
   var usedDate = new Date(document.getElementById("tarikh_digunakan").value);
   // Check the date range, 86400000 is the number of milliseconds in one day
   var difference = (endDate - startDate) / (86400000 * 7);
   var diff2 = (endDate - startDate) / (17280000 * 7);  
   if (difference < 0 ) {  
       alert("Harap Maaf! Tarikh ketibaan anda tidak sah.");
       return false;
   }
   if(diff2 > 1){
       alert("Harap Maaf! Tarikh ketibaan anda tidak sah.");
       return false;
   }
   if(same === 1){
       alert("Harap Maaf! Tarikh kemudahan digunakan tidak sama dengan Tarikh berlepas anda.");
   }
    
   return true;
}
</script>-->
  
<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1295,1297,1299,1303,1410,1470], 'vars' => []]); ?>

<?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   <?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
 
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
    <div class="row"> 
   
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> PERMOHONAN TAMBANG MENGUNJUNGI WILAYAH ASAL</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>     
        </div>
 
        <div class="col-md-12 col-xs-12">
        <div class="x_panel">
        <div class="x_title">
            <h2><strong> PANDUAN DAN SILA AMBIL MAKLUM</strong></h2>
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
       
                <div class="col-md-12 col-sm-12 col-xs-2">
                    <div align="justify"> 
                     <!--<div class="col-md-10 col-sm-10 col-xs-12">-->
                I.  Permohonan hendaklah dikemukakan 30 hari bekerja daripada tarikh cadangan kemudahan hendak digunakan. Tarikh tutup permohonan Kemudahan Mengunjungi 
                Wilayah Asal pada tahun 2022 adalah pada <strong> 1 JUN 2022.</strong><br> 
                II.   Kakitangan lantikan tetap sahaja yang layak menggunakan kemudahan ini.</strong><br>  
                III. <strong>Sila pastikan Tarikh dan Masa adalah betul bagi memudahkan proses pembelian tiket melalui tempahan secara atas talian, sebarang perubahan tarikh dan 
                masa selepas tiket di keluarkan adalah tanggungan pemohon sendiri.</strong><br> 
                IV. Permohonan kakitangan yang berkelayakan dan <strong> LENGKAP </strong> sahaja akan dipertimbangkan.<strong> PASTIKAN MAKLUMAT PERIBADI, PASANGAN & TANGGUNGAN 
                   DIKEMASKINI </strong>untuk mengelakkan permohonan ditolak.<br> 
                   V. Kemudahan ini hanya boleh digunakan sekali dalam tempoh satu (1) tahun perkhidmatan secara berterusan dan lupus sekiranya tidak digunakan.<br>
                VI.Hanya harga tambang termurah sahaja yang ditanggung oleh UMS (tidak termasuk cukai lapangan terbang, denda, bayaran tambahan, insurans, surcaj bahan api, 
                   bayaran lebihan bagasi, cukai perkhidmatan atau lain-lain bayaran yang dikenakan). <br> 
                VII.Pasangan bererti suami atau isteri atau para isteri. Anak berumur 21 tahun ke atas tidak layak mendapat kemudahan ini.<br> 
                VIII.Bagi Pemohon yang mempunyai lebih daripada satu (1) isteri hendaklah mendapat perakuan berpoligami daripada Ketua Jabatan.<br>  
                IX. Penerbangan secara berasingan tidak dibenarkan.<br>  
                X. Jika kemudahan digunakan sendiri, sila lampirkan salinan kelulusan Permohonan Cuti Rehat.<br>    
                XI.Berdasarkan Pekeliling Perkhidmatan Bil. 22/2008 dan Surat Pekeliling Bendahari Bil. 1/2020.</strong><br>    
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12"> 
                </div></div>
                   
        
        </div></div>
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
                 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">J/ A/ F/ P/ I/ B <span class="required"></span>
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
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon Bimbit <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COHPhoneNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                    
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. UC<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COOUCTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
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
                <th scope="col" colspan=8" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT TAMBANG MENGUNJUNGI WILAYAH ASAL</center></th>

                <tr>
                        <td valign="4">Wilayah Asal :<span class="required" style="color:red;"></span></td>
                        <td colspan="3"> 
                        <?= $form->field($model->kakitangan, 'displayTempatLahir')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
    
                        <?php // $form->field($model, 'wilayah_asal')->textInput(['maxlength' => true]) ->label(false); ?>
                        </td>
                        
                        <td valign="4">Kampus Cawangan :<span class="required" style="color:red;"></span></td>
                        <td colspan="3"> 
                        <?= $form->field($model->kakitangan->kampus, 'campus_name')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                          
                        <?php // $form->field($model, 'wilayah_asal')->textInput(['maxlength' => true]) ->label(false); ?>
                        </td>
                         
                            
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
                            <?php
//                            if($mod->status_semasa == 1 ){ 
//                                echo  '<input type="text" class="form-control"value="'.$mod->lastdt.' " disabled="disabled">' ;
//                           
//                            }else{
//                                 echo '<input type="text" class="form-control" value="" disabled="disabled">' ;
//                            
//                            }
//                            ?>   
                      
                        </td>
                        <td valign="4">Tarikh Kemudahan Akan Digunakan :<span class="required" style="color:red;">*</span></td>
                        <td colspan="3">
                      
                            <?=
                            $form->field($model, 'tarikh_digunakan')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true, 
                                                'format' => 'yyyy-mm-dd', 
                                                'startDate' => date('tarikh_digunakan'),
                                                'minDate'=>'0'
                                            ],
                                            'options' => [ 'placeholder' => '', 'onchange' => 'cal()', 'id' => 'tarikh_digunakan', 'onchange' => 'javascript:
                                        var selected = ($(this).val()).substr(3,2)+"/"+($(this).val()).substr(0,2)+"/"+($(this).val()).substr(6,4);
                                        var t = new Date($(this).val());
                                        var today = new Date();
                                        today.setHours(0);
                                        today.setMinutes(0);
                                        today.setSeconds(0);
                                        if (Date.parse(today)+2592000000 > Date.parse(t)) {
                                            alert("Permohonan hendaklah dikemukakan 30 hari bekerja daripada tarikh cadangan kemudahan hendak digunakan.");
                                            $(this).val() = NULL;
                                        }
                //                         else {
                //                           alert("");
                //                        }' ]])->label(false);?> 

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
                    'limit' => 10, // the maximum times, an element can be added (default 999)
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
                    <i class="fa fa-plus-circle"></i> Tambah Penumpang (Bagi yang memilih kadar keluarga)

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
                                       * Suami/Isteri  <br/>* Anak-anak berusia 21 tahun ke bawah (Anak-anak berusia 21 tahun ke atas tidak layak menggunakan kemudahan ini).</h5>

                            <?php
                                // necessary for update action.
                                if (! $modelAddress->isNewRecord) {
                                    echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                }
                            ?>
                            <table class="table table-sm table-bordered" >
        <thead>
        <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT PASANGAN DAN ANAK </center></th>

                <tr>
                         
                        
                        <td valign="2">Nama:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2">  
                            <?=
                            $form->field($modelAddress,  "[{$i}]icno")->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map($queryKeluarga, 'FamilyId', 'FmyNm'),
                                    'options' => ['placeholder' => 'Nama', 'default' => 0],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ], 
                                 ]);
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
                        <td colspan="5">   <?php // $form->field($modelPenerbangan, "[{$i}]dest_berlepas")->textInput(['maxlength' => 400])->label(false); ?>
                              <?=$form->field($modelPenerbangan, "[{$i}]dest_berlepas")->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map($depart, 'penerbangan', 'penerbangan'),
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
                        <td colspan="5">   <?php // $form->field($modelPenerbangan, "[{$i}]dest_tiba")->textInput(['maxlength' => 400])->label(false); ?>
                       <?=$form->field($modelPenerbangan, "[{$i}]dest_tiba")->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map($depart, 'penerbangan', 'penerbangan'),
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
            <td class="col-sm-1 text-right">
                  <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>
            </td>

            <td> 
<!--                <h5 style="color:black;" >Saya mengesahkan bahawa segala maklumat yang diberikan dalam permohonan ini adalah benar dan betul.
                    Saya juga memberi kebenaran untuk membuat potongan tambahan terhadap gaji saya bagi membuat bayaran penuh jumlah bayaran tambahan yang tidak ditanggung oleh UMS berdasarkan peraturan yang sedang berkuatkuasa.<br/> </h5>-->
          <h5 style="color:black;" >Saya mengesahkan bahawa segala maklumat yang diberikan dalam permohonan ini adalah benar dan betul.
                   Urusan pembelian tiket Mengunjungi Wilayah Asal saya adalah berdasarkan peraturan yang sedang berkuatkuasa.<br/> </h5>
 
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
 