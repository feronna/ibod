<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\widgets\Breadcrumbs;

$this->title = 'Kategori';
$this->params['breadcrumbs'][] = ['label' => 'Maklumat Eksekutif', 'url' => ['maklumat-eksekutif']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h5><?= Html::encode($this->title) ?></h5>
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
                            'header'=>'Kategori',
                            'value'=>function($model){
                                return Html::a($model->kategori, ['kumpulan','k'=>$model->id], ['class'=>'no-pjax']);
                            },
                            'footer' => '<b>JUMLAH KESELURUHAN</b>',
                            'footerOptions' => [
                                'colspan' => '1',
                            ],
                            'format' => 'raw',
                            
                        ],
                        [
                            'header' => 'Jumlah',
                            'value' => '_totalCount',
                            'value' => function($model, $key, $index, $obj){
                                $obj->footer +=$model->_totalCount;
                                return $model->_totalCount;
                            },
                        ],
                    ],
                    'showFooter'=>TRUE,
                ]) ?>
            </div>

        </div>
    </div>
    <div class="x_panel">

        <div class="x_content">         
        <?= 
         $this->render('chart/_chartMEK',[
             'array' => $array,
         ]);
        ?>          

        </div>
    </div>
</div>