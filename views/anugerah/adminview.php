<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblanugerah */

$this->title = 'Anugerah';

?>

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['biodata/adminview', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Anugerah', ['admintambahanugerah', 'icno' => $ICNO], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Kategori</th>
                    <th>Nama Anugerah</th>
                    <th>Gelaran</th>
                    <th>Dianugerahkan Oleh</th>
                    <th>Sebab Anugerah</th>
                    <th>Status Anugerah</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($anugerah) {
                    
                   foreach ($anugerah as $anugerahkakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $anugerahkakitangan->katanugerah ?></td>
                    <td><?= $anugerahkakitangan->namanugerah ?></td>
                    <td><?= $anugerahkakitangan->gel ?></td>
                    <td><?= $anugerahkakitangan->diaoleh ?></td>
                    <td><?= $anugerahkakitangan->AwdReason; ?></td>
                    <td><?= $anugerahkakitangan->status ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['adminlihatanugerah', 'id' => $anugerahkakitangan->awdId]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['adminupdate', 'id' => $anugerahkakitangan->awdId]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['admindelete', 'id' => $anugerahkakitangan->awdId], [
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
                        <td colspan="11" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>

