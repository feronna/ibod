<?php

use kartik\date\DatePicker;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

?>

<div class="row">
    <div class="x_content">
        <a class="btn btn-app disable">
            <span class="badge bg-red"><?=$total['overdue']?></span>
            <i class="fa fa-exclamation-circle"></i> Overdue
        </a>
        <a class="btn btn-app">
            <span class="badge bg-green"><?=$total['completed']?></span>
            <i class="fa fa-check"></i> Completed
        </a>
        <a class="btn btn-app">
            <span class="badge bg-orange"><?=$total['inProgress']?></span>
            <i class="fa fa-inbox"></i> In Progress
        </a>
        <a class="btn btn-app">
            <span class="badge bg-blue"><?=$total['fav']?></span>
            <i class="fa fa-heart"></i> Favourite
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::a('<i class="fa fa-plus-square"></i>&nbsp; Tambah Catatan', ['add-catatan'], ['class' => 'btn btn-success']) ?>
                <div class="table-responsive">
                    <?php
                    $gridColumns = [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil.',
                        ],
                        [
                            'attribute' => 'favIcon',
                            'value' => 'favIcon',
                            'format' => 'html',
                        ],
                        'typeText',
                        [
                            'attribute' => 'staf_icno',
                            'value' => 'staffBio.CONm',
                        ],
                        'title',
                        [
                            'attribute' => 'status',
                            'filter' => ["1" => "Completed", "0" => "In-progress"],
                            'value' => 'statusText',
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'due_date',
                            'filter' => DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'due_date',
                                'type' => DatePicker::TYPE_INPUT,
                                // 'value' => date('Y-m-d'),
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd/mm/yyyy',
                                    'todayHighlight' => true,
                                ],
                                'options' => [
                                    'autocomplete' => 'off',
                                ]
                            ]),
                            'format' => 'html',
                        ],
                        [
                            'header' => 'Actions',
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}{update}{delete}',  // the default buttons + your custom button
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    $t = Url::to(['diari/view', 'id' => $model->id]);
                                    return Html::button('<span class="fa fa-eye"></span>', ['value' => Url::to($t), 'class' => 'btn btn-xs btn-success modalButton']);
                                },
                                'update' => function ($url, $model) {
                                    return Html::a('<i class="fa fa-pencil"></i>', ['update-catatan', 'id' => $model->id], ['class' => 'btn btn-xs btn-primary']);
                                },
                                'delete' => function ($url, $model) {

                                    return Html::a('<i class="fa fa-trash-o"></i>', ['delete-catatan', 'id' => $model->id], [
                                        'class' => 'btn btn-xs btn-danger',
                                        'data' => [
                                            'confirm' => 'Anda pasti untuk membuang catatan ini?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                },
                            ],
                        ],
                    ];
                    ?>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'hover' => true,
                        // 'id' => 'form-pjax',
                        // 'pjax' => true,
                        'columns' => $gridColumns,
                        'options' => [
                            'class' => 'table-responsive',
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


<?php
Modal::begin([
    'header' => '<h4><strong>Paparan Catatan Diari</strong></h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
?>