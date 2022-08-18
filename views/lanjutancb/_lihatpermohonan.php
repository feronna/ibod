<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;

error_reporting(0);
/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
?> 

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
  
 
            <div class="pull-right">
               
<!--//               // echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['/lanjutancb/cetak-permohonan', 'id' =>$iklan->id, 'target'=>'_blank'], [
//                    'class'=>'btn btn-primary btn-sm', 
//                    'target'=>'_self', 
//                    'data-toggle'=>'tooltip', 
//                    'title'=>'Permohonan Pelanjutan Tempoh Cuti Belajar'
//                ]);-->
               <?= Html::a('Kembali', ['cutibelajar/permohonan-semasa'], 
         ['class' => 'btn btn-primary btn-sm']) ?>
    </div> 
       
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | 
     SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN PENGAJIAN LANJUTAN TEMPOH CUTI BELAJAR  KALI
 '); ?><?= $model->idlanjutan;?> 
                </center>  </strong>
            </span> 
        </div>
    </div>
 <div class="x_panel">
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                                     <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>MAKLUMAT PEMOHON</center></th>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAMA:</th>
                        <td><?= strtoupper($model->kakitangan->displayGelaran) . ' ' . ucwords(strtoupper($model->kakitangan->CONm)); ?></td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. PEKERJA:</th>
                        <td><?= $model->kakitangan->COOldID; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. KAD PENGENALAN:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">ALAMAT (TERKINI):</th>
                        <td> <?= $model->alamat;?> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERINGKAT PENGAJIAN:</th>
                        <td><?= ucwords(strtoupper($b->tahapPendidikan)); ?></td> 
                    </tr>
                   <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. TELEFON:</th>
                        <td><?= $model->kakitangan->COHPhoneNo; ?></td> 
                    </tr>
                    
                    
                     <tr>
                            <th width="25%">JFPIB: </th>
                            <td width="85%"><?=  ucwords(strtoupper($model->kakitangan->displayDepartment)) ?></td>  
                     </tr>
                    
                     

                    
                    

                     
                </table>
            </div>  </div>  </div>
  
<div class="x_panel">   <div class="x_content">
<div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped "> 
                    <tr>
                    <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>MAKLUMAT PRESTASI PENGAJIAN (TERKINI)</center></th>

                     </tr>
                     <tr class="headings">
                        <th class="column-title text-center">BIL</th>
                        <th class="column-title text-center" width="40%">PERKARA</th>
                        <th class="column-title text-center">PERATUSAN/ TARIKH/ BILANGAN</th>
                    </tr>
                     <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:lightblue;">PENYELIDIKAN:</th>
                    
                </tr>
             <?php
                            if ($doktoral) 
                            { $no=0;?>
                            
                                <?php foreach ($doktoral as $dok) { 
                                    
                                    if($dok->id < 7)
                                    {
                                      
                                    $no++; 
//                                 $mod = \app\models\cbelajar\TblPrestasi::find()->where(['id' => $dok->id, 'idLanjutan'=> 37, 'iklan_id'=>15])->one();
//                                   $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $dok->syarat_id, 'icno' => $icno, 'iklan_id'=>$kontrak->iklan_id])->one();
                                  $mod = \app\models\cbelajar\TblPrestasi::find()->where(['idPrestasi' => $dok->id, 'idLanjutan'=>$model->id,'iklan_id'=>$iklan->id])->one();

                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center"><?php echo $dok->prestasi; ?></td>
                                    <td class="text-center"><?php echo $mod->catatan; ?></td>

                                   
                                </tr>
                                
                                
                                    <?php 
                                    
                                }}?>
                 <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:lightblue;">KERJA KURSUS:</th>
                    
                </tr>
                
                     <?php foreach ($doktoral as $dok) { 
                                    if($dok->id >= 7)
                                    {
                                  
                                    $no++; 
                                  $mod = \app\models\cbelajar\TblPrestasi::find()->where(['idPrestasi' => $dok->id, 'idLanjutan'=>$model->id,'iklan_id'=>$iklan->id])->one();

                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center"><?php echo $dok->prestasi; ?></td>
                                    <td class="text-center"><?php echo $mod->catatan; ?></td> 

                                   
                                </tr>
                                
                                
                                    <?php 
                                    
                                    }
                                    }
                               
//                             }
                            }
                            ?>

                   
            

                    
                    

                     
                </table>
</div> </div></div>
<div class="x_panel">
    <div class="x_title">
   <h5><strong><i class="fa fa-th-list"></i> MAKLUMAT PELANJUTAN TERDAHULU</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
<div>
<form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   <thead style="background-color:lightseagreen;color:white">
       
        <tr class="headings">
          <th class="column-title text-center" width="50px" height="20px">BIL</th>
            <th>TARIKH PELANJUTAN CUTI BELAJAR </th>
            <th class="column-title text-center">TEMPOH </th>
            <th class="column-title text-center">PELANJUTAN KALI KE</th>
            <th class="column-title text-center">JUSTIFIKASI</th>

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
<td class="text-center"><?= $l->justifikasi; ?></td>


            
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
<div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
       </h5>
   
   
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>PELANJUTAN BAHARU YANG DIPOHON</center></th>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TEMPOH MASA (BULAN):</th>
                        <td> <?= $model->tempohlanjutan;?></td>
</td> 
                    </tr>
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH PELANJUTAN CUTI BELAJAR:</th>
                        <td> <?= strtoupper($model->lanjutansdt);?> Hingga <?= strtoupper($model->lanjutanedt);?>  </td>

                    </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JUSTIFIKASI PELANJUTAN:</th>
                        <td> <?= $model->justifikasi;?></td>
</td> 
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SURAT SOKONGAN DAN PERAKUAN PENYELIA:</th>
                        
                     
                      <td class="text-justify">
                            <?php if($model->dokumen_sokongan)
                            {?>
                            <a class="form-control" style="background-color: 
                                             transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" > <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
                            <?php }else{
                                
                                echo 'Tiada Maklumat';
                            }
?> </td> 
                        
               
                        

                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">PERANCANGAN PENGAJIAN (STUDY PLAN) TERDAHULU:</th>
                        
                     
                     
<td class="text-justify">
                            <?php if($model->dokumen)
                            {?>
                            <a class="form-control" style="background-color: 
                                             transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen), true); ?>" target="_blank" > <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
                            <?php }else{
                                
                                echo 'Tiada Maklumat';
                            }
?> </td>                         
               
                        

                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">PERANCANGAN PENGAJIAN YANG DIUBAHSUAI:<br>
                          <small><i>MENGAMBIL KIRA TEMPOH PELANJUTAN YANG DIPOHON</th>
                        
                     
                                 <td class="text-justify">
                            <?php if($model->dokumen2)
                            {?>
                            <a class="form-control" style="background-color: 
                                             transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen2), true); ?>" target="_blank" > <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
                            <?php }else{
                                
                                echo 'Tiada Maklumat';
                            }
?> </td> 
                        
               
                        

                        
                    </tr>
                    
                    <?php if($b->tajaan->jenisCd == 3){?>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">BORANG PERMOHONAN PELANJUTAN BIASISWA KPT:<br>
                        </th>                        
                     
 <td class="text-justify">
                            <?php if($model->dokumen3)
                            {?>
                            <a class="form-control" style="background-color: 
                                             transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen3), true); ?>" target="_blank" > <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
                            <?php }else{
                                
                                echo 'Tiada Maklumat';
                            }
?> </td> 
                        
               
                    <?php }?>       

                        
                    </tr>
                     <tr class="headings">
                        
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN KEMAJUAN PENGAJIAN:</th>
          <?php 
                  
          if($lkk)
          {
                  if((!$lkk->status_bsm == "Admin Manually Upload")) 
                      
                      {?>
                  <td> 
                    <?= Html::a('<i class="fa fa-check  fa-lg aria-hidden="true"   style="color: green"></i> <small>TELAH DIHANTAR</small>', 
                        ['lkk/lihat-borang-staff', "id"=> $lkk->reportID], ['class' => 'btn btn-default btn-xs']) ?>
                    <?= $lkk->tarikh_hantar; ?> <?php   
                    
                      }
                
                      else{ ?>
                  
                                  <td class="text-justify">  <?= Html::a('<i class="fa fa-check  fa-lg aria-hidden="true"   style="color: green"></i> <small>TELAH DIHANTAR</small>', 
                        ['lkk/lihat-permohonan', "id"=> $lkk->reportID], ['class' => 'btn btn-default btn-xs']) ?>
                    <?= $lkk->tarikh_hantar; ?><br>
 </td>
                                               <?php }
                    
                
          }                                  
        
       else{
                    ?>
                  
                        <td colspan="8"><b>Tiada Maklumat</b></td>                     
                    
                  <?php  
                }
                
                
?> 
                 
                                             

                        
                    </tr>
                     <tr class="headings">
                        
                        <th class="col-md-3 col-sm-3 col-xs-12"> TRANSKRIP KEPUTUSAN PEPERIKSAAN:</th>
          <?php 
                  
                  if(($lkk->status_jfpiu == "Tunggu Perakuan") || ($lkk->status_jfpiu == "Diperakukan")) 
                      
                      {?>
                  <td> 
                    <?= Html::a('<i class="fa fa-check  fa-lg aria-hidden="true"   style="color: green"></i> <small>TELAH DIHANTAR</small>', 
                        ['lkk/lihat-permohonan', "id"=> $lkk->reportID], ['class' => 'btn btn-default btn-xs']) ?>
                    <?= $lkk->tarikh_hantar; ?> <?php   
                    
                      }  
                    
                    elseif ($model->upload->dokumen_sokongan2) { ?>
                  
                                  <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                               href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>"
                                                               target="_blank" ><i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN
                                              </small></u></strong></a><br>
 </td>
                                               <?php }
        
       else{
                    ?>
                  
                        <td colspan="8"><b>Tiada Maklumat</b></td>                     
                    
                  <?php  
                }
                
                
?> 
                 
                                             

                        
                    </tr>
                    
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH MOHON:</th>
                        <td> <?= $model->tarikh_mohon;?>  </td>

                        
                    </tr>
                    
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PERMOHONAN:</th>
                        <td> <?= ucwords(strtoupper($model->status));?>  </td>

                        
                    </tr>

                </table>
            </div>  
        
       </div>  </div>
<div class="row" > 
    <div class="col-xs-12 col-md-12 col-lg-12"> 

    <div class="x_panel">
        <div class="x_title">
            <h5><strong><i class="fa fa-check-square"></i> PERAKUAN PEMOHON </strong></h5>
           
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <h3 style="color:grey;" ><small><center>Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan.</center></small> </h3>
            <h4 style="color:grey;"><small><center>Tarikh Hantar: <?php echo $model->tarikhmohon;?></center></small></h4><br/>
        </div>
    </div>
</div>
    
</div>
     <?php ActiveForm::end(); ?>
   




