<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\popover\PopoverX;

date_default_timezone_set("Asia/Kuala_Lumpur");
if ($title == 'Menunggu Kutipan') {
    $head = 'Menunggu Pengambilan';
} else {
    $head = $title;
}
?>
<?= $this->render('menu') ?> 
<div class="x_panel">
    <div class="x_title">
        <h2>Permohonan <?= $head; ?></h2> <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?></p>
        <div class="clearfix"></div>
    </div> 
    <div class="x_content"> 
        <?php if ($title == 'Menunggu Bayaran Kaunter' || $title == 'Menunggu Kutipan') { ?>
            <div class="table-responsive col-md-6 col-sm-6 col-xs-6">
                <?=
                DetailView::widget([
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'model' => $pelekat,
                    'attributes' => [
                        [
                            'attribute' => 'user.biodata.ICNO',
                            'contentOptions' => ['style' => 'width:30%'],
                            'captionOptions' => ['style' => 'width:15%'],
                        ],
                        'user.biodata.COOldID',
                        [
                            'attribute' => 'user.biodata.CONm',
                            'value' => function($model) {
                                return ucwords(strtolower($model->user->biodata->CONm));
                            },
                        ],
                        [
                            'attribute' => 'kenderaan.reg_number',
                            'value' => function($model) {
                                $words = str_replace(' ', '', strtolower($model->kenderaan->reg_number));
                                return strtoupper($words);
                            },
                        ],
                        [
                            'attribute' => 'status_mohon',
                            'value' => function($model) {
                                return ucwords(strtolower($model->status_mohon));
                            },
                        ],
                        [
                            'attribute' => 'mohon_date',
                            'value' => function($model) {
                                return $model->user->biodata->getTarikh($model->mohon_date) . '  ' . date("H:i:s", strtotime($model->mohon_date));
                            },
                        ],
                        'user.biodata.COHPhoneNo',
                        'user.biodata.COEmail',
                        [
                            'attribute' => 'kenderaan.veh_owner',
                            'value' => function($model) {
                                return ucwords(strtolower($model->kenderaan->veh_owner));
                            },
                            'contentOptions' => ['style' => 'width:30%'],
                            'captionOptions' => ['style' => 'width:15%'],
                        ],
                        [
                            'attribute' => 'kenderaan.veh_user',
                            'value' => function($model) {
                                return ucwords(strtolower($model->kenderaan->veh_user));
                            },
                        ],
                        [
                            'attribute' => 'kenderaan.rel_owner_user',
                            'value' => function($model) {
                                return ucwords(strtolower($model->kenderaan->rel_owner_user));
                            },
                        ],
                        [
                            'attribute' => 'kenderaan.veh_color',
                            'value' => function($model) {
                                return ucwords(strtolower($model->kenderaan->veh_color));
                            },
                        ],
                    ],
                ])
                ?>
            </div>
            <div class="table-responsive col-md-6 col-sm-6 col-xs-6">
                <?=
                DetailView::widget([
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'model' => $pelekat,
                    'attributes' => [

                        [
                            'attribute' => 'kenderaan.jeniskenderaan.Keterangan',
                            'value' => function($model) {
                                return ucwords(strtolower($model->kenderaan->jeniskenderaan->Keterangan));
                            },
                        ],
                        [
                            'attribute' => 'kenderaan.veh_brand',
                            'value' => function($model) {
                                return ucwords(strtolower($model->kenderaan->jenama->KETERANGAN));
                            },
                        ],
                        [
                            'attribute' => 'kenderaan.veh_model',
                            'value' => function($model) {
                                return ucwords(strtolower($model->kenderaan->veh_model));
                            },
                        ],
                        'kenderaan.roadtax_no',
                        [
                            'label' => 'Tarikh Tamat Roadtax',
                            'value' => function($model) {
                                return $model->user->biodata->getTarikh($model->kenderaan->roadtax_exp);
                            },
                        ],
                        [
                            'label' => 'No. lesen',
                            'value' => function($model) {
//                                                if ($model->kenderaan->lesen_id) {
//                                                    return $model->user->biodata->getTarikh($model->kenderaan->lesen($model->kenderaan->lesen_id));
//                                                } else {
//                                                    return;
//                                                } 
                                return $model->kenderaan->lesen_no ? $model->kenderaan->lesen_no : 'Tiada Maklumat';
                            },
                        ],
                        [
                            'label' => 'Fail Lesen',
                            'value' => function($model) {
                                $lesen = $model->kenderaan->getLesen($model->kenderaan->lesen_id);

//                                if (!empty($lesen->filename) && $lesen->filename != 'deleted') {
//                                    return html::a(Yii::$app->FileManager->NameFile($lesen->filename), Yii::$app->FileManager->DisplayFile($lesen->filename), ['target' => '_blank']);
//                                }
                                return 'Tiada Maklumat';
                            },
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'kenderaan.filename_grant',
                                    'value' => function($model) {
//                                        if (!empty($model->kenderaan->filename_grant) && $model->kenderaan->filename_grant != 'deleted') {
//                                            return html::a(Yii::$app->FileManager->NameFile($model->kenderaan->filename_grant), Yii::$app->FileManager->DisplayFile($model->kenderaan->filename_grant), ['target' => '_blank']);
//                                        }
                                        return 'Tiada Maklumat';
                                    },
                                            'format' => 'raw',
                                        ],
                                        [
                                            'attribute' => 'kenderaan.catatan_modifikasi',
                                            'value' => function($model) {
                                                return $model->kenderaan->catatan_modifikasi ? $model->kenderaan->catatan_modifikasi : 'Tiada Maklumat';
                                            },
                                        ],
                                        [
                                            'attribute' => 'kenderaan.filename_veh_front',
                                            'value' => function($model) {
//                                                if (!empty($model->kenderaan->filename_veh_front) && $model->kenderaan->filename_veh_front != 'deleted') {
//                                                    return html::a(Yii::$app->FileManager->NameFile($model->kenderaan->filename_veh_front), Yii::$app->FileManager->DisplayFile($model->kenderaan->filename_veh_front), ['target' => '_blank']);
//                                                }
                                                return 'Tiada Maklumat';
                                            },
                                                    'format' => 'raw',
                                                ],
                                                [
                                                    'attribute' => 'kenderaan.filename_veh_side',
                                                    'value' => function($model) {
//                                                        if (!empty($model->kenderaan->filename_veh_side) && $model->kenderaan->filename_veh_side != 'deleted') {
//                                                            return html::a(Yii::$app->FileManager->NameFile($model->kenderaan->filename_veh_side), Yii::$app->FileManager->DisplayFile($model->kenderaan->filename_veh_side), ['target' => '_blank']);
//                                                        }
                                                        return 'Tiada Maklumat';
                                                    },
                                                            'format' => 'raw',
                                                        ],
                                                        [
                                                            'attribute' => 'kenderaan.filename_veh_rear',
                                                            'value' => function($model) {
//                                                                if (!empty($model->kenderaan->filename_veh_rear) && $model->kenderaan->filename_veh_rear != 'deleted') {
//                                                                    return html::a(Yii::$app->FileManager->NameFile($model->kenderaan->filename_veh_rear), Yii::$app->FileManager->DisplayFile($model->kenderaan->filename_veh_rear), ['target' => '_blank']);
//                                                                }
                                                                return 'Tiada Maklumat';
                                                            },
                                                                    'format' => 'raw',
                                                                ],
//                        [
//                            'attribute' => 'status_kenderaan',
//                            'value' => function($model) {
//                                return ucwords(strtolower($model->status_kenderaan));
//                            },
//                        ],
                                                            ],
                                                        ])
                                                        ?>
                                                    </div>

                                                <?php } elseif ($title == 'Selesai') { ?>
                                                    <div class="table-responsive col-md-6 col-sm-6 col-xs-6">
                                                        <?=
                                                        DetailView::widget([
                                                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                                            'model' => $pelekat,
                                                            'attributes' => [
                                                                [
                                                                    'attribute' => 'user.biodata.ICNO',
                                                                    'contentOptions' => ['style' => 'width:30%'],
                                                                    'captionOptions' => ['style' => 'width:15%'],
                                                                ],
                                                                [
                                                                    'attribute' => 'user.biodata.CONm',
                                                                    'value' => function($model) {
                                                                        return ucwords(strtolower($model->user->biodata->CONm));
                                                                    },
                                                                ],
                                                                [
                                                                    'label' => 'No. Kereta',
                                                                    'value' => function($model) {
                                                                        $words = str_replace(' ', '', strtolower($model->kenderaan->reg_number));
                                                                        return strtoupper($words);
                                                                    },
                                                                ],
                                                                [
                                                                    'attribute' => 'mohon_date',
                                                                    'value' => function($model) {
                                                                        return $model->user->biodata->getTarikh($model->mohon_date) . '  ' . date("H:i:s", strtotime($model->mohon_date));
                                                                    },
                                                                ],
                                                                'user.biodata.COOldID',
                                                                'user.biodata.COHPhoneNo',
                                                                'user.biodata.COEmail',
                                                                [
                                                                    'attribute' => 'status_mohon',
                                                                    'value' => function($model) {
                                                                        return ucwords(strtolower($model->status_mohon));
                                                                    },
                                                                ],
                                                                [
                                                                    'attribute' => 'status_kenderaan',
                                                                    'value' => function($model) {
                                                                        return ucwords(strtolower($model->kenderaan->status_kenderaan));
                                                                    },
                                                                ],
                                                            ],
                                                        ])
                                                        ?>
                                                    </div>
                                                    <div class="table-responsive col-md-6 col-sm-6 col-xs-6">
                                                        <?=
                                                        DetailView::widget([
                                                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                                            'model' => $pelekat,
                                                            'attributes' => [

                                                                [
                                                                    'label' => 'Pemilik kenderaan',
                                                                    'value' => function($model) {
                                                                        return ucwords(strtolower($model->kenderaan->veh_owner));
                                                                    },
                                                                    'contentOptions' => ['style' => 'width:30%'],
                                                                    'captionOptions' => ['style' => 'width:15%'],
                                                                ],
                                                                [
                                                                    'label' => 'Pengguna kenderaan',
                                                                    'value' => function($model) {
                                                                        return ucwords(strtolower($model->kenderaan->veh_user));
                                                                    },
                                                                ],
                                                                [
                                                                    'label' => 'Hubungan',
                                                                    'value' => function($model) {
                                                                        return ucwords(strtolower($model->kenderaan->rel_owner_user));
                                                                    },
                                                                ],
                                                                [
                                                                    'label' => 'Warna Kenderaan',
                                                                    'value' => function($model) {
                                                                        return ucwords(strtolower($model->kenderaan->veh_color));
                                                                    },
                                                                ],
                                                                [
                                                                    'attribute' => 'kenderaan.jeniskenderaan.Keterangan',
                                                                    'value' => function($model) {
                                                                        return ucwords(strtolower($model->kenderaan->jeniskenderaan->Keterangan));
                                                                    },
                                                                ],
                                                                [
                                                                    'label' => 'Jenama kenderaan',
                                                                    'value' => function($model) {
                                                                        return ucwords(strtolower($model->kenderaan->jenama->KETERANGAN));
                                                                    },
                                                                ],
                                                                [
                                                                    'label' => 'Model kenderaan',
                                                                    'value' => function($model) {
                                                                        return ucwords(strtolower($model->kenderaan->veh_model));
                                                                    },
                                                                ],
                                                                'kenderaan.roadtax_no',
                                                                [
                                                                    'label' => 'Tarikh Tamat Roadtax',
                                                                    'value' => function($model) {
                                                                        return $model->user->biodata->getTarikh($model->kenderaan->roadtax_exp);
                                                                    },
                                                                ],
                                                            ],
                                                        ])
                                                        ?>
                                                    </div>     
                                                <?php } ?>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <?=
                                                    DetailView::widget([
                                                        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                                        'model' => $pelekat,
                                                        'attributes' => [
                                                            [
                                                                'label' => 'Wakil No. Kp',
                                                                'value' => function($model) {
                                                                    return $model->wakil_ICNO ? $model->wakil_ICNO : '-';
                                                                },
                                                                'contentOptions' => ['style' => 'width:30%'],
                                                                'captionOptions' => ['style' => 'width:15%'],
                                                            ],
                                                            [
                                                                'label' => 'Wakil Nama',
                                                                'value' => function($model) {
                                                                    return strtoupper($model->wakil_nama ? $model->wakil_nama : '-');
                                                                },
                                                            ],
                                                            [
                                                                'label' => 'Tarikh/Masa pengambilan',
                                                                'value' => function($model) {
                                                                    return $model->wakil_masa_ambil ? $model->wakil_masa_ambil : '-';
                                                                },
                                                            ],
                                                        ],
                                                    ])
                                                    ?>
                                                    <?php if ($title == 'Selesai') { ?>
                                                        <?=
                                                        DetailView::widget([
                                                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                                            'model' => $pelekat,
                                                            'attributes' => [
                                                                [
                                                                    'label' => 'Pengemaskini',
                                                                    'value' => function($model) {
                                                                        if ($model->updater) {
                                                                            return $model->updater . ' - ' . ucwords(strtolower($model->biodata->CONm));
                                                                        } else {
                                                                            return '';
                                                                        }
                                                                    },
                                                                ],
                                                                [
                                                                    'label' => 'Tarikh Diluluskan',
                                                                    'value' => function($model) {
                                                                        return $model->user->biodata->getTarikh(date('Y-m-d', strtotime($model->app_datetime)));
                                                                    },
                                                                    'contentOptions' => ['style' => 'width:30%'],
                                                                    'captionOptions' => ['style' => 'width:15%'],
                                                                ],
                                                            ],
                                                        ]);
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <?php if ($title == 'Menunggu Bayaran Kaunter' || $title == 'Menunggu Kutipan') { ?>

                                                        <?php
                                                        $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]);
                                                        if ($title == 'Menunggu Bayaran Kaunter') {
                                                            ?> 

                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Harga (RM): <span class="required" style="color:red;">*</span>
                                                                </label>
                                                                <div class="col-md-4 col-sm-4 col-xs-12">    
                                                                    <?= $form->field($model, 'total')->textInput(['value' => $pelekat->total, 'disabled' => true])->label(false); ?>  
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                        <div class="form-group">
                                                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Tempoh Pelekat: <span class="required" style="color:red;">*</span>
                                                            </label>
                                                            <div class="col-md-4 col-sm-4 col-xs-12">    
                                                                <?php
                                                                echo DatePicker::widget([
                                                                    'model' => $model,
                                                                    'attribute' => 'mula',
                                                                    'template' => '{input}{addon}',
                                                                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => 'true'],
                                                                    'clientOptions' => [
                                                                        'autoclose' => true,
                                                                        'format' => 'yyyy-mm-dd',
                                                                    ]
                                                                ]);
                                                                ?>  
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-12">  
                                                                <?php
                                                                echo DatePicker::widget([
                                                                    'model' => $model,
                                                                    'attribute' => 'tamat',
                                                                    'template' => '{input}{addon}',
                                                                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => 'true'],
                                                                    'clientOptions' => [
                                                                        'autoclose' => true,
                                                                        'format' => 'yyyy-mm-dd'
                                                                    ]
                                                                ]);
                                                                ?> 
                                                            </div>
                                                        </div> 

                                                        <div class="form-group">
                                                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="NoLese">No. Siri:  
                                                                <span class="required" style="color:red;">*</span>
                                                            </label>
                                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                                <?= $form->field($model, 'kod_siri')->textInput(['disabled' => true])->label(false); ?>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                <?= $form->field($model, 'siri')->textInput(['maxlength' => true])->label(false); ?>
                                                            </div> 
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-md-4 col-sm-4 col-xs-12">No. Resit: <span class="required" style="color:red;">*</span>
                                                            </label>
                                                            <div class="col-md-4 col-sm-4 col-xs-12">    
                                                                <?= $form->field($model, 'no_resit')->textInput()->label(false); ?>  
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Status Percuma:  
                                                            </label>
                                                            <div class="col-md-4 col-sm-4 col-xs-12">    
                                                                <?=
                                                                $form->field($model, 'free')->checkbox(array(
                                                                    'label' => '',
                                                                    'labelOptions' => array('style' => 'padding:5px;'),
                                                                ))->label(false);
                                                                ?>  
                                                            </div>
                                                        </div>


                                                        <div class="form-group"> 
                                                            <label class="control-label col-md-4 col-sm-4 col-xs-12">   </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <?=
                                                                PopoverX::widget([
                                                                    'header' => '<span style="color:black;"><strong> RUJUKAN NO.SIRI PELEKAT </strong></span>',
                                                                    'type' => PopoverX::TYPE_SUCCESS,
                                                                    'placement' => PopoverX::ALIGN_BOTTOM,
                                                                    'content' =>
                                                                    'KERETA STAF : KS123456 <br/>
                                                                                KERETA PELAJAR : KP123456 <br/>
                                                                                MOTOR STAF : MS123456 <br/>
                                                                                MOTOR PELAJAR : MP123456<br/>
                                                                                KERETA KONTRAKTOR : KC123456<br/>
                                                                                MOTOR KONTRAKTOR : MC123456 <br/>
                                                                                KERETA VIP : KVIP123456<br/>
                                                                                MOTOR VIP : MVIP123456 <br/>
                                                                                KERETA PELAWAT : KV123456 <br/>
                                                                                MOTOR PELAWAT : MV123456 <br/>
                                                                                KERETA JABATAN : KJ123456 <br/>
                                                                                MOTOR JABATAN :  MJ123456 <br/>
                                                                                KERETA KHAS : KK123456 <br/>
                                                                                MOTOR KHAS : MK123456',
                                                                    'toggleButton' => ['label' => 'RUJUKAN <i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-warning'],
                                                                ]);
                                                                ?>    
                                                                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
                                                            </div>
                                                        </div>

                                                        <?php ActiveForm::end(); ?>
                                                    <?php } elseif ($title == 'Selesai') { ?> 

                                                        <?=
                                                        DetailView::widget([
                                                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                                            'model' => $pelekat,
                                                            'attributes' => [

                                                                [
                                                                    'attribute' => 'no_siri',
                                                                    'value' => function($model) {
                                                                        return strtoupper($model->no_siri);
                                                                    },
                                                                    'contentOptions' => ['style' => 'width:30%'],
                                                                    'captionOptions' => ['style' => 'width:15%'],
                                                                ],
                                                                [
                                                                    'attribute' => 'no_resit',
                                                                    'value' => function($model) {
                                                                        return strtoupper($model->no_resit);
                                                                    },
                                                                    'contentOptions' => ['style' => 'width:30%'],
                                                                    'captionOptions' => ['style' => 'width:15%'],
                                                                ],
                                                                [
                                                                    'label' => 'Tarikh Luput Pelekat',
                                                                    'value' => function($model) {
                                                                        if ($model->expired_date_2) {
                                                                            return $model->user->biodata->getTarikh($model->expired_date_1) . ' - ' . $model->user->biodata->getTarikh($model->expired_date_2);
                                                                        } else {
                                                                            return $model->user->biodata->getTarikh($model->expired_date_1); //old permohonan
                                                                        }
                                                                    },
                                                                ],
                                                                'total',
                                                                [
                                                                    'attribute' => 'free',
                                                                    'value' => function($model) {
                                                                        return $model->free ? 'Percuma' : '-';
                                                                    },
                                                                    'contentOptions' => ['style' => 'width:30%'],
                                                                    'captionOptions' => ['style' => 'width:15%'],
                                                                ],
                                                            ],
                                                        ])
                                                        ?>

                                                    <?php } ?>
        </div>
    </div>
</div> 