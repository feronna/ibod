<?php
/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;

?>

<?= $this->render('_carian', [
    'model' => $searchModel,
]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Hasil Carian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <?=
                            GridView::widget([
                                //'tableOptions' => [
                                  //  'class' => 'table table-striped jambo_table',
                                //],
                                'emptyText' => 'Tiada Rekod',
                                'summary' => '',
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'header' => 'Bil',
                                        'headerOptions' => ['class'=>'text-center col-md-1'],
                                        'contentOptions' => ['class'=>'text-center'],
                                    ],
                                    [
                                        'attribute' => 'COOldID',
                                        'label' => 'UMSPER',
                                        'headerOptions' => ['class'=>'text-center col-md-1'],
                                        'contentOptions' => ['class'=>'text-center'],
                                    ],
                                    [
                                       'attribute' => 'CONm',
                                        'label' => 'Nama',
                                        'headerOptions' => ['class'=>'text-center col-md-3'],
                                        //'contentOptions' => ['class'=>'text-center'],
                                    ],
                                    [
                                       'attribute' => 'ICNO',
                                        'label' => 'No KP',
                                        'headerOptions' => ['class'=>'text-center col-md-'],
                                        'contentOptions' => ['class'=>'text-center'],
                                    ],
                                    [
                                       'label' => 'Jawatan',
                                        'value' => function ($model){
                                            return $model->jawatan->fname;
                                        },
                                       'headerOptions' => ['class'=>'text-center col-md-3'],
                                        'contentOptions' => ['class'=>'text-center'],         
                                    ],
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'JFPIU',
                                        'value' => function($model) {
                                            return $model->department->fullname;
                                        },
                                        'headerOptions' => ['class'=>'text-center col-md-2'],
                                        'contentOptions' => ['class'=>'text-center'],        
                                    ],
                                    [
                                       'label' => 'Lokasi',
                                        'value' => function ($model){
                                            return ucwords(strtolower($model->kampus->campus_name));
                                        },
                                       'headerOptions' => ['class'=>'text-center col-md-2'],
                                        'contentOptions' => ['class'=>'text-center'],           
                                    ],
                                    [
                                       'label' => 'Status Staf',
                                        'value' => function ($model){
                                            return $model->serviceStatus->ServStatusNm;
                                        },
                                       'headerOptions' => ['class'=>'text-center col-md-1'],
                                        'contentOptions' => ['class'=>'text-center'],           
                                    ],            
//                                    [
//                                       //'attribute' => 'CONm',
//                                        'label' => 'AKSES',
//                                        'headerOptions' => ['class'=>'text-center'],
//                                        'contentOptions' => ['class'=>'text-center'],
//                                        'value' => function($model) {
//                                            return is_null($model->dassAkses) ? '-' : 'ADA';
//                                        },
//                                        //'attribute' => 'test'
//                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                       //'attribute' => 'CONm',
                                        'header' => 'Tindakan',
                                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'template' => '{view}',
                                        //'header' => 'TINDAKAN',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['saraan/kemasukan', 'icno' => $model->ICNO], ['class' => 'btn btn-default btn-sm']);
                                            },
                                        ],
                                    ],
                                ],
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
