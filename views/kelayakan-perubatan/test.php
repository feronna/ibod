<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\hronline_gaji\Tblstaffroc;
use yii\data\ActiveDataProvider;
use kartik\form\ActiveForm;

error_reporting(0);


$this->title = 'Senarai LPG Untuk Tindakan';
?>  


<div class="tblprcobiodata-form">
    <div class="x_panel">
        <?= $this->render('_searchLPG', [
            'search' => $search,
        ]) ?>
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <h2><?= "Senarai LPG/Kew8 untuk disemak" ?></h2>
        <h5 class="pull-right"><?= Html::encode('Jumlah Carian: ') . $dataProvider->getCount() . " / " . $dataProvider->getTotalCount() ?></h5>
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="table-responsive">
    <?=
        GridView::widget([
            'emptyText' => 'Tiada Rekod',
            'summary' => '',
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'header' => 'BATCH CODE',
                    'headerOptions' => ['class' => 'text-center'],
                    'format'=>'raw',
                    'value' => function ($model) {
                        return 
                        Html::a($model->srb_batch_code, ['view-kumpulan','bid'=>$model->srb_batch_code,'sid'=>$model->srb_staff_id],['target'=>'_blank']);
                    },
                ],
                [
                    //                                        'class' => 'yii\grid\SerialColumn',
                    'header' => 'SEBAB PERGERAKAN',
                    'headerOptions' => ['class' => 'text-center'],
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
                    'header' => 'CATATAN',
                    'headerOptions' => ['class' => 'text-center'],
                    // 'contentOptions' => ['class' => 'text-center'],
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
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Tindakan',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['tindakan-kemasukan', 'id' => $model->srb_batch_code], ['target' => '_blank']);
                        },
                    ],
                ],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    // you may configure additional properties here
                ],       
            ],
        ]);
        ?>
        
        <div class="center pull-right">
        <?= Html::submitButton('<i class="fa fa-check"></i> Hantar', ['class' => 'btn btn-success', 'name' => 'hantar', 'value' => 'submit_1']) ?>
        <?= Html::submitButton('<i class="fa fa-check"></i> Buang', ['class' => 'btn btn-danger', 'name' => 'buang', 'value' => 'submit_2']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    </div>
    
</div>