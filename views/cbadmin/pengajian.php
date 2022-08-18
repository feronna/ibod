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
                <p align="right">  <?= Html::a('Kembali', ['cbadmin/search-pengajian'], ['class' => 'btn btn-primary btn-sm']) ?></p>

 <div class="x_panel">
     <div class="col-md-12 col-sm-12 col-xs-12">


   
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


<div class="x_panel">

<div class="col-md-12 col-sm-12 col-xs-12"> 

<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
   
</div>
    <p align="left"><?php
                if (!$b){

                //if ($model->status !=0 ) {
                echo Html::button('Tambah Pengajian', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tambah-elaun', 'id' => $b->id]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
                
              
            
       
                <?php }
 else {
    echo Html::button('Kemaskini Maklumat Pengajian <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-study', 'id' => $b->id]),
                     'class' => 'btn btn-primary btn-sm mapBtn'])                               
                 ;
                 
 }
 ?></p>


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
                        <?=strtoupper($biodata->jawatan->fname) ?></td>
                       
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
                  
            
        
        
        


 <?php  if($b->n){  ?> 
                    <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPAT PENGAJIAN ASAL</th>
                        <td style="width:20%">
                            
                         <?php  echo $b->InstNm; ?>
                          
   
                      
                        </td>
                    </tr>
                    <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPAT PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                            
                         <?php  echo '<span class="label label-primary">'.$b->n->renewTempat.'</span>'; ?>
                          
   
                      
                        </td>
                  
                       
                            
                                  
                               
                        
                            </tr>
                            
                    <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN</th>
                        <td style="width:20%">
                      <span class="label label-success"> <?= strtoupper($b->n->tarikhm)?> <b>HINGGA</b> 
                       <?= strtoupper($b->n->tarikht)?> (<?= strtoupper($b->n->tempohtajaan);?>)</span>
                        </td>
                  
                       
                            
                                  
                               
                        
                            <?php }?></tr>
                    <?php  if($b->o){  ?> 
                
                    <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPAT PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                            
                         <?php  echo '<span class="label label-primary">'.$b->o->renewTempat.'</span>'; ?>
                          
   
                      
                        </td>
                  
                       
                            
                                  
                               
                        
                            </tr>
                            
                    <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN</th>
                        <td style="width:20%">
                      <span class="label label-success"> <?= strtoupper($b->o->tarikhm)?> <b>HINGGA</b> 
                       <?= strtoupper($b->o->tarikht)?> (<?= strtoupper($b->o->tempohtajaan2);?>)</span>
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

      <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
    <div class="x_title">
   <h5><strong><i class="fa fa-plus"></i> TAMBAH TEMPAT PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
          
    <div class="x_panel">

        
    <div class="x_content">
 <p align="left"> 
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tambah-tempat?id='.$b->id,
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
             
          
            </p>
       
                 
  <div class="tab-content">
    <div  class="tab-pane fade in active">
<!--      <h3>PELARASAN TEMPAT PENGAJIAN BAHARU</h3>-->
    <form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   
     <thead>
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
                      <th class="column-title text-center">TEMPAT PENGAJIAN ASAL  </th>

            <th class="column-title text-center">TEMPAT PENGAJIAN  </th>
            <th class="column-title text-center">TEMPOH PENGAJIAN </th>
            <th class="column-title text-center">PERINCIAN </th>
           <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>  
    <tbody>
   <?php if($b->lain){ ?>
        <?php $bil=1; foreach ($b->lain as $l) {
            
            if($l->idBorang == 99){?>
        
        
<tr>
<td class="text-center"><?= $bil++ ?></td>
<td class="text-center"><?= strtoupper($b->InstNm);?> </td>
<td class="text-center"><?= strtoupper($l->renewTempat);?> </td>
<td class="text-center"><?= strtoupper($l->tarikhm); ?> HINGGA <?= strtoupper($l->tarikht); ?> </td>

<td class="text-center"><?= strtoupper($l->catatan); ?>
<td class="text-center">

                
                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-tempat-belajar', 'id' => $l->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> | 
                   
                 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-t?id='.$l->id], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?>
            </td>
</tr>

            <?php }
            

            
            }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
                    
         
        
        



 </table>
</form> 
    </div>
  </div>
    </div></div></div></div>
      <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
    <div class="x_title">
   <h5><strong><i class="fa fa-th-list"></i> TUKAR UNIVERSITI/TARIKH/BIDANG & TANGGUH PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
          
    <div class="x_panel">

        
    <div class="x_content">
 <p align="left"> 
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tukar?id='.$b->id,
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
             
          
            </p>
       
                 <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#menu1">TUKAR TEMPAT PENGAJIAN</a></li>
    <li><a data-toggle="tab" href="#menu2">PELARASAN TARIKH PENGAJIAN</a></li>
    <li><a data-toggle="tab" href="#menu3">TUKAR BIDANG PENGAJIAN</a></li>
    <li><a data-toggle="tab" href="#menu4">PENANGGUHAN PENGAJIAN</a></li>
    <li><a data-toggle="tab" href="#menu5">PENANGGUHAN LAPOR DIRI</a></li>


  </ul><br/> 
  
  <div class="tab-content">
    <div id="menu1" class="tab-pane fade in active">
<!--      <h3>PELARASAN TEMPAT PENGAJIAN BAHARU</h3>-->
    <form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   
     <thead>
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
            <th>JENIS PERMOHONAN </th>
            <th class="column-title text-center">TEMPAT PENGAJIAN ASAL </th>
            <th class="column-title text-center">TEMPAT PENGAJIAN BAHARU </th>
            <th class="column-title text-center">TEMPOH PENGAJIAN </th>
            <th class="column-title text-center">PERINCIAN </th>
           <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>  
    <tbody>
   <?php if($b->lain){ ?>
        <?php $bil=1; foreach ($b->lain as $l) {
            
            if($l->idBorang == 24){?>
        
        
<tr>
<td class="text-center"><?= $bil++ ?></td>
<td><?= strtoupper($l->borang->jenisBorang); ?> </td>
<td class="text-center"><?= strtoupper($b->InstNm);?> </td>
<td class="text-center"><?= strtoupper($l->renewTempat);?> </td>

<td class="text-center"><?= strtoupper($l->catatan); ?>
<td class="text-center">

                
                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-tempat', 'id' => $l->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> | 
                   
                 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-t?id='.$l->id], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?>
            </td>
</tr>

            <?php }
            

            
            }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
                    
         
        
        



 </table>
</form> 
    </div>
    
    <div id="menu2" class="tab-pane fade">
<!--      <h3>PELARASAN TEMPAT PENGAJIAN BAHARU</h3>-->
    <form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   
     <thead>
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
            <th>JENIS PERMOHONAN </th>
            <th class="column-title text-center">TARIKH PENGAJIAN ASAL </th>
            <th class="column-title text-center">TARIKH PENGAJIAN BAHARU </th>
            <th class="column-title text-center">PERINCIAN </th>
           <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>  
    <tbody>
   <?php if($b->lain){ ?>
        <?php $bil=1; foreach ($b->lain as $l) {
            
            if($l->idBorang == 23){?>
        
        
<tr>
<td class="text-center"><?= $bil++ ?></td>
<td><?= strtoupper($l->borang->jenisBorang); ?> </td>
<td><?= strtoupper($b->tarikhmula); ?>  HINGGA <?= strtoupper($b->tarikhtamat); ?> </td>
<td class="text-center"><?= strtoupper($l->tarikhm); ?> HINGGA <?= strtoupper($l->tarikht); ?> </td>
<td class="text-center"><?= strtoupper($l->catatan); ?>
<td class="text-center">

                
                
                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-tarikh', 'id' => $l->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> |
                    
                 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-t?id='.$l->id], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?>
            </td>
</tr>

            <?php }
            

            
            }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
                    
         
        
        



 </table>
</form> 
    </div>
      <div id="menu3" class="tab-pane fade">
    <form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   
     <thead>
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
            <th>JENIS PERMOHONAN </th>
            <th class="column-title text-center">BIDANG PENGAJIAN ASAL </th>
            <th class="column-title text-center">BIDANG PENGAJIAN BAHARU </th>
            <th class="column-title text-center">PERINCIAN </th>
           <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>  
    <tbody>
   <?php if($b->lain){ ?>
        <?php $bil=1; foreach ($b->lain as $l) {
            
            if($l->idBorang == 22){?>
        
        
<tr>
<td class="text-center"><?= $bil++ ?></td>
<td><?= strtoupper($l->borang->jenisBorang); ?> </td>
<td><?= strtoupper($b->MajorMinor); ?> </td>
<td class="text-center"><?php  if(($l->MajorCd == NULL) && ($l->MajorMinor != NULL))
                        {
                                echo  strtoupper($b->t->MajorMinor);
                        }
                        elseif (($l->MajorCd != NULL) && ($l->MajorMinor != NULL))  {
                            echo   strtoupper($l->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($l->major->MajorMinor);
                        }  ?>
                           </td>
<td class="text-center"><?= strtoupper($l->catatan); ?>
<td class="text-center">

                
                
                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-bidang', 'id' => $l->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> |
                    
                 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-t?id='.$l->id], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?>
            </td>
</tr>

            <?php }
            

            
            }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
                    
         
        
        



 </table>
</form> 
    </div>

    <div id="menu4" class="tab-pane fade">
     
    <form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   
     <thead>
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
            <th>JENIS PERMOHONAN </th>
            <th class="column-title text-center">TEMPOH  PENGAJIAN ASAL </th>
            <th class="column-title text-center">TARIKH PELARASAN PENGAJIAN BAHARU</th>
            <th class="column-title text-center">TARIKH MULA PENANGGUHAN PENGAJIAN</th>
            
            <th class="column-title text-center">PERINCIAN </th>
           <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>  
    <tbody>
   <?php if($b->lain){ ?>
        <?php $bil=1; foreach ($b->lain as $l) {
            
            if($l->idBorang == 31){?>
        
        
<tr>
<td class="text-center"><?= $bil++ ?></td>
<td><?= strtoupper($l->borang->jenisBorang); ?> </td>
<td class="text-center"><?= strtoupper($b->tarikhmula);?> HINGGA <?= strtoupper($b->tarikhtamat);?> (<?= strtoupper($b->tempoh);?>) </td>
<td class="text-center"><?= strtoupper($l->tarikhm); ?> HINGGA <?= strtoupper($l->tarikht); ?> (<?= strtoupper($l->tempohlanjutan);?>) </td>
<td class="text-center"><?= strtoupper($l->dtstangguh);?> HINGGA <?= strtoupper($l->dtntangguh);?> (<?= strtoupper($l->tempohtangguh);?>)</td>

<td class="text-center"><?= strtoupper($l->catatan);?> </td>
<td class="text-center">

                
                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-tangguh', 'id' => $l->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> | 
                    
                 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-t?id='.$l->id], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?>
            </td>
</tr>

            <?php }
            

            
            }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
                    
         
        
        



 </table>
</form>
    </div>
<div id="menu5" class="tab-pane fade">
<!--      <h3>PELARASAN TEMPAT PENGAJIAN BAHARU</h3>-->
    <form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   
     <thead>
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
            <th>JENIS PERMOHONAN </th>
           
            <th class="column-title text-center">PERINCIAN </th>
           <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>  
    <tbody>
   <?php if($b->lain){ ?>
        <?php $bil=1; foreach ($b->lain as $l) {
            
            if($l->idBorang == 25){?>
        
        
<tr>
<td class="text-center"><?= $bil++ ?></td>
<td><?= strtoupper($l->borang->jenisBorang); ?> </td>

<td class="text-center"><?= strtoupper($l->catatan); ?>
<td class="text-center">

                
                
                    
                 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-t?id='.$l->id], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?>
            </td>
</tr>

            <?php }
            

            
            }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
                    
         
        
        



 </table>
</form> 
    </div>
  </div>
</div>

                        
                    </div> 

        </div>
                    
 
 </div>

         
         
 <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
    <div class="x_title">
   <h5><strong><i class="fa fa-th-list"></i> MAKLUMAT PELANJUTAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
    <div class="x_panel">

        
    <div class="x_content">
 <p align="left"> 
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['test?id='.$b->id,
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
             
          
            </p>
       
                    
                        <div>
<form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   <thead>
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
            <th>TARIKH PELANJUTAN CUTI BELAJAR </th>
            <th class="column-title text-center">TEMPOH </th>
            <th class="column-title text-center">PELANJUTAN KALI KE</th>
            <th class="column-title text-center">JUSTIFIKASI</th>

            <th class="column-title text-center">TINDAKAN</th>

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
 </td>
<td class="text-center"><?= $l->idlanjutan; ?></td>

<td class="text-center">
    <?php if($l->justifikasi)
    {
    echo $l->justifikasi;
    }
    else
    {
        echo 'Tiada Maklumat';
    }
?></td>

                     
<td class="text-center">

                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['kemaskini-p', 'id' => $l->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> |

                
                    
                 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-tajaan?id='.$l->id], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?>
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
 </div>



       
   

