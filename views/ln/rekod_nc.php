<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
error_reporting(0); 
?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<?php echo $this->render('/ln/_topmenu'); ?> 
</div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><?php echo $title;?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <?=
                        GridView::widget([
                        'options' => [
                        'class' => 'table-responsive'
                        ],
                        'dataProvider' => $senarai,
                        'filterModel' => true,
                        //'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        //'filterModel' => $searchModel,
                        'columns' => [
                            
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil.',
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],
                            
                        [
                            'label' => 'ICNO',
                            'value' => 'icno',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                            
                        [
                            'format' => 'raw',
                            'label' => 'Nama Kakitangan',
                            'value' => 'kakitangan.CONm',   
                            'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => $icno,
                            'data' => ArrayHelper::map(\app\models\ln\Ln::find()->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                            ]),
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],  
                                
                        [
                            'label' => 'Tarikh Mohon',
                            'value' => 'entrydate',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                
//                        [
//                            'label' => 'Status Perakuan Ketua Jabatan',
//                            'value' => 'statusjfpiu',
//                            'format' => 'raw',
//                            'vAlign' => 'middle',
//                            'hAlign' => 'center',
//                        ],    
                            
                        [
                            'label' => 'Status Perakuan Ketua Jabatan',
                            'value' => 'statusjfpiu',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'filter' => Select2::widget([
                                'name' => 'statuskj',
                                'value' => $statuskj,
                                'data' => ['Tunggu Perakuan'=>'<span class="label label-warning">Menunggu</span>',
                                           'Diperakui' => '<span class="label label-success">Diperakui</span>',
                                           'Tidak Diperakui' => '<span class="label label-danger">Tidak Diperakui</span>',
                                           '-'=>'-'],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
                        ],  
                                
//                        [
//                            'label' => 'Status Semakan Canselori',
//                            'value' => 'statussemakan',
//                            'format' => 'raw',
//                            'vAlign' => 'middle',
//                            'hAlign' => 'center',
//                        ],    
                            
                        [
                            'label' => 'Status Semakan Canselori',
                            'value' => 'statussemakan',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'filter' => Select2::widget([
                                'name' => 'statuscn',
                                'value' => $statuscn,
                                'data' => ['Tunggu Semakan'=>'<span class="label label-warning">Menunggu</span>',
                                           'Diperakui' => '<span class="label label-success">Diperakui</span>',
                                           'Tidak Diperakui' => '<span class="label label-danger">Tidak Diperakui</span>',
                                           '-'=>'-'],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
                        ],
  
//                        [
//                            'label' => 'Status Kelulusan NC',
//                            'value' => 'statusnc',
//                            'format' => 'raw',
//                            'vAlign' => 'middle',
//                            'hAlign' => 'center',
//                        ], 
                            
                        [
                            'label' => 'Status Kelulusan NC',
                            'value' => 'statusnc',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'filter' => Select2::widget([
                                'name' => 'statusnc',
                                'value' => $statusnc,
                                'data' => ['Tunggu Kelulusan'=>'<span class="label label-warning">Menunggu</span>',
                                           'Diluluskan' => '<span class="label label-success">Diluluskan</span>',
                                           'Tidak Diluluskan' => '<span class="label label-danger">Tidak Diluluskan</span>',
                                           '-'=>'-'],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
                        ],
    
                        [
                            'label' => 'Tindakan',
                            'format' => 'raw',
                            'value'=>function ($data) use($title){
                                   if($title == 'Senarai Rekod Kelulusan'){
                                      return 
                                    Html::a('<i class="fa fa-eye">', ["tindakan-nc", 'id' => $data->id], ['target' => '_blank']);
                                }  
                            },
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