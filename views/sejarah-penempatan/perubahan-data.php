<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

//$this->title = 'Rekod Buku Perkhidmatan';
$this->title = 'Rekod Penempatan';
$statusLabel = [
        0 => 'Baru',
        1 => 'Kemaskini',
        2 => 'Buang',
];
?> 
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <ol class="breadcrumb">
                <li><?php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['halaman-utama']) ?></li>
                <li><?php echo Html::a('Rekod Penempatan', ['admin-view', 'id' => $ICNO]) ?></li>
                <li>Perubahan Data</li>
            </ol>
            <h2><strong>Perubahan Data</strong></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
        
     
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bahagian</th>
                    <th class="text-center">Aktiviti</th>
                    <th class="text-center">Tarikh Dikemaskini</th>
                    <th class="text-center">Pengkemaskini</th>
                   
                </tr>
                </thead>
                <?php 
                   
                
                   foreach ($provider->getModels() as $alamatkakitangan) :?>
                       
                <tr>
                    <td class="text-center"><?= $alamatkakitangan->namaBahagian->nama?></td>
                    <td class="text-center"><?= $statusLabel[$alamatkakitangan->COActivity]?></td>
                    <td class="text-center"><?= $alamatkakitangan->tarikhKemaskini?></td>
                    <td class="text-center"><?= $alamatkakitangan->namaPengemaskini->CONm?></td>
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
</div>






























