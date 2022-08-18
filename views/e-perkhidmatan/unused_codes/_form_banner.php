<?php

use kartik\form\ActiveForm;
use kartik\time\TimePicker;
use dosamigos\datepicker\DateRangePicker;

?>

<div class="rpt-tbl-aduan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="x_content">

        <div class="col-md-10 col-sm-10 col-xs-12">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tajuk Banner / Bunting / Poster</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model, 'banner_title')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi tajuk banner di sini...', 'disabled' => $status != 1 ? true : false))->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Lokasi Pemasangan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model, 'banner_location')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize', 'placeholder' => 'Tempat program', 'disabled' => $status != 1 ? true : false], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Pemasangan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model, 'banner_date_start')->widget(DateRangePicker::className(), [
                        'attributeTo' => 'banner_date_end',
                        'labelTo' => 'hingga',
                        'form' => $form, // best for correct client validation
                        'language' => 'en',
                        'size' => 'ms',
                        'options' => [
                            'placeholder' => 'Tarikh mula',
                            'disabled' => $status != 1 ? true : false
                        ],
                        'optionsTo' => [
                            'placeholder' => 'Tarikh tamat',
                            'disabled' => $status != 1 ? true : false
                        ],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'orientation' => 'bottom'
                            //'minView' => 0, /** don't know what this is for */
                            //'daysOfWeekDisabled' => false
                            //'daysOfWeekDisabled' => '0,6'
                        ],
                        'id' => 'bn'
                    ])->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Masa Mula Pemasangan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model, 'banner_time_start')->widget(TimePicker::classname(), [
                        'options' => [
                            'disabled' => $status != 1 ? true : false
                        ],
                    ])->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Masa Tamat Pemasangan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model, 'banner_time_end')->widget(TimePicker::classname(), [
                        'options' => [
                            'disabled' => $status != 1 ? true : false
                        ],
                    ])->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Syarikat</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model, 'banner_company_name')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize', 'placeholder' => 'Tempat program', 'disabled' => $status != 1 ? true : false], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Tel Syarikat</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model, 'banner_company_no')->textInput(['maxlength' => true, 'type' => 'number', 'min' => '1', 'disabled' => $status != 1 ? true : false], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Salinan Banner / Bunting / Poster</label>
                <div class="col-md-4 col-sm-4 col-xs-10">
                    <?= $form->field($model, 'file1')->fileInput()->label(false); ?>
                </div>
            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>