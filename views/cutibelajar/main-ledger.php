


 <?php 
 use yii\helpers\Html;

 
 echo $this->render('/cutibelajar/_topmenu'); 
 
 error_reporting(0);?> 
 <p align="right"><?= Html::a('Kembali', ['cutibelajar/page-tuntutan'], 
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
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        <div class="x_title">
   <h5><strong><i class="fa fa-money"></i> MAKLUMAT PEMBAYARAN ELAUN</strong></h5>
   
   <div class="clearfix"></div>
</div>
   


 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   <thead>
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
            <th class="column-title text-center">JENIS ELAUN </th>
            <th class="column-title text-center">DIBAYAR </th>
            <th class="column-title text-center">AMAUN</th>
            <th class="column-title text-center">STATUS</th>

        </tr>
        
        
        

    </thead>
    <tbody>
         <?php if($elaun){ ?>
        <?php $bil=1; foreach ($elaun as $e) { ?>
        <tr>
<td class="text-center"><?= $bil++ ?></td>
<td><?= strtoupper($e->getJenise($e->jenis_elaun)); ?> </td>
<td><?= strtoupper($e->getAmaun($e->jenis_elaun)); ?> </td>

            <td><?= $e->amaun; ?></td>
             <td></td>
<!--<td class="text-center"><?php //$bon->j_bon; ?></td>-->
            

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
        
        
        <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
   <h5><strong><i class="fa fa-money"></i> MAKLUMAT GAJI</strong></h5>
   <div class="clearfix"></div>
</div>
    
            <table class="table table-sm table-bordered">
                
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
                    
            </table>
        </div>
    </div></div><!-- div for row-->
          <!-- div for well-->
</div>
    

        </div>
                    
    


         
         </div> 

 
