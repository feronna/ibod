<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\time\TimePicker;
use kartik\checkbox\CheckboxX;
use dosamigos\datepicker\DateRangePicker;
?>

<div class="rpt-tbl-aduan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <form class="needs-validation" novalidate>

        <div class="x_content">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">Maklumat Pemohon</label>
                </div>
            </div>

            </br></br>
            <div class="col-md-10 col-sm-10 col-xs-12">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($modelBio, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Kad Pengenalan <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($modelBio, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($modelBio, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan Disandang <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($modelBio->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($modelBio->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Telefon <span class="required"></span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?php

                        if ($modelBio->COHPhoneNo) {
                            echo $form->field($modelBio, 'COHPhoneNo')->textarea(array('rows' => 1, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi nombor telefon anda di sini', 'required' => 'required', 'disabled' => 'disabled'))->label(false);
                        } else {
                            echo $form->field($modelBio, 'COHPhoneNo')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi nombor telefon anda di sini', 'required' => 'required', 'disabled' => 'disabled'))->label(false);
                        }

                        ?>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?= Html::a('<i class="fa fa-edit"></i> Kemaskini Nombor Telefon', ['biodata/kemaskini'], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?php

                        if ($modelBio->alamatTetap) {

                            echo $form->field($modelBio->alamatTetap, 'alamatPenuh')->textInput(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi alamat anda di sini', 'required' => 'required', 'disabled' => 'disabled'))->label(false);
                        } else {

                            echo $form->field($modelBio, 'alamat')->textInput(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'value' => 'Sila lengkapkan alamat tetap anda.', 'required' => 'required', 'disabled' => 'disabled'))->label(false);
                        }

                        ?>

                    </div>
                    <p align="right"><?= Html::a('<i class="fa fa-edit"></i> Kemaskini Alamat', ['alamat/view'], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank']) ?></p>
                </div>

            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">Maklumat Program</label>
                </div>
            </div>

            </br></br>
            <div class="col-md-10 col-sm-10 col-xs-12">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Program</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'event_name')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi nama program di sini...', 'disabled' => $status != 1 ? true : false))->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'event_location')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize', 'placeholder' => 'Tempat program', 'disabled' => $status != 1 ? true : false], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?php // Client validation of date-ranges when using with ActiveForm
                        // $form = ActiveForm::begin([
                        //     'tooltipStyleFeedback' => true, // shows tooltip styled validation error feedback
                        // ]);
                        // echo '<label class="form-label">';
                        // echo DatePicker::widget([
                        //     'model' => $model,
                        //     'attribute' => 'tarikhMula',
                        //     'attribute2' => 'tarikhTamat',
                        //     'options' => ['placeholder' => 'Tarikh mula'],
                        //     'options2' => ['placeholder' => 'Tarikh tamat'],
                        //     'type' => DatePicker::TYPE_RANGE,
                        //     'form' => $form,
                        //     'pluginOptions' => [
                        //         'format' => 'yyyy-mm-dd',
                        //         'autoclose' => true,
                        //     ]
                        // ]);

                        // ActiveForm::end();
                        ?>
                        <?= $form->field($model, 'event_date_start')->widget(DateRangePicker::className(), [
                            'attributeTo' => 'event_date_end',
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
                            ]
                        ])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Masa Mula</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'event_time_start')->widget(TimePicker::classname(), [
                            'options' => [
                                'disabled' => $status != 1 ? true : false
                            ],
                        ])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Masa Tamat</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'event_time_end')->widget(TimePicker::classname(), [
                            'options' => [
                                'disabled' => $status != 1 ? true : false
                            ],
                        ])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Anggaran Peserta</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'event_anggaran_peserta')->textInput(['maxlength' => true, 'type' => 'number', 'min' => '1', 'disabled' => $status != 1 ? true : false], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Keperluan Kawalan Keselamatan</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'kawalan_status')->widget(CheckboxX::classname(), [
                            'name' => 'box_kawalan',
                            'value' => 1,
                            'disabled' => $status != 1 ? true : false,
                            'options' => [
                                'id' => 'checkbox3'
                            ],
                            'pluginOptions' => ['threeState' => false]
                        ])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Keperluan Parkir</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'parkir_status')->widget(CheckboxX::classname(), [
                            'name' => 'box_parkir',
                            'value' => 1,
                            'disabled' => $status != 1 ? true : false,
                            'options' => [
                                'id' => 'checkbox4'
                            ],
                            'pluginOptions' => ['threeState' => false]
                        ])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Keperluan Banner</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'banner_status')->widget(CheckboxX::classname(), [
                            'name' => 'box_banner',
                            'value' => 1,
                            'disabled' => $status != 1 ? true : false,
                            'options' => [
                                'id' => 'checkbox1',
                                'onchange' => 'javascript:if ($(this).val() == "1"){
                                    $("#banner_starter").show();
                                }  else {
                                    $("#banner_starter").hide();
                                 }'
                            ],
                            'pluginOptions' => ['threeState' => false]
                        ])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Keperluan Papan Tanda & Countdown</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'papan_tanda_status')->widget(CheckboxX::classname(), [
                            'name' => 'box_papan_tanda',
                            'value' => 1,
                            'disabled' => $status != 1 ? true : false,
                            'options' => [
                                'id' => 'checkbox2',
                                'onchange' => 'javascript:if ($(this).val() == "1"){
                                    $("#papan_tanda_starter").show();
                                }  else {
                                    $("#papan_tanda_starter").hide();
                                 }'
                            ],
                            'pluginOptions' => ['threeState' => false]
                        ])->label(false); ?>
                    </div>
                </div>

            </div>

            <!-- AISYAH -->
            <div id="banner_starter" hidden>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" style="background-color:lightgrey;">
                        <label class="control-label col-md-6 col-sm-6 col-xs-12">Maklumat Banner</label>
                    </div>
                </div>

                </br></br>

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
            <!-- -->

            <!-- JAQUIRAH -->
            <div id="papan_tanda_starter" hidden>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" style="background-color:lightgrey;">
                        <label class="control-label col-md-6 col-sm-6 col-xs-12">Maklumat Papan Tanda</label>
                    </div>
                </div>

                </br></br>
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
            <!-- /JAQUIRAH -->

            <div class="col-md-10 col-sm-10 col-xs-12">

                <?php if ($model->event_date_applied != NULL) { ?>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Permohonan <span class="required"></span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?= $form->field($model, 'event_date_applied')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Permohonan <span class="required"></span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            < $form->field($model, 'statusPermohonan')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                        </div>
                    </div> -->

                    <!--  if ($model->cancelled_date != NULL){?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Dibatalkan <span class="required"></span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            < $form->field($model, 'tarikhBatal')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                        </div>
                    </div>
                    < } > -->
                <?php } ?>

                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <p align="right">
                            <?php if ($status == 1) { ?>
                                <button class="btn btn-primary" type="submit">Hantar </button>
                            <?php } ?>
                            <?php if ($status == 2 && $model->event_application_status == 1) { ?><?= Html::a(Yii::t('app', 'Batal'), ['delete', 'id' => $model->event_id], [
                                                                                                        'class' => 'btn btn-danger',
                                                                                                        'data' => [
                                                                                                            'confirm' => Yii::t('app', 'Adakah anda pasti anda ingin membatalkan rekod aduan ini?'),
                                                                                                            'method' => 'post',
                                                                                                        ],
                                                                                                    ]) ?>
                        <?php } ?>
                        <?= Html::a('Kembali', ['view-list'], ['class' => 'btn btn-primary']) ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </form>

    <?php ActiveForm::end(); ?>

</div>