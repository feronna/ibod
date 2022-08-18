<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Selenggara Kod';

?>
<div class="col-md-12">
    <ol class="breadcrumb">
        
        <li><?= Html::encode($this->title) ?></li>
    </ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
           
            <div class="clearfix"></div>
        </div>
         <?= Html::a('Kembali', ['biodata/view'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Kod', ['tambahkod'], ['class' => 'btn btn-primary']) ?> 
        <div class="x_content">  
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th style="width: 10px">No.</th>
                    <th style="width: 800px">Kod</th>
                    <th class="text-center" style="width:auto">Tindakan</th>   
                </tr>
                </thead>   
                <!--A-->
                
                <?php if(!empty($model)){ 
                    $i = 0;
                         foreach ($model as $data){
                             $i++;
                          ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $data->kodname ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['selenggarakod/'.$data->urlsk]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['deletekod', 'id' => $data->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin Membuang Rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  
                </tr>
                <?php
                             
                         }
                }else{
                    ?>
                <tr class="text-center">
                    <td colspan="3">No Data.</td>
                </tr>
                <?php
                }
               ?>
                
                
            </table>
            </div>
        </div>
    </div>
</div>



