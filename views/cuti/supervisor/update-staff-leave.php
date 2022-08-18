<?php

use app\models\cuti\SetPegawai;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Modal;


?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Kemaskini Cuti Kakitangan /<i> Update Staff's Leave</i></strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">



                <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Cuti / <i><?php echo Html::activeLabel($model, 'jenis_cuti_id'); ?></i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Jenis Cuti/ <i>Leave Type</i>"></i>
                    </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'jenis_cuti_id')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($jenis_cuti, 'jenis_cuti_id', 'jenis_cuti_catatan'),
                            'options' => ['placeholder' => 'Choose leave type', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Bercuti / <i>Leave Date (From - to) </i>
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
                        <?= $form->field($model, 'tempv2')->checkbox(array('label' => 'Tandakan jika hari Sabtu & Ahad adalah hari bekerja (Sabtu & Ahad akan dikira hari cuti)')); ?>
                        <?= $form->field($model, 'tempv3')->checkbox(array('label' => 'Tandakan jika hari Sabtu, Ahad & Cuti Umum Termasuk dalam pengiraan Jumlah Cuti')); ?>

                    </div>

                </div>


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Destinasi/<i>Destination</i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'destination')->textarea(['rows' => 2])->textarea()->input('destination', ['placeholder' => "Destinasi Untuk CR2 Sahaja"])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Peraku /<i>Verifier</i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pengganti"></i>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model, 'peraku_by')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::findAll(['Status' => 1]), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => 'Pilih Peraku', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>

                </div>


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Pelulus /<i>Approver</i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pengganti"></i>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model, 'lulus_by')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::findAll(['Status' => 1]), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => 'Pilih Pelulus', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>

                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan / <i>Supporting Document</i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Dokumen Sokongan (Medical Certificate / EDD Pregnancy / Any Supporting Document for Leave Type "></i>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo $form->field($model, 'file', ['enableAjaxValidation' => false])->fileInput()->label(false); ?>
                    </div>

                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Semakan Oleh /<i>Verified By</i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Penyelia Cuti Yang Memperaku"></i>
                    </label>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model, 'semakan_by')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($sick_leave_verifier, 'akses_cuti_icno', function ($sick_leave_verifier) {
                                return $sick_leave_verifier->slverifier->CONm;
                            }),
                            'options' => ['placeholder' => 'Penyelia Cuti Yang Memperaku Lampiran', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>

                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan /<i>Remark</i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'semakan_remark')->textarea(['rows' => 4])->label(false); ?>
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pengganti /<i><?= Html::activeLabel($model, 'ganti_by'); ?></i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pengganti"></i>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model, 'ganti_by')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::findAll(['Status' => 1]), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => 'Pilih Pengganti', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                        <?= $form->field($model, 'tempv1')->checkbox(array('label' => 'Tanda sekiranya Tidak Perlu Pengganti')); ?>

                    </div>

                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pengesahan /<i>Approval Status </i><span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?php
                        echo $form->field($model, 'status')->label(false)
                            ->dropDownList(
                                ['ENTRY' => 'ENTRY(BARU)', 'AGREED' => 'AGREED(BERSETUJU)', 'REJECTED' => 'REJECTED(DITOLAK)', 'CHECKED' => 'CHECKED(DISEMAK)', 'VERIFIED' => 'VERIFIED(DIPERAKU)', 'APPROVED' => 'APPROVED(DILULUSKAN)', 'VERIFIED_KJ' => 'VERIFIED_KJ(KEGUNAAN CUTI BERSALIN)'], // Flat array ('id'=>'label')
                                ['prompt' => '--Sila Pilih Status Pengesahan--']    // options
                            );
                        ?>
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan /<i>Remark</i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'remark')->textarea(['rows' => 4])->label(false); ?>
                    </div>
                </div>

                <div class="ln_solid"></div>


                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/supervisor/set-leave', 'id' => Yii::$app->getRequest()->getQueryParam('id')], ['class' => 'btn btn-warning']) ?>
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>