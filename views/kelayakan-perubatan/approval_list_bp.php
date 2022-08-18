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
        <h4><?= "PROFESSIONAL ASSOCIATION: APPROVAL LIST" ?></h4>
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="row">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'label'=>'NO.KP/Passport',
                    'attribute'=>'ICNO',
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea','style' => 'width:10%'],
                    'filterInputOptions' => [
                        'class'       => 'form-control',
                        'placeholder' => 'Carian no. KP atau Paspot'
                    ],
                ],
                [
                    'label'=>'Badan Profesional',
                    'value'=>function($model){
                        return $model->badanProfesional->ProfBody;
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    'format' => 'raw',
                ],
                [
                    'label'=>'Taraf Keahlian',
                    // 'attribute'=>'title',
                    'value'=>function($model){
                        return $model->tarafKeahlian->MembershipType;
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    // 'filterInputOptions' => [
                    //     'class'       => 'form-control',
                    //     'placeholder' => 'title'
                    // ],
                ],
                [
                    'label' => 'Tarikh Serta',
                    'value' => function($model){
                       return Yii::$app->MP->Tarikh($model->JoinDt);
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    'format' => 'raw',
                ],
                [
                    'label' => 'Tarikh Tamat',
                    'value' => function($model){
                       return Yii::$app->MP->Tarikh($model->ResignDt);
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                    'format' => 'raw',
                ],
                [
                    'label' => 'Status',
                    'value' => function($model){
                        return $model->staaktif;
                    },
                    'headerOptions' => ['class' => '','bgcolor' => '#e8e9ea'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Admin Action',
                    'template' => '{lihat-bp}',
                    'buttons' => [
                        'lihat-bp' => function ($url, $model) {
                            return Html::a('<span class="fa fa-eye"></span>', ['admin-view-bp','id'=>$model->profId], ['class' => 'text-center','target'=>'_blank']);
                        },
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