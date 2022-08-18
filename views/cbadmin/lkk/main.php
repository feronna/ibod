


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
                ?><?php echo Html::a('Kembali', ['cbadmin/search-lkk'], ['class' => 'btn btn-primary btn-sm']); ?> </p> 
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
            <legend class="scheduler-border">   <h5><i class='fa fa-bar-chart'></i> LAPORAN KEMAJUAN PENGAJIAN (LKP)</h5>
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
                       
                        
                    </tr>
 </thead>
                    <tbody>

                    <?php $bil=1; foreach ($pengajian as $akademik) { ?>

                        <tr>

                            <td class="text-center" width="5%"><?= $bil++ ?></td>
                            <td class="text-center" width="50%"><?= strtoupper($akademik->tahapPendidikan); ?></td>
                            <td class="text-center">                                        <?= Html::a('<i class="fa fa-bar-chart" aria-hidden="true"></i>', ['cbadmin/lihat-lkp?id='.$akademik->id]) ?> 
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

                






            


              
 
