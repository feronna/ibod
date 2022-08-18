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

use app\models\gaji\TblStaffRoc as GajiTblStaffRoc;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\hronline_gaji\Tblstaffroc;

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

<?php 
// $url_tambah_kumpulan = Url::to(['tambah-kumpulan', 'staff_id' => $staff_id]);
// echo Html::button('Tambah Kumpulan', ['value' => $url_tambah_kumpulan, 'class' => 'btn btn-default btn-sm modalButton']);
echo Html::a('Tambah LPG/KEW8', ['tambah-kumpulan', 'staff_id' => $staff_id],['class' => 'btn btn-default btn-sm','target'=>'_blank']);
?>

<div class="row">
    <div class="table-responsive">
        <?=
        GridView::widget([
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
                    'header' => 'BATCH CODE',
                    'headerOptions' => ['class' => 'text-center'],
                    'format'=>'raw',
                    // 'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return 
                        Html::a($model->srb_batch_code, ['view-kumpulan','bid'=>$model->srb_batch_code,'sid'=>$model->srb_staff_id],['target'=>'_blank']);
                    },
                ],
                [
                    //                                        'class' => 'yii\grid\SerialColumn',
                    'header' => 'SEBAB PERGERAKAN',
                    'headerOptions' => ['class' => 'text-center'],
                    // 'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->reason->RR_REASON_DESC;
                    },
                ],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail' => function ($model, $key, $index, $column) {
                        $query = TblStaffRoc::find()->where(['SR_ENTRY_BATCH' => $model->srb_batch_code])->orderBy(['SR_CHANGE_TYPE' => 'ASC']);

                        $dataProvider = new ActiveDataProvider([
                            'query' => $query,
                            'pagination' => [
                                'pageSize' => 20,
                            ],
                            'sort' => false,
                        ]);

                        return Yii::$app->controller->renderPartial('staff/_elaun', [
                            'dataProvider' => $dataProvider,
                        ]);
                    },
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'expandOneOnly' => true
                ],
                [
                    //                                        'class' => 'yii\grid\SerialColumn',
                    'header' => 'CATATAN',
                    'headerOptions' => ['class' => 'text-center'],
                    // 'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->srb_remarks;
                    },
                    'format' => 'html'
                ],
                [
                    //                                        'class' => 'yii\grid\SerialColumn',
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
                        // return ($model->elaunnn) ? $model->elaunnn->it_status: null;
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
                // [
                //     'header' => 'ELAUN/POTONGAN',
                //     'headerOptions' => ['class' => 'text-center col-md-1'],
                //     'contentOptions' => ['class' => 'text-center'],
                //     'value' => function ($model) {
                //         return ($model->elaunnn) ? $model->elaunnn->it_trans_type : null;
                //     },
                // ],

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
</div><br>

<div class="row">
    <div class="pull-right">
        <?php
        $url1 = Url::to(['saraan/tambah-kew8']);
        echo Html::button('Salin', ['value' => $url1, 'class' => 'btn btn-default btn-sm modalButton']);
        ?>
    </div>
</div>