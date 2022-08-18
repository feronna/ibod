<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
error_reporting(0); 
?>

<!--<div class="row">
<div class="col-md-12">
    <php echo $this->render('/tblrscoadminpost/_topmenu'); ?> 
</div>
</div>-->

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/harta/_menu');?>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
     
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>SENARAI REKOD AKSES</strong></h2>
        
      
                <div class="clearfix"></div>
            </div>
  
           
            <div class="x_content">
                
               <?= Html::a('Tambah Akses', ['tambah-akses'], ['class' => 'btn btn-warning']) ?>  

                <div class="table-responsive">
                    <?=
                        GridView::widget([
                        'options' => [
                        'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        'filterModel' => true,
                        //'summary' => '',
                        //'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        //'filterModel' => $searchModel,
                        'columns' => [
                             
                                [
                         'class' => 'kartik\grid\SerialColumn',
                        'header' => 'Bil.',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
  
                   [
                        'format' => 'raw',
                        'label' => 'Nama Kakitangan',
                        'value' => 'penyeliaBiodata.CONm',
                    
                        'filter' => Select2::widget([
                        'name' => 'akses_icno',
                        'value' => $akses_icno,
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                       'data' =>  ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->andWhere(['Status' => 1])->all(), 'ICNO', 'CONm'),
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],
                                
                        [
                        'format' => 'raw',
                        'label' => 'Jenis Akses',
            
                        'value' => function($model) {
                            if ($model->jenis_akses == 2){
                             return '<span class="label label-primary">Penyelia Sistem</span>';
                           
                            }if ($model->jenis_akses == 3){
                             return '<span class="label label-success">Admin</span>';
                           
                            } 
                       
                        },
                        'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],
                                
                     [
                        'label' => 'Jawatan',
                        'value' => 'penyeliaBiodata.jawatan.fname',
                         'filter' => Select2::widget([
                         'name' => 'gredJawatan',
                         'value' => $gredJawatan,
                          'data' => ArrayHelper::map(\app\models\hronline\GredJawatan::find()->all(), 'id', 'fname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ], 
                            
                    [
                        'label' => 'Jabatan',
                        'value' => 'penyeliaDepartment.fullname',
                         'filter' => Select2::widget([
                         'name' => 'akses_dept',
                         'value' => $akses_dept,
                          'data' => ArrayHelper::map(\app\models\hronline\Department::find()->all(), 'id', 'fullname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ], 

                    [
                        'label' => 'Kampus',
                        'value' => 'penyeliaCampus.campus_name',
                         'filter' => Select2::widget([
                         'name' => 'akses_campus',
                         'value' => $akses_campus,
                          'data' => ArrayHelper::map(\app\models\hronline\Campus::find()->all(), 'campus_id', 'campus_name'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ], 
                                
                                
                    [
                        'format' => 'raw',
                        'label' => 'Tindakan',
            
                        'value' => function($model) {
                        return  Html::a('<i class="fa fa-trash-o"></i>', ['delete-akses', 'id' => $model->id], [
                        'data' => [
                        'confirm' => 'Adakah anda pasti untuk memadamnya?',
                        'method' => 'post',
                           ],
                          ]);
                       
                        },
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],

                                         
                            ],
                                
                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                        'resizableColumns' => true,
                        'responsive' => false,
                        'responsiveWrap' => false,
                        'floatHeader' => true,
                        'floatHeaderOptions' => ['position' => 'absolute'],
                        'resizableColumnsOptions' => ['resizeFromBody' => true]
                                
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>