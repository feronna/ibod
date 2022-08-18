<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//yii\helpers\VarDumper::dump($jenis_cuti,10,true);

use app\models\cuti\Layak;
use app\models\cuti\TblRecords;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

$this->title = 'Senarai Permohonan GCR & CBTH / GCR & CBTH Application List ';


?>



<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-plane"></i>&nbsp;<strong<i><?= Html::encode($this->title) ?></i></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <!-- <h4 class="text-center">Entitlement</h4> -->
            <div class="tile-stats" style="padding:10px">
                <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
                    <thead>
                            <th class="column-title text-center">Bil</th>
                            <th class="column-title text-center">Tarikh Mohon / Apply Date</th>
                            <th class="column-title text-center">GCR Dimohon / GCR Applied</th>
                            <th class="column-title text-center">CBTH Dimohon / CBTH Applied</th>
                            <th class="column-title text-center">Status</th>
                          
                    </thead>
                    <?php foreach ($model as $v) { ?>

                    <tr class='text-center'>
                        <td><?= $bil++ ?></td>
                        <td><?= $v->mohon_dt ?></td>
                        <td><?= $v->gcr_applied ?></td>
                        <td><?= $v->cbth_applied ?></td>
                        <td><?= $v->status ?></td>
         
                    </tr>
                    <?php } ?>

                  
                </table>
            </div>
            <div style='padding: 15px;' class="table-bordered">
                    <font><u><strong>RUJUKAN /<i> REFERENCE</i></u> </strong></font><br><br>

                    <span class="label label-default">ENTRY</span> : Permohonan Baru / <i>New Application</i> &nbsp;&nbsp;&nbsp;&nbsp;<br>
                    <span class="label label-primary">CHECKED</span> : Penyelia Cuti JFPIB Telah Menyemak Permohonan / <i> Application Has Been Checked by Leave Supervisor </i> &nbsp;&nbsp;&nbsp;&nbsp;<br>
                    <span class="label label-info">VERIFIED</span> : Permohonan Telah Diperaku Oleh Ketua Jabatan/Dekan / <i>Application Has Been Verified by Head Of Department/Dean</i>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    <span class="label label-success">APPROVED</span> : Permohonan Diluluskan / <i> Application Has Been Approved</i>

            </div>
        <!-- <h4 class="text-center">Leave Records</h4> -->

    </div>
</div>