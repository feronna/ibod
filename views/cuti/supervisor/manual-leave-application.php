<?php

use app\models\cuti\SetPegawai;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use kartik\date\DatePicker;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;


?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Permohonan Cuti Manual / <i>Manual Leave Application </i></strong></h2>

                <div class="clearfix"></div>
            </div>
            <div style="text-align:left; float:right; width:5%;">
                <a href="<?= Url::to(['cuti/supervisor/set-leave', 'id' => $id]); ?>" class="fa fa-calendar-check-o"></a>
                <a href="<?= Url::to(['cuti/supervisor/leave-list-sv', 'id' => $id]); ?>" class="fa fa-calendar-plus-o"></a>
                <a href="<?= Url::to(['cuti/supervisor/leave-statement', 'id' => $id]); ?>" class="fa fa-file"></a>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <?=
                        DetailView::widget([
                            'model' => $biodata,
                            'attributes' => [

                                [
                                    'attribute' => 'Nama / Name',
                                    'value' => function ($biodata) {
                                        return $biodata->gelaran->Title . ' ' . $biodata->CONm;
                                    }
                                ],
                                [
                                    'label' => 'ICNO/Passport',
                                    'attribute' => 'ICNO',
                                ],
                                [
                                    'label' => 'UMSPER',
                                    'attribute' => 'COOldID',
                                    'contentOptions' => ['style' => 'width:auto'],
                                    'captionOptions' => ['style' => 'width:26%'],
                                ],
                                [
                                    'label' => 'Jawatan / Position',
                                    'attribute' => 'jawatan.fname',
                                    'contentOptions' => ['style' => 'width:auto'],
                                    'captionOptions' => ['style' => 'width:26%'],
                                ],
                                [
                                    'label' => 'JFPIB',
                                    'attribute' => 'department.fullname',
                                    'contentOptions' => ['style' => 'width:auto'],
                                    'captionOptions' => ['style' => 'width:26%'],
                                ],
                                [
                                    'label' => 'Jenis Lantikan / Appointment Type',
                                    'attribute' => 'displaystatuslantikan',
                                    'contentOptions' => ['style' => 'width:auto'],
                                    'captionOptions' => ['style' => 'width:26%'],
                                ],
                                [
                                    'label' => 'Tarikh Lantikan / Appointment Date',
                                    'attribute' => 'displaystartlantik',
                                    'contentOptions' => ['style' => 'width:auto'],
                                    'captionOptions' => ['style' => 'width:26%'],
                                ],
                                [
                                    'label' => 'Status',
                                    'attribute' => 'displayservicestatus',
                                    'contentOptions' => ['style' => 'width:auto'],
                                    'captionOptions' => ['style' => 'width:26%'],
                                ],

                            ],
                        ])
                    ?>
                </div>
            </div>

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

                <div class="col-md-6 col-sm-6 col-xs-10">
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
                            'showDropdowns' => true,

                            'locale' => [
                                'format' => 'd/m/Y',
                                'separator' => ' to ',

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
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Dokumen Sokongan"></i>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'file', ['enableAjaxValidation' => false])->fileInput()->label(false); ?>
                    Sila Pastikan Saiz Fail Yang Anda Muat Naik Tidak Melebihi 2MB /
                    Please Make Sure The File Size You Upload Does Not Exceed 2MB
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
                            ['ENTRY' => 'BARU', 'AGREED' => 'BERSETUJU', 'REJECTED' => 'DITOLAK', 'CHECKED' => 'TELAH DISEMAK', 'VERIFIED' => 'DIPERAKU', 'APPROVED' => 'DILULUSKAN'], // Flat array ('id'=>'label')
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


    <?php

    $content = '<p>Sebelum memasukkan rekod cuti kepada kakitangan seliaan, sila pastikan :</p>

<p>1.   Borang permohonan yang diterima adalah lengkap dan diluluskan.
</p>
<p>2.   Masukkan tarikh dengan betul.
</p>
<p>3.   Rekod cuti yang dimasukkan akan mempunyai status LULUS (perakuan dan kelulusan).

</p>
<p>4.   Sekiranya tarikh tidak dapat dimasukkan (atas sebab pertindihan tarikh, dsb) sila maklumkan kepada kakitangan tersebut.
</p>
';




    Modal::begin([
        'header' => '<span class="fa fa-info-circle"></span>&nbsp;<strong>Makluman Kepada Semua Penyelia Cuti</strong>',
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