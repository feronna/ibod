<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\kontrak\Kontrak;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\web\JsExpression;
?>
<script src="/pace/pace.js"></script>
<link href="/pace/themes/pace-theme-barber-shop.css" rel="stylesheet" />
<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\kontrak\KontrakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 error_reporting(0); 
?>
<?= $this->render('/kontrak/_topmenu') ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $forms = ActiveForm::begin([
                            'action' => ['senarai'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]);
                ?>
                <div class="form-group">
                                    <label class="control-label col-md-1 col-sm-1 col-xs-12">Mesyuarat :<span style="color: red" class="required">*</span>
                                    </label>
                                    <div class="col-md-1 col-sm-1 col-xs-12">
                                        <input value="<?= isset(Yii::$app->request->queryParams['bil'])? Yii::$app->request->queryParams['bil']:''?>" type="number" autocomplete="off" class="form-control" name="bil" placeholder="Bil">
                                    </div>
                                      <div class="col-md-1 col-sm-1 col-xs-12">
                                        <?=  DatePicker::widget([
                                        'name' => 'tahun',
                                        'value' => isset(Yii::$app->request->queryParams['tahun'])? Yii::$app->request->queryParams['tahun']:'',
                                        'type' => DatePicker::TYPE_INPUT,
                                         'options' => ['placeholder' => 'Tahun','autocomplete' => 'off'
                                                ],
                                        'pluginOptions' => [
                                            'autoclose'=>true,
                                            'format' => 'yyyy',
                    //                        'viewMode' => "years", 
                                            'minViewMode'=> "years"
                                        ]
                                    ]);?>
                                    </div>
                                </div>
                 
               
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
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
                <h2><strong>Senarai Permohonan Pelantikan Semula Kontrak</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
           

            <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['data?'.Yii::$app->request->getQueryString()], ['target' => '_blank']) ?>
            <div class="x_content">
                

                <?=
                GridView::widget([
                'options' => [
                'class' => 'table-responsive',
                    ],
                    'dataProvider' => $dataProvider,
                    'filterModel' => true,
                    'summary' => '',
//                    'rowOptions' =>function($data){
//                        $url = Url::to(['permohonankontrak', 'id' => $data->id]);
//
//                        return [
//                            'onclick' => "window.location.href='{$url}'"
//                        ];
//                    },
                    'columns' => [
                            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil',
                                'vAlign' => 'middle',
                        'hAlign' => 'center',
                                ],
                        
                        [
                        'label' => 'Nama Pemohon',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(Kontrak::find()->where(['job_category' => '1'])->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                        'value' => function($data){
                        return Html::a($data->kakitangan->CONm, ["maklumatkontrak1", 'id' => $data->id]);
                        },
                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'Jawatan',
                        'value' => 'kakitangan.jawatan.fname',
                        'filter' => Select2::widget([
                            'name' => 'jawatan',
                            'value' => isset(Yii::$app->request->queryParams['jawatan'])? Yii::$app->request->queryParams['jawatan']:'',
                            'data' => ArrayHelper::map(Kontrak::find()->where(['job_category' => '1'])->all(), 'kakitangan.jawatan.id', 'kakitangan.jawatan.fname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'JFPIU',
                        'filter' => Select2::widget([
                            'name' => 'jfpiu',
                            'value' => isset(Yii::$app->request->queryParams['jfpiu'])? Yii::$app->request->queryParams['jfpiu']:'',
                            'data' => ArrayHelper::map(Kontrak::find()->where(['job_category' => '1'])->all(), 'kakitangan.department.id', 'kakitangan.department.shortname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                        'value' => 'kakitangan.department.shortname',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'options' => ['width' => '100px'],
                    ],
                        [
                        'header' => 'Tarikh Mula Kontrak',
                        'value' => 'startdatelantik',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'Tarikh Tamat Kontrak',
                        'value' => 'enddatelantik',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                         'attribute' => 'tarikh_m',
                            'value' => 'tarikhmohon',
                        'label' => 'Tarikh Mohon',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'header' => 'LNPT terakhir',
                        'value'=>function ($data) {
                        if($data->markahlnpt(date('Y-')-1)){
                        $tahun = $data->markahlnpt(date('Y-')-1)."\n(".(date('Y')-1).")";
                        }
                        else{
                        $tahun = "-"."<br>(".(date('Y')-1).")";
                        }
                        return $tahun;
                      },
                    'format' => 'raw',
                              'vAlign' => 'middle',
                        'hAlign' => 'center',
                     ],
                        [
                        'header' => 'Status Pengesahan Dekan',
                        'attribute' => 'statusdekan',
                        'format' => 'raw',
                            'filter' => Select2::widget([
                            'name' => 'statusdekan',
                            'value' => isset(Yii::$app->request->queryParams['statusdekan'])? Yii::$app->request->queryParams['statusdekan']:'',
                            'data' => ['6'=>'<span class="label label-warning">Pending</span>',
                                '4' => '<span class="label label-success">Approved</span>',
                                '5' => '<span class="label label-danger">Rejected</span>',
                                '14' => '<span class="label label-info">Returned</span>',
                                '11' => "<span class='label' style='background-color:black'>Haven't applied</span>"],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'Status Pengesahan BSM',
                        'format' => 'raw',
                            'filter' => Select2::widget([
                            'name' => 'statusbsm',
                            'value' => isset(Yii::$app->request->queryParams['statusbsm'])? Yii::$app->request->queryParams['statusbsm']:'',
                            'data' => ['6'=>'<span class="label label-warning">Pending</span>',
                                '4' => '<span class="label label-success">Approved</span>',
                                '5' => '<span class="label label-danger">Rejected</span>',
                                '14' => '<span class="label label-info">Returned</span>',
                                '11' => "<span class='label' style='background-color:black'>Haven't applied</span>"],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            ],
                        ]),
                           'vAlign' => 'middle',
                        'hAlign' => 'center', 
                        'value'=> 'statusbsmakademik'
                    ],
//                              [
//                'class' => 'yii\grid\CheckboxColumn',
//                'checkboxOptions' => function ($data) { 
//                if(($data->status_bsm=='4' ||$data->status_bsm=='5')){
//                return ['disabled' => 'disabled'];
//                }
//                return ['value' => $data->id, 'checked'=> true];
//                },
//            ],
                ],
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                ]);
                ?>
                 
            </div>
        </div>
    </div>
</div>
