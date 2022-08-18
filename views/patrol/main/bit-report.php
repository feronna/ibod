<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\kehadiran\RefWp;
use dosamigos\datepicker\DatePicker;
use app\models\kehadiran\TblRekod;
use app\models\patrol\PatrolTblReport;
use app\models\patrol\RefBit;
use app\models\patrol\Rekod;
use yii\helpers\Url;
?>

<?= $this->render('/patrol/_menu') ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-users"></i> Staff's detail</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="w0" class="form-horizontal form-label-left" action="/basic/web/index.php?r=kehadiran%2Fremark&amp;id=51" method="post">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->CONm ?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Syif
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= Rekod::viewsyif($shift) ?>" disabled="">


                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pos
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= Rekod::viewPos($pos) ?>" disabled="">


                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Anggota Sama Syif
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?php foreach (Rekod::partner($icno, $date, $shift, $pos) as $syif) {
                                                                                                                                                            //    var_dump($syif);die;
                                                                                                                                                            echo Rekod::kakitangan($syif['icno']);
                                                                                                                                                        } ?>" disabled="">


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
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Laporan Rondaan</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <br>
                <?= PatrolTblReport::remark($icno, $date, $pos, $shift, 0) ? "" :

                    Html::a('<i class="fa fa-plus"></i> Catatan Tamat Bertugas', ['patrol/main/patroller-report', 'shift' => $shift, 'pos' => $pos, 'date' => $date], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>

                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Rondaan</th>
                                <th class="text-center">Masa Mula</th>
                                <th class="text-center">Masa Tamat</th>
                                <th class="text-center">Jumlah Masa Rondaan (Jam : Min)</th>
                                <?php foreach ($nbit as $k) { ?>

                                    <th class="text-center" style="text-align:left"><?= 'Bit' . $k ?></th>

                                <?php } ?>
                                <th class="text-center">Laporan Setiap Rondaan</th>

                            </tr>
                        </thead>
                        <?php foreach ($data as $k => $v) { ?>

                            <tr>
                                <td class="text-center" style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center" style="text-align:left"><?= $v ?></td>
                                <td class="text-center" style="text-align:left"><?= Rekod::display($icno, $pos, $shift, $k, $date, 2) ?></td>
                                <td class="text-center" style="text-align:left"><?= Rekod::display($icno, $pos, $shift, $k, $date, 3) ?></td>
                                <td class="text-center" style="text-align:centert"><?= Rekod::countpatroltime($icno, $pos, $shift, $k, $date) ?></td>
                                <?php foreach ($nbit as $b) { ?>

                                    <td class="text-center" style="text-align:left"><?= Rekod::displaytime($icno, $pos, $shift, $b, $k, $date) ?></td>

                                <?php } ?>
                                <td>
                                    <?= PatrolTblReport::remark($icno, $date, $pos, $shift, ($k + 1)) ? PatrolTblReport::remark($icno, $date, $pos, $shift, ($k + 1)) :
                                        Html::a('<i class="fa fa-edit"></i>', ['patrol/main/patroller-report', 'shift' => $shift, 'pos' => $pos, 'date' => $date, 'count' => ($k + 1)]);
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>

                    </table>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-4">

                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <tr>
                            <td style='background-color : orange' class="text-left"><b>Jumlah Rondaan </b></td>
                            <td class="text-center"><?= Rekod::countpatrol($icno, $date, $shift) ?> / <?= RefBit::patroltotal($pos, $shift, $icno, $date) ?></td>

                        </tr>

                        <!-- <body>
                        <tr>
                                <td>Rondaan</td>
                            </tr>
                        </body> -->
                    </table>

                </div>
                <div class="col-xs-12 col-md-8 col-lg-8">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <tr>
                            <td class="text-center"><?= PatrolTblReport::getreport($icno, $pos, $shift, $date) ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= PatrolTblReport::getreportdo($icno, $pos, $shift, $date) ?></td>

                        </tr>


                    </table>

                </div>

            </div>

            <div class="x_content">

                <?php if ($tukarpos) { ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <div class="x_panel">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pos Diarahkan Bertugas
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <div class="form-group field-tblrekod-tarikh">

                                            <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= Rekod::viewPos($tukarpos->pos_baru) ?>" disabled="">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Bil</th>
                                    <th class="text-center">Rondaan</th>
                                    <th class="text-center">Masa Mula</th>
                                    <th class="text-center">Masa Tamat</th>
                                    <th class="text-center">Jumlah Masa Rondaan (Jam : Min)</th>
                                    <?php foreach ($nbit as $k) { ?>

                                        <th class="text-center" style="text-align:left"><?= 'Bit' . $k ?></th>

                                    <?php } ?>
                                    <th class="text-center">Laporan Setiap Rondaan</th>

                                </tr>
                            </thead>
                            <?php foreach ($data as $k => $v) { ?>

                                <tr>
                                    <td class="text-center" style="text-align:center"><?= $bil++ ?></td>
                                    <td class="text-center" style="text-align:left"><?= $v ?></td>
                                    <td class="text-center" style="text-align:left"><?= Rekod::display($icno, $pos, $shift, $k, $date, 2) ?></td>
                                    <td class="text-center" style="text-align:left"><?= Rekod::display($icno, $pos, $shift, $k, $date, 3) ?></td>
                                    <td class="text-center" style="text-align:centert"><?= Rekod::countpatroltime($icno, $pos, $shift, $k, $date) ?></td>
                                    <?php foreach ($nbit as $b) { ?>

                                        <td class="text-center" style="text-align:left"><?= Rekod::displaytime($icno, $pos, $shift, $b, $k, $date) ?></td>

                                    <?php } ?>
                                    <td>
                                        <?= PatrolTblReport::remark($icno, $date, $tukarpos->pos_baru, $shift, ($k + 1)) ? PatrolTblReport::remark($icno, $date, $tukarpos->pos_baru, $shift, ($k + 1)) :
                                            Html::a('<i class="fa fa-edit"></i>', ['patrol/main/patroller-report', 'shift' => $shift, 'pos' => $tukarpos->pos_baru, 'date' => $date, 'count' => ($k + 1)]);
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>

                        </table>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4">

                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <tr>
                                <td style='background-color : orange' class="text-left"><b>Jumlah Rondaan </b></td>
                                <td class="text-center"><?= Rekod::countpatrol($icno, $date, $shift) ?> / <?= RefBit::patroltotal($pos, $shift, $icno, $date) ?></td>

                            </tr>
                        </table>

                    </div>
                    <div class="col-xs-12 col-md-8 col-lg-8">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <tr>
                                <td class="text-center"><?= PatrolTblReport::getreport($icno, $pos, $shift, $date) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><?= PatrolTblReport::getreportdo($icno, $pos, $shift, $date) ?></td>

                            </tr>


                        </table>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>