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
<p align="right"> 

<?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['cetak-lapor-diri', 'id'=>$model->laporID,
                   'target'=>'_blank'], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Borang Lapor Diri'
                ]);
                ?>
 <?= Html::a('Kembali', ['cbadmin/senaraitindakanlapor'], ['class' => 'btn btn-primary btn-sm']) ?></p>

  <div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     SEKYEN PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> 
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
                        <?= strtoupper($model->study2->tarikhtamat)?> (<?= strtoupper($model->study2->tempohtajaan);?>)</td>
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
<?php if(($model->study2->HighestEduLevelCd == 1) || ($model->study2->HighestEduLevelCd == 20)
            || ($model->study2->HighestEduLevelCd == 11) || ($model->study2->HighestEduLevelCd == 101) || ($model->study2->HighestEduLevelCd == 102) ||
            ($model->study2->HighestEduLevelCd == 202) ||  ($model->study2->HighestEduLevelCd == 8) || ($model->study2->HighestEduLevelCd == 201))
                        {?>
<div class="x_panel">   <div class="x_content">
        <div class="x_title">
   <h5><strong><i class="fa fa-exclamation-circle"></i> STATUS PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table" >
                        <tr>


                        <tr>
                            <th scope="col" colspan=12" style="text-align:left">
                       STATUS PENGAJIAN TERKINI</th>
                        <td colspan='12' style="vertical-align: middle" class="text-justify"><?php
    if ($model->status_pengajian == 1) {
        echo '<b><center>' . $model->study->status_pengajian . '</b></center>';
        ?>  


                            </td>

                            </tr>
                            <tr>
                                <th scope="col" colspan=12" style="text-align:left">

                                    SALINAN SIJIL IJAZAH/SURAT PENGESAHAN SENAT</th>
        <?php if ($model->upload->dokumen) { ?>
                                    <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen), true); ?>" target="_blank" >
                                            <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
                                <?php
                                } else {
                                    echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>' . '<br>';
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <th scope="col" colspan=12" style="text-align:left">

                                    BORANG TUNTUTAN PELBAGAI - KOS KUARANTIN (LUAR NEARA SAHAJA)</th>
        <?php if ($model->upload->dokumen5) { ?>
                                    <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
                                            <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
        <?php
        } else {
            echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>' . '<br>';
        }
        ?></td>
                            </tr>



        <?php
    } else {
        echo $model->study->status_pengajian;
    }
    ?>

                      







                    </table>
                
                        </div> </div></div><?php }?>
    <?php if($model->study2->HighestEduLevelCd == 200)
                        {?>
<div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
      </h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>
<tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PENGAJIAN:<br>
                       </th>

                                
                       <td class="text-center"><?= $model->study->status_pengajian;?></td>      
                        

                        
                   
                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small>Pos Doktoral</small>
                       </th>

                                
                            
                        

                        
                   
                           <?php
                 if ($model->upload->dokumen5) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td>                      

                        
                    </tr>
                     
                
                    
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>
    
         
              <?php if($model->study2->HighestEduLevelCd == 99)
                        {?>
<div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
      </h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>
<tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PENGAJIAN:<br>
                       </th>

                                
                       <td class="text-center"><?= $model->study->status_pengajian;?></td>      
                        

                        
                   
                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small>Sabatikal</small>
                       </th>

                                
                            
                        

                        
                   
                           <?php
                 if ($model->upload->dokumen5) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td>                      

                        
                    </tr>
                     
                
                    
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>


<?php if($model->study2->HighestEduLevelCd == 207 || $model->study2->HighestEduLevelCd == 211
        || $model->study2->HighestEduLevelCd == 212 )
                        {?>
<div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
      </h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>
<tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PENGAJIAN:<br>
                       </th>

                                
                       <td class="text-center"><?= $model->study->status_pengajian;?></td>      
                        

                        
                   
                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN:<br>
                       </th>

                                
                            
                        

                        
                   
                           <?php
                 if ($model->upload->dokumen5) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td>                      

                        
                    </tr>
                     
                
                    
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>
                    
     <?php if($model->study2->HighestEduLevelCd == 999)
                        {?>
<div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
      </h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>
<tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PENGAJIAN:<br>
                       </th>

                                
                       <td class="text-center"><?= $model->study->status_pengajian;?></td>      
                        

                        
                   
                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small>Latihan Industri</small>
                       </th>

                                
                            
                        

                        
                   
                           <?php
                 if ($model->upload->dokumen5) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td>                      

                        
                    </tr>
                     
                
                    
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>
    <?php if($model->kakitangan->jawatan->job_category=="1" && $model->study2->HighestEduLevelCd != 211
           && $model->study2->HighestEduLevelCd != 212){?>

    <div class="x_panel">   <div class="x_content">
        <div class="x_title">
   <h5><strong><i class="fa fa-money"></i> TUNTUTAN LAPOR DIRI PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table" >
                    <tr class="headings">
                                    <th   style="background-color:lightseagreen;color:white">
                                        JENIS TUNTUTAN
                                </th>
                                <th width="10px" style="background-color:lightseagreen;color:white"><center>
                                        SEMAKAN
                                </th>
                                </tr>
                       
                   <tr> 
                                
                        <th style="width:10%" align="right">ELAUN AKHIR PENGAJIAN -KPT</th>
                        <td style="width:20%">
                             <?php if($akhir)
    {?>
                            <p>&#9989; <?= $akhir->tarikh_m ?></p>
                                
                          <?php }
                          else{?>
                            <p> &#10060;</p>
                         <?php }
?></td></tr>
                <tr> 
                                
                        <th style="width:10%" align="right">ELAUN TESIS -KPT</th>
                        <td style="width:20%">
                            <?php if($tesis)
    {?>
                            <p>&#9989; <?= $tesis->tarikh_m ?></p>
                                
                          <?php }
                          else{?>
                            <p> &#10060;</p>
                         <?php }
?>     </td></tr>
                  <tr> 
                                
                        <th style="width:10%" align="right">HADIAH PERGERAKAN GAJI (HPG)</th>
                        <td style="width:20%">
                                <?php if($hpg)
    {?>
                            <p>&#9989; <?= $hpg->tarikh_m ?></p>
                                
                          <?php }
                          else{?>
                            <p> &#10060;</p>
                         <?php }
?> </td></tr>


                </table>
                
        </div> </div></div>
 
      
    <?php }?>

     
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
                             
                <p class="text-justify"><h5><br> 
                   <strong>Saya mengaku maklumat yang dikemukakan adalah benar dan sekiranya saya tidak melengkapkan
                                    dokumen lapor diri seperti yang dinyatakan dalam senarai semak urusan yang berkaitan dengan
                                    perkhidmatan dan saraan saya tidak akan diproses.</p></strong>

                            </h5> 
                            <center><p style="color:black;">Tarikh Mohon: <?php echo $model->tarikh_mohon; ?></p></center><br/>

                    </div>
                    </td>
              
                
                </table>
        </div> </div></div>
        <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12"> 
    <div class="x_panel">
  <div class="x_title">

   <h5><strong><i class="fa fa-check"></i> PERAKUAN KETUA JABATAN/DEKAN</strong></h5>
   
   
   <div class="clearfix"></div>
              </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>STATUS PERAKUAN KETUA JABATAN</center></th>
               
                <tr> 
                    <td colspan="5"><center><P>Adalah dimaklumkan bahawa penama berikut merupakan kakitangan dibawah seliaan saya <b>(<?= $model->namaapp->CONm; ?>)</b> yang telah mengikuti pengajian lanjutan dan beliau telah melapor diri bertugas semula seperti berikut:</P></center></td>
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
            <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Diperakukan oleh:</th>
                        <td> <?=  $model->namaapp->CONm;?></td>

                    </tr>
                </table>
            </div>  
        
       </div>  </div>
</div>     
</div>
        

     <?php ActiveForm::end(); ?>
   




