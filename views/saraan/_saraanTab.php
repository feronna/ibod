<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$url1 = Url::to(['saraan/tambah-kew8', 'umsper' => $umsper]);
$js = <<<js
    $('.modalButton2').on('click', function () {

        var keys = $('#saraan').yiiGridView('getSelectedRows');
        $.post("$url1",
        {'keylist': keys},
        function(data){
            
            
        $('#modal').modal('show')
                .find('#modalContent')
                .html(data);

        });

    });
js;
$this->registerJs($js);

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
    <div class="table-responsive">
        <?=
        GridView::widget([
            'options' => ['id' => 'saraan'],
            //'tableOptions' => [
            //  'class' => 'table table-striped jambo_table',
            //],
            'emptyText' => 'Tiada Rekod',
            //                                'pager' => [
            //                                    'class' => \kop\y2sp\ScrollPager::className(),
            //                                    'container' => '.grid-view tbody',
            //                                    'triggerOffset' => 10,
            //                                    'item' => 'tr',
            //                                    'paginationSelector' => '.grid-view .pagination',
            //                                    'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
            //                                 ],
            'summary' => '',
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => 'BIL',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    //                                        'class' => 'yii\grid\SerialColumn',
                    'header' => 'PENDAPATAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return ($model->elaunnn) ? $model->elaunnn->it_account_name . ' (' . $model->elaunnn->it_income_code . ')' : $model->SR_ROC_TYPE;
                    },
                ],
                [
                    //                                        'class' => 'yii\grid\SerialColumn',
                    'header' => 'TARIKH MULA',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->SR_DATE_FROM ? Yii::$app->formatter->asDate($model->SR_DATE_FROM, 'dd-MM-yyyy') : null;
                    },
                    'format' => 'html'
                ],
                [
                    //                                        'class' => 'yii\grid\SerialColumn',
                    'header' => 'TARIKH AKHIR',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->SR_DATE_FROM ? Yii::$app->formatter->asDate($model->SR_DATE_TO, 'dd-MM-yyyy') : null;
                    },
                    'format' => 'html'
                ],
                [
                    'header' => 'JUMLAH',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->SR_NEW_VALUE;
                    },
                ],
                [
                    'header' => 'KOD PROJEK',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        // return ($model->elaunnn) ? $model->elaunnn->it_status: null;
                        return $model->SR_PROJECT_CODE;
                    },
                ],
                [
                    'header' => 'STATUS',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return ($model->elaunnn) ? $model->elaunnn->it_status : null;
                    },
                ],
                [
                    //                                        'class' => 'yii\grid\SerialColumn',
                    'header' => 'TARIKH ISI',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->SR_ENTER_DATE ? Yii::$app->formatter->asDate($model->SR_ENTER_DATE, 'dd-MM-yyyy') : null;
                    },
                    'format' => 'html'
                ],
                [
                    //                                        'class' => 'yii\grid\SerialColumn',
                    'header' => 'TARIKH LUPUT',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->SR_CANCEL_DATE ? Yii::$app->formatter->asDate($model->SR_CANCEL_DATE, 'dd-MM-yyyy') : null;
                    },
                    'format' => 'html'
                ],
                [
                    'header' => 'ELAUN/POTONGAN',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return ($model->elaunnn) ? $model->elaunnn->it_trans_type : null;
                    },
                ],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    // you may configure additional properties here
                ],

                //                                     [
                //                                         'class' => 'yii\grid\ActionColumn',
                //                                         'header' => 'TINDAKAN',
                //                                         'headerOptions' => ['class'=>'text-center col-md-1'],
                //                                         'contentOptions' => ['class'=>'text-center'],
                //                                         'template' => '{view} {update} {delete}',
                //                                         'buttons' => [
                //                                             'view' => function ($url, $model) {
                //                                                 $url = Url::to(['saraan/lpg-report-2', 'lpg_id' => $model->t_lpg_id]);
                //                                                 return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, [
                //                                                     'title' => 'lpg', 'target' => '_blank', 'class' => 'btn btn-default btn-sm',
                //                                                 ]);
                //                                             },
                //                                             'update' => function ($url, $model) {
                //                                                 $url1 = Url::to(['saraan/kemaskini-lpg', 'icno' => $model->t_lpg_ICNO, 'lpg_id' => $model->t_lpg_id]);
                //                                                 return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url1, 'class' => 'btn btn-default btn-sm modalButton']);
                //                                             },
                //                                             'delete' => function ($url, $model) {
                //                                                 $url2 = Url::to(['saraan/padam-lpg', 'lpg_id' => $model->t_lpg_id]);
                //                                                 return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url2, [
                //                                                     'class' => 'btn btn-default btn-sm',
                //                                                     'data' => [
                //                                                                 'confirm' => 'Adakah anda ingin membuang rekod ini?',
                //                                                                 'method' => 'post',
                //                                                             ],
                //                                                     ]);
                //                                                 //Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value' => $url2, 'class' => 'btn btn-default btn-sm']);
                //                                             },       
                //                                         ],        
                //                                     ],          
            ],
        ]);
        ?>
    </div>
</div>

<div class="row">
    <div class="pull-right">
        <?php
        // $url1 = Url::to(['saraan/tambah-kew8']);
        echo Html::button('Salin', ['class' => 'btn btn-default btn-sm modalButton2']);
        ?>
    </div>
</div>