<?php

use yiister\gentelella\widgets\Panel;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Html;

?>

<div class="tblprcobiodata-form">
<?= Html::a( 'Kembali', ['viewpayroll','id'=> $icno ? $icno : ' '], ['class' => 'btn btn-primary']) ?>
    <div class="x_panel">
    
        <div class="col-md-6 col-xs-6">
            <?php
            Panel::begin(
                [
                    'header' => 'Elaun',
                    'icon' => 'plus-square',
                    'collapsable' => true,
                ]
            )
            ?>
            <?= GridView::widget([
                'dataProvider' => $elaun,
                'columns' => [
                    [
                        'header'=>'Kod Elaun',
                        'value' => function($model){
                            return $model->MPD_INCOME_CODE;
                        },
                        'footer' => 'TOTAL',
                        'footerOptions' => [
                            'colspan' => '2',
                        ]
                        
                        
                    ],
                    [
                        'header'=>'Nama Elaun',
                        'value'=>function($model, $key, $index, $obj){
                            
                            return $model->elaun ? $model->elaun->it_income_desc : 'null';
                        },                        
                        'footerOptions' => [
                            'style' => 'display: none;',
                        ]
                        
                    ],
                    [
                        'header'=>'Nilai Dibayar',
                        'value' => function($model, $key, $index, $obj){
                            $obj->footer +=$model->MPD_PAID_AMT;
                            return $model->MPD_PAID_AMT;
                        },
                        
                        
                    ],
                    
                ],
                'showFooter'=>TRUE,
                
            ]); ?>
            <?php Panel::end() ?>
        </div>
        <div class="col-md-6 col-xs-6">
            <?php
            Panel::begin(
                [
                    'header' => 'Pendapatan lain',
                    'icon' => 'plus-square',
                    'collapsable' => true,
                ]
            )
            ?>
            <?= GridView::widget([
                'dataProvider' => $elaunlain,
                'columns' => [
                    [
                        'label'=>'Kod Pendapatan',
                        'value'=>'MPD_INCOME_CODE',
                        'footer' => 'TOTAL',
                        'footerOptions' => [
                            'colspan' => '2',
                        ]
                    ],
                    [
                        'label'=>'Nama Elaun',
                        'value'=>function($model){
                            return $model->elaun ? $model->elaun->it_income_desc : 'null';
                        },
                                                
                        'footerOptions' => [
                            'style' => 'display: none;',
                        ]
                    ],
                    [
                        'label'=>'Nilai Dibayar',
                        'value' => function($model, $key, $index, $obj){
                            $obj->footer +=$model->MPD_PAID_AMT;
                            return $model->MPD_PAID_AMT;
                        }
                    ],
                ],
                'showFooter'=>TRUE,
            ]); ?>
            <?php Panel::end() ?>
        </div>
        <div class="col-md-6 col-xs-6">
            <?php
            Panel::begin(
                [
                    'header' => 'Potongan',
                    'icon' => 'minus-square',
                    'collapsable' => true,
                ]
            )
            ?>
             <?= GridView::widget([
                'dataProvider' => $potongan,
                'columns' => [
                    [
                        'label'=>'Kod Potongan',
                        'value'=>'MPD_INCOME_CODE',                        
                        'footer' => 'TOTAL',
                        'footerOptions' => [
                            'colspan' => '2',
                        ]
                    ],
                    [
                        'label'=>'Nama Potongan',
                        'value'=>function($model){
                            return $model->elaun ? $model->elaun->it_income_desc : 'null';
                        },
                                                
                        'footerOptions' => [
                            'style' => 'display: none;',
                        ]
                    ],
                    [
                        'label'=>'Nilai Dipotong',
                        'value' => function($model, $key, $index, $obj){
                            $obj->footer +=$model->MPD_PAID_AMT;
                            return $model->MPD_PAID_AMT;
                        }
                    ],
                ],
                'showFooter'=>TRUE,
            ]); ?>
            <?php Panel::end() ?>
        </div>
    </div>
</div>
