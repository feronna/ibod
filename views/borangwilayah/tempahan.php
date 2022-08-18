<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

?>

 <?= GridView::widget([
                    'dataProvider' => $dataProvider, 
                    'filterModel' => true,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'columns' => [],
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ], 
                    'beforeHeader' => [
                    [
                        'columns' => [
                            ['content' => 'WILAYAH ASAL', 'options' => ['colspan' => 10, 'class' => 'text-center ',
                                'style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                              
                            ],
                        ],
                    ]
                ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => '#',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ],
            // [
            //     'label' => 'Nama Pemohon',
            //     'value' => 'kakitangan.CONm',
            //     'headerOptions' => ['class'=>'text-center'],
            //                     'contentOptions' => ['class'=>'text-center'],
            // ], 

            [
                'label' => 'Nama Pemohon',
                'format' => 'raw',
                'filter' => Select2::widget([
                'name' => 'nama',
                'value' => isset(Yii::$app->request->queryParams['nama'])? Yii::$app->request->queryParams['nama']:'',
                'data' => ArrayHelper::map(\app\models\kemudahan\Borangwilayah::find()->where(['pengakuan' => 1])->all(), 'nama', 'nama'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                 'allowClear' => true
                ],
            ]),
                'value'=>function ($list) {
                return '<small>'. strtoupper($list->kakitangan->CONm). '</small>';
                },

                'value' => 'kakitangan.CONm',

            ],
             
            [
                'label' => 'Tarikh Mohon',
                'value' => 'entrydate',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
             
             
            [
                'label' => 'Status Ketua BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'statuskj',
            ],
          
            [
                'label' => 'Dokumen Sokongan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-left'],
                
               'value'=>function ($list){ 
                        if($list->dokumen_sokongan2 == null){
                            return '';
                        }else{
                       return  Html::a(' CUTI REHAT', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan2), ['class'=>'fa fa-download', 'target' => '_blank']);
//                              .Html::a(' DOKUMEN SOKONGAN', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan), ['class'=>'fa fa-download', 'target' => '_blank']);
                        }  
                      
                      },
            ], 
            
            [
                'label' => 'Salinan Surat',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-left'],
                
               'value'=>function ($list){
                            if($list->isActive == '1' ){
                        return  Html::a(' KELULUSAN KETUA BSM', ['borangwilayah/slulus', 'id' => $list->id], ['class'=>'fa fa-download', 'target' => '_blank']);
                            } 
                      },
            ],
               [
                'label' => 'Status Tempahan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'tempahan',
            ],
             [
                'label' => 'Tempahan Tiket',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'], 
                'value'=>function ($list){
                        if($list->isActive == '1' ){
                        return  Html::a('<i class="fa fa-edit">', ["borangwilayah/status_tempahan", 'id' => $list->id]);
                            } 
                      },
            ],                  
              
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list){
                            if($list->stat_bendahari == 'MENUNGGU TINDAKAN' || $list->stat_bendahari == 'DALAM PROSES BAYARAN'){
                        return  
                       Html::a('<i class="fa fa-eye">', ["borangwilayah/pentadbiran", 'id' => $list->id]);
                            }
                            else{
                        return Html::a('<i class="fa fa-eye">', ["borangwilayah/pentadbiran", 'id' => $list->id]);
                            }
                             
                      },
            ],
            
        ],
    ]); ?>

