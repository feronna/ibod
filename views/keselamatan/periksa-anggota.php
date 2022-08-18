<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use app\models\cuti\CutiRekod;
use app\widgets\TopMenuWidget;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\web\View;
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<?php Pjax::begin(['id' => 'icno']) ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <h2><strong><?php
                    echo $syif->details;
                    ?><br> <br> Tarikh : <?php echo $dt; ?>
 <br><br> Penyelia Bertugas : <?php if(!$do_bertugas){
                                                echo "Belum Di Set Dalam Jadual (Tindakan Admin)"; 
                    }else{
                        echo $do_bertugas->staff->CONm; 
                        }?>            </strong></h2>
        <!--. "(" . date('l') . ")"-->
        <ul>
            <li><i class="fa fa-check-square"> Hadir</i> : Tanda <i class="fa fa-check-square"></i> sekiranya Hadir Hakiki dan Hadir Baris </li>
            <li><i class="fa fa-check-square"> Melakukan Kesalahan</i> : Tanda <i class="fa fa-check-square"></i> sekiranya Melakukan Kesalahan </li>

        </ul>
        <div class="ln_solid"></div>

        <div class="x_title">


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
                                $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                                if ($validation) {
                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                    //                                \yii\helpers\VarDumper::dump($validate,$depth = 10,$highlight = true);die;
                                    if ($validate->THBH == 0) {
                                        $checked1 = 'checked disabled';
                                        //                                //npending utk rejected tp baru kena simpan
                                    } else {
                                        $checked1 = 'disabled';
                                    }
                                } else {
                                    $checked1 = '';
                                }

                                return Html::a('<input type="checkbox" name="' . $data->icno . '" value="yy' . $data->icno . '" ' . $checked1 . '>');
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Tidak Hadir Baris Hakiki',
                            'format' => 'raw',
                            'value' => function ($data) {
                                $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                                if ($validation) {
                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->one();
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

                                $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                if (!$validate) {
                                    return Html::a('');
                                } else {
                                    return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['update-kesalahan', 'id' => $validate->id,'type'=>'1']), 'class' => 'fa fa-edit mapBtn']);
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

                                $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                if (!$validate) {
                                    return Html::a('');
                                } else {
                                    return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['pembetulan-rollcall', 'id' => $validate->id, 'date' => date('Y-m-d'), 'type' => '1']), 'class' => 'fa fa-edit mapBtn']);
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
                            'label' => 'LM',
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

                                $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                                if ($validation) {
                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                    if ($validate->THBLMJ == 0) {
                                        $checked1 = 'checked disabled';
                                        //                                //npending utk rejected tp baru kena simpan
                                    } else {
                                        $checked1 = 'disabled';
                                    }
                                } else {
                                    $checked1 = '';
                                }

                                return Html::a('<input type="checkbox" name="' . $data->icno . '" value="zz' . $data->icno . '" ' . $checked1 . '>');
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Tidak Hadir Baris Kerja Lebih Masa',
                            'format' => 'raw',
                            'value' => function ($data) {
                                $syif = \app\models\keselamatan\RefShifts::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                                if ($validation) {
                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->one();
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

                                $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                if (!$validate) {
                                    return Html::a('');
                                } else {
                                    return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['update-kesalahan', 'id' => $validate->id,'type'=>'2']), 'class' => 'fa fa-edit mapBtn']);
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

                                $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                if (!$validate) {
                                    return Html::a('');
                                } else {
                                    return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['pembetulan-rollcall-lmj', 'id' => $validate->id, 'date' => date('Y-m-d'), 'type' => '1']), 'class' => 'fa fa-edit mapBtn']);
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

                                $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                                if ($validation) {
                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                    if ($validate->THBLMT == 0) {
                                        $checked1 = 'checked disabled';
                                        //                                //npending utk rejected tp baru kena simpan
                                    } else {
                                        $checked1 = 'disabled';
                                    }
                                } else {
                                    $checked1 = '';
                                }

                                return Html::a('<input type="checkbox" name="' . $data->icno . '" value="lmt' . $data->icno . '" ' . $checked1 . '>');
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Tidak Hadir Baris Kerja Lebih Masa Tambahan',
                            'format' => 'raw',
                            'value' => function ($data) {
                                $syif = \app\models\keselamatan\RefLmt::find()->where(['id' => Yii::$app->getRequest()->getQueryParam('id')])->one();

                                $validation = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                                if ($validation) {
                                    $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->one();
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

                                $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                if (!$validate) {
                                    return Html::a('');
                                } else {
                                    return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['update-kesalahan', 'id' => $validate->id,'type'=>'3']), 'class' => 'fa fa-edit mapBtn']);
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

                                $validate = app\models\keselamatan\TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMT'])->andWhere(['syif' => $syif->jenis_shifts])->one();
                                if (!$validate) {
                                    return Html::a('');
                                } else {
                                    return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['pembetulan-rollcall-lmt', 'id' => $validate->id, 'date' => date('Y-m-d'), 'type' => '1']), 'class' => 'fa fa-edit mapBtn']);
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
<?php
$script = <<< JS
    
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