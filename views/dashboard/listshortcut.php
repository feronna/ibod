<?php

use yii\grid\GridView;
use yii\helpers\Html;
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1,2,3,4, 1179, 1180]]) ?>
<div class="row">
    <div class="x_panel">
    <div class="x_title">
        <h2>Shortcut</h2>
    <div class="clearfix"></div></div>
    <div class="x_content">
    <?= Html::a('<i class="fa fa-plus"></i> Add', ["updateshortcut"], ['target' => '_blank', 'class' => 'btn btn-primary']);?>
   <?=
GridView::widget([
    'options' => [
                        'class' => 'table-responsive',
                    ],
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Name',
            'value' => 'name'
        ],
         [
            'label' => 'Url',
            'value' => 'url'
        ],
        [
          'label' => 'Access',
          'value' => function($data){
                    if($data->role == 'staff'){
                        return $data->kakitangan->CONm;
                    }else{
                        return $data->role;
                    }
          }
        ],
   [
        'label'=>'Action',
        'format' => 'raw',
        'value' => function($data){
                return Html::a('<i class="fa fa-edit"></i>', ["updateshortcut", 'id' => $data->id], ['target' => '_blank']).
                       '  '.Html::a('<i class="fa fa-trash"></i>', ["deleteshortcut", 'id' => $data->id], ['target' => '_blank', 'data'=>['confirm'=>'Are you sure?']]);
                },
],
       
      
       
    ],
]);
?>
    </div></div>
</div>
