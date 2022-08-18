<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Maklumat Dan Rekod Kakitangan';
error_reporting(0);
?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div>
            <p align="right">  <?= Html::a('Back', ['cbadmin/search-lkk'], ['class' => 'btn btn-primary btn-sm']) ?></p>
        </div>
        <div class="x_title">
   <h5 ><strong><i class="fa fa-user"></i> MAKLUMAT PERIBADI</strong></h5>
   
   
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
                <h5><?=  strtoupper($biodata->CONm); ?></h5>
                </th>
                </tr>  
                <tr>
                    <th colspan="4" class="text-center"> 
                        <?= strtoupper($biodata->jawatan->fname);?> | 
                        <?= strtoupper($biodata->department->fullname);?>
                    </th> 
                </tr>
                </thead>
                <tbody>

                    <tr> 
                        <th style="width:20%">ICNO</th>
                        <td style="width:20%"><?= $biodata->ICNO; ?></td> 
                        <th>UMSPER</th>
                        <td><?= $biodata->COOldID; ?></td>  

                    </tr>
                    <tr> 

                       
                        <th style="width:20%">TARIKH LANTIKAN</th>
                        <td style="width:20%"><?= $biodata->displayStartLantik; ?></td>
                       <th width="20%">TARAF PERKAHWINAN: </th>
                       <td><?= strtoupper($biodata->displayTarafPerkahwinan) ?></td> 

                    </tr>
                    <tr> 

                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                                    if ($biodata->confirmDt) {
                                        echo $biodata->confirmDt->tarikhMula;
                                    } else {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?></td>
                        <th style="width:20%">TEMPOH BERKHIDMAT SEMASA</th>
                        <td style="width:20%"><?= strtoupper($biodata->servPeriodPermanent);  ?></td>


                    </tr>
                     
                    <tr> 
                        
                        <th>EMEL</th>
                        <td><?= $biodata->COEmail; ?></td> 
                        <th style="width:20%">NO. TELEFON</th>
                        <td style="width:20%"><?= $biodata->COHPhoneNo; ?></td>
                    </tr>
                    
                    
                     
                </tbody>
            </table> 
        </div> 
        <br/>

    </div>
</div> 
 </div>



<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
   
</div>
   


     <?php if($pengajian){
//        foreach ($b as $b) {
                
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive">
                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th colspan="2" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($pengajian->tahapPendidikan)
                                {
                                 echo strtoupper($pengajian->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                                <tr> 
                        <th style="width:10%" align="right">JAWATAN SEMASA CUTI BELAJAR</th>
                        <td style="width:20%">
                        <?=strtoupper($pengajian->jawatancb->fname) ?></td>
                       
                    </tr>
                    <tr> 
                                  <?php  if(!$pengajian->l){
                                 ?> 
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($pengajian->InstNm); ?></td><?php }?></tr>
                        
                        
                        <?php  if($pengajian->l){  ?> 
                       <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPAT PENGAJIAN ASAL</th>
                        <td style="width:20%">
                            
                         <?php  echo $pengajian->InstNm; ?>
                          
   
                      
                        </td>
                        <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPAT PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                            
                         <?php  echo $pengajian->l->renewTempat.  ' ('.$b->pengajian->l->catatan.')'; ?>
                          
   
                      
                        </td>
                            <?php }?></tr> 
                        
                        <tr> 
                        <th style="width:10%" align="right">NEGARA</th>
                        <td style="width:20%"><?= strtoupper($pengajian->negara->Country)?></td>
                    </tr>
                             
                            
                           
                             
                    <tr> 
                          <?php  if(!$pengajian->t){
                                 ?> 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($pengajian->MajorCd == NULL) && ($pengajian->MajorMinor != NULL))
                        {
                                echo  strtoupper($pengajian->MajorMinor);
                        }
                        elseif (($pengajian->MajorCd != NULL) && ($pengajian->MajorMinor != NULL))  {
                            echo   strtoupper($pengajian->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($pengajian->major->MajorMinor);
                        }
?></td>
                          <?php }?> 
                    </tr>
                    <?php  if($pengajian->t){ 
                      ?> 
                       <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">BIDANG PENGAJIAN ASAL</th>
                        <td style="width:20%">
                            
                         <?php
                        
                        if(($pengajian->MajorCd == NULL) && ($pengajian->MajorMinor != NULL))
                        {
                                echo  strtoupper($pengajian->MajorMinor);
                        }
                        elseif (($pengajian->MajorCd != NULL) && ($pengajian->MajorMinor != NULL))  {
                            echo   strtoupper($pengajian->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($pengajian->major->MajorMinor);
                        }
?>
                          
   
                      
                        </td>
                        <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">BIDANG PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                            
                         <?php  if(($pengajian->t->MajorCd == NULL) && ($pengajian->t->MajorMinor != NULL))
                        {
                                echo  strtoupper($pengajian->t->MajorMinor);
                        }
                        elseif (($b->pengajian->t->MajorCd != NULL) && ($pengajian->t->MajorMinor != NULL))  {
                            echo   strtoupper($pengajian->t->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($pengajian->t->major->MajorMinor);
                        }  ?>
                          
   
                      
                        </td>
                        
                            <?php }?></tr>
                         <tr>
                         <th style="width:10%" align="right">TAJAAN</th>
                         <td style="width:20%">
<?php

echo $pengajian->tajaan->penajaan->penajaan.' - '. $pengajian->tajaan->nama_tajaan;


?>
                         </td>
                    </tr>
                        <tr> 
                        <?php if(!$pengajian->m)
                        {?>
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($pengajian->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->tarikhtamat)?> (<?= strtoupper($pengajian->tempohtajaan);?>)</td>
                        </tr><?php }?>
                    
                        <tr> 
                      <?php if($pengajian->m)
                        {?>
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($pengajian->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->tarikhtamat)?> (<?= strtoupper($pengajian->tempohtajaan);?>)</td>
                        </tr>
                   <tr> 
                       
                       
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN BAHARU</th>
                        <td style="width:40%">
                        <?= strtoupper($pengajian->m->tarikhm)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->m->tarikht)?> (<?= strtoupper($pengajian->m->tempohlanjutan);?>)</td>
                        </tr><?php }?>
                     <?php 
                         foreach($pengajian->lanjutan as $l)
                         {
                         ?>
                     <tr>
                         
                        
                         <th style="width:10%" align="right">TARIKH PELANJUTAN <?= $l->idlanjutan?></th>
                        <td style="width:20%">

                            <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?> (<?= strtoupper($l->tempohlanjutan);?>)</td>
                         </tr><?php }?>
                         <?php if($pengajian->r->dtstangguh){?> 
                         <tr>    
                        <th style="width:10%" align="right">TEMPOH PENANGGUHAN PENGAJIAN</th>
                        <td style="width:20%">
                        <?= strtoupper($pengajian->r->dtstangguh)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->r->dtntangguh)?> (<?= strtoupper($pengajian->r->tempohtangguh);?>)
                         <?php } else{
                             echo '-';
                         }?>
                      
                        </td>
                            <?php }?></tr>
                          <?php  if($pengajian->r){  ?> 
                       
                        <tr> 
                            
                         <th style="width:10%" align="right">TARIKH PELARASAN PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                        <?= strtoupper($pengajian->r->tarikhm)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->r->tarikht)?> (<?= strtoupper($pengajian->r->tempohlanjutan);?>)
                          <?php }?> </td>
                      
                        </tr>         
                        
                    
                  
             
                    
                    
                    
                    
                   
                   
                    <tr>  <?php if($pengajian->lapor)
                     {?>
                        <th style="width:10%" align="right">TARIKH LAPOR DIRI</th>
                        <td style="width:20%">
                            <?php 
                         if($pengajian->lapor->dt_lapordiri)
                         {
                         
                                echo strtoupper($pengajian->lapor->dtlapor);
                                
                         }
                         
                         else
                         {
                             echo '<span class="label label-danger">TIADA MAKLUMAT</span>';
                         }
                             ?></td>
                    </tr>
                    
                     <tr>
                        
                   <th style="width:10%" align="right">STATUS PENGAJIAN</th>
                         
                         <td style="width:20%">
                             
                          <?php
                         
                           if($pengajian->lapor->study->status_pengajian)
                          {
                            echo '<span class="label label-success">'.($pengajian->lapor->study->status_pengajian).'</span>';

                              
                          }
                          else
                          {
                             echo '<span class="label label-danger">'.($pengajian->lapor->status_pengajian).'</span>';
                          }
                          
                           ?>
                    </tr>
                    <tr><th style="width:10%" align="right">CATATAN</th>
                        <td style="width:20%"><?= strtoupper($pengajian->lapor->catatan)?></td>
                     <?php }?>
                    </tr>
                    
                     
                                
<!--                                <tr class="headings">
                                    <th class="column-title text-center">Telah Dimuatnaik</th>
                                    <th class="column-title text-center">Belum Dimuatnaik</th>
                                </tr>-->
                            </thead>
                        
                                     
<!--                                   // <td class="text-center">
                                        <?//php
                                   if (!$k->namafile)
                                       {
                                     echo '&#10008;'; }?></td>
                                 
                                </tr>-->
                                
                      
                        </table>
                    </div> 

        </div>
  </div>
</div>
    
<?php if(($pengajian->HighestEduLevelCd === 1) ||  ($pengajian->HighestEduLevelCd === 202) || ($pengajian->HighestEduLevelCd === 205) ||
        ($pengajian->HighestEduLevelCd === 11) || ($pengajian->HighestEduLevelCd === 102) || ($pengajian->HighestEduLevelCd === 20) || ($pengajian->HighestEduLevelCd === 200)
      )
{?>
<div class="col-md-12 col-sm-12 col-xs-12">
      
    <div class="x_panel">
         
        <div class="x_title">
            <h5><strong><i class="fa fa-th-list"></i> PROGRESS REPORT LIST</strong></h5>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <p align="left"> 
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-lkk?id='.$id,
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
             
          
            </p>
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead style="background-color:lightseagreen;color:white">
                    <tr class="headings">
                        <th class="column-title text-center">SEMESTER</th>
                        <th class="column-title text-center" style="width:130px">SESSION</th>
                        <th class="column-title text-center">LAST SUBMISSION DATE</th>
                        <th class="column-title text-center">SUBMISSION DATE</th>
                        <th class="column-title text-center">SUPERVISOR STATUS</th>
                        <th class="column-title text-center">DEAN STATUS</th>

                        <th class="column-title text-center">BSM STATUS</th>
                        <th class="column-title text-center">UPLOAD</th>
                        <th class="column-title text-center" style="width:5%;">ACTION</th>


                    </tr>
                </thead>
                <tbody>
                    <?php 
//                    echo $pengajian->tarikh_mula;

                    
                     $sem = app\models\cbelajar\TblLkk::Semlkk($model->ICNO);
                    $effectiveDate = $pengajian->tarikh_mula;
                    foreach($lkk as $lkk)
                    {
//                        echo round($sem);
                       ?>  <tr>
                            
                             <td style="width:5%;"> <?= $lkk->semester;?>  </td>
                             <td style="width:5%;"> 
                       <?php 
                       if($lkk->session == NULL)
                       {
                           echo "-";
                       }
                       else{
                           echo $lkk->session;
                  }?>
                        </td>
                             <td><span class="label label-danger"><?=   $lkk->effectivedt;
//                             $effectiveDate = date('Y-m-d', strtotime("+6 months", strtotime($effectiveDate)));
                              ?></span></td>
                             <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $id, 'reportID'=> $i, 'status_form'=>2])->one();
                                 if($lkk->agree == 1)
                                 {
                                 echo $lkk->tarikh_hantar;
                                 }
                                 else
                                 {
                                     echo '-';
                                 }
                                 ?>
                             </td>
                             <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $id, 'reportID'=> $i, 'status_form'=>2])->one();
                                 if($lkk->agree==1)
                                 {
                                 echo $lkk->statuspenyelia.'<br>'.$lkk->r_dt;
                                 }
                                 else
                                 {
                                     echo '-';
                                 }
                                 ?>
                             </td>
                              <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $id, 'reportID'=> $i, 'status_form'=>2])->one();
                                 if($lkk->status_r == "DONE")
                                 {
                                 echo $lkk->statusjfpiu.'<br>'.$lkk->verify_dt;
                                 }
                                 else
                                 {
                                     echo '-';
                                 }
                                 ?>
                             </td>
                             <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $id, 'reportID'=> $i, 'status_form'=>2])->one();
                                 if($lkk->verify_dt)
                                 {
                                 echo $lkk->statusbsm;
                                 }
                                 else
                                 {
                                     echo '-';
                                 }
                                 ?>
                             </td>
                             
                             
                              
        <td>
            <?php if($lkk->status_bsm == "Admin Manually Upload")
            {?>
           <?= Html::a('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>', 
    ['lkk/lihat-borang', "id"=> $lkk->reportID], ['class' => 'btn btn-default btn-xs']) ?>
         <?php   } else {?>
             <?= Html::a('<i class="fa fa-upload" aria-hidden="true"></i>', 
    ['lkk/borang-sokongan', "id"=> $lkk->reportID], ['class' => 'btn btn-default btn-xs']) ?>
         <?php   }?>
    
        </td>
         <td class="text-center" style="width:30%;">
                    <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                    ['lkk/adminview', "id"=> $lkk->reportID], ['class' => 'btn btn-default btn-xs']) ?> | 
                    <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['up-lkk', 'id' => $lkk->reportID]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> | 
                    <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-lkk?id='.$lkk->reportID], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?> |
         <?= Html::a('<i class="fa fa-bullhorn" aria-hidden="true"></i>', 
    ['notifistaf?id='.$id.'&&n_date='.$lkk->effectivedt], ['class' => 'btn btn-primary btn-xs']) ?>

               
         </td> 
            </tr>
            
                <?php 
                    }
                        ?>
                </tbody>
                
            </table>
           
        </div>
            
              
        
         
    </div>
        
            
        </div>
</div>
</div><?php }
else{
?>
    <div class="row">
<div class="col-md-12 col-sm-12 col-xs12">
      
    <div class="x_panel">
         
        <div class="x_title">
            <h2><strong><i class="fa fa-th-list"></i> LAPORAN AKHIR</strong></h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <p align="left"> 
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-lkk?id='.$id,
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
             
          
            </p>
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">PERKARA</th>
                        
                        <th class="column-title text-center" style="width:130px">TARIKH LAPOR DIRI</th>
<!--                        <th class="column-title text-center">TARIKH AKHIR PENGHANTARAN LAPORAN</th>-->
                        <th class="column-title text-center">TARIKH HANTAR</th>
                        <th class="column-title text-center">STATUS BSM</th>
                        <th class="column-title text-center">MUAT NAIK</th>
                        <th class="column-title text-center" style="width:5%;">TINDAKAN</th>


                    </tr>
                </thead>
                <tbody>
                    <?php 
//                    echo $pengajian->tarikh_mula;

                    
                     $sem = app\models\cbelajar\TblLkk::Semlkk($model->ICNO);
                    $effectiveDate = $pengajian->tarikh_mula;
                    foreach($lkk2 as $lkk)
                    {
//                        echo round($sem);
                       ?>  <tr>
                            
                             <td style="width:5%;">
 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $id, 'reportID'=> $i, 'status_form'=>2])->one();
                                 
                                 echo $lkk->semester;
                                 ?>  </td>
                             <td></td>
                            
                             <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $id, 'reportID'=> $i, 'status_form'=>2])->one();
                                 
                                 echo $lkk->tarikh_hantar;
                                 ?>
                             </td>
                             
                             <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $id, 'reportID'=> $i, 'status_form'=>2])->one();
                                 
                                 echo $lkk->statusbsm;
                                 ?>
                             </td>
                             
                              
        <td>
            <?php if($lkk->status_bsm == "Admin Manually Upload")
            {?>
           <?= Html::a('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>', 
    ['lkk/lihat-borang', "id"=> $lkk->reportID], ['class' => 'btn btn-default btn-xs']) ?>
         <?php   } else {?>
             <?= Html::a('<i class="fa fa-upload" aria-hidden="true"></i>', 
    ['lkk/borang-sokongan', "id"=> $lkk->reportID], ['class' => 'btn btn-default btn-xs']) ?>
         <?php   }?>
    
        </td>
         <td class="text-center" style="width:30%;">
                    <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                    ['lkk/adminview', "id"=> $lkk->reportID], ['class' => 'btn btn-default btn-xs']) ?> | 
                    <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['up-lkk', 'id' => $lkk->reportID]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> | 
                    <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-lkk?id='.$lkk->reportID], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?> |
         <?= Html::a('<i class="fa fa-bullhorn" aria-hidden="true"></i>', ['notifistaf?id='.$id.'&&n_date='.$effectiveDate], ['class' => 'btn btn-primary btn-xs']) ?>

               
         </td> 
            </tr>
            
                <?php 
                    }
                        ?>
                </tbody>
                
            </table>
           
        </div>
            
              
        
         
    </div>
        
            
        </div>
</div>
</div><?php }?>
<!--<div class="col-xs-12 col-md-12 col-lg-12" >
      
    <div class="x_panel">
 <div class="x_title">
            <h2><strong><i class="fa fa-th-list"></i> Senarai Laporan Kemajuan Kursus (LKK) - LANJUTAN</strong></h2>

            <div class="clearfix"></div>
        </div>
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">SEMESTER / SESI </th>
                        <th class="column-title text-center">TARIKH AKHIR PENGHANTARAN LAPORAN</th>
                        <th class="column-title text-center">TARIKH HANTAR</th>
                        <th class="column-title text-center">STATUS LKK</th>
                        <th class="column-title text-center">STATUS BSM</th>
                        <th class="column-title text-center">MUAT NAIK</th>
                        <th class="column-title text-center" style="width:5%;">TINDAKAN</th>


                    </tr>
                </thead>
            </table>
            </div>
        </div></div>-->
