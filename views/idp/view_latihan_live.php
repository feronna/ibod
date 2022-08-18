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
use app\models\myidp\Kehadiran;
use app\models\hronline\Department;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Fruit */

error_reporting(0);

echo $this->render('/idp/_topmenu');

// the grid columns setup (only two column entries are shown here
// you can add more column entries you need for your use case)
$gridColumns = [
    [
        'label' => 'PILIH SLOT',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        //'value'=> 'slot',
        'format' => 'raw',
        'value' => function ($data) {
            return Html::a($data->slot, ["idp/view-latihan-live", 'id' => $data->siriLatihanID, 'slotID' => $data->slotID], ['class' => 'btn btn-sm btn-primary']);
            //Html::a("Refresh", ['site/index'], ['class' => 'btn btn-lg btn-primary']);
        },
    ],
    [
        'label' => 'MATA SLOT',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        //'value'=> 'mataSlot',
        'format' => 'raw',
        'value' => function ($data) {
            return $data->mataSlot . ' ' . Html::button('<i class="fa fa-edit" aria-hidden="true"></i>', [
                'id' => 'modalButton',
                'value' => \yii\helpers\Url::to([
                    'ubah-mata-slot',
                    'slotID' => $data->slotID
                ]),
                'class' => 'btn btn-sm btn-default mapBtn'
            ]);
        },
    ],
    [
        'label' => 'JUMLAH PESERTA',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($data) {
            return Kehadiran::calculatePesertaSlot($data->slotID) . ' ' . Html::a(
                '<span class="glyphicon glyphicon-trash"></span>',
                'delete-peserta-slot?slotID=' . $data->slotID,
                [
                    'data' => [
                        'confirm' => 'Adakah anda pasti anda ingin menghapuskan semua rekod kehadiran slot ini?',
                        'method' => 'post',
                    ],
                ],
                ['title' => Yii::t('app', 'Hapus')]
            );
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
        'label' => 'Tarikh & Jam Pendaftaran',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        'vAlign' => 'middle',
        'value' => 'tarikhKursus',
    ],
    // [
    //     'label' => 'Status',
    //     'hAlign' => 'center',
    //     'vAlign' => 'middle',
    //     'format' => 'raw',
    //     'vAlign' => 'middle',
    //     'value' => 'statusPeserta_',
    // ],
    [
        'label' => 'Kompetensi',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        'vAlign' => 'middle',
        'value' => 'jenisKursus',
    ],
    [
        'class' => 'yii\grid\CheckboxColumn',
        'name' => 'momo',
        'checkboxOptions' => function ($model, $key, $index, $column) {
            return ['value' => $model->staffID, 'checked' => true];
        },
    ],
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
        'label' => 'Tarikh & Jam Pendaftaran',
        'format' => 'raw',
        'vAlign' => 'middle',
        'value' => 'tarikhKursus',
    ],
    [
        'label' => 'Kompetensi',
        'format' => 'raw',
        'value' => 'jenisKursus',
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


    });
</script>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Semakan Kursus <h3><span class="label label-success" style="color: white"><?= ucwords($model->sasaran3->tajukLatihan) . ' Siri ' . ucwords(strtolower($model->siri)) ?></span></h3>
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
                        <span class="label label-primary" style="color: white">Slot <?= ucwords($modelSlot->slot) ?></span>

                        <?=

                        ExportMenu::widget([
                            'dataProvider' => $dataProviderKehadiran,
                            'columns' => $gridColumnsPeserta,
                            'filename' => 'Kehadiran Kursus ' . ucwords(strtolower($model->sasaran3->tajukLatihan)) . ' [Siri ' . $model->siri . ' - Slot ' . $modelSlot->slot . ']',
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
                <?php if ($dataProviderKehadiran->getTotalCount() > 0) { ?>
                    <p align="right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Ubah Kompentensi Peserta <i class="fa fa-paper-plane"></i></button>
                        <!--            <button type="button" class="btn btn-primary" onclick="var keys = $('#kv-grid-demo').yiiGridView('getSelectedRows').length; alert(keys > 0 ? 'Downloaded ' + keys + ' selected books to your account.' : 'No rows selected for download.');"><i class="fas fa-download"></i> Download Selected</button>-->
                    </p>
                <?php } ?>
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

                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">

                                    <div class="latihan-form">
                                        <div class="col-md-12">
                                            <div class="x_panel">
                                                <div class="x_title">
                                                    <h2>Tukar Kompetensi</h2>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="x_content">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="kod">Kompetensi Untuk Peserta Akademik: <span class="required" style="color:red;">*</span>
                                                        </label>
                                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                                            <?= Select2::widget([
                                                                'name' => 'momok',
                                                                'data' => ArrayHelper::map(Kategori::find()->where(['academic' => '1'])->all(), 'kategori_id', 'kategori_nama'),
                                                                'options' => ['placeholder' => 'Sila pilih...'],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                    'multiple' => false,
                                                                ],
                                                            ]);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="kod">Kompetensi Untuk Peserta Pentadbiran: <span class="required" style="color:red;">*</span>
                                                        </label>
                                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                                            <?= Select2::widget([
                                                                'name' => 'momokk',
                                                                'data' => ArrayHelper::map(Kategori::find()->where(['admin' => '1'])->all(), 'kategori_id', 'kategori_nama'),
                                                                'options' => ['placeholder' => 'Sila pilih...'],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                    'multiple' => false,
                                                                ],
                                                            ]);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="card-footer text-right">
                                                        <?php
                                                        echo Html::submitButton('Hantar', [
                                                            'class' => 'btn btn-success',
                                                            'name' => 'submit',
                                                            'value' => '1',
                                                            // 'id' => 'myBtn',
                                                            // 'onclick' => 'topFunction()'
                                                        ]);

                                                        // '<button class="btn btn-primary btn-sm" id="myBtn2">';
                                                        // Spinner::widget(['preset' => 'tiny', 'align' => 'left', 'caption' => 'Loading …']);
                                                        // '</button>';

                                                        ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <script>
                                    
                                </script>
                                <div class="modal-footer">
                                    <!--                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <? Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), ['class' => 'btn btn-primary', 'name' => 'submit', 'value' => '1']) ?>
                                        <?php //Html::submitButton('HANTAR', ['name' => 'submit', 'value' => 'submit_1']) 
                                        ?>
                                    </div>
                                </div>-->
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php if (date('Y', strtotime($model->tarikhMula)) == date('Y')) { ?>
    <div class="clearfix"></div>
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h3>
                    <span class="label label-danger" style="color: white">Buang Peserta</span>
                    <span class="label label-primary" style="color: white">Slot <?= ucwords($modelSlot->slot) ?></span>
                </h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $formv = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <?php Pjax::begin(); ?>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Nama Peserta : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?=
                        // With a model and without ActiveForm
                        Select2::widget([
                            'name' => 'selectionn',
                            'data' => $allPeserta,
                            'options' => ['placeholder' => 'Sila pilih...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => false,
                            ],
                        ]);
                        ?>
                    </div>
                    <p align="left">
                        <?=
                        Html::submitButton('Buang', [
                            'class' => 'btn btn-danger', 'name' => 'submit', 'value' => '4',
                            //                        'data' => [
                            //                                'confirm' => 'Adakah anda pasti anda ingin menghapuskan kehadiran peserta ini?'
                            //                            ],
                        ])
                        ?>
                    </p>

                </div>

                <?php Pjax::end(); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h3>
                    <span class="label label-success" style="color: white">Tambah Peserta</span>
                    <span class="label label-primary" style="color: white">Slot <?= ucwords($modelSlot->slot) ?></span>
                </h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <?php Pjax::begin(); ?>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Nama Peserta : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?=
                        // With a model and without ActiveForm
                        Select2::widget([
                            'name' => 'selection',
                            'data' => $allStaf,
                            'options' => ['placeholder' => 'Sila pilih...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ],
                        ]);
                        ?>
                    </div>
                    <p align="left">
                        <?= Html::submitButton('Tambah', ['class' => 'btn btn-info', 'name' => 'submit', 'value' => '2']) ?>
                    </p>

                </div>

                <?php Pjax::end(); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h3>
                    <span class="label label-default" style="color: white">Muatnaik Peserta</span>
                    <span class="label label-primary" style="color: white">Slot <?= ucwords($modelSlot->slot) ?></span>
                </h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $formx = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enctype' => 'multipart/form-data']]); ?>
                <?php Pjax::begin(); ?>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Muatnaik Dokumen (EXCEL) : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?= $formx->field($modelImport, 'fileImport')->fileInput()->label(false); ?>
                    </div>
                    <p align="left">
                        <?= Html::submitButton('Muatnaik', ['class' => 'btn btn-info', 'name' => 'submit', 'value' => '3']) ?>
                    </p>

                </div>

                <?php Pjax::end(); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php } ?>