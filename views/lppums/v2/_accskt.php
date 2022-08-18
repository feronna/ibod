<?php

use app\models\lppums\v2\RefAspek;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => false,
    // 'sort' => false,
    // 'sort' => ['attributes' => ['month']]
    'sort' => [
        'defaultOrder' => ['month' => SORT_ASC],
    ],
]);
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <p><i><?= $desc; ?></i></p>

                    <?= RefAspek::aspekInfo($aspekId); ?>

                    <hr />
                    <div class="clearfix"></div>

                    <div class="table-responsive">
                        <?= ($aspekId != 10 || $aspekId != 7 || $aspekId != 9) ?
                            GridView::widget([
                                'emptyText' => 'Tiada Rekod',
                                'striped' => false,
                                'summary' => '',
                                'dataProvider' => $dataProvider,
                                'showFooter' => false,
                                'toolbar' => [],
                                'panel' => [
                                    'heading' => ($lpp->PYD == Yii::$app->user->identity->ICNO && is_null($tt->skt_tt_pyd)) ? Html::button('Tambah SKT', ['value' => Url::to(['lppums/tambah-skt-test', 'lpp_id' => $lpp->lpp_id, 'chosen_tab' => $currTab]), 'class' => 'pull-right btn-success btn-sm modalButtonn']) : '',
                                    'type' => 'default',
                                    // 'before' => Html::a('<i class="fas fa-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
                                    'footer' => false,
                                ],
                                // 'rowOptions' => function ($model) {
                                //     if (date('m') != $model->month && ($model->month != date('m') - 1)) {
                                //         return ['style' => 'background-color:rgb(235,235,228)'];
                                //     }
                                // },
                                'columns' => [
                                    [
                                        'header' => 'BULAN',
                                        'headerOptions' => ['class' => 'text-center col-md-1'],
                                        'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                        'value' => function ($model) {
                                            return ucfirst($model->monthLabel->slabel ?? '');
                                        },
                                        'group' => true,

                                    ],
                                    [
                                        'label' => 'RINGKASAN AKTIVITI / PROJEK',
                                        'headerOptions' => ['class' => 'column-title text-center'],
                                        // 'contentOptions' => ['style' => 'vertical-align:middle'],
                                        'value' => function ($model) {
                                            return '<sup>' . Yii::$app->formatter->asDate($model->updated_dt ?? $model->created_dt, 'dd/MM/yyyy') . '</sup><br>' . $model->ringkasan;
                                        },
                                        'format' => 'html',
                                    ],
                                    [
                                        'label' => 'SASARAN KERJA',
                                        'headerOptions' => ['class' => 'column-title text-center'],
                                        // 'contentOptions' => ['style' => 'vertical-align:middle'],
                                        'value' => function ($model) {
                                            return  $model->sasaran_kerja;
                                        },
                                        'format' => 'html',
                                    ],
                                    [
                                        'label' => 'PENCAPAIAN SEBENAR',
                                        'headerOptions' => ['class' => 'column-title text-center'],
                                        // 'contentOptions' => ['style' => 'vertical-align:middle'],
                                        'value' => function ($model) {
                                            return $model->capai;
                                        },
                                        'format' => 'html',
                                    ],
                                    [
                                        'label' => 'DOKUMEN',
                                        'headerOptions' => ['class' => 'text-center col-md-1'],
                                        'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                        'value' => function ($model) {
                                            return ($model->document) ? Html::a("<i class='fa fa-file' aria-hidden='true'></i>
                                        ", Url::to(['lppums/view-file', 'hashfile' => $model->document->filehash, 'lpp_id' => $model->lpp_id]), ['data-pjax' => 0, 'target' => '_blank', 'class' => 'btn btn-xs btn-default']) : '';
                                            // return $model->id;
                                        },
                                        'format' => 'raw',
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'TINDAKAN',
                                        'headerOptions' => ['class' => 'text-center col-md-1'],
                                        'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                        'template' => '{update} {delete}',
                                        'visible' => ($lpp->PYD == Yii::$app->user->identity->ICNO && is_null($tt->skt_tt_pyd)),
                                        //'header' => 'TINDAKAN',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                $url = Url::to(['lppums/edit-skt-test', 'lpp_id' => $model->lpp_id, 'skt_id' => $model->id]);
                                                return $model->id ? Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-xs modalButtonn1']) : '';
                                            },
                                            'delete' => function ($url, $model) {
                                                $url = Url::to(['lppums/delete-skt-test', 'lpp_id' => $model->lpp_id, 'skt_id' => $model->id]);
                                                return $model->id ?  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => 'Delete', 'data-confirm' => 'Adakah anda pasti?', 'class' => 'btn btn-default btn-xs']) : '';
                                            },
                                        ],
                                    ]
                                ],
                            ]) : '';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>