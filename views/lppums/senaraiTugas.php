<?php
/* @var $this yii\web\View */

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>

<?php
Modal::begin([
    'header' => 'Tambah / Kemaskini Rekod',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?= $this->render('_menuBorang', ['lppid' => $lpp->lpp_id]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Tugas</strong> <?= (($lpp->PYD != Yii::$app->user->identity->ICNO)) ? '(' . $lpp->pyd->CONm . ' - ' . $lpp->tahun . ')' : '' ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?=
                    DetailView::widget([
                        'model' => $lpp,
                        'attributes' => [
                            //'ICNO',
                            [
                                'label' => 'NAMA',
                                'value' => function ($model) {
                                    return strtoupper($model->pyd->CONm);
                                },
                                'captionOptions' => ['style' => 'width:25%'],
                                'format' => 'html',
                            ],
                            [
                                'label' => 'JAWATAN',
                                'value' => function ($model) {
                                    return strtoupper($model->gredJawatan->nama) . ' ' . $model->gredJawatan->gred;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'BERTANGGUNGJAWAB KEPADA',
                                'value' => function ($model) {
                                    return '';
                                },
                                'format' => 'html',
                            ],
                            //                               [
                            //                                   'label' => 'SENARAI TUGAS',
                            //                                   'value' => function($model){
                            //                                       return '';
                            //                                   },
                            //                                   'format' => 'html',
                            //                               ],
                        ],
                    ]);
                    ?>
                </div>
                <div class="row">

                    <?php if (
                        $lpp->PYD_sah == 0 and  ($lpp->PYD == \Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59'))
                        or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))
                    ) { ?>
                        <?= Html::button('Tambah Rekod', ['value' =>  Url::to(['lppums/tambah-senarai', 'lpp_id' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
                    <?php } ?>

                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'tableOptions' => [
                                'class' => 'table table-sm table-bordered',
                            ],
                            'emptyText' => 'Tiada rekod penetapan SKT',
                            'summary' => '',
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'senarai_tugas',
                                    'label' => 'Senarai Tugas',
                                    'headerOptions' => ['class' => 'text-center col-md-9'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Tindakan',
                                    'visible' => ($lpp->PYD_sah == 0 and $lpp->PYD == Yii::$app->user->identity->ICNO
                                        and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59')) or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO)),
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{update}{delete}',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            $url = Url::to(['lppums/update-senarai', 'sktid' => $model->senarai_tugas_id, 'lpp_id' => $model->lpp_id]);
                                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                        },
                                        'delete' => function ($url, $model) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/lppums/delete-senarai', 'sktid' => $model->senarai_tugas_id, 'lpp_id' => $model->lpp_id], ['class' => 'btn btn-default btn-sm']);
                                        },
                                    ],
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-xs-4 pull-right" style="text-align: center;">
                        <?php if (is_null($lpp->KJ_sah) and (($lpp->PPP == Yii::$app->user->identity->ICNO) or ($lpp->PPK == Yii::$app->user->identity->ICNO))) {
                            echo Html::a(
                                'Klik untuk tandatangan Ketua Jabatan',
                                ['lppums/tandatangan-kj', 'lpp_id' => $_GET['lpp_id']],
                                [
                                    'class' => 'btn btn-default btn-primary',
                                    'data' => [
                                        'confirm' => 'Adakah anda pasti dengan tindakan ini?',
                                        'method' => 'post',
                                    ],
                                ]
                            );
                        } ?>
                        <p>
                            Saya telah menyemak senarai tugas di atas dan disahkan, maklumat di atas adalah benar
                        </p>
                        <?= Html::input('text', 'password1', (is_null($lpp->KJ_sah) ? '' : $lpp->kjDetails), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center; height: 50px']) ?>
                        <p style="margin-top: 10px">
                            <strong>
                                (Nama & Pengesahan Ketua Jabatan)
                            </strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>