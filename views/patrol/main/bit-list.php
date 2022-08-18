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

<div class="x_panel">
    <div class="x_title">
        <h2><strong> Senarai Bit (<?= RefPosKawalan::namapos(Yii::$app->getRequest()->getQueryParam('id')); ?>) </strong></h2>

        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-line-chart"></i>&nbsp;</strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center">
                  
                    <tbody>
                   <div class="col-lg-12 col-md-12 col-xs-12 text-center" rowspan="6" valign="top">
                    <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['patrol/main/route-list'], ['class' => 'btn btn-warning']) ?>
                    <?= Html::a('<i class="fa fa-plus-circle"></i>&nbsp;Tambah Bit', ['patrol/main/add-bit', 'id' => Yii::$app->getRequest()->getQueryParam('id')], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('<i class="fa fa-qrcode"></i>&nbsp;1. Generate QrCode', ['patrol/main/bulk-generate', 'id' => Yii::$app->getRequest()->getQueryParam('id')], ['class' => 'btn btn-info']) ?>
                    <?= Html::a('<i class="fa fa-qrcode"></i>&nbsp;2. Download QrCode', ['patrol/main/print-bulk', 'id' => Yii::$app->getRequest()->getQueryParam('id')], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('<i class="fa fa-upload"></i>&nbsp; Upload Picture', ['patrol/main/upload', 'id' => Yii::$app->getRequest()->getQueryParam('id')], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('<i class="fa fa-upload"></i>&nbsp; Upload Bit', ['patrol/admin/import', 'id' => Yii::$app->getRequest()->getQueryParam('id')], ['class' => 'btn btn-success']) ?>
                </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
                
                <div class="col-lg-12 col-md-12 col-xs-12 text-center" rowspan="6" valign="top"><span>
                        <img height='60%' width="60%" src="<?php echo Yii::$app->FileManager->DisplayFile(RefPosKawalan::file(Yii::$app->getRequest()->getQueryParam('id'))); ?>"></span></div>


                <div class="pull-left">
                    <?php

                    $gridColumns = [
                        ['class' => 'yii\grid\SerialColumn'],

                        //                    'nama',

                        [
                            'attribute' => 'Bit Name',
                            'value' => 'bit_name',
                        ],
                        [
                            'attribute' => 'Kedudukan Bit',
                            'value' => 'position',
                        ],

                        [
                            'attribute' => 'Latitude Bit',
                            'value' => 'lat',
                        ],
                        [
                            'attribute' => 'Longitude Bit',
                            'value' => 'lng',
                        ],
                        
                        [
                            'attribute' => 'Location',
                            'format' => 'raw',
                            'value' => function ($data) {

                                return RefBit::DisplayLoc($data->id);
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'attribute' => 'Kemaskini Bit',
                            'format' => 'raw',
                            'value' => function ($data) {

                                return Html::a('', ["patrol/main/update-bit", 'id' =>  $data->id], ['class' => 'fa fa-pencil']) .' | '. Html::a('', ["patrol/main/delete-bit", 'id' =>  $data->id], ['class' => 'fa fa-trash']);
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
                        'responsiveWrap' => false,
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