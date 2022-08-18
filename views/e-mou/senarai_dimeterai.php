<?php
/* @var $this yii\web\View */

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#moda2l').modal('show')
                .find('#moda2lContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

$this->registerCss('
a.asc:after, a.desc:after {
    position: relative;
    top: 1px;
    display: inline-block;
    font-family: "FontAwesome";
    font-style: normal;
    font-weight: normal;
    line-height: 1;
    padding-left: 5px;
}

a.asc:after {
    content:  "\f062";
}

a.desc:after {
    content:  "\f063";
}
');

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;

Modal::begin([
    'header' => 'Paparan Memorandum',
    'id' => 'moda2l',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => false]
]);
echo "<div id='moda2lContent'></div>";
Modal::end();
?>

<?= $this->render('_menu'); ?>

<?= $this->render('_searchBorang', ['model' => $searchModel, 'title' => $titleEmou]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Hasil Carian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">

                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        'emptyText' => 'Tiada Rekod',
                        'summary' => '',
                        'pager' => [
                            'class' => \kop\y2sp\ScrollPager::className(),
                            'container' => '.grid-view tbody',
                            'triggerOffset' => 10,
                            'item' => 'tr',
                            'paginationSelector' => '.grid-view .pagination',
                            'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                        ],
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'ID',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->memorandum_id;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'JAFPIB',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->department->fullname;
                                },
                                //'attribute' => 'tahun',
                                'format' => 'html',
                            ],
                            [
                                'label' => 'AGENSI LUAR',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->external_parties;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'NEGARA',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->country->Country;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'JENIS EMOU',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->emouType->memorandum_type_desc;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'STATUS',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->emouStatus->status_desc;
                                },
                                'format' => 'html',
                                'attribute' => 'id_status',
                            ],
                            [
                                'label' => 'TARIKH KEMASKINI',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->last_update;
                                    // return Yii::$app->formatter->asDate($model->last_update, 'dd/MM/yyyy');
                                },
                                'format' => 'html',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'TINDAKAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        $url = Url::to(['e-mou/view-memorandum', 'id' => $model->memorandum_id]);
                                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    },
                                    // 'update' => function ($url, $model) {
                                    //     // $url = Url::to(['e-mou/view-memorandum', 'id' => $model->memorandum_id]);
                                    //     // return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    //     return igorvolnyi\widgets\modal\ModalAjaxMultiple::widget([
                                    //         // 'id' => '$model->memorandum_id',
                                    //         'header' => '<div class="pull-left">Kemaskini Memorandum</div>',
                                    //         'size' => 'modal-lg',
                                    //         'toggleButton' => [
                                    //             'label' => '<span class="glyphicon glyphicon-edit"></span>',
                                    //             'class' => 'btn btn-default btn-sm'
                                    //         ],
                                    //         'url' => Url::to(['e-mou/edit-memorandum-sah', 'id' =>  $model->memorandum_id]), // Ajax view with form to load
                                    //         'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
                                    //         // ... any other yii2 bootstrap modal option you need
                                    //     ]);
                                    // },
                                ],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>