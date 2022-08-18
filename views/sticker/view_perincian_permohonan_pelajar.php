<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

date_default_timezone_set("Asia/Kuala_Lumpur");
?> 
<div class="x_panel">
    <div class="x_title">
        <h2>Perincian Permohonan</h2></p>
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">    

        <div class="table-responsive">
            <?=
            DetailView::widget([
                'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'No. Kenderaan',
                        'value' => function($model) {
                            return strtoupper($model->kenderaan->reg_number);
                        },
                        'contentOptions' => ['style' => 'width:30%'],
                        'captionOptions' => ['style' => 'width:15%'],
                    ],
                   [
                            'label' => 'Tarikh Mohon',
                            'value' => function($model) {
                                return $model->biodata->getTarikh($model->mohon_date).'  '.date("H:i:s",strtotime($model->mohon_date));
                            },
                        ],  
                    [
                        'attribute' => 'no_siri',
                        'value' => function($model) {
                            return strtoupper($model->no_siri);
                        }, 
                    ],
//                    [
//                        'attribute' => 'updater',
//                        'value' => function($model) {
//                            if ($model->updater) {
//                                return $model->updater . ' - ' . ucwords(strtolower($model->biodata->CONm));
//                            } else {
//                                return '';
//                            }
//                        },
//                    ],
                    [
                        'label' => 'Tarikh Diluluskan',
                        'value' => function($model) {
                            return $model->biodata->getTarikh($model->app_date);
                        },
                    ],
                    [
                        'label' => 'Tarikh Luput Pelekat',
                        'value' => function($model) {
                            return $model->biodata->getTarikh($model->expired_date);
                        },
                    ],
                    'total',
                ],
            ])
            ?>

        </div> 
    </div>
</div>   