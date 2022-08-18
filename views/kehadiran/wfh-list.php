<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\cuti\SetPegawai;
use yii\bootstrap\Modal;

$this->title = 'Senarai Permohonan Bekerja dari Rumah / Work from Home';
?>
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-list"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="tile-stats" style="padding:10px">
            <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL</th>
                        <th class="column-title text-center">TARIKH</th>
                        <th class="column-title text-center">TEMPOH</th>
                        <th class="column-title text-center">CATATAN</th>
                        <th class="column-title text-center">TARIKH / MASA PERMOHONAN</th>
                        <th class="column-title text-center">STATUS</th>
                    </tr>
                </thead>
                <?php foreach ($model as $models) { ?>
                    <tr class='text-center'>
                        <td><?= $bil++ ?></td>
                        <td><?= $models->full_date ?></td>
                        <td><?= $models->tempoh ?></td>
                        <td><?= $models->remark ?></td>
                        <td><?= $models->entry_dt ?></td>
                        <td><?= $models->status ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>