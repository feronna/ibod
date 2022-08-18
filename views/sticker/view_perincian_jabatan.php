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
        <?php if ($title == 'Menunggu Kutipan') { ?>
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
                                return $model->kenderaan->lesen_no ? $model->kenderaan->lesen_no : 'Tiada Maklumat';
                            },
                        ],
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
            </div>
            <div class="table-responsive col-md-6 col-sm-6 col-xs-6">
                <?=
                DetailView::widget([
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'model' => $pelekat,
                    'attributes' => [


                        [
                            'label' => 'Warna kenderaan',
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
        <?php if ($title == 'Menunggu Kutipan') { ?>
            <div class="col-md-6 col-sm-6 col-xs-6">

            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
                <?php
                $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]);
                ?> 


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
            </div>

            <?php ActiveForm::end(); ?>
        <?php } elseif ($title == 'Selesai') { ?> 
            <div class="col-md-6 col-sm-6 col-xs-6"></div>
            <div class="col-md-6 col-sm-6 col-xs-6"> 
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
                        [
                            'label' => 'Pengemaskini',
                            'value' => function($model) {
                                if ($model->updater) {
                                    return $model->updater . ' - ' . ucwords(strtolower($model->pengemaskini->CONm));
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
                ])
                ?> 
            </div>

        <?php } ?>

    </div>
</div> 