<?php

use yii\data\ActiveDataProvider;

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

?>

<?php
Modal::begin([
    'header' => '',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>


<div class="row">
<?= Html::a('Kembali', ['kelulusan'], ['class' => 'btn btn-primary']) ?>

    <div class="table-responsive">
        <?=
        GridView::widget([
            'emptyText' => 'Tiada Rekod',
            'summary' => '',
            'dataProvider' => $kumpulan,
            'columns' => [
                [
                    'header' => 'BATCH CODE',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->srb_batch_code;
                    },
                ],
                [
                    'header' => 'SEBAB PERGERAKAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->reason->RR_REASON_DESC;
                    },
                ],
                [
                    'header' => 'CATATAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->srb_remarks;
                    },
                    'format' => 'html'
                ],
                [
                    'header' => 'JFPIU',
                    'headerOptions' => ['class' => 'text-center col-md-2'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return ($model->processDept) ? $model->processDept->dm_dept_desc : null;
                    },
                    'format' => 'html'
                ],
                [
                    'header' => 'TARIKH KUATKUASA',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->srb_effective_date;
                    },
                ],
                [
                    'header' => 'TARIKH',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->srb_enter_date ? \Yii::$app->formatter->asDate($model->srb_enter_date, 'yyyy-MM-dd') : null;
                    },
                ],
                [
                    'header' => 'STATUS',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->srb_status;
                    },
                ],
            ],
        ]);
        ?>
    </div>
</div>


<div class="row">

    <?=
    GridView::widget([
        'dataProvider' => $elaun,
        //'filterModel' => $searchModel,
        'summary' => '',
        'columns' => [
            [
                'value' => function ($model) {
                    return ($model->elaunnn) ? $model->elaunnn->it_account_name : null;
                },
                'label' => 'ELAUN/POTONGAN',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
            ],
            [
                'attribute' => 'SR_OLD_VALUE',
                'label' => 'JUMLAH SEBELUM',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
            ],
            [
                'attribute' => 'SR_NEW_VALUE',
                'label' => 'JUMLAH',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
            ],
            [
                'attribute' => 'SR_CALC_TYPE',
                'label' => 'JENIS KIRAAN',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
            ],
            [
                'header' => 'KOD PROJEK',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return null;
                },
                'format' => 'html'
            ],
            [
                'header' => 'PUSAT KOS',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return null;
                },
                'format' => 'html'
            ],
            [
                'header' => 'DARI',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDate($model->SR_DATE_FROM, 'yyyy-MM-dd');
                },
                'format' => 'html'
            ],
            [
                'header' => 'SEHINGGA',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDate($model->SR_DATE_TO, 'yyyy-MM-dd');
                },
                'format' => 'html'
            ],
            [
                'header' => 'JENIS',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return ($model->elaunnn) ? $model->elaunnn->it_trans_type : null;
                },
                'format' => 'html'
            ],
            [
                'header' => 'JENIS PERUBAHAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model->SR_CHANGE_TYPE;
                },
                'format' => 'html'
            ],
        ],
    ]);
    ?>

</div>
<div class="center pull-right">
<?= Html::a('<i class="fa fa-check" aria-hidden="true"> Luluskan</i>', ['tindakan-kelulusan-terima','bid'=>$srb_batch_code],[
            'data' => [
                'confirm' => 'Adakah anda pasti untuk TERIMA?',
                'method' => 'post',
            ],'class'=>'btn btn-success']) ?>
<?= Html::a('<i class="fa fa-reply" aria-hidden="true"> Pulangkan</i>', ['tindakan-kelulusan-pulang','bid'=>$srb_batch_code],[
            'class'=>'btn btn-warning']) ?>
<?= Html::a('<i class="fa fa-close" aria-hidden="true"> Tolak</i>', ['tindakan-kelulusan-tolak','bid'=>$srb_batch_code],[
            'data' => [
                'confirm' => 'Adakah anda pasti untuk BUANG?',
                'method' => 'post',
            ],'class'=>'btn btn-danger']) ?>
</div>