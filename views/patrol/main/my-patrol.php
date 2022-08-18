<?php

use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\TblShiftKeselamatan;
use app\models\keselamatan\TblStaffKeselamatan;
use app\models\patrol\PatrolTblReport;
use app\models\patrol\RefBit;
use app\models\patrol\RefRoute;
use app\models\patrol\Rekod;
use app\models\patrol\TblExcused;
use dosamigos\datepicker\DatePicker;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/patrol/_menu') ?>

<?php // echo $this->render('_search', ['model' => $searchModel]);      
 if (Yii::$app->getRequest()->getQueryParam('date') == NULL) {
    $today = date('Y-m-d');
} else{
    $today = Yii::$app->getRequest()->getQueryParam('date');
} 
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
                    'action' => ['my-patrol'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>


                <div class="col-xs-12 col-md-5 col-lg-3">
                    <?=
                    DatePicker::widget([
                        'name' => 'date',
                        'value' => $today,
                        'template' => '{input}{addon}',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ],
                        'options' => ['readonly' => 'readonly'],

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
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center">
            <thead>
                <tr class="headings">
                    <th class="column-title text-center">Peronda</th>
                    <th class="column-title text-center">Syif</th>
                    <th class="column-title text-center">Jumlah Rondaan</th>
                    <th class="column-title text-center">Tidak Dapat Membuat Rondaan</th>
                    <th class="column-title text-center">Catatan DO</th>
                    <th class="column-title text-center">Rondaan Anda</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $bil = 1;
                if ($query) {
                    foreach ($query as $admins) {
                ?>
                        <tr>
                            <td class="column-title text-left"><?= TblShiftKeselamatan::name($admins['icno']) . ' ( ' . TblShiftKeselamatan::gred($admins['icno']) . ' )'; ?></td>
                            <td><?= TblShiftKeselamatan::syif($admins['shift_id']); ?></td>

                            <td><?= Rekod::pcount($admins['icno'], $admins['pos_kawalan_id'], $admins['tarikh'], 1) . ' / ' .
                                    RefBit::countBit($admins['pos_kawalan_id']) ?>
                            </td>

                            <td> <?= TblExcused::remark($admins['icno'], $admins['tarikh'], $admins['pos_kawalan_id'], $admins['shift_id']) ? TblExcused::remark($admins['icno'], $admins['tarikh'], $admins['pos_kawalan_id'], $admins['shift_id']) :
                                        Html::a('<i class="fa fa-edit"></i>', ['patrol/main/remark', 'shift' => $admins['shift_id'], 'pos' => $admins['pos_kawalan_id'], 'date' => $admins['tarikh']]);
                                    ?></td>
                     
                            <td> <?= TblExcused::remarkdo($admins['icno'], $admins['tarikh'], $admins['pos_kawalan_id'], $admins['shift_id']) ? TblExcused::remarkdo($admins['icno'], $admins['tarikh'], $admins['pos_kawalan_id'], $admins['shift_id']) :
                                        ""
                                    ?></td>
                                    <td><?=  Html::a('<i class="fa fa-eye"></i>', ['patrol/main/bit-report', 'shift' => $admins['shift_id'], 'pos' => $admins['pos_kawalan_id'], 'date' => $admins['tarikh']]); ?></td>

                    <?php
                    }
                }
                    ?>
            </tbody>
        </table>
    </div>
</div>
<div class="x_panel">
    <div class="x_title">
        <h2><strong> Senarai Rondaan <?php echo Rekod::staff($id) ?></h2>

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
                            'attribute' => 'Pos Kawalan',
                            'value' => 'route.pos_kawalan',
                        ],
                        [
                            'attribute' => 'Bit',
                            'format' => 'raw',
                            'value' => function ($data) {
                                $val = Rekod::bit($data->id);
                                return $val;
                            },
                        ],
                        [
                            'attribute' => 'Tarikh & Masa Rondaan',
                            'value' => 'change',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'attribute' => 'Count',
                            'format' => 'raw',
                            'value' => 'patrol_count',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'attribute' => 'Status',
                            'format' => 'raw',
                            'value' => 'status',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],


                        // [
                        //     'attribute' => 'Update Status',
                        //     'format' => 'raw',
                        //     'value' => function ($data) {

                        //         return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['ikad/approval', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn']);
                        //     },
                        //     'headerOptions' => ['class' => 'text-center'],
                        //     'contentOptions' => ['class' => 'text-center'],
                        // ],

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
</div>