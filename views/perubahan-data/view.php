<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */
$statusLabel = [
        0 => 'Baru',
        1 => 'Kemaskini',
        2 => 'Buang'
];

$this->title = 'Perubahan Data';
error_reporting(0);
?> 

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['perkhidmatan/view', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
     
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Bahagian</th>
                    <th>Aktiviti</th>
                    <th>Tarikh Dikemaskini</th>
                    <th>Pengkemaskini</th>
                   
                </tr>
                </thead>
                <?php 
                   
                
                   foreach ($provider->getModels() as $alamatkakitangan) :?>
                       
                <tr>
                    <td><?= $alamatkakitangan->namaBahagian->nama?></td>
                    <td><?= $statusLabel[$alamatkakitangan->COActivity]?></td>
                    <td><?= $alamatkakitangan->tarikhKemaskini?></td>
                    <td><?= $alamatkakitangan->namaPengemaskini->CONm?></td>
                </tr>

              
                             <?php endforeach;
?>
                  
            </table>
            </div>
            
              
            <?= LinkPager::widget([
                'pagination' => $provider->pagination,
                
            ]) ?>
        </div>
    </div>
</div>



