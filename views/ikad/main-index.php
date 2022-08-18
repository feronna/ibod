<?php


use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
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
                    'action' => ['main-index'],
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
                    'data' => ['1' => 'New','2' => 'Ready To Take', '5'=>'Sent To Vendor','4' => 'Completed (Delivered To Applicant)','7'=>'Checked','8'=>'Approved','6'=>'Rejected'],
                    'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-5 col-xs-5'],
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
                            'attribute' => 'Name on Card',
                            'value' => 'd_nama',
                        ],
                        [
                            'attribute' => 'Card Language',
                            'value' => 'cardlang',
                        ],
                        [
                            'attribute' => 'Application Date',
                            'value' => 'formattarikh',

                        ],
                        [
                            'attribute' => 'Application Status',
                            'value' => 'adminappstatus',
                        ],
                        //put preview card button here
                        [
                            'attribute' => 'Preview And Submit',
                            'format'=> 'raw',
                            'value' => function ($data) {

                                return Html::a('', ["ikad/admin-update-app", 'id' =>  $data->id], ['class' => 'fa fa-pencil']). ' | ' . Html::a('Preview', ["ikad/admin-preview", 'id' =>  $data->id], ['class' => 'fa fa-search']);
                            },    
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],     
                        ],   
                        [
                            'attribute' => 'Update Status',
                            'format' => 'raw',
                            'value' => function ($data) {

                                return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['ikad/update-status', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn']);
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],

                    ];

                    // echo ExportMenu::widget(
                    //     [
                    //         'dataProvider' => $dataProviders,
                    //         'columns' => $gridColumns,
                    //         'clearBuffers' => true,
                    //         'filename' => 'Senarai Permohonan GCR dan CBTH',

                    //     ]

                    // );
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