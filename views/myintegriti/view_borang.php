<?php

function color_d($score) {
    switch($score){
    case($score >= 14):
        return $color = 'progress-bar-danger';
    case($score >= 11):
        return $color = 'progress-bar-danger';
    case($score >= 7):
        return $color = 'progress-bar-primary';
    case($score >= 5):
        return $color = 'progress-bar-info';
    case($score >= 0):
        return $color = 'progress-bar-success';
}
};

function color_a($score) {
    switch($score){
    case($score >= 10):
        return $color = 'progress-bar-danger';
    case($score >= 8):
        return $color = 'progress-bar-danger';
    case($score >= 6):
        return $color = 'progress-bar-primary';
    case($score >= 4):
        return $color = 'progress-bar-info';
    case($score >= 0):
        return $color = 'progress-bar-success';
}
};

function color_s($score) {
    switch($score){
    case($score >= 17):
        return $color = 'progress-bar-danger';
    case($score >= 13):
        return $color = 'progress-bar-danger';
    case($score >= 10):
        return $color = 'progress-bar-primary';
    case($score >= 8):
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


<?= $this->render('_navbar') ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_content">
            <div class="pull-right">
                <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Jana Laporan', ['/dass21/generate-assessment', 'id' => Yii::$app->request->get('id')], [
                    'class'=>'btn btn-primary', 
                    'target'=>'_self', 
                    //'data-toggle'=>'tooltip', 
                    //'title'=>'Will open the generated PDF file in a new window'
                ]);
                ?>
            </div>
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
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:5%'],
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
                            'label' => 'SKOR / SCORE',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:15%'],
                            'value' => function($model) use ($form, $model1) {
                                //return Html::radio('skor['.$model->id.']', false, ['value' => $model->id]);
                                $data = [0 => '0', 1 => '1', 2 => '2', 3 => '3'];
                                return $form->field($model1, "q$model->id")->radioButtonGroup($data, ['disabledItems'=>[0, 1, 2, 3]])->label(false);
                            },
                            'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
            </div>
            <?php ActiveForm::end(); ?>
            
            <div class="ln_solid"></div>
            
            <ul>
                <li>
                    Skala Kemurungan / Depression Scale : <strong><?= $d_msg; ?></strong>
                </li>
            </ul>
            
            <div class="progress">
                <div class="progress-bar <?=color_d($result->skor_d)?>" role="progressbar" aria-valuenow="<?= $result->skor_d?>" aria-valuemin="0" aria-valuemax="21" style="width: <?= (($result->skor_d/21)*100).'%;'?>">
                    <?= $result->skor_d.'/21'?>
                </div>
            </div>
            
            <ul>
                <li>
                    Skala Kebimbangan / Anxiety Scale : <strong><?= $a_msg; ?></strong>
                </li>
            </ul>
            
            <div class="progress">
                <div class="progress-bar <?=color_a($result->skor_a)?>" role="progressbar" aria-valuenow="<?= $result->skor_a?>" aria-valuemin="0" aria-valuemax="21" style="width: <?= (($result->skor_a/21)*100).'%;'?>">
                    <?= $result->skor_a.'/21'?>
                </div>
            </div>
            
            <ul>
                <li>
                    Skala Tekanan / Stress Scale : <strong><?= $s_msg; ?></strong>
                </li>
            </ul>
            
            <div class="progress">
                <div class="progress-bar <?=color_s($result->skor_s)?>" role="progressbar" aria-valuenow="<?= $result->skor_s?>" aria-valuemin="0" aria-valuemax="21" style="width: <?= (($result->skor_s/21)*100).'%;'?>">
                    <?= $result->skor_s.'/21'?>
                </div>
            </div>
            
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