<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use dosamigos\highcharts\HighCharts;
use app\models\myintegriti\TblPenilaian;
?>

<?= $this->render('_topmenu') ?>

<div class="row text-center">
    <?php
 foreach (TblPenilaian::listofyear() as $i){
     $average = TblPenilaian::averageindex($i->tahun);
     ?>
    <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3" style="display:inline-block;float:none;text-align:left;">
    <div class="x_panel">
        <div class="x_title text-center">
       TAHUN <?= $i->tahun?> 
        </div>
        <div class="x_content">
            <div class="text-center" style="font-size: 60px">
            <?= $average?>%
            </div>
            <div class="progress">
                <div class="progress-bar <?= TblPenilaian::averagestatusbar($average)?>" role="progressbar" aria-valuenow="<?= $average?>" aria-valuemin="0" aria-valuemax="21" style="width: <?= $average.'%;'?>">
                    <?= TblPenilaian::averagestatus($average)?>
                </div>
            </div>
            <ul><strong>Jumlah Responden</strong>
                <li>Jantina Lelaki : <strong><?= TblPenilaian::totalmale($i->tahun) ?></strong></li>
                <li>Jantina Perempuan : <strong><?= TblPenilaian::totalfemale($i->tahun) ?></strong></li>
            </ul>
        </div>
    </div></div>
    <?php
 } ?>
</div>
<div class="row">
    <div class="x_panel">
        <div class="col-md-10 col-sm-10 col-xs-12 col-lg-10 col-lg-offset-1">
        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3">
        <div style="width : 50%;">
                <div class="progress-bar progress-bar-success" role="progressbar" style="width: 100%">
                    Cemerlang
                </div>
        </div> &nbsp;: 85% - 100%
        </div>
        
        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3">
        <div style="width : 50%;">
                <div class="progress-bar progress-bar-info" role="progressbar" style="width: 100%">
                    Baik
                </div>
        </div> &nbsp;: 85% - 100%
        </div>
        
        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3">
        <div style="width : 50%;">
                <div class="progress-bar progress-bar-warning" role="progressbar" style="width: 100%">
                    Biasa
                </div>
        </div> &nbsp;: 85% - 100%
        </div>
        
        <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3">
        <div style="width : 50%;">
                <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 100%">
                    Lemah
                </div>
        </div> &nbsp;: 85% - 100%
        </div>
    </div>
    </div>
</div>
<div class="row">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-user"></i> Bilangan Responden</h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php
                if(!sizeof($model) == 0){
                foreach ($model as $values){
                    $a[0]= (Yii::$app->formatter->format($values['nama'], 'date'));
                    $c[]= (Yii::$app->formatter->format($values['nama'], 'date'));
                    $b[]= array('type'=> 'column', 'name' =>Yii::$app->formatter->format($values['nama'], 'date'), 'data' => array((int)$values['jml']));
                }}else {
                    $b[]= array('type'=> 'column', 'name' => Yii::$app->formatter->format(date("Y-m-d"), 'date'), 'data' => [0]);
                }
                 echo Highcharts::widget([
                     'clientOptions' => [
                         'chart'=>[
                             'type'=>'line'
                            ],
                         'title' => ['text' => 'Bilangan Responden Untuk Minggu Ke-'.date('W')],
                                'xAxis' => [
                        'categories' => ['Tarikh']
                            ],
                            'yAxis' => [
                               'title' => ['text' => 'Jumlah Responden']
                            ],
                            'series' => $b
                    ]
                ]);
                 
            ?>
        </div>
    </div>
    
</div>