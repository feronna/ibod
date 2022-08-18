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
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= $this->render('_menuAdmin'); ?>

<?= $this->render('_searchBorang', ['model' => $searchModel]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Hasil Carian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <?php
                Modal::begin([
                    'header' => 'Reset Borang',
                    'id' => 'modal',
                    'size' => 'modal-md',
                ]);
                echo "<div id='modalContent'></div>";
                Modal::end();
                ?>
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        //'tableOptions' => [
                        //  'class' => 'table table-striped jambo_table',
                        //],
                        'emptyText' => 'Tiada Rekod',
                        'summary' => '',
                        'pager' => [
                            'class' => \kop\y2sp\ScrollPager::className(),
                            'container' => '.grid-view tbody',
                            'triggerOffset' => 10,
                            'item' => 'tr',
                            'paginationSelector' => '.grid-view .pagination',
                            'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                        ],
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'ID BORANG',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->lpp_id;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'TAHUN PENILAIAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->tahun;
                                },
                                //'attribute' => 'tahun',
                                'format' => 'html',
                            ],
                            [
                                'label' => 'GURU',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->guru->CONm . '<br>' . $model->deptGuru->fullname . '</small>' .
                                        '<br><small>' . $model->gredGuru->nama . ' ' . $model->gredGuru->gred;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'PPP',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    switch ($model->tahun) {
                                        case 2020:
                                            $u = 'elnpt2/semak-lpp';
                                            break;
                                        case 2021:
                                            $u = 'elnpt2/maklumat-guru';
                                            break;
                                        default:
                                            $u = 'elnpt/semak-lpp';
                                    }

                                    return is_null($model->ppp) ? '<font color="maroon"><i>(not set)</i></font>' : Html::a('<strong>' . $model->ppp->CONm . '</strong>', Url::to([$u, 'lppid' => $model->lpp_id, 'bhg_no' => 1, 'icno' => $model->PPP]), ['data-pjax' => 0, 'target' => '_blank']) . '<br><small>';
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'PPK',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    switch ($model->tahun) {
                                        case 2020:
                                            $u = 'elnpt2/semak-lpp';
                                            break;
                                        case 2021:
                                            $u = 'elnpt2/maklumat-guru';
                                            break;
                                        default:
                                            $u = 'elnpt/semak-lpp';
                                    }

                                    return is_null($model->ppk) ? '<font color="maroon"><i>(not set)</i></font>' : Html::a('<strong>' . $model->ppk->CONm . '</strong>', Url::to([$u, 'lppid' => $model->lpp_id, 'bhg_no' => 1, 'icno' => $model->PPK]), ['data-pjax' => 0, 'target' => '_blank']) . '<br><small>';
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'PEER',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    switch ($model->tahun) {
                                        case 2020:
                                            $u = 'elnpt2/semak-lpp';
                                            break;
                                        case 2021:
                                            $u = 'elnpt2/maklumat-guru';
                                            break;
                                        default:
                                            $u = 'elnpt/semak-lpp';
                                    }

                                    return is_null($model->peer) ? '<font color="maroon"><i>(not set)</i></font>' : Html::a('<strong>' . $model->peer->CONm . '</strong>', Url::to([$u, 'lppid' => $model->lpp_id, 'bhg_no' => ($model->tahun) >= 2020 ? 10 : 9, 'icno' => $model->PEER]), ['data-pjax' => 0, 'target' => '_blank']) . '<br><small>';
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'STATUS PENILAIAN PPP',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return ($model->PPP_sah == 1) ? '<i class="fa fa-check-circle" style="font-size:24px;color:green"></i>' :
                                        '<i class="fa fa-close" style="font-size:24px;color:red"></i>';
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'STATUS PENILAIAN PPK',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return ($model->PPK_sah == 1) ? '<i class="fa fa-check-circle" style="font-size:24px;color:green"></i>' :
                                        '<i class="fa fa-close" style="font-size:24px;color:red"></i>';
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'STATUS PENILAIAN PEER',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return ($model->PEER_sah == 1) ? '<i class="fa fa-check-circle" style="font-size:24px;color:green"></i>' :
                                        '<i class="fa fa-close" style="font-size:24px;color:red"></i>';
                                },
                                'format' => 'html',
                            ],

                            //                                [
                            //                                    'class' => 'yii\grid\ActionColumn',
                            //                                    'header' => 'TINDAKAN',
                            //                                    'headerOptions' => ['class'=>'text-center col-md-2'],
                            //                                    'contentOptions' => ['class'=>'text-center'],
                            //                                    'template' => '{reset}',
                            //                                    'buttons' => [
                            //                                        'reset' => function ($url, $model) {
                            //                                            $url = Url::to(['elnpt/reset', 'lpp_id' => $model->lpp_id]);
                            //                                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                            //
                            //                                        },
                            //                                    ],
                            //                                ],            
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>