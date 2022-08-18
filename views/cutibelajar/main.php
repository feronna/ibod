<?php 
 use yii\helpers\Html;

 
 echo $this->render('/cutibelajar/_topmenu'); 
 
 error_reporting(0);?> 
 <p align="right"><?= Html::a('Kembali', ['cutibelajar/halaman-pemohon'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>

<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | 
     BAHAGIAN SUMBER MANUSIA<br/><u> REKOD PENGAJIAN LANJUTAN DILULUSKAN
 '); ?>
                </center>  </strong>
            </span> 
        </div>
    </div>
<div class="x_panel">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_title">
   <h5 ><strong><i class="fa fa-user-circle"></i> MAKLUMAT PERIBADI</strong></h5>
   
   
   <div class="clearfix"></div>
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
<!--                        <h4 colspan="2" style="background-color:lightseagreen;color:white"><center>MAKLUMAT PERIBADI</center></h4>-->

            <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <th colspan="4" class="text-center">
                <h5><center><?=  strtoupper($biodata->CONm); ?> |
                    <?=date("Y") - date("Y", strtotime($biodata->COBirthDt))." ". "TAHUN"?> </center></h5> 

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
                        <td style="width:20%"><?= strtoupper($biodata->displayStartLantik); ?></td>
                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                                    if ($biodata->confirmDt) {
                                        echo strtoupper($biodata->confirmDt->tarikhMula);
                                    } else {
                                        echo 'TIADA MAKLUMAT';
                                    }
                                    ?></td>


                    </tr>
                    <tr> 

                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                                    if ($biodata->confirmDt) {
                                        echo strtoupper($biodata->confirmDt->tarikhMula);
                                    } else {
                                        echo 'TIADA MAKLUMAT';
                                    }
                                    ?></td>
                        <th style="width:20%">TEMPOH BERKHIDMAT SEMASA</th>
                        <td style="width:20%"><?= strtoupper($biodata->servPeriodPermanent)  ?></td>


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
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_title">
   <h5 ><strong><i class="fa fa-calculator"></i> BON PERKHIDMATAN & TUNTUTAN GANTIRUGI</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
          
            
                
                
                    <div class="col-md-12 col-sm-12 col-xs-12"> 

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 
                                            <th scope="col" colspan="6" width="100%" style="background-color:lightseagreen;color:white"><center>MAKLUMAT BON PERKHIDMATAN</center></th>

                                    <?php
//                                    $B = $biodata->pengajian;
                                    if ($bon) {
                                        $bil1 = 1;
                                        ?>

                                        <tr>
                                            <th class="text-center">TARIKH MULA BERKHIDMAT</th>
                                            <th class="text-center">PERINCIAN</th>
<!--                                            <th class="text-center" style="width: 10%;">TEMPOH PENGAJIAN</th>-->
                                          

                                        </tr>
<!--                                             <tr><th class="text-center">CATATAN</th></tr>-->
                                       


                                        <?php foreach ($bon as $l) { ?>

                                            <tr>
                                                <td class="text-center"><?= strtoupper($l->dt_mkhidmat);?></td>
                                            
                                                <td class="text-center" scope="col" colspan="6"><?= strtoupper($l->catatan);?></td></tr>
                                                
                                            </tr>
                                                <tr><th class="text-right" scope="col">JUMLAH TEMPOH PERKHIDMATAN</th>
                                                 <td class="text-center" ><?= strtoupper($l->j_bon);?></td></tr>

                                            <?php
                                        }
                                        
                                    }
                                    else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center"><i>TIADA MAKLUMAT</i></td>                     
                        </tr>
<?php }
                                    ?>
                                            
                                </table>
                             
                            </div>
                        </div>
                    </div>
            
            
</div>
            
                    <div class="col-md-12 col-sm-12 col-xs-12"> 
                        <div class="x_content">

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 
                                    <th scope="col" colspan="6" width="100%" style="background-color:lightseagreen;color:white"><center>PENGIRAAN JUMLAH GANTIRUGI</center></th>
                                    <?php
//                                    $B = $biodata->pengajian;
                                    if ($tuntut) {
                                        $bil1 = 1;
                                        ?>
                                            

                                        <tr>
                                            <th class="text-left" width="50%">PERKARA</th>
                                            <th class="text-center">PERINCIAN</th>
<!--                                            <th class="text-center" style="width: 10%;">TEMPOH PENGAJIAN</th>-->
                                          

                                        </tr>
<!--                                             <tr><th class="text-center">CATATAN</th></tr>-->
                                       


                                        <?php foreach ($tuntut as $l) { ?>

                                             <tr>
                                                <td class="text-left"><b>JENIS TUNTUTAN GANTIRUGI</b></td>
                                                <td class="text-left"><?= $l->jenis_tuntutan;?></td></tr>
                                             <tr>
                                                <td class="text-left"><b>PERKARA</b></td>
                                                <td class="text-left"><?= $l->perkara;?></td></tr> 
                                             <tr>
                                                <td class="text-left"><b>PERINCIAN PERKARA</b></td>
                                                <td class="text-left"><?= $l->c1;?></td></tr>
                                             
                                             <tr>
                                                <td class="text-left"><b>JUMLAH PENGAJIAN</b></td>
                                                <td class="text-left">RM<?= $l->j_cb;?></td></tr>
                                             
                                             <tr>
                                                <td class="text-left"><b>JUMLAH TUNTUTAN KESELURUHAN</b></td>
                                                <td class="text-left">RM<?= $l->j_keseluruhan;?></td></tr>
                                             
                                             <tr>
                                                <td class="text-right"><b>ANSURAN BULANAN</b></td>
                                                <td class="text-left">RM<?= $l->j_gantirugi;?></td></tr>
                                      

                                            <?php
                                        }
                                        
                                    }
                                    else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center"><i>TIADA MAKLUMAT</i></td>                     
                        </tr>
<?php }
                                    ?>
                                            
                                </table>
                             
                            </div>
                 
                    </div>
                
      
</div>
</div>

         <div class="x_panel">
<div class="col-md-12 col-sm-12 col-xs-12">
          
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
                                            <td class="text-left" width="50%"><?= strtoupper($nd->dt_nominal);?></td>
                                        </tr>
                                        <tr>
                                             <th class="text-left" width="50%">TARIKH TAMAT NOMINAL DAMAGES</th>
                                             <td class="text-left" width="50%"><?= strtoupper($nd->nd_nominal);?></td>


                                        </tr>
                                        
                                        <tr>
                                             <th class="text-left" width="50%">TEMPOH NOMINAL DAMAGES</th>
                                             <td class="text-left" width="50%"><?= strtoupper($nd->nd_nominal);?></td>

     
                                        </tr>
                                         
                                        <tr>
                                             <th class="text-left" width="50%">JUMLAH KUTIPAN</th>
                                             <td class="text-left" width="50%"><?= strtoupper($nd->j_nd);?></td>

                                        </tr>
                                           

                                     
                                        
                                      
<?php }
                                    else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center"><i>TIADA MAKLUMAT</i></td>                     
                        </tr>

                            <?php   }?>
                                            
                                </table>
                             
                            </div>
                        </div>
                    </div>
                
        </div>
</div>
 
 
 </div>