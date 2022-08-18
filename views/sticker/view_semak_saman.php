<?php
 
use yii\grid\GridView; 
?>
<?= $this->render('menu') ?> 
    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:18px;font-weight: bold;">SEMAKAN REKOD SAMAN</p> 
            <div class="clearfix"></div>
        </div> 
        <div class="x_content">
            <div class="table-responsive">   
                <?=
                GridView::widget([
                    'dataProvider' => $pending, 
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'], 
                        [
                            'attribute' => 'NO_KENDERAAN',
                            'value' => 'NO_KENDERAAN'
                        ],
                        [
                            'attribute' => 'LOKASI',
                            'value' => 'LOKASI'
                        ], 
                        [
                            'attribute' => 'TRKHSAMAN',
                            'value' => 'TRKHSAMAN'
                        ],
                        
                        [
                            'label' => 'Kesalahan',
                            'value' => 'NOTA1'
                        ],
                        [
                            'label' => 'Amaun Pending',
                            'value' => 'samanPending.AMOUNT_PENDING'
                        ],
                         
                        
                            ],
                        ]);
                        ?> 
                <?=
                GridView::widget([
                    'dataProvider' => $pending2, 
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'], 
                        [
                            'attribute' => 'NO_KENDERAAN',
                            'value' => 'NO_KENDERAAN'
                        ],
                        [
                            'attribute' => 'LOKASI',
                            'value' => 'LOKASI'
                        ], 
                        [
                            'attribute' => 'TRKHSAMAN',
                            'value' => 'TRKHSAMAN'
                        ],
                        
                        [
                            'label' => 'Kesalahan',
                            'value' => 'NOTA1'
                        ],
                        [
                            'label' => 'Amaun Pending',
                            'value' => 'samanPending.AMOUNT_PENDING'
                        ],
                         
                        
                            ],
                        ]);
                        ?> 
            </div>
        </div>
    </div> 
