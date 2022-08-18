<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
error_reporting(0); 

/* @var $this yii\web\View */
/* @var $searchModel app\models\Ln1Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<!--<div class="row">
<div class="col-md-12">
    <= $this->render('/ptm/_topmenu') ?>
</div>
</div>-->

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                    <li><a class="close-link"><i class="fa fa-close"></i></a></li> -->
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                
                <?php
                $form = ActiveForm::begin([
                            'action' => ['index'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]);
                ?>
                
                <div class="form-group">
                    <?= Select2::widget([
                        'name' => 'ICNO',
                        'value' => Yii::$app->request->queryParams['ICNO'],
                        'data' => ArrayHelper::map($peserta, 'ICNO', 'CONm'),
                        'options' => [
                            'placeholder' => 'Nama Kakitangan',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);?>
                </div>
                
                <br>

                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Cari', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-xs-12">
     <div class="x_panel">
         <div class="x_title">
            <h2><strong>Rekod Kursus BITK</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
          <h1><?= Html::encode($this->title) ?></h1>

        <div class="x_content">
        <p>
            <?= Html::button('Tambah Rekod <i class="fa fa-plus" aria-hidden="true"></i>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tambah-bitk']),'class' => 'btn btn-primary mapBtn']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn',
                    'header' => 'Bil.',],

                [
                            'label' => 'ICNO',
                            'value' => 'ICNO',
                        ],

                [
                            'label' => 'Nama',
                            'value' => 'kakitangan.CONm',
                        ],
                
                [
                            'label' => 'Jabatan',
                            'value' => 'kakitangan.department.fullname',
                        ],
                
                [
                            'label' => 'Status Lantikan',
                            'value' => 'kakitangan.statusLantikan.ApmtStatusNm',
                        ],
                
                [
                            'label' => 'Status',
                            'value' => 'kakitangan.serviceStatus.ServStatusNm',
                        ],
                
//                ['class' => 'yii\grid\ActionColumn',],
//                ['class' => 'yii\grid\ActionColumn', 'template' => '{view}{update} '], 
                
                 [
                        'label'=>'Tindakan',
                        'format' => 'raw',
                        'value'=>function ($model){
                                return Html::a('<i class="fa fa-eye">', ['admin-view', 'id'=>$model->ICNO])  ;
//                              return Html::a('<i class="fa fa-eye">', ['admin-view','id'=>$data->ICNO]) ;          
                        },
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                          
                    ],
            ],
        ]); ?>
        </div>
     </div>
</div>
</div>
