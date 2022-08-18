<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
error_reporting(0); 
?>

<div class="row">
<div class="col-md-12">
    <?php echo $this->render('/tblrscoadminpost/_topmenu'); ?> 
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>  -->
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                
                <?php
                $form = ActiveForm::begin([
                            'action' => ['admin-post-list'],
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
                        'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->all(), 'ICNO', 'kakitangan.CONm'),
                        //'data' => ArrayHelper::map($peserta, 'ICNO', 'CONm'),
                        'options' => [
                            'placeholder' => 'Nama Kakitangan',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);?>
                </div>
                
                <div class="form-group">
                    <?= Select2::widget([
                        'name' => 'adminpos_id',
                        'value' => Yii::$app->request->queryParams['adminpos_id'],
                        'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->all(), 'adminpos_id', 'adminpos.position_name'),
                        'options' => [
                            'placeholder' => 'Jawatan Pentadbiran',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);?>
                </div>
                
                <div class="form-group">
                 <?= Select2::widget([
                        'name' => 'dept_id',
                        'value' => Yii::$app->request->queryParams['dept_id'],
                        'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->all(), 'dept_id', 'dept.fullname'),
                        'options' => ['placeholder' => 'JFPIB'
                            ],
                            'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);?>
                </div>
                
                <div class="form-group">
                 <?= Select2::widget([
                        'name' => 'campus_id',
                        'value' => Yii::$app->request->queryParams['campus_id'],
                        'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->all(), 'campus_id', 'campus.campus_name'),
                        'options' => ['placeholder' => 'Kampus'
                            ],
                            'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);?>
                </div>
                
                <div class="form-group">
                 <?= Select2::widget([
                        'name' => 'flag',
                        'value' => Yii::$app->request->queryParams['flag'],
                        'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->all(), 'flag', 'displayflag.flagstatus'),
                        'options' => ['placeholder' => 'Status'
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
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Rekod Lantikan (Keseluruhan)</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <?=
                        GridView::widget([
                        'options' => [
                        'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        //'summary' => '',
                        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        //'filterModel' => $searchModel,
                        'columns' => [
                             
                                [
                         'class' => 'kartik\grid\SerialColumn',
                        'header' => 'Bil.',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],

                                [
                        'label' => 'No IC',
                        'value' => 'ICNO',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                
                                [
                        'label' => 'Nama Staf',
                        'value' => 'kakitangan.CONm',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                
                                 [
                        'label' => 'Jawatan Pentadbiran',
                        'value' => 'adminpos.position_name',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],   
                            
                                [
                        'label' => 'Catatan',
                        'value' => 'description',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],  
                            
                                
                                [
                        'label' => 'JFPIB',
                        'value' => 'dept.fullname',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],     
                                
                                [
                        'label' => 'Kampus',
                        'value' => 'campus.campus_name',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],           
                                
                                [
                        'label' => 'Tarikh Kuatkuasa',
                        'attribute' => 'tarikhkuatkuasa',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],            
                                
                               [
                        'label' => 'Tarikh Tamat',
                        'attribute' => 'tarikhtamat',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],           
                                        
                               [
                        'label' => 'Status',
                        'attribute' => 'displayflag.flagstatus',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                
                                [
                        'label'=>'Tindakan',
                        'format' => 'raw',
                        'value'=>function ($data){
                              return Html::a('<i class="fa fa-eye">', ['admin-view','id'=>$data->ICNO]) ;          
                        },
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                          
                    ],
                            ],
                                
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>