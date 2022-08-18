<?php

use kartik\date\DatePicker;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\adu\status;

?>

<?= Yii::$app->controller->renderPartial('/smo/_menu'); ?>

<div class="row">
    <div class="x_content">
        <a class="btn btn-app">
            <span class="badge bg-orange"><?= $total['inProgress'] ?></span>
            <i class="fa fa-inbox"></i> In Progress
        </a>
        <a class="btn btn-app">
            <span class="badge bg-green"><?= $total['completed'] ?></span>
            <i class="fa fa-check"></i> Completed
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

                <?= Html::a('<i class="fa fa-pencil"></i>&nbsp; Maklumbalas baharu', ['create-komponen-2'], ['class' => 'btn btn-primary']) ?>
                <div class="table-responsive">
                    <?php
                    $gridColumns = [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil.',
                        ],
                        [
                            'attribute' => 'pyd',
                            'value' => 'pydBio.CONm',
                        ],
                        [
                            'header' => 'Aspek Penilaian',
                            'attribute'=>'bhgnRel.bahagian',
                        ],
                        [
                            'header' => 'Kriteria',
                            'attribute'=>'kriteriaRel.kriteria_label',
                        ],
                        [
                            'attribute' => 'status',
                            'filter' => ArrayHelper::map(status::find()->where(['IN','code',['ENTRY','COMPLETED']])->all(), 'code', 'detail'),
                            'value' => function ($model) {
                                return $model->statusRel->detail;
                            },
                            'format' => 'html',
                        ],
                        'create_dt:datetime',
                        [
                            'header' => 'Perincian',
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',  // the default buttons + your custom button
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    $t = Url::to(['smo/view-k2', 'id' => $model->id]);
                                    return Html::button('<span class="fa fa-eye"></span>', ['value' => Url::to($t), 'class' => 'btn btn-xs btn-success modalButton']);
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
    'header' => '<h4><strong>Perincian Aduan</strong></h4>',
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