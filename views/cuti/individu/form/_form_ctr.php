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
use yii\helpers\Url;

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
            <li>Cuti CTR yang diambil di <strong>LUAR NEGARA (LN)</strong> adalah kelulusan Naib Canselor</li>
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
                        'opens' => 'left',
                    ]
                ]);
                ?>

            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <?= Html::button('<i class="fa fa-search"></i>  ', ['value' => Url::to(['cuti/individu/leave-list']), 'class' => 'mapBtn btn btn-success']); ?> </div>
        </div>


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'type'); ?>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="DN : Dalam Negara / LN : Luar Negara"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'type')->widget(SwitchInput::classname(), [
                    'pluginOptions' => [
                        'onText' => 'LN',
                        'offText' => 'DN',
                        'size' => 'small',
                        'onColor' => 'primary',
                        'offColor' => 'success',
                    ]
                ])->label(false)
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'remark'); ?>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'remark')->textarea(['rows' => 4])->label(false); ?>
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
        <p>Saya ingin memohon Cuti Tanpa Rekod mengikut butiran berikut dan dilampirkan <strong>sesalinan dokumen sokongan</strong> bagi menyokong permohonan saya ini</p>
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