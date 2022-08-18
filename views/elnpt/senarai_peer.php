<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

use app\models\elnpt\TblLppTahun;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= $this->render('_menuUtama'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Borang</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama PYD</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <?=
                            $form->field($searchModel, 'CONm')->textInput([
                                'placeholder' => 'Cari Nama',
                            ])->label(false);
                            ?>
                        </div>
                    </div>

                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Penilaian</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_ASC,])->all(), 'lpp_tahun', 'lpp_tahun'),
                            'hideSearch' => true,
                            'options' => [
                                'placeholder' => 'Pilih Tahun',
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
                <h2><strong>Senarai Guru Yang Dinilai</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
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
                                'headerOptions' => ['class' => 'text-center  col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'NAMA PYD',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    switch ($model->tahun) {
                                        case 2020:
                                            $u = 'elnpt2/semak-lpp';
                                            break;
                                        case 2021:
                                            $u = 'elnpt2/semak-lpp';
                                            break;
                                        default:
                                            $u = 'elnpt/semak-lpp';
                                    }

                                    return Html::a(
                                        '<strong><u>' . $model->guru->CONm . '</u></strong>',
                                        [$u, 'lppid' => $model->lpp_id, 'bhg_no' => 10]
                                    ) . '<br><small>' . $model->deptGuru->fullname . '</small>' .
                                        '<br><small>' . $model->gredGuru->nama . ' ' . $model->gredGuru->gred;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'TAHUN',
                                'headerOptions' => ['class' => 'text-center  col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->tahun;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'STATUS BORANG',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return '<strong>PYD</strong> : ' . (($model->PYD_sah == 0) ? '<span class="label label-danger">Belum Sah</span>' : '<span class="label label-success">Sudah Sah</span>') . '<br>' .
                                        '<strong>PPP</strong> : ' . (($model->PPP_sah == 0) ? '<span class="label label-danger">Belum Sah</span>' : '<span class="label label-success">Sudah Sah</span>') . '<br>' .
                                        '<strong>PPK</strong> : ' . (($model->PPK_sah == 0) ? '<span class="label label-danger">Belum Sah</span>' : '<span class="label label-success">Sudah Sah</span>') . '<br>' .
                                        '<strong>PEER</strong> : ' . (($model->PEER_sah == 0) ? '<span class="label label-danger">Belum Sah</span>' : '<span class="label label-success">Sudah Sah</span>');
                                },
                                'format' => 'html',
                            ],
                            //                                [
                            //                                    'label' => 'HANTAR PERINGATAN',
                            //                                    'headerOptions' => ['class'=>'text-center  col-md-1'],
                            //                                    'value' => function($model) {
                            //                                        return '';
                            //                                    },
                            //                                    'format' => 'html',
                            //                                ],
                            [
                                'label' => 'PENILAIAN SELESAI',
                                'headerOptions' => ['class' => 'text-center  col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    // return ($model->PYD_sah == 1 && $model->PPP_sah == 1
                                    //     && $model->PPK_sah == 1 && $model->PEER_sah == 1)
                                    return ($model->PEER_sah == 1)
                                        ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' :
                                        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                                },
                                'format' => 'html',
                            ],
                        ],
                    ]);
                    ?>
                </div>
                <hr>
                <p><strong>*Klik nama PYD untuk membuat penilaian.</strong></p>
            </div>
        </div>
    </div>
</div>