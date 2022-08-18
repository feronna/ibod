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
                <div class="table-responsive">
                    <?php
                    $gridColumns = [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil.',
                        ],
                        [
                            'header' => 'Fungsi Operasi',
                            'attribute' => 'fungsiRel.numDetail',
                        ],
                        [
                            'header' => 'PTJ',
                            'attribute' => 'locRel.shortname',
                        ],
                        [
                            'header' => 'Penberi Maklumbalas',
                            'attribute' => 'staffBio.CONm',
                        ],
                        [
                            'attribute' => 'status',
                            'filter' => ArrayHelper::map(status::find()->all(), 'code', 'detail'),
                            'value' => function ($model) {
                                return $model->statusRel->detail;
                            },
                            'format' => 'html',
                        ],
                        'create_dt:datetime',
                        'update_dt:datetime',
                        [
                            'header' => 'Perincian',
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',  // the default buttons + your custom button
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    $t = Url::to(['smo/view-admin-k1', 'id' => $model->id]);
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
    'header' => '<h4><strong>Perincian Maklumbalas</strong></h4>',
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