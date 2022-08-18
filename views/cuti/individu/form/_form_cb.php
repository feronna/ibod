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
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

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
            <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Expected due date/Delivery date
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Bercuti"></i>
            </label>

            <div class="col-md-5 col-sm-5 col-xs-12">
            <?php
            echo $form->field($model, 'start_date', [
                'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
                'options' => [
                    'class' => 'drp-container',
                    'autocomplete' => 'off'
                ],
                'showLabels' => false,
            ])->widget(DateRangePicker::classname(), [
                'useWithAddon'=>true,
                'readonly' => true,

                'pluginOptions'=>[
                
                    'singleDatePicker'=>true,
                    // 'locale' => [
                    //     'format' => 'd/m/Y',
                    //     // 'separator' => ' to '
                    // ],
                    // 'showDropdowns'=>true
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Maternity Balance 
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Baki Cuti Bersalin"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $bal ?>" disabled="true">
            </div>

        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Duration
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <?php
                   echo $form->field($model, 'arr1')->dropDownList(
                    ['30' => '30 Hari', '60' => '60 Hari', '90' => '90 Hari'],
                    ['prompt' => 'Pilih Jumlah Cuti Bersalin yang ada ingin mohon...']
                    // ENTRY,AGREED,CHECKED,VERIFIED,APPROVED,REJECTED,RETURNED
                )->label(false);

                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Remark
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'remark')->textarea(['rows' => 4, 'placeholder' => 'Sila Isi Catatan'])->label(false); ?>
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
        <p>Saya ingin memohon Cuti Bersalin mengikut butiran berikut dan dilampirkan <strong style="color:red;">sesalinan dokumen sokongan</strong> bagi menyokong permohonan saya ini</p>
        <p>Sebarang Perubahan Tarikh Bersalin Hendaklah di maklumkan terus kepada Penyelia Cuti BSM </p>
        <strong style="color:red;"><p>Sila Buat Permohonan Penukaran Waktu Bekerja anda setelah selesai membuat permohonan</p> </strong>

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