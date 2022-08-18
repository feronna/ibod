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

<?php
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
                        <input value="<?= $sesis ?>" type="number" autocomplete="off" class="form-control" name="sesis" placeholder="Bil">
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-12">
                        <?= DatePicker::widget([
                            'name' => 'tahuns',
                            'value' =>  $tahuns,
                            'type' => DatePicker::TYPE_INPUT,
                            'options' => [
                                'placeholder' => 'Tahun', 'autocomplete' => 'off'
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy',
                                //                        'viewMode' => "years", 
                                'minViewMode' => "years"
                            ]
                        ]); ?>
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
            <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['data?' . Yii::$app->request->getQueryString()], ['target' => '_blank']) ?>
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
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],

                        [
                            'label' => 'Nama Pemohon',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                                'name' => 'icnos',
                                'value' => $icnos,
                                'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'value' => function ($data) {
                                return Html::a($data->kakitangan->CONm, ["maklumatkontrak_bsm", 'id' => $data->id]);
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
                                'value' => $jawatan,
                                'data' => ArrayHelper::map(\app\models\hronline\GredJawatan::find()->where(['job_category' => '1'])->all(), 'id', 'fname'),
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
                                'value' => $jfpiu,
                                'data' => ArrayHelper::map(\app\models\hronline\Department::find()->all(), 'id', 'shortname'),
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
                            'value' => function ($data) {
                                if ($data->markahlnpt(date('Y-') - 1)) {
                                    $tahun = $data->markahlnpt(date('Y-') - 1) . "\n(" . (date('Y') - 1) . ")";
                                } else {
                                    $tahun = "-" . "<br>(" . (date('Y') - 1) . ")";
                                }
                                return $tahun;
                            },
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'header' => 'Umur Sekarang',
                            'attribute' => 'umur',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'header' => 'Umur semasa tamat Kontrak',
                            'attribute' => 'umurTamatKontrak',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'header' => 'Status Pengesahan Ketua Program',
                            'attribute' => 'statuskp',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                                'name' => 'kps',
                                'value' => $kps,
                                'data' => [
                                    '6' => '<span class="label label-warning">Pending</span>',
                                    '4' => '<span class="label label-success">Approved</span>',
                                    '5' => '<span class="label label-danger">Rejected</span>',
                                    '14' => '<span class="label label-info">Returned</span>',
                                    '11' => "<span class='label' style='background-color:black'>Haven't applied</span>"
                                ],
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
                            'header' => 'Status Pengesahan Dekan',
                            'attribute' => 'statusdekan',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                                'name' => 'dekans',
                                'value' => $dekans,
                                'data' => [
                                    '6' => '<span class="label label-warning">Pending</span>',
                                    '4' => '<span class="label label-success">Approved</span>',
                                    '5' => '<span class="label label-danger">Rejected</span>',
                                    '14' => '<span class="label label-info">Returned</span>',
                                    '11' => "<span class='label' style='background-color:black'>Haven't applied</span>"
                                ],
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
                                'name' => 'bsms',
                                'value' => $bsms,
                                'data' => [
                                    '6' => '<span class="label label-warning">Pending</span>',
                                    '4' => '<span class="label label-success">Approved</span>',
                                    '5' => '<span class="label label-danger">Rejected</span>',
                                    '7' => '<span class="label label-danger">Resignation</span>',
                                    '15' => '<span class="label label-danger">Completion of service</span>',
                                    '14' => '<span class="label label-info">Returned</span>',
                                    '11' => "<span class='label' style='background-color:black'>Haven't applied</span>"
                                ],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'value' => 'statusbsmakademik'
                        ],
                        [
                            'label' => 'Tindakan',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'value' => function ($data) {
                                //return Html::a('<i class="fa fa-edit">', ["kontrak/tindakan_bsm", 'id' => $data->id]);
                                if ($data->status_bsm != '5' && $data->status_bsm != '4') {
                                    return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tindakan_bsm', 'id' => $data->id]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit mapBtn']) .
                                        Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsurat', 'id' => $data->id]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-upload mapBtn']) .
                                        Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['update', 'id' => $data->id]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-cog mapBtn']);
                                } else {
                                    return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsurat', 'id' => $data->id]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-upload mapBtn']) .
                                        Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['update', 'id' => $data->id]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-cog mapBtn']);
                                }
                            },
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