<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

error_reporting(0);


?>

<div class="col-md-12 col-xs-12">
    <?php echo $this->render('/hrpayroll/_menu'); ?>
</div>

<div class="tblprcobiodata-form">
    <div class="x_panel">
        <div class="x_title">
            <h2>Senarai Tindakan</h2>
            <div class="clearfix"></div>
        </div>
        <?php

        $roles = array_keys($tasks);
        for ($i = 0; $i < count($roles); $i++) {
            switch ($roles[$i]) {
                case 'ENTRY':
                    $url = Url::toRoute(['kemasukan-l-p-g']);
                    break;
                case 'VERIFY':
                    $url = Url::toRoute(['semakan-l-p-g']);
                    break;
                case 'APPROVE':
                    $url = Url::toRoute(['kelulusan-l-p-g']);
                    break;
                
                default:
                    $url = Url::toRoute(['index']);
                    break;
            }
            echo $roles[$i] . ' : ' . Html::a('<i class="fa red" aria-hidden="true">'.$tasks[$roles[$i]].'</i>', $url, ['target' => '_blank']);
            echo '</br>';
        }

        ?>
    </div>
</div>

<div class="tblprcobiodata-form">
    <div class="x_panel">
        <?= $this->render('_searchstaff', [
            'carian' => $carian,
        ]) ?>
    </div>
</div>

<div class="x_panel">
    <div class="x_title" style="color:#37393b;">
        <h2><?= Html::encode($this->title) ?></h2>
        <h5 class="pull-right"><?= Html::encode('Jumlah Carian: ') . $dataProvider->getCount() . " / " . $dataProvider->getTotalCount() ?></h5>
        <div class="clearfix"></div>
    </div>

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
                    'label' => 'IC/KP',
                    'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey',],
                    'value' => 'ICNO',
                ],
                [
                    'label' => 'UMSPER',
                    'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => 'COOldID',
                ],
                [
                    'label' => 'Nama',
                    'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => 'CONm',
                ],
                [
                    'label' => 'Gred',
                    'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->jawatan->gred;
                    },
                ],
                [
                    'label' => 'Email',
                    'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => 'COEmail',
                ],
                [
                    'label' => 'JFPIU',
                    'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->department->fullname;
                    },
                ],
                [
                    'label' => 'Pendidikan Tertinggi',
                    'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->pendidikan->HighestEduLevel;
                    },
                ],
                [
                    'label' => 'Kampus',
                    'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->kampus->campus_name;
                    },
                ],
                [
                    'label' => 'Status',
                    'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->serviceStatus->ServStatusNm;
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Tindakan',
                    'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                    'contentOptions' => ['class' => 'text-center',],
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['viewpayroll', 'id' => $model->ICNO], ['target' => '_blank']);
                        },
                    ],
                ],
            ],
        ]);
        ?>
    </div>
</div>