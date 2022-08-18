<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */
//$this->title = 'Sejarah Penempatan';
?> 
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <ol class="breadcrumb">
                <li><?php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['halaman-utama']) ?></li>
                <li><?php echo Html::a('Rekod Penempatan', ['admin-view', 'id' => $model->ICNO]) ?></li>
                <li><?= Html::a('Senarai Rekod Penempatan', Yii::$app->request->referrer) ?></li>
                <li>Lihat Rekod Penempatan</li>
            </ol>
            <h2><strong>Lihat Rekod Penempatan</strong></h2>
        <div class="clearfix"></div>
        </div>
        
        <div class="x_content">        
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Tarikh Mula</th>
                    <th>Tarikh Kemaskini</th>
                    <th>JFPIB</th>
                    <th>Kampus</th>
                    <th>Catatan</th>
                
                </tr>
                </thead>
                <?php if($alamat) {
                    
                   foreach ($alamat as $alamatkakitangan) {
                    
                ?>
                  
                <tr>
                    <td><?= $alamatkakitangan->tarikhMula?></td>
                    <td><?= $alamatkakitangan->tarikhKemaskini?></td>
                    <td><?= $alamatkakitangan->department->fullname?></td>
                    <td><?= $alamatkakitangan->kampus->campus_name?></td>
                    <td><?= $alamatkakitangan->remark?></td>
              
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
</div>



