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
use kartik\export\ExportMenu;

//use kartik\select2\Select2;
//use yii\helpers\ArrayHelper;
//use yii\widgets\ActiveForm;
//use yii\helpers\Html;

use app\models\elnpt\Department;
use app\models\elnpt\TblLppTahun;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= $this->render('_menuPenetap'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Pegawai</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Guru</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'CONm')->textInput([
                                'placeholder' => 'Cari Nama',
                            ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. KP / Pasport Guru</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'PYD')->textInput([
                                'placeholder' => 'Cari No. KP / Pasport',
                            ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Penilaian</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TblLppTahun::find()->all(), 'lpp_tahun', 'lpp_tahun'),
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian Tahun Penilaian', 
                                    // 'id' => 'ppp'
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
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
                <h2><strong>Penetapan Pegawai Penilai (PPP, PPK, PEER)</strong></h2>
                <div class="pull-right">
                    <?php
                    echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'TAHUN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->tahun;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'NAMA GURU',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return '<b>' . $model->guru->CONm . '</b><br><small>' . $model->deptGuru->fullname . '</small>' .
                                        '<br><small>' . $model->gredGuru->nama . ' ' . $model->gredGuru->gred;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'PPP',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->ppp) ? '<span class="label label-warning">Belum Set</span>' :
                                        '<b>' . $model->ppp->CONm . '</b>';
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'PPK',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->ppk) ? '<span class="label label-warning">Belum Set</span>' :
                                        '<b>' . $model->ppk->CONm . '</b>';
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'PEER',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->peer) ? '<span class="label label-warning">Belum Set</span>' :
                                        '<b>' . $model->peer->CONm . '</b>';
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'CATATAN',
                                'headerOptions' => ['class' => 'text-center'],
                                //                                    'contentOptions' => ['class'=>'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->catatan) ? '' : $model->catatan;
                                },
                                //'attribute' => 'tahun',
                                'format' => 'html',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'TINDAKAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{reset}',
                                'buttons' => [
                                    'reset' => function ($url, $model) {
                                        $url = Url::to(['elnpt/kemaskini-pegawai-penilai', 'lpp_id' => $model->lpp_id]);
                                        return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    },
                                ],
                            ],
                        ],
                        'exportConfig' => [
                            ExportMenu::FORMAT_TEXT => false,
                            //                        ExportMenu::FORMAT_HTML => false
                        ],
                        'filename' => 'senarai_penilai'
                    ]);
                    ?></div>
                <div class="clearfix"></div>

                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?php
                    Modal::begin([
                        'header' => 'Tambah/Kemaskini Penilai',
                        'id' => 'modal',
                        'size' => 'modal-md',
                    ]);
                    echo "<div id='modalContent'></div>";
                    Modal::end();
                    ?>
                    <?=
                        \kartik\grid\GridView::widget([
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
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'label' => 'TAHUN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->tahun;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'NAMA GURU',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return '<b>' . $model->guru->CONm . '</b><br><small>' . $model->deptGuru->fullname . '</small>' .
                                            '<br><small>' . $model->gredGuru->nama . ' ' . $model->gredGuru->gred;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PPP',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->ppp) ? '<span class="label label-warning">Belum Set</span>' :
                                            '<b>' . $model->ppp->CONm . '</b>';
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PPK',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->ppk) ? '<span class="label label-warning">Belum Set</span>' :
                                            '<b>' . $model->ppk->CONm . '</b>';
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PEER',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->peer) ? '<span class="label label-warning">Belum Set</span>' :
                                            '<b>' . $model->peer->CONm . '</b>';
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'CATATAN',
                                    'headerOptions' => ['class' => 'text-center'],
                                    //                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->catatan) ? '' : $model->catatan;
                                    },
                                    //'attribute' => 'tahun',
                                    'format' => 'html',
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'TINDAKAN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{reset}',
                                    'buttons' => [
                                        'reset' => function ($url, $model) {
                                            $url = Url::to(['elnpt/kemaskini-pegawai-penilai', 'lpp_id' => $model->lpp_id]);
                                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                        },
                                    ],
                                ],
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>