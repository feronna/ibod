<?php

use yii\helpers\Html;

$this->title = 'Alamat';

?> 

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['biodata/adminview', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Alamat', ['admintambahalamat', 'icno' => $ICNO], ['class' => 'btn btn-primary']) ?>   
            
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Jenis Alamat</th>
                    <th>Alamat</th>
                    <th>Alamat 2</th>
                    <th>Alamat 3</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($alamat) {
                    
                   foreach ($alamat as $alamatkakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $alamatkakitangan->jenalamat; ?></td>
                    <td><?= $alamatkakitangan->Addr1; ?></td>
                    <td><?= $alamatkakitangan->Addr2; ?></td>
                    <td><?= $alamatkakitangan->Addr3; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['adminlihatalamat', 'id' => $alamatkakitangan->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['adminupdate', 'id' => $alamatkakitangan->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['admindelete', 'id' => $alamatkakitangan->id], [
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
