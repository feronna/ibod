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

                          <p align="right">  <?= Html::a('Kembali', ['cbadmin/nominal-damages'], ['class' => 'btn btn-primary btn-sm']) ?></p>


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


    
  <div class="col-md-12 col-sm-12 col-xs-12 ">   



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
                        <?=strtoupper($biodata->jawatan->fname) ?></td>
                       
                    </tr>
                    <tr> 
                                  <?php  if(!$b->l){
                                 ?> 
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($pengajian->InstNm); ?></td><?php }?></tr>
                        
                        
                        <?php  if($b->l){  ?> 
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
                        <?php if(!$pengajian->m)
                        {?>
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($pengajian->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->tarikhtamat)?> (<?= strtoupper($pengajian->tempohpengajian);?>)</td>
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
                    
                   <tr>
                         <th style="width:10%" align="right">TAJAAN</th>
                         <td style="width:20%">
<?php

echo $pengajian->tajaan->penajaan->penajaan.' - '. $pengajian->tajaan->nama_tajaan;


?>
                         </td>
                    </tr>
             
                    
                    
                    
                    
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
                         
                          if($pengajian->lapor->status_pengajian == "SELESAI")
                          {
                              echo '<span class="label label-success">'.($pengajian->lapor->status_pengajian).'</span>';
                          }
                          
                          elseif ($pengajian->lapor->status_pengajian != "SELESAI")
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

        </div><?php  }else{?> <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                                    </tr></table>
                            <?php }?></div>
  </div>
</div>
 
     <div class="row">

    
  <div class="col-md-12 col-sm-12 col-xs-12 ">   



<div class="x_panel">

<div class="x_title">
   <h5><strong><i class="fa fa-legal"></i> MAKLUMAT NOMINAL DAMAGES</strong></h5>
   <div class="clearfix"></div>
</div>
    <p align="left"> 
<!--            <= Html::a('Kembali', ['index', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>-->
<!--            <= Html::a('Kemaskini', ['update2', 'id' => $model->ICNO], ['class' => 'btn btn-primary mapBtn ', 'id' => 'modalButton']) ?>-->
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['view_nds', 'id'=>$lapor->laporID
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
   <thead>
       
        <tr class="headings">
            <th class="column-title text-center">BIL</th>
            <th class="column-title text-center">TARIKH PATUT MULA </th>
            <th class="column-title text-center">TARIKH BERSETUJU </th>
            <th class="column-title text-center">TARIKH TAMAT </th>
            <th class="column-title text-center">TEMPOH </th>

            <th class="column-title text-center">JUMLAH NOMINAL (BULANAN)</th>
             
            <th class="column-title text-center">JUMLAH KUTIPAN</th>
          
 <th class="column-title text-center">CATATAN</th>
            <th class="column-title text-center">TINDAKAN</th>
        </tr>
         
        

    </thead>
    <tbody>
         <?php if($nd){ $jumlahkutipan = 0; ?>
        <?php $bil=1; foreach ($nd as $nd) { ?>
        <tr>
<td class="text-center"><?= $bil++ ?></td>
<td class="text-center"><?= strtoupper($nd->dt_nominal); ?></td>
<td class="text-center"><?= strtoupper($nd->dt_setuju); ?></td>

<td class="text-center"><?= strtoupper($nd->nd_nominal); ?></td>
<td class="text-center">
  <?php if($nd->nd_nominal){
        echo $nd->tempohh;
    }
    elseif($nd->dt_setuju)
    {
                echo $nd->tempohhh;

    }
    elseif($nd->j_nd)
    {
                echo $nd->tempoh1;

    }
 else {
        echo '-';
    }
?>

 
             
                     </td>
<td class="text-center">RM<?= strtoupper($nd->j_nd
); ?></td>
<td class="text-center">
  <?php if($nd->nd_nominal){
        $kutipan = $nd->j_nd * $nd->tempohh;
    }
    elseif($nd->dt_setuju)
    {
       $kutipan = $nd->j_nd * $nd->tempoh1;

    }
    
 else {
        $kutipan = $nd->j_nd * $nd->tempohhh;
    }
    
    echo 'RM'.$kutipan;
    
    $jumlahkutipan = $jumlahkutipan+$kutipan;
?>
    
</td>
<td class="text-center"><?= $nd->catatan; ?></td>
<!--<td class="text-center"><?php //$bon->j_bon; ?></td>-->
            <td class="text-center">

                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-nd', 'id' => $nd->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> |

                
                    
                 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/deletend?id='.$nd->id.'&page=rekod-bon'], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda yakin ingin membuang rekod ini?',],                                   
                    ])
                    ?>
            </td>

        </tr>
        <?php }} else{
                    ?>
                    <tr>
                        <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
      
                      
                           
                               <tr>
                             <td colspan="6" align="right"><strong>JUMLAH KESELURUHAN (RM)</strong></td>
                            
                     <td class="text-center">
                         RM<?= $jumlahkutipan?>
                     </td><td></td><td></td></tr>
                    
            
       
        



 </table>
</form>           </div> <!-- div for row-->
          <!-- div for well-->
</div>
   
                
                    </div>
                </div><!-- div for row-->
     <!-- div for well-->
 </div>

                







   

