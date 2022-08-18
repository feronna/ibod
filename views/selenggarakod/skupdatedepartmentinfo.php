<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;


$this->title = 'Jabatan Info';
?>
<div class="bandar-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Kembali', ['selenggarakod/skindex'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
             'header'=>'Bil.',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:5%','bgcolor'=>'#e8e9ea'],],
            ['label' => 'Department Name',
            'format' => 'raw',
            'filter' => Select2::widget([
                'name' => 'fullname',
                'value' => isset(Yii::$app->request->queryParams['fullname'])? Yii::$app->request->queryParams['fullname']:'',
                'data' => ArrayHelper::map(Department::find()->all(), 'fullname', 'fullname'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
            'value' => 'fullname',
            //'contentOptions' => ['style' => 'text-decoration: underline;'],
            'vAlign' => 'middle',
            'hAlign' => 'center',
            ],
            
            ['label'=>'Head Name',
             'value'=>function($model){
                 if($model->chiefBiodata){
                    return $model->chiefBiodata->CONm;
                 }
                 return $model->chief;
             },
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:30%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'P.A. Email',
             'value'=>'pa_email',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:30%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Office No.',
             'value'=>'tel_no',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],
            ['label'=>'UC No.',
             'value'=>'uc_no',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Fax No.',
             'value'=>'fax_no',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:15%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Address',
             'value'=>'address',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],


            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Tindakan',
             'template' => '{tk_updatedepartmentinfo}',
               'buttons'=>[
                'tk_updatedepartmentinfo' => function($url){
                    return Html::a('<span class="fa fa-pencil"></span>', $url);
                }     ],
             'contentOptions' => ['class' => 'text-center'],
             'headerOptions' => ['class'=>'text-center','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
        ],
    ]); ?>
</div>
