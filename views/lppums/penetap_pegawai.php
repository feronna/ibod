<?php

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;

$gridColumn = [
    [
        'class' => 'yii\grid\SerialColumn',
        'header' => 'BIL',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
    ],
    [
        'label' => 'NAMA',
        'headerOptions' => ['class' => 'column-title'],
        'value' => function ($model) {
            return '<strong>' . $model->pyd->CONm . '</strong><br><small>' . $model->pyd->department->fullname . '</small>' .
                '<br><small>' . $model->pyd->jawatan->nama . ' ' . $model->pyd->jawatan->gred;
        },
        'format' => 'html',
    ],
    [
        'label' => 'JAFPIB',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return $model->pyd->department->shortname;
        },
    ],
    [
        'label' => 'TAHUN',
        'headerOptions' => ['class' => 'text-center col-md-1'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return $model->tahun;
        },
    ],
    [
        'label' => 'PPP',
        'headerOptions' => ['class' => 'column-title text-center'],
        'value' => function ($model) {
            if (is_null($model->ppAll)) {
                if (!is_null($model->ppp)) {
                    return '<strong>' . $model->ppp->CONm . '</strong><br><small>' . $model->ppp->department->fullname . '</small>' .
                        '<br><small>' . $model->ppp->jawatan->nama . ' ' . $model->ppp->jawatan->gred;
                }
            } else {
                return '<i> <font color="green">Set Sebagai PP</font> </i>';
            }
        },
        'format' => 'html',
    ],
    [
        'label' => 'PPK',
        'headerOptions' => ['class' => 'column-title text-center'],
        'value' => function ($model) {
            if (is_null($model->ppAll)) {
                if (!is_null($model->ppk)) {
                    return '<strong>' . $model->ppk->CONm . '</strong><br><small>' . $model->ppk->department->fullname . '</small>' .
                        '<br><small>' . $model->ppk->jawatan->nama . ' ' . $model->ppk->jawatan->gred;
                }
            } else {
                return '<i> <font color="green">Set Sebagai PP</font> </i>';
            }
        },
        'format' => 'html',
    ],
    [
        'label' => 'PP',
        'headerOptions' => ['class' => 'column-title text-center'],
        'value' => function ($model) {
            if (!is_null($model->ppAll)) {
                return '<strong>' . $model->ppAll->CONm . '</strong><br><small>' . $model->ppAll->department->fullname . '</small>' .
                    '<br><small>' . $model->ppAll->jawatan->nama . ' ' . $model->ppAll->jawatan->gred;
            }
        },
        'format' => 'html',
    ],
    [
        'label' => 'STATUS',
        'headerOptions' => ['class' => 'column-title text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return $model->pyd->serviceStatus->ServStatusNm;
        },
        'format' => 'html',
    ],
    [
        'label' => 'CATATAN',
        'headerOptions' => ['class' => 'column-title text-center'],
        'value' => function ($model) {
            return $model->catatan;
        },
        'format' => 'html',
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'TINDAKAN',
        'headerOptions' => ['class' => 'text-center col-md-1'],
        'contentOptions' => ['class' => 'text-center'],
        'template' => '{update}',
        'buttons' => [
            'update' => function ($url, $model) {
                $url = Url::to(['lppums/penetapan-pegawai', 'lppid' => $model->lpp_id,]);
                return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
            },
        ],
    ],
];

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$tmp = 'penetap-pegawai-penilai';
$title = 'Penetapan Pegawai Penilai (PPP, PPK)';
?>

<?= $this->render('_menuUtama'); ?>

<?= $this->render('_carian_borang', ['model' => $searchModel, 'tmp' => $tmp, 'title' => $title]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Pegawai Pentadbiran</strong></h2>
                <div class="pull-right">
                    <?php
                    echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumn,
                        'exportConfig' => [
                            ExportMenu::FORMAT_TEXT => false,
                        ],
                        'filename' => 'senarai_penilai'
                    ]);
                    ?></div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <?php
                        echo \kartik\grid\GridView::widget([
                            'emptyText' => 'Tiada Rekod',
                            'summary' => '',
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumn,
                        ]);
                        ?>
                    </div>
                    <?php
                    Modal::begin([
                        'id' => 'modal',
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id='modalContent'></div>";
                    Modal::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>