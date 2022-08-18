<?php
/* @var $this yii\web\View */
$js = <<< JS
$("#login-form").on("beforeSubmit",function(e){
    // alert('test');
    $("#buttonBhg1").prop('disabled', true);
    $("#resetBhg1").prop('disabled', true);
    e.preventDefault();
    $("#login-form").css({pointerEvents:'none'});
    return true;
});

$('.modalBtn').on('click', function () {
    $('#modalLnpkSkt').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    $('#modalHeader').text('Tambah Aktiviti/ Projek/ Keterangan');
});

$('.modalBtn1').on('click', function () {
    $('#modalLnpkSkt').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    $('#modalHeader').text('Kemaskini Aktiviti/ Projek/ Keterangan');
});
JS;
$this->registerJs($js, \yii\web\View::POS_READY);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap\Modal;

Modal::begin([
    'header' => '<strong id="modalHeader"></strong>',
    'id' => 'modalLnpkSkt',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();

?>

<?php
echo $this->render('_menuBorang', ['lnpk_id' => $lnpk->lnpk_id]);
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>SASARAN KERJA & LAPORAN PENCAPAIAN</strong><?= $lnpk->isAdmin() ? '<sup> View as Admin</sup>' : '' ?><?= ' - ' . $lnpk->pyd->CONm ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p style="text-align:justify">
                        <strong>Laporan Pencapaian Sasaran Kerja</strong><br />
                        <i>
                            (PYD hendaklah melaporkan pencapaian sasaran kerja dalam tempoh penilaian : ..........hingga .........).<br />
                            Laporan ini boleh disediakan dalam beberapa helaian bersesuaian dengan keperluan.
                        </i>
                    </p>

                    <?= (($sktTT->isNewRecord || $sktTT->sign_PYD == null) && ($lnpk->isPYD() || $lnpk->isAdmin())) ? Html::button('Tambah Aktiviti', ['value' => yii\helpers\Url::to(['lnpk/tambah-skt', 'lnpk_id' => $lnpk->lnpk_id]), 'class' => 'pull-right btn-success btn-sm modalBtn']) : '' ?>
                    <div class="clearfix"></div>

                    <div class="table-responsive">
                        <?=
                        GridView::widget([
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
                                    'label' => 'AKTIVITI/ PROJEK/ KETERANGAN',
                                    'headerOptions' => ['class' => 'column-title text-center'],
                                    'value' => function ($model) {
                                        return $model->skt_aktiviti;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PETUNJUK PRESTASI',
                                    'headerOptions' => ['class' => 'text-center'],
                                    // 'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->petunjukPrestasi;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'SASARAN KERJA',
                                    'headerOptions' => ['class' => 'text-center'],
                                    // 'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->skt_sasar;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PENCAPAIAN SEBENAR',
                                    'headerOptions' => ['class' => 'text-center'],
                                    // 'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->skt_capai;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'ULASAN PYD',
                                    'headerOptions' => ['class' => 'text-center'],
                                    // 'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->skt_ulasan_PYD;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    //'attribute' => 'CONm',
                                    'header' => 'TINDAKAN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{update}{delete}',
                                    'visible' => !isset($sktTT->sign_dt_PYD) && ($lnpk->PYD == Yii::$app->user->identity->ICNO),
                                    //'header' => 'TINDAKAN',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            $url = yii\helpers\Url::to(['lnpk/update-skt', 'skt_id' => $model->id, 'lnpk_id' => $model->lnpk_id]);
                                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalBtn1']);
                                        },
                                        'delete' => function ($url, $model) {
                                            $url = yii\helpers\Url::to(['lnpk/delete-skt', 'skt_id' => $model->id, 'lnpk_id' => $model->lnpk_id]);
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => 'Delete', 'data-confirm' => 'Adakah anda pasti?', 'class' => 'btn btn-default btn-sm']);
                                        },
                                    ],
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <div class="col-md-3 col-xs-6 pull-left" style="text-align:center">
                        <?= ($sktTT->isNewRecord || $sktTT->sign_PYD == null) ? Html::a(
                            'Klik untuk tandatangan PYD',
                            ['lnpk/tandatangan-skt', 'lnpk_id' => $lnpk->lnpk_id],
                            [
                                'class' => (($lnpk->PYD == Yii::$app->user->identity->ICNO) || $lnpk->isAdmin()) ? 'btn btn-default btn-primary' : 'btn btn-default btn-default',
                                'data' => [
                                    'confirm' => 'Adakah anda pasti dengan tindakan ini?',
                                    'method' => 'post',
                                ],
                                'style' => (($lnpk->PYD == Yii::$app->user->identity->ICNO) || $lnpk->isAdmin()) ? "" : "pointer-events: none;"
                            ]
                        ) : $sktTT->tandatanganPyd ?>
                    </div>

                    <div class="col-md-3 col-xs-6 pull-right" style="text-align:center">
                        <?= ($sktTT->isNewRecord || $sktTT->sign_PP == null) ? Html::a(
                            'Klik untuk tandatangan ' . ($lnpk->isPP ? 'PP' : 'PPP'),
                            ['lnpk/tandatangan-skt', 'lnpk_id' => $lnpk->lnpk_id],
                            [
                                'class' => ((($lnpk->PPP == Yii::$app->user->identity->ICNO) && $sktTT->sign_PYD != null) || $lnpk->isAdmin()) ? 'btn btn-default btn-primary' : 'btn btn-default btn-default',
                                'data' => [
                                    'confirm' => 'Adakah anda pasti dengan tindakan ini?',
                                    'method' => 'post',
                                ],
                                'style' => ((($lnpk->PPP == Yii::$app->user->identity->ICNO) && $sktTT->sign_PYD != null) || $lnpk->isAdmin()) ? "" : "pointer-events: none;"
                            ]
                        ) : $sktTT->tandatanganPpp ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>