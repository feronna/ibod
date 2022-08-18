<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\widgets\SwitchInput;

$this->title = $model_jenis->jenis_cuti_catatan . ' (' . $model_jenis->jenis_cuti_nama . ')';
?>
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-plane"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <ol>
            <li>*Sila pastikan borang permohonan lengkap diisi dan disertakan dokumen sokongan sebelum dikemukakkan ke seksyen perkhdimatan BSM, Jabatan Pendaftar untuk proses kelulusan</li>
        </ol>
        <div class="ln_solid"></div>

        <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
      
        <div class="form-group">
            <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Bercuti (Mula - Tamat) / <i><?php echo Html::activeLabel($model, 'full_date'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Bercuti start_date to end_date"></i>
            </label>

            <div class="col-md-5 col-sm-5 col-xs-12">
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
                        // 'ranges' => [ Yii::t('kvdrp', "Today") => ["moment().utc().startOf('day')", "moment().utc().endOf('day')"]],
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
        </div>


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Memohon Cuti Kecemasan
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <?php

                echo $form->field($model, 'arr[]')->checkboxList(
                    ['Banjir' => 'Banjir', 
                    'Gempa Bumi' => 'Gempa Bumi', 'Ribut' => 'Ribut','Perintah berkurung' =>'Perintah berkurung',
                    'Tanah runtuh' =>'Tanah runtuh','Jambatan runtuh'=>'Jambatan runtuh',
                    // 'Kebakaran',
                    'Perintah Sekatan Am' => 'Perintah Sekatan Am',
                    'Lain-lain'=>'Lain-lain  (Sila Perincikan)'
                    ]
                )->label(false);

                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Perincian
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'others')->textarea(['rows' => 4,'placeholder'=>'Sila Isi Sekiranya Memilih Pilihan Lain-lain'])->label(false); ?>
            </div>

        </div>
    

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'file'); ?>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Dokumen Sokongan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $form->field($model, 'file', ['enableAjaxValidation' => false])->fileInput()->label(false); ?>
            </div>

        </div>
        <p>Saya ingin memohon Cuti Kecemasan mengikut butiran berikut dan dilampirkan <strong>sesalinan dokumen sokongan</strong> bagi menyokong permohonan saya ini</p>
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

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
?>