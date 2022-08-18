<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use kartik\select2\Select2;
error_reporting(0);

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
?> 



   
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>

 
 
 
            <div class="pull-right">
                <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['/lanjutancb/cetak-permohonan', 'i'=>$model->id,
                   'id'=> $model->iklan_id, 'target'=>'_blank'], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Permohonan Pelanjutan Tempoh Cuti Belajar'
                ]);
                ?><?= Html::a('Kembali', ['cbadmin/senaraitindakan'], 
         ['class' => 'btn btn-primary btn-sm']) ?>
    </div> 
      
    
 <div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | 
     SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN PENGAJIAN LANJUTAN TEMPOH CUTI BELAJAR KALI
 '); ?><?= $model->idlanjutan;?> 
                </center>  </strong>
            </span> 
        </div>
    </div>
<div class="x_panel">
    <div class="x_title">
   <h5 ><strong><i class="fa fa-user"></i> MAKLUMAT PERIBADI</strong></h5>
   
   
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
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>      

     <?php if($model->study){
        
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive">
                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th colspan="2" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($b->tahapPendidikan)
                                {
                                 echo strtoupper($b->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                                <tr> 
                        <th style="width:10%" align="right">JAWATAN SEMASA CUTI BELAJAR</th>
                        <td style="width:20%">
                        <?=strtoupper($b->gred) ?></td>
                       
                    </tr>
                    <tr> 
                          <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">ALAMAT (TERKINI):</th>
                        <td> <?= strtoupper($model->alamat);?> 
</td> 
                    </tr>
                         <?php  if($b->l){  ?> 
                    <tr> 
                            
                                  
                               
                          <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                            
                         <?php  echo $b->InstNm; ?>
                          
   
                      
                        </td>
                    </tr>
                    <tr> 
                            
                                  
                               
                          <th style="width:10%" align="right">UNIVERSITI/INSTITUSI BAHARU</th>
                        <td style="width:20%">
                            
                         <?php  echo $b->l->renewTempat; ?>
                          
   
                      
                        </td>
                  
                       
                            
                                  
                               
                        
                            <?php }?></tr>
                    <tr>    
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($b->InstNm); ?></td>
                        
                        
                    </tr>
                     
                        <tr>
                 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($b->MajorCd == NULL) && ($b->MajorMinor != NULL))
                        {
                                echo  strtoupper($b->MajorMinor);
                        }
                        elseif (($b->MajorCd != NULL) && ($b->MajorMinor != NULL))  {
                            echo   strtoupper($b->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($b->major->MajorMinor);
                        }
                        ?></td></tr>
                      
                    
                     <tr> 
                                
                        <th style="width:10%" align="right">MOD PENGAJIAN</th>
                        <td style="width:20%">
                            
                                  <?php if($b->modeID)
                                  {echo strtoupper($b->mod->studyMode);}
                                  
                                  else{
                                      echo "Tiada Maklumat";
                                  }
?></td></tr>
                     
                      <tr> 
                                
                        <th style="width:10%" align="right">TAJUK PENYELIDIKAN</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($b->tajuk_tesis); ?></td></tr>
                        <tr> 
                                
                        <th style="width:10%" align="right">NAMA PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($b->nama_penyelia); ?></td></tr>
                          <tr> 
                                
                        <th style="width:10%" align="right">EMEL PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo ($b->emel_penyelia); ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($b->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($b->tarikhtamat)?> (<?= strtoupper($b->tempohpengajian);?>)</td>
                        </tr>
                        <tr>
                        <th style="width:10%" align="right">BIASISWA:</th>
                        <td><?= ucwords(strtoupper($model->tajaan->nama_tajaan)); ?></td> 
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
   <h5><strong><i class="fa fa-th-list"></i> MAKLUMAT PELANJUTAN TERDAHULU</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
<div>
<form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   <thead style="background-color:lightseagreen;color:white">
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
            <th>TARIKH PELANJUTAN CUTI BELAJAR </th>
            <th class="column-title text-center">TEMPOH </th>
            <th class="column-title text-center">PELANJUTAN KALI KE</th>
            <th class="column-title text-center">JUSTIFIKASI</th>

        </tr>
        
        
        

    </thead>
    <tbody>
        
         <?php if($b->lanjutan){ ?>
        <?php $bil=1; foreach ($b->lanjutan as $l) { ?>
<tr>
<td class="text-center"><?= $bil++ ?></td>
<td> <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?></td>
<td class="text-center">

<?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->tempohlanjutan)?></td>

<td class="text-center"><?= $l->idlanjutan; ?></td>

<td class="text-center"><?= $l->justifikasi; ?></td>

            
</tr>
        <?php }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
         
        
        



 </table>
</form>           </div>
</div>
<div class="x_panel">   <div class="x_content">
        <div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PRESTASI PENGAJIAN (TERKINI)</strong><br><br>
       </h5>

            

   
   
</div>
<div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped "> 
                   
                     <tr class="headings">
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white" >BIL</th>
                        <th class="column-title text-center" width="30%"  style="background-color:lightseagreen;color:white">PERKARA</th>
                        <th class="column-title text-center" width="30%" style="background-color:lightseagreen;color:white">PERATUSAN/ TARIKH/ BILANGAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">ULASAN</th>

                    </tr>
                     <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:lightblue;">PENYELIDIKAN:</th>
                    
                </tr>
             <?php
                            if ($doktoral) 
                            { $no=0;?>
                            
                                <?php foreach ($doktoral as $dok) { 
                                    
                                    if($dok->id < 7)
                                    {
                                      
                                    $no++; 
//                                 $mod = \app\models\cbelajar\TblPrestasi::find()->where(['id' => $dok->id, 'idLanjutan'=> 37, 'iklan_id'=>15])->one();
//                                   $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $dok->syarat_id, 'icno' => $icno, 'iklan_id'=>$kontrak->iklan_id])->one();
                                  $mod = \app\models\cbelajar\TblPrestasi::find()->where(['idPrestasi' => $dok->id, 'idLanjutan'=>$model->id,'iklan_id'=>$iklan->id])->one();

                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center"><?php echo $dok->prestasi; ?></td>
                                    <td class="text-center"><?php echo $mod->catatan; ?></td>
                                    <td class="text-center"><?php echo $mod->komen; ?></td>

                                </tr>
                                
                                
                                    <?php 
                                    
                                }}?>
                 <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:lightblue;">KERJA KURSUS:</th>
                    
                </tr>
                
                     <?php foreach ($doktoral as $dok) { 
                                    if($dok->id >= 7)
                                    {
                                  
                                    $no++; 
                                  $mod = \app\models\cbelajar\TblPrestasi::find()->where(['idPrestasi' => $dok->id, 'idLanjutan'=>$model->id,'iklan_id'=>$iklan->id])->one();

                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center"><?php echo $dok->prestasi; ?></td>
                                    <td class="text-center"><?php echo $mod->catatan; ?></td> 
                                    <td class="text-center"><?php echo $mod->komen; ?></td> 

                                   
                                </tr>
                                
                                
                                    <?php 
                                    
                                    }
                                    }
                               
//                             }
                            }
                            ?>

                   
            

                    
                    

                     
                </table>
    <p align="right">  <?= Html::a('Kemaskini Maklumat', ['update', 'id'=>$mod->iklan_id, 'i'=>$mod->idlanjutan], ['class' => 'btn btn-warning btn-xs']) ?> </p>
</div> </div></div>

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="x_panel">
<div class="x_panel">
    <div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
       </h5>
   
   
</div>
        <div class="x_content">
            <p align ="left"><?php // Html::a('KEMASKINI <i class="fa fa-pencil" aria-hidden="true"></i>', ['', 'id' => $eduhighest->id],
//  ['class' => 'btn btn-default'])
           echo Html::button('KEMASKINI <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-semakan?id='.$model->iklan_id.'&i='.$model->id]),
                     'class' => 'btn btn-primary btn-sm mapBtn'])                               
                   ;?> </p>
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table"> 
                <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>PELANJUTAN BAHARU YANG DIPOHON</center></th>
                <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>
                    SEMAKAN</center></th>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TEMPOH MASA (BULAN):</th>
                        <td colspan="10"> <?= $model->tempohlanjutan;?> <b></b></td>
                        <td colspan="50"></td> 
                    </tr>
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH MULA PELANJUTAN</th>
                        <td colspan="10"><?= strtoupper($model->stlanjutan) ?> HINGGA <?= strtoupper($model->ndlanjutan) ?> 
                        <td colspan="50"></td> 

                    </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JUSTIFIKASI PELANJUTAN:</th>
                        <td colspan="10" style='white-space:pre-line;'> <?= $model->justifikasi;?></td>
                        <td colspan="50"></td> 
                    </tr>
                 <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SURAT SOKONGAN DAN PERAKUAN PENYELIA:</th>
                        
                     
                                             
<td class="text-justify">
                            <?php if($model->dokumen_sokongan)
                            {?>
                            <a class="form-control" style="background-color: 
                                             transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" > <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
                            <?php }else{
                                
                                echo 'Tiada Maklumat';
                            }
?> </td> 
                        <?php if($model->c4 == NULL)
{?>
                         <td colspan="30"> 
            <?= $form->field($model,'c4')->
            dropDownList(['1' => 'DISAHKAN',
                          '2' => 'TIDAK MEMENUHI KRITERIA',
                        
                
                          
                        ])->label(false);
?></td> <?php } 
elseif ($model->c4 == 1)
{ ?>

    <td colspan="50"  class="text-center"><i class="fa fa-check-square fa-lg"></i></td><?php } 
elseif ($model->c4 == 2)
{ ?>

    <td colspan="50" class="text-center"><br><i class="fa fa-times fa-lg"></i></td>

   
<?php }?> 


               
                        

                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">PERANCANGAN PENGAJIAN (STUDY PLAN) TERDAHULU:</th>
                        
                     
                                           
<td class="text-justify">
                            <?php if($model->dokumen)
                            {?>
                            <a class="form-control" style="background-color: 
                                             transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen), true); ?>" target="_blank" > <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
                            <?php }else{
                                
                                echo 'Tiada Maklumat';
                            }
?> </td> 
 <?php if($model->c3 == NULL)
{?>
                         <td colspan="30"> 
            <?= $form->field($model,'c3')->
            dropDownList(['1' => 'DISAHKAN',
                          '2' => 'TIDAK MEMENUHI KRITERIA',
                        
                
                          
                        ])->label(false);
?></td> <?php } 
elseif ($model->c3 == 1)
{ ?>

    <td colspan="50"  class="text-center"><i class="fa fa-check-square fa-lg"></i></td><?php } 
elseif ($model->c3 == 2)
{ ?>

    <td colspan="50" class="text-center"><br><i class="fa fa-times fa-lg"></i></td>

   
<?php }?> 

   
               
                        

                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">PERANCANGAN PENGAJIAN YANG DIUBAHSUAI:<br>
                          <small><i>MENGAMBIL KIRA TEMPOH PELANJUTAN YANG DIPOHON</th>
                        
                     
                                 <td class="text-justify">
                            <?php if($model->dokumen2)
                            {?>
                            <a class="form-control" style="background-color: 
                                             transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen2), true); ?>" target="_blank" > <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
                            <?php }else{
                                
                                echo 'Tiada Maklumat';
                            }
?> </td> 
 <?php if($model->c2 == NULL)
{?>
  <td colspan="30"> 
            <?=  $form->field($model,'c2')->
            dropDownList(['1' => 'DISAHKAN',
                          '2' => 'TIDAK MEMENUHI KRITERIA',
                        
                
                          
                        ])->label(false);?>
</td> <?php } 
elseif ($model->c2 == 1)
{ ?>

    <td colspan="50"  class="text-center"><i class="fa fa-check-square fa-lg"></i></td><?php } 
elseif ($model->c2 == 2)
{ ?>

    <td colspan="50" class="text-center"><br><i class="fa fa-times fa-lg"></i></td>

   
<?php }?>


 

                        
               
                        

                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">BORANG PERMOHONAN PELANJUTAN BIASISWA KPT:</th>
                        
                     
                        <td colspan="10"> 
                            <?php if($model->dokumen3)
                            {?>
                            <a class="form-control" style="background-color: 
                                             transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen3), true); ?>" target="_blank" > <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
                            <?php }else{
                                
                                echo 'Tiada Maklumat';
                            }
?> </td>
                        <?php if($model->c4 == NULL)
{?>
                         <td colspan="30"> 
            <?= $form->field($model,'c5')->
            dropDownList(['1' => 'DISAHKAN',
                          '2' => 'TIDAK MEMENUHI KRITERIA',
                          '3' => 'TIDAK BERKAITAN',
                        
                
                          
                        ])->label(false);
?></td> <?php } 
elseif ($model->c5 == 1)
{ ?>

    <td colspan="50"  class="text-center"><i class="fa fa-check-square fa-lg"></i></td><?php } 
elseif ($model->c5 == 2)
{ ?>

    <td colspan="50" class="text-center"><br><i class="fa fa-times fa-lg"></i></td>

   
<?php }?> 


               
                        

                        
                    </tr>
                    <tr class="headings">
                        
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN KEMAJUAN PENGAJIAN & TRANSKRIP KEPUTUSAN PEPERIKSAAN:</th>
          <?php 
                  
                  if(($lkk->status_jfpiu == "Tunggu Perakuan") || ($lkk->status_jfpiu == "Diperakukan")) 
                      
                      {?>
                  <td> 
                    <?= Html::a('<i class="fa fa-check  fa-lg aria-hidden="true"   style="color: green"></i> <small>TELAH DIHANTAR</small>', 
                            ['lkk/adminview', "id"=> $lkk->reportID], ['class' => 'btn btn-default btn-xs']) ?>  <?= $lkk->tarikh_hantar; ?>  <br>
                            
                       <?php if($model->upload->dokumen_sokongan2){ ?>     
                            <small><a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                              href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>"
                             target="_blank" ><i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN
                                        </small></u></strong></a></small>
                   <?php   
                    
                      } else{
                          echo '<b>Bukti Transkrip: Tiada Maklumat</b>';
                      }
                      }elseif ($model->upload->dokumen_sokongan2) { ?>
                  
                                  <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                               href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>"
                                                               target="_blank" ><i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN
                                              </small></u></strong></a><br>
 </td>
                                               <?php }
                    
                    
        
       else{
                    ?>
                  
                        <td colspan="8"><b>Tiada Maklumat</b></td>                     
                    
                  <?php  
                }
                
                
?> 
                 
                  <?php if($model->c1 == NULL)
{?>
                         <td colspan="30"> 
            <?= $form->field($model,'c1')->
            dropDownList(['1' => 'DISAHKAN',
                          '2' => 'TIDAK MEMENUHI KRITERIA',
                        
                
                          
                        ])->label(false);
?></td> <?php } 
elseif ($model->c1 == 1)
{ ?>

    <td colspan="50"  class="text-center"><i class="fa fa-check-square fa-lg"></i></td>
        <?php } 
elseif ($model->c1 == 2)
{ ?>

    <td colspan="50" class="text-center"><br><i class="fa fa-times fa-lg"></i></td>
   
<?php }?>                           

                        
                    </tr>
                     
                  
                      <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">DIPERAKUKAN OLEH:</th>
                        <td> <?= $model->namaapp->CONm;?>  </td>

                        
                    </tr>
                    
                    
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS KETUA JABATAN/DEKAN:</th>
                        <td colspan="10"> <?= ucwords(strtoupper($model->status_jfpiu));?> (<?= $model->app_date;?>)  </td>
                         <td colspan="50"></td> 

                        
                    </tr>
                    
                     
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">ULASAN JFPIU:</th>
                        <td colspan="10" style='white-space:pre-line;'> <?= ucwords(strtoupper($model->ulasan_jfpiu));?>  </td>

                        <td colspan="50">
                            
                        </td> 
  
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH MOHON:</th>
                        <td colspan="10"> <?= $model->tarikh_mohon;?>  </td>
                         <td colspan="50"></td> 

                       
                    </tr>
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PERMOHONAN:</th>
                        <td colspan="10"> <?= ucwords(strtoupper($model->status));?>  </td>

                         <td colspan="50"></td> 
      
                    </tr>
                    
                    

                </table>
            </div>  
        
        </div>  </div></div>
<div class="row" > 
    <div class="col-xs-12 col-md-12 col-lg-12"> 

    <div class="x_panel">
        <div class="x_title">
            <h5><strong><i class="fa fa-check-square"></i> PERAKUAN PEMOHON </strong></h5>
           
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <h3 style="color:grey;" ><small><center>Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan.</center></small> </h3>
            <h4 style="color:grey;"><small><center>Tarikh Hantar: <?php echo $model->tarikhmohon;?></center></small></h4><br/>
        </div>
    </div>
</div>
    
</div>
        <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Hasil Semakan</strong></h2>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <p align ="left"><?php // Html::a('KEMASKINI <i class="fa fa-pencil" aria-hidden="true"></i>', ['', 'id' => $eduhighest->id],
//  ['class' => 'btn btn-default'])
           echo Html::button('KEMASKINI <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-semakans?id='.$model->iklan_id.'&i='.$model->id]),
                     'class' => 'btn btn-primary btn-sm mapBtn'])                               
                   ;?> </p>
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
               
                <th scope="col" colspan=12"  style="background-color:white;"><center>SEMAKAN UNIT PENGEMBANGAN PROFESIONALISME</center></th>

                   
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMAKAN PERMOHONAN:
                            </th>
                        <td class="text-justify">                                        
                 <?= strtoupper($model->status_semakan);?> </td>
<tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">CATATAN:</th>
                        <td> <?= strtoupper($model->ulasan_bsm);?> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH SEMAKAN:</th>
                        <td> <?= strtoupper($model->c_date);?> 
</td> 
                    </tr>
                        

                        
                    </tr>

                    
                    

                     
                </table>
      </div>  </div>
        
    </div>
</div>     
</div>
 <div class="row">
  <!-- Semakan Admin BSM -->
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list-alt"></i> Hasil Semakan</strong></h2>
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Semakan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model,'status_semakan')->label(false)->widget(Select2::classname(), [
                        'data' => ['Layak Dipertimbangkan' => 'LAYAK DIPERTIMBANGKAN', 'Tidak Layak Dipertimbangkan'=>'TIDAK LAYAK DIPERTIMBANGKAN', 'Dokumen Tidak Lengkap' => 'DOKUMEN TIDAK LENGKAP'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Dimajukan untuk pertimbangan JK Pengajian Lanjutan Akademik"){
                        $("#ulasan").show();$("#ulasan1").show();
                        }
                        else if($(this).val() == "Dokumen Tidak Lengkap"){
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
          <div class="form-group"  align="center">
            <h5 style="font-size:120%;" class="text-justify"> 
                </h5>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan: <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_bsm')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
        
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
    </div>
</div>
 </div>
     <?php ActiveForm::end(); ?>
   




