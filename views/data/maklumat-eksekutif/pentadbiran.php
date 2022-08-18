<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Pentadbiran';
$this->params['breadcrumbs'][] = ['label' => 'Maklumat Eksekutif', 'url' => ['maklumat-eksekutif']];
$this->params['breadcrumbs'][] = ['label' => 'Maklumat Eksekutif Kakitangan', 'url' => ['maklumat-eksekutif-kakitangan']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'header' => 'Id',
                            'value' => 'id',
                            'footerOptions' => [
                                'style' => 'display: ;',
                            ]
                        ],
                        [
                            'header' => 'Kumpulan',
                            'value' => 'name',
                            'footer' => 'TOTAL',
                            'footerOptions' => [
                                'colspan' => '1',
                            ]
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
            $this->render('chart/_chartPentadbiran', [
                'array' => $array,
            ]);
            ?>

        </div>
    </div>
</div>