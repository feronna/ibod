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
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
               <h2><strong>ARAHAN BAYARAN</strong></h2>
                <div class="form-group text-right">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
                </div>
                <div class="clearfix"></div>
            </div>
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
                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center', 'style' => 'width: 15%;'],
                    'value' => function ($model) { 
                    return $model-> payDetails->kakitangan->CONm;

                        }, 
                    ], 
//                    [
//                        //                                        'class' => 'yii\grid\SerialColumn',
//                        'header' => 'BATCH CODE',
//                        'headerOptions' => ['class' => 'text-center'],
//                        'contentOptions' => ['class' => 'text-center'],
//                        'value' => '',
//                       
//                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'value' => function($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                       
                        'detailUrl' => 'elaun-details',
                        'headerOptions' => ['class' => 'text-center'], 
                        'contentOptions' => ['class' => 'text-center'],         
                        'expandOneOnly' => true
                    ],
                    [
                        //                                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'SEBAB PERUBAHAN /PERGERAKAN',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
//                            return $model-> elaun_kemudahan;
                            return $model-> payDetails->elaunPakaian->kemudahan;

                        }, 
                       
                    ],
                    [
                        //                                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'CATATAN',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
//                            return $model-> elaun_kemudahan;
                            return $model->payDetails->approver_remark;

                        }, 
                    ],
                    
                   
                    [
                        //                                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'JFPIU',
                        'headerOptions' => ['class' => 'text-center col-md-2'],
                        'contentOptions' => ['class' => 'text-center'],
                         'value' => function ($model) {
//                            return $model-> elaun_kemudahan;
                            return $model->payDetails->kakitangan->department->fullname;

                        }, 
                    ],
                    [
                        'header' => 'TARIKH KUATKUASA',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
//                            return $model-> elaun_kemudahan;
                            return $model->payDetails->datefrom;

                        }, 
                    ],
                    [
                        'header' => 'TARIKH',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                       'value' => function ($model) { 
                            return $model->payDetails->appDt;

                        }, 
                    ],
                    [
                        'header' => 'STATUS',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) { 
                            return $model->payDetails->statuskj;

                        }, 
                    ],
                   [
                        'header' => 'TINDAKAN',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {  
                            return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['new-elaun', 'id' => $model->PAY_PARENT_ID]),'style'=>'background-color: transparent; 
                            border: none;', 'class' => 'fa fa-edit mapBtn']);
                        }


                      
                    ], 
                ],
            ]);
        ?>
              
</div>
</div>
</div>
                  
                    
                
             
     
         
 

