<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\cuti\SetPegawai;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = $model_jenis->jenis_cuti_catatan . '/ Leave Outside the Country' . ' (' . $model_jenis->jenis_cuti_nama . ')';
?>
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-plane"></i>&nbsp;<strong>(<?= $model_jenis->jenis_cuti_nama ?>)&nbsp;<?= $model_jenis->jenis_cuti_catatan ?>/<i><?= $model_jenis->jenis_cuti_catatan_bi ?></i></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($model); ?>
        <p style="color: green">*Sila berhubung dengan <strong>Penyelia Cuti</strong> jabatan anda sekiranya anda mengalami sebarang masalah untuk memohon cuti / <i>Please contact your department's <strong>Leave Supervisor</strong> if your experience any difficulties </i></p>

        <div class="form-group">
            <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Bercuti (Mula - Tamat) / <i><?php echo Html::activeLabel($model, 'full_date'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Bercuti start_date to end_date"></i>
            </label>

            <div class="col-md-4 col-sm-4 col-xs-10">
                <?php
                echo $form->field($model, 'full_date', [
                    'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
                    'options' => ['class' => 'drp-container'],
                    'showLabels' => false,
                ])->widget(DateRangePicker::classname(), [
                    'useWithAddon' => true,
                    'startAttribute' => 'start_date',
                    'endAttribute' => 'end_date',
                    'convertFormat' => true,
                    'readonly' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd/m/Y',
                            'separator' => ' to '
                        ],
                        'opens' => 'left',
                    ],
                    'pluginEvents' => [
                        'apply.daterangepicker' => 'function(ev, picker) {
                            if($(this).val() == "") {
                                picker.callback(picker.startDate.clone(), picker.endDate.clone(), picker.chosenLabel);
                            }
                        }',
                    ]
                ]);
                ?>

            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <?= Html::button('<i class="fa fa-search"></i>  ', ['value' => Url::to(['cuti/individu/leave-list']), 'class' => 'mapBtn btn btn-success']); ?> </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Destinasi / <i><?= Html::activeLabel($model, 'destination'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Nyatakan destinasi percutian luar negara anda"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'destination')->textarea(['rows' => 2])->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pengganti/<i><?= Html::activeLabel($model, 'ganti_by'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pengganti"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'ganti_by')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map($staff_list, 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Pilih Pengganti', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>

        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan / <i><?= Html::activeLabel($model, 'remark'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'remark')->textarea(['rows' => 4])->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Peraku /<i><?= Html::activeLabel($model, 'peraku_by'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pengawai Memperaku Cuti"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $bio ?>" disabled="true">
            </div>
        </div>

        <div class="ln_solid"></div>


        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/individu/pilih'], ['class' => 'btn btn-warning']) ?>
                <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php

$content = '<p>Kakitangan yang berada di luar negara/negara ketiga atas urusan persendirian diwajibkan mengambil perlindungan insurans kesihatan atas tanggungan sendiri sebelum boleh dibenarkan ke luar negara.</p>
        
<p>Tuntutan bayaran balik (reimbursement) di mana kakitangan hendaklah mendahulukan bayaran premium dan kemudian boleh menuntut balik bayaran berkenaan daripada Seksyen Perkhidmatan Bahagian Sumber Manusia Jabatan Pendaftar.</p>

<p>Rujukan : <a target="_blank" href="/e_cuti/assets/uploads/jpa.pdf">Surat Jabatan Perkhidmatan Awam(S)187/20 Jld.18 (2) bertarikh 16 Januari 2019</a></p>
<p>Pekeliling Perkhidmatan Bilangan 6 Tahun 2015 :kemudahan Perlindungan Insurans Kesihatan kepada Pegawai Perkhidmatan Awam Yang Berada Di Luar Negara Atas Urusan Persendirian</p>
<p>Sebarang pertanyaan sila berhubung dengan :
</p>
<ul>
<li><strong>Puan Bibiana Robert/ Pembatu Tadbir P/O (Samb. 102893) </strong></li>
<li><strong>Puan Rozaidah Amir Hussein/ Penolong Pendaftar Kanan (Samb. 102005)</strong></li>
</ul>
<p></p>
<p>Borang Tuntutan Bayaran Balik Insurans Kesihatan Ke Luar Negara/ Negara Ketiga Atas Urusan Peribadi <strong><a target="_blank" href="/staff/web/uploads/Tuntutan Balik Bayaran Balik Insurans Kesihatan.pdf">[Clik Borang disini]</a></strong></p>
';




Modal::begin([
    'header' => '<span class="fa fa-info-circle"></span>&nbsp;<strong>PEMAKLUMAN</strong>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'>$content</div>";
Modal::end();
?>

<?php
$js = <<<js

        $('#modal').modal('show')
js;
$this->registerJs($js);
?>