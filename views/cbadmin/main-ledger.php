


 <?php 
 use yii\helpers\Html;

 
 echo $this->render('/cutibelajar/_topmenu'); 
 
 error_reporting(0);?> 
 <p align="right"><?= Html::a('Kembali', ['cbadmin/search-elaun'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
<div class="x_panel">
    
<div class="x_content">
    
           
            
         
<span class="required" style="color:#062f49;">
<h5><strong><?= strtoupper('
    MAKLUMAT KAKITANGAN DAN AKADEMIK TERKINI'); ?>
                        </strong></h5> 
            </span> <br/>
     <table class="table" style="width:100%">
             
                    <tr>
                 
               <td>
               NO KAD PENGENALAN:  <?=  strtoupper($biodata->ICNO); ?>
                </td>
                </tr> 
                   <tr>
                 
               <td>
                   NAMA: <?= strtoupper($biodata->displayGelaran) ?> <?=  strtoupper($biodata->CONm); ?>
                </td>
                </tr>
                
                <tr>
                 
               <td>
               INSTITUT PENGAJIAN: <?=  strtoupper($pengajian->InstNm); ?>
                </td>
                </tr>
                <tr>
                <td>KURSUS / BIDANG: <?php
                        
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
                </tr>
                <tr>
                 
               <td>
               PERINGKAT PENGAJIAN: <?=  strtoupper($pengajian->HighestEduLevel); ?>
                </td>
                </tr>
               
     </table>
   
</div>
</div>
<div class="x_panel">
    
<div class="x_content">
<span class="required" style="color:#062f49;">
<h5><strong><?= strtoupper('
    MAKLUMAT LEDGER BIASISWA/TAJAAN'); ?>
                        </strong></h5> 
            </span><hr/>
            
            <div class="col-md-12 col-sm-12 col-xs-12"> 
        
          
           
                
                    <div class="col-md-12 col-sm-12 col-xs-12"> 

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 

                                    <?php
                                   
                                    if ($elaun) {
                                        $bil1 = 1;
                                        ?>
                                      

                                        <tr>
                                          

                                            <th class="text-center">ESH</th>
                                            <th class="text-center">EBK</th>
                                            <th class="text-center">EBSR </th>
                                            
                                            
                                             <th class="text-center">CATATAN</th>
                                             <th class="text-center">TINDAKAN</th>

                                            

<!--                                            <th class="text-center">TARIKH PENGAJIAN</th>-->
<!--                                            <th class="text-center" style="width: 10%;">TEMPOH PENGAJIAN</th>-->
                                           

                                        </tr>
                                   
                                        
                                         <td class="text-center"><?= $elaun->esh;?></td>
                                         <td class="text-center"><?= $elaun->ebk;?></td>
                                         <td class="text-center"><?= $elaun->ebsr;?></td> 
                                         
                                        
                                             <td class="text-center"><?= $elaun->catatan;?></td>
                                             <td class="text-center">

                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-ledger', 'id' => $elaun->icno]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> 

                                                                                                                                                                           
                                        

<?php }
                                    else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>

                            <?php   }?>
                                            
                                </table>
                             
                            </div>
                        </div>
                    </div>
                
        </div>
            
</div>
</div>

 
