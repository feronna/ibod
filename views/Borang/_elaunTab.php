<?php

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modall').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal; 
use app\models\Kemudahan\BorangSearch;

?>

<?php
Modal::begin([
    'header' => 'Kemasukan',
    'id' => 'modall',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

       <?=
           
            GridView::widget([
                //'tableOptions' => [
                //  'class' => 'table table-striped jambo_table',
                //],
                'emptyText' => 'Tiada Rekod',
                    'summary' => '',
                'dataProvider' => $dataProvider,
                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'BIL',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                    'label' => 'NAMA',
                    'value' => 'kakitangan.CONm',
                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center', 'style' => 'width: 15%;'],
                    ], 
                     
                    [ 
                        'header' => 'ELAUN / TUNTUTAN',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) { 
                            return $model-> elaunPakaian->kemudahan;

                        }, 
                    ],
                    
                    [
                        'header' => 'TARIKH MOHON',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                       'value' => function ($model) { 
                            return $model->appDt;

                        }, 
                    ],
//                     
//                     [
//                        'header' => 'SALINAN SURAT',
//                        'headerOptions' => ['class' => 'text-center col-md-1'],
//                        'contentOptions' => ['class' => 'text-left'],
//                        'format' => 'raw',
//                       'value' => function ($model) { 
//                            return Html::a(' SURAT KELULUSAN ', ['borang/sk_lulus', 'id' => $model->parent_id], ['class'=>'fa fa-download', 'target' => '_blank']).'<br>'
//                                  .Html::a(' MEMO ', ['borang/memo', 'id' => $model->parent_id], ['class'=>'fa fa-download', 'target' => '_blank']).'<br>'
//                                  .Html::a(' KELULUSAN KETUA BSM ', ['borang/surat_kj', 'id' => $model->parent_id], ['class'=>'fa fa-download', 'target' => '_blank']);
//
//                        }, 
//                    ],
                    [
                        'header' => 'STATUS KETUA BSM',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) { 
                            return $model->statuskj;

                        }, 
                    ],
                   [
                        'header' => 'TINDAKAN',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) { 
                            return Html::a('<i class="fa fa-edit">', ["borang/pay", 'id' => $model->parent_id]); 

                        }, 
                    ],

                              
                ],
            ]);
        ?>
              

                  
                    
                
             
     
         
 

