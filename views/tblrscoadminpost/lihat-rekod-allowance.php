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
<!--            <ol class="breadcrumb">
                <li><php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['halaman-utama']) ?></li>
                <li><php echo Html::a('Rekod Lantikan', ['admin-view', 'id' => $ICNO]) ?></li>
                <li>Senarai Rekod Allowance</li>
            </ol>-->
            <h2><strong>Senarai Rekod Allowance</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['admin-view', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?></p>   
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
      
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
<!--                    <th>ID</th>-->
<!--                    <th class="text-center">Bil. </th>-->
                    <th class="text-center">No IC</th>
                    <th class="text-center">Kod</th>
                    <th class="text-center">Allowance</th>
                    <th class="text-center">Tindakan</th>

                    
                </tr>
                </thead>
                <?php 
                
                 $bil=1;
                
                if($provider) {
                    
                   foreach ($provider->getModels() as $models) {
                    
                ?>
                  
                <tr>
<!--                    <td><?php //echo $models->id; ?></td>-->
<!--                    <td class="text-center" style="width:5%;"><?= $bil++; ?></td>-->
                    <td class="text-center" style="width:5%;"><?= $models->ICNO; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->it_income_code; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->allowance->it_account_name; ?></td>
  
                    <td class="text-center" style="width:10%;"><?php echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihat-allowance', 'id' => $models->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-rekod-allowance', 'id' => $models->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete2', 'id' => $models->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  
<!--                    <td class="text-center" style="width:8%;"><= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihat-rekod-lantikan', 'id' => $models->id]) ?></td>  -->
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



