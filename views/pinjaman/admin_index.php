<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\kontrak\KontrakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 error_reporting(0); 
?>
 
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1306,1309,1312], 'vars' => []]); ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="src/jquery.table2excel.js"></script>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Search</strong></h2>
                <div class="form-group text-right">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['admin-index', 'id' => $icno], 'GET'); ?> 
                 <?= Select2::widget([
                        'name' => 'carian_icno',
                        'value' => Yii::$app->request->queryParams['carian'],
                        'data' => ArrayHelper::map(\app\models\Pinjaman\Pinjaman::find()->all(), 'icno', 'icno'),
                        'options' => ['placeholder' => 'ICNO'
                            ],
                            'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);?>
                <br>
                
                  
                <div class="form-group">
                     <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-1">
                         <br>
                      <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary']) ?> 
                      <?= Html::a('Reset', ['admin-index'], ['class' => 'btn btn-warning']) ?> 
                </div>
                </div>
                <?= Html::endForm(); ?>

            </div>
        </div>
    </div>
</div>
 

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Pinjaman Peribadi</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
 
                <br>
                <div class="row"> 
                <div class="col-xs-12 col-md-12 col-lg-12"> 
  
                    <div class="x_content">
                         
                        
                        <div class="table-responsive">
                    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'columns' => [],
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
 
                    ],
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>Permohonan Pinjaman Peribadi</h2>',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => 'Bil',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ],
                        [
                            'label' => 'Nama',
                            'value' => 'biodata.CONm',
                                                       
                        ],
                        [
                            'label' => 'No.IC',
                            'value' => 'biodata.ICNO',
                            
                        ],
                        
                         [
                            'label' => 'Jabatan',
                            'value' => 'biodata.department.shortname',
                            
                        ],
                      
                         [
                            'label' => 'Tindakan',
                            'format' => 'raw', 
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'], 
                            'value'=>function ($list){
                            return Html::a('', ['pinjaman/detail-view', 'id' => $list->id, 'icno' => $list->icno], [
                            'class' => 'btn btn-info fa fa-eye',
                             
                        ])      
                            .Html::a('', ['delete', 'id' => $list->id], [
                            'class' => 'btn btn-danger fa fa-trash',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                          
                        
                      },
                            
                        ],           
                        
  
                    ],
                           
                           
                ]); ?>
                </div>
        
            
                    </div>

                </div>
            </div>

            </div>
        </div>
    </div>
</div>
 
 