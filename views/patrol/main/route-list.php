<?php

use app\models\keselamatan\RefPosKawalan;
use app\models\patrol\RefBit;
use app\models\patrol\RefRoute;
use dosamigos\datepicker\DatePicker;
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
<?= $this->render('/patrol/_menu') ?>

<?php // echo $this->render('_search', ['model' => $searchModel]);      
$today = Yii::$app->getRequest()->getQueryParam('date');

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
                    'action' => ['route-list'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>

                <div class="col-xs-12 col-md-6 col-lg-6">

                 
                      <?=
                        $form->field($searchModel, 'id')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(RefPosKawalan::find()->all(), 'id', 'pos_kawalan'),
                            'options' => ['placeholder' => 'Choose Route', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                   
                </div>
             

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
                <?= Html::a('<i class="fa fa-plus-circle"></i>&nbsp;Tambah Route', ['patrol/main/add-route'], ['class' => 'btn btn-primary']) ?>

                <div class="pull-left">
                    <?php

                    $gridColumns = [
                        ['class' => 'yii\grid\SerialColumn'],

                        //                    'nama',

                        [
                            'attribute' => 'Pos Kawalan',
                            'value' => 'pos_kawalan',
                        ],
                       

                        [
                            'attribute' => 'Senarai Bit Dalam Pos Kawalan',
                            'format' => 'raw',
                            'value' => function ($data) {

                                return Html::a('', ["patrol/main/bit-list", 'id' =>  $data->id], ['class' => 'fa fa-pencil']);
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