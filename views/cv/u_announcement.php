<?php

use yii\grid\GridView;
?> 
<?= $this->render('menu') ?> 
<div class="x_panel">  
    <div class="x_title">
        <p style="font-size:15px;font-weight: bold;">OPEN PROMOTION</p> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="table-responsive">

            <?php
            echo GridView::widget([
                'dataProvider' => $model,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'value' => function ($data) {
                            return $data->findJawatan($data->gred_id);
                        },
                    ],
                    'StartDate',
                    'EndDate',
                ],
            ]);
            ?>
        </div> 
    </div>
</div>  

