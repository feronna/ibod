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
<?= Html::a('Kembali', ['semakan'], ['class' => 'btn btn-primary']) ?>

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
                // 'attribute' => 'SR_ROC_TYPE',
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
                //                                        'class' => 'yii\grid\SerialColumn',
                'header' => 'KOD PROJEK',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return null;
                },
                'format' => 'html'
            ],
            [
                //                                        'class' => 'yii\grid\SerialColumn',
                'header' => 'PUSAT KOS',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return null;
                },
                'format' => 'html'
            ],
            [
                //                                        'class' => 'yii\grid\SerialColumn',
                'header' => 'DARI',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDate($model->SR_DATE_FROM, 'yyyy-MM-dd');
                },
                'format' => 'html'
            ],
            [
                //                                        'class' => 'yii\grid\SerialColumn',
                'header' => 'SEHINGGA',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDate($model->SR_DATE_TO, 'yyyy-MM-dd');
                },
                'format' => 'html'
            ],
            [
                //                                        'class' => 'yii\grid\SerialColumn',
                'header' => 'JENIS',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return ($model->elaunnn) ? $model->elaunnn->it_trans_type : null;
                },
                'format' => 'html'
            ],
            [
                //                                        'class' => 'yii\grid\SerialColumn',
                'header' => 'JENIS PERUBAHAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model->SR_CHANGE_TYPE;
                },
                'format' => 'html'
            ],
            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'header' => 'TINDAKAN',
            //     // 'headerOptions' => ['class'=>'text-center'],
            //     // 'contentOptions' => ['class'=>'text-center'],
            //     'template' => '{update}{delete}',
            //     'buttons' => [
            //         'update' => function ($url, $model) {
            //             $url = Url::to(['kemaskini-elaun', 'eid' => $model->SR_REF_ID]);
            //             return Html::button('<span class="fa fa-pencil"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
            //         },
            //         'delete' => function ($url, $model) {
            //             return Html::a('<span class="fa fa-trash-o"></span>', ['padam-elaun', 'eid' => $model->SR_REF_ID], [
            //                 'class' => 'btn btn-default btn-sm',
            //                 'data' => [
            //                     'confirm' => 'Adakah anda pasti MEMBUANG ELAUN ini?',
            //                     'method' => 'post',
            //                 ],
            //             ]);
            //         }
            //     ],
            // ],
        ],
    ]);
    ?>

</div>
<div class="center pull-right">
<?= Html::a('<i class="fa fa-check" aria-hidden="true"> Disemak</i>', ['tindakan-semakan-disemak','bid'=>$srb_batch_code], ['class' => 'btn btn-success ']) ?>
<?= Html::a('<i class="fa fa-reply" aria-hidden="true"> Pulang</i>', ['tindakan-semakan-pulang','bid'=>$srb_batch_code], ['class' => 'btn btn-warning']) ?>
<?= Html::a('<i class="fa fa-close" aria-hidden="true"> Tolak</i>', ['tindakan-semakan-tolak','bid'=>$srb_batch_code], ['class' => 'btn btn-danger']) ?>
</div>