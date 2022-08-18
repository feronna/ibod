<?php
 
use yii\grid\GridView; 
?>
<?= $this->render('menu') ?>  
<div class="x_panel">
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">HARGA PELEKAT</p> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">
        <div class="table-responsive">   
            <?=
            GridView::widget([
                'dataProvider' => $model, 
                'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                 'options' => [ 'style' => 'table-layout:fixed;' ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'], 
                    
                                   
                                    [
                            'label' => 'Jenis Pelekat',
                            'value' => function($model) {
                                return  $model->type;
                            },
                              'format' => 'raw',    
                        ], 
                                     [
                            'label' => 'Harga (2) buah pertama (RM)',
                            'value' => function($model) {
                                return  $model->amount;
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'], 
                                    'contentOptions' => [ 'style' => 'width: 15%;' ],
                        ], 
                                    [
                            'label' => 'Harga (3) dan keatas (RM)',
                            'value' => function($model) {
                                return  $model->amount2;
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'contentOptions' => [ 'style' => 'width: 15%;' ],
                        ], 
                                    [
                            'label' => 'Bas dan Lori 1.5 tan keatas (RM)',
                            'value' => function($model) {
                                return  $model->bas_lori_rate; 
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'contentOptions' => [ 'style' => 'width: 15%;' ],
                        ], 
                                     [
                            'label' => 'Catatan',
                            'value' => function($model) {
                                return  $model->desc;
                            },
                        ], 
                                     [
                            'label' => 'Maximum kenderaan',
                            'value' => function($model) {
                                return  $model->maximum_desc;
                            },
                                    'format' => 'raw',
                        ], 
                                    [
                            'label' => 'Tempoh (Tahun)',
                            'value' => function($model) {
                                return  $model->period;
                            },
                                    'format' => 'raw',
                        ], 
                ],
            ]);
            ?> 
        </div>
    </div>
</div> 
