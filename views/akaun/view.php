<?php

use yii\helpers\Html;

$this->title = 'Akaun';

?>

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['biodata/userview'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Akaun', ['tambahakaun'], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>No. Akaun</th>
                    <th>Jenis Akaun</th>
                    <th>Tujuan Akaun</th>
                    <th>Nama Bank/Institusi</th>
                    <th>Cawangan Akaun</th>
                    <th>Status Akaun</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($akaun) {
                    
                   foreach ($akaun as $akaunkakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $akaunkakitangan->AccNo ?></td>
                    <td><?= $akaunkakitangan->jenakaun ?></td>
                    <td><?= $akaunkakitangan->tujakaun ?></td>
                    <td><?= $akaunkakitangan->namakaun ?></td>
                    <td><?= $akaunkakitangan->cawakaun ?></td>
                    <td><?= $akaunkakitangan->staakaun ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatakaun', 'id' => $akaunkakitangan->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $akaunkakitangan->id]) ?></td>  
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="9" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>



