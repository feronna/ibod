<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
// use dosamigos\datetimepicker\DateTimePicker;
use kartik\datetime\DateTimePicker;
?>


<div class="tblmaxtuntutan">
    <div class="x_panel">
        <div class="x_title">

            <h2><strong>Kemaskini Tuntutan Rawatan Klinik Panel</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <p>
                <?= Html::a('Kembali', ['view-adminr', 'id' => $model->rawatan_id], ['class' => 'btn btn-primary']) ?>
            </p>
        <div class="x_content">




            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-12">NAMA KLINIK<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model->klinik, 'nama')->textarea(['maxlength' => true, 'rows' => 1, 'disabled' => TRUE])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-12">NAMA KAKITANGAN<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model->kakitangan->kakitangan, 'CONm')->textarea(['maxlength' => true, 'rows' => 1, 'disabled' => TRUE])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NO.KP KAKITANGAN<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'visit_icno')->textarea(['maxlength' => true, 'rows' => 1, 'disabled' => TRUE])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA PESAKIT<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'pesakit_name')->textarea(['maxlength' => true, 'rows' => 1, 'disabled' => TRUE])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NO.KP PESAKIT<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'pesakit_icno')->textarea(['maxlength' => true, 'rows' => 1, 'disabled' => TRUE])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="used_dt">TARIKH RAWATAN<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <!--<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">-->
                    <?= DateTimePicker::widget([
                        'model' => $model,
                        'attribute' => "rawatan_date",
                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                        'options' => ['required' => true],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd HH:ii',
                        ]
                    ]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="used_dt">CUTI SAKIT?<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'mc_status')->label(false)->widget(Select2::classname(), [
                        'data' => ['1' => 'YA', '2' => 'TIDAK'],
                        'options' => [
                            'placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Dipersetujui"){
                                                $("#tempoh").show();
                                                    
                                                else{
                                                $("#tempoh").hide();
                                                }'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">RAWATAN<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'rawatan')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JUMLAH TUNTUTAN (RM)<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'jum_tuntutan')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="used_dt">STATUS REKOD LAWATAN<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'id_visit_status')->label(false)->widget(Select2::classname(), [
                        'data' => ['1' => 'BELUM JANA', '2' => 'TELAH DIJANA'],
                        'options' => [
                            'placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Dipersetujui"){
                                                $("#tempoh").show();
                                                    
                                                else{
                                                $("#tempoh").hide();
                                                }'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">ID TUNTUTAN<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tblvisit_batch_id')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

            <p>
                <?= Html::submitButton('<i class="fa fa-save" aria-hidden="true"></i> Simpan', ['class' => 'btn btn-success']) ?>
                <?=
                Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> Padam', ['deleted', 'id' => $model->rawatan_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])
                ?>
            </p>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>