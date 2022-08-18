<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */
error_reporting(0);
$this->title = 'Status Perkhidmatan';

?> 
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['data/admin-status-perkhidmatan'], ['class' => 'btn btn-primary']) ?>
         <?= Html::button('Tambah', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tambah-perkhidmatan?icno='.$model->ICNO]),'class' => 'btn btn-primary mapBtn']) ?>

            <div class="table-responsive">
         
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Status Pekerja</th>
                    <th>Status Terperinci</th>
                    <th>Tarikh Mula</th>
                  
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($perkhidmatan) {
                   foreach ($perkhidmatan as $perkhidmatan) {
                ?>
                <tr>
                    <td><?= $perkhidmatan->statusPerkhidmatan->ServStatusNm?></td>
                    <td><?= $perkhidmatan->statusTerperinci->name?></td>
                    <td><?= $perkhidmatan->tarikhMula ?></td>
                    
                    <td class="text-center"><?= Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kemaskini-perkhidmatan', 'id' => $perkhidmatan->id]),'style'=>'background-color: transparent; 
                          border: none;', 'class' => 'fa fa-edit mapBtn'])?>| <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-perkhidmatan', 'id' => $perkhidmatan->id], [
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



