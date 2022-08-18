<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\dass\TblPenilaianDass21;
use kartik\date\DatePicker;

$this->registerJs("
document.getElementById('btn_refresh').addEventListener('click', refresh, false);

function refresh()
{
    $.pjax.reload({
        container:'#grid_report',
        timeout:60000,
    })
}
");

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

$tmp = 'carian-borang-lpp';
$title = 'Carian borang LPP';

function relative_date($time)
{
    $today = strtotime(date('M j, Y'));
    $reldays = ($time - $today) / 86400;
    if ($reldays >= 0 && $reldays < 1) {
        return 'Today';
    } else if ($reldays >= 1 && $reldays < 2) {
        return 'Tomorrow';
    } else if ($reldays >= -1 && $reldays < 0) {
        return 'Yesterday';
    }
    if (abs($reldays) < 7) {
        if ($reldays > 0) {
            $reldays = floor($reldays);
            return 'In ' . $reldays . ' day' . ($reldays != 1 ? 's' : '');
        } else {
            $reldays = abs(floor($reldays));
            return $reldays . ' day' . ($reldays != 1 ? 's' : '') . ' ago';
        }
    }
    if (abs($reldays) < 182) {
        return date('l, j F', $time ? $time : time());
    } else {
        return date('l, j F, Y', $time ? $time : time());
    }
}
?>

<?= $this->render('_navbar') ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Borang</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['action' => ['carian-borang'], 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?>

                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">Nama
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'CONm')->textInput(['id' => 'nama_pyd'])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group jspiu">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai">Senarai JSPIU</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'dept_id')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC])->all(), 'id', 'fullname'),
                            'options' => [
                                'placeholder' => 'Pilih Jabatan',
                                'class' => 'form-control col-md-7 col-xs-12',
                                //'selected'    => 2,
                                'id' => 'senarai',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group tarikh">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikh">Tarikh</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?=
                        $form->field($searchModel, 'created_dt')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Pilih Tarikh'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                            ]
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group tahun">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai-tahun">Tahun</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?=
                        $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TblPenilaianDass21::find()->select('tahun')->orderBy(['tahun' => SORT_DESC])->all(), 'tahun', 'tahun'),
                            'options' => [
                                'placeholder' => 'Pilih Tahun',
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'selected'    => 2,
                                'id' => 'senarai-tahun',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="pull-right">
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Jana</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <?php Pjax::begin(['id' => 'grid_report']); ?>
                    <?=
                    GridView::widget([
                        //'tableOptions' => [
                        //  'class' => 'table table-striped jambo_table',
                        //],
                        'emptyText' => 'Tiada Rekod',
                        'summary' => '',
                        'dataProvider' => $listDownloads,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'NAMA',
                                'headerOptions' => ['class' => 'text-center'],
                                'attribute' => 'file_name',
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'USER',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->createUser->CONm;
                                }
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'DATE CREATED',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                // 'attribute' => 'created_dt',
                                'value' => function ($model) {
                                    return relative_date(strtotime($model->created_dt));
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'TINDAKAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{download} {delete}',
                                //'header' => 'TINDAKAN',
                                'buttons' => [
                                    'download' => function ($url, $model) use ($uapi) {
                                        return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', $uapi->DisplayFile($model->filehash, true), ['title' => 'Download']);
                                    },
                                    'delete' => function ($url, $model) {
                                        $url = Url::to(['dass-21/delete-file', 'filehash' => $model->filehash]);
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => 'Delete', 'data-confirm' => 'Adakah anda pasti?']);
                                    },
                                ],
                            ]
                        ],
                    ]);
                    ?>
                    <?php Pjax::end(); ?>
                </div>

                <p>
                    Sila tekan butang
                    <?=
                    Html::button(
                        '<span class="glyphicon glyphicon-refresh"></span>',
                        [
                            'id' => 'btn_refresh',
                            'class' => 'btn btn-default btn-sm',
                        ]
                    );
                    ?>
                    untuk <i>refresh</i> semula senarai di atas.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Hasil Carian</strong></h2>
                <?= Html::a('<i class="fa fa-download"> Muat Turun Carian</i>', ['dass21/generate-report'], ['class' => 'btn btn-default btn-sm pull-right']); ?>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        //'tableOptions' => [
                        //  'class' => 'table table-striped jambo_table',
                        //],
                        'emptyText' => 'Tiada Rekod',
                        'summary' => '',
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'NAMA',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return Html::a('<strong>' . $model->biodata->CONm . '</strong>', ['/dass21/view-assessment', 'id' => $model->id]) . '<br><small>' . $model->department->fullname . '</small>' .
                                        '<br><small>' . $model->jawatan->nama . ' ' . $model->jawatan->gred;
                                },
                                'format' => 'html',
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'JSPIU',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->department->shortname;
                                },
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'TARIKH / MASA',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'attribute' => 'created_dt'
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'TAHUN',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'attribute' => 'tahun'
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'SKOR',
                                'headerOptions' => ['class' => 'text-center'],
                                //'contentOptions' => ['class'=>'text-center'],
                                'value' => function ($model) use ($rubric) {
                                    foreach (array_reverse($rubric->depression_scale) as $key) {
                                        if ($model->skor_d >= $key['score']) {
                                            $d_msg = $key['status'];
                                            break;
                                        }
                                    }

                                    foreach (array_reverse($rubric->anxiety_scale) as $key) {
                                        if ($model->skor_a >= $key['score']) {
                                            $a_msg = $key['status'];
                                            break;
                                        }
                                    }

                                    foreach (array_reverse($rubric->stress_scale) as $key) {
                                        if ($model->skor_s >= $key['score']) {
                                            $s_msg = $key['status'];
                                            break;
                                        }
                                    }

                                    return '<ul><li>Depression : ' . $model->skor_d . '/21 <b>' . $d_msg . '</b></li>' .
                                        '<li>Anxiety : ' . $model->skor_a . '/21 <b>' . $a_msg . '</li>' .
                                        '<li>Stress : ' . $model->skor_s . '/21 <b>' . $s_msg . '</b></li></ul>';
                                },
                                'format' => 'html',
                            ],
                            /*[
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'PPK',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['lppums/penetapan-pegawai', 'lppid' => $model->lpp_id,]);
                                    return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                                        'title' => 'Penetapan Pegawai',
                                    ]);
                                },
                            ],
                        ],*/
                        ],
                    ]);
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>