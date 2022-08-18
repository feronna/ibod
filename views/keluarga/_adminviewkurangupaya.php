<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\alert\Alert;

$this->title = 'Lihat Kurang Upaya';

?>
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Tambah Kurang Upaya', ['admintambahkurangupaya','id'=>$id], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>No. Kad OKU </th>
                    <th>No. Laporan Doktor</th>
                    <th>Jenis Kurang Upaya</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($fmydis) {   

                   foreach ($fmydis as $okus) {
                    
                ?>
                   
                <tr>
                    <td><?= $okus->socialwelfareno; ?></td>
                    <td><?= $okus->drrptno; ?></td>
                    <td><?= $okus->jenkecacatan; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['adminlihat-k-u', 'id' => $okus->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['adminupdate-k-u', 'id' => $okus->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['adminpadam-k-u', 'id' => $okus->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  
                </tr>

                <?php }
                 }
                   
                else{
                    ?>
                    <tr>
                        <td colspan="4" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                   } 
                ?>
            </table>
            </div>
        </div>
    </div>




