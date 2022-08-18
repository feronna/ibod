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
                <li><?php echo Html::a('Rekod Lantikan', ['admin-view', 'id' => $ICNO]) ?></li>
                <li>Senarai Rekod Lantikan</li>
            </ol>
            <h2><strong>Senarai Rekod Lantikan</strong></h2>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
      
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
<!--                    <th>ID</th>-->
                    <th class="text-center">Bil. </th>
                    <th class="text-center">No IC</th>
                    <th class="text-center">Nama Staf</th>
                    <th class="text-center">Jawatan Pentadbiran</th>
                    <th class="text-center">JFPIB</th>
                    <th class="text-center">Kampus</th>
                    <th class="text-center">Tarikh Kuatkuasa</th>
                    <th class="text-center">Tarikh Tamat</th>
                    <th class="text-center">Status</th>
                  
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
                    <td class="text-center" style="width:5%"><?= $bil++; ?></td>
                    <td class="text-center" style="width:5%"><?= $models->ICNO; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->kakitangan->CONm; ?></td>
                    <td class="text-center" style="width:13%;"><?= $models->adminpos->position_name; ?></td>
                    <td class="text-center" style="width:13%;"><?= $models->dept->fullname; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->campus->campus_name; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->tarikhkuatkuasa; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->tarikhtamat; ?></td>
                    <td class="text-center" style="width:8%;"><?= $models->displayflag->flagstatus; ?></td>
                   
               
                    <td class="text-center" style="width:8%;"><?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-rekod-lantikan', 'id' => $models->id]) ?>  |  <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $models->id], [
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



