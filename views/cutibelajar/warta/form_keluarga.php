<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */
$title = $this->title = 'Maklumat Keluarga';
?> 
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN PENGAJIAN LANJUTAN LATIHAN INDUSTRI
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
</div>
<?php echo $this->render('_menusm', ['title' => $title, 'id'=> $iklan->id]) ?>

<!-- Maklumat Keluarga -->


<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
            
            <div class="x_title">
                <h2><strong><i class="fa fa-users"></i> Maklumat Keluarga</strong></h2>
                <p align ="right">
                    <?php echo Html::a('<i class="fa fa-edit"></i>', ['keluarga/view'], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']); ?>
                  
                </p>
                <div class="clearfix"></div>
            </div>
<p style="color:red"> *Sila pastikan maklumat keluarga diisi dengan tepat dan benar. 
Hanya maklumat pasangan dan anak-anak sahaja yang akan tertera:</p>
            <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center" style="width:5%;">BIL</th>
                        <th class="column-title text-center" style="width:25%;">NAMA </th>
                        <th class="column-title text-center" style="width:10%;">HUBUNGAN</th>
                        <th class="column-title text-center" style="width:10%;">NO. KAD PENGENALAN </th>
                        <th class="column-title text-center" style="width:5%;">UMUR </th>
                       
                    </tr>

                </thead>
                <tbody>
                    
                    <?php 
                    
                    if($keluarga)
                    {$bil=1; foreach ($keluarga as $keluarga) {
                    if($keluarga->hubunganKeluarga->RelNm == "Isteri" 
                   || $keluarga->hubunganKeluarga->RelNm == "Anak Kandung" || $keluarga->hubunganKeluarga->RelNm == "Suami"){?>


                        <tr>

                            <td class="text-center" style="width:5%;"><?= $bil++ ?></td>
                            <td><?= strtoupper($keluarga->FmyNm); ?></td>
                            <td><?= strtoupper($keluarga->hubunganKeluarga->RelNm);?></td>
                            <td><?= strtoupper($keluarga->FamilyId); ?></td>
                            <td><?=date("Y") - date("Y", strtotime($keluarga->FmyBirthDt))." " ."TAHUN";?></td>
                            
                        
                        </tr>
                       <?php
              } }} else{?>
                  
                   
    
         
                       
                        <tr>
                            <td colspan="11" class="text-center"><strong><i>Tiada Maklumat</i></strong></td>                     
                        </tr>
<?php }
?>
             
    
           </tbody>
                </table> 

                    
                       
                      


                </form>


            </div>
            <br/>
            <p align ="right">

               
                <?= Html::a('Seterusnya', ['senarai-dokumen', 'id'=> $iklan->id], ['class' => 'btn btn-info btn-sm']);?>
                <?php echo Html::a('Kembali',['maklumat-biasiswa', 'id'=> $iklan->id], ['class' => 'btn btn-primary btn-sm']); ?>  
    
           
                   <!--  <?php if ($keluarga) {
                    echo Html::a('Borang Permohonan Cuti Belajar', ['borang-pemohon'], ['class' => 'btn btn-primary btn-sm']);
                    } ?> -->
                  
                </p>
        </div>
         
    </div>
</div>







