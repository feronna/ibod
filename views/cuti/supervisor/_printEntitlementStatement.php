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

        <div class="x_panel">
            <div class="x_title">

                <h4><strong> Senarai Kelayakan Cuti Rehat / <i>Entitlement List</i></strong></h4>

                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <div class="table-responsive">
                    <?=
                    DetailView::widget([
                        'model' => $biodata,
                        'attributes' => [
                            [
                                'label' => 'Nama / Name',
                                'attribute' => 'CONm',
                            ],
                            [
                                'label' => 'ICNO/Passport',
                                'attribute' => 'ICNO',
                            ],
                            [
                                'label' => 'UMSPER',
                                'attribute' => 'COOldID',
                                'contentOptions' => ['style' => 'width:auto'],
                                'captionOptions' => ['style' => 'width:26%'],
                            ],
                            [
                                'label' => 'Jawatan / Position',
                                'attribute' => 'jawatan.fname',
                                'contentOptions' => ['style' => 'width:auto'],
                                'captionOptions' => ['style' => 'width:26%'],
                            ],
                            [
                                'label' => 'JFPIB',
                                'attribute' => 'department.fullname',
                                'contentOptions' => ['style' => 'width:auto'],
                                'captionOptions' => ['style' => 'width:26%'],
                            ],
                            [
                                'label' => 'Jenis Lantikan / Appointment Type',
                                'attribute' => 'displaystatuslantikan',
                                'contentOptions' => ['style' => 'width:auto'],
                                'captionOptions' => ['style' => 'width:26%'],
                            ],
                            [
                                'label' => 'Tarikh Lantikan / Appointment Date',
                                'attribute' => 'displaystarttoendlantik',
                                'contentOptions' => ['style' => 'width:auto'],
                                'captionOptions' => ['style' => 'width:26%'],
                            ],
                            [
                                'label' => 'Status',
                                'attribute' => 'displayservicestatus',
                                'contentOptions' => ['style' => 'width:auto'],
                                'captionOptions' => ['style' => 'width:26%'],
                            ],

                        ],
                    ])
                    ?>
                </div>
            </div>

            <div class="clearfix">

                <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
                    <tr class="headings">
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
                        <th class="column-title text-center">Adjustment</th>
                        <th class="column-title text-center">Remark</th>
                    </tr>

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