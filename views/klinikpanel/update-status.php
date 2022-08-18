<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="tblmaxtuntutan-search">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Kemaskini Status Tuntutan Klinik Panel</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <th scope="col" colspan=12" style="background-color:teal; color:white">
                        <center>
                            <h5><strong>KEMASKINI STATUS SEMAKAN TUNTUTAN KLINIK PANEL</h5></strong>
                        </center>
                    </th>
                    <tr>
                        <td valign="5" width="30%">ID Tuntutan:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">
                            <div class="col-md-12 col-sm-12 col-xs-10">
                                <?= $form->field($model, 'batch_id')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => TRUE])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="5">Nama Klinik<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">
                            <div class="col-md-12 col-sm-12 col-xs-10">
                                <?= $form->field($model->klinik, 'nama')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => TRUE])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="5">Tarikh Tuntutan Dijana<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">
                            <div class="col-md-12 col-sm-12 col-xs-10">
                                <?= $form->field($model, 'batch_date_issued')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => TRUE])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="5">Jumlah Tuntutan (RM):<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'total_batch_claim')->textArea(['maxlength' => true, 'rows' => 1])->label(false); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="5">Status Semakan<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'status_check')->label(false)->widget(Select2::classname(), [
                                    'data' => ['1' => 'SELESAI SEMAKAN', '2' => 'PERLU PEMBETULAN DARIPADA KLINIK'],
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
                        </td>
                    </tr>
                    <tr>
                        <td valign="5">No. Invois Klinik<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'remarks')->textArea(['maxlength' => true, 'rows' => 1])->label(false); ?>
                            </div>
                        </td>
                    </tr>
            </table>
            </thead>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>