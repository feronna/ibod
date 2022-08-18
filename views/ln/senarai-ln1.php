<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
error_reporting(0); 
?>

<?= $this->render('/ln/_topmenu') ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Menunggu Kelulusan Permohonan Bertugas Rasmi Ke Luar Negara (LN-1)</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
<!--            <= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['reportpentadbiran', 'status' => $searchModel->status_surat]) ?>-->
            <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['reportsenarailn1', 'icno' => Yii::$app->request->queryParams['icno'], 'statuskj' => Yii::$app->request->queryParams['statuskj'], 'statuscn' => Yii::$app->request->queryParams['statuscn'], 'statusnc' => Yii::$app->request->queryParams['statusnc']]) ?>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
            
            <div class="x_content"> 
                <?=
                GridView::widget([
                'options' => [
                    'class' => 'table-responsive'
                    ],
                    'dataProvider' => $dataProvider,
                    'filterModel' => true,
                    //'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    //'summary' => '',
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil.',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        
                        [
                            'label' => 'Nama',
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
                            'label' => 'Gred & Jawatan',
                            'value' => 'kakitangan.jawatan.fname',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'value' => 'entrydate',
                            'label' => 'Tarikh Mohon',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'value' => 'datefrom',
                            'label' => 'Tarikh Pergi',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        
                        // [
                        //     'label' => 'Negara',
                        //     'value' => 'nama_tempat',
                        //     'vAlign' => 'middle',
                        //     'hAlign' => 'center',
                        // ], 

                        [
                            'label' => 'Negara',
                            'value' => 'nama_tempat',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'filter' => Select2::widget([
                                'name' => 'negara',
                                'value' => $negara, 
                                'data' => ArrayHelper::map(\app\models\ln\ln::find()->all(), 'nama_tempat', 'nama_tempat'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
                        ],
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
                                           'Tidak Diperakui' => '<span class="label label-danger">Tidak Diperakui</span>'],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
                        ],  
                        
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
                                           'Tidak Diperakui' => '<span class="label label-danger">Tidak Diperakui</span>'],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
                        ],
                                    
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
                                           'Tidak Diluluskan' => '<span class="label label-danger">Tidak Diluluskan</span>'],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
                        ],
                                    
                        [
                            'label' => 'Status Surat',
                            'format' => 'raw',
                            'value'=>function ($data) {
                                if($data->status_surat == 3){
                                    $checked = 'checked';
                                }
                                if($data->status_surat == 4){
                                    $checked1 = 'checked';
                                }
                                if($data->status_surat == 1 || $data->status_surat == 2){
                                    return $data->statussurat;
                                }
                                return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'><i class="fa fa-check"></i>').Html::a('<input type="radio" name="'.$data->id.'" value="n'.$data->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
                                },
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                              
                        [
                            'label'=>'Tindakan',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'value'=>function ($data) {
                                if($data->terima == NULL){
                                return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tindakan_admin_canselori', 'id' => $data->id]),'style'=>'background-color: transparent; 
                                border: none;', 'class' => 'fa fa-edit mapBtn']).
                                     Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsurat', 'id' => $data->id]),'style'=>'background-color: transparent; 
                                border: none;', 'class' => 'fa fa-upload mapBtn']);}
                                else{
                                    return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsurat', 'id' => $data->id]),'style'=>'background-color: transparent; 
                                border: none;', 'class' => 'fa fa-upload mapBtn']);
                                }
                            },
                        ],
                              
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) { 
                                if(($data->status_surat=='1' ||$data->status_surat=='2')){
                                return ['disabled' => 'disabled'];
                                }
                                return ['value' => $data->id, 'checked'=> true];
                              },
                        ],
                        
                        [
                            'label' => 'Salinan Surat',
                            'format' => 'raw',
                            'value'=>function ($statussurat){
                                if($statussurat->status_surat == 0){
                                    return 
                                Html::a('<i class="fa fa-download">');
                               }
                               if($statussurat->status_surat == 1){
                                    return 
                                Html::a('<i class="fa fa-download">', ["ln/surat-ln", 'id' => $statussurat->id], ['target' => '_blank']);
                               }
                                else if($statussurat->status_surat == 2){
                                    return 
                                Html::a('<i class="fa fa-download">', ["ln/surat-ln", 'id' => $statussurat->id], ['target' => '_blank']);
                               }
                                else if ($statussurat->status_surat == 3){
                                    return 
                                Html::a('<i class="fa fa-download">', ["ln/surat-ln", 'id' => $statussurat->id], ['target' => '_blank']);
                               }
                                else if($statussurat->status_surat == 4){
                                    return 
                                Html::a('<i class="fa fa-download">', ["ln/surat-ln", 'id' => $statussurat->id], ['target' => '_blank']);
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
                
                <div class="col-md-12 col-sm-12 col-xs-12" align="right">  
                    <?= Html::submitButton(Yii::t('app', ''), ['class' => 'btn btn-primary', 'name' => 'searchs', 'value' => 'submit_1', 'style' => 'display:none']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'data'=>['disabled-text' => 'Sila Tunggu..'], 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'data'=>['disabled-text' => 'Sila Tunggu..'], 'value' => 'submit_2']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
</div>
</div>
