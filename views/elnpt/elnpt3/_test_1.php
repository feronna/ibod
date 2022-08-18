<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'id' => 'kategori1',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider,
        'showFooter' => false,
        'pjax' => true,
        'rowOptions' => function ($model) {
            if ($model['id'] == 6) {
                return ['class' => 'danger'];
            }
        },
        'pjaxSettings' => [
            'options' => [
                'id' => 'pjax_kategori1_result',
            ],
        ],
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
                    if ($model['id'] == 6) {
                        return '<del>' . rtrim($model['aktiviti']) . '</del>';
                    }
                    return (!$model['auto'] ? (!($model['lain']) ? '<span class="label label-default">Pending</span> ' : '<span class="label label-primary">Manual</span> ') : '') . rtrim($model['aktiviti']) . ' ' . (($model['lain'] && $model['modal']) ?  Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to(['elnpt3/aktiviti-lain', 'lppid' => $lpp->lpp_id, 'kategori' => $model['kategori']]), 'class' => 'btn btn-default btn-xs modalButton1_2']) : '');
                },
                'format' => 'raw',
            ],
            [
                'header' => 'BIL UNIT',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return ($model['id'] != 6) ?  (isset($model['input']) ? $model['input'] : '<span class="label label-warning">No data available</span>') : '';
                }, // configure even group cell css class
                'format' => 'html',
            ],
            [
                'header' => 'MATA DIPEROLEH',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return ($model['id'] != 6) ? ('<b>' . Yii::$app->formatter->asDecimal($model['mata'], 2) . '</b>') : '';
                }, // configure even group cell css class
                'format' => 'html',
            ],
        ],
    ]);
    ?>
</div>