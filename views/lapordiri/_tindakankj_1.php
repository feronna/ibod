<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
error_reporting(0);

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */
$this->title = 'Permohonan Cuti Belajar';

?> 

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
  <p align="right"><?= Html::a('Kembali', ['lapordiri/senaraitindakan'], 
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
                               <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($model->kakitangan->ICNO)); ?>.jpeg" width="150" height="180"></center>

            </div>
        </div> 
        <br/> 
    </div> 
        <br/> 
 
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
                                  <?php echo strtoupper($model->study2->emel_penyelia); ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($model->study2->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($model->study2->tarikhtamat)?> (<?= strtoupper($model->study2->tempohpengajian);?>)</td>
                        </tr>
                        <tr>
                        <th style="width:10%" align="right">PENAJAAN BIASISWA:</th>
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
  <div class="x_panel">

        <div class="x_title">
   <h5><strong><i class="fa fa-th-list"></i> MAKLUMAT PELANJUTAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
    <div class="x_content">
 
                    
                        <div>
<form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   <thead style="background-color:lightseagreen;color:white">
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
            <th>TARIKH PELANJUTAN CUTI BELAJAR </th>
            <th class="column-title text-center">TEMPOH </th>
            <th class="column-title text-center">PELANJUTAN KALI KE</th>
            <th class="column-title text-center">JUSTIFIKASI TERDAHULU</th>

        </tr>
        
        
        

    </thead>
    <tbody>
         <?php if($b->lanjut){ ?>
        <?php $bil=1; foreach ($b->lanjut as $l) { ?>
<tr>
<td class="text-center"><?= $bil++ ?></td>
<td><?= strtoupper($l->stlanjutan); ?>  <b>HINGGA</b> <?= strtoupper($l->ndlanjutan); ?> </td>
<td class="text-center">

<?= strtoupper($l->tempohlanjutan); ?> </td>
<td class="text-center"><?= $l->idlanjutan; ?></td>
<td class="text-center"><?= $l->justifikasi; ?></td>

</tr>
        <?php }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
         
        
        



 </table>
</form>           </div>
                    </div> 

        </div>
  
<div class="x_panel">   <div class="x_content">
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table" >
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>STATUS PENGAJIAN TERKINI</center></th>
                <?php if ($model->status_pengajian == 1)
                {?>
                  <th scope="col" colspan=12">
                      
                  <center>SALINAN SIJIL IJAZAH/SURAT PENGESAHAN SENAT	</center></td></th><?php }?>
               </thead>
              
                    <tr>

                            <td colspan='12' style="vertical-align: middle" class="text-justify"><?php if($model->status_pengajian == 1)
                            {
                                echo '<b><center>'.$model->study->status_pengajian.'</b></center>';
                                ?>  
                                
                            
                        

                        
                   
                           <?php
                 if ($model->upload->dokumen) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td></tr>
                            
                           
                               
                               <?php
                            }
                            
                           
                            elseif ($model->status_pengajian == 3)
                            {
                              echo $model->study->status_pengajian.' | ';
                              echo $model->cek->correction;
                            }
                             elseif ($model->status_pengajian == 6)
                            {
                              echo $model->study->status_pengajian. ' | ';
                              echo $model->catatan;
                              
                            }
                             elseif ($model->status_pengajian == 2)
                            {
                              echo $model->study->status_pengajian. ' , ';
                              echo $model->writing;
                              
                            }
                            
                            else
                            {
                              echo $model->study->status_pengajian;
                            }
                            ?>
                            
                            </tr>
                       
                    

             



                </table>
                
        </div> </div></div>
  <div class="x_panel">   <div class="x_content">
              
              <div class="x_title">
  <?php if(($model->status_pengajian == 2) || ($model->status_pengajian == 3) || ($model->status_pengajian == 4) 
                || ($model->status_pengajian == 5) || ($model->status_pengajian == 6)){?>
   <h5><strong><i class="fa fa-info-circle"></i> MAKLUMAT STATUS PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>TARIKH JANGKAAN BAGI PERKARA BERIKUT (JIKA BELUM SELESAI)</center></th></thead>
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Jangkaan Hantar Tesis Terkini:</th>
                      
                                  <td>
                                    <?php
                                    if($model->dt_tesis != NULL)
                                    {
                                        echo strtoupper($model->dttesis);
                                        
                                    }
                                    else
                                    {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?>
                                  </td>
                     
                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Jangka Viva:</th>
                        <td>
                                    <?php
                                    if($model->dt_viva != NULL)
                                    {
                                        echo strtoupper($model->dtviva);
                                        
                                    }
                                    else
                                    {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?>
                                  </td>
                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jangka Tamat Pengajian:</th>
                            <td>
                                    <?php
                                    if($model->dt_endstudy != NULL)
                                    {
                                        echo strtoupper($model->dtnstudy);
                                        
                                    }
                                    else
                                    {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?>
                                  </td>
                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Jangka Keputusan Rasmi:</th>
                        <td>
                                    <?php
                                    if($model->dt_result != NULL)
                                    {
                                        echo strtoupper($model->dtresult);
                                        
                                    }
                                    else
                                    {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?>
                                  </td>
                    </tr>

                    <tr><?php if($model->study2->HighestEduLevelCd == 999)
                    {?>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Temuduga:</th>
                        <td>
                                    <?php
                                    if($model->dt_iv != NULL)
                                    {
                                        echo strtoupper($model->dtiv);
                                        
                                    }
                                    else
                                    {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?>
                                  </td>
                    </tr><?php }?>
<tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Justifikasi:</th>
                        <td>
                                    <?= $model->catatan;?>
                                  </td>
                    </tr>
                    <tr>           
                    <?php if($model->biasiswa->jenisCd == 3)
{?>
                 <td><strong>Borang Pengesahan Kelayakan Elaun Akhir Pengajian</strong></td><?php
                if ($model->upload->dokumen2) { ?>
                  <td> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen2), true); ?>" target="_blank" >
        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>                            <?php } else {
        echo '<td>Tiada Maklumat</td>'.'<br>';
}?></td></tr><?php }?>
                          <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            Borang Persetujuan Pemotongan Gaji :</th>
                        <td>
                                     <?php
                                    if ($model->upload->dokumen_6) { ?>
                                  
                                  <a class="form-control" style="border:0;box-shadow: none;" href="<?= yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen_6), true); ?>" target="_blank" ><i></i> 
                                      <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
                                    <?php } else {
                                        echo 'Tiada Maklumat'.'<br>';
                                    }?>
                                  </td>
                    </tr>
  </table><?php }?>
        </div> </div></div>
 <div class="row">
                

<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
            
            <div class="x_title">
              <?php if (($model->study2->HighestEduLevelCd == 200) || ($model->study2->HighestEduLevelCd == 207) || ($model->study2->HighestEduLevelCd == 222) || ($model->study2->HighestEduLevelCd == 999))
                      {?> 
                <h5><strong><i class="fa fa-list-alt"></i> DOKUMEN TUNTUTAN TAMAT PENGAJIAN </strong></h5>
                
            </div>

 <div>
<table class="table table-bordered jambo_table">
   
                    <thead style="background-color:lightseagreen;color:white">
                    <tr class="headings">
                        <th class="column-title">NAMA DOKUMEN </th>
                        <th class="column-title text-center">PERINCIAN </th>

                    </tr>
                  
                  
                </thead>
                <tbody>
                    
<!--                        <td rowspan="2">     <center><b>SEKIRANYA TAJAAN KPM</b></center></td>-->
                    <tr>           
                    <?php if($model->biasiswa->jenisCd == 3)
{?>
                 <td><strong>BORANG PENGESAHAN KELAYAKAN ELAUN AKHIR PENGAJIAN</strong></td><?php
                if ($model->upload->dokumen2) { ?>
                  <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen2), true); ?>" target="_blank" >
        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>                            <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td></tr>
                               
                    <tr>  
                  <td><strong>   BORANG TUNTUTAN ELAUN TESIS</strong></td><?php
                                    if ($model->upload->dokumen3) { ?>
                        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen3), true); ?>" target="_blank" >
        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>                            <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td></tr>
                             
                    <tr>
                        <td>  <strong>  BORANG PERMOHONAN HADIAH PERGERAKAN GAJI (HPG)</strong><br/><?php
                        if ($model->upload->dokumen4) { ?>
                                     <b>(HANYA BAGI GRED DS45 SAHAJA)</b></td><br>
                        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen4), true); ?>" target="_blank" >
        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>                            <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
}}?></td></tr>
        <tr> 
            <?php if (($model->study2->HighestEduLevelCd == 200) || ($model->study2->HighestEduLevelCd == 207) || ($model->study2->HighestEduLevelCd == 222) || ($model->study2->HighestEduLevelCd == 999))
                      {?>
            <td><strong>  LAPORAN SEPANJANG TEMPOH PENGAJIAN</strong></td>
            <?php
      if ($model->upload->dokumen5) { ?>
                                    <br>
                                <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>                            <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
                      } }}?></td></tr>
                        
</tbody></table></div></div></div></div>
                
 <div class="row"> 
<div class="col-xs-12 col-md-12 col-lg-12">

      <div class="x_panel">   <div class="x_content">
                <div class="x_title">
   <h5><strong><i class="fa fa-check-square"></i> PERAKUAN KAKITANGAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>PERAKUAN KAKITANGAN</center></th></thead>

                    <tr class="headings">

                    
                
              
              

                    <td class="col-sm-2 text-center">
                        <div >
                             
                <p class="text-center"><h5><br> 
                   Saya mengaku maklumat yang dikemukakan adalah benar dan sekiranya saya tidak melengkapkan
                                    dokumen lapor diri seperti yang dinyatakan dalam senarai semak urusan yang berkaitan dengan
                                    perkhidmatan dan saraan saya tidak akan diproses.<br>

                           
                Tarikh Mohon: <?php echo $model->tarikh_mohon; ?></p> </h5> <br/>

                    </div>
                    </td>
              
                
                </table>
        </div> </div></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 
    <div class="x_panel">
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                <th scope="col" colspan=12"  style="background-color:white;"><center>STATUS PERAKUAN KETUA JABATAN</center></th>
               
                <tr> 
                    <td colspan="5"><center><P>Adalah dimaklumkan bahawa penama berikut merupakan kakitangan dibawah seliaan saya yang telah mengikuti pengajian lanjutan dan beliau telah melapor diri bertugas semula seperti berikut:</P></center></td>
                </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Lapor Diri:</th>
                        <td> <?= $model->dt_lapordiri;?>  </td>

                        
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Status Perakuan:</th>
                        <td> <?= $model->status_jfpiu;?></td>
</td> 
                    </tr>
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Ulasan:</th>
                        <td> <?= $model->ulasan_jfpiu;?>  </td>

                    </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Diperakukan:</th>
                        <td> <?= $model->app_date;?></td>

                    </tr>
          
                </table>
            </div>  
        
       </div>  </div>
</div>     
</div></div>
 <div class="row">
  <!-- Perakuan Ketua Jabatan -->
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
    <div class="x_panel">
        
        <br>
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">
                <center><strong><h5><u> PERAKUAN BAGI PENGESAHAN LAPOR DIRI</u></h5></strong></center>
                <p>Adalah dimaklumkan bahawa penama berikut merupakan kakitangan dibawah seliaan saya yang telah mengikuti pengajian lanjutan dan beliau telah melapor diri bertugas semula seperti berikut:</P>

                <table class="table table-bordered jambo_table">

<tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAMA:</th>
                        <td colspan="5"><?= strtoupper($model->kakitangan->displayGelaran) . ' ' . ucwords(strtoupper($model->kakitangan->CONm)); ?></td>

                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">UMSPER:</th>
                        <td><?= strtoupper($model->kakitangan->COOldID); ?></td>
                       
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">FAKULTI:</th>
                        <td><?=  strtoupper($model->kakitangan->displayDepartment); ?></td>
                       
                    </tr>
                    <tr>
                        <th class="col-md-2 col-sm-3 col-xs-12">PERINGKAT PENGAJIAN:</th>
                        <td><?php if($model->study2->tahapPendidikan)
                                {
                                 echo strtoupper($model->study2->tahapPendidikan);
                                         
                                }
                                
                              
                                ?></td> </tr>
                    
                    
                    
                </table>
            </form>
        </div>
       
        <hr>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">TARIKH LAPOR DIRI<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                     <?= $form->field($model, 'dt_lapordiri')->widget(DatePicker::className(),
                            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                            'options' => [ 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'lanjutansdt' ]])->label(false);?>
                </div>
        </div>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">STATUS PERAKUAN<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status_jfpiu')->label(false)->widget(Select2::classname(), [
                        'data' => ['Diperakukan' => 'TELAH MELAPOR DIRI'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Diperakukan"){
                        $("#ulasan").show();$("#ulasan1").show();
                        }
                        else if($(this).val() == "Tidak Diperakukan"){
                        $("#ulasan1").show();$("#ulasan").hide();}
                        
                        else{$("#ulasan").hide();$("#ulasan1").hide()
                        }'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        
                       
                    ]);
                    ?>
                </div>
        </div>
<!--        <div class="form-group" id="ulasan" style="display: none" align="center">
        <div style="width: 580px; height: 130px;border:2px solid red">
            <br><p align="left">&nbsp;Saya mengambil maklum bahawa telah menerima permohonan pelanjutan tempoh cuti belajar bagi <br>
               &nbsp;1. Tarikh dan tempoh cuti belajar sesuai.<br>
               &nbsp;2. Fungsi JFPIU tidak akan terjejas sepanjang ketidakberadaan kakitangan.<br>
               &nbsp;3. Saya bersetuju untuk memberi pelepasan kepada beliau tanpa staf gantian.</p>
            </div>
        </div>        -->
        <div class="form-group" id="ulasan1" style="display: none" align="center">
            <h5 style="font-size:120%;" class="text-justify"> 
                </h5>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">ULASAN <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_jfpiu')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
            <div class="ln_solid"></div>
           <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                <button class="btn btn-primary" type="reset">Reset</button> 
            </div>
    </div>
</div>
        

    </div>
     <?php ActiveForm::end(); ?>
   




