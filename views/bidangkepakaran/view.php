<?php

use yii\helpers\Html;

$this->title = 'Bidang Kepakaran';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['biodata/userview'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Kepakaran', ['tambahbidangkepakaran'], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Kluster Kepakaran</th>
                    <th>Bidang Kepakaran</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($bidangkepakaran) {
                    
                   foreach ($bidangkepakaran as $bidangkepakarankakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $bidangkepakarankakitangan->klusterid ? $bidangkepakarankakitangan->bidangKepakaran->kluster : 'Tidak Berkaitan'; ?></td>
                    <td><?= $bidangkepakarankakitangan->bidang; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatbidangkepakaran', 'id' => $bidangkepakarankakitangan->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $bidangkepakarankakitangan->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $bidangkepakarankakitangan->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin Membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="3" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>



