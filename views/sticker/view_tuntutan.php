<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
?>

<?= $this->render('menu') ?> 


<div class="x_panel">
    <div class="table-responsive">     
        <?php Pjax::begin(); ?>
        <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'No. K/P',
                'value' => function($model) {
                    return $model->biodata->ICNO;
                },
            ],
            [
                'label' => 'Nama',
                'value' => function($model) {
                    return $model->biodata->CONm;
                },
            ],
            [
                'label' => 'Jabatan',
                'value' => function($model) {
                    return $model->biodata->department->shortname;
                },
            ],
            [
                'label' => 'Rekod Pelekat',
                'value' => function($model) {
                    return Html::a('<i class="fa fa-eye"></i>', ['senarai-pelekat', 'key' => md5($model->ICNO)], ['class' => 'btn btn-default btn-sm']);
                },
                        'format'=>'raw',
            ],
            [
                'label' => 'Tindakan',
                'value' => function($model) {
                    if(empty($model->pay_status)){
                        return Html::a('<i class="fa fa-money"></i> BAYAR <i class="fa fa-edit"></i>', ['bayar-tuntutan', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']);
                    }else{
                        return '';
                    }
                },
                        'format'=>'raw',
            ],
            [
                'label' => 'Status',
                'value' => function($model) {
                    if ($model->pay_status == 0) {
                        return '<span class="label label-danger">BELUM BAYAR</span>';
                    } else {
                        return '<span class="label label-success">SELESAI</span>';
                    }
                },
                        'format'=>'raw',
            ],
                        [
                'label' => 'Jenis Pembayaran',
                'value' => function($model) {
                    if ($model->pay_type == 1) {
                        return 'KAUNTER';
                    } elseif ($model->pay_type == 2) {
                        return 'ATAS TALIAN';
                    }else{
                        return '';
                    }
                },
                        'format'=>'raw',
            ],
        ];
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'beforeHeader' => [
                [
                    'columns' => [],
                    'options' => ['class' => 'skip-export'] // remove this row from export
                ]
            ],
            'toolbar' => [],
            'bordered' => true,
            'striped' => false,
            'condensed' => false,
            'responsive' => true,
            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => '<h2>Rekod Tuntutan</h2>',
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>

