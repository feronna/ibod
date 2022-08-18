<?php

use app\models\cuti\Layak;
use app\models\cuti\SetPegawai;
use app\models\cuti\TblRecords;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Modal;


?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Carian/<i>Searching</i> </strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['leave-statement', 'id' => $id], 'GET'); ?>


                <?= Html::dropDownList('year', $year, $data, ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>

                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <?= Html::a('<i class="fa fa-print"></i> Print', ['cuti/supervisor/print-statement', 'id' => $id, 'year' => $year], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                <?= Html::endForm(); ?>

            </div>
            <div style="text-align:left; float:right; width:5%;">
                <a href="<?= Url::to(['cuti/supervisor/set-leave', 'id' => $id]); ?>" class="fa fa-calendar-check-o"></a>
                <a href="<?= Url::to(['cuti/supervisor/leave-list-sv', 'id' => $id]); ?>" class="fa fa-calendar-plus-o"></a>
                <a href="<?= Url::to(['cuti/supervisor/leave-statement', 'id' => $id]); ?>" class="fa fa-file"></a>
            </div>
            <?php if ($year != 0) { ?>

                <div class="clearfix">
                
                <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
                    <thead>
                        <!-- <tr class="headings"> -->
                        <th class="column-title text-center" width="auto">Entitlement Date</th>
                        <th class="column-title text-center">BCTL</th>
                        <th class="column-title text-center">Entitlement</th>
                        <th class="column-title text-center">Total</th>
                        <th class="column-title text-center">Leave Start to End</th>
                        <!-- <th class="column-title text-center">Leave End</th> -->
                        <th class="column-title text-center">Duration</th>
                        <th class="column-title text-center">Increment</th>
                        <th class="column-title text-center">Balance</th>
                        <th class="column-title text-center">CBTH</th>
                        <th class="column-title text-center">GCR</th>
                        <th class="column-title text-center">Lupus</th>
                        <th class="column-title text-center">Leave Type</th>
                        <!-- </tr> -->
                    </thead>
                    <?php foreach ($query as $data) { ?>
                        <td class="text-center" ><?= $data->layak_mula . ' - ' . $data->layak_tamat ?></td>
                        <td class="text-center"><?= $data->layak_bawa_lepas?></td> 
                        <td class="text-center"><?= $data->layak_cuti?></td> 
                        <td class="text-center"><?= $data->layak_cuti + $data->layak_bawa_lepas + $data->layak_selaras?></td> 

                        <td class="text-center" colspan="8">Leave Records <?php $date = date('Y', strtotime($data->layak_mula));echo "($date)";?></td>

                        <tr>
                            <?php foreach (TblRecords::getRecords($data->layak_icno, $data->layak_mula, $data->layak_tamat) as $test) { ?>
                                <td class="text-center"></td> 
                                 <td class="text-center" colspan="3"></td>
                                <td class="text-center"><?=$test->full_date ?></td>
                                <td class="text-center"><?=$test->tempoh ?></td>
                                <td class="text-center"><?= TblRecords::getIncrement($test->icno,$data->layak_mula,$test->end_date) ?></td>
                                <td class="text-center"><?= $data->layak_cuti + $data->layak_bawa_lepas + $data->layak_selaras - TblRecords::getIncrement($test->icno,$data->layak_mula,$test->end_date) ?></td>
                                <td class="text-center"></td> 
                                <td class="text-center"></td> 
                                <td class="text-center"></td> 
                                <td class="text-center"><?=$test->jenisCuti->jenis_cuti_nama ?></td>


                        </tr>


                    <?php  } ?>
                    <tr>
                    <td class="text-center" colspan="8"></td>
                    <td class="text-center"><?= $data->layak_bawa_depan ?></td> 
                    <td class="text-center"><?= $data->layak_gcr ?></td> 
                    <td class="text-center"><?= $data->layak_hapus ?></td> 
                    <td class="text-center"></td> 
                    </tr>
                   
                <?php  } ?>

                <tr>
                    <td class="text-center" colspan="8">Total GCR</td>
                    <td class="text-center"></td> 

                    <td class="text-center"><?=Layak::getTotalGcr($id,$year)?></td>
                    <td class="text-center" colspan="2"></td> 
                    <!-- <td class="text-center"></td>  -->

                    </tr>

                </table>
            </div>
            <?php  }else{ ?>
                <div class="clearfix">
                
                <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
                    <thead>
                        <!-- <tr class="headings"> -->
                        <th class="column-title text-center" width="auto">Entitlement Date</th>
                        <th class="column-title text-center">BCTL</th>
                        <th class="column-title text-center">Entitlement</th>
                        <th class="column-title text-center">Total</th>
                        <th class="column-title text-center">Leave Start to End</th>
                        <!-- <th class="column-title text-center">Leave End</th> -->
                        <th class="column-title text-center">Duration</th>
                        <th class="column-title text-center">Increment</th>
                        <th class="column-title text-center">Balance</th>
                        <th class="column-title text-center">CBTH</th>
                        <th class="column-title text-center">GCR</th>
                        <th class="column-title text-center">Lupus</th>
                        <th class="column-title text-center">Leave Type</th>
                        <!-- </tr> -->
                    </thead>
                    <?php foreach ($query as $data) { ?>
                        <td class="text-center" ><?= $data->layak_mula . ' - ' . $data->layak_tamat ?></td>
                        <td class="text-center"><?= $data->layak_bawa_lepas?></td> 
                        <td class="text-center"><?= $data->layak_cuti?></td> 
                        <td class="text-center"><?= $data->layak_cuti + $data->layak_bawa_lepas ?></td> 

                        <td class="text-center" colspan="8">Leave Records <?php $date = date('Y', strtotime($data->layak_mula));echo "($date)";?></td>

                        <tr>
                            <?php foreach (TblRecords::getRecords($data->layak_icno, $data->layak_mula, $data->layak_tamat) as $test) { ?>
                                <td class="text-center"></td> 
                                 <td class="text-center" colspan="3"></td>
                                <td class="text-center"><?=$test->full_date ?></td>
                                <td class="text-center"><?=$test->tempoh ?></td>
                                <td class="text-center"><?= TblRecords::getIncrement($test->icno,$data->layak_mula,$test->end_date) ?></td>
                                <td class="text-center"><?= $data->layak_cuti + $data->layak_bawa_lepas - TblRecords::getIncrement($test->icno,$data->layak_mula,$test->end_date) ?></td>
                                <td class="text-center"></td> 
                                <td class="text-center"></td> 
                                <td class="text-center"></td> 
                                <td class="text-center"><?=$test->jenisCuti->jenis_cuti_nama ?></td>


                        </tr>


                    <?php  } ?>
                    <tr>
                    <td class="text-center" colspan="8"></td>
                    <td class="text-center"><?= $data->layak_bawa_depan ?></td> 
                    <td class="text-center"><?= $data->layak_gcr ?></td> 
                    <td class="text-center"><?= $data->layak_hapus ?></td> 
                    <td class="text-center"></td> 
                    </tr>
                   
                <?php  } ?>

                <tr>
                    <td class="text-center" colspan="8">Total GCR</td>
                    <td class="text-center"></td> 

                    <td class="text-center"><?=Layak::getTotalGcr($id,$year)?></td>
                    <td class="text-center" colspan="2"></td> 
                    <!-- <td class="text-center"></td>  -->

                    </tr>

                </table>
            </div>
            <?php  } ?>

        </div>
    </div>