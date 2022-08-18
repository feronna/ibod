<?php

use app\models\cuti\TblRecords;
use yii\helpers\Html;
use app\models\kehadiran\TblWarnaKad;
use app\models\kehadiran\TblRekod;
use app\models\kehadiran\TblWp;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i>&nbsp;Senarai kakitangan dibawah Seliaan Anda.</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th >Nama Kakitangan</th>
                                <th >Gred Jawatan</th>
                                <th class="text-center">Status</th>
                                <th >Masa Masuk</th>
                                <th >Masa Keluar</th>
                                <th >Cuti/Outstation</th>
                      
                            </tr>
                        </thead>
                        <?php if ($model) { ?>
                            <?php foreach ($model->teammates as $senarai) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                    <td><?php echo $senarai->name; ?></td>
                                    <td><?php echo $senarai->designation; ?></td>
                                    <td><?= TblRecords::statuslantik($senarai->serv); ?></td>
                                    <td><?php echo $senarai->timeIn; ?></td>
                                    <td><?php echo $senarai->timeOut; ?></td>
                                    <td><?php echo $senarai->onleave; ?></td>
                                                </tr>
                                                
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="11" class="align-center text-center"><i>Tiada Kakitangan Untuk Dipantau</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
