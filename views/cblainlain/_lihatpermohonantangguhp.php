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
    <u> PERMOHONAN PERTUKARAN TEMPAT PENGAJIAN
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
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Telefon:</th>
                        <td><?= $model->kakitangan->COHPhoneNo; ?></td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Peringkat Pengajian:</th>
                        <td><?= ucwords(strtolower($model->maklumat->HighestEduLevel)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Institusi Pengajian Asal:</th>
                        <td><?= ucwords(strtolower($model->maklumat->InstNm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Institut Pengajian Baharu:</th>
                        <td> <?= $model->renewTempat;?> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Biasiswa:</th>
                        <td><?= ucwords(strtoupper($model->maklumat->tajaan)); ?></td> 
                    </tr>
                <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan (Surat):</th>
                        <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i class="fa fa-file-pdf-o"></i></a><br>
                       <i class="fa fa-download"></i> Klik Sini Untuk Muat Turun
                        </td>                        

                        
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Status Permohonan:</th>
                        <td> <?= $model->status_bsm;?> 
</td> 
                    </tr>
                </table>
            </div>  </div>  </div>
  


     <?php ActiveForm::end(); ?>
   




