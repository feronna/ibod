<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\hronline\Negara;
use app\models\hronline\MajorMinor; 
use kartik\daterange\DateRangePicker;
use app\models\smp_ppi\CutiPenyelidikan;
error_reporting(0);

?>

<?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($model); ?>
<div class="x_panel">
    
 <table class="table table-bordered jambo_table">
                <thead>
                        <th scope="col" colspan=12">
                        <center>MAKLUMAT PENYELIDIKAN</center></th>
                </thead>
                </table>
<div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Penyelidikan
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Lokasi"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <?php
                echo $form->field($model, 'lokasi')->dropDownList(
                    ['0' => 'Dalam Negara', '1' => 'Luar Negara'],
                    ['prompt' => 'Sila Pilih...']
                )->label(false);
                ?>
            </div>
        </div>

    
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Projek Penyelidikan
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Penyelidikan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'research_id')->label(false)->widget(Select2::classname(), [
                    'data' => \app\models\elnpt\TblPenyelidikan2::staffResearchList($ICNO),
                    'options' => ['placeholder' => 'Choose Project', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?> </div>
        </div>
       <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Penyelidikan
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Penyelidikan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                echo $form->field($model, 'full_dt', [
                    'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>','rows'=>4]],
                    'options' => ['class' => 'drp-container'],
                    'showLabels' => false,
                ])->widget(DateRangePicker::classname(), [
                    'useWithAddon' => true,
                    'startAttribute' => 'tarikh_mula',
                    'endAttribute' => 'tarikh_tamat',
                    'convertFormat' => true,
                    'readonly' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd/m/Y',
                            'separator' => ' hingga '
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Justifikasi Permohonan
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'catatan')->textarea(['rows' => 4])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Penetapan KPI sepanjang Cuti

                <label class="control-label col-md-12 col-sm-12 col-xs-12">a. Faedah kepada tugas hakiki
                </label>

                <label class="control-label col-md-12 col-sm-12 col-xs-12"> b. Faedah kepada Universiti
                </label>

                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'summary')->textarea(['rows' => 4])->label(false); ?>
            </div>
        </div>


          
          
         

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                     <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                    
                   
                </div>
            </div>
                 <?= $form->field($model, 'iklan_id')->hiddenInput(['value' => $iklan->id])->label(false); ?>

            <?php ActiveForm::end(); ?>
     <!-- end of xpanel-->
  </div>

