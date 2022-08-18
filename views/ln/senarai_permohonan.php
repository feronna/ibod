<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
error_reporting(0); 
?>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<?php echo $this->render('/ln/_topmenu'); ?> 
</div>
</div>  

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
<!--                <= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Kembali', ['halaman-utama-akademik'], ['class' => 'btn btn-primary']) ?><br>-->
                <h2><strong>Senarai Permohonan Bertugas Rasmi Di Luar Negara</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?></p>   
                <div class="clearfix"></div>
            </div>
            <!--<= Html::a('Kembali', ['halaman-utama-akademik'], ['class' => 'btn btn-primary']) ?>-->
<!--            <= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['reportakademik', 'icno' => Yii::$app->request->queryParams['icno'], 'admin' => Yii::$app->request->queryParams['adminpos_id'], 'program' => Yii::$app->request->queryParams['program_id'], 'dept' => Yii::$app->request->queryParams['dept_id'], 'campus' => Yii::$app->request->queryParams['campus_id']]) ?>-->
            <div class="x_content">
                <div class="table-responsive">
                    <?=
                        GridView::widget([
                        'options' => [
                        'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        'filterModel' => true,
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
                        'label' => 'Nama Pemohon',
                        'value' => function($data){
                        return Html::a($data->kakitangan->CONm, ["view", 'id' => $data->id], ['target' => '_blank']);
                        },
                        'filter' => Select2::widget([
                        'name' => 'icno',
                        'value' => $icno,
                        'data' => ArrayHelper::map(\app\models\ln\Ln::find()->all(), 'icno', 'kakitangan.CONm'),
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                
                    [
                        'label' => 'Tarikh Mohon',
                        'attribute' => 'entrydate',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        ],            
//                                
//                    [
//                            'label' => 'Status Perakuan Ketua Jabatan',
//                            'value' => 'statusjfpiu',
//                            'format' => 'raw',
//                            'vAlign' => 'middle',
//                            'hAlign' => 'center',
//                        ],
//                    [
//                            'label' => 'Status Semakan Canselori',
//                            'value' => 'statussemakan',
//                            'format' => 'raw',
//                            'vAlign' => 'middle',
//                            'hAlign' => 'center',
//                        ],
//                    [
//                            'label' => 'Status Kelulusan NC',
//                            'value' => 'statusnc',
//                            'format' => 'raw',
//                            'vAlign' => 'middle',
//                            'hAlign' => 'center',
//                        ],
                                
                                 [
                        'label' => 'Status Perakuan KJ',
                        'attribute' => 'statusjfpiu',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'filter' => Select2::widget([
                            'name' => 'status_jfpiu',
                            'value' => $status_jfpiu,
                            'data' => ['Tunggu Perakuan'=>'<span class="label label-warning">Menunggu</span>',
                                'Diperakui' => '<span class="label label-success">Diperakui</span>',
                                'Tidak Diperakui' => '<span class="label label-danger">Ditolak</span>'],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            ],
                        ]),
                    ],
                                
                                 [
                        'label' => 'Status Semakan Canselori',
                        'attribute' => 'statussemakan',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'filter' => Select2::widget([
                            'name' => 'status_semakan',
                            'value' => $status_semakan,
                            'data' => ['Tunggu Perakuan'=>'<span class="label label-warning">Menunggu</span>',
                                'Diperakui' => '<span class="label label-success">Diperakui</span>',
                                'Tidak Diperakui' => '<span class="label label-danger">Ditolak</span>'],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            ],
                        ]),
                    ],
                                
                                 [
                        'label' => 'Status Kelulusan NC',
                        'attribute' => 'statusnc',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'filter' => Select2::widget([
                            'name' => 'status_nc',
                            'value' => $status_nc,
                            'data' => ['Tunggu Kelulusan'=>'<span class="label label-warning">Menunggu</span>',
                                'Diluluskan' => '<span class="label label-success">Diluluskan</span>',
                                'Tidak Diluluskan' => '<span class="label label-danger">Ditolak</span>'],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            ],
                        ]),
                    ],
                                
                                
//                                [
//                        'label'=>'Tindakan',
//                        'format' => 'raw',
//                        'value'=>function ($data){
//                                return Html::a('<i class="fa fa-eye">', ['lihat-rekod-lantikan', 'id' => $data->id]) ;
////                              return Html::a('<i class="fa fa-eye">', ['admin-view','id'=>$data->ICNO]) ;          
//                        },
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                          
//                    ],
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