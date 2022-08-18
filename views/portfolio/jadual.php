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
  echo Html::a(Yii::t('app','MAKLUMAT PENGESAH/PELULUS'), ['/portfolio/maklumat-pelulus','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','JADUAL PENGEMASKINIAN'), ['/portfolio/jadual','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
//  echo Html::a(Yii::t('app','MAKLUMAT JD'), ['/portfolio/deskripsi-tugas','id' => $deskripsi->id], ['class' => 'btn btn-success']);
?>
         </div></div>
        
        <div class="x_panel">
   
        <div class="x_title">
            <strong><h2>JADUAL PENGEMASKINIAN</h2></strong>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
          
                </div>
        <div class="x_content">
          <div class="table-responsive">
              <p style="color:black">
                    ** Jadual Pengemaskinian Menyatakan Maklumat Terkini Perubahan Pada Sebarang TAB MyPortfolio.</p>
           
                <table class="table table-sm table-bordered">
                    
                        <thead>

                        <tr class="headings">
                            <th class="column-title">BIL </th>
                            <th class="column-title">TARIKH TERKINI KEMASKINI</th>
                            <th class="column-title">PERKARA</th>
                            <th class="column-title">STATUS KEMASKINI </th>
                       
                            
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align:center">1.</td>
                                <td style="text-align:center"><?= $carta->created_dt?></td>
                                <td style="text-align:left">Carta Organisasi</td>
                                <td style="text-align:center"><?php if ($carta){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">2.</td>
                                <td style="text-align:center"><?= $carta->created_dt?></td>
                                <td style="text-align:left">Carta Fungsi</td>
                                <td style="text-align:center"><?php if ($fungsi){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">3.</td>
                                <td style="text-align:center"><?= $aktiviti->created_at?></td>
                                <td style="text-align:left">Aktiviti-Aktiviti Bagi Fungsi</td>
                                <td style="text-align:center"><?php if ($aktiviti->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">4.</td>
                                <td style="text-align:center"><?= $deskripsi->created_at?></td>
                                <td style="text-align:left">Deskripsi Tugas</td>
                                <td style="text-align:center"><?php if ($deskripsi->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">5.</td>
                                <td style="text-align:center"><?= $proses->created_at?></td>
                                <td style="text-align:left">Proses Kerja</td>
                                <td style="text-align:center"><?php if ($proses){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             
                          
                             <tr>
                                <td style="text-align:center">6.</td>
                                <td style="text-align:center"><?= $undang->created_at?></td>
                                <td style="text-align:left">Senarai Undang - Undang, Peraturan Dan Punca Kuasa</td>
                                <td style="text-align:center"><?php if ($undang->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">7.</td>
                                <td style="text-align:center"><?= $borang->created_at?></td>
                                <td style="text-align:left">Senarai Borang</td>
                                <td style="text-align:center"><?php if ($borang->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">8.</td>
                                <td style="text-align:center"><?= $jawatanKuasa->created_at?></td>
                                <td style="text-align:left">Senarai Jawatankuasa Yang Dianggotai</td>
                                <td style="text-align:center"><?php if ($jawatanKuasa->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                            
           

                    </table>
            
          
        </div>
        
    </div>
            </div>
</div>
</div>

   


   
