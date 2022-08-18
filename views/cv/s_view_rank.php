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
        <h2>Rank</h2> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">
        <div class="table-responsive">   
            <?=
            GridView::widget([
                'dataProvider' => $model, 
                'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'], 
                    
                                   
                                    [
                            'label' => 'Jawatan Semasa',
                            'value' => function($model) {
                                return  $model->fname;
                            },
                                    
                        ],
                                    'id',
                                     [
                            'label' => 'Kenaikan',
                            'value' => function($model) {
                                return  $model->getDisplayKenaikan();
                            },
                        ], 
                ],
            ]);
            ?> 
        </div>
    </div>
</div> 
