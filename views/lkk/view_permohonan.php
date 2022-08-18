<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// use dosamigos\datepicker\DatePicker;
// use yii\web\UploadedFile;
// use yii\helpers\ArrayHelper;
error_reporting(0);
?>

<div class="row">
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>

<div class="col-md-12 col-sm-12 col-xs-12">
   <p align="right"><?= Html::a('Kembali', ['cutibelajar/halaman-pemohon'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
   <div class="x_panel">
                <style>
.w3-table td,.w3-table th,.w3-table-all td,.w3-table-all th
{padding:2px 2px;display:table-cell;text-align:left;vertical-align:top}
</style>

                <div class="alert alert-warning alert-dismissible fade in">
                        <table class="w3-table w3-bordered" style="font-size: 15px; color:black">
                          <h5 style="color:white">
                              <i class="fa fa-question-circle" style="color:white"></i> 
                               MOD PENGAJIAN:</h5>
                          <tr>
                             <td width="50px" height="20px"><center>1.</center></td> 
                        <td><small>MOD PENGAJIAN ADALAH BERDASARKAN SURAT TAWARAN DR./TUAN/PUAN, TETAPI JIKA<strong> ADA SEBARANG PERUBAHAN MOD PENGAJIAN, SILA MOHON PERTUKARAN MOD PENGAJIAN  SECARA ATAS TALIAN </strong></small> <p align="left"> <?= Html::a('KLIK SINI UNTUK MOHON', ['cutibelajar/view-takwim'], 
                                ['class' => 'btn btn-primary btn-sm','target' => "_blank",'title'=> 'Mohon Tukar Mod']) ?> <small> / JIKA ADA KESILAPAN TEKNIKAL, SILA HUBUNGI EN. GORAID J. JOHN (goraidj.john@ums.edu.my) ATAU PN. DAYANG NOORANIZAH MOHD AMIN (anizah@ums.edu.my) UNTUK MEMBUAT PEMAKLUMAN</small> </p> </td>
                          </tr>
                            
                        
                         </table>
                </div>
            </div>
<div class="x_panel">
<!-- < Maklumat Pengajian Yang Dipohon -->
    



<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>      

     <?php if($pengajian){
        foreach ($pengajian as $pengajian) {
                
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
                        <?=strtoupper($biodata->jawatan->fname) ?></td>
                       
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
                            
                         <?php  echo $pengajian->l->renewTempat.  ' ('.$pengajian->l->catatan.')'; ?>
                          
   
                      
                        </td>
                            <?php }?></tr> 
                   
                       
                       
                      <tr> 
                                 
                        <th style="width:10%" align="right">NAMA PENYELIA</th>
                        <td style="width:20%">
                                  <?php if($pengajian->nama_penyelia)
                                  {
                                  echo strtoupper($pengajian->nama_penyelia);}
                                  else{
                                      
                                      echo '<i>Tiada Maklumat</i>';
                                  }
?></td></tr>
                      
                        <tr> 
                                 
                        <th style="width:10%" align="right">EMEL PENYELIA</th>
                        <td style="width:20%">
                                  <?php if($pengajian->emel_penyelia)
                                  {
                                  echo $pengajian->emel_penyelia;}
                                  else{
                                      
                                      echo '<i>Tiada Maklumat</i>';
                                  }
?></td></tr>
                        
                         
                        
                    <tr>
                         <th style="width:10%" align="right">TAJAAN</th>
                         <td style="width:20%">
<?php

if($pengajian->tajaan->jenisCd == 1)
{
    echo $pengajian->tajaan->nama_tajaan;
}
else
{
    echo strtoupper($pengajian->tajaan->penajaan->penajaan);}?></td>                    </tr>
                  
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
                        <?= strtoupper($pengajian->tarikhtamat)?> (<?= strtoupper($pengajian->tempohpengajian);?>)</td>
                        </tr>
                   <tr> 
                       
                       
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN BAHARU</th>
                        <td style="width:40%">
                        <?= strtoupper($pengajian->m->tarikhm)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->m->tarikht)?> (<?= strtoupper($pengajian->m->tempohlanjutan);?>)</td>
                        </tr><?php }?>
                    
                          <?php  if($pengajian->r){  ?> 
                       
                        <tr> 
                            
                         <th style="width:10%" align="right">TARIKH PELARASAN PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                        <?= strtoupper($pengajian->r->tarikhm)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->r->tarikht)?> (<?= strtoupper($pengajian->r->tempohlanjutan);?>)
                        </td>
                      
                        </tr>         
                        <tr>    
                        <th style="width:10%" align="right">TEMPOH PENANGGUHAN PENGAJIAN</th>
                        <td style="width:20%">
                        <?= strtoupper($pengajian->r->dtstangguh)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->r->dtntangguh)?> (<?= strtoupper($pengajian->r->tempohtangguh);?>)
   
                      
                        </td>
                            <?php }?></tr>
                    
                    
                    <?php 
                         foreach($pengajian->lanjutan as $l)
                         {
                         ?>
                     <tr>
                         
                        
                         <th style="width:10%" align="right">TARIKH PELANJUTAN <?= $l->idlanjutan?></th>
                        <td style="width:20%">

                            <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?></td>
                         </tr><?php }?>
                   
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
//                          if($pengajian->lapor->status_pengajian == "SELESAI")
//                          {
//                              echo '<span class="label label-success">'.($pengajian->lapor->status_pengajian).'</span>';
//                          }
//                          
//                          elseif ($pengajian->lapor->status_pengajian != "SELESAI")
//                         {
//                             echo '<span class="label label-danger">'.($pengajian->lapor->status_pengajian).'</span>';
//                         }
                          
                          
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

        </div><?php } }else{?> <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                                    </tr></table>
                            <?php }?></div>
  </div>

</div>
<?php if(($pengajian->HighestEduLevelCd === 1) || ($pengajian->HighestEduLevelCd === 202) || ($pengajian->HighestEduLevelCd === 205) ||
        ($pengajian->HighestEduLevelCd === 11) || ($pengajian->HighestEduLevelCd === 101) || 
        ($pengajian->HighestEduLevelCd === 20) || ($pengajian->HighestEduLevelCd === 200) || ($pengajian->HighestEduLevelCd === 102)
        )
{?>
 <div class="row">

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
      <?php ?>
            
         
        <div class="x_title">
            <h5><strong><i class="fa fa-th-list"></i> SENARAI LAPORAN KEMAJUAN PENGAJIAN (LKP)</strong></h5>
            
            
            
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
            <div class="table-responsive">
                
                
                <p align="right"> <a href="<?php echo yii\helpers\Url::to('@web/files/Tatacara LKP.png'); ?>" target="_blank"  class="btn btn-info btn-md">Manual Pengguna</a>
                    <?php 
?></p>
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">SEMESTER / SESSION </th>
                        <th class="column-title text-center">LAST SUBMISSION DATE</th>
                        <th class="column-title text-center">ACTION</th>
                        <th class="column-title text-center">SUBMISSION DATE</th>
                         <th class="column-title text-center">SUPERVISOR STATUS</th>
                        <th class="column-title text-center">DEAN/DIRECTOR STATUS</th>
                        <th class="column-title text-center">BSM STATUS</th>
                        <th class="column-title text-center">OVERALL PERFORMANCE</th>

                        <th class="column-title text-center">PRINT</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
//                    echo $pengajian->tarikh_mula;

                    
                     $sem = app\models\cbelajar\TblLkk::Semlkk($model->icno);
                    $effectiveDate = $pengajian->tarikh_mula;
//                    for ($i = 1; $i <= round($sem); $i++)
                          if($lkk){
                    foreach ($lkk as $statuss) {
                    
//                        echo round($sem);
                       ?>  <tr>
                            
                             <td style="width:30%;"> <?= $statuss->semester;?>/ <?= $statuss->session;?> </td>
                             <td><span class="label label-danger"><?= 
                             $effectiveDate = date('Y-m-d', strtotime("+6 months", strtotime($effectiveDate)));
                             ; ?></span></td>
                             <td> 
             <?php if($statuss->status_bsm == "Admin Manually Upload")
            {?>
           <?= Html::a('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>', 
    ['lkk/lihat-borang-staff', "id"=> $statuss->reportID], ['class' => 'btn btn-default btn-xs']) ?>
         <?php   }
          elseif ($statuss->open == 2) {?>
             <?= Html::a('<i class="fa fa-edit  fa-lg aria-hidden="true"   style="color: orange"></i><br><small>Update</small>', 
    ['lkk/lihat-permohonan', "id"=> $statuss->reportID]) ?>
         <?php   }
           elseif ($statuss->status_borang != NULL) {?>
             <?= Html::a('<i class="fa fa-edit  fa-lg aria-hidden="true"   style="color: green"></i><br><small>Verify</small>', 
    ['lkk/pengesahan', "id"=> $statuss->reportID.'&icno='.$icno]) ?>
         <?php   }
          
          elseif ($statuss->agree == 1) {?>
             <?= Html::a('<i class="fa fa-check-circle  fa-lg aria-hidden="true"   style="color: green"></i>', 
    ['lkk/lihat-permohonan', "id"=> $statuss->reportID]) ?>
         <?php   }
        
       else {?>
             <?= Html::a('HANTAR LAPORAN', 
    ['lkk/borang-permohonan?id='.$statuss->reportID.'&icno='.$icno], ['class' => 'btn btn-success btn-xs']) ?>
         <?php   }?>
                                
                             
                             </td>
                             <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $icno, 'reportID'=> $statuss])->one();
                                 if($statuss->agree == 1)
                                 {
                                 echo $statuss->tarikh_mohon;
                                 }
                                
                                 else
                                 {
                                     echo "Not Verify Yet";
                                 }
                                 ?>
                             </td>
                              <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $icno, 'reportID'=> $i])->one();
                                 
                                 echo $statuss->statuspenyelia.'<BR>'.$statuss->r_dt;
                                 ?>
                             </td>
                             <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $icno, 'reportID'=> $i])->one();
                                 if($statuss->status_r == "DONE")
                                 {
                                 echo $statuss->statusjfpiu.'<br> '.$statuss->verify_dt;
                                 }
                                 else
                                 {
                                     echo '-';
                                 }
                                 ?>
                             </td>
                               
                             <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $icno, 'reportID'=> $i])->one();
                                 if($statuss->verify_dt)
                                 {
                                                                      echo $statuss->statusbsm;

                                 }
 else {
     echo '-';
 }
                                 ?>
                             </td>
                             <td>
                            <?php 
                     $c = \app\models\cbelajar\Rating::find()->where(['idLkk' => $statuss->reportID,'idKriteria'=>5])->one();
                     $b = \app\models\cbelajar\Rating::find()->where(['idLkk' => $statuss->reportID,'idKriteria'=>7])->one();
                     $a = \app\models\cbelajar\Rating::find()->where(['idLkk' => $statuss->reportID,'idKriteria'=>6])->one();
                     $d = \app\models\cbelajar\Rating::find()->where(['idLkk' => $statuss->reportID,'idKriteria'=>4])->one();
                     $e = \app\models\cbelajar\Rating::find()->where(['idLkk' => $statuss->reportID,'idKriteria'=>3])->one();
                     $f = \app\models\cbelajar\Rating::find()->where(['idLkk' => $statuss->reportID,'idKriteria'=>2])->one();
                     $g = \app\models\cbelajar\Rating::find()->where(['idLkk' => $statuss->reportID,'idKriteria'=>1])->one();
                     $total = ($a->p_komen + $b->p_komen + $c->p_komen + $d->p_komen
                                  + $e->p_komen + $f->p_komen + $g->p_komen);                                
                    if($statuss->status_r =="DONE" && $statuss->status_jfpiu == "Diperakukan")
                                 {?>
                                    <strong style="color:red"><?= round(($total / 56) * 100) ;?>%
                                    </strong><br/>
                                    
                                     
                                    
                          <?php  }                                ?> </td>
                             
                             <td>
                                 <?php if($statuss->status_bsm == "Diperakukan"){?>
                                       <?= Html::a('<i class="fa fa-print  aria-hidden="true"  ></i>', 
    ['lkk/print-report', "id"=> $statuss->reportID],[
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]) ?>
                             <?php    }?>
                             </td>    
            </tr>
            
                <?php 
                          }}
                        ?>
                </tbody>
            </table>
           
        </div>
              
        </div>
         
    </div>
</div>
</div>

<?php }

 elseif(($pengajian->HighestEduLevelCd === 210)
        )
{?>
 <div class="row">

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
      <?php ?>
            
         
        <div class="x_title">
            <h5><strong><i class="fa fa-th-list"></i> SENARAI LAPORAN KEMAJUAN PENGAJIAN (LKP)</strong></h5>
            
            
            
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
            <div class="table-responsive">
                
                
                <p align="right"> <a href="<?php echo yii\helpers\Url::to('@web/files/Tatacara LKP.png'); ?>" target="_blank"  class="btn btn-info btn-md">Manual Pengguna</a>
                    <?php 
?></p>
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
 
<!--                <th colspan="2" style="background-color:lightseagreen;color:white"><center>-->
                    <tr class="headings" style="background-color:lightseagreen;color:white">
                        <th class="column-title text-center">BULAN </th>
                        <th class="column-title text-center">TARIKH AKHIR PENGHANTARAN </th>
                        <th class="column-title text-center">TINDAKAN</th>
                        <th class="column-title text-center">TARIKH HANTAR</th>
                        <th class="column-title text-center">STATUS DEKAN/PENGARAH</th>
                        <th class="column-title text-center">STATUS BSM</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
//                    echo $pengajian->tarikh_mula;

                    
                     $sem = app\models\cbelajar\TblLkk::Semlkk($model->icno);
                    $effectiveDate = $pengajian->tarikh_mula;
//                    for ($i = 1; $i <= round($sem); $i++)
                          if($lkk){
                    foreach ($lkk as $statuss) {
                    
//                        echo round($sem);
                       ?>  <tr>
                            
                             <td style="width:30%;"> 
                        <?php if($statuss->semester == 1){
                            
                            echo '<span class="label label-success">AWAL BULAN KE-3</span>';
                        }
                        elseif($statuss->semester == 2){?>
                            
                          <?php  echo '<span class="label label-success">AWAL BULAN KE-6</span>';
                        }
                        else{?>
                    
 <?php echo '<span class="label label-success">AWAL BULAN KE-9</span>';?> <?php                      }
?>
                       </td>
                             <td><span class="label label-danger"><?= 
                             $effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($effectiveDate)));
                             ; ?></span></td>
                             <td> 
             <?php if($statuss->status_bsm == "Admin Manually Upload")
            {?>
           <?= Html::a('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>', 
    ['lkk/lihat-borang-staff', "id"=> $statuss->reportID], ['class' => 'btn btn-default btn-xs']) ?>
         <?php   }
          elseif ($statuss->open == 2) {?>
             <?= Html::a('<i class="fa fa-edit  fa-lg aria-hidden="true"   style="color: orange"></i><br><small>Update</small>', 
    ['lkk/lihat-permohonan', "id"=> $statuss->reportID]) ?>
         <?php   }
           elseif ($statuss->status_borang != NULL) {?>
             <?= Html::a('<i class="fa fa-edit  fa-lg aria-hidden="true"   style="color: green"></i><br><small>Verify</small>', 
    ['lkk/lihat-lkp-ir', "id"=> $statuss->reportID.'&icno='.$icno]) ?>
         <?php   }
          
          elseif ($statuss->agree == 1) {?>
             <?= Html::a('<i class="fa fa-check-circle  fa-lg aria-hidden="true"   style="color: green"></i>', 
    ['lkk/lihat-permohonan', "id"=> $statuss->reportID]) ?>
         <?php   }
        
       else {?>
             <?= Html::a('HANTAR LAPORAN', 
    ['lkk/borang-lkp-latihan-industri?id='.$statuss->reportID.'&icno='.$icno], ['class' => 'btn btn-success btn-xs']) ?>
         <?php   }?>
                                
                             
                             </td>
                             <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $icno, 'reportID'=> $statuss])->one();
                                 if($statuss->agree == 1)
                                 {
                                 echo $statuss->tarikh_mohon;
                                 }
                                
                                 else
                                 {
                                     echo "Not Verify Yet";
                                 }
                                 ?>
                             </td>
                            
                             <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $icno, 'reportID'=> $i])->one();
                                
                                 echo $statuss->statusjfpiu.'<br> '.$statuss->verify_dt;
                               
                                 ?>
                             </td>
                               
                             <td>
                                 <?php 
                                 
//                                 $lkk = app\models\cbelajar\TblLkk::find()->where(['icno'=> $icno, 'reportID'=> $i])->one();
                                 if($statuss->verify_dt)
                                 {
                                                                      echo $statuss->statusbsm;

                                 }
 else {
     echo '-';
 }
                                 ?>
                             </td>
                              
            </tr>
            
                <?php 
                          }}
                        ?>
                </tbody>
            </table>
           
        </div>
              
        </div>
         
    </div>
       <div class="x_panel">
                <style>
.w3-table td,.w3-table th,.w3-table-all td,.w3-table-all th
{padding:2px 2px;display:table-cell;text-align:left;vertical-align:top}
</style>

                <div class="alert alert-info alert-dismissible fade in">
                        <table class="w3-table w3-bordered" style="font-size: 15px; color:white">
                        
                          <tr>
<!--                             <td width="50px" height="20px"><center>1.</center></td> -->
                              <td><small><b>LAPORAN AKHIR LATIHAN INDUSTRI ANDA WAJIB DIHANTAR KETIKA MENGISI BORANG LAPOR DIRI</b></small> </p> </td>
                          </tr>
                            
                        
                         </table>
                </div>
            </div>
</div>
</div>

<?php }
else{
?>
    <div class="row">
<div class="col-md-12 col-sm-12 col-xs12">
      
    <div class="x_panel">
         
        <div class="x_title">
            <h2><strong><i class="fa fa-th-list"></i> SENARAI LAPORAN KEMAJUAN PENGAJIAN (LKP)</strong></h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <div class="x_panel">
                <style>
.w3-table td,.w3-table th,.w3-table-all td,.w3-table-all th
{padding:2px 2px;display:table-cell;text-align:left;vertical-align:top}
</style>

                <div class="alert alert-success alert-dismissible fade in">
                        <table class="w3-table w3-bordered" style="font-size: 15px; color:black">
                          <h5 style="color:white">
                              <i class="fa fa-question-circle" style="color:white"></i> 
                               CUTI SABATIKAL/POS DOKTORAL/LATIHAN INDUSTRI/PRA-WARTA/LATIHAN PENYELIDIKAN:</h5>
                          <tr>
                             <td width="50px" height="20px"><center>1.</center></td> 
                        <td>LAPORAN AKHIR WAJIB DISERTAKAN DALAM BORANG LAPOR DIRI. <?= Html::a('KLIK SINI UNTUK MOHON', ['cutibelajar/senarai-borang-lapor'], 
                                ['class' => 'btn btn-primary btn-sm','target' => "_blank",'title'=> 'Laporan Akhir']) ?></td>
                          </tr>
                            
                        
                         </table>
                </div>
            </div>
           
            
              
        
         
    </div>
        
            
        </div>
</div>
</div><?php }?>
<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel">
<ul>
    <li><i class="fa fa-file-pdf-o" aria-hidden="true"></i> : <strong>LKK DIMUATNAIK OLEH ADMIN</strong></li>
    <li><i class="fa fa-check-square-o" aria-hidden="true"></i> : <strong>LKK BERJAYA DIHANTAR</strong></li>
    <li><span class="label label-success">TELAH DISEMAK</span> : <strong>LKK TELAH DISEMAK</strong></li> 
<!--                <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>-->
            </ul>
    </div>
        </div></div>

       </div>     