<?php
/* @var $this yii\web\View */

use yii\bootstrap\Alert;

use yii\grid\GridView;
use yii\helpers\Html;
use app\models\elnpt\TblPenetapPenilai;

$bio = app\models\hronline\Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->identity->ICNO]);
$penetap = TblPenetapPenilai::findOne(['ref_kump_dept' => $bio->DeptId, 'tahun' => date("Y")]);

?>

<?= $this->render('_menuUtama'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Borang Laporan Penilaian Prestasi Tinggi bagi <?= Yii::$app->user->identity->CONm ?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <?= Alert::widget([
                        'options' => ['class' => 'alert-warning'],
                        'body' => '<font color="black">
                                    <strong>INFO</strong><br>
                                    <p>
                                        Sila berhubung dengan Penetap Penilai (<strong>' . (!isset($penetap->namaPenetap->CONm) ? '<i>not set</i>' : $penetap->namaPenetap->CONm) . '</strong>) sekiranya PPP, PPK atau PEER belum ditetapkan.
                                    </p>
                                </font>',
                    ]); ?>

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
                                //                                    [
                                //                                        'class' => 'yii\grid\SerialColumn',
                                //                                        'header' => 'BIL',
                                //                                        'headerOptions' => ['class'=>'text-center'],
                                //                                        'contentOptions' => ['class'=>'text-center'],
                                //                                    ],
                                [
                                    'label' => 'TAHUN PENILAIAN',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        switch ($model->tahun) {
                                            case 2020:
                                                $u = 'elnpt2/maklumat-guru';
                                                break;
                                            case 2021:
                                                $u = 'elnpt2/maklumat-guru';
                                                break;
                                            default:
                                                $u = 'elnpt/maklumat-guru';
                                        }
                                        return Html::a('<b><u>' . $model->tahun . '</u></b>', [$u, 'lppid' => $model->lpp_id]);
                                    },
                                    //'attribute' => 'tahun',
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PPP',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->ppp) ? '<span class="label label-warning">Belum set</span>' : $model->ppp->CONm;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PPK',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->ppk) ? '<span class="label label-warning">Belum Set</span>' : $model->ppk->CONm;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PEER',
                                    'headerOptions' => ['class' => 'text-center  col-md-2'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->peer) ? '<span class="label label-warning">Belum Set</span>' : '<span class="label label-success">Sudah Set</span>';
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'MARKAH',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    //                                        'attribute' => 'tahun',
                                    //                                        'format' => 'html',
                                    'value' => function ($model) {
                                        return $model->statusBorang;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'CATATAN',
                                    'headerOptions' => ['class' => 'text-center'],
                                    //                                        'contentOptions' => ['class'=>'text-center'],
                                    'value' => function ($model) {
                                        return $model->catatan;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'JANA BORANG',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        // return $model->catatan;
                                        return ($model->PYD_sah == 1 && $model->PPP_sah == 1 && $model->PPK_sah == 1 && $model->PEER_sah == 1)
                                            ? Html::a('<i class="fa fa-print" aria-hidden="true"></i>', ['elnpt/generate-borang', 'lppid' => $model->lpp_id])
                                            : '';
                                    },
                                    'format' => 'html',
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <hr>
                <p><strong>*Klik tahun untuk mengakses borang e-LNPT.</strong></p>
            </div>
        </div>
    </div>
</div>