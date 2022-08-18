<?php
$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;

$this->registerJs($js);
$this->registerJsFile('@web/js/circleprogress.js');

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\hronline\MajorMinor; 

error_reporting(0);
//$this->title = 'MAKLUMAT PENAJAAN';
$laporan = app\models\cbelajar\TblPengajian::find()->where(['HighestEduLevelCd'=>[211,99,200], 'id'=>$b->id])->all();

?> 

<style>
    @media screen and (min-width: 701px) {
        .app1 {
          width: 280px;}}
     @media screen and (max-width: 700px) {
        .app1 {
          width: 200px;}}
    .app1{
        background-color: #efefef;
        height: 50px;
        white-space: normal;
    }
    div.scrollmenu {
  overflow: auto;
  white-space: nowrap;
}

.labelc{
    font-size: 18px;
}
.canvasc {
    display: block;
    position:absolute;
    top:0;
    left:0;
}
.spanc {
    color:#555;
    display:grid;
    text-align:center;
    font-family:sans-serif;
    font-size:16px;
    height: 100px;
    align-items: center;
}

.appname{
        white-space: normal;
    
}

.table > tbody > tr > td, .table > tfoot > tr > td{
    border-top: none;
}
</style>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
 <div class="row">

       <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
 <div class="row">

<div class="col-md-12 col-sm-12 col-xs-12 "> 
                <p align="right">  <?= Html::a('Kembali', ['cutibelajar/view-rekod'],['class' => 'btn btn-primary btn-sm']) ?></p>

 


<div class="x_panel">

<div class="col-md-12 col-sm-12 col-xs-12"> 

<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
   
</div>
   


     <?php if($b){
//        foreach ($b as $b) {
                
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
                        <?=strtoupper($b->jawatancb->fname) ?></td>
                       
                    </tr>
                    <tr> 
                                  <?php  if(!$b->l){
                                 ?> 
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($b->InstNm); ?></td><?php }?></tr>
                        
                        
                        <?php  if($b->l){  ?> 
                    <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPAT PENGAJIAN ASAL</th>
                        <td style="width:20%">
                            
                         <?php  echo $b->InstNm; ?>
                          
   
                      
                        </td>
                    </tr>
                    <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPAT PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                            
                         <?php  echo $b->l->renewTempat; ?>
                          
   
                      
                        </td>
                  
                       
                            
                                  
                               
                        
                            <?php }?></tr> 
                        
                        <tr> 
                        <th style="width:10%" align="right">NEGARA</th>
                        <td style="width:20%"><?= strtoupper($b->negara->Country)?></td>
                    </tr>
                             
                            
                          <tr> 
                                
                          <th class="col-md-3 col-sm-3 col-xs-12">MOD PENGAJIAN</th>
                        <td>
                            
                                  <?php if($b->modeID)
                                  {echo strtoupper($b->mod->studyMode);}
                                  
                                  else{
                                      echo "Tiada Maklumat";
                                  }
?></td></tr> 
                             
                    <tr> 
                          <?php  if(!$b->t){
                                 ?> 
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
?></td>
                          <?php }?> 
                    </tr>
                    <?php  if($b->t){ 
                      ?> 
                       <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">BIDANG PENGAJIAN ASAL</th>
                        <td style="width:20%">
                            
                         <?php
                        
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
?>
                          
   
                      
                        </td>
                        <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">BIDANG PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                            
                         <?php  if(($b->t->MajorCd == NULL) && ($b->t->MajorMinor != NULL))
                        {
                                echo  strtoupper($b->t->MajorMinor);
                        }
                        elseif (($b->t->MajorCd != NULL) && ($b->t->MajorMinor != NULL))  {
                            echo   strtoupper($b->t->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($b->t->major->MajorMinor);
                        }  ?>
                          
   
                      
                        </td>
                            <?php }?></tr>
                        <tr> 
                        
                        <th style="width:10%" align="right">NAMA PENYELIA</th>
                        <td style="width:40%">
                         <?= strtoupper($b->nama_penyelia)?> </td>
                        </tr>
                        
                        <tr> 
                        
                        <th style="width:10%" align="right">EMEL PENYELIA</th>
                        <td style="width:40%">
                         <?= ($b->emel_penyelia)?> </td>
                        </tr>
                    
                        <tr> 
                        <?php if(!$b->m)
                        {?>
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($b->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($b->tarikhtamat)?> (<?= strtoupper($b->tempohtajaan);?>)</td>
                        </tr><?php }?>
                    
                        <tr> 
                      <?php if($b->m)
                        {?>
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($b->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($b->tarikhtamat)?> (<?= strtoupper($b->tempohtajaan);?>)</td>
                        </tr>
                   <tr> 
                       
                       
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN BAHARU</th>
                        <td style="width:40%">
                        <?= strtoupper($b->m->tarikhm)?> <b>HINGGA</b> 
                        <?= strtoupper($b->m->tarikht)?> (<?= strtoupper($b->m->tempohlanjutant);?>)</td>
                        </tr><?php }?>
                       
                          <?php  if($b->r){  ?> 
                       
                        <tr> 
                            
                         <th style="width:10%" align="right">TARIKH PELARASAN PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                        <?= strtoupper($b->r->tarikhm)?> <b>HINGGA</b> 
                        <?= strtoupper($b->r->tarikht)?> (<?= strtoupper($b->r->tempohlanjutan);?>)
                        </td>
                      
                        </tr>         
                        <tr>    
                        <th style="width:10%" align="right">TEMPOH PENANGGUHAN PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                        <?= strtoupper($b->r->dtstangguh)?> <b>HINGGA</b> 
                        <?= strtoupper($b->r->dtntangguh)?> (<?= strtoupper($b->r->tempohtangguh);?>)
   
                      
                        </td>
                            <?php }?></tr>
                    
                   <tr>
                         <th style="width:10%" align="right">TAJAAN</th>
                         <td style="width:20%">
<?php

echo $b->tajaan->penajaan->penajaan.' - '. $b->tajaan->nama_tajaan;


?>
                         </td>
                    </tr>
             
                    
                    
                    
                    
                    <?php 
                         foreach($b->lanjutan as $l)
                         {
                         ?>
                     <tr>
                         
                        
                         <th style="width:10%" align="right">TARIKH PELANJUTAN <?= $l->idlanjutan?></th>
                        <td style="width:20%">

                            <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?> (<?= strtoupper($l->tempohlanjutan);?>)</td>
                         </tr><?php }?>
                   
                    <tr>  <?php if($b->lapor)
                     {?>
                        <th style="width:10%" align="right">TARIKH LAPOR DIRI</th>
                        <td style="width:20%">
                            <?php 
                         if($b->lapor->dt_lapordiri)
                         {
                         
                                echo strtoupper($b->lapor->dtlapor);
                                
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
                         
                          if($b->lapor->status_pengajian == "SELESAI")
                          {
                              echo '<span class="label label-success">'.($b->lapor->study->status_pengajian).'</span>';
                          }
                           elseif($b->lapor->status_pengajian == "1" )
                          {
                              echo '<span class="label label-success">'.($b->lapor->study->status_pengajian).'</span>';

                          }
                          
                          elseif ($b->lapor->status_pengajian != "SELESAI")
                         {
                             echo '<span class="label label-danger">'.($b->lapor->study->status_pengajian).'</span>';
                         }
                          
                          
                           ?>
                    </tr>
                    <tr><th style="width:10%" align="right">CATATAN</th>
                        <td style="width:20%"><?= strtoupper($b->lapor->catatan)?></td>
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

        </div><?php  }else{?> <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                                    </tr></table>
                            <?php }?></div>
  </div>
</div>

            
  
  
    
    
  
      <?php if(($b->HighestEduLevelCd === 1) ||  ($b->HighestEduLevelCd === 202) || ($b->HighestEduLevelCd === 205) ||
        ($b->HighestEduLevelCd === 11) || ($b->HighestEduLevelCd === 102) || ($b->HighestEduLevelCd === 20)
      )
{?>
<div class="col-md-12 col-sm-12 col-xs-12">
                      <div class='x_panel'>

         
        <div class="x_title">
            <h5><strong><i class="fa fa-th-list"></i> PROGRESS REPORT LIST</strong></h5>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             
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
                        <th class="column-title text-center">ACTION</th>


                    </tr>
                </thead>
                <tbody>
                    <?php 
//                    echo $pengajian->tarikh_mula;

                    
                     $sem = app\models\cbelajar\TblLkk::Semlkk($model->ICNO);
                    $effectiveDate = $b->tarikh_mula;
                    foreach($lkk as $lkk)
                    {
//                        echo round($sem);
                       ?>  <tr>
                            
                             <td style="width:5%;"> 
                        <?= $lkk->semester;?>  </td>
                             <td style="width:5%;"> 
                         <?php if($lkk->session == NULL)
                         {
                             echo "-";
                         }
                         else
                         {
                            echo '<u>'.Html::a($lkk->session, 
    ['lkk/pengesahan?id= '.$lkk->reportID.'&?icno= '.$icno],[
                                        
                                        'target' => '_blank',
                                    ]).'</u>' ?>
                          <?php       }?>
                    
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
         <?php   } elseif($lkk->status_bsm =="Diperakukan") {?>
             <?= Html::a('<i class="fa fa-print  aria-hidden="true"  ></i>', 
    ['lkk/print-report', "id"=> $lkk->reportID],[
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]) ?>
            
         <?php   }
         else{
             echo '-';
         }
?>
    
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
</div>                <?php }
else{
?>
</div>
          

    <div class="col-md-12 col-sm-12 col-xs-12">
     <div class="x_panel">

        <div class="x_title">
            <h5><strong><i class="fa fa-university"></i> LAPORAN AKHIR </strong></h5>
            <!--             <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
                        </ul>-->
            <div class="clearfix"></div>
        </div>

        <div class="x_content">

            <div class="table-responsive">
                <table class="table table-bordered jambo_table">
                    <thead>
                        <tr class="headings">
                            <th class="column-title text-center">BIL</th>
                            <th class="text-center">GRED SEMASA  </th>
                            <th class="text-center">PERINGKAT PENGAJIAN  </th>
                            <th class="text-center">TARIKH PENGAJIAN </th>
                            <th class="text-center">UNIVERSITI/INSTITUSI</th>
                            <th class="text-center">STATUS PENGAJIAN </th>
                            <th class="text-center">LAPORAN AKHIR </th>

    <!--                        <th class="text-center">Baki Bon Perkhidmatan (Tahun) </th>-->


                        </tr>
                    </thead>
                    <?php
                    if ($laporan) {
                        $counter = 0;
                        foreach ($laporan as $pengajian) {
                            $counter = $counter + 1;
                            ?>

                            <tr>

                                <td width="1%"><?= $counter; ?></td>
                                <td class="text-center"> 
                                    <small><?= $pengajian->gred;
                            ?></small></td>
                                <td class="text-center"> <?php
                                    if ($pengajian->tahapPendidikan) {
                                        echo '<small>' . strtoupper($pengajian->tahapPendidikan) . '</small>';
                                    }
                                    ?></td>
                                <td class="text-center"><small><?= strtoupper($pengajian->tarikhmula) ?> HINGGA
                                        <?= strtoupper($pengajian->tarikhtamat) ?><br> 
                                        (<?= strtoupper($pengajian->tempohtajaan); ?>)</small></td>
                                <?php if ($pengajian->l) { ?> 


                                    <td class="text-center">

                                        <small><?php echo $pengajian->l->renewTempat; ?></small>



                                    </td>


                                    <?php
                                } else {
                                    ?>
                                    <td class="text-center">
                                        <small><?= $pengajian->InstNm; ?></small></td>

                                <?php }
                                ?>

                                <td class="text-center">

                                    <?php
                                    if ($pengajian->lapor->study->status_pengajian && $pengajian->lapor->agree == 1) {
                                        echo '<span class="label label-success">' . ($pengajian->lapor->study->status_pengajian) . '</span><br><small><b>'
                                        . strtoupper($pengajian->lapor->dt_lapordiri) . '</small></b>';
                                    } 
                                    elseif ($pengajian->lapor->status_a == "MANUAL") {
                                        echo '<span class="label label-success">' . ($pengajian->lapor->status_pengajian) . '</span><br><small><b>'
                                        . strtoupper($pengajian->lapor->dt_lapordiri) . '</small></b>';
                                    } 
                                    ?>
                               

                                     <?php if ($pengajian->lapor->upload->dokumen5) { ?>
                            <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($pengajian->lapor->upload->dokumen5), true); ?>" target="_blank" >
                                    <i class="fa fa-download"></i>  </a><br>                            
    <?php
    } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>' . '<br>';
    }
    ?>
                            </td>



                            </tr>

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="8" class="text-center">Tiada Rekod</td>                     
                        </tr>
                    <?php }
                    ?>
                </table>

            </div>
        </div>
    </div>  

</div>

    <?php }?>

