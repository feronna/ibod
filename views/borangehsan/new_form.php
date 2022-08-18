<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\kemudahan\Reftujuan; 
use wbraganca\dynamicform\DynamicFormWidget;
//use app\models\hronline\HubunganKeluarga;
//use kartik\depdrop\DepDrop;
//use yii\helpers\Url;
use yii\widgets\ActiveForm\radioButton;

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

$tujuan = ArrayHelper::map(Reftujuan::find()->all(), 'id', 'tujuan');
error_reporting(0); 
?>
 
<?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   
    <div class="x_panel">
    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong> PANDUAN [PEKELILING PERKHIDMATAN BIL.5 TAHUN 1978]</strong></h2> 
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
            <div align="justify">o&nbsp;Permohonan hendaklah <strong>diajukan 30 hari </strong>daripada tarikh kemudahan telah digunakan. <br>
            <div align="justify">o Permohonan kakitangan yang berkelayakan dan lengkap sahaja akan dipertimbangkan. Pastikan maklumat peribadi lengkap untuk mengelakkan permohonan ditolak. <br>
            <div align="justify">o Kemudahan ini hanya boleh digunakan sekali sahaja bagi seorang ibu bapa atau ibu bapa mertua, pegawai yang layak diberi  kemudahan ini terhad kepada 4 kali sepanjang perkhidmatan. <br> 
            <div align="justify">o Hanya pegawai yang bertukar wilayah yang layak menerima kemudahan tambang ehsan, bagi pegawai suami isteri yang bertukar wilayah yang berkhidmat di jabatan yang sama layak dipertimbangkan
                kemudahan ini mengikut kelayakan masing-masing<br> 
            <div align="justify">o &nbsp;Sila sertakan sijil kematian dan resit tiket penerbangan. <br>
                <!--<div align="justify"><strong>o &nbsp;Borang yang lengkap hendaklah dihantar kepada seksyen perkhidmatan, bahagian sumber manusia. <br></strong>-->    
        </div>
    </div>
            </div></div></div></div></div></div>

        <div class="row"> 
        <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> BUTIRAN PERMOHONAN PEGAWAI</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div> 
        <div class="x_content">
            <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-4"> Nama Pegawai :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-10"> 
                <?= $form->field($modelCustomer, 'icno')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\elnpt\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => 'Name'],
                            ])->label(false); 
                    ?>
                 
            </div>
            </div> 
            <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-4"> Permohonan Kali :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-10"> 
                <?=
                   $form->field($modelCustomer, 'pohon')->label(false)->widget(Select2::classname(), [
                    'data' => ['PERTAMA (1)' => 'PERTAMA (1)', 
                    'KEDUA (2)' => 'KEDUA (2)',
                    'KETIGA (3)' => 'KETIGA (3)',
                    'KEEMPAT (4)' => 'KEEMPAT (4)',   
                 ],
                    'options' => [
                            'placeholder' => 'Sila Pilih'], 
                ]); 
                   ?>    
                 
            </div>
            </div> 
        <div class="table-responsive">
                   <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;" width ="100%">
                       <thead>
                            <tr class="headings" >
                                
                                <th class="text-left" width ="60%">PERMOHONAN PEGAWAI ( Sila tanda √ di ruangan yang berkaitan )</th>
                                 
                            </tr>
                        </thead> 
                            <tr class="headings">
                                
                                <td class="text-left" > 
                                <?= $form->field($modelCustomer, 'tujuan')
                 ->radioList(['1' => 'Diri sendiri ke ibu negeri wilayah asal *ibu/ bapa/ibu mertua/ bapa mertua yang *sakit tenat/ meninggal dunia', 
                     '2' => 'Isteri/ suami/ anak ke ibu negeri wialayah asal/ bagi menziarahi *ibu/ bapa/ ibu mertua/ bapa mertua yang *sakit tenat/ meninggal dunia',  
                     '3' => 'Anak dari ibu negeri wilayah asal untuk melawat saya sakit tenat (Hanya layak bagi anak pegawai yang tidak pernah menggunakan kemudahan tambang kapal terbang ketika Pegawai bertukar wilayah)'])
                           ->label(false);?>
                                </td>
                                 
                           
                            </tr>
                             
                    </table> 
            </div> 
            <table class="table table-sm table-bordered" >
        <thead>
                <tr>
                    <td valign="4">Resit Tiket<span class="required" style="color:red;">* :</span></td>
                    <td colspan="4"> <?= $form->field($model, 'dokumen_sokongan')->fileInput()->label(false);?> </td>
                    <td valign="4">Sijil Kematian<span class="required" style="color:red;">* :</span></td>
                    <td colspan="4"> <?= $form->field($model, 'dokumen_sokongan2')->fileInput()->label(false);?> </td> 
                </tr>
        </thead>
             </table>  
             
        <div class="customer-form"> 
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
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
                    <i class="fa fa-plus-circle"></i> Tambang Untuk Seorang Ahli Keluarga ( jika pengguna tambang adalah selain pegawai) 
                    <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i>Tambah </button>   
                     <?php // Html::a('<i class="glyphicon glyphicon-plus"></i> <span class="btn-label">Tambah</span>', ['borangehsan/form-family',  'id' => $model->id ], ['class' => 'btn btn-success btn-sm pull-right']) ?> 
                </h4>
            </div>
            <div class="panel-body">
                <div class="container-items"><!-- widgetBody -->
                <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                    <div class="item panel panel-default"><!-- widgetItem -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Address</h3>
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
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT TAMBANG AHLI KELUARGA</center></th>

                <tr>
                        <td valign="2">NAMA:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2">
                            <div class="col-md-12 col-sm-12 col-xs-10"> 
                             <?php
//                            $form->field($modelAddress,  "[{$i}]nama")->label(false)->widget(Select2::classname(), [
//                                    'data' => ArrayHelper::map($family, 'FmyNm', 'FmyNm'),
//                                    'options' => ['placeholder' => 'Sila pilih nama', 'default' => 1],
//                                    'pluginOptions' => [
//                                        'allowClear' => true
//                                    ], 
//                             ]); 
                            ?>  
                             <?= $form->field($modelAddress, "[{$i}]nama")->textInput(['maxlength' => true]) ->label(false);?> 
                            </div>
                        </td>
                        
                        <td valign="2">ICNO:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2"> 
                            <?php
//                             $form->field($modelAddress,  "[{$i}]icno")->label(false)->widget(Select2::classname(), [
//                                    'data' => ArrayHelper::map($family, 'FamilyId', 'FamilyId'),
//                                    'options' => ['placeholder' => 'Sila pilih icno', 'default' => 0],
//                                    'pluginOptions' => [
//                                        'allowClear' => true
//                                    ], 
//                                 ]); 
                             ?> 
                            <?= $form->field($modelAddress, "[{$i}]icno")->textInput(['maxlength' => true]) ->label(false);?> 
                        </td>
 
                
                </tr> 
                <tr>
                        <td valign="2">HUBUNGAN:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2">
                            <div class="col-md-12 col-sm-12 col-xs-10"> 
                                 
                                <?php
//                            $form->field($modelAddress,  "[{$i}]hubungan")->widget(Select2::classname(), [
//                                'data' => ArrayHelper::map($queryKeluarga, hubKeluarga, hubKeluarga),
//                                'options' => ['placeholder' => 'Pilih'],
//                                'pluginOptions' => [
//                                    'allowClear' => true
//                                ],
//                            ])->label(false);
                            ?>  
                            <?= $form->field($modelAddress, "[{$i}]hubungan")->textInput(['maxlength' => true]) ->label(false);?> 
                            </div>
                        </td>
                        
                        <td valign="2">TARIKH LAHIR:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2"> 
                            <?php // $form->field($modelAddress, "[{$i}]tarikh_lahir")->textInput(['maxlength' => true]) ->label(false);?> 
                            <?= $form->field($modelAddress, "[{$i}]tarikh_lahir")->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
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
        <!--           view dyanamic end here-->   
            </div>   
        </div>
            <div style="color: green; margin-top: 0px;">
            Pemohon perlu memuat naik dokumen sokongan : Sila sertakan sijil kematian dan resit tiket penerbangan.<p>
            <strong>  Sila pastikan maklumat tuntutan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.</strong>
        </div> 
     
        <?php ActiveForm::end(); ?>
        </div>
        
        
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong>  Status Kelulusan Ketua BSM</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
            </ul>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?= $form->field($model, 'ver_date')->hiddenInput()->label(false)?>
            <div class="col-md-10 col-sm-10 col-xs-12">
                
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua BSM : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">    
               <?= $form->field($model, 'pelulus_by')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\elnpt\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => 'Name'],
                            ])->label(false); 
                    ?>
                </div>
            </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Diluluskan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'app_date')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kelulusan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">    
                <?= $form->field($model, 'status_kj')->label(false)->widget(Select2::classname(), [
                    'data' => [
                        
                        'DILULUSKAN' => 'DILULUSKAN', 
//                        'TIDAK DILULUSKAN' => 'TIDAK DILULUSKAN',
                        ],
                   'options' => [
                         'placeholder' => 'Sila Pilih'],

                ]); ?>
                </div>
            </div> 
             
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'catatan_kj')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>   
                </div>
            </div>
             
                
        <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?> 
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
 