<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ptb\TblTugasBelumSelesaiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ISYTIHAR HARTA';
$this->params['breadcrumbs'][] = $this->title;
$statusLabel = [
        1 => '<span class="label label-success">Borang Selesai Dihantar</span>',
        4 => '<span class="label label-success">Berjaya</span>',
        0 => '<span class="label label-danger">Ditolak</span>',
        5 => '<span class="label label-danger">Ditolak</span>',
        null => '<span class="label label-danger">Borang Belum Dihantar</span>',
    
];


$options = [
        1=> 'Permohonan Baharu',
        2=> 'Pertambahan Harta',
       4 => 'Tiada Perubahan',
        3=> 'Pelupusan Harta'
    
];


?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Borang Isytihar</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="respon"
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama Pemohon</th>
                    <th class="text-center">No.Kad Pengenalan</th>
                    <th class="text-center">Jawatan dan Gred</th>
                    <th class="text-center">JFPIU Semasa</th>
         

                    <th class="text-center">Tarikh Isytihar</th>
                    <th class="text-center">Lihat</th>
                    <th class="text-center">Tindakan</th>
                  
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
        
                      
                            <td align= 'center'>
                        <?php  if ($maklumats->ADDeclDt != null){
                   echo  $maklumats->ADDeclDt;
                  }else{
                    echo 'Borang Belum Dihantar';
                 }
                 ?></td>
                   
                             <td align= 'center' ><?=Html::a('<i class="fa fa-eye">', ["harta/borang", 'id' => $maklumats->id]);
                     ?></td>
                                <td align= 'center' ><?=Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['mohon3', 'id' => $maklumats->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-send mapBtn']);
                        
                     ?></td>
                             

                       
                    
                    <?php 
                    
                    
                    
                        }} ?>
                            
                            
                         
                </tbody>
            </table>
            </div>
        </div>
    </div>
    </div>
</div>
