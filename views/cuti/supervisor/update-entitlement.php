<?php

use app\models\cuti\Layak;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\cuti\SetPegawai;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;

$this->title = $model->layak_icno;
?>
<?php if ($exist) { ?>
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Kemaskini Kelayakan / <i>Update Entitlement for</i> <?= $bio ?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
            <?= $form->errorSummary($model); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Mula/<i>Start Date</i>
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Mula Kelayakan"></i>
                </label>

                <div class="col-md-4 col-sm-4 col-xs-10">

                    <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'layak_mula',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => false],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>

                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Tamat/<i>End Date</i>
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Tamat Kelayakan"></i>
                </label>

                <div class="col-md-4 col-sm-4 col-xs-10">

                    <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'layak_tamat',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => false],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>

                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Jumlah Kelayakan / <i>Entitlement Days</i>

                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Jumlah Kelayakan"></i>
                </label>

                <div class="col-md-4 col-sm-4 col-xs-10">

                    <?= $form->field($model, 'layak_cuti', [
                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent', 'disabled' => false]
                    ])->textInput()->input('layak_cuti', ['placeholder' => "Kelayakan Cuti"])->input('layak_cuti', ['placeholder' => "Dikira automatik oleh sistem"])->label(false); ?>
                    <?= $form->field($model, 'indicator')->checkbox(array('label' => 'Tandakan jika Mahu Menambah Kelayakan Cuti Secara Manual')); ?>

                </div>

            </div>

            <div class="ln_solid"></div>
            &nbsp&nbsp BCTL <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
            <br>
            <br>
            <div class="col-md-4 col-sm-4 col-xs-12">

                <?= $form->field($model, 'layak_bawa_lepas', [
                    'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                ])->textInput()->input('layak_bawa_lepas', ['placeholder' => "Kelayakan Cuti", 'disabled' => true,])->label(false); ?>

            </div>
            <br>
            <div class="col-md-8 col-sm-4 col-xs-12">

                Baki dari tahun lepas akan ditarik secara automatik daripada rekod kelayakan sebelum ini.

            </div>
            <br>
            <br>
            <i> Sila pastikan Jumlah ruangan CBTH + GCR + LUPUS adalah sama dengan jumlah pada ruangan Baki Akhir Cuti Rehat. Sekiranya terdapat ruangan tidak berkaitan biarkan nilai berkenaan kepada 0.
            </i>
        </div>
        <br>
        <br>
        &nbsp&nbsp Baki Akhir Cuti Rehat <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Baki Cuti"></i>
        <br>

        <div class="form-group">

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group field-tblrekod-tarikh">

                    <input type="text" class="col-md-4 col-sm-4 col-xs-12" name="TblRekod[tarikh]" value="
    <?= Layak::getBakiLast($model->layak_id); ?>" disabled="">


                    <div class="help-block"></div>
                </div>
            </div>
        </div>


        <br>
        <br>
        &nbsp&nbsp CBTH <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
        <br>
        <br>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <?= $form->field($model, 'layak_bawa_depan', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
            ])->textInput()->input('layak_bawa_depan', ['placeholder' => "Kelayakan Cuti"])->label(false); ?>

        </div>
        <br>
        <br>

        <br>
        &nbsp&nbsp GCR <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
        <br>
        <br>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <?= $form->field($model, 'layak_gcr', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
            ])->textInput()->input('layak_gcr', ['placeholder' => "Kelayakan Cuti"])->label(false); ?>

        </div>

        <br>
        <br>
        <br>
        &nbsp&nbsp Lupus <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
        <br>
        <br>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <?= $form->field($model, 'layak_hapus', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
            ])->textInput()->input('layak_hapus', ['placeholder' => "Kelayakan Cuti"])->label(false); ?>

        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/individu/pilih'], ['class' => 'btn btn-warning']) ?>
                <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

    </div>


    <?php ActiveForm::end(); ?>

    </div>
    </div>
<?php } elseif ($stat == 1) { ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Kemaskini Kelayakan / <i>Update Entitlement for</i> <?= $bio ?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
            <?= $form->errorSummary($model); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Mula/<i>Start Date</i>
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Mula Kelayakan"></i>
                </label>

                <div class="col-md-4 col-sm-4 col-xs-10">

                    <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'layak_mula',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => false],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>

                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Tamat/<i>End Date</i>
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Tamat Kelayakan"></i>
                </label>

                <div class="col-md-4 col-sm-4 col-xs-10">

                    <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'layak_tamat',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => false],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>

                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Jumlah Kelayakan / <i>Entitlement Days</i>

                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Jumlah Kelayakan"></i>
                </label>

                <div class="col-md-4 col-sm-4 col-xs-10">
                    <?= $form->field($model, 'layak_cuti', [
                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent', 'disabled' => true]
                    ])->textInput()->input('layak_cuti', ['placeholder' => "Kelayakan Cuti"])->input('layak_cuti', ['placeholder' => "Dikira automatik oleh sistem"])->label(false); ?>

                </div>

            </div>

            <div class="ln_solid"></div>
            &nbsp&nbsp BCTL <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
            <br>
            <br>
            <div class="col-md-4 col-sm-4 col-xs-12">

                <?= $form->field($model, 'layak_bawa_lepas', [
                    'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                ])->textInput()->input('layak_bawa_lepas', ['placeholder' => "Kelayakan Cuti", 'disabled' => true,])->label(false); ?>

            </div>
            <br>
            <div class="col-md-8 col-sm-4 col-xs-12">

                Baki dari tahun lepas akan ditarik secara automatik daripada rekod kelayakan sebelum ini.

            </div>
            <br>
            <br>
            <i> Sila pastikan Jumlah ruangan CBTH + GCR + LUPUS adalah sama dengan jumlah pada ruangan Baki Akhir Cuti Rehat. Sekiranya terdapat ruangan tidak berkaitan biarkan nilai berkenaan kepada 0.

            </i>
        </div>
        <br>
        <br>
        &nbsp&nbsp Baki Akhir Cuti Rehat <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Baki Cuti"></i>
        <br>

        <div class="form-group">

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group field-tblrekod-tarikh">

                    <input type="text" class="col-md-4 col-sm-4 col-xs-12" name="TblRekod[tarikh]" value="
    <?= Layak::getBakiLast($model->layak_id); ?>" disabled="">


                    <div class="help-block"></div>
                </div>
            </div>
        </div>


        <br>
        <br>
        &nbsp&nbsp CBTH <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
        <br>
        <br>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <?= $form->field($model, 'layak_bawa_depan', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent', 'disabled' => true]
            ])->textInput()->input('layak_bawa_depan', ['placeholder' => "Kelayakan Cuti"])->label(false); ?>

        </div>
        <br>
        <br>

        <br>
        &nbsp&nbsp GCR <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
        <br>
        <br>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <?= $form->field($model, 'layak_gcr', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent', 'disabled' => true]
            ])->textInput()->input('layak_bawa_depan', ['placeholder' => "Kelayakan Cuti"])->label(false); ?>

        </div>

        <br>
        <br>
        <br>
        &nbsp&nbsp Lupus <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
        <br>
        <br>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <?= $form->field($model, 'layak_hapus', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent', 'disabled' => true]
            ])->textInput()->input('layak_bawa_depan', ['placeholder' => "Kelayakan Cuti"])->label(false); ?>

        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/individu/pilih'], ['class' => 'btn btn-warning']) ?>
                <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

    </div>


    <?php ActiveForm::end(); ?>

    </div>
    </div>
<?php } elseif ($stat == 7 || $stat == 6) { ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Kemaskini Kelayakan / <i>Update Entitlement for</i> <?= $bio ?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
            <?= $form->errorSummary($model); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Mula/<i>Start Date</i>
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Mula Kelayakan"></i>
                </label>

                <div class="col-md-4 col-sm-4 col-xs-10">

                    <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'layak_mula',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => false],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>

                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Tamat/<i>End Date</i>
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Tamat Kelayakan"></i>
                </label>

                <div class="col-md-4 col-sm-4 col-xs-10">

                    <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'layak_tamat',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => false],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>

                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Jumlah Kelayakan / <i>Entitlement Days</i>

                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Jumlah Kelayakan"></i>
                </label>

                <div class="col-md-4 col-sm-4 col-xs-10">
                    <?= $form->field($model, 'layak_cuti', [
                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent', 'disabled' => false]
                    ])->textInput()->input('layak_cuti', ['placeholder' => "Kelayakan Cuti"])->input('layak_cuti', ['placeholder' => "Sila Masukkan Jumlah Kelayakan"])->label(false); ?>

                </div>

            </div>

            <div class="ln_solid"></div>
            &nbsp&nbsp BCTL <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
            <br>
            <br>
            <div class="col-md-4 col-sm-4 col-xs-12">

                <?= $form->field($model, 'layak_bawa_lepas', [
                    'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                ])->textInput()->input('layak_bawa_lepas', ['placeholder' => "Kelayakan Cuti", 'disabled' => true,])->label(false); ?>

            </div>
            <br>
            <div class="col-md-8 col-sm-4 col-xs-12">

                Baki dari tahun lepas akan ditarik secara automatik daripada rekod kelayakan sebelum ini.

            </div>
            <br>
            <br>
            <i> Sila pastikan Jumlah ruangan CBTH + GCR + LUPUS adalah sama dengan jumlah pada ruangan Baki Akhir Cuti Rehat. Sekiranya terdapat ruangan tidak berkaitan biarkan nilai berkenaan kepada 0.

            </i>
        </div>
        <br>
        <br>
        &nbsp&nbsp Baki Akhir Cuti Rehat <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Baki Cuti"></i>
        <br>

        <div class="form-group">

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group field-tblrekod-tarikh">

                    <input type="text" class="col-md-4 col-sm-4 col-xs-12" name="TblRekod[tarikh]" value="
    <?= Layak::getBakiLast($model->layak_id); ?>" disabled="">


                    <div class="help-block"></div>
                </div>
            </div>
        </div>


        <br>
        <br>
        &nbsp&nbsp CBTH <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
        <br>
        <br>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <?= $form->field($model, 'layak_bawa_depan', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
            ])->textInput()->input('layak_bawa_depan', ['placeholder' => "Kelayakan Cuti"])->label(false); ?>

        </div>
        <br>
        <br>

        <br>
        &nbsp&nbsp GCR <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
        <br>
        <br>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <?= $form->field($model, 'layak_gcr', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent', 'disabled' => true]
            ])->textInput()->input('layak_bawa_depan', ['placeholder' => "Kelayakan Cuti"])->label(false); ?>

        </div>

        <br>
        <br>
        <br>
        &nbsp&nbsp Lupus <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
        <br>
        <br>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <?= $form->field($model, 'layak_hapus', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
            ])->textInput()->input('layak_bawa_depan', ['placeholder' => "Kelayakan Cuti"])->label(false); ?>

        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/individu/pilih'], ['class' => 'btn btn-warning']) ?>
                <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

    </div>


    <?php ActiveForm::end(); ?>

    </div>
    </div>
<?php } else { ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Kemaskini Kelayakan / <i>Update Entitlement for</i> <?= $bio ?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
            <?= $form->errorSummary($model); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Mula/<i>Start Date</i>
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Mula Kelayakan"></i>
                </label>

                <div class="col-md-4 col-sm-4 col-xs-10">

                    <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'layak_mula',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => false],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>

                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Tamat/<i>End Date</i>
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Tamat Kelayakan"></i>
                </label>

                <div class="col-md-4 col-sm-4 col-xs-10">

                    <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'layak_tamat',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => false],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>

                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Jumlah Kelayakan / <i>Entitlement Days</i>

                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Jumlah Kelayakan"></i>
                </label>

                <div class="col-md-4 col-sm-4 col-xs-10">
                    <?= $form->field($model, 'layak_cuti', [
                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent', 'disabled' => true]
                    ])->textInput()->input('layak_cuti', ['placeholder' => "Kelayakan Cuti"])->input('layak_cuti', ['placeholder' => "Dikira automatik oleh sistem"])->label(false); ?>

                </div>

            </div>

            <div class="ln_solid"></div>
            &nbsp&nbsp BCTL <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
            <br>
            <br>
            <div class="col-md-4 col-sm-4 col-xs-12">

                <?= $form->field($model, 'layak_bawa_lepas', [
                    'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                ])->textInput()->input('layak_bawa_lepas', ['placeholder' => "Kelayakan Cuti", 'disabled' => true,])->label(false); ?>

            </div>
            <br>
            <div class="col-md-8 col-sm-4 col-xs-12">

                Baki dari tahun lepas akan ditarik secara automatik daripada rekod kelayakan sebelum ini.

            </div>
            <br>
            <br>
            <i> Sila pastikan Jumlah ruangan CBTH + GCR + LUPUS adalah sama dengan jumlah pada ruangan Baki Akhir Cuti Rehat. Sekiranya terdapat ruangan tidak berkaitan biarkan nilai berkenaan kepada 0.

            </i>
        </div>
        <br>
        <br>
        &nbsp&nbsp Baki Akhir Cuti Rehat <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Baki Cuti"></i>
        <br>

        <div class="form-group">

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group field-tblrekod-tarikh">

                    <input type="text" class="col-md-4 col-sm-4 col-xs-12" name="TblRekod[tarikh]" value="
    <?= Layak::getBakiLast($model->layak_id); ?>" disabled="">


                    <div class="help-block"></div>
                </div>
            </div>
        </div>


        <br>
        <br>
        &nbsp&nbsp CBTH <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
        <br>
        <br>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <?= $form->field($model, 'layak_bawa_depan', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
            ])->textInput()->input('layak_bawa_depan', ['placeholder' => "Kelayakan Cuti"])->label(false); ?>

        </div>
        <br>
        <br>

        <br>
        &nbsp&nbsp GCR <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
        <br>
        <br>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <?= $form->field($model, 'layak_gcr', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent', 'disabled' => true]
            ])->textInput()->input('layak_bawa_depan', ['placeholder' => "Kelayakan Cuti"])->label(false); ?>

        </div>

        <br>
        <br>
        <br>
        &nbsp&nbsp Lupus <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="BCTL"></i>
        <br>
        <br>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <?= $form->field($model, 'layak_hapus', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
            ])->textInput()->input('layak_bawa_depan', ['placeholder' => "Kelayakan Cuti"])->label(false); ?>

        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/individu/pilih'], ['class' => 'btn btn-warning']) ?>
                <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

    </div>


    <?php ActiveForm::end(); ?>

    </div>
    </div>
<?php } ?>