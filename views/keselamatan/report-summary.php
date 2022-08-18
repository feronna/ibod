<?php

use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblRollcall;
use app\widgets\TopMenuWidget;
use yii\helpers\Url;
?>


<?= $this->render('/keselamatan/_topmenu') ?>

    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong> Ringkasan Kehadiran Dan Laporan Rondaan Pegawai Bertugas/Penyelia</strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="4" class="text-center">Nama</th>
                                    <th colspan="4" class="text-center"></th>
                                    <th colspan="2" class="text-center">Syif</th>
                                    <th colspan="5" class="text-center">Tarikh</th>
                                </tr>
                                <tr class="headings">
                                    <th class="text-center">Bil</th>
                                    <th class="text-center">Unit/Pos</th>
                                    <th class="text-center">KKTN</th>
                                    <th class="text-center">JAD</th>
                                    <th class="text-center">TH</th>
                                    <th class="text-center">LMT</th>
                                    <th class="text-center">T/SYIF(IN)</th>
                                    <th class="text-center">T/SYIF(OUT)</th>
                                    <th class="text-center">JUM HADIR</th>
                                    <th class="text-center">TINDAKAN</th>
                                    <th colspan="2" class="text-center">JUM KEKUATAN</th>
                                    <th colspan="2" class="text-center">MASA RONDA</th>
                                    <th colspan="2" class="text-center">CATATAN</th>

                                </tr>
                            </thead>
                            <?php foreach ($var1 as $v) { ?>
                            <tr>

                                <td class="text-center"  style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center"  style="text-align:center"><?= $v->unit_name ?></td>
                            </tr>
                        <?php } ?>
                            <?php foreach ($var as $v) { ?>
                            <tr>

                                <td class="text-center"  style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center"  style="text-align:center"><?= $v->unit_name ?></td>
                            </tr>
                        <?php } ?>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
