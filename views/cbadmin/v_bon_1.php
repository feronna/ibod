<?php
$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;

$this->registerJs($js);
$this->registerJsFile('@web/js/circleprogress.js');

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
error_reporting(0);
$this->title = 'Bon Perkhidmatan';

?> 

<div class="row">    
<div class="col-md-12 col-sm-12 col-xs-12 "> 
 <p align="left"> 
<!--            <= Html::a('Kembali', ['index', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>-->
<!--            <= Html::a('Kemaskini', ['update2', 'id' => $model->ICNO], ['class' => 'btn btn-primary mapBtn ', 'id' => 'modalButton']) ?>-->
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-bon?id='.$lapor->laporID]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
<!--            <= Html::a('Padam', ['delete', 'id' => $model->ICNO], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
-->            </p>

<div class="x_panel">

<div class="x_title">
   <h5><strong><i class="fa fa-book"></i> PENGIRAAN TEMPOH BERKHIDMAT (TIDAK TERMASUK TEMPOH PENGAJIAN LANJUTAN KAKITANGAN)</strong></h5>
   <div class="clearfix"></div>
</div>

 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead>
       
        <tr class="headings">
            <th class="column-title text-center">BIL</th>
            <th class="column-title text-center">TARIKH MULA BON </th>
            <th class="column-title text-center">CATATAN</th>
            <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>
    <tbody>
         <?php if($bon){ ?>
        <?php $bil=1; foreach ($bon as $bon) { ?>
        <tr>
<td class="text-center"><?= $bil++ ?></td>
<td class="text-center"><?= strtoupper($bon->dtm); ?> <b> HINGGA </b><?= strtoupper($bon->dtt); ?></td>
            <td class="text-center"><?= $bon->catatan; ?></td>
<!--<td class="text-center"><?php //$bon->j_bon; ?></td>-->
            <td class="text-center">

                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-bon', 'id' => $bon->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> |

                
                    
                 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete?id='.$bon->id.'&page=rekod-bon'], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?>
            </td>

        </tr>
        <?php }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
         
        <tr class="headings" >
            
            <th class="column-title text-center" colspan="2">JUMLAH TEMPOH PERKHIDMATAN </th>
            <td class="text-center"><?= $bon->j_bon; ?></td>
          
            
        </tr>
        



 </table>
</form>           </div> <!-- div for row-->
          <!-- div for well-->
</div>
    </div></div>

                




 


   

