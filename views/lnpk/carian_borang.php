<?php

$js = <<< JS
$('.modalBtn').on('click', function () {
    $('#modalLnpkSkt').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    $('#modalHeader').text('Tambah Borang LNPK');
});
$('.modalBtn1').on('click', function () {
    $('#modalLnpkSkt').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    $('#modalHeader').text('Kemaskini Borang LNPK');
});

JS;
$this->registerJs($js, \yii\web\View::POS_READY);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\db\Expression;

use app\models\lppums\TblLppTahun;
use app\models\hronline\GredJawatan;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;

$tahunn = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();

Modal::begin([
    'header' => '<strong id="modalHeader"></strong>',
    'id' => 'modalLnpkSkt',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?php
$referrerUrl = trim(Yii::$app->request->referrer, '/');

if (strpos($referrerUrl, 'lppums') !== false) {
    echo $this->render('//lppums/_menuAdmin');
} else if (strpos($referrerUrl, 'elnpt') !== false) {
    echo $this->render('//elnpt/_menuAdmin');
}


?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Borang</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left'], 'action' => ['lnpk/carian-borang']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama PYD</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'PYD')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['!=', 'Status', 6])->all(), 'ICNO', 'CONm'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                //                                'id' => 'ppp'
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gred Jawatan</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'gred_jawatan_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(GredJawatan::find()
                                ->select(new Expression('fname, id'))
                                ->orderBy(['id' => SORT_ASC])->all(), 'id', 'fname'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian Nama',
                                'class' => 'form-control col-md-7 col-xs-12',
                                //'selected'    => 2,
                                //'id' => 'senarai',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">JSPIU</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'jspiu')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC,])->all(), 'id', 'fullname'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Cari JFPIU',
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Penilaian</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_DESC,])->all(), 'lpp_tahun', 'lpp_tahun'),
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
                <h2><strong> Senarai Borang Laporan Penilaian Prestasi Khas (LNPK)</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <?= Html::button('Tambah Borang', ['value' => yii\helpers\Url::to(['lnpk/create-borang']), 'class' => 'pull-right btn-success btn-sm modalBtn']) ?>
                <div class="clearfix"></div>

                <p><b><?= ($this->context->action->id == 'senarai-pyd-ppk') ? '* Klik loceng untuk kembalikan borang kepada PPP jika perlu.' : (($this->context->action->id == 'senarai-pyd-ppp') ? '* Klik loceng untuk kembalikan borang kepada PYD jika perlu.' : '') ?></b></p>

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
                                'label' => 'TAHUN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->tahun;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'JENIS',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->jenisBorang->lnpk_desc;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'PYD',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return Html::a('<strong><u>' . $model->pyd->CONm . '</u></strong>', Url::to(['lnpk/bahagian1', 'lnpk_id' => $model->lnpk_id]), ['target' => '_blank']) . '<br><small>' . $model->deptPyd->fullname . '</small>' .
                                        '<br><small>' . $model->gredPyd->nama . ' ' . $model->gredPyd->gred;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'PPP',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return ($model->ppp)
                                        ? '<strong>' . $model->ppp->CONm . '</strong><br><small>' . $model->deptPpp->fullname . '</small>' .
                                        '<br><small>' . $model->gredPpp->nama . ' ' . $model->gredPpp->gred
                                        : null;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'PPK',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return
                                        $model->isPP ? null : (($model->ppk)
                                            ? '<strong>' . $model->ppk->CONm . '</strong><br><small>' . $model->deptPpk->fullname . '</small>' .
                                            '<br><small>' . $model->gredPpk->nama . ' ' . $model->gredPpk->gred : null);
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'PP',
                                'headerOptions' => ['class' => 'text-center'],
                                // 'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->isPP
                                        ? '<strong>' . $model->ppp->CONm . '</strong><br><small>' . $model->deptPpp->fullname . '</small>' .
                                        '<br><small>' . $model->gredPpp->nama . ' ' . $model->gredPpp->gred
                                        : null;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'STATUS BORANG',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    if ($model->is_deleted) {
                                        return '<span class="label label-danger">Deleted</span>';
                                    }
                                    return ($model->statusPenilaian) ? '<span class="label label-success">Selesai</span>' : '<span class="label label-warning">Sedang berjalan</span>';
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'MARKAH (100)',
                                'headerOptions' => ['class' => 'text-center  col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return ($model->isPP) ? $model->totalMarkahPPP : (($model->totalMarkahPPP + $model->totalMarkahPPK) / 2);
                                },
                                'format' => 'html',
                            ],
                            // [
                            //     'label' => 'PENILAIAN SELESAI',
                            //     'headerOptions' => ['class' => 'text-center  col-md-1'],
                            //     'contentOptions' => ['class' => 'text-center'],
                            //     'value' => function ($model) {

                            //         if ($model->is_deleted) {
                            //             return '<strong>Deleted</strong>';
                            //         }

                            //         return ($model->PP_sah == 1)
                            //             ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' :
                            //             '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                            //     },
                            //     'format' => 'html',
                            // ],
                            [
                                'label' => 'CATATAN',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->catatan;
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
                                        $url = yii\helpers\Url::to(['lnpk/update-borang', 'lnpk_id' => $model->lnpk_id]);
                                        return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalBtn1']);
                                    },
                                ],
                            ]
                        ],
                    ]);
                    ?>
                </div>
                <hr>
                <p><strong>*Klik nama PYD untuk melihat borang.</strong></p>
            </div>
        </div>
    </div>
</div>