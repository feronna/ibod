


 <?php 
 use yii\helpers\Html;

 
 echo $this->render('/cutibelajar/_topmenu'); 
 
 error_reporting(0);?> 
<p align="right"> 
    <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['cetak-rekod', 'id'=>$biodata->ICNO,
                    'target'=>'_blank'], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Rekod Keseluruhan'
                ]);
                ?><?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?> </p> 
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> 
     REKOD KAKITANGAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>

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
 
 
  
<div class="x_panel">
       
             <fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-graduation-cap'></i> MAKLUMAT PENGAJIAN</h5>
            </legend> 
            <?php
              if($pengajian){ ?>
            <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead style="background-color:lightseagreen;color:white">
                      
                    <tr class="headings">
                        <th class="column-title text-center ">BIL</th>
                        <th class="column-title text-center">TAHAP PENGAJIAN </th>
                        <th class="column-title text-center">LKP</th>
                        <th class="column-title text-center">TINDAKAN</th>

                        
                    </tr>
 </thead>
                    <tbody>

                    <?php $bil=1; foreach ($pengajian as $akademik) { ?>

                        <tr>

                            <td class="text-center" width="5%"><?= $bil++ ?></td>
                            <td class="text-center" width="50%"><?= strtoupper($akademik->tahapPendidikan); ?></td>
                            <td class="text-center">                                        <?= Html::a('<i class="fa fa-bar-chart" aria-hidden="true"></i>', ['cbadmin/lihat-lkp?id='.$akademik->id]) ?> 
</td>
<td class="text-center">
<?=    Html::button('<i class="fa fa-info" aria-hidden="true"></i>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['/cutibelajar/ringkasan?id='.$akademik->id,
                  ]),'class' => 'btn btn-default mapBtn']); ?>

                                    
                                  </td>

                        </tr>
                    <?php } ?>
                    </tbody>
              
                
                </table>

             </div>
              <?php }
              else{?>
                  <tr>
                  <p style="color:red"><b> SILA ISI MAKLUMAT AKADEMIK ANDA</b></p>
                      <td class="text-center"><b> TIADA MAKLUMAT</b></td>
                               

                        </tr>
   <?php           }
?>
  
</div>






<div class="x_panel">

<div class="x_title">
   <h5><strong><i class="fa fa-book"></i> MAKLUMAT BON PERKHIDMATAN</strong></h5>
   <div class="clearfix"></div>
</div> 
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

        </tr>
        
        
        

    </thead>
    <tbody>
         <?php if($bon){ ?>
        <?php $bil=1; foreach ($bon as $bon) { ?>
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
            

        </tr>
        <?php }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>TIADA MAKLUMAT</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
             <tr>
                             <td colspan="4" align="right"><strong>JUMLAH TEMPOH BERKHIDMAT</strong></td>
                            
                     <td class="text-center" col>
                         <?= $sum+= $bon->tempohbon?>
                     </td><td></td></tr>
        



 </table>
</form>           </div> <!-- div for row-->
          <!-- div for well-->
</div>
            <div class="x_panel">
<div class="x_title">
   <h5><strong><i class="fa fa-legal"></i> JUMLAH TUNTUTAN GANTIRUGI</strong></h5>
   <div class="clearfix"></div>
</div>
      <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead style="background-color:lightseagreen;color:white">
       
       <tr class="headings">
                                            <th class="text-center" width="5%">BIL</th>
                                            <th class="text-center">PERINGKAT PENGAJIAN
</th>

                                            <th class="text-center">JUMLAH PENGAJIAN</th>
                                            <th class="text-center">JUMLAH GANTIRUGI SECARA PRO RATA</th>

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

          

        </tr>
        <?php }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>TIADA MAKLUMAT</i></td>                     
                        </tr>
                  <?php  
                } ?>
                  
         
       
        



 </table>
</form>           </div></div>


               <div class="x_panel">
        
          
          <div class="x_title">
   <h5 ><strong><i class="fa fa-legal"></i> NOMINAL DAMAGES</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
                
                    <div class="col-md-12 col-sm-12 col-xs-12"> 

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 
                                    <tr> <th colspan="2" style="background-color:lightseagreen;color:white"><center>NOMINAL DAMAGES</center></th>
                     </tr>
                                    <?php
                                   
                                    if ($nd) {
                                        $bil1 = 1;
                                        ?>
                                      

                                        <tr>
                                            <th class="text-left" width="50%">TARIKH MULA NOMINAL DAMAGES</th>
                                            <td class="text-left" width="50%">
                                        <?php if($nd->dt_nominal)
                                        {
                                            echo strtoupper($nd->dtnominal);
                                        }
                                        else{
                                            echo "Tiada Maklumat";
                                        }
?></td>
                                        </tr>
                                        <tr>
                                            <?php if($nd->nd_nominal)
                                            {?>
                                             <th class="text-left" width="50%">TARIKH TAMAT NOMINAL DAMAGES</th>
                                             <td class="text-left" width="50%"><?= strtoupper($nd->nd_nominal);?></td>

                                            <?php }?>
                                        </tr>
                                        
                                        <tr>
                                             <th class="text-left" width="50%">TEMPOH NOMINAL DAMAGES</th>
                                             <td class="text-left" width="50%">
                                            <?php 
                                          if($nd->nd_nominal)
                    {
                    echo $nd->tempohh;}
                     elseif ($nd->dt_setuju)
                    {
                        echo $nd->tempohhh;
                   
                    }

                    elseif ($nd->j_nd)
                    {
                        echo '<strong><small>'.$nd->tempoh1.'</strong></small>';
                   
                    }
                    else
                    {
                        echo "-";
                        
                    }?>
                                           </td>

     
                                        </tr>
                                         
                                        <tr>
                                             <th class="text-left" width="50%">JUMLAH KUTIPAN (BULANAN) : RM<?= strtoupper($nd->j_nd);?></th>
                                             <td class="text-left" width="50%">
                    <?php
                    if($nd->nd_nominal)
                       {
                           echo "RM".($nd->j_nd * $nd->tempohh);
                           
                       }
                       elseif($nd->dt_setuju)
                       {
                           echo "RM".($nd->j_nd * $nd->tempoh1);
                       }
                      else
                       {
                       echo "RM".($nd->j_nd * $nd->tempohhh);}?>
                    </td>

                                        </tr>
                                           

                                     
                                        
                                      
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

 
