<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

//$this->title = 'Rekod Buku Perkhidmatan';

?> 
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
<!--            <h2><?= Html::encode($this->title) ?></h2>-->
            <ol class="breadcrumb">
                <li><?php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['halaman-utama']) ?></li>
                <li><?php echo Html::a('Rekod Penempatan', ['admin-view', 'id' => $ICNO]) ?></li>
                <li>Kemaskini Sejarah Penempatan</li>
            </ol>
            <h2><strong>Kemaskini Sejarah Penempatan</strong></h2>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
      
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
<!--                    <th class="column-title text-center">ID</th>-->
                    <th class="text-center">Bil. </th>
                    <th class="text-center">Tarikh Mula</th>
                    <th class="text-center">JSPIU</th>
                    <th class="text-center">Kampus</th>
                    <th class="text-center">Sebab Perpindahan</th>
                    <th class="text-center">Catatan</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php 
                
                $bil=1;
                
                if($model) {
                    
                   foreach ($model as $models) {
                    
                ?>
                  
                <tr>
<!--                    <td><?php //echo $models->id; ?></td>-->
                    <td class="text-center" style="width:5%;"><?= $bil++; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->tarikhMula; ?></td>
                    <td class="text-center" style="width:13%;"><?= $models->department->fullname; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->campus->campus_name; ?></td>
                    <td class="text-center" style="width:15%;"><?= $models->reasonPenempatan->name; ?></td>
                    <td class="text-center" style="width:18%;"><?= $models->remark; ?></td>
                   
<!--                    <td class="text-center"><?php //echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihat-rekod-penempatan', 'id' => $models->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-rekod-penempatan', 'id' => $models->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $models->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  -->
                                    <td class="text-center" style="width:10%;"><?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-rekod-penempatan', 'id' => $models->id]) ?>  |  <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $models->id], [
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
                        <td colspan="10" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>
</div>



