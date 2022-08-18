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

$this->title = 'Substitute For';


?>



<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-plane"></i>&nbsp;<strong>Menggantikan / <i><?= Html::encode($this->title) ?></i></strong></h2>
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
                            <th class="column-title text-center">Substitute For</th>
                            <th class="column-title text-center">Leave Start</th>
                            <th class="column-title text-center">Leave End</th>
                            <th class="column-title text-center">Duration</th>
                            <th class="column-title text-center">Remark</th>
                            <th class="column-title text-center">Status</th>
                          
                    </thead>
                    <?php foreach ($model as $v) { ?>

                    <tr class='text-center'>
                        <td><?= $v->kakitangan->CONm ?></td>
                        <td><?= $v->start_date ?></td>
                        <td><?= $v->end_date ?></td>
                        <td><?= $v->tempoh ?></td>
                        <td><?= $v->remark ?></td>
                        <td><?= $v->status ?></td>
         
                    </tr>
                    <?php } ?>

                  
                </table>
            </div>
        <!-- <h4 class="text-center">Leave Records</h4> -->

    </div>
</div>