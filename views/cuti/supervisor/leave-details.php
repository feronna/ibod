<?php

use app\models\cuti\TblRecords;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\widgets\DetailView;

?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Maklumat Cuti / <i>Leave Full Details</i></strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-striped table-sm jambo_table">

                        <thead>
                            <!-- <tr class="headings"> -->
                            <th colspan="2" class="column-title text-center">Leave Application Details</th>
                        </thead>

                        <tr>
                            <th width="40%" class="text-center">Nama / <i>Name</i></th>
                            <td class="text-left"><?= $biodata->CONm ?></td>
                        </tr>
                        <tr>
                            <th width="40%" class="text-center">Jawatan/ <i>Position</i></th>
                            <td class="text-left"><?= $biodata->jawatan->fname ?></td>
                        </tr>
                        <tr>
                            <th width="40%" class="text-center">JFPIB</th>
                            <td class="text-left"><?= $biodata->department->fullname ?></td>
                        </tr>
                        <tr>
                            <th width="40%" class="text-center">Tarikh Mula/ <i>Leave Start</i></th>
                            <td class="text-left"><?= $model->start_date ?></td>
                        </tr>
                        <tr>
                            <th width="40%" class="text-center">Tarikh End/ <i>Leave End</i></th>
                            <td class="text-left"><?= $model->end_date ?></td>
                        </tr>
                        <tr>
                            <th width="40%" class="text-center">Tempoh/ <i>Duration</i></th>
                            <td class="text-left"><?= $model->tempoh ?></td>
                        </tr>
                        <tr>
                            <th width="40%" class="text-center">Destinasi/ <i>Destination</i></th>
                            <td class="text-left"><?= $model->Destination ?></td>
                        </tr>
                        <tr>
                            <th width="40%" class="text-center">Jenis Cuti /<i>Leave Type</i></th>
                            <td class="text-left"><?= $model->jenisCuti->jenis_cuti_nama . ' - ' . $model->jenisCuti->jenis_cuti_catatan ?></td>
                        </tr>
                        <tr>
                            <th width="40%" class="text-center">Catatan / <i> Remark </i></th>
                            <td class="text-left"><?= $model->remark ?></td>
                        </tr>
                        <tr>
                            <th width="40%" class="text-center">Tarikh Mohon / <i> Apply Date </i></th>
                            <td class="text-left"><?= TblRecords::getTarikh($model->mohon_dt);  ?></td>
                        </tr>

                        <!-- </table>

                    <table class="table table-bordered table-condensed table-striped table-sm jambo_table"> -->

                        <thead>
                            <!-- <tr class="headings"> -->
                            <th colspan="2" class="column-title text-center">Substitute Information</th>
                        </thead>
                        <?php if (!$pengganti) { ?>

                            <tr>
                                <th width="40%" class="text-center">Nama / <i>Name</i></th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Jawatan/ <i>Position</i></th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">JFPIB</th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Status</th>
                                <td class="text-left"></td>
                            </tr>

                        <?php } else { ?>
                            <tr>
                                <th width="40%" class="text-center">Nama / <i>Name</i></th>
                                <td class="text-left"><?= $pengganti->CONm ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Jawatan/ <i>Position</i></th>
                                <td class="text-left"><?= $pengganti->jawatan->fname ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">JFPIB</th>
                                <td class="text-left"><?= $pengganti->department->fullname ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Status</th>
                                <td class="text-left"><?= $model->statuspengganti ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Tarikh / Date</th>
                                <td class="text-left"><?= TblRecords::getTarikh($model->ganti_dt);  ?></td>
                            </tr>




                            <!-- semakan BSM -->
                        

                        <?php } ?>
                        <thead>
                                <!-- <tr class="headings"> -->
                                <th colspan="2" class="column-title text-center">Verification</th>
                            </thead>
                        <?php if (!$semak) { ?>

                            <tr>
                                <th width="40%" class="text-center">Nama / <i>Name</i></th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Jawatan/ <i>Position</i></th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Catatan / <i>Remark</i></th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Status Semakan / <i>Verification Status</i></th>
                                <td class="text-left"></td>
                            </tr>
                        <?php } else { ?>

                            <tr>
                                <th width="40%" class="text-center">Nama / <i>Name</i></th>
                                <td class="text-left"><?= $semak->CONm ?></td>
                            </tr>
                           
                            <tr>
                                <th width="40%" class="text-center">Jawatan/ <i>Position</i></th>
                                <td class="text-left"><?= $semak->jawatan->fname ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Catatan / <i>Remark</i></th>
                                <td class="text-left"><?= $model->semakan_remark ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Status Semakan / <i>Verification Status</i></th>
                                <td class="text-left"><?= $model->status ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Tarikh Semak / Date</th>
                                <td class="text-left"><?= TblRecords::getTarikh($model->semakan_dt);  ?></td>
                            </tr>

                        <?php } ?>
                        <thead>
                            <!-- <tr class="headings"> -->
                            <th colspan="2" class="column-title text-center">Verifier Information</th>
                        </thead>
                        <?php if (!$peraku) { ?>
                            <tr>
                                <th width="40%" class="text-center">Nama / <i>Name</i></th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Jawatan/ <i>Position</i></th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">JFPIB</th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Status</th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Catatan Peraku/ <i>Verifier Remark</i></th>
                                <td class="text-left"></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <th width="40%" class="text-center">Nama / <i>Name</i></th>
                                <td class="text-left"><?= $peraku->CONm ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Jawatan/ <i>Position</i></th>
                                <td class="text-left"><?= $peraku->jawatan->fname ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">JFPIB</th>
                                <td class="text-left"><?= $peraku->department->fullname ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Status</th>
                                <td class="text-left"><?= $model->statusverifier ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Catatan Peraku/ <i>Verifier Remark</i></th>
                                <td class="text-left"><?= $model->peraku_remark ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Tarikh / Date</th>
                                <td class="text-left"><?= TblRecords::getTarikh($model->peraku_dt);  ?></td>
                            </tr>

                        <?php } ?>


                        <thead>
                            <!-- <tr class="headings"> -->
                            <th colspan="2" class="column-title text-center">Approver Information</th>
                        </thead>
                        <?php if (!$pelulus) { ?>

                            <tr>
                                <th width="40%" class="text-center">Nama / <i>Name</i></th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Jawatan/ <i>Position</i></th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">JFPIB</th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Status</th>
                                <td class="text-left"></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Catatan Pelulus/ <i>Approver Remark</i></th>
                                <td class="text-left"></td>
                            </tr>
                        <?php } else { ?>


                            <tr>
                                <th width="40%" class="text-center">Nama / <i>Name</i></th>
                                <td class="text-left"><?= $pelulus->CONm ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Jawatan/ <i>Position</i></th>
                                <td class="text-left"><?= $pelulus->jawatan->fname ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">JFPIB</th>
                                <td class="text-left"><?= $pelulus->department->fullname ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Status</th>
                                <td class="text-left"><?= $model->statusapprover ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Catatan Pelulus/ <i>Approver Remark</i></th>
                                <td class="text-left"><?= $model->lulus_remark ?></td>
                            </tr>
                            <tr>
                                <th width="40%" class="text-center">Tarikh / Date</th>
                                <td class="text-left"><?= TblRecords::getTarikh($model->lulus_dt);  ?></td>
                            </tr>

                        <?php } ?>

                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-striped table-sm jambo_table">

                        <thead>
                            <!-- <tr class="headings"> -->
                            <th colspan="5" class="column-title text-center">Leave Application Details</th>
                        </thead>
                        <thead>
                            <!-- <tr class="headings"> -->
                            <th class="column-title text-center">ID</th>
                            <th class="column-title text-center">LEAVE TYPE</th>
                            <th class="column-title text-center">START</th>
                            <th class="column-title text-center">END</th>
                            <th class="column-title text-center">DURATION</th>

                            <!-- </tr> -->
                        </thead>
                        <?php foreach ($dataProvider as $v) { ?>
                            <!-- <div class="tile-stats" style="padding:10px"> -->

                            <tr class='text-center'>
                                <td><?= $bil++ ?></td>
                                <td><?= $v->jenisCuti->jenis_cuti_nama ?></td>
                                <td><?= $v->start_date ?></td>
                                <td><?= $v->end_date ?></td>
                                <td><?= $v->tempoh ?></td>
                            </tr>

                        <?php } ?>
                    </table>

                </div>
            </div>
        </div>
    </div>