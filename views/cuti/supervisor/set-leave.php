<?php

use app\models\cuti\Layak;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\widgets\DetailView;

?>

    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="alert alert-success alert-dismissible " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <strong>Info!</strong> Lantikan Sementara, Lantikan Kontrak dan Lantikan Kontrak Jabatan Tidak Dikira Sebagai Lantikan Pertama.
            </div>
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong> Senarai Kelayakan Cuti Rehat / <i>Entitlement List</i></strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div style="text-align:left; float:right; width:5%;">
                    <a href="<?= Url::to(['cuti/supervisor/set-leave', 'id' => $id]); ?>" class="fa fa-calendar-check-o"></a>
                    <a href="<?= Url::to(['cuti/supervisor/leave-list-sv', 'id' => $id]); ?>" class="fa fa-calendar-plus-o"></a>
                    <a href="<?= Url::to(['cuti/supervisor/leave-statement', 'id' => $id]); ?>" class="fa fa-file"></a>
                </div>

                <?php echo Yii::$app->controller->renderPartial('_staff_details', ['biodata' => $biodata,]); ?>

                <div class="clearfix">
                    <span class="badge" style="background-color :pink;font-size: 100%"><u><?= Html::a('[Tambah Kelayakan Cuti Rehat / Set New Entitlement]', ["cuti/supervisor/set-entitlement", 'id' =>  $id]) ?>
                        </u></span>
                    <span style="font-size: 100%;float:right;">
                    <?php if ($bsm && (Layak::getTotalGcrA($id, 0)) > 150 ) { ?>
                                <?= Html::a('<i class="fa fa-pencil"></i> Penyelarasan', ['cuti/supervisor/penyelarasan', 'icno' => $id], ['class' => 'btn btn-default', 'target' => '_blank']) ?>

                            <?php } ?>

                        <?= Html::a('<i class="fa fa-print"></i> Print', ['cuti/supervisor/print-entitlement-statement', 'id' => $id], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                    </span>
                    <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
                        <thead>
                            <!-- <tr class="headings"> -->
                            <th class="column-title text-center">Start</th>
                            <th class="column-title text-center">End</th>
                            <th class="column-title text-center">BCTL</th>
                            <th class="column-title text-center">Entitlement</th>
                            <th class="column-title text-center">Total(Adjustment Included)</th>
                            <th class="column-title text-center">Leave Taken</th>
                            <th class="column-title text-center">Bal</th>
                            <th class="column-title text-center">CBTH</th>
                            <th class="column-title text-center">GCR</th>
                            <th class="column-title text-center">Lupus</th>
                            <th class="column-title text-center">Manually Applied</th>
                            <th class="column-title text-center">Remark</th>
                            <th class="column-title text-center">Action</th>
                            <!-- </tr> -->
                        </thead>
                        <?php foreach ($layak as $v) { ?>
                            <!-- <div class="tile-stats" style="padding:10px"> -->

                            <tr class='text-center'>
                                <td class='text-center'><?= $v->layakMulaDmy ?></td>
                                <td class='text-center'><?= $v->layakTamatDmy ?></td>
                                <td class='text-center'><?= $v->layak_bawa_lepas ?></td>
                                <td class='text-center'><?= $v->layak_cuti ?></td>
                                <td class='text-center'><?= $v->layak_bawa_lepas + $v->layak_cuti + $v->layak_selaras ?></td>
                                <td class='text-center'><?= ($v->layak_bawa_lepas + $v->layak_cuti + $v->layak_selaras) - (Layak::getBakiOld($id, $v->layak_mula, $v->layak_tamat)) ?></td>
                                <td class='text-center'><?= Layak::getBakiOld($id, $v->layak_mula, $v->layak_tamat) -  ($v->layak_bawa_depan +  $v->layak_gcr +  $v->layak_hapus) ?></td>
                                <td class='text-center'><?= $v->layak_bawa_depan ?></td>
                                <td class='text-center'><?= $v->layak_gcr ?></td>
                                <td class='text-center'><?= $v->layak_hapus ?></td>
                                <td class='text-center'><?= $v->layak_selaras ?></td>
                                <td class='text-center'><?= $v->catatan ?></td>

                                <?php if ($bsm) { ?>
                                    <td class="text-center"><?= Html::a('', ["cuti/supervisor/update-entitlement", 'id' =>  $v->layak_id], ['class' => 'fa fa-pencil']) ?>
                                        | <?= Html::a('', ["cuti/supervisor/delete-layak", 'id' =>  $v->layak_id, 'icno' => $v->layak_icno], ['class' => 'fa fa-trash', 'data' => ['confirm' => 'Are you sure to delete this Entitlement record?']]) ?>
                                        | <?= Html::a('GCR', ["cuti/supervisor/adjust-gcr", 'id' =>  $v->layak_id, 'icno' => $v->layak_icno], ['class' => 'fa fa-edit']) ?>
                                        | <?= Html::a('Remark', ["cuti/supervisor/remark", 'id' =>  $v->layak_id, 'icno' => $v->layak_icno]) ?></td>

                                <?php } else { ?>

                                    <?php
                                    $yr = strtotime(date('Y-m-d') . '-1 year');
                                    $yr2 = strtotime(date('Y-m-d') . '-2 year');
                                    $dt = date('Y', $yr);
                                    $dt2 = date('Y', $yr2);
                                    $date = DateTime::createFromFormat("Y-m-d", $v->layak_mula);
                                    $date->format("Y");

                                    if ($curr == $date->format("Y") || $date->format("Y") == $dt || $date->format("Y") > $curr) { ?>
                                        <td class="text-center"><?= Html::a('', ["cuti/supervisor/update-entitlement", 'id' =>  $v->layak_id], ['class' => 'fa fa-pencil']) ?>
                                            | <?= Html::a('', ["cuti/supervisor/delete-layak", 'id' =>  $v->layak_id, 'icno' => $v->layak_icno], ['class' => 'fa fa-trash', 'data' => ['confirm' => 'Are you sure to delete this Entitlement record?']]) ?></td>
                                    <?php } elseif ($biodata->statLantikan != 1) { ?>
                                        <?php if ($curr == $date->format("Y") || $date->format("Y") == $dt || $date->format("Y") == $dt2 || $date->format("Y") > $curr) { ?>
                                            <td class="text-center"><?= Html::a('', ["cuti/supervisor/update-entitlement", 'id' =>  $v->layak_id], ['class' => 'fa fa-pencil']) ?>
                                                | <?= Html::a('', ["cuti/supervisor/delete-layak", 'id' =>  $v->layak_id, 'icno' => $v->layak_icno], ['class' => 'fa fa-trash', 'data' => ['confirm' => 'Are you sure to delete this Entitlement record?']]) ?></td>
                                        <?php } else { ?>
                                            <td class="text-center"></td>
                                        <?php } ?>
                                        <!-- <td class="text-center"><?= Html::a('', ["cuti/supervisor/delete-layak", 'id' =>  $v->layak_id, 'icno' => $v->layak_icno], ['class' => 'fa fa-trash', 'data' => ['confirm' => 'Are you sure to delete this Entitlement record?']]) ?></td> -->
                                    <?php } else { ?>

                                        <td class="text-center"></td>
                                    <?php } ?>
                                <?php } ?>


                            </tr>

                        <?php } ?>
                        <tr class='text-center'>
                            <td colspan="8">Total GCR Before Adjustment</td>
                            <td><?= Layak::getTotalGcr($id, 0) ?></td>
                            <td colspan="4"></td>

                        </tr>
                        <tr class='text-center'>
                            <td colspan="8">Total GCR After Adjustment</td>
                            <td><?= Layak::getTotalGcrA($id, 0) ?></td>
                            <td colspan="4"></td>

                        </tr>

                    </table>
                </div>
                <div style='padding: 15px;' class="table-bordered">
                    <font>BCTL</font> : Baki Cuti Tahun Lepas &nbsp;&nbsp;&nbsp;&nbsp;
                    <font>CBTH</font> : Cuti Bawa Tahun Hadapan &nbsp;&nbsp;&nbsp;&nbsp;
                    <font>GCR</font> : Ganti Cuti Rehat

                </div>
            </div>
        </div>
   