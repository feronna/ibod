<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\TopMenuWidget;
use yii\helpers\ArrayHelper;
use app\models\cbelajar\PendidikanTertinggi;
use app\models\cbelajar\Modpengajian;
use app\models\hronline\Negara;
use app\models\hronline\MajorMinor; 
error_reporting(0);
?>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="x_panel">
        <div class="x_content">  
           
            <span class="required" style="color:blue;">
                <strong>
                    <h2><?= strtoupper('
    <u> KEMASKINI MAKLUMAT PRESTASI PENGAJIAN TERKINI</u>
 '); ?>  

                </strong>
            </span> &nbsp;
         <?= Html::a('Kembali', ['lanjutancb/adminview' , 'id'=>$model->iklan_id, 'i'=>$model->id], ['class' => 'btn btn-primary btn-sm']) ?></h2>
            
        </div>

        
        
    </div>
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
                        <th class="column-title text-center">KOMEN</th>

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
                                  $mod = \app\models\cbelajar\TblPrestasi::find()->where
                                  (['idPrestasi' => $dok->id, 'idLanjutan'=>$model->id, 'iklan_id'=>$model->iklan_id])->one();

                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->prestasi; ?></td>
                                    <td class="text-justify"><?php echo $mod->catatan; ?>
                                    <td class="text-justify"><textarea id="komen" class="form-control" name="<?= $dok->id?>"><?= $mod->komen?></textarea></td> 

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
                                  $mod = \app\models\cbelajar\TblPrestasi::find()->where(['idPrestasi' => $dok->id, 'idLanjutan'=>$model->id, 'iklan_id'=>$model->iklan_id])->one();

                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->prestasi; ?></td>
                                    <td class="text-justify"><?php echo $mod->catatan; ?>
                                    <td class="text-justify"><textarea id="komen" class="form-control" name="<?= $dok->id?>"><?= $mod->komen?></textarea></td> 

                                   
                                </tr>
                                
                                
                                    <?php 
                                    
                                    }
                                    }
                               
//                             }
                            }
                            ?>

                   
            

                    
                    

                     
                </table>
   <div class="form-group">
                <div class="col-md-9 col-sm-9col-xs-12 col-md-offset-3">
                     
                    <p align="right">    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?></p>
                   
                </div>
    </div>
</div> </div></div>
      <?php ActiveForm::end(); ?>