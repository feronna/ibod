<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

?>
<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: center;
}

</style>


<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?> 
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_content"> 

    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->

<?php
  echo Html::a(Yii::t('app','<i class="fa fa-users"></i> <span class="label label-success">MAKLUMAT UMUM</span>'), ['/portfolio/maklumat-bahagian','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-university"></i> <span class="label label-info">MAKLUMAT KHUSUS</span>'), ['/portfolio/carta-organ-staf','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-book"></i> <span class="label label-info">MAKLUMAT JD</span>'), ['/portfolio/deskripsi-tugas','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);


?>
         </div>
    </div>
     <div class="x_panel">
         <div class="x_content"> 
<?php
  echo Html::a(Yii::t('app','MAKLUMAT BAHAGIAN'), ['/portfolio/maklumat-bahagian','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','MAKLUMAT PEGAWAI'), ['/portfolio/maklumat-pegawai','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','MAKLUMAT PENGESAH/PELULUS'), ['/portfolio/maklumat-pelulus','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
  echo Html::a(Yii::t('app','JADUAL PENGEMASKINIAN'), ['/portfolio/jadual','id' => $deskripsi->id], ['class' => 'btn btn-success']);
//  echo Html::a(Yii::t('app','MAKLUMAT JD'), ['/portfolio/deskripsi-tugas','id' => $deskripsi->id], ['class' => 'btn btn-success']);
?>
         </div></div>
        
        <div class="x_panel">
   
        <div class="x_title">
            <strong><h2>MAKLUMAT PENGESAH/PELULUS</h2></strong>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
          
                </div>
        <div class="x_content">
          <div class="table-responsive">
              <p style="color:black">
                    ** Pengemaskinian Data Adalah Di Modul Pentadbir.</p>
           
                <table class="table table-sm table-bordered">
                 
                     <tr>
                     <td><strong>PEGAWAI PENGESAH</strong></td>
                     <td><?= strtoupper($deskripsi->ketuaPerkhidmatan->CONm)?></td>

                     </tr>
                       <tr>
                     <td><strong>PEGAWAI PELULUS</strong></td>
                     <td><?= strtoupper($deskripsi->ketuaJabatan->CONm)?></td>
                     </tr>
                    
                       <tr>
                     <td><strong>TARIKH HANTAR</strong></td>
                     <td><?= strtoupper($deskripsi->tarikh_hantar)?></td>
                     </tr>
                   
                   
                </table>
            
          
        </div>
        
    </div>
            </div>
</div>
</div>

   
   
 

   
