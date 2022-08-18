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
error_reporting(0);
$this->title = 'BON PERKHIDMATAN & TUNTUTAN GANTIRUGI';

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
 <div class="row">
       <?php echo $this->render('/cutibelajar/_topmenu'); ?>

<div class="col-md-12 col-sm-12 col-xs-12 "> 

                          <p align="right">  <?= Html::a('Kembali', ['cbadmin/senarai-bon'], ['class' => 'btn btn-primary btn-sm']) ?></p>


      <div class="x_panel">



   
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
                        elseif (($pengajian->t->MajorCd != NULL) && ($pengajian->t->MajorMinor != NULL))  {
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
                         
                          if($pengajian->lapor->status_pengajian == "SELESAI" )
                          {
                              echo '<span class="label label-success">'.($pengajian->lapor->status_pengajian).'</span>';
                          }
                          elseif($pengajian->lapor->status_pengajian == "1" )
                          {
                              echo '<span class="label label-success">'.($pengajian->lapor->study->status_pengajian).'</span>';

                          }
                            elseif($pengajian->lapor->status_pengajian == "BELUM SELESAI" )
                          {
                              echo '<span class="label label-danger">'.($pengajian->lapor->status_pengajian).'</span>';

                          }
                          else
                         {
                             echo '<span class="label label-danger">'.($pengajian->lapor->study->status_pengajian).'</span>';
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

        </div><?php } }else{?> <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> <tr>
                            <td colspan="11" class="text-center"><i>TIADA MAKLUMAT</i></td>                     
                                    </tr></table>
                            <?php }?></div>
  </div>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
   <h5 ><strong><i class="fa fa-suitcase"></i> MAKLUMAT LANTIKAN</strong></h5>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead style="background-color:lightseagreen;color:white">
                <tr class="headings">
                    <th>STATUS LANTIKAN</th>
                    <th>TARIKH MULA LANTIKAN </th>
                    <th>TARIKH TAMAT LANTIKAN</th>
                  
                </tr>
                </thead>
                <?php if($alamat2) {
                    
                   foreach ($alamat2 as $alamatkakitangan) {
                    
                ?>
                  
                <tr>
                    <td><?= strtoupper($alamatkakitangan->statusLantikan->ApmtStatusNm); ?></td>
                    <td><?= strtoupper($alamatkakitangan->tarikhMulaLantikan); ?></td>
                    <td><?= strtoupper($alamatkakitangan->tarikhTamatLantikan); ?></td>
               
                    
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>

            <div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
       <div class="x_title">
   <h5 ><strong><i class="fa fa-suitcase"></i> MAKLUMAT KESELURUHAN PERKHIDMATAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
        
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead style="background-color:lightseagreen;color:white">
                <tr class="headings">
                    <th>STATUS PERKHIDMATAN</th>
                    <th>STATUS TERPERINCI</th>
                    <th>TARIKH MULA </th>
                    <th>TARIKH TAMAT </th>
                    <th>TEMPOH BERKHIDMAT </th>
                </tr>
                </thead>
                <?php if($alamat) {
                    $counter_p = 0;
                    $counter_c = 0;
                    $prev_date = date('Y');
                   foreach ($alamat as $alamatkakitangan) {
                       
                       
                       $tarikhtamat = "";
                       //if($counter_c == ($counter_p + 1)){
     
                           $tarikhtamat = date('Y-m-d', strtotime('-1 day', strtotime($prev_date)));
                           $counter_p = $counter_p + 1;
                            $prev_date = $alamatkakitangan->ServStatusStDt;
//                            $tempoh = $prev_date -  $alamatkakitangan->ServStatusStDt;
                      
                        $ts1 = strtotime($alamatkakitangan->ServStatusStDt);
                        $ts2 = strtotime($tarikhtamat);
                        $months = 0;
//                         $year = 0;

                        while (strtotime('+1 MONTH', $ts1) < $ts2) {
                            $months++;
                            $ts1 = strtotime('+1 MONTH', $ts1);
                        }

                       $tempoh = $months. ' BULAN '. ($ts2 - $ts1) / (60*60*24). ' HARI'; // 120 month, 26 days

                       //}
//                       else{
//                           $prev_date = $alamatkakitangan->ServStatusStDt;
//                       }

                ?>
                  
                <tr>
                    <td><?= strtoupper($alamatkakitangan->statusPerkhidmatan->ServStatusNm)?></td>
                
                    <td><?= strtoupper($alamatkakitangan->statusTerperinci->name)?></td>
                    <td><?= strtoupper($alamatkakitangan->ServStatusStDt) ?></td>
                     <td><?= $tarikhtamat ?></td>
                   <td><?php 
//                   echo '<pre>', var_dump($alamat2), '</pre>';
//                   ddfd
//                   die();
                   
                   
                 $alamat2 = \app\models\hronline\Tblrscoapmtstatus::find()->where(['ICNO' => $id])->orderBy(['ApmtStatusStDt' => SORT_DESC])->one();
                   if($alamat2->ApmtStatusCd == 2)
                     {
                        echo  $tempoh = 0;
                     }else{
                         
                         echo $tempoh;
                     }
                      ?></td>

                </tr>
                
                        
                   <?php $counter_c = $counter_c + 1;} 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>
     <div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
       <div class="x_title">
   <h5 ><strong><i class="fa fa-suitcase"></i> MAKLUMAT PERKHIDMATAN (AKTIF SAHAJA)</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
        
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead style="background-color:lightseagreen;color:white">
                <tr class="headings">
                    <th>STATUS PERKHIDMATAN</th>
                    <th>STATUS TERPERINCI</th>
                    <th>TARIKH MULA </th>
                    <th>TARIKH TAMAT </th>
                    <th>TEMPOH BERKHIDMAT </th>
                </tr>
                </thead>
                <?php 
                $array = [];
                $ss = \app\models\hronline\Tblrscoservstatus::find()->where(['ICNO' => $id])->orderBy(['ServStatusStDt' => SORT_DESC])->all();
                $counter = 0;
                $index = 0;
                $temp_t = null;
                $sum_day = 0;
                foreach ($ss as $ss) {
                    $tempoh = 0;
                    $months = 0;
                    
                    if($ss->ServStatusCd == 1 && $counter == 0){
                        $temp_t = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
                        $array[$index]['st'] = strtoupper($ss->statusPerkhidmatan->ServStatusNm);
                        $array[$index]['stdtl'] = strtoupper($ss->statusTerperinci->name);
                        $array[$index]['tm'] = $ss->ServStatusStDt;
                        $array[$index]['tt'] = $temp_t;
                        $ts1 = strtotime($ss->ServStatusStDt);
                        $ts2 = strtotime($temp_t);

                        while (strtotime('+1 MONTH', $ts1) < $ts2) {
                            $months++;
                            $ts1 = strtotime('+1 MONTH', $ts1);
                        }
                        
                        $sum_month = $sum_month + $months;
                       
                        $sum_day= $sum_day + ($ts2 - $ts1);
                        $tempoh = $months. ' BULAN '. ($ts2 - $ts1) / (60*60*24). ' HARI'; // 120 month, 26 days
                        $array[$index]['tempoh'] = $tempoh;
                        
                        $index = $index + 1;
                    }else if($ss->ServStatusCd == 1){
                        $array[$index]['st'] = strtoupper($ss->statusPerkhidmatan->ServStatusNm);
                        $array[$index]['stdtl'] = strtoupper($ss->statusTerperinci->name);
                        $array[$index]['tm'] = $ss->ServStatusStDt;
                        $array[$index]['tt'] = $temp_t;
                        $ts1 = strtotime($ss->ServStatusStDt);
                        $ts2 = strtotime($temp_t);

                        while (strtotime('+1 MONTH', $ts1) < $ts2) {
                            $months++;
                            $ts1 = strtotime('+1 MONTH', $ts1);
                        }
                        
                        $sum_month = $sum_month + $months;
                       
                        $sum_day = $sum_day + ($ts2 - $ts1);
                       $tempoh = $months. ' BULAN '. ($ts2 - $ts1) / (60*60*24). ' HARI'; // 120 month, 26 days
                       $array[$index]['tempoh'] = $tempoh ; 
                       $index = $index + 1;
                    }
                    $temp_t = date('Y-m-d', strtotime('-1 day', strtotime($ss->ServStatusStDt)));
                    $counter = $counter + 1;
                }
                if($array){
                for($i = 0 ; $i < count($array); $i++){
                    ?>
                     <tr>
                    <td><?= $array[$i]['st']?></td>
                    <td><?= $array[$i]['stdtl']?></td>
                    <td><?= $array[$i]['tm']?></td>
                    <td><?= $array[$i]['tt']?></td>
                   <td> <?php 
//                   echo '<pre>', var_dump($alamat2), '</pre>';
//                   ddfd
//                   die();
                   
                   
                 $alamat2 = \app\models\hronline\Tblrscoapmtstatus::find()->where(['ICNO' => $id])->orderBy(['ApmtStatusStDt' => SORT_DESC])->one();
                   if($alamat2->ApmtStatusCd == 2)
                     {
                        echo  $tempoh = 0;
                     }else{
                         
                         echo $array[$i]['tempoh'];
                     }
                      ?></td>

                </tr>
                    
               <?php     
                    
                }
                }
                
                else{
                    ?>
                
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                     <tr>
                             <td colspan="4" align="right"><strong>JUMLAH PERKHIDMATAN</strong></td>
                            
                     <td class="text-left">
                        <?php 
                        $sum_day = ($sum_day) / (60*60*24);
                        while($sum_day > 31){
                           $sum_month = $sum_month + 1;
                           $sum_day = $sum_day - 30 ;
                        }
                        
                        if ($alamat2->ApmtStatusCd == 2) {
                            echo $tempoh = 0;
                        } else {

                            echo $sum_month . ' BULAN ' . $sum_day . ' HARI'; // 120 month, 26 days
                        }
                        ?>
                     </td></tr>
            </table>
            </div>
        </div>
    </div>
</div>
  <div class="col-md-12 col-sm-12 col-xs-12 ">   



<div class="x_panel">

<div class="x_title">
   <h5><strong><i class="fa fa-book"></i> MAKLUMAT BON PERKHIDMATAN</strong></h5>
   <div class="clearfix"></div>
</div>
    <p align="left"> 
<!--            <= Html::a('Kembali', ['index', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>-->
<!--            <= Html::a('Kemaskini', ['update2', 'id' => $model->ICNO], ['class' => 'btn btn-primary mapBtn ', 'id' => 'modalButton']) ?>-->
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['a-bon', 'id'=>$id
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
<!--            <= Html::a('Padam', ['delete', 'id' => $model->ICNO], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
-->            </p>
 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead style="background-color:lightseagreen;color:white">
       
        <tr class="headings">
            <th class="column-title text-center">BIL</th>
            <th class="column-title text-center">PERINGKAT PENGAJIAN </th>
            <th class="column-title text-center">TARIKH MULA BON </th>
            <th class="column-title text-center">TEMPOH BON </th>
            <th class="column-title text-center">TEMPOH BERKHIDMAT </th>
            <th class="column-title text-center">BAKI BON</th>
            <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>
    <tbody>
        
         <?php if($bon){ ?>
        <?php $bil=1; foreach ($bon as $bon) {
            
//                             $p = app\models\cbelajar\TblPengajian::find()->where(['icno' => $id])->orderBy(['tarikh_mula' => SORT_DESC])->one();
?>
        <tr>
<td class="text-center"><?= $bil++ ?></td>
<td class="text-center"><?= strtoupper($bon->tahapPendidikan); ?></td>

<td class="text-center"><?= strtoupper($bon->dtm); ?></td>

<td class="text-center"><?= strtoupper($bon->tempoh); ?></td>
<td class="text-center">
    
<?= strtoupper($bon->tempohbon
); ?></td>

            <td class="text-center"></td>
<!--<td class="text-center"><?php //$bon->j_bon; ?></td>-->
            <td class="text-center">

                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-bon', 'id' => $bon->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> |

                
                    
                 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete?id='.$bon->id.'&page=rekod-bon'], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?>
            </td>

        </tr>
        <?php }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>TIADA MAKLUMAT</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
         
       
        



 </table>
</form>           </div> <!-- div for row-->
          <!-- div for well-->
</div>
   
                <div class="x_panel">

    
         <div class="x_title">
   <h5><strong><i class="fa fa-money"></i> PENGIRAAN JUMLAH GANTIRUGI</strong></h5>
   <div class="clearfix"></div>
</div>
                    <p align="left"> 
<!--            <= Html::a('Kembali', ['index', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>-->
<!--            <= Html::a('Kemaskini', ['update2', 'id' => $model->ICNO], ['class' => 'btn btn-primary mapBtn ', 'id' => 'modalButton']) ?>-->
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-tuntutan-gantirugi', 'id' => $pengajian->icno
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
<!--            <= Html::a('Padam', ['delete', 'id' => $model->ICNO], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
-->            </p>
                                 
<div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead style="background-color:lightseagreen;color:white">
       
       <tr class="headings">
                                            <th class="text-left" width="5%">BIL.</th>
                                            <th class="text-center">PERINGKAT PENGAJIAN
</th>

                                            <th class="text-center">JUMLAH PENGAJIAN</th>
                                            <th class="text-center">JUMLAH GANTIRUGI SECARA PRO RATA</th>
                                           <th class="text-center">TINDAKAN</th>

<!--                                            <th class="text-center" style="width: 10%;">TEMPOH PENGAJIAN</th>-->
                                          

                                        </tr>
        
        
        

    </thead>
    <tbody>
         <?php if($tuntut){ ?>
        <?php $bil=1; foreach ($tuntut as $tuntut) { ?>
        <tr>
<td class="text-center"><?= $bil++ ?></td>
<td class="text-center"><?= strtoupper($tuntut->tahapPendidikan); ?></td>

<td class="text-center"><?= strtoupper($tuntut->j_cb); ?></td>

<td class="text-center"><?= strtoupper($tuntut->j_gantirugi); ?></td>

            <td class="text-center">

                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-tuntut', 'id' => $tuntut->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> |

                
                    
                 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-tuntut?id='.$tuntut->id.'&page=rekod-bon'], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?>
            </td>

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
                </div><!-- div for row-->
     <!-- div for well-->
 </div>

                







   

