<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Kecacatan';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['biodata/userview'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Kecacatan', ['tambahkecacatan'], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>No. Fail Kebajikan</th>
                    <th>No. Laporan Doktor</th>
                    <th>Jenis Kecacatan</th>
                    <th>Punca Kecacatan</th>
                    <th>Tarikh Kecacatan</th>
                    <th>Tarikh Sembuh</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($kecacatan) {
                    
                   foreach ($kecacatan as $kecacatankakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $kecacatankakitangan->SocialWelfareNo; ?></td>
                    <td><?= $kecacatankakitangan->DrRptNo; ?></td>
                    <td><?= $kecacatankakitangan->jenkecacatan; ?></td>
                    <td><?= $kecacatankakitangan->punkecacatan; ?></td>
                    <td><?= $kecacatankakitangan->disabilityDt; ?></td>
                    <td><?= $kecacatankakitangan->tarikhsembuh ;?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatkecacatan', 'id' => $kecacatankakitangan->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $kecacatankakitangan->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $kecacatankakitangan->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="7" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>



