<?php

function color($score) {
    switch($score){
    case($score >= 14):
        return $color = 'progress-bar-danger';
    case($score >= 11):
        return $color = 'progress-bar-alert';
    case($score >= 7):
        return $color = 'progress-bar-primary';
    case($score >= 5):
        return $color = 'progress-bar-info';
    case($score >= 0):
        return $color = 'progress-bar-success';
}
};

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\grid\GridView;
use kartik\form\ActiveForm;
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_content">
            
            <table class="table table-sm table-bordered">
                <tr>
                    <td width="15%"><strong>Nama Pegawai</strong></td>
                    <td><?= $bio->CONm; ?></td>
                </tr>
                <tr>
                    <td><strong>No. KP / Pasport</strong></td>
                    <td><?= $bio->ICNO; ?></td>
                </tr>
                <tr>
                    <td><strong>JSPIU</strong></td>
                    <td><?= $model1->department->fullname; ?></td>
                </tr>
                <tr>
                    <td><strong>Jawatan / Gred</strong></td>
                    <td><?= $model1->jawatan->nama; ?> / <?= $model1->jawatan->gred; ?></td>
                </tr>
                <tr>
                    <td><strong>Tarikh / Masa</strong></td>
                    <td><?= $model1->created_dt; ?></td>
                </tr>
            </table>
            
            <div class="ln_solid"></div>
            
            <?php 
                $form = ActiveForm::begin(['action' => ['assessment']]);
                
            ?>
            <div class="table-responsive">
            <?=
                GridView::widget([
                    'summary' => '',
                    //'emptyText' => 'Tiada rekod penetapan SKT',
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'label' => 'BIL',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:10%'],
                            'attribute' => 'id',
                        ],
                        [
                            'label' => 'SOALAN',
                            'headerOptions' => ['class'=>'text-center'],
                            //'contentOptions' => ['style'=>'width:75%'],
                            'attribute' => 'soalan',
                            'format' => 'html'
                                    
                        ],
                        [
                            'label' => 'SKOR',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:15%'],
                            'value' => function($model) use ($form, $model1) {
                                //return Html::radio('skor['.$model->id.']', false, ['value' => $model->id]);
                                $tmp = "q$model->id";
                                return $model1->$tmp;
                            },
                                    'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
            </div>
            <?php ActiveForm::end(); ?>
            
            <hr>
            
            <ul>
                <li>
                    Skala Kemurungan / Depression Scale : <?= $result->skor_d.'/21'?> <strong><?= $d_msg; ?></strong>
                </li>
            </ul>
            
            <ul>
                <li>
                    Skala Kebimbangan / Anxiety Scale : <?= $result->skor_a.'/21'?> <strong><?= $a_msg; ?></strong>
                </li>
            </ul>
            
            <ul>
                <li>
                    Skala Tekanan / Stress Scale : <?= $result->skor_s.'/21'?> <strong><?= $s_msg; ?></strong>
                </li>
            </ul>
            
            <hr>
            
            <table class="table">
                <tr>
                    <th></th>
                    <th class="text-center">KEMURUNGAN / DEPRESSION</th>
                    <th class="text-center">KEBIMBANGAN / ANXIETY</th>
                    <th class="text-center">STRESS / TEKANAN</th>
                </tr>
                <tr>
                    <td align="right">NORMAL</td>
                    <td align="center">0 - 4</td>
                    <td align="center">0 - 3</td>
                    <td align="center">0 - 7</td>
                </tr>
                <tr>
                    <td align="right">RINGAN / MILD</td>
                    <td align="center">5 - 6</td>
                    <td align="center">4 - 5</td>
                    <td align="center">8 - 9</td>
                </tr>
                <tr>
                    <td align="right">SEDERHANA / MODERATE</td>
                    <td align="center">7 - 10</td>
                    <td align="center">6 - 7</td>
                    <td align="center">10 - 12</td>
                </tr>
                <tr>
                    <td align="right">TERUK / SEVERE</td>
                    <td align="center">11 - 13</td>
                    <td align="center">8 - 9</td>
                    <td align="center">13 - 16</td>
                </tr>
                <tr>
                    <td align="right">SANGAT TERUK / EXTREMELY SEVERE</td>
                    <td align="center">14+</td>
                    <td align="center">10+</td>
                    <td align="center">17+</td>
                </tr>
            </table>
            
        </div> 
    </div>
    </div>
</div>