<?php

use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Html;

error_reporting(0);
/* * * for popover PENCERAMAH & INFO **** */
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});
/* To initialize BS3 popovers set this below */
$(function () { 
   $("[data-toggle='popover']").popover();
//    $("[data-trigger='focus']").popover();
//    $('.popover-dismiss').popover({
//        trigger: 'focus'
//        })
});
//$(function() {
//    // use the popoverButton plugin
//    $('#kv-btn-1').popoverButton({
//        placement: 'left', 
//        target: '#myPopover5'
//    });
//});
$(function() {
    $('#testHover').popoverButton({
        trigger: 'hover focus',
        target: '#myPopover6'
    });
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
?>

 

<div class="row">
<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Senarai Mesyuarat Prima Facie</h2>
        
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            
    
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                  'filterModel' => $searchModel,

                        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        // Simple columns defined by the data contained in $dataProvider.
        // Data from the model's column will be used.
        
        'nama_mesyuarat',
        'tarikh_mesyuarat',
        'masa_mesyuarat',
        'tempat_mesyuarat' ,
        'bidang',
        'info',
        'status',
          [
                            'label'=>'Ahli',
                          // 'format' => 'raw',
                            'value'=>  function ($data){
                           //   return  $data->AhliMeeting($data->id);
                 //   return $data->tempat_mesyuarat;
                           //    'value' => function ($data) {
      //   $img ='';
            foreach ($data->AhliMeeting()as $key){
                 $img = '</br>'.$key->icno;
                 //    echo'<li>' .$models->icno; 
            //  $data->AhliMeeting($data->id);
                   //$models->icno; 
            }
            return $img;
        
        } 
                                   
                              
                                 //   return Html::a('<span class="fa fa-info-circle" aria-hidden="true">  Info</span>', ['tatatertib-staf/detail-mesyuarat', 'id' => $data->id ], ['class' => 'btn btn-info btn-block']) ;
                                  
//                                    return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tindakans', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn btn btn-info']);

                            
                            
                        ],
        // More complex one.
            [
                            'label'=>'Status',
                            'format' => 'raw',
                            'value'=>function ($data){
                              
                                    return Html::a('<span class="fa fa-info-circle" aria-hidden="true">  Info</span>', ['tatatertib-staf/detail-mesyuarat', 'id' => $data->id ], ['class' => 'btn btn-info btn-block']) ;
                                  
//                                    return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tindakans', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn btn btn-info']);

                                }
                        ],
                      [
                            'label'=>'Tindakan',
                            'format' => 'raw',
                            'value'=>function ($data){
                              
                                     return Html::a('<span class="fa fa-info-circle" aria-hidden="true">  Tambah</span>', ['tatatertib-staf/tambah-ahli-mesyuarat', 'id' => $data->id ], ['class' => 'btn btn-success btn-block']) 
                                  
                                    . Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tatatertib-staf/detail-ahli', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn btn btn-info']);

                                }
                        ],
                ],   
           // 
                    'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                 
                  //  'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => ' background-color: rgb(0, 191, 255)'],
                 // 'columns' => $gridColumns,
                ]);
            ?>


        </div>
    </div>
</div>
</div>
