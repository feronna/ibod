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
  <p align="right"><?= Html::a('Kembali', ['cutibelajar/permohonan-semasa'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>

    <div class="x_panel">
        <div class="x_content">  
            <div class="pull-right">
                <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['/lanjutancb/cetak-permohonan', 'id' =>$iklan->id, 'target'=>'_blank'], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Permohonan Pelanjutan Tempoh Cuti Belajar'
                ]);
                ?>
    </div> 
            <span class="required" style="color:black;">
                <strong>
                    <h2><center><?= strtoupper('
    <u> PERMOHONAN PENGAJIAN LANJUTAN TEMPOH CUTI BELAJAR
 '); ?> <?= $l->idlanjutan; ?>
                </strong> </center></h2>
            </span> 
        </div>
        
        
    </div>
<!--  <div class="row">

    <div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
           
          
                 <div class="x_title">
            <h4>UNIT PENGAJIAN LANJUTAN | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN CUTI BELAJAR KAKITANGAN AKADEMIK</u></h4><br/>
            
           <p align ="right">
                    <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-xs']); ?>  
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
                                     <th scope="col" colspan=12"  style="background-color:white;"><center>MAKLUMAT PEMOHON</center></th>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama:</th>
                        <td><?= $model->kakitangan->displayGelaran . ' ' . ucwords(strtolower($model->kakitangan->CONm)); ?></td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Pekerja:</th>
                        <td><?= $model->kakitangan->COOldID; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Alamat (Terkini):</th>
                        <td> <?= $model->alamat;?> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERINGKAT PENGAJIAN:</th>
                        <td><?= ucwords(strtoupper($model->study->pendidikanTertinggi->HighestEduLevel)); ?></td> 
                    </tr>
                   <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Telefon:</th>
                        <td><?= $model->kakitangan->COHPhoneNo; ?></td> 
                    </tr>
                    
                    
                     <tr>
                            <th width="25%">Jabatan/Fakulti/Pusat/Institut: </th>
                            <td width="85%"><?=  ucwords(strtolower($model->kakitangan->displayDepartment)) ?></td>  
                     </tr>
                    
                     

                    
                    

                     
                </table>
            </div>  </div>  </div>
  
<div class="x_panel">   <div class="x_content">
<div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped "> 
                    <tr>
                    <th scope="col" colspan=12"  style="background-color:white;"><center>MAKLUMAT PRESTASI PENGAJIAN (TERKINI)</center></th>

                     </tr>
                     <tr class="headings">
                        <th class="column-title text-center">BIL</th>
                        <th class="column-title text-center" width="40%">PERKARA</th>
                        <th class="column-title text-center">PERATUSAN/ TARIKH/ BILANGAN</th>
                    </tr>
                     <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:white;">PENYELIDIKAN:</th>
                    
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
                                    <td class="text-justify"><?php echo $dok->prestasi; ?></td>
                                    <td class="text-justify"><?php echo $mod->catatan; ?></td>

                                   
                                </tr>
                                
                                
                                    <?php 
                                    
                                }}?>
                 <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:white;">KERJA KURSUS:</th>
                    
                </tr>
                
                     <?php foreach ($doktoral as $dok) { 
                                    if($dok->id >= 7)
                                    {
                                  
                                    $no++; 
                                  $mod = \app\models\cbelajar\TblPrestasi::find()->where(['idPrestasi' => $dok->id, 'idLanjutan'=>$model->id,'iklan_id'=>$iklan->id])->one();

                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->prestasi; ?></td>
                                    <td class="text-justify"><?php echo $mod->catatan; ?></td> 

                                   
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
   <h5><strong><i class="fa fa-th-list"></i> MAKLUMAT PELANJUTAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
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
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                <th scope="col" colspan=12"  style="background-color:white;"><center>PELANJUTAN BAHARU YANG DIPOHON</center></th>

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
                        
                     
                        <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><button class="btn btn-primary btn-xs">Perakuan Penyelia</button></a><br>
 </td>
                        
               
                        

                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">PERANCANGAN PENGAJIAN (STUDY PLAN) TERDAHULU:</th>
                        
                     
                        <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen), true); ?>" target="_blank" ><button class="btn btn-primary btn-xs">Perancangan Pengajian (Asal)</button></a><br>
 </td>
                        
               
                        

                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">PERANCANGAN PENGAJIAN YANG DIUBAHSUAI:<br>
                          <small><i>MENGAMBIL KIRA TEMPOH PELANJUTAN YANG DIPOHON</th>
                        
                     
                        <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen2), true); ?>" target="_blank" ><button class="btn btn-primary btn-xs">Perancangan Pengajian Yang Diubahsuai</button></a><br>
 </td>
                        
               
                        

                        
                    </tr>
                  
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">TRANSKRIP KEPUTUSAN PEPERIKSAAN:</th>
                        <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" ><button class="btn btn-primary btn-xs">Transkrip Peperiksaan</button></a><br>
                        </td>                        

                        
                    </tr>
                    
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH MOHON:</th>
                        <td> <?= $model->tarikh_mohon;?>  </td>

                        
                    </tr>
                    
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">Status Permohonan:</th>
                        <td> <?= ucwords(strtoupper($model->status));?>  </td>

                        
                    </tr>

                </table>
            </div>  
        
       </div>  </div>
     <?php ActiveForm::end(); ?>
   




