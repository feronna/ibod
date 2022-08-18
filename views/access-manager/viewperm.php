<?php

use yii\helpers\Html;

$this->title = 'Permissions';

?> 

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Permission', ['create-perm'], ['class' => 'btn btn-primary']) ?>   
            
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>ID</th>
                    <th>Nama Permission</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($perm) {
                    
                   foreach ($perm as $p) {
                    
                ?>
                   
                <tr>
                    <td><?= $p->perm_id; ?></td>
                    <td><?= $p->perm_desc; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-perm', 'id' => $p->perm_id], [
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
                        <td colspan="3" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
            
        </div>
    </div>
</div>



