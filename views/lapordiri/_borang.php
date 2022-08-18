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
error_reporting(0);
?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <p align="right"><?= Html::a('Kembali', ['cutibelajar/halaman-pemohon'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>

<div class="x_panel">  
    <div class="product_price"> 
        <h5 align="center" style="font-size:16px;font-weight: bold;"> 
            LAPOR DIRI TAMAT TEMPOH PENGAJIAN LANJUTAN</5> 
        <div class="clearfix"></div> 
    </div> 
</div>
 <div class="row"> 
<div class="col-md-12 col-xs-12"> 

<div class="x_panel">

        <div class="x_title">
            <h4><strong> PANDUAN PERMOHONAN</strong></h4>
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
            <?php if($model->biasiswa->jenisCd == 3)
    {?>
            <b style="color:red">JIKA ANDA SELESAI, TAJAAN KPT:</b><br> 
            <div align="justify"><strong>
            
                    1. SILA PILIH STATUS PENGAJIAN ANDA <b>LULUS</b>.</strong><br> </div>
            <div align="justify"><strong>
            
           2. SILA MUAT NAIK SALINAN SIJIL ASAL/SURAT PENGESAHAN SENAT LULUS PENGAJIAN.</strong><br> </div>
            <div align="justify"><strong>
            
           3. KLIK BUTANG ELAUN AKHIR PENGAJIAN UNTUK TUNTUTAN.</strong><br> </div>
            <div align="justify"><strong>
            
           4. KLIK BUTANG ELAUN TESIS UNTUK TUNTUTAN.</strong><br> </div>
            <div align="justify"><strong>
            
           5. KLIK BUTANG HADIAH PERGERAKAN GAJI UNTUK TUNTUTAN (HANYA UNTUK JAWATAN GRED DS45 SAHAJA).</strong><br> </div>
            
            <div align="justify"><strong>
                    6. KLIK BUTANG PENGESAHAN UNTUK MENGHANTAR BORANG LAPOR DIRI ANDA.</strong><br> 
                    <small>(BUTANG PENGESAHAN AKAN KELUAR SETELAH STATUS PENGAJIAN DIISI)</small></div>
            
            <br>
    <?php }
//    elseif($model->biasiswa->jenisCd == "NULL"){
//        
//        return "-";
//    }
    
    else { ?>
             <b style="color:red">JIKA ANDA SELESAI, TAJAAN UMS/LUAR:</b><br> 
            <div align="justify"><strong>
            
           1. SILA PILIH STATUS PENGAJIAN ANDA <b>LULUS</b>.</strong><br> </div>
            <div align="justify"><strong>
            
           2. KLIK BUTANG HADIAH PERGERAKAN GAJI UNTUK TUNTUTAN (HANYA UNTUK GRED DS45 SAHAJA).</strong><br> </div>
          
            <div align="justify"><strong>
                    3. KLIK BUTANG PENGESAHAN UNTUK MENGHANTAR BORANG LAPOR DIRI ANDA.</strong><br> 
                    &nbsp;&nbsp;&nbsp;&nbsp;<small>(BUTANG PENGESAHAN AKAN KELUAR SETELAH STATUS PENGAJIAN<B> DIISI DAN DISIMPAN</B>)</small></div>
    <?php }?>
        </div>
</div>
</div></div>
    <div class ="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->
<!--    <div class="x_title">
        <h2><strong><i class="fa fa-check-square"></i> PANDUAN PERMOHONAN</strong><br/>
        <small>Sila Klik Setiap Butang Untuk Hantar Permohonan</small></h2>
            
            <div class="clearfix"></div>
        </div>-->
         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app',' <i class="fa fa-graduation-cap"></i> STATUS PENGAJIAN'), ['lapordiri/borang'], ['class' => 'btn btn-primary btn-md']);
//  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//     echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/lkk-jfpiu'], ['class' => 'btn btn-default btn-lg']);
  

?>
    <?php if($model->stud->tajaan->jenisCd == 3)
    {?><?php
  
  echo Html::a(Yii::t('app',' <i class="fa fa-th-list"></i> ELAUN AKHIR PENGAJIAN'), ['lapordiri/tuntut-akhir'], ['class' => 'btn btn-primary btn-md','target' => '_blank']);
  echo Html::a(Yii::t('app',' <i class="fa fa-book"></i> ELAUN TESIS'), ['lapordiri/tuntut-tesis'], ['class' => 'btn btn-primary btn-md','target'=>'_blank']);

    ?><?php }?>
 <?php if($lapor)
    {?><?php
  echo Html::a(Yii::t('app',' <i class="fa fa-gift"></i> HADIAH PERGERAKAN GAJI'), ['lapordiri/tuntut-hpg'], ['class' => 'btn btn-primary btn-md','target' => '_blank']);

  echo Html::a(Yii::t('app',' <i class="fa fa-check"></i> PENGESAHAN'), ['lapordiri/pengesahan','i'=>$lapor->laporID], ['class' => 'btn btn-primary btn-md']);
//  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//     echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/lkk-jfpiu'], ['class' => 'btn btn-default btn-lg']);
  

    ?><?php } else
    {
    if($model->kakitangan->jawatan->gred == "DS45")
    {
          echo Html::a(Yii::t('app',' <i class="fa fa-gift"></i> HADIAH PERGERAKAN GAJI'), ['lapordiri/tuntut-hpg'], ['class' => 'btn btn-primary btn-md','target' => '_blank']);
    }
    }
?>
         </div>
    </div>
</div></div>
            
    <div class="x_panel">
    <div class="x_title">
   <h5 ><strong><i class="fa fa-user"></i> MAKLUMAT PEMOHON</strong></h5>
   
   
   <div class="clearfix"></div>
</div>      
    <div class="col-md-3 col-sm-3  profile_left"> 
        

        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="150" height="180"></center>
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

     <?php if($model->stud){
        
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive">
                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th colspan="2" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($model->stud->tahapPendidikan)
                                {
                                 echo strtoupper($model->stud->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                               
                    <tr> 
                                
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->stud->InstNm); ?></td></tr>
                        
                        
                   
                     
                       
                 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($model->stud->MajorCd == NULL) && ($model->stud->MajorMinor != NULL))
                        {
                                echo  strtoupper($model->stud->MajorMinor);
                        }
                        elseif (($model->stud->MajorCd != NULL) && ($model->stud->MajorMinor != NULL))  {
                            echo   strtoupper($model->stud->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($model->stud->major->MajorMinor);
                        }
?></td>
                      
                    
                     <tr> 
                                
                        <th style="width:10%" align="right">MOD PENGAJIAN</th>
                        <td style="width:20%">
                            
                                  <?php if($model->stud->modeID)
                                  {echo strtoupper($model->stud->mod->studyMode);}
                                  
                                  else{
                                      echo "<i>Tiada Maklumat</i>";
                                  }
?></td></tr>
                     
                      <tr> 
                                
                        <th style="width:10%" align="right">TAJUK PENYELIDIKAN</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->stud->tajuk_tesis); ?></td></tr>
                        <tr> 
                                
                        <th style="width:10%" align="right">NAMA PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->stud->nama_penyelia); ?></td></tr>
                          <tr> 
                                
                        <th style="width:10%" align="right">EMEL PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo $model->stud->emel_penyelia; ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($model->stud->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($model->stud->tarikhtamat)?> (<?= strtoupper($model->stud->tempohpengajian);?>)</td>
                        </tr>
                        <tr>
                        <th style="width:10%" align="right">BIASISWA:</th>
                        <td><?= ucwords(strtoupper($model->stud->tajaan->nama_tajaan)); ?></td> 
                    </tr>
                              <?php }     else{
                    ?>
                    <tr>
                        <td><b>TIADA MAKLUMAT</b></td>                     
                    </tr>
                  <?php  
                } ?> 
                     
                    
                  
                
                    
      
                            </thead>
                        

                                
                      
                        </table>

                    </div> 

        </div></div>
<div class="row">
    <div class="x_panel">         
    <div class="col-md-12 col-sm-12 col-xs-12"> 

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
                                'data' => ArrayHelper::map(app\models\cbelajar\RefStatus::find()->where(['cat'=>2])->all(), 'id', 'status_pengajian'),
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
                
        </div> </div></div></div>
   
<div class="x_panel">
     <?php if(($model->stud->HighestEduLevelCd == 1) || ($model->stud->HighestEduLevelCd == 20)
            || ($model->stud->HighestEduLevelCd == 11) || ($model->stud->HighestEduLevelCd == 101) || ($model->stud->HighestEduLevelCd == 102) ||
            ($model->stud->HighestEduLevelCd == 202) || ($model->stud->HighestEduLevelCd == 8) || ($model->stud->HighestEduLevelCd == 201))
                        {?>
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
        <i><small>Lengkapkan permohonan anda dan pastikan muatnaik lampiran yang sewajarnya</small></i></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>

                    
                     
               
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SALINAN  SIJIL ASAL/SURAT PENGESAHAN SENAT LULUS PENGAJIAN:<br>
                          
                       </th>
                        <td class="text-justify"><?= $form->field($model, 'file')->fileInput()->label(false);?> </td>
                        

                        
                    </tr>
                     <tr>
                         <th  class="col-md-3 col-sm-3 col-xs-12">BORANG TUNTUTAN PELBAGAI - KOS KUARANTIN (Luar Negara Sahaja):<br>
                         <a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/borang tuntutan pelbagai - kos kuarantin.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>
                        </th>
                     
                        <td><br><?= $form->field($model, 'file5')->fileInput()->label(false);?> </td>
</div>
                </tr>
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>
    
    <?php if($model->stud->HighestEduLevelCd == 200)
                        {?>
<div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
        <i><small>Lengkapkan permohonan anda dan pastikan muatnaik lampiran yang sewajarnya</small></i></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>

                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small>Pos Doktoral</small>
                       </th>
                        <td class="text-justify"><?= $form->field($model, 'file5')->fileInput()->label(false);?> </td>
                        

                        
                    </tr>
                     
                
                    
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>
    
    
    <?php if($model->stud->HighestEduLevelCd == 99 || $model->stud->HighestEduLevelCd == 211 || $model->stud->HighestEduLevelCd == 212 ||
            $model->stud->HighestEduLevelCd == 210)
                        {?>
<div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
        <i><small>Lengkapkan permohonan anda dan pastikan muatnaik lampiran yang sewajarnya</small></i></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>

                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <?php if($model->stud->HighestEduLevelCd == 99)
                            {?>
                            <small>Cuti Sabatikal</small><?php }
                            elseif($model->stud->HighestEduLevelCd == 212)
                            {?>
                            <small>Latihan Penyelidikan</small>   
                           <?php }
                            elseif($model->stud->HighestEduLevelCd == 210)
                            {?>
                            <small>Latihan Industri - IR</small>   
                           <?php }
                            else{?>
                                <small>Pra Warta</small><?php
                            }
?>
                       </th>
                        <td class="text-justify"><?= $form->field($model, 'file5')->fileInput()->label(false);?> </td>
                        

                        
                    </tr>
                     
                
                    
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>
    
    
    <?php if($model->stud->HighestEduLevelCd == 207)
                        {?>
<div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
        <i><small>Lengkapkan permohonan anda dan pastikan muatnaik lampiran yang sewajarnya</small></i></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>

                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small>Program Sangkutan</small>
                       </th>
                        <td class="text-justify"><?= $form->field($model, 'file5')->fileInput()->label(false);?> </td>
                        

                        
                    </tr>
                     
                
                    
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>
    
    <?php if($model->stud->HighestEduLevelCd == 999)
                        {?>
<div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
        <i><small>Lengkapkan permohonan anda dan pastikan muatnaik lampiran yang sewajarnya</small></i></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>

                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small>Latihan Industri</small>
                       </th>
                        <td class="text-justify"><?= $form->field($model, 'file5')->fileInput()->label(false);?> </td>
                        

                        
                    </tr>
                     
                
                    
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>


    
<div class="customer-form">  
    <div class="form-group" align="center">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
            <br>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-disk"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2'])?>
            <button class="btn btn-primary" type="reset">Reset</button>
        </div>
    </div>
</div>   


<?php ActiveForm::end(); ?>
 


