<?php

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Admin Reset Password';
?>
<div class="gelaran-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Kembali', ['skindex'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Tambah Aksess', ['tk_adminrp?id'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
             'header'=>'Bil.',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:5%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'IC/KP',
             'value'=>'icno',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:30%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Access Type',
             'value'=>function($model){
                if($model->access_type == 1){
                   return 'View only' ;
                }
                return 'View and Reset Password';
            },
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:0%','bgcolor'=>'#e8e9ea'],],
             ['label'=>'is Active',
             'value'=>function($model){
                 if($model->isActive == 1){
                    return 'Active' ;
                 }
                 return 'Inactive';
             },
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:0%','bgcolor'=>'#e8e9ea'],],
            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Tindakan',
             'template' => '{tk_adminrp}',
               'buttons'=>[
                'tk_adminrp' => function($url){
                    return Html::a('<span class="fa fa-pencil"></span>', $url);
                }     ],
             'contentOptions' => ['class' => 'text-center'],
             'headerOptions' => ['class'=>'text-center','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
        ],
    ]); ?>
</div>
