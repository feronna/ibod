<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="col-md-12">
</div>
<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Permohonan Baru</strong></h2>
            <div class="clearfix"></div>
        </div>

        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'icno')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan dan Gred <span class="required"></span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Lantikan <span class="required"></span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan->statusLantikan, 'ApmtStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">J/ F/ P/ I/ B <span class="required"></span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Emel <span class="required"></span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan, 'COEmail')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon <span class="required"></span>
                            </label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan, 'COOffTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>


                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ext <span class="required"></span>
                            </label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan, 'COOUCTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                                <?php // $form->field($model->rekod, 'destinasi')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <h2><i class="fa fa-book"></i><strong> Butiran Permohonan - <?php if ($model->entry_id == 1) {
                                                                                    echo "Kali Pertama";
                                                                                } else {
                                                                                    echo 'Kali Kedua';
                                                                                } ?></strong></h2>

                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>

                    <div class="clearfix"></div>
                </div>
                <div class="container">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <th scope="col" colspan=12" style="background-color:lightseagreen; color:white">
                                    <center>
                                        <h5><strong>MAKLUMAT PERUNTUKAN TAHUN <?= date('Y') ?></strong></h5>
                                    </center>
                                </th>
                                <tr>
                                    <td valign="5" width="30%">Jumlah Peruntukan Tahunan (RM):<span class="required" style="color:red;">*</span></td>
                                    <td colspan="5">
                                        <div class="col-md-12 col-sm-12 col-xs-10">
                                            <?= $form->field($model->kakitangan, 'max_tuntutan')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => TRUE])->textInput(['disabled' => 'disabled'])->label(false); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="5">Baki Peruntukan (RM):<span class="required" style="color:red;">*</span></td>
                                    <td colspan="5">
                                        <div class="col-md-12 col-sm-12 col-xs-10">
                                            <?= $form->field($model->kakitangan, 'current_balance')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => TRUE])->textInput(['disabled' => 'disabled'])->label(false); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="5">Rekod Penambahan Peruntukan (RM):<span class="required" style="color:red;">*</span></td>
                                    <td colspan="5">
                                        <div class="col-md-12 col-sm-12 col-xs-10">
                                            <?= $form->field($model->kakitangan, 'topup_max')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => TRUE])->textInput(['disabled' => 'disabled'])->label(false); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="5">Jumlah Tuntutan Klinik Panel (RM):<span class="required" style="color:red;">*</span></td>
                                    <td colspan="5">
                                        <div class="col-md-12 col-sm-12 col-xs-10">
                                            <?= $form->field($model->kakitangan, 'tuntutan')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => TRUE])->textInput(['disabled' => 'disabled'])->label(false); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="5">Jumlah Tuntutan Klinik Bukan Panel (RM):<span class="required" style="color:red;">*</span></td>
                                    <td colspan="5">
                                        <div class="col-md-12 col-sm-12 col-xs-10">
                                            <?= $form->field($model->kakitangan, 'tuntutan_bukan_panel')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => TRUE])->textInput(['disabled' => 'disabled'])->label(false); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="5">Jumlah Tuntutan PKU HUMS - Sistem MedCare (RM):<span class="required" style="color:red;">*</span></td>
                                    <td colspan="5">
                                        <div class="col-md-12 col-sm-12 col-xs-10">
                                            <?= $form->field($model->kakitangan, 'jumlah')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => TRUE])->textInput(['disabled' => 'disabled'])->label(false); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="5">Bilangan Tanggungan:<span class="required" style="color:red;">*</span></td>
                                    <td colspan="5">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <?= $form->field($model, 'dependent')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => TRUE])->textInput(['disabled' => 'disabled'])->label(false); ?>
                                        </div>

                                        <div class="col-md-2 col-sm-6 col-xs-6">
                                            <?= Html::button('<i class="fa fa-search"></i>  ', ['value' => Url::to(['klinikpanel/family-listpemohon', 'id' => $id]), 'class' => 'mapBtn btn btn-success']); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="5">Justifikasi Permohonan:<span class="required" style="color:red;">*</span></td>
                                    <td colspan="5">
                                        <div class="col-md-12 col-sm-12 col-xs-10">
                                            <?= $form->field($model, 'entry_remarks')->textArea(['maxlength' => true, 'rows' => 8, 'disabled' => TRUE])->label(false); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="5">Pegawai Peraku:</td>
                                    <td colspan="5">
                                        <div class="col-md-12 col-sm-12 col-xs-10">
                                            <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo ($model->verify_by == '700827125563') ? 'Professor Madya Dr. RAMAN B. NOORDIN' : $model->verifier->CONm; ?>" disabled />
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td valign="5">Pegawai Pelulus:</td>
                                    <td colspan="5">
                                        <div class="col-md-12 col-sm-12 col-xs-10">
                                            <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo ($approver->pelulus_icno) ? $approver->pelulus->CONm : 'Terus kepada Pegawai Memperaku'; ?>" disabled />
                                        </div>
                                    </td>
                                </tr>
                        </table>

                        <div class="x_title">
                            <h2><i class="fa fa-book"></i><strong> PERAKUAN KETUA JABATAN</strong></h2>

                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>

                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perakuan<span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'status')->label(false)->widget(Select2::classname(), [
                                    'data' => ['1' => 'DIPERAKU', '4' => 'TIDAK DIPERAKU'],
                                    'options' => [
                                        'placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                                        'onchange' => 'javascript:if ($(this).val() == "4"){
                                            $("#status").show();$("#status1").hide();
                                            }
                                            else if($(this).val() == "1"){
                                            $("#status1").show();$("#status").hide();}
                                            
                                            else{$("#status").hide();$("#status1").hide()
                                            }'
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                            
                                           
                                        ]); ?>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan<span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'verify_remarks')->textArea(['maxlength' => true, 'rows' => 2])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group" id="status" style="display: none" align="center"> 
                            <table>
                                <tr>
                                    <td class="col-sm-3 text-right">
                                        <?= $form->field($model, 'checkbox')->checkBox(['label' => '', 'data-size' => 'small', 'class' => 'bs_switch', 'margin-bottom:4px;', 'id' => 'checkbox1', 'onclick' => "checkTerms()"]) ?>
                                    </td>

                                    <td class="text-center">
                                        <div style="width: 800px; height: 90px;border:2px solid burlywood">
                                            <h5 style="color:black;"><br>
                                                &nbsp; Saya tidak bersetuju untuk memperaku permohonan peruntukan yang dipohon. <p>
                                            </h5>
                                            <strong>
                                                <p style="color:black;">
                                                    <center>Tarikh Peraku: <?php echo date('Y-m-d H:i:s'); ?>
                                                </p><br />
                                            </strong></center>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div class="form-group"  id="status1" style="display: none" align="center"> 
                            <table>
                                <tr>
                                    <td class="col-sm-3 text-right">
                                        <?= $form->field($model, 'checkboxs')->checkBox(['label' => '', 'data-size' => 'small', 'class' => 'bs_switch', 'margin-bottom:4px;', 'id' => 'checkbox2', 'onclick' => "checkTermss()"]) ?>
                                    </td>

                                    <td class="text-center">
                                        <div style="width: 800px; height: 90px;border:2px solid burlywood">
                                            <h5 style="color:black;"><br>
                                                &nbsp; Saya bersetuju untuk memperaku permohonan peruntukan yang dipohon. <p>
                                            </h5>
                                            <strong>
                                                <p style="color:black;">
                                                    <center>Tarikh Peraku: <?php echo date('Y-m-d H:i:s'); ?>
                                                </p><br />
                                            </strong></center>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </div>

                        <div class="ln_solid"></div>

                        <div class="customer-form">
                            <div class="form-group" align="center">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <br>
                                    <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) 
                                    ?>
                                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['id' => 'submitb', 'disabled' => true, 'class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                </div>
                            </div>
                        </div>


                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("foo").onchange = function() {
        if (this.selectedIndex !== 0) {
            window.location.href = this.value;
        }
    };
</script>

<script>
    function checkTerms() {
        // Get the checkbox
        var checkBox = document.getElementById("checkbox1");

        // If the checkbox is checked, display the output text
        if (checkBox.checked === true) {
            document.getElementById("submitb").disabled = false;
        } else {
            document.getElementById("submitb").disabled = true;
        }
    }
</script>
<script>
    function checkTermss() {
        // Get the checkbox
        var checkBox = document.getElementById("checkbox2");

        // If the checkbox is checked, display the output text
        if (checkBox.checked === true) {
            document.getElementById("submitb").disabled = false;
        } else {
            document.getElementById("submitb").disabled = true;
        }
    }
</script>