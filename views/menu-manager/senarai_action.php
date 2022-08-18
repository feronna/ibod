<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\system_core\TblMenuTopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Senarai Action';
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tbl-menu-top-index">
    <div class="row"> 
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_content">
                    
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                    
                    <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => '',
                        //'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                            ],

                            [
                                'label' => 'ORDER',
                                'attribute' => 'order',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                            ],
                            [
                                'label' => 'LABEL',
                                'attribute' => 'label',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                            ],
                            [
                                'label' => 'URL',
                                'attribute' => 'url',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                            ],
//                            [
//                                'label' => 'ICON',
//                                //'attribute' => 'icon_id',
//                                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//                                'value' => function($model) {
//                                    return '<i class="fa fa-'.$model->icon->icon_label.'"></i> '.$model->icon->icon_label.'';
//                                },
//                                'format' => 'raw'
//                            ],
                            [
                                'label' => 'VISIBLE',
                                //'attribute' => 'visible'
                                'value' => function($model) {
                                    return (is_null($model->visible)) ? null : $model->visible;
                                },
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                            ],
                            [
                                'label' => 'STATUS',
                                //'attribute' => 'status'
                                'value' => function($model) {
                                    return ($model->status == 1) ? '<span class="label label-success">Enabled</span>' : 
                                            '<span class="label label-danger">Disabled</span>';
                                },
                                'format' => 'raw',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                            ],
                        ],
                    ]); ?>
                    </div>
                </div> 
            </div>                
        </div>
    </div>
</div>
