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
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   <?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <p align="right"><?= Html::a('Kembali', ['cutibelajar/senarai-borang'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
    
      <div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN TEMPAHAN TIKET PENERBANGAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
<div class="x_panel">
        <div class="x_title">
            <h4><strong> PANDUAN PERMOHONAN</strong></h4>
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
            <div align="justify"><strong>o PERMOHONAN HENDAKLAH DIKEMUKAKAN SEKURANG – KURANGNYA <u>14 HARI</u> SEBELUM PENERBANGAN DIJADUALKAN DENGAN MELAMPIRKAN BERSAMA SURAT KELULUSAN. </strong><br></div>
            <div align="justify"><strong>o PERMOHONAN INI HANYA UNTUK PEMOHON YANG MELANJUTKAN PENGAJIAN LUAR DARI NEGERI SABAH. </strong><br> </div>
            <div align="justify"><strong>o HANYA  PERMOHONAN YANG LENGKAP SAHAJA AKAN DIPROSES.</strong><br> </div>

        </div>
</div>

<div class="x_panel">
            <div class="x_title">
                <h2><strong>Jenis Permohonan</strong></h2> 
                <div class="clearfix"></div>
            </div>
                
                <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Permohonan Tiket :<span class="required"></span>
                </label>

                 <div class="col-md-6 col-sm-6 col-xs-12">
                     
                        <?=
                        $form->field($model, 'idBorang')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\app\models\cbelajar\PermohonanTiket::find()->all(), 'idBorang', 'jenisPermohonan'),
                            'options' => 
                                        ['placeholder' => 'Pilih Jenis Permohonan Tiket', 'class' => 'form-control col-md-7 col-xs-12',
                                         

                                        ],
                                        'pluginOptions' => [
                                        'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
</div>
        </div>        
       <div class="x_panel">
        <div class="x_title">
            <h2><strong>Maklumat Pemohon</strong></h2> 
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama:</th>
                        <td><?= $model->kakitangan->displayGelaran . ' ' . ucwords(strtolower($model->kakitangan->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Pekerja:</th>
                        <td><?= $model->kakitangan->COOldID; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jabatan / Seksyen:</th>
                        <td><?= $model->kakitangan->department->fullname; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?= $model->kakitangan->jawatan->nama; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Gred:</th>
                        <td><?= $model->kakitangan->jawatan->gred; ?></td> 
                    </tr>
                    
                    

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Taraf Jawatan:</th>
                        <td><?= $model->kakitangan->statusLantikan->ApmtStatusNm ?></td> 
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Telefon:</th>
                        <td><?= $model->kakitangan->COHPhoneNo; ?></td> 
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Emel:</th>
                        <td><?= $model->kakitangan->COEmail; ?></td> 
                    </tr>
                     
                </table>
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
                    'limit' => 4, // the maximum times, an element can be added (default 999)
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
                            <h3 class="panel-title pull-left">Penumpang</h3><br/>

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
                            <?php // $form->field($modelAddress, "[{$i}]icno")->textInput(['maxlength' => true]) ?>
                             <div class="col-sm-6">
                                                             <h5 style="color:red">
                                                               * Suami/Isteri  <br/>* Terhad untuk <b>tiga (3) orang anak sahaja</b> yang tidak melebihi umur 13 tahun.</h5>

                                    <?php // $form->field($modelAddress, "[{$i}]hubungan")->textInput(['maxlength' => true]) ?>
                                   <?= $form->field($modelAddress,  "[{$i}]jp_icno")->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map($queryKeluarga, 'FamilyId', 'FmyNm'),                                   
                                    'options' => ['placeholder' => 'Pilih Nama Penumpang'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                    ])->label(false);
                                ?>

                                </div><!-- .row -->
<!--                            <div class="row">
                                <div class="col-sm-4">
                                    <?php // $form->field($modelAddress, "[{$i}]umur")->textInput(['maxlength' => true]) ?>
                                </div>

                            </div> .row -->
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
                    'limit' => 12, // the maximum times, an element can be added (default 999)
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
                                     <th scope="col" colspan=12"  style="background-color:white;"><center>JADUAL PENERBANGAN YANG DIRANCANG / DITEMPAH
                                         <</center></th>

                  <tr>
                      <th scope="col" colspan=12"  style="background-color:lightblue;"><center>PERLEPASAN</th>
                      
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
                                                'format' => 'yyyy-mm-dd'
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
                      <th scope="col" colspan=12"  style="background-color:lightblue;"><center>KETIBAAN</th>
                      
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
                                                'format' => 'yyyy-mm-dd'
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
<!--                      <th scope="col" colspan=12"  style="background-color:white;"></th>-->
                      
                    </tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Kategori (S/P/A):</th>
                    <td colspan="5">  <?= $form->field($modelPenerbangan, "[{$i}]idTempahan")->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(app\models\cbelajar\RefTempahan::find()->all(), 'id', 'jenisTempahan'),  
                                        'options' => ['placeholder' => 'Pilih Kategori Tempahan', 'class' => 'testing form-control col-md-12 col-xs-12',
                                   
                                    ],
                                ])->label(false);
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

     
     <div class="row">
         <div class="col-xs-12 col-md-12 col-lg-12"> 

    <div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
        <i><small>Lengkapkan permohonan anda dan pastikan muatnaik lampiran yang sewajarnya</small></i></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>PERMOHONAN  TIKET PENERBANGAN</center></th>

                    
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SALINAN SURAT TAWARAN CUTI BELAJAR/ SURAT KELULUSAN PELANJUTAN TEMPOH CUTI BELAJAR
                       :</th>
                        <td class="text-justify"><?= $form->field($model, 'file2')->fileInput()->label(false);?> </td>
                        

                        
                    </tr> 
               
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SALINAN PASSPORT 
                            [BELAJAR LUAR NEGARA]/NO. KAD PENGENALAN <br><small>(Termasuk Salinan Penumpang)</small>
                            
                            
                            <br>                            
                            <i><small style="color:red">
                                    Bagi memudahkan Bahagian Pentadbiran dalam proses pembelian 
                                    tiket penerbangan anda</small></i>
 :</th>
                        <td class="text-justify"><?= $form->field($model, 'file')->fileInput()->label(false);?> </td>
                        

                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SILA NYATAKAN CADANGAN AIRLINES:<br>
                            <i><small style="color:red">Bagi memudahkan Bahagian Pentadbiran dalam proses pembelian tiket penerbangan anda</small></i>
                       :</th>
                    <td><?= $form->field($model, 'cadangan_airlines')->textArea(['maxlength' => true,'rows' => 6]) ->label(false);?> 
                            
                        </td>
                    </tr>

                    
                    

                     
                </table>
            </div>  </div>  </div>

     </div> </div>
    <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12"> 
    <div class="x_panel">
         <div class="x_title">
             <h5 ><strong><i class="fa fa-check-square"></i> PERAKUAN PEMOHON</strong></h5>
           
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
 <div class="col-sm-12 text-center">
    
    <table>
        <tr>
            <td class="col-sm-3 text-right">
                <?php // $model->agree = 1; ?>
                                <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>

<!--                <br>//<?= $form->field($model, 'agree')->checkbox()->label(false); ?> <p>&nbsp;&nbsp;</p>-->
            </td>

            <td> 
                <div style="width: 800px; height: 90px;border:2px solid red">
             <h5 style="color:black;" >Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi <br/>
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan. </h5>
                    <p style="color:black;">Tarikh Mohon: <?php echo $model->tarikh_mohon;?></p><br/>
                      
            </div>
            </td>
        </tr>
    </table>
     <br/>
  
 </div>
</div>
    </div>
</div>
</div>
        
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
                    <br>
                    <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1'])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
            </div>   
       
      
            <?php ActiveForm::end(); ?>
 


 