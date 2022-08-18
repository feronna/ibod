<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

error_reporting(0);


$this->title = 'Semakan';
?>

<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1186, 1183, 1184, 1185], 'vars' => []]); ?>


<div class="tblprcobiodata-form">
    <div class="x_panel">
        <div class="x_title">
            <h2>Carian</h2>
            <div class="clearfix"></div>
        </div>
        <?php $form = ActiveForm::begin([
            'action' => ['semakan-diterima'],
            'method' => 'get',
            'options' => ['class' => 'form-horizontal form-label-left']
        ]); ?>
        <div class="form-group ">
            <div class="form-group col-md-12 col-sm-12 col-xs-12 align-center">
                <div class=" col-md-5 col-sm-5 col-xs-12">
                    <?= $form->field($search, 'carian_data')->textInput(['placeholder' => 'Batch Code / Staff ID'])->label(false) ?>
                </div>
                <div class=" col-md-1 col-sm-1 col-xs-12">
                    <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary']) ?>
                </div>
                <div class=" col-md-1 col-sm-1 col-xs-12">
                    <?= Html::submitButton('<i class="fa fa-refresh" aria-hidden="true"></i> Set Semula', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <h2><?= "Senarai LPG/Kew8 Diterima" ?></h2>
        <h5 class="pull-right"><?= Html::encode('Jumlah Carian: ') . $dataProvider->getCount() . " / " . $dataProvider->getTotalCount() ?></h5>
        <div class="clearfix"></div>
    </div>

    <div class="table-responsive">
        <?=
        GridView::widget([
            //'tableOptions' => [
            //  'class' => 'table table-striped jambo_table',
            //],
            'emptyText' => 'Tiada Rekod',
            'summary' => '',
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'label' => 'UMSPER',
                    'value' => 'srb_staff_id',
                ],
                [
                    'label' => 'LPG BATCH CODE',
                    'value' => 'srb_batch_code',
                ],


                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Tindakan',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['tindakan-semakan', 'id' => $model->srb_batch_code], ['target' => '_blank']);
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
    </div>

</div>