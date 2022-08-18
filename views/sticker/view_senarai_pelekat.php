<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
?>

<?= $this->render('menu') ?> 


<div class="x_panel"> 
    <div class="table-responsive">     
        <?php Pjax::begin(); ?>
        <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'], 
            [
                'label' => 'Nama',
                'value' => function($model) {
                    return $model->kenderaan->biodata->CONm;
                },
            ], 
            [
                'label' => 'No. Kenderaan',
                'value' => function($model) {
                    return $model->kenderaan->reg_number;
                },
            ],
            [
                'label' => 'No. Siri',
                'value' => function($model) {
                    return $model->no_siri;
                },
            ],
                        [
                'label' => 'Tempoh Pelekat',
                'value' => function($model) {
                    return $model->expired_date_1.' - '.$model->expired_date_2;
                },
            ],
                        [
                'label' => 'Harga (RM)',
                'value' => function($model) {
                    return $model->total;
                },
            ],
                        [
                'label' => 'Jenis Pembayaran',
                'value' => function($model) {
                    if($model->jenis_bayaran == 1){
                        return 'KAUNTER';
                    }elseif($model->jenis_bayaran == 2){
                        return 'ATAS TALIAN';
                    }else{
                        return '';
                    }
                },
            ],
             
        ];
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'beforeHeader' => [
                [
                    'columns' => [],
                    'options' => ['class' => 'skip-export'] // remove this row from export
                ]
            ],
            'toolbar' => [
                                        'content' =>
                                        \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']),
                                    ],
            'bordered' => true,
            'striped' => false,
            'condensed' => false,
            'responsive' => true,
            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => '<h2>Senarai Pelekat </h2>', 
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div> 
</div>

