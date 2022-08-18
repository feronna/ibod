<?php
/* @var $this yii\web\View */

use yii\grid\GridView;

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    
                        <?= 
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
                                'summary' => '',
                                'columns' => [
                                    [
                                        'attribute' => 'el_amount',
//                                        'label' => 'Jumlah Sebelum',
                                        'headerOptions' => ['class' => 'text-center'], 
                                        'contentOptions' => ['class' => 'text-center'],
                                        'format' => 'html',
                                    ],
//                                    [
//                                        'attribute' => 'SR_NEW_VALUE',
//                                        'label' => 'Jumlah',
//                                        'headerOptions' => ['class' => 'text-center'], 
//                                        'contentOptions' => ['class' => 'text-center'],
//                                        'format' => 'html',
//                                    ],             
                                ],
                            ]);
                        ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
