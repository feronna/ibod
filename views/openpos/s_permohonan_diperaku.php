<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\export\ExportMenu;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\widgets\TopMenuWidget;

error_reporting(0);

$this->title = 'Permohonan Jawatan';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=
TopMenuWidget::widget(['top_menu' => [18, 44, 45, 51], 'vars' => [
        ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]);
?>

<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

<!--    <p>
<?= Html::a('Create Tbl Mohontest', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Permohonan Jawatan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </li>
                </ul>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
            </div>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<?php Pjax::begin(['id' => 'icno']) ?>
            <ul>
                <li><span class="label label-primary"><i class="fa fa-check"></i></span> : Meluluskan Permohonan</li>
                <li><span class="label label-success"><i class="fa fa-remove"></i></span> : Menolak Permohonan</li>
            </ul>
<?php $id = Yii::$app->getRequest()->getQueryParam('id'); ?>
            &nbsp<a href="<?= Url::to(['uploadedlist', 'id' => Yii::$app->getRequest()->getQueryParam('id')]); ?>" class="btn btn-primary btn-md rounded">
                <strong>Senarai Dokumen Dimuat Naik </strong></a>
<!--            <a href="<?= Url::to(['janasurat', 'id' => Yii::$app->getRequest()->getQueryParam('id')]); ?>" class="btn btn-primary btn-md rounded">
                <strong>Jana Surat </strong></a>-->
            &nbsp<?= Html::button('Jana Surat', ['id' => 'modalButton', 'value' => Url::to(['openpos/janasurat', 'id' => Yii::$app->getRequest()->getQueryParam('id')]), 'class' => 'btn btn-primary mapBtn']);
?>
            <a href="<?= Url::to(['openpos/report', 'id' => Yii::$app->getRequest()->getQueryParam('id')]); ?>" class="btn btn-primary btn-md rounded">
                <strong>Jana Lampiran </strong></a>

            <!--            <?= Html::a('<i class="fa fa-print"></i> Cetak Laporan', ['kehadiran/report', 'id' => $icno, 'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                        <div class="x_content">-->

            <?=
            GridView::widget([
                'options' => [
                    'class' => 'table-responsive',
                ],
                'dataProvider' => $dataProvider,
//                    'filterModel' => $searchModel, 
                //to hide the search row
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//        [
//            'label' => 'Nama Pemohon',
//            'value' => 'kakitangan.CONm',
//        ],
                    [
                        'label' => 'Jawatan Dipohon',
                        'attribute' => 'jawatan_dipohon',
                        'value' => 'gredjawatan.fname',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'J/F/P/I/U',
                        'attribute' => 'dept_id',
                        'value' => 'dept.shortname',
                    ],
                    [
                        'label' => 'Tarikh Mohon',
                        'attribute' => 'tarikhmohon',
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Unit Ditetapkan',
                        'value' => 'unit',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Status Ketua Jabatan',
                        'attribute' => 'statuskj',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Status Kelulusan Perjawatan',
                        'format' => 'raw',
                        'value' => function ($data) {

//                                var_dump($data->id);die;
                            //ypending for approved tp bru kena simpan..belum kena hantar
                            if ($data->status == 'YPENDING') {
                                $checked = 'checked';
                                //npending utk rejected tp baru kena simpan
                            } elseif ($data->status == 'NPENDING') {
                                $checked1 = 'checked';
                            } elseif ($data->status == 'VERIFIED' || $data->status == 'REJECTED') {
                                return $data->statusLabel;
                            }
                            return Html::a('<input type="radio" name="' . $data->id . '" value="y' . $data->id . '" ' . $checked . '><i class="fa fa-check"></i>') . '  ' .
                                    Html::a('<input type="radio" name="' . $data->id . '" value="n' . $data->id . '" ' . $checked1 . '>' . '<i class="fa fa-remove"></i>');
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Tindakan',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['perakuan_pegawai_perjawatan', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn']) . '' .
                                    Html::button('', ['id' => 'modalButton', 'value' => Url::to(['openpos/tindakan_pegawai_perjawatan', 'id' => $data->id]), 'class' => 'fa fa-eye mapBtn']);
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
//                        [
//                            'label' => 'View',
//                            'format' => 'raw',
//                            'value' => function ($data) {
//
//                                return Html::a('<i class="fa fa-eye">', ["openpos/tindakan_pegawai_perjawatan", 'id' => $data->id]);
//                            },
//                        ],
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($data) {
                            if (($data->status == 'VERIFIED' || $data->status == 'REJECTED')) {
                                return ['disabled' => 'disabled'];
                            }
                            return ['value' => $data->id, 'checked' => true];
                        },
                    ],
                ],
            ]);
            ?>

            <div class="form-group" align="right">
                <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1'])
                ?>
<?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2'])
?>
            </div>

        </div>
<?php Pjax::end() ?>
<?php ActiveForm::end(); ?>
    </div>
</div>
</div>


