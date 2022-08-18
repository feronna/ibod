<?php

use kartik\form\ActiveForm;
use dosamigos\datepicker\DateRangePicker;
?>

<div class="rpt-tbl-aduan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="x_content">

        <div class="col-md-10 col-sm-10 col-xs-12">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tajuk Papan Tanda</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model, 'papan_tanda_title')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi tajuk papan tanda di sini...', 'disabled' => $status != 1 ? true : false))->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Pemasangan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model, 'papan_tanda_date_start')->widget(DateRangePicker::className(), [
                        'attributeTo' => 'papan_tanda_date_end',
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
                        'id' => 'pt'
                    ])->label(false); ?>
                </div>
            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>