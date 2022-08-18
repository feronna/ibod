<?php

use PHPUnit\Framework\Constraint\Count;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\VarDumper;

$k = $params['k'];
$s = $params['s'];

$this->title = 'Senarai Staf';
$this->params['breadcrumbs'][] = ['label' => 'Maklumat Eksekutif', 'url' => ['maklumat-eksekutif']];
$this->params['breadcrumbs'][] = ['label' => 'Kategori', 'url' => ['kategori']];
$this->params['breadcrumbs'][] = ['label' => 'Kumpulan', 'url' => ['kumpulan','k'=>$params['k']]];
$this->params['breadcrumbs'][] = ['label' => 'Status Lantikan', 'url' => ['status-lantikan','k'=>$params['k'],'s'=>$params['s']]];
$this->params['breadcrumbs'][] = ['label' => 'Status Perkhidmatan', 'url' => ['status-perkhidmatan','k'=>$params['k'],'s'=>$params['s'],'p'=>$params['p']]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h5><?= Html::encode('Kategori::'.Yii::$app->MP->Kategori($params['k']).' | Kumpulan::'.Yii::$app->MP->Kumpulan($params['s']).' | Lantikan::'.Yii::$app->MP->StatusLantikan($params['p']).' | Jawatan::'.Yii::$app->MP->Jawatan($params['j']).' | Status::'.Yii::$app->MP->ServiceStatus($params['sl'])) ?></h5>
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
                        ],
                        [
                            'header' => 'No KP',
                            'value' => 'ICNO',
                            'format' => 'raw',

                        ],
                        [
                            'header' => 'UMSPER',
                            'value' => 'COOldID',
                            'format' => 'raw',

                        ],
                        [
                            'header' => 'Nama',
                            'value' =>'CONm',
                            'format' => 'raw',
                        ],
                        [
                            'header' => 'Jabatan',
                            'value' => '_temp',
                        ],
                    ],
                    'showFooter' => false,
                ]) ?>
            </div>

        </div>
    </div>
</div>