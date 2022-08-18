<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use app\widgets\AduanTileWidget;
/* @var $this yii\web\View */
/* @var $searchModel app\models\aduan\RptTblAduanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Senarai Aduan');
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('/aduan/_topmenu');
echo $this->render('/aduan/contact');
?>

<div class="rpt-tbl-aduan-index">
    <!-- <div class="container-fluid"> -->
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel x_panel-success">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <div class="clearfix"></div>
                </div>

                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); 
                ?>

                <p>
                    <?= Html::a(Yii::t('app', 'Aduan Baru'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'emptyText' => 'Tiada aduan ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>-</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn'],
                        // [
                        //     'class' => 'kartik\grid\SerialColumn',
                        //     'contentOptions' => ['class' => 'kartik-sheet-style'],
                        //     'width' => '36px',
                        //     'pageSummary' => 'Jumlah',
                        //     'pageSummaryOptions' => ['colspan' => 6],
                        //     'header' => 'Bil',
                        //     'headerOptions' => ['class' => 'kartik-sheet-style'],
                        // ],
                        [
                            'label' => 'Nombor Aduan',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            'value' => 'aduan.nomborAdu'

                        ],
                        [
                            //'attribute' => 'CONm',
                            'label' => 'Nama',
                            'vAlign' => 'middle',
                            'value' => function ($data) {
                                return ucwords(strtolower($data->aduan->biodata->displayGelaran.' '.$data->aduan->biodata->CONm));
                            },
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:200px;'],
                            'filterInputOptions' => [
                                'class'  => 'form-control',
                                'placeholder' => 'Cari...'
                            ],
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                        ],
                        [
                            'label' => 'Jawatan Disandang',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'value' => function ($data) {
                                return ucwords(strtolower($data->aduan->biodata->jawatan->nama));
                            }
                        ],
                        [
                            'label' => 'Gred',
                            'format' => 'raw',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            'value' => function ($data) {
                                return ucwords(strtoupper($data->aduan->biodata->jawatan->gred));
                            }
                        ],
                        [
                            'label' => 'JAFPIB',
                            'format' => 'raw',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            'value' => function ($data) {
                                return ucwords(strtoupper($data->aduan->biodata->department->shortname));
                            }
                        ],
                        [
                            'label' => 'Tarikh Aduan',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            'value' => 'aduan.tarikhAdu',
                        ],
                        [
                            'label' => 'Status Aduan',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            'format' => 'raw',
                            'value' => 'aduan.aduanStatus.statusAdu',
                            //'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                            //'captionOptions' => ['tooltip' => 'Tooltip'],
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => 'Tindakan',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{view}',
                            'buttons' => [

                                'view' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'Papar'),
                                    ]);
                                },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'view') {
                                    $url = 'view-penyiasat?id=' . $model->aduan_id;
                                    return $url;
                                }
                            }
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>