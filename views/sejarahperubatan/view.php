<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Sejarah Perubatan';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['biodata/userview'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Sejarah Perubatan', ['tambahsejarahperubatan'], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Nama Penyakit</th>
                    <th>Tahun</th>
                    <th>Tarikh Mula Rawatan</th>
                    <th>Tarikh Akhir Rawatan</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($sejarahperubatan) {
                    
                   foreach ($sejarahperubatan as $sejarahperubatankakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $sejarahperubatankakitangan->jenpenyakit ?></td>
                    <td><?= $sejarahperubatankakitangan->Year; ?></td>                    
                    <td><?= $sejarahperubatankakitangan->treatmentStartDt; ?></td>
                    <td><?= $sejarahperubatankakitangan->treatmentEndDt; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatsejarahperubatan', 'id' => $sejarahperubatankakitangan->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $sejarahperubatankakitangan->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $sejarahperubatankakitangan->id], [
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
                        <td colspan="6" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>



