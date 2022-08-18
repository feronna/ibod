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
            <h2><strong><i class="fa fa-list"></i> Kemaskini Status Permohonan Penambahan Peruntukan MyHealth</strong></h2>
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
            <div class="col-md-6">
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
                                    <th scope="col" colspan=12" style="background-color:teal; color:white">
                                        <center>
                                            <h5><strong>MAKLUMAT PERUNTUKAN TAHUN <?= date('Y') ?></h5></strong>
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
                                        <td valign="5">Rekod Penambahan Peruntukan(RM):<span class="required" style="color:red;">*</span></td>
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
                                        <td valign="5">Jumlah Dipohon (RM):<span class="required" style="color:red;">*</span></td>
                                        <td colspan="5">
                                            <div class="col-md-12 col-sm-12 col-xs-10">
                                                <?= $form->field($model, 'jumlah_mohon')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => TRUE])->textInput(['disabled' => 'disabled'])->label(false); ?>
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
                                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo ($model->verify_by == '680114125023') ? 'Prof. Datuk ChM. Ts. Dr. TAUFIQ YAP YUN HIN' : $model->verifier->CONm; ?>" disabled />
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



                    </div>
                </div>

                <div class="x_title">
                    <h2><i class="fa fa-book"></i><strong>PERAKUAN KETUA JABATAN</strong></h2>

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
                        <?= $form->field($model, 'status_ver')->label(false)->widget(Select2::classname(), [
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
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'verify_remarks')->textArea(['maxlength' => true, 'rows' => 2, 'disabled' => TRUE])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Diperaku Pada</label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'verify_dt')->textArea(['maxlength' => true, 'rows' => 2, 'disabled' => TRUE])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Diperaku Oleh</label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model->verifier, 'CONm')->textArea(['maxlength' => true, 'rows' => 2, 'disabled' => TRUE])->label(false); ?>
                    </div>
                </div>
                <div class="x_title">
                    <h2><i class="fa fa-check-square"></i><strong> SEMAKAN BAHAGIAN SUMBER MANUSIA</strong></h2>

                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>

                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'status_check')->label(false)->widget(Select2::classname(), [
                            'data' => ['2' => 'SEMAKAN LAYAK', '4' => 'SEMAKAN TIDAK LAYAK'],
                            'options' => [
                                'placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                                'onchange' => 'javascript:if ($(this).val() == "Dipersetujui"){
                        $("#tempoh").show();
                        }
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'check_remarks')->textArea(['maxlength' => true, 'rows' => 2])->label(false); ?>
                    </div>
                </div>
                <div class="x_title">
                    <h2><i class="fa fa-check-square"></i><strong> PERAKUAN BAHAGIAN SUMBER MANUSIA (KETUA BSM)</strong></h2>
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
                        <?= $form->field($model, 'status_verifybsm')->label(false)->widget(Select2::classname(), [
                            'data' => ['5' => 'DIPERAKU', '4' => 'TIDAK DIPERAKU'],
                            'options' => [
                                'placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],


                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'verifybsm_remarks')->label(false)->widget(Select2::classname(), [
                            'data' => ['Permohonan Mematuhi Garis Panduan' => 'Permohonan Mematuhi Garis Panduan', 'Tidak Mematuhi Garis Panduan' => 'Tidak Mematuhi Garis Panduan'],
                            'options' => [
                                'placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12',

                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],


                        ]); ?>
                    </div>
                </div>
                <div class="x_title">
                    <h2><i class="fa fa-check-square"></i><strong> KELULUSAN PENDAFTAR</strong></h2>

                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>

                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kelulusan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'status_app')->label(false)->widget(Select2::classname(), [
                            'data' => ['3' => 'DILULUSKAN', '4' => 'TIDAK DILULUSKAN'],
                            'options' => [
                                'placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],


                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'app_remarks')->label(false)->widget(Select2::classname(), [
                            'data' => ['Permohonan Diluluskan' => 'Permohonan Diluluskan', 'Permohonan Tidak Diluluskan' => 'Permohonan Tidak Diluluskan'],
                            'options' => [
                                'placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12',

                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],


                        ]); ?>
                    </div>
                </div>
                <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Dipohon<span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?php echo '<span class="btn btn-primary">RM '.$model->jumlah_mohon.'</span>' ?>
                        </div>
                    </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Diluluskan (RM)<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?php
                        echo
                        $form->field($model, 'app_amount')->label(false)->widget(Select2::classname(), [
                            'data' => ['1000.00' => '1000.00', '750.00' => '750.00', '500.00' => '500.00', '375.00' => '375.00', '250.00' => '250.00', '0.00' => '0.00'],
                            'options' => [
                                'placeholder' => 'Sila Pilih Amaun Penambahan', 'class' => 'form-control col-md-7 col-xs-12'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);

                        ?>
                    </div>
                </div>
                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
</div>