<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Lesen';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         
         <?= Html::a('Kembali', ['biodata/adminview', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Lesen', ['admintambahlesen', 'icno' => $ICNO], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>No. Lesen</th>
                    <th>Jenis Lesen</th>
                    <th>Kelas Lesen</th>
                    <th>Tarikh Dikeluarkan</th>
                    <th>Tarikh Luput</th>
                    <th>Yuran Pembaharuan</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($lesen) {
                    
                   foreach ($lesen as $lesenkakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $lesenkakitangan->LicNo ;?></td>
                    <td><?= $lesenkakitangan->jenlesen; ?></td>
                    <td><?= $lesenkakitangan->kellesen; ?></td>
                    <td><?= $lesenkakitangan->firstLicIssuedDt; ?></td>
                    <td><?= $lesenkakitangan->licExpiryDt; ?></td>
                    <td><?='RM '. $lesenkakitangan->LicRnwlFee; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['adminlihatlesen', 'id' => $lesenkakitangan->licId]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['adminupdate', 'id' => $lesenkakitangan->licId]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['admindelete', 'id' => $lesenkakitangan->licId], [
                         'data' => [
                                   'confirm' => 'Anda ingin Membuang Rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  
                </tr>

                   <?php }  
                   
                }else{
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
