<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$kategori = [
    '1'=>'Akademik',
    '2'=>'Pentadbiran',
];

$this->title = 'Status Lantikan';
$this->params['breadcrumbs'][] = ['label' => 'Maklumat Eksekutif', 'url' => ['maklumat-eksekutif']];
$this->params['breadcrumbs'][] = ['label' => 'Kategori', 'url' => ['kategori']];
$this->params['breadcrumbs'][] = ['label' => 'Kumpulan ('.$kategori[$params['k']].')', 'url' => ['kumpulan','k'=>$params['k']]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php echo $this->render('menu_info_tugas'); ?> 
</div>

<div class="col-md-3 col-sm-12 col-xs-12"> 
    <?php echo $this->render('menu_services'); ?>   
</div>
    
 <div class="col-md-9 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h6><i class="fa fa-suitcase"></i> Bilangan Staf Mengikut Jawatan</h6>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider2,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'Bil.',
                            'headerOptions'=>['style'=>'max-width: 50px;width: 50px;'],
                            'footerOptions' => [
                                'style' => 'display: ;',
                            ],
                        ],
                       [
                            'header' => ' Jawatan',
                            'value' => function ($model) {
                                
                                return $model->nama.' '.'('.$model->gred.')';
                            },
                                     'footer' => '<b>JUMLAH</b>',
                            'footerOptions' => [
                                'colspan' => '1',
                            ],
                            'format' => 'raw',
                        ],
                        [
                            'header' => 'Bilangan',
                            'value' => '_totalCount',
                            'value' => function ($model, $key, $index, $obj) {
                                $obj->footer += $model->_totalCount;
                                return $model->_totalCount;
                            },
                        ],
                    ],
                    'showFooter' => TRUE,
                ]) ?>
            </div>

        </div>
    </div>
   

    
    <div class="x_panel">
        <div class="x_title">
            <h6><i class="fa fa-users"></i> Bilangan Status Lantikan</h6>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'Bil.',
                            'headerOptions'=>['style'=>'max-width: 50px;width: 50px;'],
                            'footerOptions' => [
                                'style' => 'display: ;',
                            ],
                        ],
                        [
                            'header' => 'Staf',
                            'value' =>function($model)use ($params){
                                return Html::a($model->ApmtStatusNm, ['status-perkhidmatan','k'=>$params['k'],'s'=>$params['s'],'p'=>$model->ApmtStatusCd], ['class'=>'no-pjax']);
                            },
                            'footer' => '<b>JUMLAH</b>',
                            'footerOptions' => [
                                'colspan' => '1',
                            ],
                            'format' => 'raw',
                        ],
                        [
                            'header' => 'Bilangan',
                            'value' => '_totalCount',
                            'value' => function ($model, $key, $index, $obj) {
                                $obj->footer += $model->_totalCount;
                                return $model->_totalCount;
                            },
                        ],
                    ],
                    'showFooter' => TRUE,
                ]) ?>
            </div>

        </div>
    </div>
   
</div>
</div>