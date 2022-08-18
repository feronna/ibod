<?php
/* @var $this yii\web\View */

use yii\bootstrap\Alert;

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

use app\models\elnpt\TblPenetapPenilai;

?>

<?php
echo $this->render('_menuUtama');
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Senarai Borang Laporan Penilaian Prestasi Khas (LNPK)</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

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
                                    'label' => 'TAHUN PENILAIAN',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->tahun;
                                    },
                                    //'attribute' => 'tahun',
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PYD',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->pyd->CONm . '<br><small>' . $model->deptPyd->fullname . '</small>' .
                                            '<br><small>' . $model->gredPyd->nama . ' ' . $model->gredPyd->gred;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PPP',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->ppp) ? null : ($model->ppp->CONm . '<br><small>' . $model->deptPpp->fullname . '</small>' .
                                            '<br><small>' . $model->gredPpp->nama . ' ' . $model->gredPpp->gred);
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'STATUS PENILAIAN',
                                    'headerOptions' => ['class' => 'text-center  col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        switch ($model->statusPenilaian) {
                                            case 1:
                                                return '<span class="label label-warning">Penilaian sedang berjalan</span>';
                                            case 2:
                                                return '<span class="label label-warning">Penilaian sedang berjalan</span>';
                                            case 3:
                                                return '<span class="label label-warning">Penilaian dan pengesahan PPP</span>';
                                            case 4:
                                                return '<span class="label label-success">Penilaian selesai</span>';
                                            default:
                                                return '<span class="label label-danger">Pengesahan belum bermula</span>';
                                        }
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'TINDAKAN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{view}',
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            //Html::a('label', ['/controller/action'], ['class'=>'btn btn-primary'])
                                            $url = Url::to(['lnpk/bahagian1', 'lnpk_id' => $model->lnpk_id]);
                                            return Html::a(
                                                '<span class="glyphicon glyphicon-eye-open"></span>',
                                                $url,
                                                [
                                                    'class' => 'btn btn-default btn-sm',
                                                ]
                                            );
                                        },
                                    ],
                                ]
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <hr>
                <p><strong>*Klik butang <span class="glyphicon glyphicon-eye-open"></span> untuk mengakses borang LNPK.</strong></p>
            </div>
        </div>
    </div>
</div>