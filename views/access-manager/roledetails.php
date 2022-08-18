<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Maklumat Role';

?>

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
<div class="tblpraddress-view">


    <p>
        <?= Html::a('Kembali', ['view-role'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Kemaskini', ['update-role', 'id' => $role->role_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $role,
        'attributes' => [
            ['label' => 'ID',
              'value' => $role->role_id,
              'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],  
            ],
              
            ['label' => 'Nama Role',
              'value' => $role->role_name],
            ['label' => 'Nama Controller',
              'value' =>  $role->controller_id],
        ],
    ]) ?>

</div>
        <div class="x_title">
            <h2><?= 'Senarai Permission (action)' ?></h2>
            <div class="clearfix"></div>
        </div>
            <div class="x_content">
         <?= Html::a('Assign Permission', ['assign-perm','role_id'=>$role->role_id], ['class' => 'btn btn-primary']) ?>   
            
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
                    <td class="text-center"><?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['unassign-perm', 'perm_id' => $p->perm_id, 'role_id' => $role->role_id], [
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
            
        <div class="x_title">
            <h2><?= 'Senarai Pengguna (User)' ?></h2>
            <div class="clearfix"></div>
        </div>
            <div class="x_content">
         <?= Html::a('Assign User', ['assign-user','role_id'=>$role->role_id], ['class' => 'btn btn-primary']) ?>   
            
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>ID</th>
                    <th>Nama Pengguna</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($user) {
                    
                   foreach ($user as $u) {
                    
                ?>
                   
                <tr>
                    <td><?= $u->user_id; ?></td>
                    <td><?= $u->userBiodata->CONm; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['unassign-user', 'user_id' => $u->user_id, 'role_id' => $role->role_id], [
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
</div>
