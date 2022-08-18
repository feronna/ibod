<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar';
error_reporting(0);

?> 

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
 
 <p align="right"><?= Html::a('Kembali', ['cutibelajar/permohonan-semasa'], 
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
  echo Html::a(Yii::t('app',' <i class="fa fa-graduation-cap"></i> STATUS PENGAJIAN'), ['lapordiri/borang-belum-selesai'], ['class' => 'btn btn-primary btn-md']);
//  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//     echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/lkk-jfpiu'], ['class' => 'btn btn-default btn-lg']);
  

?>
    <?php if($model->biasiswa->jenisCd == 3)
    {?><?php
  
  echo Html::a(Yii::t('app',' <i class="fa fa-th-list"></i> ELAUN AKHIR PENGAJIAN'), ['lapordiri/tuntut-akhir'], ['class' => 'btn btn-primary btn-md']);


    ?><?php }?>
 <?php if($lapor)
    {?><?php

  echo Html::a(Yii::t('app',' <i class="fa fa-check"></i> PENGESAHAN'), ['lapordiri/pengesahan-belum-selesai','i'=>$i], ['class' => 'btn btn-primary btn-md']);
//  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//     echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/lkk-jfpiu'], ['class' => 'btn btn-default btn-lg']);
  

    ?><?php } ?>
         </div>
    </div>
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
                            
                                  <?php if($stu->modeID)
                                  {echo strtoupper($stu->mod->studyMode);}
                                  
                                  else{
                                      echo "<i>Tiada Maklumat</i>";
                                  }
?></td></tr>
                     
                      <tr> 
                                
                        <th style="width:10%" align="right">TAJUK PENYELIDIKAN</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($stu->tajuk_tesis); ?></td></tr>
                        <tr> 
                                
                        <th style="width:10%" align="right">NAMA PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($stu->nama_penyelia); ?></td></tr>
                          <tr> 
                                
                        <th style="width:10%" align="right">EMEL PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($stu->emel_penyelia); ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($stu->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($stu->tarikhtamat)?> (<?= strtoupper($stu->tempohtajaan);?>)</td>
                        </tr>
                        <tr>
                        <th style="width:10%" align="right">PENAJAAN BIASISWA:</th>
                        <td><?= ucwords(strtoupper($stu->tajaan->nama_tajaan)); ?></td> 
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
         <?php if($stu->lanjut){ ?>
        <?php $bil=1; foreach ($stu->lanjut as $l) { ?>
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
                            <td colspan="11" class="text-center"><i>TIADA MAKLUMAT</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
         
        
        



 </table>
</form>           </div>
                    </div> 

        </div>
 
<div class="x_panel">
     <?php if ($model->agree == NULL) { ?>   <p align="right">
            <?= Html::a('Kemaskini', ['kemaskini-lapordiri?i=' . $model->laporID], ['class' => 'btn btn-primary btn-sm','target'=>'_blank']) ?></p><?php } ?><div class="x_content">
        <div class="x_title">
   <h5><strong><i class="fa fa-exclamation-circle"></i> STATUS PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
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
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td></tr>
                            
                           
                               
                               <?php
                            }
                            
                           
                            elseif ($model->status_pengajian == 3)
                            {
                              echo $model->study->status_pengajian;
//                              echo $model->cek->correction;
                            }
                             elseif ($model->status_pengajian == 6)
                            {
                              echo $model->study->status_pengajian. ' | ';
                              echo $model->catatan;
                              
                            }
                             elseif ($model->status_pengajian == 2)
                            {
                              echo $model->study->status_pengajian;
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
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            Borang Tuntutan Pelbagai - Kos Kuarantin (Luar Negara Sahaja) :</th>
                        <td>
                                     <?php
                                    if ($model->upload->dokumen5) { ?>
                                  
                                  <a class="form-control" style="border:0;box-shadow: none;" href="<?= yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" ><i></i>  
                                      <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
                                    <?php } else {
                                        echo 'Tiada Maklumat'.'<br>';
                                    }?>
                                  </td>
                    </tr>
                </table>
        </div> </div></div>
 

 
         
              



                    
     
          
          

     <?php ActiveForm::end(); ?>
   




