<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;

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
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <p align="right"><?= Html::a('Kembali', ['cutibelajar/halaman-pemohon'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>

<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> 
     LAPOR DIRI TAMAT TEMPOH PENGAJIAN LANJUTAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
    <div class="x_panel">
    <div class="x_title">
   <h5 ><strong><i class="fa fa-user"></i> MAKLUMAT PEMOHON</strong></h5>
   
   
   <div class="clearfix"></div>
</div>      
    <div class="col-md-3 col-sm-3  profile_left"> 
        

        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                <center> <?php
                       
                        if ($img) {
                            echo Html::img($img->getImageUrl().$img->filename, [
                                'class' => 'img-thumbnail',
                                'width' => '150',
                                'width' => '150',
                            ]);
                        }

                        ?>  </center>
            </div>
        </div> 
        <br/> 
    </div>
    <div class="col-md-9 col-sm-9 col-xs-9">

        <div class="col-md-12 col-sm-12 col-xs-12">   
            <br/>
<!--            <h4 colspan="2" style="background-color:lightseagreen;color:white"><center>MAKLUMAT PERIBADI</center></h4>-->
                   
            <table class="table" style="width:100%">
                
                <thead>
                    <tr>
                        <th colspan="4" class="text-center">
                <h5><?=  strtoupper($model->kakitangan->CONm); ?> |
                <?=date("Y") - date("Y", strtotime($model->kakitangan->COBirthDt))." ". "TAHUN"?></h5>
                </th>
                </tr>  
                <tr>
                    <th colspan="4" class="text-center"> 
                        <?= strtoupper($model->kakitangan->jawatan->fname);?> | 
                        <?= strtoupper($model->kakitangan->department->fullname);?>
                    </th> 
                </tr>
                </thead>
                <tbody>

                    <tr> 
                        <th style="width:20%">ICNO</th>
                        <td style="width:20%"><?= $model->kakitangan->ICNO; ?></td> 
                        <th>UMSPER</th>
                        <td><?= $model->kakitangan->COOldID; ?></td>  

                    </tr>
                    <tr> 

                       
                        <th style="width:20%">TARIKH LANTIKAN</th>
                        <td style="width:20%"><?= strtoupper($model->kakitangan->displayStartLantik); ?></td>
                       <th width="20%">TARAF PERKAHWINAN: </th>
                       <td><?= strtoupper($model->kakitangan->displayTarafPerkahwinan) ?></td> 

                    </tr>
                    <tr> 

                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                                    if ($model->kakitangan->confirmDt) {
                                        echo strtoupper($model->kakitangan->confirmDt->tarikhMula);
                                    } else {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?></td>
                        <th style="width:20%">TEMPOH BERKHIDMAT SEMASA</th>
                        <td style="width:20%"><?= strtoupper($model->kakitangan->servPeriodPermanent);  ?></td>


                    </tr>
                     
                    <tr> 
                        
                        <th>EMEL</th>
                        <td><?= $model->kakitangan->COEmail; ?></td> 
                        <th style="width:20%">NO. TELEFON</th>
                        <td style="width:20%"><?= $model->kakitangan->COHPhoneNo; ?></td>
                    </tr>
                    
                    
                     
                </tbody>
            </table> 
        </div> 
        <br/>

    </div>
</div>

    <div class="x_panel">
      <div class="col-md-12 col-sm-12 col-xs-12"> 

<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN </strong></h5>
   
   
   <div class="clearfix"></div>
</div>      

     <?php if($model->study2){
        
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive">
                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th colspan="2" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($model->study2->tahapPendidikan)
                                {
                                 echo strtoupper($model->study2->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                               
                    <tr> 
                                
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->study2->InstNm); ?></td></tr>
                        
                        
                   
                     
                       
                 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($model->study2->MajorCd == NULL) && ($model->study2->MajorMinor != NULL))
                        {
                                echo  strtoupper($model->study2->MajorMinor);
                        }
                        elseif (($model->study2->MajorCd != NULL) && ($model->study2->MajorMinor != NULL))  {
                            echo   strtoupper($model->study2->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($model->study2->major->MajorMinor);
                        }
?></td>
                      
                    
                     <tr> 
                                
                        <th style="width:10%" align="right">MOD PENGAJIAN</th>
                        <td style="width:20%">
                            
                                  <?php if($model->study2->modeID)
                                  {echo strtoupper($model->study2->mod->studyMode);}
                                  
                                  else{
                                      echo "<i>Tiada Maklumat</i>";
                                  }
?></td></tr>
                     
                      <tr> 
                                
                        <th style="width:10%" align="right">TAJUK PENYELIDIKAN</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->study2->tajuk_tesis); ?></td></tr>
                        <tr> 
                                
                        <th style="width:10%" align="right">NAMA PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->study2->nama_penyelia); ?></td></tr>
                          <tr> 
                                
                        <th style="width:10%" align="right">EMEL PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo $model->study2->emel_penyelia; ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($model->study2->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($model->study2->tarikhtamat)?> (<?= strtoupper($model->study2->tempohpengajian);?>)</td>
                        </tr>
                        <tr>
                        <th style="width:10%" align="right">BIASISWA:</th>
                        <td><?= ucwords(strtoupper($model->biasiswa->nama_tajaan)); ?></td> 
                    </tr>
                              <?php }     else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center"><b>Tiada Rekod Maklumat Pengajian yang dipohon</b></td>                     
                    </tr>
                  <?php  
                } ?> 
                     
                    
                  
                
                    
      
                            </thead>
                        

                                
                      
                        </table>

                    </div> 

        </div></div>
  </div>
    
<div class="x_panel">   <div class="x_content">
        <div class="x_title">
   <h5 ><strong><i class="fa fa-exclamation-circle"></i> STATUS PENGAJIAN </strong></h5>
   
   
   <div class="clearfix"></div>
</div> 
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>STATUS PENGAJIAN TERKINI</center></th></thead>
              
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12"><center>STATUS PENGAJIAN:</center</th>
                        <td><?=
                            $form->field($model, 'status_pengajian')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(app\models\cbelajar\RefStatus::find()->all(), 'id', 'status_pengajian'),
                                'options' =>
                                ['placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12',
                                    'onchange' =>
                                    'javascript:if ($(this).val() == "1")
                                           {
                                                $("#lulus").show();$("#viva").hide();$("#tulis").hide();$("#lain").hide();$("#belum").hide();$("#rasmi").hide()
                                         }
                                        
                                          else if(($(this).val() == "2") || ($(this).val() == "3") || ($(this).val() == "4")
                                          || ($(this).val() == "5") || ($(this).val() == "6"))
                                         {
                                           $("#tulis").show();$("#viva").hide();$("#lulus").hide();$("#lain").hide();$("#belum").hide();$("#rasmi").hide();
                                           }
                                            else if($(this).val() == "5") 
                                         {
                                           $("#viva").show();$("#tulis").hide();$("#lulus").hide();$("#lain").hide();$("#belum").hide();$("#rasmi").hide();
                                           }
                                         
                                         

                                    else{
                                    $("#lulus").hide();$("#viva").hide();$("#tulis").hide();$("#lain").hide();$("#rasmi").hide();$("#belum").hide();
                                    }'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?> 
                          
                             
                             
                            
                            
                             

                        </td> 
                    </tr>



                </table>
                
        </div> </div></div>

<div id="lulus" style="display: none">

<div class="x_panel">   <div class="x_content">
        <div> <?php if($model->study2->HighestEduLevelCd == 1)
                        {?>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                        
                    <th scope="col" colspan=12">
                        
                    <center>TELAH SELESAI</center></th></thead>
                    </tr>
                    <tr>
                       
                        <th colspan="4">SALINAN  SIJIL ASAL/SURAT PENGESAHAN SENAT LULUS PENGAJIAN:</th>
                        <td class="text-justify"><?= $form->field($model, 'file')->fileInput()->label(false);?> </td>

                        </tr><?php }?>
                        
                       <tr>
                      <?php if($model->biasiswa->jenisCd == 3)
{?>
                    <th colspan='5'><center>SEKIRANYA TAJAAN KPM</center></th>
                <tr>
                    <th colspan="4">BORANG PENGESAHAN KELAYAKAN ELAUN AKHIR PENGAJIAN<br> 
                        Sila lampirkan bersama;<br>
                        i. Salinan tiket penerbangan<br>
                        ii. Boarding pass<br/>
                 <a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/akhir.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>
</th>
                   <td class="text-justify"><?= $form->field($model, 'file2')->fileInput()->label(false);?> </td>
                </tr>
             
                <tr>
                    <th colspan="4">BORANG TUNTUTAN ELAUN TESIS<br>Sila lampirkan bersama;<br> 
                    <p>i. Transkrip Akademik <br> 
                    ii. Sijil PhD/ Sarjana Atau Surat Pengesahan Senat<br>
                    iii. Penyata Bank<br>
                    iv. Salinan Tesis</p>
                   <a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/BORANG-TUNTUTAN-ELAUN-TESIS.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a></th>

                   
                </th>
                   <td class="text-justify"><?= $form->field($model, 'file3')->fileInput()->label(false);?> </td>
                </tr>
<?php }?>
                <tr>
                      <?php if(($model->biasiswa->jenisCd == 2) ||($model->biasiswa->jenisCd == 3) ||
                              ($model->study2->HighestEduLevelCd == 1) || ($model->study2->HighestEduLevelCd == 20))
{?>
                    <th colspan="4">BORANG PERMOHONAN HADIAH PERGERAKAN GAJI (HPG)
                        <b>(HANYA BAGI GRED DS45 SAHAJA)</b><br> i. Salinan Sijil PhD                       
                 <a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/PERMOHONAN-HADIAH-PERGERAKAN-GAJI.pdf', true); ?>" target="_blank" ><br/><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a></th>

                   
           
                    <td class="text-justify"><?= $form->field($model, 'file4')->fileInput()->label(false);?> </td></tr>
<?php }?> 
                <tr>
                      <?php if ($model->study2->HighestEduLevelCd == 200)
                      {?>
                          
                    <th colspan="4">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:
                      <br>
                      <?php if ($model->study2->HighestEduLevelCd == 200)
                      {
                          echo "i. Post Doktoral";
                      }?>
                      
                    </th>
                   <td class="text-justify"><?= $form->field($model, 'file5')->fileInput()->label(false);?> </td>
                
             <?php     }

                     
                ?></tr> 
                  <tr>
                      <?php if ($model->study2->HighestEduLevelCd == 99)
                      {?>
                          
                    <th colspan="4">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:
                      <br>
                      <?php if ($model->study2->HighestEduLevelCd == 99)
                      {
                          echo "i. Sabatikal";
                      }?>
                      
                    </th>
                   <td class="text-justify"><?= $form->field($model, 'file5')->fileInput()->label(false);?> </td>
                
             <?php     }

                     
                ?></tr> 
                  
                  <tr>
                      <?php if ($model->study2->HighestEduLevelCd == 207)
                      {?>
                          
                    <th colspan="4">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:
                      <br>
                      <?php if ($model->study2->HighestEduLevelCd == 207)
                      {
                          echo "i. Program Sangkutan";
                      }?>
                      
                    </th>
                   <td class="text-justify"><?= $form->field($model, 'file5')->fileInput()->label(false);?> </td>
                
             <?php     }

                     
                ?></tr>
                  <tr>
                      <?php if ($model->study2->HighestEduLevelCd == 999)
                      {?>
                          
                    <th colspan="4">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:
                      <br>
                      <?php if ($model->study2->HighestEduLevelCd == 999)
                      {
                          echo "i. Latihan Industri (FKJ)";
                      }?>
                      
                    </th>
                   <td class="text-justify"><?= $form->field($model, 'file5')->fileInput()->label(false);?> </td>
                
                      <?php     }

                     
                ?></tr>
                
                </table></form>
        </div> </div></div></div>
    
    
    <div id="viva" style="display: none">

<div class="x_panel">   <div class="x_content">
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                        
                    <center>TELAH VIVA</center></th></thead>
                    </tr>
                    
                
                </table>
        </div> </div></div></div>
    
 <div id="tulis" style="display: none">

<div class="x_panel">   <div class="x_content">
        <div class="x_title">
   <h5 ><strong><i class="fa fa-calendar"></i> TARIKH JANGKAAN DAN JUSTIFIKASI </strong></h5>
   
   
   <div class="clearfix"></div>
</div> 
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">

                    <th scope="col" colspan=12">
                    <center>TARIKH JANGKAAN BAGI PERKARA BERIKUT (JIKA BELUM SELESAI)</center></th></thead>
                    
                    <tr>
                        <th width="45%">Tarikh Jangkaan Hantar Tesis Terkini:</th>
                        <td colspan="5"><?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'dt_tesis',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?> </td>
                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Jangka Viva:</th>
                        <td colspan="5"><?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'dt_viva',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?> </td>
                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jangka Tamat Pengajian:</th>
                        <td colspan="5"><?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'dt_endstudy',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?> </td>
                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Jangka Keputusan Rasmi:</th>
                        <td colspan="5"><?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'dt_result',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?> </td>
                    </tr>

                    <tr>
                        <?php if($model->study2->HighestEduLevelCd == 999)
                        {?>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Temuduga:</th>
                        <td colspan="5"> <?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'dt_iv',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                        ?> </td><?php }?>
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Justifikasi:</th>
                                    <td colspan="5"> <?= $form->field($model, 'catatan')->textArea(['maxlength' => true]) ->label(false);?></td>

                    </tr>
                                        <?php if($model->biasiswa->jenisCd == 3)
{?>
                    <th colspan='5'><center>SEKIRANYA TAJAAN KPM</center></th>
                <tr>
                    <th  class="col-md-3 col-sm-3 col-xs-12">BORANG PENGESAHAN KELAYAKAN ELAUN AKHIR PENGAJIAN<br> 
                        Sila lampirkan bersama;<br>
                        i. Salinan tiket penerbangan<br>
                        ii. Boarding pass<br/>
                 <a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/akhir.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>
</th>
                   <td class="text-justify"><?= $form->field($model, 'file2')->fileInput()->label(false);?> </td>
                </tr>
<?php }?>
                    <tr>
                         <th  class="col-md-3 col-sm-3 col-xs-12">Borang Persetujuan Pemotongan Gaji:<br>
                         <a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/gaji.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>
                        Borang ini perlu dimuat turun dan diisi untuk persetujuan pemotongan gaji bagi yang belum selesai & telah lapor diri</th>
                     
                        <td><br><?= $form->field($model, 'file6')->fileInput()->label(false);?> </td>
</div>
                </tr>
                   
</div>
                </table>
        </div> </div></div></div> 
        
      
        


<div class="x_panel">   <div class="x_content">
        <div class="x_title">
   <h5 ><strong><i class="fa fa-check-square"></i> PERAKUAN </strong></h5>
   
   
   <div class="clearfix"></div>
</div> 
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>PERAKUAN PEMOHON</center></th></thead>

                    <tr class="headings">

                    
                
                        <?php // $model->agree = 0; ?> 
              

                    <td class="col-sm-2 text-center">
                        <div >
                <?php $model->agree = 1; ?>
                <br><?= $form->field($model, 'agree')->checkbox(['disabled' => false])->label(false); ?> <p>&nbsp;&nbsp;</p>                            <p class="text-justify"><h5 style="color:black;" ><br> 
                           &nbsp;Saya mengaku maklumat yang dikemukakan adalah benar dan sekiranya saya tidak melengkapkan
                                    dokumen lapor diri seperti yang dinyatakan dalam senarai semak urusan yang berkaitan dengan
                                    perkhidmatan dan saraan saya tidak akan diproses.</p>

                            </h5> 
                            <center><p style="color:black;">Tarikh Mohon: <?php echo $model->tarikh_mohon; ?></p></center><br/>

                    </div>
                    </td>
              
                
                </table>
        </div> </div></div>
    
<div class="customer-form">  
    <div class="form-group" align="center">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
            <br>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2'])?>
            <button class="btn btn-primary" type="reset">Reset</button>
        </div>
    </div>
</div>   


<?php ActiveForm::end(); ?>
 


