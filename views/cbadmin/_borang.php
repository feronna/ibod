<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\hronline\MajorMinor; 
use kartik\daterange\DateRangePicker;
use wbraganca\dynamicform\DynamicFormWidget;
//use yii\helpers\Url;
use app\models\hronline\Negara;

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
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
<?php $this->title = 'Borang Online'; ?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<?php //$form = ActiveForm::begin(['id' => 'dynamic-form']); ?>


<div class="x_panel">
    <h2><strong><center>PERMOHONAN BAHARU PENGAJIAN LANJUTAN PENTADBIRAN</center></strong></h2>

</div>

<div class="x_panel">

        <div class="x_content">
        <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                        <th scope="col" colspan=12">
                    <center>MAKLUMAT PERIBADI</center>
</th></thead>
                       
                     
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama:</th>
                        <td colspan="5"><?= $model->kakitangan->displayGelaran . ' ' . ucwords(strtolower($model->kakitangan->CONm)); ?></td>
                        
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JFPIU:</th>
                        <td><?= $model->kakitangan->department->fullname; ?></td>
                        <th class="col-md-3 col-sm-3 col-xs-12 text-left">No. Tel Bimbit: </th>
                        <td><?=  ucwords(strtolower($model->kakitangan->COHPhoneNo)) ?></td>  
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan & Gred:</th>
                        <td><?= $model->kakitangan->jawatan->nama ." (". ($model->kakitangan->jawatan->gred). ")"; ?></td>
                        <th class="col-md-3 col-sm-3 col-xs-12 text-left">Emel: </th>
                        <td><?= ($model->kakitangan->COEmail) ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                        <th class="col-md-3 col-sm-3 col-xs-12 text-left">Umur:</th>
                        <td><?=date("Y") - date("Y", strtotime($model->kakitangan->COBirthDt))." ". "Tahun"?></td> 
                    </tr>
                    
                  
                   <tr>
                           <th class="col-md-2 col-sm-3 col-xs-12">Tarikh Lantikan: </th>
                           <td><?=  ($model->kakitangan->displayStartLantik) ?></td>  
                           <th class="col-md-2 col-sm-3 col-xs-12 text-left">Tarikh Disahkan Dalam Perkhidmatan: </th>
                           <td>
                               <?php if(!empty($model->kakitangan->confirmpengesahan->tarikhmula )):?>
                                    <?php echo $model->kakitangan->confirmpengesahan->tarikhmula ?></a>
                                          
                                            <?php endif;?>
                           </td>
                   </tr>

                     
                </table>
                     <p align="right">  <?= Html::a('Kemaskini Maklumat Peribadi', ['biodata/userview'], ['class' => 'btn btn-success btn-xs', 'target'=>'_blank']) ?> </p>
            </div>   </div>  </div>


<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
            <?php
//                    $akademik = $biodata->akademik;
              if($akademik){ ?>
            <div>

                       <table class="table table-bordered jambo_table">
                    <thead>
                        <th scope="col" colspan=12">
                    <center>MAKLUMAT AKADEMIK</center></th>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="column-title text-center">Tahap Pendidikan </th>
                        <th class="column-title text-center">Bidang</th>
                        <th class="column-title text-center">Universiti / Institusi</th>
                        <th class="column-title text-center">Kelas / CGPA</th>
                        <th class="column-title text-center">Tarikh Dianugerahkan</th>
                        <th class="column-title text-center">Tajaan</th>
                        
                    </tr>
</thead>
                    <tbody>

                    <?php $bil=1; foreach ($akademik as $akademik) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            <td><?= $akademik->tahapPendidikan; ?></td>
                            <td><?= $akademik->namaMajor;?></td>
                            <td><?= $akademik->namainstitut;?></td>
                            <td><?= $akademik->OverallGrade;?></td>
                            <td><?= $akademik->confermentDt;?></td> 
                            <td><?= $akademik->Sponsorship;?></td>

                        </tr>
                    <?php } ?>
                    </tbody>
              
                
                </table>
              <p align="right">  <?= Html::a('Kemaskini Maklumat Akademik', ['pendidikan/view'], ['class' => 'btn btn-success btn-xs', 'target'=>'_blank']) ?> </p>
             </div>
              <?php }?>
    </div>
</div>

</div>
<div class="x_panel">   <div class="x_content">
<div class="table-responsive">

                 <table class="table table-bordered jambo_table">
                    <thead>
                        <th scope="col" colspan=12">
                        <center>MAKLUMAT PENGAJIAN YANG DIPOHON</center></th></thead>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Universiti:</th>
                        <td colspan="2">   <?= $form->field($pengajian, 'InstNm')->textArea(['maxlength' => true]) ->label(false);?> 

                        </td> 
                        <th class="col-md-3 col-sm-3 col-xs-12">Negara:</th>
                        <td colspan="3">
                         <?= $form->field($pengajian, 'CountryCd')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                        'options' => [
                            'placeholder' => 'Pilih Negara'],
                    ])->label(false); ?>
                        </td>
                    </tr>
                    
                    
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Peringkat Pengajian:</th>
                        <td colspan="5">
                        <?php
            echo $form->field($pengajian,'HighestEduLevelCd')->
            dropDownList(['12' => 'Sijil ',
                          '11' => 'Diploma', 
                          '8'=>'Sarjana Muda',
                          '20'=> 'Sarjana',
                          '1' => 'Doktor Falsafah (PhD)'],['prompt'=>'Pilih Peringkat Pengajian'])->label(false);
?>
                        </td>
                        
                 </tr>
                 
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Bidang Pengajian:</th>
                        <td colspan="5">
                      
                             <?=$form->field($pengajian, 'MajorCd')->label(false)->widget(Select2::classname(), [
                 'data' => ArrayHelper::map(MajorMinor::find()->all(),  'MajorMinorCd', 'MajorMinor'),
                 'options' => ['placeholder' => 'Pilih Bidang Pengajian', 'class' => 'form-control col-md-7 col-xs-12',
                 'onchange' => 'javascript:if ($(this).val() == "9999"){
                   $("#lain").show();
                                         }
                                    else{
                                    $("#lain").hide();
                                    }'],
                        
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],
                                ]);


                                ?> 
                        </td>
                        
                 </tr>
                
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Pengajian (Mula - Tamat):</th>
                        <td colspan="5"> <div class="col-sm-10">
            <?php
            echo DateRangePicker::widget([
                'model' => $pengajian,
                'attribute' => 'full_dt',
                //                    'useWithAddon'=>true,
                'convertFormat' => true,
                'startAttribute' => 'tarikh_mula',
                'endAttribute' => 'tarikh_tamat',
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'd/m/Y',
                        'separator' => ' hingga '
                    ],
                    'opens' => 'left',
                ]
            ]);
            ?>

        </div>
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tajuk Tesis Disertasi (secara kasar) dan cadangan program PhD (Sila Kepilkan: </th>
                        <td colspan="2">  <?= $form->field($pengajian, 'tajuk_tesis')->textArea()->label(false); ?> 
 

                        </td> 
                        <th class="col-md-3 col-sm-3 col-xs-12">Lampiran (Jika Ada):</th>
                       
                         <td><br><?= $form->field($pengajian, 'file1')->fileInput()->label(false);?> </td>
                    
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12"> Nama Penyelia (Jika telah diketahui): </th>
                        <td colspan="2" >  <?= $form->field($pengajian, 'nama_penyelia')->textInput()->label(false); ?> </td>
                       <th class="col-md-3 col-sm-3 col-xs-12"> Emel Penyelia: </th>
                       <td>  <?= $form->field($pengajian, 'emel_penyelia')->textInput()->label(false); ?> </td>
                    </tr>
                </table>
            </div>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">     <div class="x_content">
        <div class="x_title">
            <h2><strong>Maklumat Pembiayaan / Pinjaman Yang Dipohon</strong></h2>
           
            <div class="clearfix"></div>
        </div> 
  
            
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
                       'nama_tajaan',
                       'bentukBantuan',
                       'amaunBantuan'
                    ],
                ]); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-plus-circle"></i> Tajaan Luar
                    <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i>Tambah </button>
                </h4>
            </div>
            <div class="panel-body">
                <div class="container-items"><!-- widgetBody -->
                <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                    <div class="item panel panel-default"><!-- widgetItem -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Tajaan Luar</h3>
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
                                 <label> Nama Agensi / Tajaan </label>
                                    <?= $form->field($modelAddress, "[{$i}]nama_tajaan")->textInput(['maxlength' => true])->label(false) ?>
                                </div>


                                  <div class="col-sm-6">
                                       <label> Bentuk Tajaan </label>
                                    <?php
                                echo $form->field($modelAddress, "[{$i}]BantuanCd")->dropDownList(['1' => 'Yuran Pengajian', '2' => 'Tiket Penerbangan', '3'=>'Sara Hidup', '4'=> 'Lain - Lain'],['prompt'=>'Bentuk Tajaan'])->label(false);
?>
                                    
                               </div><div id="lain2" style="display: none">
                                        <?= $form->field($modelAddress, "[{$i}]bentukBantuan")->textInput()->label(false); ?>
                              
                                    </div>      
<!--<script>
    $(document).ready(function() {
    $('.testing').select2();
});
</script>-->
                                       
                               
                            
                             <div class="col-sm-6">
                                 <label> Amaun Tajaan (RM) </label>
                                    <?= $form->field($modelAddress, "[{$i}]amaunBantuan")->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                                    <?php // $form->field($modelAddress, "[{$i}]umur")->textInput(['maxlength' => true]) ?>
                                </div>

                            </div>
                        </div>
                    </div>
            
                <?php endforeach; ?>
                </div>
            
         
            </div> 
            
        </div><!-- .panel -->
        
   <?php DynamicFormWidget::end(); ?>

            </div>      
</div>   </div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
            <div class="x_content">
            <?php
              if($keluarga){ ?>
 <div>
                <form id="w1" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                        <th scope="col" colspan=12">
                    <center>MAKLUMAT KELUARGA</center></th></thead>
                    <tr class="headings">
<!--                        <th class="column-title text-center">Bil</th>-->
                        <th class="column-title text-center">Nama </th>
                        <th class="column-title text-center">Hubungan</th>
                        <th class="column-title text-center">No. Kad Pengenalan </th>
                        <th class="column-title text-center">Umur </th>
                       
                    </tr>
                
                <tbody>

                    <?php $bil=1; foreach ($keluarga as $keluarga) { 
                        if( $keluarga->hubunganKeluarga->RelNm == "Suami" || $keluarga->hubunganKeluarga->RelNm == "Isteri" || $keluarga->hubunganKeluarga->RelNm == "Anak Kandung"){?>

                        <tr>

                            <td class="text-center"><?= $keluarga->FmyNm; ?></td>
                            <td class="text-center"><?= $keluarga->hubunganKeluarga->RelNm;?></td>
                            <td class="text-center"><?= $keluarga->FamilyId; ?></td>
                            <td class="text-center"><?=date("Y") - date("Y", strtotime($keluarga->FmyBirthDt))." " ."Tahun";?></td>
                            
                        
                        </tr>
                    <?php }} ?>
                </tbody>

                     </table>

                </form>


  <?php } ?>
            </div>
                              <p align="right">  <?= Html::a('Kemaskini Maklumat Keluarga', ['keluarga/view'], ['class' => 'btn btn-success btn-xs', 'target'=>'_blank']) ?> </p>

        </div>

    </div>
</div>
</div>

<div class="x_panel">   <div class="x_content">
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead>
                    <th scope="col" colspan=12">
                    <center>PERAKUAN PEMOHON</center></th></thead>

                    <tr class="headings">

                    
                
                        <?php // $model->agree = 0; ?> 
              

                    <td class="col-sm-2 text-center">
                        <div >
                           <?= $form->field($model, 'agree')->checkbox()->label(false); ?>
                            <p class="text-justify"><h5 style="color:black;" ><br> 
                           &nbsp;Saya mengaku maklumat yang dikemukakan adalah benar dan sekiranya saya tidak melengkapkan
                                    dokumen lapor diri seperti yang dinyatakan dalam senarai semak urusan yang berkaitan dengan
                                    perkhidmatan dan saraan saya tidak akan diproses.</p>

                            </h5> 
                            <center><p style="color:black;">Tarikh Mohon: <?php echo $model->tarikh_m; ?></p></center><br/>

                    </div>
                    </td>
              
                
                </table>
            </form>
        </div> </div></div>
<div class="customer-form">  
    <div class="form-group" align="center">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
            <br>
            <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success'])  ?>
            <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1']) ?>
            <button class="btn btn-primary" type="reset">Reset</button>
        </div>
    </div>
</div>   


<?php ActiveForm::end(); ?>
 


