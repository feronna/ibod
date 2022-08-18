<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
//use app\models\hronline\Negara;
use dosamigos\datepicker\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
error_reporting(0);
/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left disable-submit-buttons', 'id' => 'dynamic-form']]); ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<?php echo $this->render('/ln/_topmenu'); ?> 
</div>
</div>

<script type="text/javascript">
        function GetDays(){
                var dropdt = new Date(document.getElementById("date_to").value);
                var pickdt = new Date(document.getElementById("date_from").value);
                return parseInt((dropdt - pickdt) / (24 * 3600 * 1000));
        }      
        function cal(){
        if(document.getElementById("date_to")){
            document.getElementById("days").value=GetDays();
        }  
        }
</script>

<script>  
        function addNumber(){
            var a = document.getElementById("tambang").value;
            var b = document.getElementById("elaun_makan").value;
            var c = document.getElementById("elaun_hotel").value;
            var d = document.getElementById("yuran").value;
            var e = document.getElementById("transport").value;
            var f = document.getElementById("dll").value;
            var x = Number(a) + Number(b) + Number(c) + Number(d) + Number(e) + Number(f);;
            return document.getElementById("jumlah").value = " " + x;
        }
         function call() {
             if(document.getElementById("tambang")){
            document.getElementById("jumlah").value=addNumber();
        }
        }
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'right',
            title : "<p><li>Sila muat naik dokumen Kertas Kerja.</li></p>",
            html : true
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip2"]').tooltip({
            placement: 'right',
            title : "<p><li>Sila muat naik dokumen Surat Jemputan.</li></p>",
            html : true
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip3"]').tooltip({
            placement: 'right',
            title : "<p><li>Sila muat naik dokumen sokongan lain jika ada.</li></p>",
            html : true
        });
    });
</script>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<!--    <div class="x_panel">-->
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> PERMOHONAN BERTUGAS RASMI KE LUAR NEGARA </strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?></p>      
            <div class="clearfix"></div>
        </div>
    <div class="col-md-12 col-xs-12">

    <div class="row">    
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. IC</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model->kakitangan, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Pekerja</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan Hakiki</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                    </div>                 
                </div>
                <div class="form-group">                 
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jabatan/Fakulti/Pusat/Institut</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                    </div>               
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan Pentadbiran</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">       
                        <?php if($model->kakitangan->adminpos->adminpos != NULL){?>                   
                        <?= $model->kakitangan->adminpos->adminpos->position_name . " (" . $model->kakitangan->adminpos->dept->fullname . ")"; ?>                    
                        <?php }else{
                        echo "Tidak Berkaitan";
                        }?>     
                    </div>                 
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
        
    <div class="row">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Sejarah Perjalanan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                <tr class="headings">
                    <th class="text-center">Bil.</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Tarikh Perjalanan</th>
                    <th class="text-center">Nama Lawatan</th>
                    <th class="text-center">Tempat</th>
                    <th class="text-center">Kod Peruntukan</th>
                </tr>
               </thead>
                <?php
                if ($ln) { $bil1=1;?>
                    <?php foreach ($ln as $a) { 
                        { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                            <td class="text-center"><?php echo $a->kakitangan->CONm; ?></td>
                            <td class="text-center"><?php echo $a->datefrom; ?> - <?php echo $a->dateto; ?></td>
                            <td class="text-center"><?php echo $a->nama_lawatan; ?></td>
                            <td class="text-center"><?php echo $a->nama_tempat; ?></td>
                            <td class="text-center"><?php echo $a->kod_peruntukan_cn; ?></td>
                        </tr>
                    <?php } }?>
                <?php } else { ?>
                   
                <?php } ?>
                 
            </table>        
        </div>
        </div>
    </div>
    </div>

    <div class="row">    
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Mengenai Lawatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive"> 
            <div class="col-md-10 col-sm-10 col-xs-12"> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Nama Lawatan:<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'nama_lawatan')->textArea(['maxlength' => true, 'placeholder' => 'Nama persidangan/seminar/lawatan rasmi/kursus yang dihadiri']) ->label(false);?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Faedah Lawatan:<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'faedah_lawatan')->textArea(['maxlength' => true, 'placeholder' => 'Faedah lawatan yang dihadiri kepada negara']) ->label(false);?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tujuan:<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'tujuan')->textArea(['maxlength' => true, 'placeholder' => 'Tujuan lawatan yang dihadiri']) ->label(false);?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tempat:<span class="required" style="color:red;">*</span></label>  
                    <div class="col-md-8 col-sm-8 col-xs-10">
                    <?= $form->field($model, 'nama_tempat')->textInput(['maxlength' => true, 'placeholder' => 'Tempat seminar yang dihadiri']) ->label(false);?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Pergi:<span class="required" style="color:red;">*</span></label>  
                    <div class="col-md-3 col-sm-3 col-xs-10"> 
                    <?= $form->field($model, 'date_from')->widget(DatePicker::className(),
                            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'startDate'=>date('date_from'), 'format' => 'yyyy-mm-dd', 'autoclose' => true], 
                            'options' => [ 'placeholder' => 'Pilih tarikh ', 'onchange' => 'cal()', 'id' => 'date_from', 'onchange' => 'javascript:
                        var selected = ($(this).val()).substr(3,2)+"/"+($(this).val()).substr(0,2)+"/"+($(this).val()).substr(6,4);
                        var t = new Date($(this).val());
                        var today = new Date();
                        today.setHours(0);
                        today.setMinutes(0);
                        today.setSeconds(0);
                        if (Date.parse(today)+1209600000 > Date.parse(t)) {
                            alert("Permohonan perjalanan adalah kurang daripada 14 hari, sila pastikan permohonan dibuat dalam 14 hari sebelum tarikh permohonan untuk mengelakkan sebarang masalah. Permohonan lewat dari tempoh tersebut hendaklahlah disertakan dengan alasan/justifikasi yang kukuh.");
                            $(this).val() = NULL;
                        }
//                         else {
//                           alert("");
//                        }' ]])->label(false);?>
                    </div>
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Balik:<span class="required" style="color:red;">*</span></label>   
                    <div class="col-md-3 col-sm-3 col-xs-10"> 
                      <?= $form->field($model, 'date_to')->widget(DatePicker::className(),
                              ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'startDate'=>date('date_to'), 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                              'options' => [ 'placeholder' => 'Pilih tarikh ', 'onchange' => 'cal()', 'id' => 'date_to',  ]])->label(false);?>   
                    </div>
                    <label class="control-label col-md-1 col-sm-1 col-xs-4">Tempoh:</label>
                    <div class="col-md-1 col-sm-1 col-xs-10"> 
                      <?= $form->field($model, 'days')->textInput(['maxlength' => true, 'id' => 'days', 'pattern'=>'[0123456789]+', 'title'=>'Invalid Date!Please enter correct date.']) ->label(false);?>    
                    </div>  
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Justifikasi:<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'justifikasi')->textArea(['maxlength' => true, 'placeholder' => 'Justifikasi/alasan permohonan yang lewat (perjalanan yang kurang 14 hari dari tarikh perjalanan)']) ->label(false);?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Bilangan Peserta:<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'bil_peserta')->textInput(['maxlength' => true, 'placeholder' => 'Bilangan peserta yang hadir (termasuk pemohon)']) ->label(false);?>
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

        <div class="customer-form"> 
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 6, // the maximum times, an element can be added (default 999)
                    'min' => 1, // 0 or 1 (default 1)
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
                    <i class="fa fa-plus-circle"></i> Maklumat Peserta ( termasuk Ketua Rombongan/Diri Sendiri) 
                    <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i>Tambah </button>   
                     <?php // Html::a('<i class="glyphicon glyphicon-plus"></i> <span class="btn-label">Tambah</span>', ['borangehsan/form-family',  'id' => $model->id ], ['class' => 'btn btn-success btn-sm pull-right']) ?> 
                </h4>
            </div>
            <div class="panel-body">
                <div class="container-items"><!-- widgetBody -->
                <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                <div class="item panel panel-default"><!-- widgetItem -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Maklumat Peserta</h3>
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
<!--                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT DAN PERANAN PESERTA</center></th>-->
                <tr>
                    <td valign="2">Nama Peserta:<span class="required" style="color:red;">*</span></td> 
                    <td colspan="2">
                        <div class="col-md-12 col-sm-12 col-xs-10"> 
                        <?=
                        $form->field($modelAddress,  "[{$i}]icno")->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($peserta, 'ICNO', 'CONm', 'jawatan.fname'),
                            'options' => ['placeholder' => 'Sila pilih nama'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ], 
                        ]); 
                        ?>   
                        </div>
                    </td> 
                    
                    <td valign="2">Peranan:<span class="required" style="color:red;">*</span></td> 
                    <td colspan="2"> 
                       <?=
                        $form->field($modelAddress,  "[{$i}]peranan")->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($peranan, 'id', 'peranan'),
                            'options' => ['placeholder' => 'Sila pilih peranan'],
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
        </div>
    </div>
    </div>
        
    <div class="row">    
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Perbelanjaan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;" width ="100%">
                <thead>
                    <tr class="headings" >
                        <td class="text-center" width ="2%"> 
                        <th class="text-left" width ="60%">PERBELANJAAN ( Sila tanda √ di ruangan yang berkaitan )</th>
                        <td width ="10%">  </td>
                    </tr>
                </thead> 
                    <tr class="headings">
                        <td class="text-center"> i) </td>
                        <td class="text-left" >Perbelanjaan ditanggung oleh pihak penganjur</td>
                        <td class="text-center"><br> <?= $form->field($model, 'perbelanjaan')->radio(['label' => '', 'value' => 1, 'uncheck' => null])->label(false)  ?>     </td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> ii) </td>
                        <td class="text-left" >Memerlukan bantuan kewangan dari pihak Universiti</td>
                        <td class="text-center">  <?= $form->field($model, 'perbelanjaan')->radio(['label' => '', 'value' => 2, 'uncheck' => null])->label(false)  ?>   </td>

                    </tr>
                    <tr class="headings">
                        <td class="text-center"> iii) </td>
                        <td class="text-left" >Tidak memerlukan bantuan Universiti/Tanpa biaya</td>                        
                        <td class="text-center"> <?= $form->field($model, 'perbelanjaan')->radio(['label' => '', 'value' => 3, 'uncheck' => null])->label(false) ?>  </td>
                    </tr> 
            </table> 
        </div>
    </div>
    </div>
        
    <div class="row">    
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Jumlah Anggaran Perbelanjaan Yang Diperlukan</strong></h2>
            <h2>&nbsp;(Sila rujuk Pekeliling Perbendaharaan Bil: 3/2003)</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;" width ="100%">
                <thead>
                    <tr class="headings" >
                        <td class="text-center" width ="2%"> 
                        <th class="text-left" width ="60%">PERBELANJAAN ( Sila isi jumlah (RM) di ruangan yang berkaitan )</th>
                        <td width ="7%">RM</td>
                    </tr>
                </thead> 
                    <tr class="headings">
                        <td class="text-center"> i) </td>
                        <td class="text-left" >Tambang pergi-balik </td>
                        <td class="text-center"><?= $form->field($model, 'tambang')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'tambang', 'rows' => 2,  'prefix' => 'RM',])->label(false); ?>
                        </td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> ii) </td>
                        <td class="text-left" >Elaun Makan </td>
                        <td class="text-center"><?= $form->field($model, 'elaun_makan')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'elaun_makan', 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> iii) </td>
                        <td class="text-left" >Elaun Sewa Hotel </td>                        
                        <td class="text-center"><?= $form->field($model, 'elaun_hotel')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'elaun_hotel', 'rows' => 2])->label(false); ?></td>
                    </tr> 
                    <tr class="headings">
                        <td class="text-center"> iv) </td>
                        <td class="text-left" >Yuran Pendaftaran </td>
                        <td class="text-center"><?= $form->field($model, 'yuran')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'yuran', 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> v) </td>
                        <td class="text-left" >Lain-lain: Pengangkutan </td>
                        <td class="text-center"><?= $form->field($model, 'transport')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'transport', 'rows' => 2])->label(false); ?></td>

                    </tr>
                    <tr class="headings">
                        <td class="text-center"> vi) </td>
                        <td class="text-left" >Lain-lain: Pertukaran Wang/Dobi/dll </td>
                        <td class="text-center"><?= $form->field($model, 'dll')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'dll', 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"></td>
                        <td class="text-left" ><strong>Jumlah</strong></td>
                        <td class="text-center"><?= $form->field($model, 'jumlah')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'jumlah','rows' => 2])->label(false); ?></td>
                    </tr>    
            </table> <br><br>
            <div class="table-responsive"> 
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4">Bantuan yang dipohon dari Universiti:<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-4 col-sm-4 col-xs-8"> 
                    <?= $form->field($model, 'kod_peruntukan')->textArea(['maxlength' => true, 'placeholder' => 'Kod peruntukan . Cth: GKP003-SG-2016']) ->label(false);?>
                    </div>
            </div>
            </div>
            </div>
        </div>
    </div>
    </div>
        
    <div class="row">    
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Dokumen Sokongan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="table-responsive">
                <div class="form-group" id="file">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muat Naik Dokumen Kertas Kerja: <span class="required" style="color:red;">*</span></label>
                    <span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>
                    <div class="col-md-3">
                        <?= $form->field($model, 'dokumen_sokongan')->fileInput()->label(false) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <br>
        
        <div class="x_content">
            <div class="table-responsive">
                <div class="form-group" id="file">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muat Naik Dokumen Surat Jemputan: <span class="required" style="color:red;">*</span></label>
                    <span data-toggle="tooltip2" ><i class="fa fa-info-circle fa-lg"></i></span>
                    <div class="col-md-3">
                        <?= $form->field($model, 'dokumen_sokongan2')->fileInput()->label(false) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="x_content">
            <div class="table-responsive">
                <div class="form-group" id="file">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muat Naik Dokumen Sokongan: </label>
                    <span data-toggle="tooltip3" ><i class="fa fa-info-circle fa-lg"></i></span>
                    <div class="col-md-3">
                        <?= $form->field($model, 'dokumen_sokongan3')->fileInput()->label(false) ?>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button class="btn btn-primary" type="reset">Reset</button>
            <?= Html::submitButton('Hantar',['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Please Wait..' , 'confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?' ]]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
        
    </div>   
    </div>
</div>
</div>