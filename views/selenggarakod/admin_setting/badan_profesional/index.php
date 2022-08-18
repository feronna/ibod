<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Setting Badan Profesional';
?>
<div class="jenis-alamat-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Kembali', ['skindex'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' =>['class' => 'table table-bordered table-sm'],
        'columns' => [
            ['label'=>'ID',
             'value'=>'ProfBodyCd',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:15%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Nama',
             'value'=>'ProfBody',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:40%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Status',
             'value'=>'status',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Tindakan',
             'template' => '{lihat-badanprofesional-skim}',
               'buttons'=>[   
                'lihat-badanprofesional-skim' => function($url,$model){
                    return Html::a('<span class="fa fa-eye"></span>', ['lihat-badanprofesional-skim','bp_id'=>$model->ProfBodyCd]);
                } ,    
            ],
             'contentOptions' => ['class' => 'text-center'],
             'headerOptions' => ['class'=>'text-center','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
        ],
    ]); ?>
</div>
