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
//$this->title = 'MAKLUMAT PENAJAAN';

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

<div class="col-md-12 col-sm-12 col-xs-12 "> 

                          <p align="right">  <?= Html::a('Kembali', ['cbadmin/search-biasiswa'], ['class' => 'btn btn-primary btn-sm']) ?></p>


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
   


     <?php if($b->pengajian){
//        foreach ($b as $b) {
                
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive">
                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th colspan="2" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($b->pengajian->tahapPendidikan)
                                {
                                 echo strtoupper($b->pengajian->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                                <tr> 
                        <th style="width:10%" align="right">JAWATAN SEMASA CUTI BELAJAR</th>
                        <td style="width:20%">
                        <?=strtoupper($biodata->jawatan->fname) ?></td>
                       
                    </tr>
                    <tr> 
                                  <?php  if(!$b->pengajian->l){
                                 ?> 
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($b->pengajian->InstNm); ?></td><?php }?></tr>
                        
                        
                        <?php  if($b->pengajian->l){  ?> 
                       <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPAT PENGAJIAN ASAL</th>
                        <td style="width:20%">
                            
                         <?php  echo $b->pengajian->InstNm; ?>
                          
   
                      
                        </td>
                        <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPAT PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                            
                         <?php  echo $b->pengajian->l->renewTempat.  ' ('.$b->pengajian->l->catatan.')'; ?>
                          
   
                      
                        </td>
                            <?php }?></tr> 
                        
                        <tr> 
                        <th style="width:10%" align="right">NEGARA</th>
                        <td style="width:20%"><?= strtoupper($b->pengajian->negara->Country)?></td>
                    </tr>
                             
                            
                           
                             
                    <tr> 
                          <?php  if(!$b->pengajian->t){
                                 ?> 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($b->pengajian->MajorCd == NULL) && ($b->pengajian->MajorMinor != NULL))
                        {
                                echo  strtoupper($b->pengajian->MajorMinor);
                        }
                        elseif (($b->pengajian->MajorCd != NULL) && ($b->pengajian->MajorMinor != NULL))  {
                            echo   strtoupper($b->pengajian->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($b->pengajian->major->MajorMinor);
                        }
?></td>
                          <?php }?> 
                    </tr>
                    <?php  if($b->pengajian->t){ 
                      ?> 
                       <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">BIDANG PENGAJIAN ASAL</th>
                        <td style="width:20%">
                            
                         <?php
                        
                        if(($b->pengajian->MajorCd == NULL) && ($b->pengajian->MajorMinor != NULL))
                        {
                                echo  strtoupper($b->pengajian->MajorMinor);
                        }
                        elseif (($b->pengajian->MajorCd != NULL) && ($b->pengajian->MajorMinor != NULL))  {
                            echo   strtoupper($b->pengajian->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($b->pengajian->major->MajorMinor);
                        }
?>
                          
   
                      
                        </td>
                        <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">BIDANG PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                            
                         <?php  if(($b->pengajian->t->MajorCd == NULL) && ($b->pengajian->t->MajorMinor != NULL))
                        {
                                echo  strtoupper($b->pengajian->t->MajorMinor);
                        }
                        elseif (($b->pengajian->t->MajorCd != NULL) && ($b->pengajian->t->MajorMinor != NULL))  {
                            echo   strtoupper($b->pengajian->t->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($b->pengajian->t->major->MajorMinor);
                        }  ?>
                          
   
                      
                        </td>
                            <?php }?></tr>
                        <tr> 
                        <?php if(!$b->pengajian->m)
                        {?>
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($b->pengajian->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($b->pengajian->tarikhtamat)?> (<?= strtoupper($b->pengajian->tempohtajaan);?>)</td>
                        </tr><?php }?>
                    
                        <tr> 
                      <?php if($b->pengajian->m)
                        {?>
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($b->pengajian->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($b->pengajian->tarikhtamat)?> (<?= strtoupper($b->pengajian->tempohtajaan);?>)</td>
                        </tr>
                   <tr> 
                       
                       
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN BAHARU</th>
                        <td style="width:40%">
                        <?= strtoupper($b->pengajian->m->tarikhm)?> <b>HINGGA</b> 
                        <?= strtoupper($b->pengajian->m->tarikht)?> (<?= strtoupper($b->pengajian->m->tempohlanjutan);?>)</td>
                        </tr><?php }?>
                    
                          <?php  if($b->pengajian->r){  ?> 
                       
                        <tr> 
                            
                         <th style="width:10%" align="right">TARIKH PELARASAN PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                        <?= strtoupper($b->pengajian->r->tarikhm)?> <b>HINGGA</b> 
                        <?= strtoupper($b->pengajian->r->tarikht)?> (<?= strtoupper($b->pengajian->r->tempohlanjutan);?>)
                        </td>
                      
                        </tr>         
                        <tr>    
                        <th style="width:10%" align="right">TEMPOH PENANGGUHAN PENGAJIAN</th>
                        <td style="width:20%">
                        <?= strtoupper($b->pengajian->r->dtstangguh)?> <b>HINGGA</b> 
                        <?= strtoupper($b->pengajian->r->dtntangguh)?> (<?= strtoupper($b->pengajian->r->tempohtangguh);?>)
   
                      
                        </td>
                            <?php }?></tr>
                    
                   <tr>
                         <th style="width:10%" align="right">TAJAAN</th>
                         <td style="width:20%">
<?php

echo $b->pengajian->tajaan->penajaan->penajaan.' - '. $b->pengajian->tajaan->nama_tajaan;


?>
                         </td>
                    </tr>
             
                    
                    
                    
                    
                    <?php 
                         foreach($b->pengajian->lanjutan as $l)
                         {
                         ?>
                     <tr>
                         
                        
                         <th style="width:10%" align="right">TARIKH PELANJUTAN <?= $l->idlanjutan?></th>
                        <td style="width:20%">

                            <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?>
                        (<?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->tempohlanjutan)?>)</td>

                         </tr><?php }?>
                   
                    <tr>  <?php if($b->pengajian->lapor)
                     {?>
                        <th style="width:10%" align="right">TARIKH LAPOR DIRI</th>
                        <td style="width:20%">
                            <?php 
                         if($b->pengajian->lapor->dt_lapordiri)
                         {
                         
                                echo strtoupper($b->pengajian->lapor->dtlapor);
                                
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
                         
                          if($b->pengajian->lapor->status_pengajian == "SELESAI")
                          {
                              echo '<span class="label label-success">'.($b->pengajian->lapor->study->status_pengajian).'</span>';
                          }
                           elseif($b->pengajian->lapor->status_pengajian == "1" )
                          {
                              echo '<span class="label label-success">'.($b->pengajian->lapor->study->status_pengajian).'</span>';

                          }
                          
                          elseif ($b->lapor->status_pengajian != "SELESAI")
                         {
                             echo '<span class="label label-danger">'.($b->pengajian->lapor->study->status_pengajian).'</span>';
                         }
                          
                          
                           ?>
                    </tr>
                    <tr><th style="width:10%" align="right">CATATAN</th>
                        <td style="width:20%"><?= strtoupper($b->pengajian->lapor->catatan)?></td>
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
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                                    </tr></table>
                            <?php }?></div>
  </div>
</div>
                 <div class="x_panel">

<div class="col-md-12 col-sm-12 col-xs-12">

<div class="x_title">
   <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PENAJAAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>      


        
    <div class="x_content">
        <p align="left"><?php
                if (!$e){

                //if ($model->status !=0 ) {
                echo Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tambah-elaun', 'id' => $b->id]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
                
              
            
       
                <?php }
 else {
    echo Html::button('Kemaskini Maklumat Penajaan <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-elaun', 'id' => $b->id]),
                     'class' => 'btn btn-primary btn-xs mapBtn'])                               
                 ;
                 
 }
 ?></p>
                    
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                               
                    
                    
                     <tr> <th colspan="2" style="background-color:lightseagreen;color:white"><center>MAKLUMAT PENAJAAN</center></th>
                     </tr>    
                     
                     
                     <tr>
                        
                        <th style="width:10%" align="right">NAMA TAJAAN</th>
                        <td style="width:20%"><?php

                        echo $b->pengajian->tajaan->penajaan->penajaan.' - '. 
                                $b->pengajian->tajaan->nama_tajaan. 
                                 ' ('.$b->pengajian->tajaan->bantuan->bentukBantuan.')';


?></td>
                       
                    </tr>
                    <tr>
                        
                        <th style="width:10%" align="right">CATATAN TAJAAN</th>
                        <td style="width:20%"><?=
                        strtoupper($b->c_tajaan) ?></td>
                       
                    </tr>
                     <tr> 
                        <th style="width:10%" align="right">LOKASI PENGAJIAN</th>
                        <td style="width:20%"><?=
                        strtoupper($b->e->lokasi) ?></td>
                       
                    </tr>
                     <tr>  <?php if($b->e)
                     {?>
                        <th style="width:10%" align="right">TARIKH DAN TEMPOH PENAJAAN</th>
                        <td style="width:20%"><?=
                        strtoupper($b->e->dt) ?> HINGGA <?=
                        strtoupper($b->e->dt1) ?> (<?=
                        strtoupper($b->e->tempoh) ?>)</td>
                       
                    </tr>
                    
                     
                   
                   
                    </tr>
                    <tr> 
                        <th style="width:10%" align="right">TARAF PERKAHWINAN</th>
                        <td style="width:20%">
                        <?=
                        strtoupper($b->kakitangan->displayTarafPerkahwinan) ?></td>
                       
                    </tr>
                   
               
                    <tr>
                         
                        <th style="width:10%" align="right">AKUAN MEMBAWA KELUARGA? (YA/TIDAK)</th>
                        <td style="width:20%"><?=
                        strtoupper($b->e->family) ?></td>
                       
                    </tr>
                      <?php if($b->e->family == "YA")
                 {?>
                     <tr> 
                        <th style="width:10%" align="right">PASANGAN</th>
                        <td style="width:20%"><?=
                        strtoupper($b->e->pasangan) ?></td>
                        
                       
                    </tr>
                    <tr>
                        <th align="right">ANAK</th>
                        <td style="width:20%"><?=
                        strtoupper($b->e->anak) ?></td>
                    </tr>
                    
                      <tr>
                        <th align="right">TARIKH DAN TEMPOH MEMBAWA KELUARGA</th>
                        <td style="width:20%">
                            
                       <?php if($b->pengajian->InstNm != "UNIVERSITI MALAYSIA SABAH" && $b->pengajian->InstNm != "UMS")
                        {
                       echo  strtoupper($b->e->bk). ' HINGGA '.  strtoupper($b->e->bk1).' ( '.$b->e->tempohbk.' ) ';
                        }
                       
else{
    echo "TIDAK BERKAITAN";
}
?>
                      </td>
                     <?php }}?>
                     
                    </tr>
                    
                    
                   
                    
                    
                   

                            </thead>
                        
                                    </table>         
 

        </div>
  </div> 
 </div>
     
            

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
    <div class="x_title">
   <h5><strong><i class="fa fa-plus-square"></i> MAKLUMAT PELANJUTAN TAJAAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
    <div class="x_panel">

        
    <div class="x_content">
 
       
                    
                        <div>
<form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   <thead>
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
            <th>TARIKH PELANJUTAN CUTI BELAJAR </th>
            <th class="column-title text-center">TEMPOH </th>
            <th class="column-title text-center">PELANJUTAN KALI KE</th>
             <th class="column-title text-center">TARIKH PELANJUTAN TAJAAN</th>
            <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>
    <tbody>
        
         <?php if($lanjutan){ ?>
        <?php $bil=1; foreach ($lanjutan as $l) { ?>
<tr>
<td class="text-center"><?= $bil++ ?></td>
<td> <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?></td>


<td class="text-center">

<?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->tempohlanjutan)?></td>

<td class="text-center"><?= $l->idlanjutan; ?></td>
<td class="text-center"> <?php if($l->dt_slanjutb)
{
       
     echo strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->dtslanjut)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->dtnlanjut)?> (<?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->tempohtajaan)?>)
<?php }
else
{
    echo "-";
}
?></td>

                     
<td class="text-center">

                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['tajaan-lanjutan', 'id' => $l->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> 

                
                    
               
            </td>
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
                    
 
 </div>

         
         </div>
</div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        <div class="x_title">
   <h5><strong><i class="fa fa-money"></i> MAKLUMAT PEMBAYARAN ELAUN & YURAN [KPT/UMS]</strong></h5>
   <div class="clearfix"></div>
</div>

   
<?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> TAMBAH ELAUN', 
    ['rekod-elaun','id' => $id,], ['class' => 'btn btn-primary btn-xs']) ?>
                <h5> <span class="label label-info"><?= $b->e->kadar ?></span></h5>

 <div id="menu1" class="tab-pane fade in active">
<!--      <h3>PELARASAN TEMPAT PENGAJIAN BAHARU</h3>-->
    <form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   
     <thead>
       
        <tr class="headings">
            <th class="column-title text-center">BIL </th>
            <th class="column-title text-center"  width="60%">JENIS ELAUN </th>
            <th class="column-title text-center">BAYARAN </th>
            <th class="column-title text-center">AMAUN </th>

        </tr>
        
        
        

    </thead>  
    <tbody>
                       <?php
                            if(($b->e->kadar == "KADAR A") && 
                             ($b->pengajian->HighestEduLevelCd == 202)
                               && ($b->e->family == "YA"))
                            
                            {
                            if ($elaun) 
                            { $no=0;?>
                            
                                <?php foreach ($elaun as $dok) { $no++; 
                                $mod = \app\models\cbelajar\KadarA::find()->where(['id' => $dok->id])->one();
                                   
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->elaun; ?></td>
                                    <td class="text-center"><?php echo $dok->bayaran; ?></td>
                                    <td class="text-center">RM<?php echo $dok->kadar_a; ?></td>

   
                    
</tr>

            <?php }
            

            
            }}
            elseif(($b->e->kadar == "KADAR A") && 
                             ($b->pengajian->HighestEduLevelCd == 20)
                               && ($b->e->family == "YA"))
                            
                            {
                            if ($elaun) 
                            { $no=0;?>
                            
                                <?php foreach ($elaun as $dok) { $no++; 
                                $mod = \app\models\cbelajar\KadarA::find()->where(['id' => $dok->id])->one();
                                   
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->elaun; ?></td>
                                    <td class="text-center"><?php echo $dok->bayaran; ?></td>
                                    <td class="text-center">RM<?php echo $dok->kadar_a; ?></td>

   
                    
</tr>

            <?php }
            

            
            }}
            elseif(($b->e->kadar == "KADAR A") && 
                             ($b->pengajian->HighestEduLevelCd == 1)
                               && ($b->e->family == "YA"))
                            
                            {
                            if ($elaun) 
                            { $no=0;?>
                            
                                <?php foreach ($elaun as $dok) { $no++; 
                                $mod = \app\models\cbelajar\KadarA::find()->where(['id' => $dok->id])->one();
                                   
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->elaun; ?></td>
                                    <td class="text-center"><?php echo $dok->bayaran; ?></td>
                                    <td class="text-center">RM<?php echo $dok->kadar_a; ?></td>

   
                    
</tr>

            <?php }
            

            
            }}
            //BUJANG KADAR A SARJANA
           elseif(($b->e->kadar == "KADAR A") && 
                 ($b->pengajian->HighestEduLevelCd == 202) 
                 && ($b->e->family == "TIDAK"))
                            {
                            if ($e1) 
                            { $no=0;?>
                            
                                <?php foreach ($e1 as $e) { $no++; 
//                                $mod = \app\models\cbelajar\RefElaun::find()->where(['id' => $dok->id])->one();
                                   
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-left"><?php echo $e->elaun; ?></td>
                                    <td class="text-center"><?php echo $e->bayaran; ?></td>
                                    <td class="text-center">RM<?php echo $e->kadar_a; ?></td>
                                    
                                   

                                    
                                   
                                    
                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            }
                            elseif(($b->e->kadar == "KADAR A") && 
                 ($b->pengajian->HighestEduLevelCd == 1) 
                 && ($b->e->family == "TIDAK"))
                            {
                            if ($e2) 
                            { $no=0;?>
                            
                                <?php foreach ($e2 as $e) { $no++; 
//                                $mod = \app\models\cbelajar\RefElaun::find()->where(['id' => $dok->id])->one();
                                   
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-left"><?php echo $e->elaun; ?></td>
                                    <td class="text-center"><?php echo $e->bayaran; ?></td>
                                    <td class="text-center">RM<?php echo $e->kadar_a; ?></td>
                                    
                                   

                                    
                                   
                                    
                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            }
                            elseif(($b->e->kadar == "KADAR B") && 
                 ($b->pengajian->HighestEduLevelCd == 202) 
                 && ($b->e->family == "YA") && ($b->e->anak == "3 ANAK"))
                            {
                            if ($kadarb) 
                            { $no=0;?>
                            
                                <?php foreach ($kadarb as $dok) { $no++; 
//                                $mod = \app\models\cbelajar\RefElaun::find()->where(['id' => $dok->id])->one();
                                   
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-left"><?php echo $dok->elaun; ?></td>
                                    <td class="text-center"><?php echo $dok->bayaran; ?></td>
                                    <td class="text-center">RM<?php echo $dok->kadar_b; ?></td>
                                    
                                   

                                    
                                   
                                    
                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            }
                   elseif(($b->e->kadar == "KADAR B") && 
                 ($b->pengajian->HighestEduLevelCd == 1) 
                 && ($b->e->family == "YA") && ($b->e->anak == "3 ANAK"))
                            {
                            if ($kadarc) 
                            { $no=0;?>
                            
                                <?php foreach ($kadarc as $dok) { $no++; 
//                                $mod = \app\models\cbelajar\RefElaun::find()->where(['id' => $dok->id])->one();
                                   
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-left"><?php echo $dok->elaun; ?></td>
                                    <td class="text-center"><?php echo $dok->bayaran; ?></td>
                                    <td class="text-center">RM<?php echo $dok->kadar_b; ?></td>
                                    
                                   

                                    
                                   
                                    
                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            }

           else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
                    
         
        
        



 </table>
</form> 
    </div> <!-- div for row-->
          <!-- div for well-->
</div>
    

        </div>
                    
    


         
         </div>
     
     <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
   <h5><strong><i class="fa fa-money"></i> PEMBAYARAN DIBAWAH PENGURUSAN UMS</strong></h5>
   
   <div class="clearfix"></div>
</div>

 

 <div id="menu1" class="tab-pane fade in active">
<!--      <h3>PELARASAN TEMPAT PENGAJIAN BAHARU</h3>-->
    <form id="w0" class="form-horizontal form-label-left" action="">
        
            <table class="table table-sm table-bordered">
      <?php if($t){?>
     <thead>
      
        <tr class="headings">
            <th class="column-title text-center">BIL </th>
            <th class="column-title text-center" width="60%">JENIS ELAUN </th>
            <th class="column-title text-center">BAYARAN </th>
            <th class="column-title text-center">AMAUN </th>

        </tr>
        
        
        

    </thead>  
    <tbody>
                    <?php 
//                    echo $pengajian->tarikh_mula;

               $no=0;
                    foreach($t as $t)
                    { $no++;
//                        echo round($sem);
                       ?>  <tr>
                              <td class="column-title text-center" > <?= $no++;?>  </td>
                             <td class="column-title text-left" > <?= $t->jenis->elaun;?>  </td>
                            <td class="column-title text-center"> UMS </td>
                             <td class="column-title text-center">
                                 
                                 
                                 
                               RM<?= $t->amaun;
                                 ?>
                             </td>
                             
                              
        
         
            </tr>
            
                <?php 
                    }
}    else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                  } ?></tbody>
         
                    
         
        
        



 </table>
</form> 
    </div> <!-- div for row-->
          <!-- div for well-->
</div>
    

        </div>
                    
    


         
         </div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
   <h5><strong><i class="fa fa-money"></i> MAKLUMAT GAJI</strong></h5>
   <div class="clearfix"></div>
</div>
    
            <table class="table table-sm table-bordered">
                <?php if($c)
                {?>
                <tr>
                   <th <td width="50px" height="20px"><strong>BIL</strong></td></th>
                     <th class="text-center">JENIS PENDAPATAN</th>
                   <th <td width="200px" height="20px"><strong>JUMLAH</strong></td></th>
                    
                </tr>
                
                
            
                   <?php foreach ($c as $key=>$item): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                             <td><?= $item->it_income_desc?></td>
                             <td><?= $item->MPDH_PAID_AMT?></td>
                         
                        </tr>
                <?php endforeach; ?>
             
           
                <?php foreach ($model2 as $key=>$item): ?>
                      
                           
                               <tr><td>
                             <td align="right"><strong>JUMLAH PENDAPATAN</strong></td>
                             <td><?= $item->MPH_TOTAL_ALLOWANCE?></td></td></tr>
                    
                <?php endforeach; ?>
                <?php }else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                  } ?>
            </table>
        </div>
    </div></div></div>

       
   

