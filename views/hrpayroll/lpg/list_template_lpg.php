<?php

use yii\bootstrap\Modal;

Modal::begin([
    'header' => '<strong>Tambah / Kemaskini Template</strong>',
    'id' => 'modal',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => "-1",
    ],
    // 'clientOptions' => [
    //     'backdrop' => 'static',
    //     'keyboard' => false
    // ]
]);
echo "<div id='modalContent'></div>";
Modal::end();

$js = <<<js
    $('.modalButton').on('click', function () {
        if ($('#modal').data('bs.modal').isShown) {
            $('#modal').find('#modalContent')
                    .load($(this).attr('value'));
        } else {
            //if modal isn't open; open it and load content
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));      
        }
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

// error_reporting(0);


$this->title = 'Senarai Template Lpg/Kew8';
?>

<div class="x_panel">
    <div class="x_title" style="color:#37393b;">
        <h2><?= Html::encode($this->title) ?></h2>
        <?= Html::button('Add Template', ['value' => 'create-template', 'class' => 'pull-right btn-success btn-sm modalButton']) ?>
        <div class="clearfix"></div>
    </div>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'striped' => true,
            'hover' => true,
            'emptyText' => 'Tiada Rekod',
            'summary' => '',
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => 'BIL',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'JENIS LPG',
                    'headerOptions' => ['class' => 'text-center col-md-4'],
                    // 'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->lpgType->RR_REASON_DESC;
                    },
                    'format' => 'html',
                    'group' => true,
                ],
                [
                    'label' => 'JENIS ELAUN',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->lpgElaun ? ($model->lpgElaun->nama_ringkas) : null;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'CREATE BY',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->creator->CONm;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'CREATE DATE',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->create_dt;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'UPDATE BY',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->editor ? $model->editor->CONm : null;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'UPDATE DATE',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->update_dt;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'STATUS',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return boolval($model->status) ? '<span style="color:green">Active</span>' : '<span style="color:orange">Inactive</span>';
                    },
                    'format' => 'html',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'TINDAKAN',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            $url = Url::to(['hrpayroll/update-template', 'id' => $model->jenis_lpg_id]);
                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                        },
                        'delete' => function ($url, $model) {
                            $url = Url::to(['hrpayroll/delete-template', 'id' => $model->jenis_lpg_id]);
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => 'Padam',
                                'class' => 'btn btn-default btn-sm',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this LPG?',
                                    'method' => 'post',
                                ],
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>