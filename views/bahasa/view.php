<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblbahasa */

$this->title = 'Bahasa';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
          <?= Html::a('Kembali', ['biodata/userview'], ['class' => 'btn btn-primary']) ?>
          <?= Html::a('Tambah Bahasa', ['tambahbahasa'], ['class' => 'btn btn-primary']) ?>
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Nama Bahasa</th>
                    <th>Kemahiran Lisan</th>
                    <th>Kemahiran Menulis</th>
                    <th>Sijil Kemahiran</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($bahasa) {
                    
                   foreach ($bahasa as $bahasakakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $bahasakakitangan->bahasa; ?></td>
                    <td><?= $bahasakakitangan->oral; ?></td>
                    <td><?= $bahasakakitangan->written; ?></td>
                    <td><?= $bahasakakitangan->sijil ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatbahasa', 'id' => $bahasakakitangan->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $bahasakakitangan->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $bahasakakitangan->id], [
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
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
            
        </div>
    </div>
</div>


