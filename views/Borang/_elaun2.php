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
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
                            'summary' => '',
                            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                            'columns' => [
                                [
                                    // 'attribute' => 'SR_ROC_TYPE',
                                    'value' => function ($model) {
                                    return $model-> payDetails->elaunPakaian->kemudahan;
                                    },
                                    'label' => 'ELAUN/POTONGAN',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'html',
//                                    'value' => '',
                                ],
                               
                                 [
                                'header' => 'JUMLAH SEBELUM',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => '',
                            ],
                                [
                                     
                                    'label' => 'JUMLAH',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'html',
                                     'value' => function ($model) { 
                                    return $model->PAY_NEW_VALUE;

                                }, 
                                ],
                                [
                                    
                                    'label' => 'JENIS KIRAAN',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'html',
//                                     'value' => function ($model) { 
//                                    return $model->payDetails->jenis_kiraan;
//
//                                }, 
                                    'value' => '',
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'KOD PROJEK',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => '',
                                    'format' => 'html'
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'PUSAT KOS',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => '',
                                    'format' => 'html'
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'DARI',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'], 
                                    'format' => 'html', 
                                    'value' => function ($model) {
                                     return \Yii::$app->formatter->asDate($model->PAY_DATE_FROM, 'yyyy-MM-dd');
                                },

                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'SEHINGGA',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'], 
                                    'format' => 'html',
                                    'value' => function ($model) {
                                     return \Yii::$app->formatter->asDate($model->PAY_DATE_TO, 'yyyy-MM-dd');
                                },
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'JENIS',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => '',
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'JENIS PERUBAHAN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => '',
                                ],
                            ],
                        ]);
                    ?>



                  
                    
                
             
     
         
 

