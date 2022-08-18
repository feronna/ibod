<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>
<?= $this->render('menu') ?>  
<div class="x_panel">
    <div class="x_title">
        <h2><?= $title;?></h2> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">
        <div class="table-responsive">   
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider, 
                'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'], 
                    
                                   
                                    [
                            'label' => 'Nama',
                            'value' => function($model) {
                                return  $model->buyer_name;
                            },
                              'format' => 'raw',    
                        ], 
                                     [
                            'label' => 'Harga (RM)',
                            'value' => function($model) {
                                return  $model->amount;
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                        ],  
                                    [
                            'label' => 'Data',
                            'value' => function($model) {
                                return  $model->getPaymentDetails();
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                        ],  
                ],
            ]);
            ?> 
        </div>
    </div>
</div> 
