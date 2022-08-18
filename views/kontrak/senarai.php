<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\kontrak\Kontrak;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $searchModel app\models\kontrak\KontrakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

error_reporting(0);
?>

<?= $this->render('/kontrak/_topmenu') ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian (Sesi / Tahun)</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $forms = ActiveForm::begin([
                    'action' => ['senarai'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1,
                        'class' => 'disable-submit-buttons'
                    ],

                ]);
                ?>
                <div class="form-group">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?= Select2::widget([
                            'name' => 'sesi',
                            'value' => $sesi,
                            'data' => ['3' => 'JANUARI', '4' => 'APRIL', '5' => 'JULAI', '6' => 'OKTOBER'],
                            'options' => [
                                'placeholder' => 'Sesi Kontrak'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]); ?>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?= DatePicker::widget([
                            'name' => 'tahun',
                            'value' =>  $tahun,
                            'type' => DatePicker::TYPE_INPUT,
                            'options' => [
                                'placeholder' => 'Tahun', 'autocomplete' => 'off'
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy',
                                //                        'viewMode' => "years", 
                                'minViewMode' => "years"
                            ]
                        ]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Cari', ['class' => 'btn btn-primary', 'name' => 'search', 'value' => 'submit_1']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Permohonan Pelantikan Semula Kontrak</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <?= Html::a('<i class="text-success fa fa-download"></i> Muat Turun', ['report', 'sesi' => $sesi, 'tahun' => $tahun], ['style' => "float: right; font-size:18px;", 'target' => "_blank"]) ?>

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


            <div class="x_content">


                <?=
                GridView::widget([
                    'options' => [
                        'class' => 'table-responsive',
                    ],
                    'dataProvider' => $dataProvider,
                    'filterModel' => true,
                    'summary' => '',
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'format' => 'raw',
                            'label' => 'Nama Pemohon',
                            'value' => function ($data) {
                                return Html::a($data->kakitangan->CONm, ["permohonankontrak", 'id' => $data->id], ['target' => '_blank']);
                            },
                            'filter' => Select2::widget([
                                'name' => 'icno',
                                'value' => $icno,
                                'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'contentOptions' => ['style' => 'text-decoration: underline;'],
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'label' => 'Jawatan',
                            'value' => 'kakitangan.jawatan.nama',
                            'filter' => Select2::widget([
                                'name' => 'jawatan',
                                'value' => $jawatan,
                                'data' => ArrayHelper::map(\app\models\hronline\GredJawatan::find()->where(['job_category' => '2'])->all(), 'id', 'fname'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'label' => 'JFPIU',
                            'value' => 'kakitangan.department.shortname',
                            'filter' => Select2::widget([
                                'name' => 'jfpiu',
                                'value' => $jfpiu,
                                'data' => ArrayHelper::map(\app\models\hronline\Department::find()->all(), 'id', 'shortname'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'header' => 'Taraf Jawatan',
                            'attribute' => 'kakitangan.statusLantikan.ApmtStatusNm',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'header' => 'Tarikh Mula Kontrak',
                            'value' => 'startdatelantik',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'label' => 'Tarikh Tamat Kontrak',
                            'value' => 'enddatelantik',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'attribute' => 'tarikh_m',
                            'value' => 'tarikhmohon',
                            'label' => 'Tarikh Mohon',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'header' => 'LNPT terakhir',
                            'value' => function ($data) {
                                if ($data->markahlnpt(date('Y') - 1)) {
                                    $tahun = $data->markahlnpt(date('Y') - 1) . "\n(" . (date('Y') - 1) . ")";
                                } else {
                                    $tahun = "-" . "<br>(" . (date('Y') - 1) . ")";
                                }
                                return $tahun;
                            },
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'header' => 'Kategori LNPT',
                            'value' => function ($data) {

                                $kat = '-';

                                if ($data->markahlnpt(date('Y') - 1)) {
                                    $tahun = $data->markahlnpt(date('Y') - 1);

                                    $kat = Kontrak::getKatLnpt($tahun);
                                }

                                return $kat;
                            },
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'header' => 'Kategori Kehadiran',
                            'attribute' => 'kategoriStars',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'header' => 'Status Persetujuan PP',
                            'attribute' => 'statuspp',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'filter' => Select2::widget([
                                'name' => 'statuspp',
                                'value' => $statuspp,
                                'data' => [
                                    '6' => '<span class="label label-warning">Menunggu</span>',
                                    '4' => '<span class="label label-success">Dipersetujui</span>',
                                    '5' => '<span class="label label-danger">Ditolak</span>'
                                ],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
                        ],
                        [
                            'label' => 'Status Perakuan Ketua JFPIU',
                            'attribute' => 'statusjfpiu',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'filter' => Select2::widget([
                                'name' => 'statuskj',
                                'value' => $statuskj,
                                'data' => [
                                    '6' => '<span class="label label-warning">Menunggu</span>',
                                    '4' => '<span class="label label-success">Diperakui</span>',
                                    '5' => '<span class="label label-danger">Ditolak</span>'
                                ],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
                        ],
                        [
                            'label' => 'Status Kelulusan BSM',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'filter' => Select2::widget([
                                'name' => 'statusbsm',
                                'value' => $statusbsm,
                                'data' => [
                                    '6' => '<span class="label label-warning">Menunggu</span>',
                                    '4' => '<span class="label label-success">Diluluskan</span>',
                                    '5' => '<span class="label label-danger">Ditolak</span>'
                                ],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
                            'value' => function ($data) {
                                if ($data->status_bsm == '12') {
                                    $checked = 'checked';
                                }
                                if ($data->status_bsm == '13') {
                                    $checked1 = 'checked';
                                }
                                if ($data->status_bsm == '4' || $data->status_bsm == '5') {
                                    return $data->statusbsm;
                                }
                                return Html::a('<input type="radio" name="' . $data->id . '" value="y' . $data->id . '" ' . $checked . '><i class="fa fa-check"></i>') . '  ' . Html::a('<input type="radio" name="' . $data->id . '" value="n' . $data->id . '" ' . $checked1 . '><i class="fa fa-remove"></i>');
                            },
                        ],
                        [
                            'label' => 'Tempoh Kontrak Baru',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'contentOptions' => ['style' => 'width: 150px;'],
                            'value' => function ($data) {
                                if ($data->status == 4) {
                                    return $data->tempoh_l_bsm;
                                } elseif ($data->status == 5) {
                                    return '-';
                                } else {
                                    return Select2::widget([
                                        'name' => 't' . $data->id,
                                        'value' => $data->tempoh_l_bsm,
                                        'data' => ArrayHelper::map(app\models\Kontrak\RefTempoh::find()->where(['job_category' => [2, 3]])->andWhere(['!=', 'tempoh', 'Lain-lain'])->all(), 'tempoh', 'tempoh'),
                                        'options' => ['placeholder' => ''],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        ],
                                    ]);
                                }
                            },
                        ],
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
                                if (($data->status_bsm == '4' || $data->status_bsm == '5')) {
                                    return ['disabled' => 'disabled'];
                                }
                                return ['value' => $data->id, 'checked' => true];
                            },
                        ],
                    ],
                    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                    'resizableColumns' => true,
                    'responsive' => false,
                    'responsiveWrap' => false,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                    'resizableColumnsOptions' => ['resizeFromBody' => true]
                ]);
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                    <?= Html::a('<i class="fa fa-book"></i> Ringkasan Data', ['ringkasan_data', 'sesi' => $sesi, 'tahun' => $tahun], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
                    <?= Html::a('<i class="fa fa-book"></i> Belum Memohon', ['belummohon'], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
                    <?= Html::submitButton(Yii::t('app', ''), ['class' => 'btn btn-primary', 'name' => 'searchs', 'value' => 'submit_1', 'style' => 'display:none']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Notifikasi Pemohon'), ['class' => 'btn btn-primary', 'name' => 'notipemohon', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Notifikasi Pegawai'), ['class' => 'btn btn-primary', 'name' => 'notipegawai', 'value' => 'submit_2']) ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-paper-plane"></i>Hantar</button>

                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']) ?>

                </div>

            </div>
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            Tarikh Mula Lantikan Baru : <?= Kontrak::formatdate(app\models\kontrak\TblBukapermohonan::find()->where(['id' => $sesi])->one()->new_start_date) ?>

                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Tarikh Auto Kemaskini Tarikh Lantikan Baru
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <?= DatePicker::widget([
                                            'name' => 'autodate',
                                            'readonly' => true,
                                            'type' => DatePicker::TYPE_INPUT,
                                            'options' => [
                                                'placeholder' => 'Biarkan kosong jika kemaskini secara manual', 'autocomplete' => 'off'
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => 'yyyy-mm-dd'
                                            ]
                                        ]); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>