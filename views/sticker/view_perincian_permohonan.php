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
                            return $model->biodata->getTarikh($model->mohon_date) . '  ' . date("H:i:s", strtotime($model->mohon_date));
                        },
                    ],
                    [
                        'attribute' => 'no_siri',
                        'value' => function($model) {
                            return strtoupper($model->no_siri);
                        },
                    ], 
                    [
                        'label' => 'Tarikh Diluluskan',
                        'value' => function($model) {
                            return $model->biodata->getTarikh(date('Y-m-d', strtotime($model->app_datetime)));
                        },
                    ],
                    [
                        'label' => 'Tarikh Luput Pelekat',
                        'value' => function($model) {
                            if ($model->expired_date_2) {
                                return $model->user->biodata->getTarikh($model->expired_date_1) . ' - ' . $model->user->biodata->getTarikh($model->expired_date_2);
                            } else {
                                return $model->user->biodata->getTarikh($model->expired_date_1); //old permohonan
                            }
                        },
                    ],
                    'total',
                ],
            ])
            ?>

        </div> 
    </div>
</div>   