<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\kehadiran\RefWp;
//use dosamigos\datepicker\DatePicker;
use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblRollcall;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use app\widgets\TopMenuWidget;
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-search"></i> Search</strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?= Html::beginForm(['ringkasan-laporan'], 'GET'); ?>

                    <strong>Syif :</strong>

                    <?= Html::dropDownList('syif', $syif, ['A' => 'A', 'B' => 'B', 'C' => 'C'], ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                    <br>
                    <br>
                    <strong>Tarikh :</strong>

                    <?=
                        DatePicker::widget([
                            'name' => 'tarikh',
                            'value' => $todaydt,
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'removeIcon' => '<i class="fa fa-trash text-danger"></i>',
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>
                    <br>
                    <br>
                    <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                    <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
                    <?= Html::endForm(); ?>

                </div>
            </div>
        </div>
    </div>

    <?php if ($var != null || $thb != null || $thh != null || $thlmj != null || $thlmt != null) { ?>

        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-users"></i> Pegawai Bertugas Bertugas</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="w0" class="form-horizontal form-label-left" action="/basic/web/index.php?r=kehadiran%2Fremark&amp;id=51" method="post">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama :
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group field-tblrekod-tarikh">

                                        <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $do_name->CONm ?>" disabled="">

                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pengganti Pegawai Bertugas(Jika Ada) :
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group field-tblrekod-tarikh">

                                        <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $p ?>" disabled="">

                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh :
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group field-tblrekod-tarikh">

                                        <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $tarikh ?>" disabled="">

                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Syif/Kawalan :
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group field-tblrekod-tarikh">

                                        <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $syif ?>" disabled="">

                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">

            <div class="x_panel">

                <div class="x_title">

                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
                    <div class="form-group">
                        <h6><strong></i> Laporan Odometer Kenderaan(Sekiranya ada) : </strong></h6>
                        <div class="col-md-3 col-sm-3 col-xs-12 ">

                            <?= $form->field($model2, 'plate_num')->textInput()->input('plate_num', ['placeholder' => "Nombor Plate Kenderaan"])->label(false); ?>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 ">

                            <?= $form->field($model2, 'start_odo')->textInput()->input('start_odo', ['placeholder' => "Masukkan Odometer Mula"])->label(false); ?>
                            <?= $form->field($model2, 'end_odo')->textInput()->input('start_odo', ['placeholder' => "Masukkan Odometer Tamat"])->label(false); ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <h6><strong></i> Ulasan Penyelia Bertugas : </strong></h6>

                        <?= $form->field($model, 'laporan')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Hantar', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait.. ']]) ?>
                            <button class="btn btn-primary" type="reset">Reset</button>

                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <br>
                    </br>
                    <h2><strong><i class="fa fa-list"></i> Ringkasan Laporan Kehadiran</strong></h2>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 col-md-12 col-lg-12">
                    </div>
                    <div class="x_content">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm jambo_table table-bordered">
                                <thead>
                                    <tr class="headings">
                                        <th class="text-center">Bil</th>
                                        <th class="text-center">Nama Anggota</th>
                                        <th class="text-center">Pos Kawalan</th>
                                        <th class="text-center">Jenis Tugas </th>
                                        <th class="text-center">Jenis Kesalahan</th>
                                        <th class="text-center">Catatan</th>


                                    </tr>
                                </thead>
                                <!-- THH -->

                                <?php foreach ($thh as $k) { ?>
                                    <tr>
                                        <td class="text-center" style="text-align:center"><?= $bil++ ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->staff->CONm ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::Syif($k->staff->ICNO, Yii::$app->getRequest()->getQueryParam('tarikh')); ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->type ?></td>
                                        <td class="text-center" style="text-align:center"><?php
                                                                                            if ($k->THH == '1') {
                                                                                                echo 'THH';
                                                                                            } elseif ($k->THLMJ == '1') {
                                                                                                echo 'THLMJ';
                                                                                            } elseif ($k->THLMT == '1') {
                                                                                                echo 'THLMT';
                                                                                            }
                                                                                            ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->catatan ?></td>


                                    </tr>
                                <?php } ?>

                                <!-- THLMJ -->

                                <?php foreach ($thlmj as $k) { ?>
                                    <tr>
                                        <td class="text-center" style="text-align:center"><?= $bil++ ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->staff->CONm ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::Syif($k->staff->ICNO, Yii::$app->getRequest()->getQueryParam('tarikh')); ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->type ?></td>
                                        <td class="text-center" style="text-align:center"><?php
                                                                                            if ($k->THH == '1') {
                                                                                                echo 'THH';
                                                                                            } elseif ($k->THLMJ == '1') {
                                                                                                echo 'THLMJ';
                                                                                            } elseif ($k->THLMT == '1') {
                                                                                                echo 'THLMT';
                                                                                            }
                                                                                            ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->catatan ?></td>

                                    </tr>
                                <?php } ?>

                                <!-- THLMT -->

                                <?php foreach ($thlmt as $k) { ?>
                                    <tr>
                                        <td class="text-center" style="text-align:center"><?= $bil++ ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->staff->CONm ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::Syif($k->staff->ICNO, Yii::$app->getRequest()->getQueryParam('tarikh')); ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->type ?></td>
                                        <td class="text-center" style="text-align:center"><?php
                                                                                            if ($k->THH == '1') {
                                                                                                echo 'THH';
                                                                                            } elseif ($k->THLMJ == '1') {
                                                                                                echo 'THLMJ';
                                                                                            } elseif ($k->THLMT == '1') {
                                                                                                echo 'THLMT';
                                                                                            }
                                                                                            ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->catatan ?></td>

                                    </tr>
                                <?php } ?>


                            </table>
                        </div>
                    </div>
                    <!--THB-->
                    <div class="x_content">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm jambo_table table-bordered">
                                <thead>
                                    <tr class="headings">
                                        <th class="text-center">Bil</th>
                                        <th class="text-center">Nama Anggota</th>
                                        <th class="text-center">Pos Kawalan</th>
                                        <th class="text-center">Jenis Tugas(H/LMJ/LMT/KAWALAN)</th>
                                        <th class="text-center">Masa Masuk Tugas</th>
                                        <th class="text-center">Catatan</th>

                                    </tr>
                                </thead>
                                <?php foreach ($thb as $k) { ?>
                                    <tr>
                                        <td class="text-center" style="text-align:center"><?= $bil++ ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->staff->CONm ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::Syif($k->staff->ICNO, Yii::$app->getRequest()->getQueryParam('tarikh')); ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->type ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->masa_masuk_tugas ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->catatan ?></td>

                                    </tr>
                                <?php } ?>

                            </table>
                        </div>

                    </div>
                    <!--end of ringkasan-->

                    <!--start of kekuatan anggota dan odometer-->
                    <div class="x_title">
                        <h2><strong><i class="fa fa-list"></i> Jumlah Kehadiran</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm jambo_table table-bordered">
                                <thead>
                                    <tr class="headings">
                                        <th class="text-center">Kakitangan Jadual</th>
                                        <th class="text-center">Tidak Hadir</th>
                                        <th class="text-center">(+)LMT</th>
                                        <th class="text-center">(+)Tukar Syif</th>
                                        <th class="text-center">Jumlah Hadir</th>
                                    </tr>
                                </thead>

                                <tr>
                                    <td class="text-center" style="text-align:center"><?= $jumlah ?></td>
                                    <td class="text-center" style="text-align:center"><?= $Thadir ?></td>
                                    <td class="text-center" style="text-align:center"></td>
                                    <td class="text-center" style="text-align:center"></td>
                                    <td class="text-center" style="text-align:center"><?= $hadir ?></td>

                                </tr>

                            </table>
                        </div>
                    </div>

                    <div class="x_title">
                        <h2><strong><i class="fa fa-list"></i> Bacaan Odometer Kenderaan</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm jambo_table table-bordered">
                                <thead>
                                    <tr class="headings">
                                        <th class="text-center">No Plate</th>
                                        <th class="text-center">Akhir</th>
                                        <th class="text-center">Mula</th>
                                        <th class="text-center">Jumlah Jarak (KM)</th>
                                    </tr>
                                </thead>
                                <?php foreach ($odometer as $k) { ?>
                                    <tr>
                                        <td class="text-center" style="text-align:center"><?= $k->plate_num ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->end_odo ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->start_odo ?></td>
                                        <td class="text-center" style="text-align:center"><?= $k->distance ?></td>

                                    </tr>
                                <?php } ?>


                            </table>
                        </div>
                    </div>
                    <div class="x_title">
                        <h2><strong><i class="fa fa-list"></i> Ulasan Pegawai Bertugas</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm jambo_table table-bordered">
                                <thead>
                                    <tr class="headings">
                                        <th class="text-center">Ulasan</th>
                                        <th class="text-center">Kemaskini</th>

                                    </tr>
                                </thead>
                                <?php foreach ($ulasan as $k) { ?>
                                    <tr>
                                        <td class="text-center" style="text-align:left"><?= $k->laporan ?></td>
                                        <td class="text-center" style="text-align:center"><?= Html::button('', ['value' => Url::to([
									'/keselamatan/update-ulasan', 'id' => Yii::$app->user->identity->ICNO, 'syif' => Yii::$app->getRequest()->getQueryParam('syif'),
									'date' => Yii::$app->getRequest()->getQueryParam('tarikh')
								]), 'class' => 'fa fa-edit mapBtn ', 'id' => 'modalButton']);?></td>

                                    </tr>
                                <?php } ?>


                            </table>
                        </div>
                    </div>
                    <div class="x_panel">
                        <div class="form-group">

                            <div class="div1" style="text-align:left; float:left; width:40%;">
                                <input type="text" class="form-control" value="<?= $s_name . ' ' . $s_date ?>" disabled="">

                                <?php if ($v_sender) { ?>
                                    <label style="text-align:center;" class="control-label c    ol-md-6 col-sm-6 col-xs-12">Pegawai Bertugas</label>

                                <?php } else { ?>
                                    <label style="text-align:center;" class="control-label col-md-6 col-sm-6 col-xs-12">

                                        <?php echo Html::a('Klik Untuk Hantar Laporan', [
                                            '/keselamatan/send-to-verify', 'id' => Yii::$app->user->identity->ICNO, 'syif' => Yii::$app->getRequest()->getQueryParam('syif'),
                                            'date' => Yii::$app->getRequest()->getQueryParam('tarikh')
                                        ], ['name' => 'verify', 'class' => 'text', 'data' => ['confirm' => 'Anda Pasti untuk menghantar Laporan Kepada Pegawai Medan?? Anda Tidak akan Dapat Mengubah Laporan dan Rollcall dalam Manual Rollcall dan Rollcall untuk Syif Dan Tarikh Ini Selepas Laporan Ini Dihantar?']]) ?></label>
                                <?php } ?>
                            </div>


                        </div>
                    </div>
                    <div class="x_title">
                        <h2><strong><i class="fa fa-list"></i> Ulasan Pegawai Medan</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm jambo_table table-bordered">
                                <thead>
                                    <tr class="headings">
                                        <th class="text-center">Ulasan</th>

                                    </tr>
                                </thead>
                                <tr>
                                    <td class="text-center" style="text-align:left"><?= $pm ?></td>

                                </tr>


                            </table>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="form-group">


                            <div class="div1" style="text-align:right; float:left; width:35%;">
                                <?php if ($verifier) { ?>
                                    <input type="text" class="form-control" value="<?= $v_name . ' ' . $v_date ?>" disabled="">

                                <?php } else if ($verifier == "") { ?>
                                    <input style="text-align:center" type="text" class="form-control" value="" disabled="">


                                <?php } else { ?>
                                    <input style="text-align:center" type="text" class="form-control" value="Menunggu Pengesahan" disabled="">

                                <?php } ?>

                                <label style="text-align:center;" class="control-label col-md-6 col-sm-6 col-xs-12">Pegawai Medan
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>
        </div>


    <?php } ?>