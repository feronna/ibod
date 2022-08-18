<?php
$this->registerJs('$(function () {
  $(\'[data-toggle="tooltip"]\').tooltip()
})');
use yii\helpers\Html;
use yii\helpers\Url;    
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Dropdown;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
error_reporting(0); 
$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});
';

$this->registerJs($js);
$title = $this->title = 'Ringkasan Penyelidikan';

?>




<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>

     
    <div class='row'>   

        <div class="col-xs-12 col-md-12 col-lg-12">

 <div class="panel panel-success">

                <div class="panel-heading">
        <h6><strong><i class="fa fa-graduation-cap"></i> <?php if($b->tahapPendidikan)
                                {
                                 echo strtoupper($b->tahapPendidikan);
                                         
                                }
                                
                              
?></strong></h6> 
                </div>
   


     <?php if($b){
//        foreach ($b as $b) {
                
                ?>  
            

                    <div class="x_content ">
    <div class='x_panel'>   

                 <div class="table-responsive">
                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                
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
    </div>
    </div>
        <?php ActiveForm::end(); ?>
  
  



