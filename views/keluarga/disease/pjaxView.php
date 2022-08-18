<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
?>
<div class="countries-index">
    <p>
    <?= Html::button('Add Disease', ['value' => Url::to(['keluarga/add-disease','id'=>$new_disease->FamilyId]), 'class' => 'showModalButton btn btn-success',]); ?> 
    </p>    
    
<?php Pjax::begin(['id' => 'countries']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'FamilyId',
            'description',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end() ?>
</div>
