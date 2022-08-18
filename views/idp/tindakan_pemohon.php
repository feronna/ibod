<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\detail\DetailView;

echo $this->render('/idp/_topmenu');

//$jumlahLayak = $model->layakYuran + $model->layakTiketPenerbangan + $model->layakPenginapan;
// setup your attributes
// DetailView Attributes Configuration
$attributes = [
    [
        'group' => true,
        'label' => 'BAHAGIAN 1 : MAKLUMAT KURSUS',
        'rowOptions' => ['class' => 'table-info']
    ],
    [
        'columns' => [
            [
                'label' => 'Anjuran',
                'format' => 'raw',
                'value' => $model->penganjur,
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:30%']
            ],
            [
                'label' => 'Penganjur',
                'value' => $model->namaPenganjur,
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:70%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Program',
                'format' => 'raw',
                'value' => '<span class="text-justify"><kbd>' . $model->namaProgram . '</kbd></span>',
                'type' => DetailView::INPUT_TEXTAREA,
                'options' => ['rows' => 4]
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Tarikh Mula',
                'value' => Yii::$app->formatter->asDate($model->tarikhMula),
                'displayOnly' => true,
            ],

        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Tarikh Tamat',
                'value' => Yii::$app->formatter->asDate($model->tarikhTamat),
                'displayOnly' => true,
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Jumlah Hari',
                'value' => $model->daysKursus,
                'format' => 'raw',
                'inputContainer' => ['class' => 'col-sm-6'],
                // hide this in edit mode by adding `kv-edit-hidden` CSS class
                'rowOptions' => ['class' => 'warning kv-edit-hidden', 'style' => 'border-top: 5px double #dedede'],
            ],

        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Tempat',
                'format' => 'raw',
                'value' => $model->lokasi,
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:100%']
            ],
        ],
    ],
    [
        'attribute' => 'failProgram1',
        'label' => 'Dokumen 1',
        'format' => 'raw',
        //'value' => html::a(Yii::$app->FileManager->NameFile($model->failProgram1), Yii::$app->FileManager->DisplayFile($model->failProgram1)),
        'value' => $model->displayLink,
        'displayOnly' => true,
        'valueColOptions' => ['style' => 'width:100%']
    ],
    [
        'attribute' => 'failProgram2',
        'label' => 'Dokumen 2',
        'format' => 'raw',
        //'value' => html::a(Yii::$app->FileManager->NameFile($model->failProgram2), Yii::$app->FileManager->DisplayFile($model->failProgram2)),
        'value' => $model->displayLink2,
        'displayOnly' => true,
        'valueColOptions' => ['style' => 'width:100%']
    ],
    [
        'attribute' => 'failProgram3',
        'label' => 'Dokumen 3',
        'format' => 'raw',
        //'value' => html::a(Yii::$app->FileManager->NameFile($model->failProgram3), Yii::$app->FileManager->DisplayFile($model->failProgram3)),
        'value' => $model->displayLink3,
        'displayOnly' => true,
        'valueColOptions' => ['style' => 'width:100%']
    ],
    // [
    //     'group' => true,
    //     'label' => 'BAHAGIAN 3 : SENARAI PESERTA',
    //     'rowOptions' => ['class' => 'table-info']
    // ],
    // [
    //     'columns' => [
    //         [   
    //             'label' => 'Peserta',
    //             'format' => 'raw',
    //             'value' => '<span class="text-justify">' . $model->displayPeserta . '</span>',
    //             'type' => DetailView::INPUT_TEXTAREA,
    //             'options' => ['rows' => 4]
    //         ],
    //     ],
    // ],
    [
        'group' => true,
        'label' => 'BAHAGIAN 2 : APA YANG ANDA TELAH PELAJARI DARIPADA KURSUS INI?',
        'rowOptions' => ['class' => 'table-info']
    ],
    [
        'columns' => [
            [
                'label' => 'Pelajaran Kursus',
                'format' => 'raw',
                'value' => '<span class="text-justify"><em>' . $model->laporan . '</em></span>',
                'type' => DetailView::INPUT_TEXTAREA,
                'options' => ['rows' => 4]
            ],
        ],
    ],
    [
        'group' => true,
        'label' => 'Tarikh Permohonan : ' . Yii::$app->formatter->asDate($model->tarikhPohon, 'php:d-m-Y'),
        'rowOptions' => ['class' => 'table-info']
    ],
];

$gridColumnsPeserta2 = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'pageSummary' => 'Total',
        'pageSummaryOptions' => ['colspan' => 6],
        'header' => 'Bil',
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'hAlign' => 'center',
        'vAlign' => 'middle',


    ],
    [
        'label' => 'Nama',
        'format' => 'raw',
        'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtolower($data->biodata->gelaran->Title)) . ' ' . ucwords(strtolower($data->biodata->CONm));
        }
    ],
    [
        'label' => 'JAFPIB',
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtoupper($data->biodata->department->shortname));
        }
    ],
    [
        'label' => 'Kompetensi Dipohon',
        'format' => 'raw',
        'value' => 'kompetensii',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'label' => 'Kompetensi Lulus',
        'format' => 'raw',
        'value' => 'kompetensiLuluss',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'label' => 'Mata IDP Lulus',
        //'name' => 'momo',
        'value' => function ($data) {

            if ($data->statusKS == 1) {
                return Html::textInput($data->staffID, $data->mataIDPlulus, ['disabled' => 'disabled']);
            } else {
                //return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => true]);

                if ($data->statusPL == 1) {
                    return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => 'true']);
                } else {
                    if ($data->jumlahJamHadir != 0) {
                        return Html::textInput($data->staffID, $data->jumlahJamHadir * 1, ['required' => true]);
                    } else {
                        return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => true]);
                    }
                }
            }
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
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
        //                                'header' => 'Bil',
        //                                'vAlign' => 'middle',
        //                                'hAlign' => 'center',

    ],
    //            [
    //                'label' => 'Slot',
    //                'value' => 'slotID'
    //            ],
    //            [
    //                'label' => 'ID Peserta',
    //                'value' => 'staffID'
    //            ],
    [
        'label' => 'Nama Kakitangan',
        'format' => 'raw',
        'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtolower($data->biodata->gelaran->Title)) . ' ' . ucwords(strtolower($data->biodata->CONm));
        }
    ],
    [
        'label' => 'JAFPIB',
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtoupper($data->biodata->department->shortname));
        }
    ],
    [
        'label' => 'Kompetensi Dipohon',
        'format' => 'raw',
        // 'value' => function ($data) {
        //     return $data->sasaran9->kompetensii;
        // },
        'value' => 'kompetensii',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
];
?>
<!-- ************************************ DETAIL VIEW ********************************************* -->
<script>
    function checkTerms() {
        // Get the checkbox
        var checkBox = document.getElementById("checkbox1");

        // If the checkbox is checked, display the output text
        if (checkBox.checked === true) {
            document.getElementById("submitb").disabled = false;
        } else {
            document.getElementById("submitb").disabled = true;
        }
    }
</script>

<!-- -->
<?php if ($model->statusPermohonan == '11') { ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h5>
                        <h3><span class="label label-danger" style="color: white">Permohonan Dibatalkan</span>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </h3>
                    </h5>
                </div>
                <div class="x_content">
                    <!-- ada x_content baru boleh collapse -->
                    <div class="x_panel">
                        <?php
                        if ($model->tarikhBatalPermohonan) {

                            if ($model->dibatalkanOleh) {
                                echo 'Dibatalkan Oleh :</br></br>';
                                echo strtoupper($model->pembatal->gelaran->Title) . ' ' . $model->pembatal->CONm . '</br>';
                                echo strtoupper($model->pembatal->jawatan->nama) . '</br>';
                                echo strtoupper($model->pembatal->department->fullname) . '</br></br>';
                            }
                            echo 'Tarikh Batal : ' . Yii::$app->formatter->asDate($model->tarikhBatalPermohonan, 'php:d-m-Y');
                            echo '</br></br>';
                            echo 'Justifikasi Batal : ';
                            echo '<i>' . $model->justifikasiBatal . '</i>';
                        } else {
                            echo '';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($model->pemohonID != $id) { ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h5>
                        <h3><span class="label label-success" style="color: white">Permohonan Oleh Urusetia JAFPIB</span>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </h3>
                    </h5>
                </div>
                <div class="x_content">
                    <!-- ada x_content baru boleh collapse -->
                    <div class="x_panel">
                        <?php
                        if ($model->tarikhPohon) {
                            echo 'Dipohon Oleh :</br></br>';
                            echo strtoupper($model->biodata->gelaran->Title) . ' ' . $model->biodata->CONm . '</br>';
                            echo strtoupper($model->biodata->jawatan->nama) . '</br>';
                            echo strtoupper($model->biodata->department->fullname) . '</br></br>';
                            echo 'Tarikh Permohonan : ' . Yii::$app->formatter->asDate($model->tarikhPohon, 'php:d-m-Y');
                            echo '</br></br>';
                        } else {
                            echo '';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<!-- -->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>
                    <h3><span class="label label-primary" style="color: white">Maklumat Kursus</span>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </h3>
                </h5>
            </div>
            <div class="x_content">
                <?=
                // View file rendering the widget
                DetailView::widget([
                    'model' => $model,
                    'attributes' => $attributes,
                    'mode' => 'view',
                    'bordered' => true,
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'hover' => true,
                    'hAlign' => 'right',
                    'vAlign' => 'middle',
                    'fadeDelay' => 1,
                    'panel' => [
                        'type' => 'info',
                        //'heading' => 'Butir-Butir Latihan',
                        //'footer' => '<div class="text-center text-muted">This is a sample footer message for the detail view.</div>'
                    ],
                    'buttons1' => false,
                    'deleteOptions' => [ // your ajax delete parameters
                        'params' => ['id' => $model->permohonanID, 'kvdelete' => true],
                    ],
                    'container' => ['id' => 'kv-demo2'],
                    //'formOptions' => ['action' => Url::current(['#' => 'kv-demo2'])] // your action to delete
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
                <h5>
                    <h3>
                        <span class="label label-success" style="color: white">Senarai Peserta</span>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </h3>
                </h5>
            </div>
            <div class="x_content">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
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
            </div>
        </div>
    </div>
</div>

<?php if ($model->statusPermohonan == '99' && ($model->pemohonID == $id)) { ?>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h5>
                        <h3>
                            <span class="label label-danger" style="color: white">Tambah Peserta</span>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </h3>
                    </h5>
                </div>
                <div class="x_content">
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <?php Pjax::begin(); ?>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-4">Nama Peserta : </label>
                        <div class="col-md-6 col-sm-6 col-xs-10">
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
                            <?= Html::submitButton('Tambah Peserta', ['class' => 'btn btn-info', 'name' => 'submit', 'value' => '1']) ?>
                            <?= Html::submitButton('Hantar Permohonan', [
                                'class' => 'btn btn-primary',
                                //'data' => ['confirm' => 'Adakah anda pasti ingin menghantar permohonan anda?'],
                                'name' => 'submit',
                                'value' => '2'
                            ]) ?>
                        </p>


                    </div>

                    <?php Pjax::end(); ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<?php if ($model->statusPermohonan != '99') { ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h5>
                        <h3>
                            <span class="label label-warning" style="color: white">Pengesahan Ketua Jabatan / Dekan / Pengarah</span>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </h3>
                    </h5>
                </div>
                <div class="x_content">
                    <?php if ($model->tarikhSemakanKJ == NULL) {

                        $forms = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                        <div class="form-group">
                            <?= $forms->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5, 'placeholder' => 'Menunggu pengesahan Ketua Jabatan/Pengarah anda...', 'disabled' => 'disabled'))->label(false); ?>
                        </div>
                    <?php
                        ActiveForm::end();
                    } else { ?>
                        <div class="form-group">
                            <div class="x_panel">
                                <?php
                                if ($model->tarikhSemakanKJ) {

                                    if ($model->kjPenyemak) {
                                        echo 'Disahkan Oleh :</br></br>';
                                        echo strtoupper($model->pengesah->gelaran->Title) . ' ' . $model->pengesah->CONm . '</br>';
                                        echo strtoupper($model->pengesah->jawatan->nama) . '</br>';
                                        echo strtoupper($model->pengesah->department->fullname) . '</br></br>';
                                    }
                                    echo 'Tarikh : ' . Yii::$app->formatter->asDate($model->tarikhSemakanKJ);
                                    echo '</br></br>';
                                    echo 'Ulasan : ';
                                    echo '<i>' . $model->ulasanKJ . '</i>';
                                } else {
                                    echo '';
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($model->statusUL) { ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h5>Semakan
                        <h3><span class="label label-default" style="color: white">Urusetia</span>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </h3>
                    </h5>
                </div>

                <div class="x_content">
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                    <?=
                                    $model->statusULL;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <!--
                            <?php //$formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); 
                            ?>   
                            </div>-->
                                <div class="x_panel" style="background-color: #cecece">
                                    <?= Yii::$app->formatter->asDate($model->tarikhSemakanUL, 'php:d-m-Y'); ?>
                                </div>
                            </div>
                        </div>
                        <?php //if ($userLevel == "ul") { 
                        ?>
                        <!--                        <div class="form-group">
                            <div class="col-sm-3"></div> 
                            <div class="col-sm-9">
                                <?php //Html::resetButton('Reset', ['class' => 'btn btn-primary']); 
                                ?>
                                <?php //Html::submitButton('Simpan', ['class' => 'btn btn-success']) 
                                ?>
                                <p align="right"><?= Html::submitButton(Yii::t('app', 'Kemaskini <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'), ['class' => 'btn btn-primary']) ?></p>
                            </div>
                        </div>-->
                        <?php //} 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($model->statusBSM) { ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h5>Semakan
                        <h3><span class="label label-info" style="color: white">Pegawai</span>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </h3>
                    </h5>
                </div>
                <div class="x_content">
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                    <?=
                                    $model->statusBSMM;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <!--
                            <?php //$formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); 
                            ?>   
                            </div>-->
                                <div class="x_panel" style="background-color: #cecece">
                                    <?= Yii::$app->formatter->asDate($model->tarikhSemakanBSM, 'php:d-m-Y'); ?>
                                </div>
                            </div>
                        </div>
                        <?php //if ($userLevel == "ul") { 
                        ?>
                        <!--                        <div class="form-group">
                            <div class="col-sm-3"></div> 
                            <div class="col-sm-9">
                                <?php //Html::resetButton('Reset', ['class' => 'btn btn-primary']); 
                                ?>
                                <?php //Html::submitButton('Simpan', ['class' => 'btn btn-success']) 
                                ?>
                                <p align="right"><?= Html::submitButton(Yii::t('app', 'Kemaskini <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'), ['class' => 'btn btn-primary']) ?></p>
                            </div>
                        </div>-->
                        <?php //} 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($model->statusSektor) { ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h5>Semakan
                        <h3><span class="label label-success" style="color: white">Sektor</span>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </h3>
                    </h5>
                </div>
                <div class="x_content">

                    <?php

                    if ($model->statusSektor == '4') {


                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'pager' => [
                                'firstPageLabel' => 'Halaman Pertama',
                                'lastPageLabel'  => 'Halaman Terakhir'
                            ],
                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                            'columns' => $gridColumnsPeserta2,
                        ]);
                    }

                    ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                    <?=
                                    $model->statusSektorr;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <!--
                            <?php //$formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); 
                            ?>   
                            </div>-->
                                <div class="x_panel" style="background-color: #cecece">
                                    <?= Yii::$app->formatter->asDate($model->tarikhKelulusan, 'php:d-m-Y'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>