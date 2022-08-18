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

$this->title = 'Leave Entitlement / Kelayakan Cuti';
?>

<div class="x_panel">
<!-- <br> -->
<div class="alert alert-success alert-dismissible " role="alert">
 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
</button>
<strong>Info!</strong> Lantikan Sementara, Lantikan Kontrak dan Lantikan Kontrak Jabatan Tidak Dikira Sebagai Lantikan Pertama Anda.
</div>
    <div class="x_title">
        <h2><i class="fa fa-plane"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
     
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            
        </ul>
        <div class="clearfix">
        
        <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
        
        <thead>
                        <!-- <tr class="headings"> -->
                            <th class="column-title text-center">START</th>
                            <th class="column-title text-center">END</th>
                            <th class="column-title text-center">BCTL</th>
                            <th class="column-title text-center">ENTITLEMENT</th>
                            <th class="column-title text-center">TOTAL (Adjustment Included)</th>
                            <th class="column-title text-center">CBTH</th>
                            <th class="column-title text-center">GCR</th>
                            <th class="column-title text-center">DISCARDED</th>
                        <!-- </tr> -->
                    </thead>
        <?php foreach ($layak as $v) { ?>
            <!-- <div class="tile-stats" style="padding:10px"> -->
              
                    <tr class='text-center'>
                        <td><?= $v->layakMulaDmy ?></td>
                        <td><?= $v->layakTamatDmy ?></td>
                        <td><?= $v->layak_bawa_lepas ?></td>
                        <td><?= $v->layak_cuti ?></td>
                        <td><?= $v->layak_bawa_lepas + $v->layak_cuti + $v->layak_selaras ?></td>
                        <td><?= $v->layak_bawa_depan ?></td>
                        <td><?= $v->layak_gcr ?></td>
                        <td><?= $v->layak_hapus ?></td>
                    </tr>
                    <tr class='text-center'>

                    <?php } ?>
                    <tr class='text-center'>
                        <td colspan="6">Total GCR Before Adjustment</td>
                        <td><?= Layak::getTotalGcr($id, 0) ?></td>
                        <td colspan="1"></td>

                    </tr>
                    <tr class='text-center'>
                        <td colspan="6">Total GCR After Adjustment</td>
                        <td><?= Layak::getTotalGcrA($id, 0) ?></td>
                        <td colspan="1"></td>

                    </tr>


        </table>
    </div>
</div>