<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use kartik\date\DatePicker;
error_reporting(0); 
?>

<?= $this->render('/ln/_topmenu') ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Rekod Permohonan Bertugas Rasmi Ke Luar Negara (LN-1)</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
            <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                <?= Html::beginForm(['rekod-ln1', 'id' => $icno], 'GET'); ?>
                <div class="form-group">
                  <?=  DatePicker::widget([
                    'name' => 'tahun',
                    'value' => Yii::$app->request->queryParams['tahun'],
                    'type' => DatePicker::TYPE_INPUT,
                     'options' => ['placeholder' => 'Tahun',
                            ],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy',
                        'minViewMode'=> "years"
                    ]
                ]);?> 
                </div> 
<!--                <= Html::dropDownList('tahun', $tahun, ['2022' => '2022', '2021' => '2021', '2020' => '2020', '2019' => '2019', '2018' => '2018', '2017' => '2017', '2016' => '2016'], ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>-->
<!--                <br>-->
<!--                <br>-->
                <?= Html::dropDownList('bulan', $bulan, ['0' => 'Show All by Year', '01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                 <br>
                 <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Cari', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php // Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/report', 'model' => $model ,'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                 <?= Html::endForm(); ?>
            </div>
            
            <div class="x_content">  <br>
          
            <div class="row"> 
            <div class="col-xs-12 col-md-12 col-lg-12"> 
<!--                    <= $this->render('_sub', ['dataProvider' => $dataProvider,'model' => $model]) ?> -->
                    <?= Html::a('<div style="float: left; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['reportsenarairekodln1', 'tahun' => $tahun, 'bulan' => $bulan,'model' => $model]) ?>
                    <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun Semua</div>', ['reportsenaraisemualn1', 'icno' => Yii::$app->request->queryParams['icno']]) ?>
                <div class="x_content">
                <div class="table-responsive">
                    <table id = "table_wrapper" class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;" width ="100%">
                        <thead><br>
                            <tr class="headings">
                                <th class="text-center">BULAN</th>
                                <th class="text-center">JAN</th>
                                <th class="text-center">FEB</th>
                                <th class="text-center">MAC</th>
                                <th class="text-center">APR</th>
                                <th class="text-center">MAY</th>
                                <th class="text-center">JUN</th>
                                <th class="text-center">JUL</th>
                                <th class="text-center">AUG</th>
                                <th class="text-center">SEP</th>
                                <th class="text-center">OCT</th>
                                <th class="text-center">NOV </th>
                                <th class="text-center">DEC</th>
                                <th class="text-center">JUMLAH</th>   
                            </tr>
                        </thead>
                            <tr class="headings">
                                <td class="text-center"  style="text-align:center">BILANGAN </td>
                                <?php for($i=1; $i<=12; $i++){ ?>
                                <td class="text-center"  style="text-align:center"><?php echo $model->perMonth($tahun,$i);?></td>
                                <?php } ?>
                                <td class="text-center"  style="text-align:center"><?php echo $model->getTotalCount($tahun,$bulan)?> </td> 
                            </tr>    
                    </table>
                </div>

                <div class="table-responsive">
                    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'showFooter' => true,
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'options' => ['class' => 'table-responsive' ], 
                    'columns' => [
                        [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'BIL.',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'], 
                        ],

                        
                          [
                            'label' => 'NAMA',
                            'format' => 'raw',
                            'value' => function($data){
                                return Html::a($data->kakitangan->CONm, ["tindakan-admin", 'id' => $data->id] , ['target' => '_blank']);
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
                            'label' => 'ICNO',
                            'value' => 'kakitangan.ICNO',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],        
                                    
                        [
                            'label' => 'GRED & JAWATAN',
                            'value' => 'kakitangan.jawatan.fname',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'value' => 'entrydate',
                            'label' => 'TARIKH MOHON',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'value' => 'datefrom',
                            'label' => 'TARIKH PERGI',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'label' => 'STATUS KJ',
                            'value' => 'statusjfpiu',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'filter' => Select2::widget([
                                'name' => 'statuskj',
                                'value' => $statuskj,
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
                            'label' => 'STATUS CANSELORI',
                            'value' => 'statussemakan',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'filter' => Select2::widget([
                                'name' => 'statussemakan',
                                'value' => $statussemakan,
                                'data' => ['Tunggu Semakan'=>'<span class="label label-warning">Menunggu</span>',
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
                            'label' => 'STATUS NC',
                            'value' => 'statusnc',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'filter' => Select2::widget([
                                'name' => 'statusnc',
                                'value' => $statusnc,
                                'data' => ['Tunggu Kelulusan'=>'<span class="label label-warning">Menunggu</span>',
                                           'Diluluskan' => '<span class="label label-success">Diperakui</span>',
                                           'Tidak Diluluskan' => '<span class="label label-danger">Ditolak</span>'],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
                        ], 
                       
                        [
                            'label' => 'STATUS SURAT',
                            'format' => 'raw',
                            'value'=>function ($data) {
//                                if($data->status_surat == 3){
//                                    $checked = 'checked';
//                                }
//                                if($data->status_surat == 4){
//                                    $checked1 = 'checked';
//                                }
                                if(($data->status_surat == 0) || ($data->status_surat == 3) || ($data->status_surat == 4)){
                                    return $data->statussurat;
                                }
                                if($data->status_surat == 1){
                                    return $data->statussurat;
                                }
                                if($data->status_surat == 2 && $data->status_jfpiu == 'Tidak Diperakui' || $data->status_semakan == '-' || $data->status_nc == '-'){
                                    return $data->statussurat;
                                }
                                if($data->status_surat == 2){
                                    return $data->statussurat;
                                }
//                                return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'><i class="fa fa-check"></i>').Html::a('<input type="radio" name="'.$data->id.'" value="n'.$data->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
                                },
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                            
                        [
                            'label' => 'JUMLAH BUDGET', 
                            'vAlign' => 'middle',
                            'hAlign' => 'center', 
                            'value' => function($dataProvider) { return 'RM' . " " . $dataProvider->jumlah3 ;}, 
                            'footer' => 'RM  '.$sum,
                        ],
                        [
                            'label'=>'TINDAKAN',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'value'=>function ($data) {
                                if($data->terima == NULL){
                                    return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsurat', 'id' => $data->id]),'style'=>'background-color: transparent; 
                                border: none;', 'class' => 'fa fa-upload mapBtn']);
                                }
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
 
 