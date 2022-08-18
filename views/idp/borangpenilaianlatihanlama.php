<?php

use yii\helpers\Html;
//use yii\grid\GridView;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\detail\DetailView;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\myidp\BorangPenilaianLatihan */
/* @var $form ActiveForm */

// setup your attributes
// DetailView Attributes Configuration
$attributes = [

    [
        'columns' => [
            [
                'attribute'=>'vcsl_nama_latihan',
                'format'=>'raw', 
                'value'=>'<kbd>'.ucwords(strtolower($modelLatihan->vcsl_nama_latihan)).'</kbd>',
                'displayOnly'=>true,
                //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label'=>'Sinopsis Kursus',
                'format'=>'raw',
                'value'=>'<span class="text-justify"><em>' . $modelLatihan->vcsl_deskripsi_latihan  . '</em></span>',
                'type'=>DetailView::INPUT_TEXTAREA, 
                'options'=>['rows'=>4]
            ],
        ],
    ],
];

?>
<style>
    .btn-info:active, .btn-info.active, .open > .dropdown-toggle.btn-info {
    color: #fff;
    background-color: #0000FF;
    background-image: none;
    border-color: #269abc;
}
    
</style>
<div class="row">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-pencil" aria-hidden="true"></i> Borang Penilaian Latihan</h2>
            <div class="clearfix"></div>
        </div>
        <br>
        <div>
            <h4><i class="fa fa-folder-open-o" aria-hidden="true"></i> Maklumat Program</h4>
            <div class="clearfix"></div>
        </div>
        <div class="x_content" id="myText">
        
            <?=
                // View file rendering the widget
                DetailView::widget([
                    'model' => $modelLatihan,
                    'attributes' => $attributes,
                    'mode' => 'view',
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => true,
                    'responsive' => true,
                    'hover' => true,
                    'hAlign' => 'right',
                    'vAlign' => 'middle',
                    'fadeDelay' => 1,
                ]);
                
            ?>
        </div>
<!--        <div class="row"> -->
        <div>
            <h4><i class="fa fa-folder-open-o" aria-hidden="true"></i> Borang Penilaian</h4>
            <div class="clearfix"></div>
        </div>
        
                Sila tandakan  maklumbalas anda mengikut skala berikut: / <em>Please tick  your response as per following scale</em> :<br>
                <table class="items table table-bordered table-condensed" width="100%" border="1">
                  <tbody><tr>
                    <td width="5%"><div align="center"><strong>1</strong></div></td>
                    <td width="20%"><div align="center"><strong>Sangat Tidak Berpuas Hati<br>
                          <em>Very Unsatisfied</em></strong></div></td>
                    <td width="5%"><div align="center"><strong>2</strong></div></td>
                    <td width="20%"><div align="center"><strong>Tidak Berpuas Hati<br>
                          <em>Not Satisfied</em></strong></div></td>
                    <td width="5%"><div align="center"><strong>3</strong></div></td>
                    <td width="20%"><div align="center"><strong>Puas Hati<br>
                          <em>Satisfied</em></strong></div></td>
                    <td width="5%"><div align="center"><strong>4</strong></div></td>
                    <td width="20%"><div align="center"><strong>Sangat Puas Hati<br>
                          <em>Very Satisfied</em></strong></div></td>
                  </tr>
                </tbody></table>
        <?php $form = ActiveForm::begin(['options' => ['id' => 'borangpl']]);  $modelL->scenario = 'bm'; $modelN->scenario = 'bm';?>
<!--        <div class="table-responsive">-->
            <?= GridView::widget([
                    'summary' => '',
                    //'emptyText' => 'Tiada rekod penetapan SKT',
                    'dataProvider' => $dataProviderA,
                    'columns' => [
                        [
                            'label' => 'BIL',
                            'headerOptions' => ['class'=>'text-center', 'style' => 'display: none;',],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:5%'],
                            'attribute' => 'soalanID',
                        ],
                        [
                            'label' => 'PERSEKITARAN PEMBELAJARAN / LEARNING ENVIRONMENT',
                            'headerOptions' => ['class'=>'text-center', 'colspan' => '2',],
                            'contentOptions' => ['style'=>'width:60%'],
                            'attribute' => 'soalan',
                            'format' => 'html'
                                    
                        ],
                        [
                            'label' => 'SKALA / SCALE',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:15%'],
                            'value' => function($model) use ($modelL, $form) {
                                $data = [1 => '1', 2 => '2', 3 => '3', 4 => '4'];
                                
                                //return $form->field($model1, "q$model->id")->radioButtonGroup($data)->label(false);
                                return $form->field($modelL, "$model->soalanID")->radioButtonGroup($data, [
                                    'class' => 'btn-group-sm',
                                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-info', 'disabled' => true]]
                                ])->label(false);
                            },
                            'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
 
            <?= $form->field($modelL, 'a_ulasan')->textarea(['rows' => '6', 'disabled' => true])->label('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> ULASAN') ?>
            
<!--        </div>-->
<!--        <div class="table-responsive">-->
            <?= GridView::widget([
                    'summary' => '',
                    //'emptyText' => 'Tiada rekod penetapan SKT',
                    'dataProvider' => $dataProviderB,
                    'columns' => [
                        [
                            'label' => 'BIL',
                            'headerOptions' => ['class'=>'text-center', 'style' => 'display: none;',],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:5%'],
                            'attribute' => 'soalanID',
                        ],
                        [
                            'label' => 'PENYAMPAIAN PENCERAMAH / SPEAKER’S DELIVERY',
                            'headerOptions' => ['class'=>'text-center', 'colspan' => '2',],
                            'contentOptions' => ['style'=>'width:60%'],
                            'attribute' => 'soalan',
                            'format' => 'html'
                                    
                        ],
                        [
                            'label' => 'SKALA / SCALE',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:15%'],
                            'value' => function($model) use ($modelL, $form) {
                                $data = [1 => '1', 2 => '2', 3 => '3', 4 => '4'];
                                
                                //return $form->field($model1, "q$model->id")->radioButtonGroup($data)->label(false);
                                return $form->field($modelL, "$model->soalanID")->radioButtonGroup($data, [
                                    'class' => 'btn-group-sm',
                                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-info', 'disabled' => true]]
                                ])->label(false);
                            },
                            'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
            <?= $form->field($modelL, 'b_ulasan')->textarea(['rows' => '6', 'disabled' => true])->label('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> ULASAN') ?>
<!--        </div>
        <div class="table-responsive">-->
            <?= GridView::widget([
                    'summary' => '',
                    //'emptyText' => 'Tiada rekod penetapan SKT',
                    'dataProvider' => $dataProviderC,
                    'columns' => [
                        [
                            'label' => 'BIL',
                            'headerOptions' => ['class'=>'text-center', 'style' => 'display: none;',],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:5%'],
                            'attribute' => 'soalanID',
                        ],
                        [
                            'label' => 'KANDUNGAN KURSUS / COURSE CONTENT',
                            'headerOptions' => ['class'=>'text-center', 'colspan' => '2',],
                            'contentOptions' => ['style'=>'width:60%'],
                            'attribute' => 'soalan',
                            'format' => 'html'
                                    
                        ],
                        [
                            'label' => 'SKALA / SCALE',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:15%'],
                            'value' => function($model) use ($modelL, $form) {
                                $data = [1 => '1', 2 => '2', 3 => '3', 4 => '4'];
                                
                                //return $form->field($model1, "q$model->id")->radioButtonGroup($data)->label(false);
                                return $form->field($modelL, "$model->soalanID")->radioButtonGroup($data, [
                                    'class' => 'btn-group-sm',
                                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-info', 'disabled' => true]]
                                ])->label(false);
                            },
                            'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
            <?= $form->field($modelL, 'c_ulasan')->textarea(['rows' => '6', 'disabled' => true])->label('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> ULASAN') ?>
<!--        </div>
        <div class="table-responsive">-->
            <?= GridView::widget([
                    'summary' => '',
                    //'emptyText' => 'Tiada rekod penetapan SKT',
                    'dataProvider' => $dataProviderD,
                    'columns' => [
                        [
                            'label' => 'BIL',
                            'headerOptions' => ['class'=>'text-center', 'style' => 'display: none;',],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:5%'],
                            'attribute' => 'soalanID',
                        ],
                        [
                            'label' => 'URUSETIA / SECRETARIAT',
                            'headerOptions' => ['class'=>'text-center', 'colspan' => '2',],
                            'contentOptions' => ['style'=>'width:60%'],
                            'attribute' => 'soalan',
                            'format' => 'html'
                                    
                        ],
                        [
                            'label' => 'SKALA / SCALE',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:15%'],
                            'value' => function($model) use ($modelL, $form) {
                                $data = [1 => '1', 2 => '2', 3 => '3', 4 => '4'];
                                
                                //return $form->field($model1, "q$model->id")->radioButtonGroup($data)->label(false);
                                return $form->field($modelL, "$model->soalanID")->radioButtonGroup($data, [
                                    'class' => 'btn-group-sm',
                                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-info', 'disabled' => true]]
                                ])->label(false);
                            },
                            'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
            <?= $form->field($modelL, 'd_ulasan')->textarea(['rows' => '6', 'disabled' => true])->label('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> ULASAN') ?>
<!--        </div>
        <div class="table-responsive">-->
            <?= GridView::widget([
                    'summary' => '',
                    //'emptyText' => 'Tiada rekod penetapan SKT',
                    'dataProvider' => $dataProviderK,
                    'beforeHeader' => [
                        [
                            'columns' => [
                                ['content' => 'SKALA KESELURUHAN / OVERALL SCALE', 'options' => ['colspan' => 3, 'class' => 'text-center warning']],
                                //['content' => 'Date', 'options' => ['colspan' => 2, 'class' => 'text-center warning']],
                            ],
                        ]
                    ],
                    'columns' => [
                        [
                            'header' => 'SEBELUM KURSUS <br> / BEFORE COURSE',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:25%'],
                            'value' => function($model) use ($modelL, $form) {
                                $data = [1 => '1', 2 => '2', 3 => '3', 4 => '4'];
                                
                                //return $form->field($model1, "q$model->id")->radioButtonGroup($data)->label(false);
                                return $form->field($modelL, "sblm$model->soalanID")->radioButtonGroup($data, [
                                    'class' => 'btn-group-sm',
                                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-info', 'disabled' => true]]
                                ])->label(false);
                            },
                            'format' => 'raw'
                        ],
                        [
                            'header' => 'KOMPETENSI / COMPETENCY',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['style'=>'width:50%'],
                            'attribute' => 'soalan',
                            'format' => 'html'
                                    
                        ],
                        [
                            'header' => 'SELEPAS KURSUS <br> / AFTER COURSE',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:25%'],
                            'value' => function($model) use ($modelL, $form) {
                                $data = [1 => '1', 2 => '2', 3 => '3', 4 => '4'];
                                
                                //return $form->field($model1, "q$model->id")->radioButtonGroup($data)->label(false);
                                return $form->field($modelL, "slps$model->soalanID")->radioButtonGroup($data, [
                                    'class' => 'btn-group-sm',
                                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-info', 'disabled' => true]]
                                ])->label(false);
                            },
                            'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
<!--        </div>-->
        <!-- idp-borangpenilaianlatihan -->
        <hr>
        <div class="x_title">
            <h2><i class="fa fa-pencil" aria-hidden="true"></i> Ringkasan Program</h2>
            <div class="clearfix"></div>
            <h4>Keberkesanan Program Pembangunan Profesional Individu
            <br>(Individual Effectiveness of Professional Development Programme)</h4>
        </div>
        <div class="x_content">
            <?= $form->field($modelN, 'ringkasanLatihan')->textarea(['rows' => '6', 'disabled' => true])->label('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> RINGKASAN') ?>
            <table class="items table table-bordered table-condensed" width="100%" border="1">
                <tbody>
                <tr>
                  <td colspan="10"><div align="center"><strong>Skala Penilaian (<em>Evaluation Scale</em>) </strong></div></td>
                </tr>
                <tr>
                  <td width="5%"><div align="center">1</div></td>
                  <td width="15%"><div align="center"><strong>Sangat Tidak Setuju<br>
                        <em>(Strongly Disagree)</em></strong></div></td>
                  <td width="5%"><div align="center">2</div></td>
                  <td width="15%"><div align="center"><strong>Tidak Setuju<br>
                        <em>(Disagree)</em></strong></div></td>
                  <td width="5%"><div align="center">3</div></td>
                  <td width="15%"><div align="center"><strong>Sederhana<br>
                        <em>(Moderate)</em></strong></div></td>
                  <td width="5%"><div align="center">4</div></td>
                  <td width="15%"><div align="center"><strong>Setuju<br>
                        <em>(Agree)</em></strong></div></td>
                  <td width="5%"><div align="center">5</div></td>
                  <td width="15%"><div align="center"><strong>Sangat Setuju<br>
                        <em>(Strongly Agree)</em></strong></div></td>
                </tr>
                </tbody>
            </table>
            <?= GridView::widget([
                    'summary' => '',
                    //'emptyText' => 'Tiada rekod penetapan SKT',
                    'dataProvider' => $dataProviderN,
                    'columns' => [
                        [
                            'label' => 'BIL',
                            'headerOptions' => ['class'=>'text-center', 'style' => 'display: none;',],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:5%'],
                            'attribute' => 'soalanID',
                        ],
                        [
                            'label' => 'PERKARA / DESCRIPTIONS',
                            'headerOptions' => ['class'=>'text-center', 'colspan' => '2',],
                            'contentOptions' => ['style'=>'width:60%'],
                            'attribute' => 'soalan',
                            'format' => 'html'
                                    
                        ],
                        [
                            'label' => 'SKALA / SCALE',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:15%'],
                            'value' => function($model) use ($modelN, $form) {
                                $data = [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'];
                                
                                //return $form->field($model1, "q$model->id")->radioButtonGroup($data)->label(false);
                                return $form->field($modelN, "$model->soalanID")->radioButtonGroup($data, [
                                    'class' => 'btn-group-sm',
                                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-info', 'disabled' => true]]
                                ])->label(false);
                            },
                            'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
        </div>
        <?php 
            if ($modelL->tarikhIsi) { ?>
                <div class="form-group pull-right">
                    <div class="">Borang anda telah dihantar pada <?php echo $modelL->tarikhIsi; ?></div>
                </div>
            <?php } else { ?>
                <div class="form-group pull-right">
                    <div class="">Borang anda telah dihantar.</div>
                </div>
        <?php } ?>
        <?php ActiveForm::end(); ?> 
    </div>
</div>