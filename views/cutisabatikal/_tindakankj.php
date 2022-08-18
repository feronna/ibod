<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;
use kartik\select2\Select2;


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
            
            <span class="required" style="color:black;">
                <strong>
                    <h2><center><?= strtoupper('
    <u> PERMOHONAN PENGAJIAN LANJUTAN TEMPOH CUTI BELAJAR
 '); ?>
                </strong> </center></h2>
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
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Telefon:</th>
                        <td><?= $model->kakitangan->COHPhoneNo; ?></td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Peringkat Pengajian:</th>
                        <td><?= ucwords(strtolower($model->maklumat->HighestEduLevel)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Institusi Pengajian:</th>
                        <td><?= ucwords(strtolower($model->maklumat->InstNm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Biasiswa:</th>
                        <td><?= ucwords(strtoupper($model->maklumat->tajaan)); ?></td> 
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
                                   $mod = \app\models\cbelajar\TblPrestasi::find()->where(['idPrestasi' => $dok->id])->one();

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
<div class="x_panel">   <div class="x_content">
<div class="table-responsive">
                <table class="table table-sm table-striped jambo_table table-bordered"> 
                    <tr>
                    <th scope="col" colspan=12"  style="background-color:white;"><center>MAKLUMAT PRESTASI PENGAJIAN (TERKINI)</center></th>

                     </tr>
                     <tr class="headings">
                        <th class="column-title text-center">PERKARA</th>
                        <th class="column-title text-center" width="40%">PELANJUTAN PERTAMA</th>
                        <th class="column-title text-center">PELANJUTAN KEDUA</th>
                    </tr>
            
                   <tr class="headings">
                        <th class="column-title text-center">Tempoh</th>
                        <td class="text-justify"> </td>
                        <td class="text-justify"></td>

                        
                    </tr>
            
                     <tr class="headings">
                        <th class="column-title text-center">Tarikh Kelulusan</th>
                        <td class="text-justify">Mula </td>
                        <td class="text-justify">Mula</td>

                        
                    </tr>
            
                     <tr class="headings">
                        <th class="column-title text-center">Justifikasi Pelanjutan Terdahulu</th>
                        <td class="text-justify"> </td>
                        <td class="text-justify"></td>

                        
                    </tr>
                    
                    
                     
                </table>
</div> </div></div>
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
                        <th class="col-md-3 col-sm-3 col-xs-12">Tempoh Masa (bulan):</th>
                        <td> <?= $model->tempoh_masa;?> <b>Bulan</b></td>
</td> 
                    </tr>
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Mula:</th>
                        <td> <?= $model->fulldt;?>  </td>

                    </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Justifikasi Pelanjutan:</th>
                        <td> <?= $model->justifikasi;?></td>
</td> 
                    </tr>
                  <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">Surat Sokongan dan Perakuan Penyelia:</th>
                        
                     
                        <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i class="fa fa-file-pdf-o"></i></a><br>
 </td>
                        
               
                        

                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">Transkrip Keputusan Peperiksaan:</th>
                        <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" ><i class="fa fa-file-pdf-o"></i></a><br>
                        </td>                        

                        
                    </tr>
                    
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Mohon:</th>
                        <td> <?= $model->tarikh_mohon;?>  </td>

                        
                    </tr>
                    
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">Status Permohonan:</th>
                        <td> <?= ucwords(strtoupper($model->status));?>  </td>

                        
                    </tr>

                </table>
            </div>  
        
       </div>  </div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 
    <div class="x_panel">
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                <th scope="col" colspan=12"  style="background-color:white;"><center>STATUS PERAKUAN KETUA JABATAN</center></th>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Status Perakuan:</th>
                        <td> <?= $model->status_jfpiu;?></td>
</td> 
                    </tr>
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Ulasan:</th>
                        <td> <?= $model->ulasan_kj;?>  </td>

                    </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Diperakukan:</th>
                        <td> <?= $model->app_date;?></td>

                    </tr>
               
                        
               
                        

                        
                   
                 

                </table>
            </div>  
        
       </div>  </div>
</div>     
</div>
 <div class="row">
  <!-- Perakuan Ketua Jabatan -->
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Perakuan Ketua Jabatan</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Perakuan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status_jfpiu')->label(false)->widget(Select2::classname(), [
                        'data' => ['Diperakukan' => 'PERMOHONAN DISOKONG', 'Tidak Diperakukan' => 'PERMOHONAN TIDAK DISOKONG'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Diperakukan"){
                        $("#ulasan").show();$("#ulasan1").show();
                        }
                        else if($(this).val() == "Tidak Diperakukan"){
                        $("#ulasan1").show();$("#ulasan").hide();}
                        
                        else{$("#ulasan").hide();$("#ulasan1").hide()
                        }'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        
                       
                    ]);
                    ?>
                </div>
        </div>
<!--        <div class="form-group" id="ulasan" style="display: none" align="center">
        <div style="width: 580px; height: 130px;border:2px solid red">
            <br><p align="left">&nbsp;Saya mengambil maklum bahawa telah menerima permohonan pelanjutan tempoh cuti belajar bagi <br>
               &nbsp;1. Tarikh dan tempoh cuti belajar sesuai.<br>
               &nbsp;2. Fungsi JFPIU tidak akan terjejas sepanjang ketidakberadaan kakitangan.<br>
               &nbsp;3. Saya bersetuju untuk memberi pelepasan kepada beliau tanpa staf gantian.</p>
            </div>
        </div>        -->
        <div class="form-group" id="ulasan1" style="display: none" align="center">
            <h5 style="font-size:120%;" class="text-justify"> 
                </h5>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_kj')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
            <div class="ln_solid"></div>
           <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                <button class="btn btn-primary" type="reset">Reset</button> 
            </div>
    </div>
</div>
        

    </div>
     <?php ActiveForm::end(); ?>
   




