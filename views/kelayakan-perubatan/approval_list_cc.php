<?php

use app\models\hronline\certificateType;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

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
        <h4><?= "APPROVAL LIST" ?></h4>
        <div class="clearfix"></div>
    </div>
    <p>
        <?php // \yii\helpers\Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="row">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'label'=>'NO.KP/Passport',
                    'attribute'=>'icno',
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea','style' => 'width:10%'],
                    'filterInputOptions' => [
                        'class'       => 'form-control',
                        'placeholder' => 'Carian no. KP atau Paspot'
                    ],
                ],
                [
                    'label'=>'Type',
                    'filter' => Select2::widget([
                        'model'=>$searchModel,
                        'attribute' => 'type',
                        'data' => ArrayHelper::map(certificateType::find()->where(['isActive'=>1])->orderBy(['id'=> SORT_ASC])->all(), 'id', 'certType'),
                        'options' => ['placeholder' => 'Pilih..'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'value'=>function($model){
                        return $model->certType->certType;
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    'format' => 'raw',
                ],
                [
                    'label'=>'Title',
                    // 'attribute'=>'title',
                    'value'=>'title',
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    // 'filterInputOptions' => [
                    //     'class'       => 'form-control',
                    //     'placeholder' => 'title'
                    // ],
                ],
                [
                    'label' => 'Start Date',
                    'value' => function($model){
                       return Yii::$app->MP->Tarikh($model->startDt);
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    'format' => 'raw',
                ],
                [
                    'label' => 'End Date',
                    'value' => function($model){
                       return Yii::$app->MP->Tarikh($model->endDt);
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    'format' => 'raw',
                ],
                [
                    'label' => 'Award By',
                    'value' => function($model){
                        return $model->awardBy;
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Admin Action',
                    'template' => '{lihat-cc}',
                    'buttons' => [
                        // 'lock-unlock-clockin' => function ($url, $model) {
                        //     $lock = 'fa fa-unlock';
                        //     $status = 'not allow';
                        //     if($model->isAllowed == 0){
                        //         $lock = 'fa fa-lock';
                        //         $status = 'allow';
                        //     }
                        //     return Html::a('<span class="'.$lock.'"></span>', $url, ['class' => 'text-center btn btn-primary',
                        //     'data' => [
                        //         'confirm' => 'Do you wish to '.$status.' clock-in for this staff ?',
                        //         'method' => 'post',
                        //             ],]);
                        // },
                    ],
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['class' => 'text-center', 'style' => 'width:10%', 'bgcolor' => '#e8e9ea'],
                ],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    // you may configure additional properties here
                ], 
            ],
        ]) ?>
    </div>
    <div class="center pull-right">
       
        <?= Html::submitButton('<i class="fa fa-check"></i> Tolak', ['class' => 'btn btn-danger', 'name' => '_action', 'value' => 'tolak']) ?>
        <?= Html::submitButton('<i class="fa fa-check"></i> Terima', ['class' => 'btn btn-success', 'name' => '_action', 'value' => 'terima']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>