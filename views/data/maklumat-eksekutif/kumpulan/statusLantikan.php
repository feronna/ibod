<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Status Lantikan';
$this->params['breadcrumbs'][] = ['label' => 'Maklumat Eksekutif', 'url' => ['maklumat-eksekutif']];
$this->params['breadcrumbs'][] = ['label' => 'Kategori', 'url' => ['kategori']];
$this->params['breadcrumbs'][] = ['label' => 'Kumpulan', 'url' => ['kumpulan','k'=>$params['k']]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h5><?= Html::encode('Kategori::'.Yii::$app->MP->Kategori($params['k']).') | '.'Kumpulan::'.Yii::$app->MP->Kumpulan($params['s'])) ?></h5>
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
                            'header' => 'Status Lantikan',
                            'value' =>function($model)use ($params){
                                return Html::a($model->ApmtStatusNm, ['status-perkhidmatan','k'=>$params['k'],'s'=>$params['s'],'p'=>$model->ApmtStatusCd], ['class'=>'no-pjax']);
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

        <div class="x_content">
            <?=
            $this->render('../chart/akademik/_chartPengurusanTertinggi', [
                'array' => $array,
            ]);
            ?>

        </div>
    </div>
</div>