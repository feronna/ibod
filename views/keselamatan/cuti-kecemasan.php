<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\daterange\DateRangePicker;
use app\widgets\TopMenuWidget;
use kartik\select2\Select2;
use app\models\keselamatan\TblAkses;
use yii\helpers\ArrayHelper;
use aryelds\sweetalert\SweetAlert;

?>
<?= $this->render('/keselamatan/_topmenu') ?>

<?php
    echo SweetAlert::widget([
        'options' => [
            'title' => "Info",
            'text' => "Sila Pilih Pegawai Medan Yang Bertugas / yang Meluluskan Cuti Kecemasan Anda.",
            'type' => SweetAlert::TYPE_INFO,
            'animation' => 'slide-from-top',
//        'showCancelButton' => true,
//        'confirmButtonColor' => "#DD6B55",
            'confirmButtonText' => "Ok",
            'closeOnConfirm' => true,
        ],
    ]);

?>
<div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_content"> 
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <?php
                        $cr = \yiister\gentelella\widgets\StatsTile::widget(
                                        [
                                            'icon' => 'plus-square',
                                            'header' => 'Cuti Rehat',
                                            'text' => '',
                                            'number' => 'CR',
                                        ]
                        );
                        echo Html::a($cr, ['keselamatan/cuti-rehat-dalam-negara']);
                        ?>
                    </div>
                    <div style="background-color:lightblue" class="col-xs-12 col-md-3">
                         <?php
                        $ck = \yiister\gentelella\widgets\StatsTile::widget(
                                        [
                                            'icon' => 'plus-square',
                                            'header' => 'Cuti Kecemasan',
                                            'text' => '',
                                            'number' => 'CK',
                                        ]
                        );
                        echo Html::a($ck, ['keselamatan/cuti-kecemasan']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Permohonan Cuti Kecemasan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php
            Yii::$app->session->setFlash('info', ' Bagi Cuti Yang Dirancang ,Permohonan Cuti Hendaklah Dibuat TIGA hari Sebelum 15hb Setiap Bulan Untuk Dimasukkan Di Dalam Jadual. '
                    . 'Permohonan Cuti Yang Lain Pula Hendaklah Dibuat TIGA hari sebelum Tarikh Bercuti Kecuali Cuti Kecemasan');
            Yii::$app->session->setFlash('warning', 'Permohonan Cuti Hendaklah Diluluskan Dahulu oleh Pegawai Pelulus. Sekiranya anda bercuti sebelum cuti diluluskan Maka anda Akan Dianggap Sebagai Tidak Hadir Tanpa Cuti ');
            ?>
            <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
            <?php if ($model) { ?>
                <!--form-->
                <!--<form class="form-horizontal form-label-left">-->
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Baki Cuti :
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php echo $layak; ?>" disabled="">

                        </div>
                    </div>


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pemohon :
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->pemohon->CONm ?>" disabled="">
                    </div>
                </div>

                <!--                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Memperaku :
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php echo ($model->peraku_icno) ? $model->peraku->CONm : 'Terus kepada Pegawai Melulus'; ?>" disabled="">
                
                                    </div>
                                </div>-->


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Medan Yang Bertugas <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model2, 'cuti_lulus_oleh')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TblAkses::find()->where(['akses_level'=>3])->all(), 'icno','kakitangan.CONm'),
                            'options' => ['placeholder' => 'Pilih Pegawai Medan Yang Bertugas / Yang Meluluskan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>            
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Cuti Mula - Cuti Tamat :
                    </label>

                    <div class="col-md-4 col-sm-4 col-xs-10">
                        <?php
                        echo $form->field($model2, 'full_date', [
                            'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
                            'options' => ['class' => 'drp-container'],
                            'showLabels' => false,
                        ])->widget(DateRangePicker::classname(), [
                            'useWithAddon' => true,
                            'startAttribute' => 'cuti_mula',
                            'endAttribute' => 'cuti_tamat',
                            'convertFormat' => true,
                            'readonly' => true,
                            'pluginOptions' => [
                                'locale' => [
                                    'format' => 'Y-m-d',
                                    'separator' => ' -> '
                                ],
                                'opens' => 'left',
                            ]
                        ]);
                        ?>

                    </div>

                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sila Berikan Catatan Yang Terperinci<span class="required">:</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model2, 'cuti_catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>        
                <div class="ln_solid"></div>
                <?php if ($layak > 0) { ?>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="reset">Set Semula</button>
                            <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait.. ']]) ?>
                        </div>
                    </div>
                <?php } else { ?><div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'disabled' => 'disabled']) ?>
                        </div>
                    </div><?php } ?>

                <?php ActiveForm::end(); ?>

                <!--form-->
            <?php } else { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nota:
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <h2 class="text-center">Anda Tidak Mempunyai Pegawai Peraku/Pelulus. Sila Berjumpa Dengan Penyelia Cuti Jabatan Anda.</h2>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>