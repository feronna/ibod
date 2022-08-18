<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Status Perkhidmatan';
$this->params['breadcrumbs'][] = ['label' => 'Maklumat Eksekutif', 'url' => ['maklumat-eksekutif']];
$this->params['breadcrumbs'][] = ['label' => 'Kategori', 'url' => ['kategori']];
$this->params['breadcrumbs'][] = ['label' => 'Kumpulan', 'url' => ['kumpulan','k'=>$params['k']]];
$this->params['breadcrumbs'][] = ['label' => 'Status Lantikan', 'url' => ['status-lantikan','k'=>$params['k'],'s'=>$params['s']]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h5><?= Html::encode('Kategori::'.Yii::$app->MP->Kategori($params['k']).' | Kumpulan::'.Yii::$app->MP->Kumpulan($params['s']).' | Lantikan::'.Yii::$app->MP->StatusLantikan($params['p'])) ?></h5>
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
                            'header' => 'Nama Jawatan',
                            'value' =>function($model)use($params){
                               
                                return Html::a($model->nama, ['senarai-kakitangan','k'=>$params['k'],'s'=>$params['s'],'p'=>$params['p'],'j'=>$model->id], ['class'=>'no-pjax']);
                            },
                            'footer' => '<b>JUMLAH KESELURUHAN</b>',
                            'footerOptions' => [
                                'colspan' => '1',
                            ],
                            'format' => 'raw',
                            'headerOptions'=>['style'=>'max-width: 500px;width: 500px;'],// <-- right here
                        ],
                        [
                            'header' => 'Gred Jawatan',
                            'value' => 'gred',
                        ],
                        [
                            'header' => 'Aktif',
                            'value' => function ($model, $key, $index, $obj)use($params) {
                                $ss = 1;
                                $v=0;
                                $temp = $model->totalServStatus($ss,$params['k'],$params['s'],$params['p']);
                                // $obj->footer;
                                $obj->footer = Html::a($v+=$temp, ['senarai-kakitangan','sl'=>$ss,'k'=>$params['k'],'s'=>$params['s'],'p'=>$params['p'],'j'=>$model->id], ['class'=>'no-pjax']);
                                return Html::a($temp, ['senarai-kakitangan','sl'=>$ss,'k'=>$params['k'],'s'=>$params['s'],'p'=>$params['p'],'j'=>$model->id], ['class'=>'no-pjax']);
                            },
                            'format'=> 'raw',
                        ],
                        [
                            'header' => 'Tidak Aktif </br> Bergaji Penuh',
                            'value' => function ($model, $key, $index, $obj)use($params) {
                                $ss = 2;
                                $temp = $model->totalServStatus($ss,$params['k'],$params['s'],$params['p']);
                                $obj->footer += $temp;
                                return Html::a($temp, ['senarai-kakitangan','sl'=>$ss,'k'=>$params['k'],'s'=>$params['s'],'p'=>$params['p'],'j'=>$model->id], ['class'=>'no-pjax']);
                            },
                            'format'=> 'raw',
                        ],
                        [
                            'header' => 'Tidak Aktif </br> Separuh Gaji',
                            'value' => function ($model, $key, $index, $obj)use($params) {
                                $ss = 3;
                                $temp = $model->totalServStatus($ss,$params['k'],$params['s'],$params['p']);
                                $obj->footer += $temp;
                                return Html::a($temp, ['senarai-kakitangan','sl'=>$ss,'k'=>$params['k'],'s'=>$params['s'],'p'=>$params['p'],'j'=>$model->id], ['class'=>'no-pjax']);
                            },
                            'format'=> 'raw',
                        ],
                        [
                            'header' => 'Tidak Aktif</br>Tanpa Gaji',
                            'value' => function ($model, $key, $index, $obj)use($params) {
                                $ss = 4;
                                $temp = $model->totalServStatus($ss,$params['k'],$params['s'],$params['p']);
                                $obj->footer += $temp;
                                return Html::a($temp, ['senarai-kakitangan','sl'=>$ss,'k'=>$params['k'],'s'=>$params['s'],'p'=>$params['p'],'j'=>$model->id], ['class'=>'no-pjax']);
                            },
                            'format'=> 'raw',
                        ],
                        [
                            'header' => 'Dalam</br>Pinjaman',
                            'value' => function ($model, $key, $index, $obj)use($params) {
                                $ss = 5;
                                $temp = $model->totalServStatus($ss,$params['k'],$params['s'],$params['p']);
                                $obj->footer += $temp;
                                return Html::a($temp, ['senarai-kakitangan','sl'=>$ss,'k'=>$params['k'],'s'=>$params['s'],'p'=>$params['p'],'j'=>$model->id], ['class'=>'no-pjax']);
                            },
                            'format'=> 'raw',
                        ],
                        [
                            'header' => 'Jumlah',
                            'value' => function ($model, $key, $index, $obj)use($params) {
                                //semua servstatus selain 06
                                $obj->footer += $model->_totalCount;
                                return Html::a($model->_totalCount, ['senarai-kakitangan','sl'=>'06','k'=>$params['k'],'s'=>$params['s'],'p'=>$params['p'],'j'=>$model->id], ['class'=>'no-pjax']);
                            },
                            'format'=> 'raw',
                        ],
                    ],
                    'showFooter' => TRUE,
                ]) ?>
            </div>

        </div>
    </div>
</div>