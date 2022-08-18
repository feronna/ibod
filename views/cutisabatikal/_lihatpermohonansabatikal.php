<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
?> 
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
<p align="right"> 

<?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['cetak-borang-sabatikal', 'id'=>$model->id,
                    'ICNO'=>$model->icno, 'takwim_id'=> $model->iklan_id,'target'=>'_blank'], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Permohonan Baharu Pengajian Lanjutan'
                ]);
                ?>
 <?= Html::a('Kembali', ['cbadmin/senaraitindakan1'], ['class' => 'btn btn-primary btn-sm']) ?></p>
<div class="x_panel">
        <div class="x_content"> 
              
            <span class="required" style="color:black;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGAJIAN LANJUTAN | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN CUTI SABATIKAL/LATIHAN INDUSTRI
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
                <center> <?php
                       
                        if ($img) {
                            echo Html::img($img->getImageUrl().$img->filename, [
                                'class' => 'img-thumbnail',
                                'width' => '150',
                                'width' => '150',
                            ]);
                        }
                        ?>  </center>
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
                <h5><?= strtoupper($model->kakitangan->displayGelaran) ?><?=  strtoupper($biodata->CONm); ?> |
                <?=date("Y") - date("Y", strtotime($biodata->COBirthDt))." ". "TAHUN"?></h5>
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
                       <th width="20%">TARAF PERKAHWINAN: </th>
                       <td><?= strtoupper($biodata->displayTarafPerkahwinan) ?></td> 

                    </tr>
                    <tr> 

                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                                    if ($biodata->confirmDt) {
                                        echo strtoupper($biodata->confirmDt->tarikhMula);
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
   
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
              <div class="x_title">
                <h5><strong><i class="fa fa-book"></i> MAKLUMAT AKADEMIK</strong></h5>
                
                
                <div class="clearfix"></div>
            </div>
            <?php
                    $akademik = $biodata->akademik;
              if($akademik){ ?>
            
            <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead style="background-color:lightseagreen;color:white">
                      
                    <tr class="headings">
                        <th class="column-title text-center">BIL</th>
                        <th class="column-title text-center">TAHAP PENDIDIKAN </th>
                        <th class="column-title text-center">BIDANG</th>
                        <th class="column-title text-center">UNIVERSITI/INSTITUSI</th>
                        <th class="column-title text-center">KELAS/CGPA</th>
                        <th class="column-title text-center">TARIKH DIANUGERAHKAN</th>
                        <th class="column-title text-center">TAJAAN</th>
                        
                    </tr>
 </thead>
                    <tbody>

                    <?php $bil=1; foreach ($akademik as $akademik) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            <td><?= strtoupper($akademik->tahapPendidikan); ?></td>
                            <td><?= strtoupper($akademik->namaMajor);?></td>
                            <td><?= strtoupper($akademik->namainstitut);?></td>
                            <td><?= strtoupper($akademik->OverallGrade);?></td>
                            <td class="text-center"><?= strtoupper($akademik->confermentDt);?></td> 
                            <td ><?= strtoupper($akademik->Sponsorship);?></td>

                        </tr>
                    <?php } ?>
                    </tbody>
              
                
                </table>

             </div>
              <?php }?>
    </div>
</div>

</div>
<div class="x_panel">
<div class="col-xs-12 col-md-12 col-lg-12">

<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN YANG DIPOHON</strong></h5>
   
   
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
                                
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($pengajian->InstNm); ?></td><?php }?></tr>
                        
                        
                   
                     
                       
                 
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
                    
                     <tr> 
                                
                        <th style="width:10%" align="right">MOD PENGAJIAN</th>
                        <td style="width:20%">
                            
                                  <?php if($pengajian->modeID)
                                  {echo strtoupper($pengajian->mod->studyMode);}
                                  
                                  else{
                                      echo "Tiada Maklumat";
                                  }
?></td></tr>
                     
                      
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($pengajian->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->tarikhtamat)?> (<?= strtoupper($pengajian->tempohtajaan);?>)</td>
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

        </div></div>
  </div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
            <div class="x_title">
   <h5 ><strong><i class="fa fa-money"></i> MAKLUMAT BIASISWA/PEMBIAYAAN YANG DIPOHON</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
              <?php 
                  
              if($biasiswa){ ?>
 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead style="background-color:lightseagreen;color:white">
                       
                    <tr class="headings">
                        
                       
                        <th class="column-title text-center">NAMA AGENSI/TAJAAN </th>
                        <th class="column-title text-center">JENIS TAJAAN</th>
                        <th class="column-title text-center">JUMLAH AMAUN (RM)</th>
                       
                    </tr>
</thead>
                
                <tbody>

                    <?php $bil=1; foreach ($biasiswa as $biasiswa) { ?>

                        <tr>

                            <td class="text-center"><?= $biasiswa->nama_tajaan; ?></td>
                            <td class="text-center"><?=  $biasiswa->bantuan->bentukBantuan;?></td>
                            <td class="text-center">RM<?=  $biasiswa->amaunBantuan;?></td>
                            
                           
                        
                        </tr>
                    <?php } ?>
                        
                </tbody>

</table></form>
             


          
        </div>   
     <?php }
      else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center"><b>Tiada Rekod Maklumat Pembiayaan / Pinjaman yang dipohon</b></td>                     
                    </tr>
                  <?php  
                } ?> 

      

    </div>
</div>
  
</div>

      
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
            <div class="x_title">
   <h5 ><strong><i class="fa fa-paperclip"></i> DOKUMEN BAGI PERMOHONAN CUTI SABATIKAL / LATIHAN INDUSTRI</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
              <?php if($dokumen){ ?>
<!--            <div class="x_title">
                <h2><strong><i class="fa fa-list-alt"></i> Dokumen Yang Telah Dimuatnaik </strong></h2>
                 <p align="right">
                
                </p>
                <div class="clearfix"></div>
            </div>-->

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                
                       <table class="table table-bordered jambo_table">
                    <thead style="background-color:lightseagreen;color:white">
                        
                    <tr class="headings">
                        <th class="column-title text-center">BIL</th>
                        <th class="column-title text-center">NAMA DOKUMEN </th>
                        
                        
                       
                    </tr>

                </thead>
                <tbody>
<!--                  <h5><strong>DOKUMEN BAGI PERMOHONAN CUTI SABATIKAL / LATIHAN INDUSTRI</strong></h5>-->

                   <?php
                    if ($dokumen) {
                        $counter = 0;
                        foreach ($dokumen as $dokumen) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center" style="width:5%;"><?= $counter; ?></td> 
                                
                                <td><?php if((!empty($dokumen->nama_dokumen))&& (!empty($dokumen->namafile))):?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen->namafile), true); ?>" target="_blank"/> <u><?php echo $dokumen->nama_dokumen ?>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen->namafile, true);?>"/>-->
                                            <?php endif;?></u>
                      
                                            
                                         
                                      </td>
                                


<!--                                <td class="text-center">
                                <td class="text-center">
                                   

                                  <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i>',['uploads/', 'namafile' => $dokumen->namafile] , ['class' => 'btn btn-default', 'target'=>"_blank"]) ?> 
                                 
                                    
                                  </td>  -->
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                </tbody>

                     </table>

 
                </form>



            </div>
        </div>
    </div>
</div>

      <?php } ?>
 


    
<div class="row" > 
    <div class="col-xs-12 col-md-12 col-lg-12"> 

    <div class="x_panel">
        <div class="x_title">
            <h5><strong><i class="fa fa-check-square"></i> PERAKUAN PEMOHON </strong></h5>
           
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <h4 style="color:grey;" ><small>Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi <br/>
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal<br/> dengan sendirinya dan boleh diambil tindakan perundangan.</small> </h4>
            <h6 style="color:grey;"><small>Tarikh Hantar: <?php echo $model->tarikhmohon;?></small></h6><br/>
        </div>
    </div>
</div>
    
</div>

<div class="x_panel">                  
<div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white">                
<center>STATUS PERAKUAN KETUA JABATAN/DEKAN</center></th>

                    
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH MOHON:</th>
                        <td> <?= $model->tarikh_m;?>  </td>

                        
                    </tr>
                    
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS KETUA JABATAN/DEKAN:</th>
                        <td> <?php if($model->status_jfpiu == "DALAM TINDAKAN KETUA JABATAN")
                        {
                            
                            echo "MENUNGGU PERAKUAN";
                        }
                        else
                        {
                            echo strtoupper($model->statusjfpiu).'  [ '. $model->app_date. ' ] ';
                        }?>
                </td>

                        
                    </tr>
                    
                    
                     
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">ULASAN JFPIU:</th>
                        <td><?php if($model->status_jfpiu == "DALAM TINDAKAN KETUA JABATAN")
                        {
                            
                            echo "-";
                        }
                        else
                        {
                            echo strtoupper($model->ulasan_jfpiu);
                        }?>   </td>

                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">DIPERAKUKAN OLEH:</th>
                        <td> <?=$model->ketuajfpiu ?>
                </td>

                        
                    </tr>
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PERMOHONAN:</th>
                        <td> <?= ucwords(strtoupper($model->status));?>  </td>

                        
                    </tr>

                </table>
            </div>  
        
       </div>
</div>