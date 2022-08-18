<?php

use yii\grid\GridView;
use yii\helpers\Html;
?> 
<?= $this->render('menu') ?> 
<div class="x_panel">  
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">ANNOUNCEMENT LIST</p> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">    
        <p align="right"><?= Html::button('ADD', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-ads', 'id' => $model->id]), 'class' => 'mapBtn btn btn-primary btn-md']);?></p>
        
        <div class="table-responsive">

            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Position',
                    'value' => function($model) {
                        return $model->findJawatan($model->gred_id);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Start',
                    'value' => function($model) {
                        return $model->StartDate;
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'End',
                    'value' => function($model) {
                        return $model->EndDate;
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Action',
                    'value' => function($model) {
                        if (date('Y-m-d') >= $model->StartDate) {
                            return '';
                        } else {
                            return Html::button(' ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['edit-ads', 'id' => $model->id]), 'class' => 'fa fa-edit mapBtn btn btn-default btn-lg']) . Html::a(' ', ['delete-ads', 'id' => $model->id],['class' => 'fa fa-trash btn btn-danger btn-lg']);
                        }
                    },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                    ];



                    echo GridView::widget([
                        'dataProvider' => $model,
                        'columns' => $gridColumns, 
                    ]);
                    ?>
        </div>




    </div>
</div>  

