<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use kartik\popover\PopoverX;

if ($title == 'Menunggu Kutipan') {
    $head = 'Menunggu Pengambilan';
} else {
    $head = $title;
}
date_default_timezone_set("Asia/Kuala_Lumpur");
?>
<?= $this->render('menu') ?> 
<div class="x_panel">
    <div class="x_title">
        <h2>Permohonan <?= $head; ?></h2> <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?></p>
        <div class="clearfix"></div>
    </div> 
    <div class="x_content"> 
        <?php if ($title == 'Semasa' || $title == 'Menunggu Kutipan') { ?>
            <div class="table-responsive col-md-6 col-sm-6 col-xs-6">
                <?=
                DetailView::widget([
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'model' => $pelekat,
                    'attributes' => [
                        [
                            'label' => 'No. KP / Paspot',
                            'value' => function($model) {
                                return ucwords(strtolower($model->user->biodata->icno));
                            },
                            'contentOptions' => ['style' => 'width:30%'],
                            'captionOptions' => ['style' => 'width:15%'],
                        ],
                        [
                            'label' => 'No. Matrik',
                            'value' => function($model) {
                                return ucwords(strtolower($model->user->biodata->username));
                            },
                        ],
                        [
                            'label' => 'Nama',
                            'value' => function($model) {
                                return ucwords(strtolower($model->user->biodata->name));
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
                            'label' => 'Status Permohonan',
                            'value' => function($model) {
                                return ucwords(strtolower($model->status_mohon));
                            },
                        ],
                        [
                            'label' => 'Tarikh Mohon',
                            'value' => function($model) {
                                return $model->user->biodata->getTarikh($model->mohon_date) . '  ' . date("H:i:s", strtotime($model->mohon_date));
                            },
                        ],
                        [
                            'label' => 'No. Telefon Bimbit',
                            'value' => function($model) {
                                return $model->user->biodata->no_tel;
                            },
                        ],
                        [
                            'label' => 'Email',
                            'value' => function($model) {
                                return $model->user->biodata->email;
                            },
                        ],
                        [
                            'label' => 'Fail Lesen',
                            'value' => function($model) {
                                $lesen = $model->kenderaan->findLesenStudent($model->kenderaan->lesen_id);

                                if (!empty($lesen->filename) && $lesen->filename != 'deleted') {
                                    return html::a(Yii::$app->FileManager->NameFile($lesen->filename), Yii::$app->FileManager->DisplayFile($lesen->filename), ['target' => '_blank']);
                                }
                                return 'File not exist!';
                            },
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'kenderaan.filename_grant',
                                    'value' => function($model) {
                                        if (!empty($model->kenderaan->filename_grant) && $model->kenderaan->filename_grant != 'deleted') {
                                            return html::a(Yii::$app->FileManager->NameFile($model->kenderaan->filename_grant), Yii::$app->FileManager->DisplayFile($model->kenderaan->filename_grant), ['target' => '_blank']);
                                        }
                                        return 'File not exist!';
                                    },
                                            'format' => 'raw',
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
                                            'label' => 'Tarikh Tamat Lesen',
                                            'value' => function($model) {
                                                if ($model->kenderaan->lesen_id) {
                                                    return $model->user->biodata->getTarikh($model->kenderaan->lesen($model->kenderaan->lesen_id));
                                                } else {
                                                    return;
                                                }
                                            },
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
                                            'label' => 'No. KP / Paspot',
                                            'value' => function($model) {
                                                return ucwords(strtolower($model->user->biodata->icno));
                                            },
                                            'contentOptions' => ['style' => 'width:30%'],
                                            'captionOptions' => ['style' => 'width:15%'],
                                        ],
                                        [
                                            'label' => 'No. Matrik',
                                            'value' => function($model) {
                                                return ucwords(strtolower($model->user->biodata->username));
                                            },
                                        ],
                                        [
                                            'label' => 'Nama',
                                            'value' => function($model) {
                                                return ucwords(strtolower($model->user->biodata->name));
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
                                            'attribute' => 'status_mohon',
                                            'value' => function($model) {
                                                return ucwords(strtolower($model->status_mohon));
                                            },
                                        ],
                                        [
                                            'attribute' => 'Tarikh Mohon',
                                            'value' => function($model) {
                                                return $model->user->biodata->getTarikh($model->mohon_date) . '  ' . date("H:i:s", strtotime($model->mohon_date));
                                            },
                                        ],
                                        [
                                            'label' => 'No. Telefon Bimbit',
                                            'value' => function($model) {
                                                return $model->user->biodata->no_tel;
                                            },
                                        ],
                                        [
                                            'label' => 'Email',
                                            'value' => function($model) {
                                                return $model->user->biodata->email;
                                            },
                                        ],
                                        [
                                            'attribute' => 'status_mohon',
                                            'value' => function($model) {
                                                return ucwords(strtolower($model->status_mohon));
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
                                            'attribute' => 'status_kenderaan',
                                            'value' => function($model) {
                                                return ucwords(strtolower($model->kenderaan->status_kenderaan));
                                            },
                                        ],
                                    ],
                                ])
                                ?>
                            </div>     
                        <?php } ?>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php if ($title == 'Semasa') { ?>

                                <?php
                                $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]);
                                ?> 
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoLese">Status: <span class="required" style="color:red;">*</span>
                                    </label>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <?=
                                        $form->field($model, 'status_mohon')->widget(Select2::classname(), [
                                            'data' => ['MENUNGGU KUTIPAN' => 'LULUS', 'DITOLAK' => 'DITOLAK'],
                                            'options' => ['placeholder' => '....'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label(false);
                                        ?>
                                    </div>
                                </div>    

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisLesen">Catatan: <span class="required" style="color:red;">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <?= $form->field($model, 'catatan2')->textarea(['maxlength' => true])->label(false); ?>
                                    </div>
                                </div> 
                                <div class="form-group text-center"> 
                                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
                                </div>

                                <?php ActiveForm::end(); ?>
                            <?php } elseif ($title == 'Menunggu Kutipan') { ?>

                                <?php
                                $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]);
                                ?> 
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisLesen">Harga Pelekat (RM): <span class="required" style="color:red;">*</span>
                                    </label>
                                    <div class="col-md-2 col-sm-2 col-xs-12"> 

                                        <?= $form->field($model, 'total')->textInput(['value' => $model->findStickerRate(), 'disabled' => true])->label(false); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh Pelekat: <span class="required" style="color:red;">*</span>
                                    </label>
                                    <div class="col-md-2 col-sm-2 col-xs-12">    
                                        <?php
                                        echo DatePicker::widget([
                                            'model' => $model,
                                            'attribute' => 'mula',
                                            'template' => '{input}{addon}',
                                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => 'true'],
                                            'clientOptions' => [
                                                'autoclose' => true,
                                                'format' => 'yyyy-mm-dd'
                                            ]
                                        ]);
                                        ?>  
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">     
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoLese">No. Siri:  
                                        <span class="required" style="color:red;">*</span>
                                    </label>
                                    <div class="col-md-1 col-sm-1 col-xs-12">
                                        <?= $form->field($model, 'kod_siri')->textInput(['disabled' => true])->label(false); ?>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <?= $form->field($model, 'siri')->textInput(['maxlength' => true])->label(false); ?>
                                    </div> 
                                    <div class="col-md-2 col-sm-2 col-xs-12">
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
                                            'toggleButton' => ['label' => 'RUJUKAN <i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-warning btn-sm'],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            
                            <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisLesen">No. Resit: <span class="required" style="color:red;">*</span>
                                    </label>
                                    <div class="col-md-2 col-sm-2 col-xs-12"> 

                                        <?= $form->field($model, 'no_resit')->textInput()->label(false); ?> 
                                    </div>
                                </div>
 


                                <div class="form-group"> 
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">   </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                                        <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
                                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
                                    </div>
                                </div>


                                <?php ActiveForm::end(); ?>
                            <?php } elseif ($title == 'Selesai') { ?> 
                                <div class="table-responsive col-md-offset-2 col-sm-offset-2 col-xs-offset-2 col-md-8 col-sm-8 col-xs-8">
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
                                                'attribute' => 'updater',
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
                                                    return $model->user->biodata->getTarikh($model->app_date);
                                                },
                                            ],
                                            [
                                                'label' => 'Tarikh Luput Pelekat',
                                                'value' => function($model) {
                                                    if ($model->expired_date_2) {
                                                        return $model->user->biodata->getTarikh($model->expired_date) . ' - ' . $model->user->biodata->getTarikh($model->expired_date_2);
                                                    } else {
                                                        return $model->user->biodata->getTarikh($model->expired_date);
                                                    }
                                                },
                                            ],
                                            'total',
                                        ],
                                    ])
                                    ?>

                                </div>
                            <?php } ?>
        </div>
    </div>
</div> 