<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\myidp\SiriLatihan;
//use yii\grid\GridView; //this Yii2 Gridview cannot use 'hover'
//use \yiister\gentelella\widgets\grid\GridView; //use this one to called 'hover'

echo $this->render('/idp/_topmenu');
?><?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
<?php

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'pageSummary' => 'Jumlah',
        'pageSummaryOptions' => ['colspan' => 6],
        'header' => 'Bil',
        'headerOptions' => ['class' => 'kartik-sheet-style'],

    ],
    [
        'attribute' => 'tajukLatihan',
        'contentOptions' => ['style' => 'width:200px;'],
        'filterInputOptions' => [
            'class'       => 'form-control',
            'placeholder' => 'Cari...'
        ],
        'label' => 'Kursus',
        'value' => function ($data) {
            return ucwords(strtoupper($data->tajukLatihan));
        },
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'label' => 'Bil Siri',
        'contentOptions' => ['style' => 'width:30px;'],
        'value' => function ($data) {
            return SiriLatihan::getSiriAmount($data->kursusLatihanID);
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',

    ],
    [
        'class' => 'kartik\grid\EnumColumn',
        'attribute' => 'kategoriJawatanID',
        'label' => 'Kategori',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        // 'enum' => [
        //     'AKADEMIK' => '<span class="text-muted">AKADEMIK</span>',
        //     'PENTADBIRAN' => '<span class="text-success">PENTADBIRAN</span>',
        //     'TERBUKA' => '<span class="text-primary">TERBUKA</span>',
        // ],
        //'loadEnumAsFilter' => true, // optional - defaults to `true`
        'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
            'AKADEMIK' => 'AKADEMIK',
            'PENTADBIRAN' => 'PENTADBIRAN',
            'TERBUKA' => 'TERBUKA',
        ],
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen    
        'contentOptions' => ['style' => 'width:50px;'],
    ],
    //            [
    //                'class' => '\kartik\grid\BooleanColumn',
    //                'trueLabel' => 'AKTIF', 
    //                'falseLabel' => 'TIDAK AKTIF',
    //                'attribute' => 'statusKursusLatihan', 
    //                'vAlign' => 'middle',
    //                'filterType' => GridView::FILTER_SELECT2,
    //                'filterWidgetOptions' => [
    //                    'pluginOptions' => ['allowClear' => true],
    //                ],
    //                'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen 
    //            ],
    [
        'label' => 'Kompetensi',
        'contentOptions' => ['style' => 'width:100px;'],
        'format' => 'raw',
        'value' => 'kompetensii',
        'hAlign' => 'center',
        'vAlign' => 'middle',

    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Tindakan',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        //'headerOptions' => ['style' => 'color:#337ab7'],
        'template' => '{view} | {update} | {delete} | {linkSiri}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => Yii::t('app', 'Papar'),
                ]);
            },

            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => Yii::t('app', 'Kemaskini'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-trash"></span>',
                    $url,
                    [
                        'data' => [
                            'confirm' => 'Adakah anda pasti anda ingin menghapuskan rekod ini?',
                            'method' => 'post',
                        ],
                    ],
                    ['title' => Yii::t('app', 'Hapus'),]
                );
            },
            'linkSiri' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-tags"></span>', $url, [
                    'title' => Yii::t('app', 'Tambah Siri'),
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url = 'view-latihan?id=' . $model->kursusLatihanID;
                return $url;
            }

            if ($action === 'update') {
                $url = 'update-latihan?id=' . $model->kursusLatihanID; //hantar ke Controller
                return $url;
            }

            if ($action === 'delete') {
                $url = 'delete-latihan?id=' . $model->kursusLatihanID;
                return $url;
            }

            if ($action === 'linkSiri') {
                $url = 'form-tambah-siri?id=' . $model->kursusLatihanID;
                return $url;
            }
        }
    ],

]





?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Senarai Kursus Anjuran
                    <h3><span class="label label-primary" style="color: white">DALAMAN</span>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                    </h3>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>
                    <!-- ubah kat sini -->
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'showFooter' => true,
                            'showHeader' => true,
                            'layout' => "{items}\n{pager}",
                            'pager' => [
                                'firstPageLabel' => 'Halaman Pertama',
                                'lastPageLabel'  => 'Halaman Terakhir'
                            ],
                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA PENETAPAN</b></i>'],
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                            'columns' => $gridColumns,
                        ]);
                        ?>
                    </div>
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>