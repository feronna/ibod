<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\hronline\StatusLantikan;


$this->title = 'Sub Status Lantikan';
?>
<div class="jenis-alamat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Kembali', ['skindex'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Tambah Kod', ['tk_subapmtstatus?id='], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' =>['class' => 'table table-bordered table-sm'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
             'header'=>'Bil.',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:5%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'ID',
             'value'=>'id',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:15%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Nama Sub Status Lantikan',
             'value'=>'SubApmtStatusNm',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:40%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Nama Status Lantikan',
             'value'=>function($model){
                 $apmtstatusnm = StatusLantikan::find()->select('ApmtStatusNm')->where(['ApmtStatusCd'=>$model->ApmtStatusCd])->asArray()->one();
                 if(!empty($apmtstatusnm)){
                     return $apmtstatusnm['ApmtStatusNm'];
                 }
                 return $model->ApmtStatusCd;
             },
             'format' => 'raw',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:40%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Status',
             'value'=>'isActive',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],
            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Tindakan',
             'template' => '{tk_subapmtstatus}',
               'buttons'=>[
                'tk_subapmtstatus' => function($url){
                    return Html::a('<span class="fa fa-pencil"></span>', $url);
                }     ],
             'contentOptions' => ['class' => 'text-center'],
             'headerOptions' => ['class'=>'text-center','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
        ],
    ]); ?>
</div>
