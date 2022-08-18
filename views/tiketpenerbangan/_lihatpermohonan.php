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

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
 

    <div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN TEMPAHAN TIKET PENERBANGAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
<!--  <div class="row">

    <div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
           
          
                 <div class="x_title">
            <h4>UNIT PENGAJIAN LANJUTAN | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN CUTI BELAJAR KAKITANGAN AKADEMIK</u></h4><br/>
            
           <p align ="right">
                    <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  
                </p>
                 
        
        </div>
    </div>
</div>
</div> -->
 <div class="x_panel">
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama:</th>
                        <td><?= $model->kakitangan->displayGelaran . ' ' . ucwords(strtolower($model->kakitangan->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Pekerja:</th>
                        <td><?= $model->kakitangan->COOldID; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jabatan / Seksyen:</th>
                        <td><?= $model->kakitangan->department->fullname; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?= $model->kakitangan->jawatan->nama; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Gred:</th>
                        <td><?= $model->kakitangan->jawatan->gred; ?></td> 
                    </tr>
                    
                   

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Taraf Jawatan:</th>
                        <td><?= $model->kakitangan->statusLantikan->ApmtStatusNm ?></td> 
                    </tr>
                    

                     
                </table>
            </div>   </div>  </div>

           <div class="x_panel">
            <div class="x_title">
                <h2><strong>Maklumat Penumpang Lain</strong></h2> 
                
                <div class="clearfix"></div>
            </div>
                
                            
   <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                     <thead style="background-color:lightseagreen;color:white">
                                <tr class="headings">
                                    <th class="text-center" width="5%" rowspan="2">Bil.</th>
                                    <th class="text-center"  width="40%">Nama</th>
                                    <th class="text-center">Umur</th>
                                    <th class="text-center" width="30%">No. MyKAD/MyPR/KPT/Sijil Lahir</th>
                                    <th class="text-center" colspan="3">Jenis</th>
                                  
                                </tr>
                     </thead>
                     <?php
                    if ($penumpang2) {
                        $counter = 0;
                        foreach ($penumpang2 as $penumpang2) {
                            $counter = $counter + 1;
                            ?>
                        
                           <tr>
                                <td class="text-center"><?= $counter; ?></td>
                                <td class="text-center"><?= $penumpang2->jp_nama; ?></td>
                                <td class="text-center"><?= $penumpang2->umur.' '."Tahun"?></td> 
                                <td class="text-center"><?= $penumpang2->jp_icno; ?></td> 
                                <td class="text-center" colspan="2"><?= $penumpang2->jp_hubungan; ?></td>
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
                </table>
   </div>
        </div>
        <!--           view dyanamic end here--> 

        
                
      
      
<div class="x_panel">
            <div class="x_title">
                <h2><strong>Jadual Penerbangan Yang Dirancang / Ditempah</strong></h2>
               
              

                <div class="clearfix"></div>
            </div>
    
         
   <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                     <thead style="background-color:lightseagreen;color:white">
                                <tr class="headings">
                                    <th class="text-center" width="5%" rowspan="2">Bil.</th>
                                    <th class="text-center" colspan="3">Pelepasan</th>
                                    <th class="text-center" colspan="3">Ketibaan</th>
                                    <th class="text-center">Jenis Tempahan</th>
                                  
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Tarikh</th>
                                    <th class="column-title text-center">Destinasi</th>
                                    <th class="column-title text-center">Masa</th>
                                    <th class="column-title text-center">Tarikh</th>
                                    <th class="column-title text-center">Destinasi</th>
                                    <th class="column-title text-center">Masa</th>
                                    <th class="column-title text-center">(S/P/A)</th>

                                </tr>
                            </thead>
                    <?php
                    if ($jadualTempahan) {
                        $counter = 0;
                        foreach ($jadualTempahan as $jadualTempahan) {
                            $counter = $counter + 1;
                            ?>
                        
                           <tr>
                                <td class="text-center"><?= $counter; ?></td>
                                <td class="text-center"><?= $jadualTempahan->tarikhberlepas; ?></td> 
                                <td class="text-center"><?= $jadualTempahan->dest_berlepas ?></td>
                                <td class="text-center"><?= $jadualTempahan->masa_berlepas ?></td>
                                <td class="text-center"><?= $jadualTempahan->tarikhtiba; ?></td> 
                                <td class="text-center"><?= $jadualTempahan->dest_tiba ?></td>
                                <td class="text-center"><?= $jadualTempahan->masa_tiba ?></td>
                                <td class="text-center"><?= $jadualTempahan->jenistempahan->jenisTempahan ?></td>
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
                </table>
   </div>
            
            
        </div>
      
        <div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
       </h5>
   
   
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>SALINAN DOKUMEN SOKONGAN</center></th>

                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                          SALINAN SURAT TAWARAN CUTI BELAJAR/ SURAT KELULUSAN PELANJUTAN TEMPOH CUTI BELAJAR:
                            </th><?php
                 if ($model->upload->dokumen2) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen2), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td></tr>
                     
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                           SALINAN PASSPORT:
                            </th><?php
                 if ($model->upload->dokumen) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td></tr>
                            
                     
                                               
<tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">CADANGAN AIRLINES :</th>
                        <td><?php if($model->cadangan_airlines){?>
                            <?= strtoupper($model->cadangan_airlines);?>
                        <?php } else {
                            echo "TIADA MAKLUMAT";
                        }
?></td> 

                    </tr> 

                        
                   
                    
                    

                     
                </table>
            </div>  </div>  </div>
      
        
       <div class="row"> 
<div class="col-xs-12 col-md-12 col-lg-12">

      <div class="x_panel">   <div class="x_content">
                <div class="x_title">
   <h5><strong><i class="fa fa-check-square"></i> PERAKUAN KAKITANGAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>PERAKUAN KAKITANGAN</center></th></thead>

                    <tr class="headings">

                    
                
              
              

                    <td class="col-sm-2 text-center">
                        <div >
                             
                <p class="text-justify"><h5><br> 
                   <strong>Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi 
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan.</strong>

                            </h5> 
                            <center><p style="color:black;">Tarikh Mohon: <?php echo $model->tarikh_mohon; ?></p></center><br/>

                    </div>
                    </td>
              
                
                </table>
        </div> </div></div>
</div> </div> 

       

     <?php ActiveForm::end(); ?>
   




