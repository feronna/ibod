<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Program Vaksinasi';
?>
<style>
    .fix-width>tbody>tr>th {
        width: 30%;
    }
</style>

<?php echo $this->render('/kehadiran/_menu'); ?>



<div class="x_panel">
    <div class="x_title">
        <h4><?= "VAKSINASI WATCH LIST" ?></h4>
        <div class="clearfix"></div>
    </div>
    <p>
        <?php // \yii\helpers\Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="row">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'label'=>'NO.KP/Passport',
                    'attribute'=>'icno',
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    'filterInputOptions' => [
                        'class'       => 'form-control',
                        'placeholder' => 'Carian no. KP atau Paspot'
                    ],
                ],
                [
                    'label'=>'Name',
                    'attribute'=>'name',
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    'filterInputOptions' => [
                        'class'       => 'form-control',
                        'placeholder' => 'Carian nama staf'
                    ],
                ],
                [
                    'label'=>'Category',
                    'filter' => Select2::widget([
                        'model'=>$searchModel,
                        'attribute' => 'category',
                        'data' => ['1'=>'Belum Kemasini','2'=>'Belum Vaksin'],
                        'options' => ['placeholder' => 'Pilih..'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'value'=>function($model){
                        return ($model->category == 1 ) ? 'Belum Kemaskini' : 'Belum Vaksin';
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                ],
                [
                    'label'=>'Sample Covid19 Test',
                    'filter' => Select2::widget([
                        'model'=>$searchModel,
                        'attribute' => 'sample_result',
                        'data' => ['-1'=>'Tidak Berkaitan','0'=>'Belum mengambil sample','Pending'=>'Pending','Detected'=>'Detected','Not Detected'=> 'Not Detected'],
                        'options' => ['placeholder' => 'Pilih..'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'value'=>function($model){

                        switch ($model->category) {
                            case '2':
                                if($model->covid19Sample){
                                    if($model->covid19Sample->isVerified == 'Yes'){
                                        switch ($model->covid19Sample->result) {
                                            case 'Not Detected':
                                                $label = 'label-success';
                                                break;
                                            
                                            default:
                                                $label = 'label-danger';
                                                break;
                                        }
                                        return '<span class="label '.$label.'">'.$model->covid19Sample->result.'</span>';
                                    }else{
                                        return '<span class="label label-warning">'.$model->covid19Sample->result. '. Not Verified.</span>';
                                    }
                                }
                                return '<span class="label label-danger">Belum mengambil sample</span>';
                                break;
                            
                            default:
                                return '<span class="label label-success">Tidak Berkaitan</span>';
                                break;
                        }
                        
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    'format' => 'raw',
                ],
                [
                    'label' => 'is allowed to clock-in',
                    'filter' => Select2::widget([
                        'model'=>$searchModel,
                        'attribute' => 'isAllowed',
                        'data' => ['1'=>'Allowed','0'=>'Not Allowed'],
                        'options' => ['placeholder' => 'Pilih..'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'value' => function($model){
                        if($model->isAllowed){
                            return '<span class="label label-success">Allowed / Unlocked</span>';
                        }
                        return '<span class="label label-danger">Not Allowed / Locked</span>';
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    'format' => 'raw',
                ],
                [
                    'label' => 'is updated by staff',
                    'filter' => Select2::widget([
                        'model'=>$searchModel,
                        'attribute' => 'isDone',
                        'data' => ['1'=>'Updated','0'=>'Not Yet'],
                        'options' => ['placeholder' => 'Pilih..'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'value' => function($model){
                        if($model->isDone){
                            return '<span class="label label-success">Updated</span>';
                        }
                        return '<span class="label label-danger">Not Yet</span>';
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Admin Action',
                    'template' => '{lock-unlock-clockin}',
                    'buttons' => [
                        'lock-unlock-clockin' => function ($url, $model) {
                            $lock = 'fa fa-unlock';
                            $status = 'not allow';
                            if($model->isAllowed == 0){
                                $lock = 'fa fa-lock';
                                $status = 'allow';
                            }
                            return Html::a('<span class="'.$lock.'"></span>', $url, ['class' => 'text-center btn btn-primary',
                            'data' => [
                                'confirm' => 'Do you wish to '.$status.' clock-in for this staff ?',
                                'method' => 'post',
                                    ],]);
                        },
                    ],
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['class' => 'text-center', 'style' => 'width:10%', 'bgcolor' => '#e8e9ea'],
                ],
            ],
        ]) ?>
    </div>

</div>