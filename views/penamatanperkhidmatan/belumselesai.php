<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\Select2;
use app\models\penamatanperkhidmatan\TblJenispenamatan;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

error_reporting(0);
?>

<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> <?=$title?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <i>[Tarikh terakhir dikemaskini : <?= $tarikh?>]</i>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">PERKARA</th>
                        <th class="column-title text-center"><?= $dept_id==158? 'BAKI (TAHUN)':'BAKI (RM)'?></th>
                    </tr>
                </thead>
                <tbody>
                   <?php 
                    $bil=1;
                    if($model){
                    foreach ($model as $model) { 
                        ?>
                        <tr>
                            <td><?= $bil++; ?></td>
                            <td><?= $model->perkara; ?></td>
                            <td><?= $model->baki; ?></td>
                        </tr>
                    <?php }} 
                    else{
                        echo '<tr>
                            <td colspan=3><div class="empty"></div></td>
                        </tr>';
                    }
?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>



