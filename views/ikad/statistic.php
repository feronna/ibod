<?php

use app\models\hronline\GredJawatan;
use app\models\kehadiran\TblYears;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo $this->render('/ikad/_menu'); ?>

<?php // echo $this->render('_search', ['model' => $searchModel]);      
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Searching</strong></h2>
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
                $form = ActiveForm::begin([
                    'action' => ['statistic'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>


                <?=
                $form->field($searchModel, 'd_nama')->textInput(['placeholder' => 'Search by Name'])->label(false);

                ?>
                <?=
                $form->field($searchModel, 'status_kad')->label(false)->widget(Select2::classname(), [
                    'data' => ['1' => 'New', '2' => 'Ready To Take', '5' => 'Sent To Vendor', '4' => 'Completed (Delivered To Applicant)', '7' => 'Checked', '8' => 'Approved', '6' => 'Rejected'],
                    'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-5 col-xs-5'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                <?=
                $form->field($searchModel, 'year')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(TblYears::find()->where(['status' => 1])->all(), 'year', 'year'),
                    'options' => ['placeholder' => 'Year', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                <?=
                $form->field($searchModel, 'month')->label(false)->widget(Select2::classname(), [
                    'data' => ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'],
                    'options' => ['placeholder' => 'Month', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>

                <?=
                $form->field($searchModel, 'type')->label(false)->widget(Select2::classname(), [
                    'data' => ['1' => 'Pengurusan Tertinggi', '2' => 'Akademik'],
                    'options' => ['placeholder' => 'Type', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>


                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <h2><strong> Application List and Status</strong></h2>

        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-line-chart"></i>&nbsp;</strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="pull-left">
                    <?php

                    $gridColumns = [
                        ['class' => 'yii\grid\SerialColumn'],

                        //                    'nama',

                        [
                            'attribute' => 'Nama Pegawai',
                            'value' => 'kakitangan.CONm',
                        ],
                        [
                            'attribute' => 'Kelayakan Akademik',
                            'value' => 'highestedu',
                        ],
                        [
                            'attribute' => 'Gred Jawatan',
                            'value' => 'gred.fname',
                        ],
                        [
                            'attribute' => 'Alamat JAFPIB',
                            'value' => 'address',
                        ],
                        [
                            'attribute' => 'Tel',
                            'value' => 'd_office_telno',

                        ],
                        [
                            'attribute' => 'Ext',
                            'value' => 'd_office_extno',

                        ],
                        [
                            'attribute' => 'Fax',
                            'value' => 'd_faxno',
                        ],
                        [
                            'attribute' => 'Bimbit',
                            'value' => 'd_hpno',
                        ],
                        [
                            'attribute' => 'e-mel',
                            'value' => 'd_email',
                        ],
                    

                    ];

                    echo ExportMenu::widget(
                        [
                            'dataProvider' => $dataProviders,
                            'columns' => $gridColumns,
                            'clearBuffers' => true,
                            'filename' => 'Senarai',

                        ]

                    );
                    ?>
                </div>

                <div class="x_content">
                    <?php


                    echo GridView::widget([
                        'dataProvider' => $dataProviders,
                        'columns' => $gridColumns,
                        // 'filterModel' => $searchModel,
                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                        'responsiveWrap' => true,
                        'responsive' => true,
                        'hover' => true,
                        'showFooter' => true,
                        'hover' => true,
                        'floatHeader' => true,
                        'floatHeaderOptions' => [
                            'position' => 'absolute',
                        ],
                        'pjax' => true,
                        'pjaxSettings' => [
                            'neverTimeout' => true,
                        ]
                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>