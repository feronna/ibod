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
     PERMOHONAN BAHARU PENGAJIAN LANJUTAN SEPENUH MASA
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
</div>
<?php echo $this->render('_menu', ['title' => $title, 'id'=> $iklan->id]) ?>

<!-- Maklumat Keluarga -->


<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
            <div class="x_title">
   <h5 ><strong><i class="fa fa-users"></i> MAKLUMAT KELUARGA</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
            <?php
//                    $keluarga = $biodata->keluarga;
              if($keluarga){ ?>
 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead style="background-color:lightseagreen;color:white">
                    <tr class="headings">
<!--                        <th class="column-title text-center">Bil</th>-->
                        <th class="column-title text-center">NAMA </th>
                        <th class="column-title text-center">HUBUNGAN</th>
                        <th class="column-title text-center">NO. KAD PENGENALAN </th>
                        <th class="column-title text-center">UMUR </th>
                       
                    </tr>
                       </thead>
                <tbody>

                    <?php $bil=1; foreach ($keluarga as $keluarga) { 
                        if( $keluarga->hubunganKeluarga->RelNm == "Suami" || $keluarga->hubunganKeluarga->RelNm == "Isteri" || $keluarga->hubunganKeluarga->RelNm == "Anak Kandung"){?>

                        <tr>

                            <td class="text-center"><?= strtoupper($keluarga->FmyNm); ?></td>
                            <td class="text-center"><?= strtoupper($keluarga->hubunganKeluarga->RelNm);?></td>
                            <td class="text-center"><?= $keluarga->FamilyId; ?></td>
                            <td class="text-center"><?=date("Y") - date("Y", strtotime($keluarga->FmyBirthDt))." " ."TAHUN";?></td>
                            
                        
                        </tr>
                    <?php }} ?>
                </tbody>

                     </table>

                </form>


  <?php }else{?> <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped">
                                    <thead style="background-color:lightseagreen;color:white">
                    <tr class="headings">
<!--                        <th class="column-title text-center">Bil</th>-->
                        <th class="column-title text-center">NAMA </th>
                        <th class="column-title text-center">HUBUNGAN</th>
                        <th class="column-title text-center">NO. KAD PENGENALAN </th>
                        <th class="column-title text-center">UMUR </th>
                       
                    </tr>
                       </thead><tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                                    </tr></table>
                            <?php }?> 
            </div>
        </div>
    </div>
            <br/>
            <p align ="right">

               
                <?= Html::a('Seterusnya', ['cbelajar/senarai-dokumen-dimuatnaik', 'id'=> $iklan->id], ['class' => 'btn btn-info btn-sm']);?>
                <?php echo Html::a('Kembali',['cbelajar/maklumat-biasiswa', 'id'=> $iklan->id], ['class' => 'btn btn-primary btn-sm']); ?>  
    
           
                   <!--  <?php if ($keluarga) {
                    echo Html::a('Borang Permohonan Cuti Belajar', ['borang-pemohon'], ['class' => 'btn btn-primary btn-sm']);
                    } ?> -->
                  
                </p>
        </div>
         
    </div>








