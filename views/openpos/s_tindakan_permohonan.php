<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
//use yii\grid\GridView;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\widgets\TopMenuWidget;

error_reporting(0);

/* ini utk senarai permohonan individu */
$this->title = 'Permohonan Jawatan';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=TopMenuWidget::widget(['top_menu' => [18,44,45,51], 'vars' => [
    ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]);            ?>

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
            </div>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <?php Pjax::begin(['id' => 'icno']) ?>
            <!--            <ul>
                            <li><span class="label label-primary"><i class="fa fa-check"></i></span> : Meluluskan Permohonan</li>
                            <li><span class="label label-success"><i class="fa fa-remove"></i></span> : Menolak Permohonan</li>
                            <li><span class="label label-warning"><i class="fa fa-question"></i></span> : Permohonan Perlu Perubahan</li>
                        </ul>-->
            <?php $id = Yii::$app->getRequest()->getQueryParam('id');?>
            <?php $id = Yii::$app->getRequest()->getQueryParam('id');?>            &nbsp<a href="<?= Url::to(['uploadedlist', 'id' => $send]); ?>" class="btn btn-primary btn-md rounded">
                <strong>Senarai Dokumen Dimuat Naik </strong></a>
            <div class="x_content">

                <?=
                GridView::widget([
                    'options' => [
                        'class' => 'table-responsive',
                    ],
                    'dataProvider' => $dataProvider,
//                    'rowOptions' => function ($model) {
//                        if ($model) {
//                            return ['class' => 'info'];
//                        }
//                    },
                    /*   'filterModel' => $searchModel, */ //to hide the search row
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Nama Pemohon',
                            'value' => 'kakitangan.CONm',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Jawatan Dipohon',
                            'value' => 'gredjawatan.fname',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Tarikh Mohon',
                            'attribute' => 'tarikhmohon',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Unit Ditetapkan',
                            'value' => 'unit',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
//                        [
//                            'label' => 'Status',
//                            'attribute' => 'statuskj',
//                            'format' => 'raw',
//                        ],
                        [
                            'label' => 'Status Kelulusan Perjawatan',
                            'attribute' => 'statusLabel',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
//                        [
//                            'label' => 'Tindakan',
//                            'format' => 'raw',
//                            'value' => function ($data) {
//                                return Html::button('Peraku', ['id' => 'modalButton', 'value' => Url::to(['perakuan_ketua_jabatan', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn']);
//                            },
//                        ],
                        [
                            'label' => 'Status Kelulusan Ketua Jabatan',
                            'format' => 'raw',
                            'value' => 'statuskj',
//                            'value' => function ($data) {
//
////                                var_dump($data->id);die;
//                                //ypending for approved tp bru kena simpan..belum kena hantar
//                                if ($data->status_kj == 'YPENDING') {
//                                    $checked = 'checked';
//                                    //npending utk rejected tp baru kena simpan
//                                } elseif ($data->status_kj == 'NPENDING') {
//                                    $checked1 = 'checked';
//                                } elseif ($data->status_kj == 'PPENDING') {
//                                    $checked2 = 'checked';
//                                } elseif ($data->status_kj == 'VERIFIED' || $data->status_kj == 'APPROVED') {
//                                    return $data->statuskj;
//                                } else {
////                                    return $checked4 = "";
//                                }
//                                return Html::a('<input type="radio" name="' . $data->id . '" value="y' . $data->id . '" ' . $checked . '><i class="fa fa-check"></i>') . '  ' .
//                                        Html::a('<input type="radio" name="' . $data->id . '" value="n' . $data->id . '" ' . $checked1 . '>' . '<i class="fa fa-remove"></i>') . '  ' .
//                                        Html::a('<input type="radio" name="' . $data->id . '" value="p' . $data->id . '" ' . $checked2 . '>' . '<i class="fa fa-question"></i>');
//                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Tindakan',
                            'format' => 'raw',
                            'value' => function ($data) {
//                                return Html::a('<i class="fa fa-eye">', ["openpos/tindakan_ketua_jabatan", 'id' => $data->id]);
                                return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['perakuan_ketua_jabatan', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn']) . '  ' .
                                        Html::button('', ['id' => 'modalButton', 'value' => Url::to(['tindakan_ketua_jabatan', 'id' => $data->id]), 'class' => 'fa fa-eye mapBtn']);
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
//                        [
//                            'class' => 'yii\grid\CheckboxColumn',
//                            'checkboxOptions' => function ($data) {
//                                if (($data->status == 'APPROVED' || $data->status == 'REJECTED')) {
//                                    return ['disabled' => 'disabled'];
//                                }
//                                return ['value' => $data->id, 'checked' => true];
//                            },
//                        ],
                    ],
                ]);
                ?>
                <!--
                                <div class="form-group" align="right">
                <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1'])
                ?>
                <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2'])
                ?>
                                </div>-->

            </div>
            <?php Pjax::end() ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
