<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\select2\Select2;

error_reporting(0);
?>
<?= $this->render('menu') ?> 

<?php if($title == 'Senarai Menunggu Perakuan'){?>
<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $title;?></strong></h2> 
            <div class="clearfix"></div>
        </div>
          
      
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        
             <?= GridView::widget([
                    'dataProvider' => $senarai,
//                    'filterModel' => true,
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'columns' => [],
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
//                                '{export}',
//                                '{toggleData}'
                    ],
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>Semakan Permohonan</h2>',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => '#',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ],
//            [
//                'label' => 'Nama',
//                'value' => 'biodata.CONm',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//            ],
             [
                'label' => 'Nama',
                'format' => 'raw',
                'filter' => Select2::widget([
                'name' => 'card_owner',
                'value' => isset(Yii::$app->request->queryParams['card_owner'])? Yii::$app->request->queryParams['card_owner']:'',
                'data' => ArrayHelper::map(\app\models\Kadpekerja\Kadpekerja::find()->all(), 'card_owner', 'card_owner'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                 'allowClear' => true
                ],
            ]),
                 

                'value' => 'card_owner',

            ],
//            [
//                'label' => 'UMS-PER',
//                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//                'value'=>'card_id',
//            ],
            [
                'label' => 'UMS-PER',
                'format' => 'raw',
                'filter' => Select2::widget([
                'name' => 'card_id',
                'value' => isset(Yii::$app->request->queryParams['card_id'])? Yii::$app->request->queryParams['card_id']:'',
                'data' => ArrayHelper::map(\app\models\Kadpekerja\Kadpekerja::find()->all(), 'card_id', 'card_id'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                 'allowClear' => true
                ],
            ]),
               

             'value' => 'card_id', 
            ],
//             [
//                'label' => 'ICNO',
//                'value' => 'biodata.ICNO',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//            ],      
            [
                'label' => 'ICNO',
                'format' => 'raw',
                'filter' => Select2::widget([
                'name' => 'icno',
                'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                'data' => ArrayHelper::map(\app\models\Kadpekerja\Kadpekerja::find()->all(), 'icno', 'icno'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                 'allowClear' => true
                ],
            ]),
              'value'=>function ($data) {
              return '<small>'. strtoupper($data->biodata->ICNO). '</small>';
              },

             'value' => 'icno', 
            ],
            
//            [
//                'label' => 'Jenis Permohonan',
//                'value' => 'kadPekerja.card_type',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//            ],
            [
                'label' => 'Jenis Permohonan',
                'format' => 'raw',
                'filter' => Select2::widget([
                'name' => 'card_type',
                'value' => isset(Yii::$app->request->queryParams['card_type'])? Yii::$app->request->queryParams['card_type']:'',
                'data' => ArrayHelper::map(\app\models\Kadpekerja\Kadpekerja::find()->all(), 'card_type', 'kadPekerja.card_type'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                 'allowClear' => true
                ],
            ]),
              

             'value' => 'kadPekerja.card_type', 
            ],
             
            [
                'label' => 'Tarikh Mohon',
                'value' => 'entrydt',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
//            [
//                'label' => 'Payment',
//                'value' => '',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//            ],
            [
                'label' => 'Pegawai KP',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'verstatus',
            ],
            [
                'label' => 'Ketua Seksyen',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'appstatus',
            ],
            
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list){
                            if($list->isActive == 1){
                        return  
                        Html::a('<i class="fa fa-edit">', ["kadpekerja/tindakan-tadbir", 'id' => $list->id]);
                            }
                           
                        
                      },
            ], 
               
        ],
    ]); ?>
        
    </div>
        <?php }?>
        
        <?php if($title == 'Senarai Menunggu Kelulusan'){?>
<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $title;?></strong></h2> 
            <div class="clearfix"></div>
        </div>
          
      
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        
             <?= GridView::widget([
                    'dataProvider' => $senarai,
//                    'filterModel' => true,
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'columns' => [],
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
//                                '{export}',
//                                '{toggleData}'
                    ],
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>Semakan Permohonan</h2>',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => '#',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ],
//            [
//                'label' => 'Nama Pemohon',
//                'value' => 'biodata.CONm',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//            ],
             [
                'label' => 'Nama',
                'format' => 'raw',
                'filter' => Select2::widget([
                'name' => 'card_owner',
                'value' => isset(Yii::$app->request->queryParams['card_owner'])? Yii::$app->request->queryParams['card_owner']:'',
                'data' => ArrayHelper::map(\app\models\Kadpekerja\Kadpekerja::find()->all(), 'card_owner', 'card_owner'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                 'allowClear' => true
                ],
            ]),
                 

                'value' => 'card_owner',

            ],
             [
                'label' => 'UMS-PER',
                'format' => 'raw',
                'filter' => Select2::widget([
                'name' => 'card_id',
                'value' => isset(Yii::$app->request->queryParams['card_id'])? Yii::$app->request->queryParams['card_id']:'',
                'data' => ArrayHelper::map(\app\models\Kadpekerja\Kadpekerja::find()->all(), 'card_id', 'card_id'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                 'allowClear' => true
                ],
            ]),
               

             'value' => 'card_id', 
            ],
                         [
                'label' => 'ICNO',
                'format' => 'raw',
                'filter' => Select2::widget([
                'name' => 'icno',
                'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                'data' => ArrayHelper::map(\app\models\Kadpekerja\Kadpekerja::find()->all(), 'icno', 'icno'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                 'allowClear' => true
                ],
            ]),
              'value'=>function ($data) {
              return '<small>'. strtoupper($data->biodata->ICNO). '</small>';
              },

             'value' => 'icno', 
            ],
            [
                'label' => 'Jenis Permohonan',
                'format' => 'raw',
                'filter' => Select2::widget([
                'name' => 'card_type',
                'value' => isset(Yii::$app->request->queryParams['card_type'])? Yii::$app->request->queryParams['card_type']:'',
                'data' => ArrayHelper::map(\app\models\Kadpekerja\Kadpekerja::find()->all(), 'card_type', 'kadPekerja.card_type'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                 'allowClear' => true
                ],
            ]),
              

             'value' => 'kadPekerja.card_type', 
            ],
            [
                'label' => 'Tarikh Mohon',
                'value' => 'entrydt',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
//            [
//                'label' => 'Payment',
//                'value' => '',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//            ],
            [
                'label' => 'Pegawai KP',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'verstatus',
            ],
            [
                'label' => 'Ketua Seksyen',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'appstatus',
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list){
                            if($list->isActive == 1){
                        return  
                        Html::a('<i class="fa fa-edit">', ["kadpekerja/tindakan-ks", 'id' => $list->id]);
                            }
                           
                        
                      },
            ],
              
        ],
    ]); ?>
        
    </div>
        <?php }?>
        <div class="x_content"> 
        <ul>
            <li><span class="label label-warning">Pending Payment</span> : Status pembayaran belum lengkap.</li>
            <li><span class="label label-success">Menunggu Kutipan</span> : Permohonan berjaya dan sila kutip Kad Pekerja dikaunter keselamatan.</li>
             
        </ul>
        </div> 
  
    </div>
</div></div>
