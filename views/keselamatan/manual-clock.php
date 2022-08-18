<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use dosamigos\datepicker\DatePicker;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use app\models\cuti\CutiRekod;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\web\View;
?>

<?= $this->render('/keselamatan/_topmenu') ?>

<!--<div class="col-md-12"> -->

<div class="x_panel">
    <div class="x_title">
        <h2><strong>Pilih Tarikh Syif Dan Syif (A,B,C)</h2>
        <div class="clearfix"></div>
    </div>
    <?php Yii::$app->session->setFlash('info', 'Sila Masukkan Kehadiran Anggota Secara Manual Di Sini.'); ?>

    <div class="x_content">

        <?= Html::beginForm(['manual-clock'], 'GET'); ?>


        <?php
        echo '<label class="control-label">Tarikh syif</label>';
        echo DatePicker::widget([
            'name' => 'date',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'removeIcon' => '<i class="fa fa-trash text-danger"></i>',
            'value' => '',
            'readonly' => true,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
        ?>
        <br>
        <?= Html::dropDownList('id', $id, ['3' => 'Syif A', '5' => 'Syif B', '4' => 'Syif C'], ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>

        <br>
        <br>
        <br>
        <br>
        <div class="form-group" align="right">

            <button class="btn btn-primary" type="reset">Set Semula</button>
            <?= Html::submitButton('<i class="fa fa-plane"></i> Hantar', ['class' => 'btn btn-primary']); ?>
            <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
            <?= Html::endForm(); ?>
        </div>

    </div>


</div>

<?php if ($var != null) { ?>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
    <?php Pjax::begin(['id' => 'icno']) ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <strong>Syif: <?php
                                echo $shift->details;
                                ?>
                    <br><br> Tarikh : <?php echo Yii::$app->getRequest()->getQueryParam('date'); ?>
                    <br><br> Pengawai Bertugas : <?php if ($i == false) {
                                                        echo "Belum Di Set Dalam Jadual (Tindakan Admin)";
                                                    } else {
                                                        echo $v;
                                                    } ?>
                    <br><br> Pengganti Pengawai Bertugas :<?php  if ($p_do != NULL) {
                                                        echo Html::a('<input type="text" name="namado" value="' . $p_do . '"  disabled >');
                                                    } else {
                                                        echo Html::a('<input type="text" name="namado" value="" >');
                                                    }
                                                    ?>

                    
                </strong>

            <ul>
                <li><i class="fa fa-check-square"> Hadir</i> : Tanda <i class="fa fa-check-square"></i> sekiranya Hadir Hakiki dan Hadir Baris </li>
                <li><i class="fa fa-check-square"> Melakukan Kesalahan</i> : Tanda <i class="fa fa-check-square"></i> sekiranya Melakukan Kesalahan </li>

            </ul>
            <?= Html::button('Odometer', ['id' => 'modalButton', 'value' => Url::to(['odometer']), 'class' => 'btn btn-info mapBtn']);
            ?>
            <?= Html::button('Ulasan Harian(DO)', ['id' => 'modalButton', 'value' => Url::to(['laporan-kejadian']), 'class' => 'btn btn-info mapBtn']);
            ?>
            <div class="ln_solid"></div>

            <div class="x_title">

                <button type="button" class="checkall btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Select All</button>

                <!--// Control your pjax options-->
                <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => [
                            'class' => 'table-responsive',
                        ],

                        /*   'filterModel' => $searchModel, */ //to hide the search row
                        'columns' => [
                            ['class' => 'kartik\grid\SerialColumn'],
                            [
                                'label' => 'Action Taken',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->andWhere(['!=', 'status', 'SIMPAN'])->one();
                                    if ($validate) {
                                        $checked1 = 'checked disabled';
                                    } else {
                                        $checked1 = 'disabled';
                                    }
                                    return Html::a('<input type="checkbox" ' . $checked1 . ' >');
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Nama',
                                'value' => 'staff.CONm',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',

                            ],
                            [
                                'label' => 'Unit',
                                'value' => 'unitname.unit_name',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'Hakiki',
                                'value' => 'syif.jenis_shifts',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'Pos Kawalan',
                                'value' => 'pos.pos_kawalan',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            //                  
                            [
                                'label' => 'Hadir Baris Hakiki',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                                    if ($validation) {
                                        $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                        if ($validate->THBH == 0) {
                                            $checked1 = 'checked disabled';
                                            //                                //npending utk rejected tp baru kena simpan
                                        } else {
                                            $checked1 = 'disabled';
                                        }
                                    } else {
                                        $checked1 = '';
                                    }

                                    return Html::a('<input type="checkbox" class = "checkId" name="' . $data->icno . '" value="yy' . $data->icno . '" ' . $checked1 . ' >');
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],

                            ],
                            [
                                'label' => 'Tidak Hadir Baris Hakiki',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                                    if ($validation) {
                                        $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                        if ($validate->THBH == 1) {
                                            $checked1 = 'checked disabled';
                                            //                                //npending utk rejected tp baru kena simpan
                                        } else {
                                            $checked1 = 'disabled';
                                        }
                                    } else {
                                        $checked1 = '';
                                    }

                                    return Html::a('<input type="checkbox" name="' . $data->icno . '" value="y' . $data->icno . '" ' . $checked1 . '>');
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            //                    [
                            //                        'label' => 'Surat Tunjuk Sebab',
                            //                        'format' => 'raw',
                            //                        'value' => function ($data) {
                            //                            return Html::a('<i class="fa fa-eye">', ["keselamatan/sts", 'id' => Yii::$app->getRequest()->getQueryParam('id')]);
                            //                        },
                            //                        'headerOptions' => ['class' => 'text-center'],
                            //                        'contentOptions' => ['class' => 'text-center'],
                            //                    ],
                            [
                                'label' => 'Tindakan STS',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                    if (!$validate) {
                                        return Html::a('');
                                    } else {
                                        return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['update-kesalahan-manual', 'id' => $validate->id, 'date' => Yii::$app->getRequest()->getQueryParam('date'), 'type' => 1]), 'class' => 'fa fa-edit mapBtn']);
                                    }
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Pembetulan Kehadiran',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'H'])->one();
                                    if (!$validate) {
                                        return Html::a('');
                                    } else {
                                        return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['pembetulan-rollcall', 'id' => $validate->id, 'date' => Yii::$app->getRequest()->getQueryParam('date'), 'type' => '2']), 'class' => 'fa fa-edit mapBtn']);
                                    }
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            // [
                            //     'label' => 'Tindakan Lisan/Bertulis',
                            //     'format' => 'raw',
                            //     'value' => function ($data) {
                            //         $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                            //         $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'H'])->one();
                            //         if (!$validate) {
                            //             return Html::a('');
                            //         } else {
                            //             return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['tindakan-bertulis', 'id' => $validate->id,'date'=>Yii::$app->getRequest()->getQueryParam('date'),'shift'=>Yii::$app->getRequest()->getQueryParam('id')]), 'class' => 'fa fa-edit mapBtn']);
                            //         }
                            //     },
                            //     'headerOptions' => ['class' => 'text-center'],
                            //     'contentOptions' => ['class' => 'text-center'],
                            // ],
                        ],
                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                        'resizableColumns' => true,
                        'responsive' => false,
                        'responsiveWrap' => false,
                        'hover' => true,
                        'floatHeader' => true,
                        'floatHeaderOptions' => [
                            'position' => 'absolute',
                        ],
                    ]);
                ?>

                <?=
                    GridView::widget([
                        'dataProvider' => $dataProviders,
                        'options' => [
                            'class' => 'table-responsive',
                        ],
                        /*   'filterModel' => $searchModel, */ //to hide the search row
                        'columns' => [
                            ['class' => 'kartik\grid\SerialColumn'],
                            [
                                'label' => 'Action Taken',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->andWhere(['!=', 'status', 'SIMPAN'])->one();
                                    if ($validate) {
                                        $checked1 = 'checked disabled';
                                    } else {
                                        $checked1 = 'disabled';
                                    }
                                    return Html::a('<input type="checkbox" ' . $checked1 . ' >');
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Nama',
                                'value' => 'staff.CONm',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'Unit',
                                'value' => 'unitname.unit_name',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'LMJ',
                                'value' => 'syif.jenis_shifts',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'Pos Kawalan',
                                'value' => 'pos.pos_kawalan',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'Hadir Baris Kerja Lebih Masa',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                                    if ($validation) {
                                        $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                        if ($validate->THBLMJ == 0) {
                                            $checked1 = 'checked disabled';
                                            //                                //npending utk rejected tp baru kena simpan
                                        } else {
                                            $checked1 = 'disabled';
                                        }
                                    } else {
                                        $checked1 = '';
                                    }

                                    return Html::a('<input type="checkbox" class = "checkId" name="' . $data->icno . '" value="zz' . $data->icno . '" ' . $checked1 . '>');
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Tidak Hadir Baris Kerja Lebih Masa',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                                    if ($validation) {
                                        $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                        if ($validate->THBLMJ == 1) {
                                            $checked1 = 'checked disabled';
                                            //                                //npending utk rejected tp baru kena simpan
                                        } else {
                                            $checked1 = 'disabled';
                                        }
                                    } else {
                                        $checked1 = '';
                                    }

                                    return Html::a('<input type="checkbox" name="' . $data->icno . '" value="z' . $data->icno . '" ' . $checked1 . '>');
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Tindakan STS',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                    if (!$validate) {
                                        return Html::a('');
                                    } else {
                                        return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['update-kesalahan-manual', 'id' => $validate->id, 'date' => Yii::$app->getRequest()->getQueryParam('date'), 'type' => '2']), 'class' => 'fa fa-edit mapBtn']);
                                    }
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Pembetulan Kehadiran',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                    if (!$validate) {
                                        return Html::a('');
                                    } else {
                                        return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['pembetulan-rollcall-lmj', 'id' => $validate->id, 'date' => Yii::$app->getRequest()->getQueryParam('date'), 'type' => '2']), 'class' => 'fa fa-edit mapBtn']);
                                    }
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                        ],
                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                        'resizableColumns' => true,
                        'responsive' => false,
                        'responsiveWrap' => false,
                        'hover' => true,
                        'floatHeader' => true,
                        'floatHeaderOptions' => [
                            'position' => 'absolute',
                        ],
                    ]);
                ?>

                <?=
                    GridView::widget([
                        'dataProvider' => $dataProviderslmt,
                        'options' => [
                            'class' => 'table-responsive',
                        ],
                        /*   'filterModel' => $searchModel, */ //to hide the search row
                        'columns' => [
                            ['class' => 'kartik\grid\SerialColumn'],
                            [
                                'label' => 'Action Taken',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefLmt::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->andWhere(['!=', 'status', 'SIMPAN'])->one();
                                    if ($validate) {
                                        $checked1 = 'checked disabled';
                                    } else {
                                        $checked1 = 'disabled';
                                    }
                                    return Html::a('<input type="checkbox" ' . $checked1 . ' >');
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Nama',
                                'value' => 'staff.CONm',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'Unit',
                                'value' => 'unitname.unit_name',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'LMT',
                                'value' => 'syif.jenis_shifts',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'Pos Kawalan',
                                'value' => 'pos.pos_kawalan',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'Hadir Baris Kerja Lebih Masa Tambahan',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefLmt::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                                    if ($validation) {
                                        $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                        if ($validate->THBLMT == 0) {
                                            $checked1 = 'checked disabled';
                                            //                                //npending utk rejected tp baru kena simpan
                                        } else {
                                            $checked1 = 'disabled';
                                        }
                                    } else {
                                        $checked1 = '';
                                    }

                                    return Html::a('<input type="checkbox" class = "checkId" name="' . $data->icno . '" value="lmt' . $data->icno . '" ' . $checked1 . '>');
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Tidak Hadir Baris Kerja Lebih Masa Tambahan',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefLmt::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                                    if ($validation) {
                                        $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                        if ($validate->THBLMT == 1) {
                                            $checked1 = 'checked disabled';
                                            //                                //npending utk rejected tp baru kena simpan
                                        } else {
                                            $checked1 = 'disabled';
                                        }
                                    } else {
                                        $checked1 = '';
                                    }

                                    return Html::a('<input type="checkbox" name="' . $data->icno . '" value="lmts' . $data->icno . '" ' . $checked1 . '>');
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Tindakan STS',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefLmt::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                    if (!$validate) {
                                        return Html::a('');
                                    } else {
                                        return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['update-kesalahan-manual', 'id' => $validate->id, 'date' => Yii::$app->getRequest()->getQueryParam('date'), 'type' => 3]), 'class' => 'fa fa-edit mapBtn']);
                                    }
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Pembetulan Kehadiran',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $syif = \app\models\keselamatan\RefLmt::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => Yii::$app->getRequest()->getQueryParam('date')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                    if (!$validate) {
                                        return Html::a('');
                                    } else {
                                        return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['pembetulan-rollcall-lmt', 'id' => $validate->id, 'date' => Yii::$app->getRequest()->getQueryParam('date'), 'type' => '2']), 'class' => 'fa fa-edit mapBtn']);
                                    }
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                        ],
                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                        'resizableColumns' => true,
                        'responsive' => false,
                        'responsiveWrap' => false,
                        'hover' => true,
                        'floatHeader' => true,
                        'floatHeaderOptions' => [
                            'position' => 'absolute',
                        ],
                    ]);
                ?>

                <div class="form-group" align="right">
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait.. ']])
                    ?>

                </div>
            </div>
            <?php Pjax::end() ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php } ?>
<!--</div>-->

<?php
$script = <<< JS
        
       $(document).ready(function () {
        
        var clicked = false;
        $(".checkall").on("click", function() {
          $(".checkId").prop("checked", !clicked);
          clicked = !clicked;
        });

    });
    $(window).scroll(function() {
  sessionStorage.scrollTop = $(this).scrollTop();
});

$(document).ready(function() {
  if (sessionStorage.scrollTop != "undefined") {
    $(window).scrollTop(sessionStorage.scrollTop);
  }
});
JS;
$this->registerJs($script, View::POS_END);
?>