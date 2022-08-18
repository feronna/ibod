<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Roles';

?> 

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Role', ['create-role'], ['class' => 'btn btn-primary']) ?>   
            
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>ID</th>
                    <th>Nama Role</th>
                    <th>Nama Controller</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($role) {
                    
                   foreach ($role as $r) {
                    
                ?>
                   
                <tr>
                    <td><?= $r->role_id; ?></td>
                    <td><?= $r->role_name; ?></td>
                    <td><?= $r->controller_id; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['role-details', 'id' => $r->role_id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update-role', 'id' => $r->role_id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-role', 'id' => $r->role_id], [
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
                        <td colspan="4" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
            
        </div>
    </div>
</div>



