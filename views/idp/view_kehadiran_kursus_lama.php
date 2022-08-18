<?php

use Zxing\QrReader;
use yii\helpers\Url;
use Da\QrCode\QrCode;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\spinner\Spinner;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use kartik\export\ExportMenu;
use yii\bootstrap\ActiveForm;
use app\models\myidp\Kategori;
use app\models\myidp\VCpdLatihan;
use app\models\hronline\Department;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Fruit */

error_reporting(0);

echo $this->render('/idp/_topmenu');

// the grid columns setup (only two column entries are shown here
// you can add more column entries you need for your use case)
$gridColumns = [
    // [
    //     'label' => 'PILIH SLOT',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     //'value'=> 'slot',
    //     'format' => 'raw',
    //     'value' => function ($data) {
    //         return Html::a($data->slot, ["idp/view-latihan-live", 'id' => $data->siriLatihanID, 'slotID' => $data->slotID], ['class' => 'btn btn-sm btn-primary']);
    //         //Html::a("Refresh", ['site/index'], ['class' => 'btn btn-lg btn-primary']);
    //     },
    // ],
    // [
    //     'label' => 'MATA SLOT',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     //'value'=> 'mataSlot',
    //     'format' => 'raw',
    //     'value' => function ($data) {
    //         return $data->mataSlot . ' ' . Html::button('<i class="fa fa-edit" aria-hidden="true"></i>', [
    //             'id' => 'modalButton',
    //             'value' => \yii\helpers\Url::to([
    //                 'ubah-mata-slot',
    //                 'slotID' => $data->slotID
    //             ]),
    //             'class' => 'btn btn-sm btn-default mapBtn'
    //         ]);
    //     },
    // ],
    [
        'label' => 'JUMLAH PESERTA',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($data) {
            return VCpdLatihan::calculatePeserta($data->vcsl_kod_latihan);
        },
    ],
];

$gridColumnsPeserta = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'pageSummary' => 'Total',
        'pageSummaryOptions' => ['colspan' => 6],
        'header' => 'Bil',
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'vAlign' => 'middle',
        //                                'hAlign' => 'center',

    ],
    [
        'attribute' => 'CONm',
        'contentOptions' => ['style' => 'width:200px;'],
        'filterInputOptions' => [
            'class'  => 'form-control',
            'placeholder' => 'Cari...'
        ],
        'label' => 'Nama',
        'value' => function ($data) {
            return ucwords(strtolower($data->peserta->CONm));
        },
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'format' => 'raw',
        'vAlign' => 'middle',
    ],
    [
        'label' => 'Jawatan Disandang',
        'format' => 'raw',
        'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtolower($data->peserta->jawatan->nama)) . ' (' . ucwords(strtoupper($data->peserta->jawatan->gred)) . ')';
        }
    ],
    [
        'attribute' => 'DeptId',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'label' => 'JAFPIB',
        'value' => function ($data) {
            return ucwords(strtoupper($data->peserta->department->shortname));
        },
        'filter'    => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen                  
    ],
    [
        'label' => 'Kategori',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function ($data) {
            if ($data->peserta->jawatan->job_category == '1') {
                return 'Akademik';
            } else {
                return 'Pentadbiran';
            }
        },

    ],
    [
        'label' => 'Kompetensi',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        'value' => 'jenisKursus',
    ],
    [
        'label' => 'Jumlah Mata',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        'value' => 'vcl_jum_mata',
    ],
    // [
    //     'class' => 'yii\grid\CheckboxColumn',
    //     'name' => 'momo',
    //     'checkboxOptions' => function ($model, $key, $index, $column) {
    //         return ['value' => $model->staffID, 'checked' => true];
    //     },
    // ],
];

$gridColumnsPesertaExport = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'pageSummary' => 'Total',
        'pageSummaryOptions' => ['colspan' => 6],
        'header' => 'Bil',
        'headerOptions' => ['class' => 'kartik-sheet-style'],
    ],
    [
        'label' => 'Nama',
        'format' => 'raw',
        'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtolower($data->peserta->CONm));
        }
    ],
    [
        'label' => 'Jawatan Disandang',
        'format' => 'raw',
        'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtolower($data->peserta->jawatan->nama));
        }
    ],
    [
        'label' => 'Gred',
        'format' => 'raw',
        'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtolower($data->peserta->jawatan->gred));
        }
    ],
    [
        'label' => 'JAFPIB',
        'format' => 'raw',
        'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtoupper($data->peserta->department->shortname));
        }
    ],
    [
        'label' => 'Kategori',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function ($data) {
            if ($data->peserta->jawatan->job_category == '1') {
                return 'Akademik';
            } else {
                return 'Pentadbiran';
            }
        },

    ],
    [
        'label' => 'Kompetensi',
        'format' => 'raw',
        'value' => 'jenisKursus',
    ],
    [
        'label' => 'Jumlah Mata',
        'format' => 'raw',
        'value' => 'vcl_jum_mata',
    ],
];
?>
<script>
    $(function() {

    $('.mapBtn').click(function() {
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });



    });
</script>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Semakan Kursus <h3><span class="label label-success" style="color: white"><?= ucwords($model->vcsl_nama_latihan) ?></span></h3>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?=

                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
                    'layout' => "{items}\n{pager}",
                ]);

                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h5>Semakan Peserta
                    <h3>
                        <span class="label label-success" style="color: white">Senarai Peserta</span>

                        <?=

                        ExportMenu::widget([
                            'dataProvider' => $dataProviderKehadiran,
                            'columns' => $gridColumnsPeserta,
                            'filename' => 'Kehadiran Kursus ' . ucwords(strtolower($model->vcsl_nama_latihan)),
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/myidp/.',
                            'linkPath' => '/files/myidp/',
                            'batchSize' => 10,
                        ]); ?>
                    </h3>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="idp">
                <?php
                $form = ActiveForm::begin([
                    'method' => 'post',
                    //'action' => ['view-latihan-live?id='.$id.'&slotID='.$slotID],
                ]);
                ?>
                <?=
                GridView::widget([
                    'options' => ['id' => 'kv-grid-demo'],
                    'dataProvider' => $dataProviderKehadiran,
                    'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPeserta,
                ]);
                ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
