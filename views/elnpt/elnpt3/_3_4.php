<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->registerJs("
    $('.modalButton3_4').on('click', function () {
        $('#modal3_4').modal('show')
                .find('#modalContent1')
                .load($(this).attr('value'));
    });
");
?>

<?php
Modal::begin([
    'header' => '<strong>Senarai Aktiviti Lain</strong>',
    'id' => 'modal3_4',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false
    ]
]);
echo "<div id='modalContent1'></div>";
Modal::end();
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
            <h4>Penyelidikan</h4>
        </li>
    </ol>
</nav>

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'id' => 'data_kategori3',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider2,
        'showFooter' => false,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'BIL',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'header' => 'PROJEK ID',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['ProjectID'];
                }
            ],
            [
                'header' => 'TAJUK PROJEK',
                'headerOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['Title'];
                }
            ],
            [
                'header' => 'PERANAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['Peranan'];
                }
            ],
            [
                'header' => 'PEMBIAYA',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['AgencyName'];
                }
            ],
            [
                'header' => 'KATEGORI PEMBIAYA',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    switch ($model['Tahap_geran']):
                        case '1':
                            $str = 'GERAN UNIVERSITI';
                            break;
                        case '2':
                            $str = 'GERAN LUAR (TEMPATAN)';
                            break;
                        case '3':
                            $str = 'GERAN LUAR (ANTARABANGSA)';
                            break;
                        default:
                            $str = $model['Tahap_geran'];
                            break;
                    endswitch;
                    return $str;
                }
            ],
            [
                'header' => 'JUMLAH BIAYA (RM)',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return is_null($model['Amount']) ? 'RM 0' : Yii::$app->formatter->asCurrency($model['Amount'], 'RM ');
                }
            ],
            [
                'header' => 'MULA',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model['StartDate'], 'yyyy');
                }
            ],
            [
                'header' => 'TAMAT',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model['EndDate'], 'yyyy');
                }
            ],
        ]
    ]);
    ?>
</div>

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'id' => 'kategori3',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider,
        'showFooter' => false,
        'columns' => [
            [
                'header' => 'HAKIKI',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return $model['isHakiki'] ? 'Hakiki' : 'Selain Hakiki';
                },
                'group' => true,
                // 'groupOddCssClass' => '',  // configure odd group cell css class
                // 'groupEvenCssClass' => '', // configure even group cell css class
            ],
            [
                'header' => 'BIL',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return $model['bil'];
                },
                'group' => true,
                'groupOddCssClass' => '',  // configure odd group cell css class
                'groupEvenCssClass' => '', // configure even group cell css class
            ],
            [
                'label' => 'AKTIVITI',
                'headerOptions' => ['class' => 'column-title text-center'],
                'contentOptions' => ['style' => 'vertical-align:middle'],
                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                    return (!$model['auto'] ? (!($model['lain']) ? '<span class="label label-default">Pending</span> ' : '<span class="label label-primary">Manual</span> ') : '') . rtrim($model['aktiviti']) . ' ' . (($model['lain'] && $model['modal']) ?  Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to(['elnpt3/aktiviti-lain', 'lppid' => $lpp->lpp_id, 'kategori' => $model['kategori']]), 'class' => 'btn btn-default btn-xs modalButton3_4', 'style' => 'visibility: hidden;']) : '');
                },
                'format' => 'raw',
            ],
            [
                'header' => 'BIL UNIT',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    $arryCurr = [57, 58, 59];
                    return isset($model['input']) ? (in_array($model['id'], $arryCurr) ? Yii::$app->formatter->asCurrency($model['input'], 'RM ') : $model['input']) : '<span class="label label-warning">No data available</span>';
                }, // configure even group cell css class
                'format' => 'html',
            ],
            [
                'header' => 'MATA DIPEROLEH',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return '<b>' . Yii::$app->formatter->asDecimal($model['mata'], 2) . '</b>';
                }, // configure even group cell css class
                'format' => 'html',
            ],
        ],
    ]);
    ?>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
            <h4>Penerbitan</h4>
        </li>
    </ol>
</nav>

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'id' => 'data_kategori4',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider4,
        'showFooter' => false,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'BIL',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'header' => 'ID PENERBITAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['PubID'];
                }
            ],
            [
                'header' => 'JENIS PENERBITAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['Bilangan_penerbitan'];
                }
            ],
            [
                'header' => 'TAJUK',
                'headerOptions' => ['class' => 'text-center'],
                // 'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['Title'];
                }
            ],
            [
                'header' => 'TAHUN TERBIT',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['PublicationYear'];
                }
            ],
            // [
            //     'header' => 'TAHUN PENYERAHAN',
            //     'headerOptions' => ['class' => 'text-center col-md-1'],
            //     'contentOptions' => ['class' => 'text-center'],
            //     'value' => function ($model) {
            //         return $model['SubmissionYear'];
            //     }
            // ],
            [
                'header' => 'STATUS PENULIS',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['Status_penulis'];
                }
            ],
            // [
            //     'header' => 'PENULIS',
            //     'headerOptions' => ['class' => 'text-center'],
            //     'contentOptions' => ['class' => 'text-center'],
            //     'value' => function ($model) {
            //         return $model['FullAuthorName'];
            //     }
            // ],
            [
                'header' => 'STATUS INDEKS',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['Status_indeks'];
                }
            ],
            [
                'header' => 'STATUS PENERBITAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['Status_penerbitan'];
                }
            ],
            [
                'header' => 'BIL PENULIS UMS',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['bil_penulis'];
                }
            ],
        ]
    ]);
    ?>
</div>

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'id' => 'kategori4',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider3,
        'showFooter' => false,
        'columns' => [
            [
                'header' => 'HAKIKI',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return $model['isHakiki'] ? 'Hakiki' : 'Selain Hakiki';
                },
                'group' => true,
                // 'groupOddCssClass' => '',  // configure odd group cell css class
                // 'groupEvenCssClass' => '', // configure even group cell css class
            ],
            [
                'header' => 'BIL',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return $model['bil'];
                },
                'group' => true,
                'groupOddCssClass' => '',  // configure odd group cell css class
                'groupEvenCssClass' => '', // configure even group cell css class
            ],
            [
                'label' => 'AKTIVITI',
                'headerOptions' => ['class' => 'column-title text-center'],
                'contentOptions' => ['style' => 'vertical-align:middle'],
                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                    return (!$model['auto'] ? (!($model['lain']) ? '<span class="label label-default">Pending</span> ' : '<span class="label label-primary">Manual</span> ') : '') . rtrim($model['aktiviti']) . ' ' . (($model['lain'] && $model['modal']) ?  Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to(['elnpt3/aktiviti-lain', 'lppid' => $lpp->lpp_id, 'kategori' => $model['kategori']]), 'class' => 'btn btn-default btn-xs modalButton3_4', 'style' => 'visibility: hidden;']) : '');
                },
                'format' => 'raw',
            ],
            [
                'header' => 'BIL UNIT',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return isset($model['input']) ? $model['input'] : '<span class="label label-warning">No data available</span>';
                }, // configure even group cell css class
                'format' => 'html',
            ],
            [
                'header' => 'MATA DIPEROLEH',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return '<b>' . Yii::$app->formatter->asDecimal($model['mata'], 2) . '</b>';
                }, // configure even group cell css class
                'format' => 'html',
            ],
        ],
    ]);
    ?>
</div>

<?= $this->renderAjax('_mini_summary', ['miniSummary' => $miniSummary]) ?>