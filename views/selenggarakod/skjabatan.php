<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;


$this->title = 'Jabatan';
?>
<div class="jabatan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Kembali', ['selenggarakod/skindex'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Tambah Jabatan', ['tk_jabatan?id='], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
             'header'=>'Bil.',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:5%','bgcolor'=>'#e8e9ea'],],
            ['label' => 'Nama JAFPIB',
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
            ['label' => 'Singkatan JAFPIB',
            'format' => 'raw',
            'filter' => Select2::widget([
                'name' => 'shortname',
                'value' => isset(Yii::$app->request->queryParams['shortname'])? Yii::$app->request->queryParams['shortname']:'',
                'data' => ArrayHelper::map(Department::find()->all(), 'shortname', 'shortname'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
            'value' => 'shortname',
            //'contentOptions' => ['style' => 'text-decoration: underline;'],
            'vAlign' => 'middle',
            'hAlign' => 'center',
            ],
            
            ['label'=>'Ketua JAFPIB',
             'value'=>function($model){
                 if($model->chiefBiodata){
                    return $model->chiefBiodata->CONm;
                 }
                 return $model->chief;
             },
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:30%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Pegawai Pendaftar',
             'value'=>function($model){
                 if($model->ppBiodata){
                     return $model->ppBiodata->CONm;
                 }
                 return $model->pp;
             },
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:30%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Kategori',
             'value'=> function($model){
                 if($model->deptCat){
                    return $model->deptCat->category;
                 }
                 return $model->dept_cat_id;
             },
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],
            ['label'=>'No. Telefon',
             'value'=>'tel_no',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],
            ['label'=>'No. UC',
             'value'=>'uc_no',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],
            
            ['label'=>'Alamat',
             'value'=>'address',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Status',
             'value'=>function($model){
                 return $model->active;
             },
             'format'=>'raw',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],


            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Tindakan',
             'template' => '{tk_jabatan} | {tk_ad}',
               'buttons'=>[
                'tk_jabatan' => function($url){
                    return Html::a('<span class="fa fa-pencil"></span>', $url);
                },
                'tk_ad' => function ($url, $model) {
                    $icon = 'fa fa-window-close-o';
                    $status = 'deactive';
                    if($model->isActive == 0){
                        $icon = 'fa fa-check-square-o';
                        $status = 'activate';
                    }
                    return Html::a('<span class="'.$icon.'"></span>', $url, ['class' => 'text-center ',
                    'data' => [
                        'confirm' => 'Do you wish to '.$status.' this department ?',
                        'method' => 'post',
                            ],]);
                },
            
            ],
             'contentOptions' => ['class' => 'text-center'],
             'headerOptions' => ['class'=>'text-center','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
        ],
    ]); ?>
</div>
