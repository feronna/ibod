<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ptb\TblTugasBelumSelesaiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ISYTIHAR HARTA';
$this->params['breadcrumbs'][] = $this->title;
$options = [
        1=> 'Permohonan Baharu',
        2=> 'Pertambahan Harta',
        4=> 'Tiada Perubahan',
        3=> 'Pelupusan Harta'
    
];

$title = $this->title = 'PengakuanPegawai';

?>
<div class="col-md-12 col-xs-12"> 
<div class="x_panel">
<?php if ($models == false){
   echo $this->render('_menu1', ['title' => $title]) ;      
}else{
     echo $this->render('_menu2', ['title' => $title]) ;     
}
?>
</div>
</div>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Pengakuan Pegawai</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="respon"
        <div class="x_content">
            <div class="table-responsive">
           <p style="color: green">
               * Dikehendaki untuk mengisi dan melengkapkan harta/aset terlebih dahulu sebelum membuat pengakuan.
            </p>
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama Pemohon</th>
                    <th class="text-center">No.Kad Pengenalan</th>
                    <th class="text-center">Jawatan dan Gred</th>
                    <th class="text-center">JFPIU Semasa</th>
                    <th class="text-center">Jenis Permohonan</th>
                    <th class="text-center">Status Borang</th>
                    <th class="text-center">Tarikh Isytihar</th>
                   
                    <th class="text-center">Hantar</th>
                  
         </tr>
                </thead>
                <tbody>
                    <?php 
                    if($maklumat){
                    foreach ($maklumat as $key => $maklumats) { 
                        ?>
                        <tr>
                            <td><?= $key+1?></td>
                            <td align='center'><?= $maklumats->AssetOwnerNm?></td>
                            <td align='center'><?= $maklumats->icno?></td>
                            <td align='center'><?= $maklumats->jawatan?> (<?=$maklumats->gred?>)</td>
                            <td align='center'><?= $maklumats->jfpiu?></td>
                            <td align='center'><?= $options[$maklumats->jenis_permohonan]?></td>
                     
                                <td align= 'center'>
                        <?php  if ($maklumats->status != null){
                   echo  'Borang Telah Dihantar';
                  }else{
                     echo '<p style="color:red">Borang Belum Dihantar</p>';
                 }
                 ?></td>
                  
                <td align= 'center'>
                        <?php  if ($maklumats->ADDeclDt != null){
                   echo  $maklumats->ADDeclDt;
                  }else{
                  echo '<p style="color:red">Borang Belum Dihantar</p>';
                 }
                 ?>
                </td>
                  <th><?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i> HANTAR BORANG', ['value' => \yii\helpers\Url::to(['mohon4', 'id' => $maklumats->id]), 'class' => 'mapBtn btn-sm btn-danger btn-block'])?></th>

                  <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="9" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                            
                            
                         
                </tbody>
            </table>
            </div>
        </div>
    </div>
  
</div>

 