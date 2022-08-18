<?php

use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Html;


?>

<div class="x_panel">
         <p align="right"> 
         <?= Html::a('Kembali', ['tatatertib-staf/index'], ['class' => 'btn btn-primary btn-sm']) ?>
        </p>
    <div class="x_title">
        <h5><strong><i class="fa fa-book"></i> SENARAI REKOD KES TATATERTIB SEDIA ADA</strong>  
         <?php echo // Html::a('<span class="fa fa-info-circle" aria-hidden="true">  Tambah</span>', ['tatatertib-staf/tambah-ahli-meeting', 'id' => $model->id ], ['class' => 'btn btn-success btn-block']); 
        Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tatatertib-staf/tambah-rekod-lama']), 'class' => 'fa fa-plus mapBtn btn btn-info']);?> </h5>
      
        <div class="clearfix"></div>
    </div>   
      
                <div class="x_content">          
                <table class="table table-bordered jambo_table" style="font-size: 12px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">NAMA</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JAWATAN</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TINDAKAN</th>
            
                </tr> 
                </thead>
                <tbody>
                      <?php
 
                if($rekod){ ?>
                <?php $bil=1; foreach ($rekod as $rekod) { ?>
                    <tr>
                        <td class="text-center"><?= $bil++ ?></td>
                        <td class="text-center"><?= strtoupper($rekod->kakitangan->CONm); ?></td>
                        <td class="text-center"><?= strtoupper($rekod->kakitangan->jawatan->nama . " (" . $rekod->kakitangan->jawatan->gred . ")"); ?></td>
                        
                         <td class="text-center"> <?php echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['detail-rekod-lama', 'id' => $rekod->id]), 'class' => 'fa fa-info mapBtn btn btn-info']); 
                                    ?>| <?php echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kemaskini-rekod-lama', 'id' => $rekod->id]), 'class' => 'fa fa-pencil mapBtn btn btn-info']); 
                                    ?>| <?php echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['padam-rekod-lama', 'id' => $rekod->id]), 'class' => 'fa fa-trash mapBtn btn btn-info', 
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ], ]) ?>
                        </td> 
                       
                    </tr>
                <?php } }
                        else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                </tbody>
        </table>              
    </div>
    
     
             
</div>