<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use dosamigos\highcharts\HighCharts;
?>

<?= $this->render('_navbar') ?>

<div class="row">
    <div class="col-md-7 col-sm-7 col-xs-12 col-lg-7">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-user"></i> Bilangan Responden</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                if (!sizeof($model) == 0) {
                    foreach ($model as $values) {
                        $a[0] = (Yii::$app->formatter->format($values['nama'], 'date'));
                        $c[] = (Yii::$app->formatter->format($values['nama'], 'date'));
                        $b[] = array('type' => 'column', 'name' => Yii::$app->formatter->format($values['nama'], 'date'), 'data' => array((int)$values['jml']));
                    }
                } else {
                    $b[] = array('type' => 'column', 'name' => Yii::$app->formatter->format(date("Y-m-d"), 'date'), 'data' => [0]);
                }

                /*\dosamigos\highcharts\HighCharts::widget([
                   'clientOptions' => [
                      'chart' => [
                         'type' => 'bar'
                      ],
                      'title' => [
                         'text' => 'Nama Buah'
                      ],
                      'xAxis' => [
                         'categories' => [
                            'Apel',
                            'Pisang',
                            'Jeruk'
                         ]
                      ],
                      'yAxis' => [
                         'title' => [
                             'text' => 'Buah yang dimakan'
                         ]
                      ],
                      'series' => [
                         ['name' => 'Rohman', 'data' => [1, 6, 4]],
                         ['name' => 'Rohim', 'data' => [5, 7, 3]]
                      ]
                   ]
                ]);*/

                echo Highcharts::widget([
                    'clientOptions' => [
                        'chart' => [
                            'type' => 'line'
                        ],
                        'title' => ['text' => 'Bilangan Responden Untuk Minggu Ke-' . date('W')],
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


    <div class="col-md-5 col-sm-5 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-file-o"></i> Maklumat Borang Penilaian </strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <ul><strong>Jumlah Responden</strong>
                    <li>Jantina Lelaki : <strong><?= $male ?></strong></li>
                    <li>Jantina Perempuan : <strong><?= $female ?></strong></li>
                </ul>
            </div>
        </div>
    </div>

</div>