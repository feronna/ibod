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
    <div class="x_title">
        <h2>Carian</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
        <?php
        $form = ActiveForm::begin([
                    'action' => ['laporan-sh-kontraktor'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                    'fieldConfig' => ['autoPlaceholder' => true,
                    ],
        ]);
        ?>

        <div class="col-md-3 col-sm-3 col-xs-3">
                <?=$form->field($searchModel, 'ICNO')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\Kontraktor\Kontraktor::find()->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Nama', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>  
            <div class="col-md-3 col-sm-3 col-xs-3">
                <?=$form->field($searchModel, 'syarikat_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\esticker\TblKontraktor::find()->all(), 'apsu_suppid', 'apsu_lname'),
                    'options' => ['placeholder' => 'Syarikat', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div> 
        <div class="col-md-3 col-sm-3 col-xs-3">
            <?=
            $form->field($searchModel, 'flag')->label(false)->widget(Select2::classname(), [
                'data' => [2 => 'BELUM SELESAI', 0 => 'SELESAI'],
                'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3">
            <?=
            $form->field($searchModel, 'check_in')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'HARIAN'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd'
                ]
            ])->label(false);
            ?>
        </div> 
        <div class="col-md-3 col-sm-3 col-xs-3">
            <?=
            $form->field($searchModel, 'bulanan')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'BULAN & TAHUN'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'startView' => 'year',
                    'minViewMode' => 'months',
                    'format' => 'mm-yyyy'
                ]
            ])->label(false);
            ?>
        </div>  

        <div class="col-md-1 col-sm-1 col-xs-1">
            <div class="form-group">
                <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
            </div>
        </div>

        <?php ActiveForm::end(); ?> 
    </div>
</div>

<div class="x_panel">
    <div class="table-responsive">     
        <?php Pjax::begin(); ?>
        <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'No. K/P',
                'value' => function ($model) {
                    return $model->ICNO;
                },
            ],
            [
                'label' => 'Nama',
                'value' => function ($model) {
                    return $model->pekerja->CONm;
                },
            ],
            [
                'label' => 'Tarikh/Masa (Masuk)',
                'value' => function ($model) {
                    return $model->check_in;
                },
            ],
            [
                'label' => 'Tarikh/Masa (Anggaran Keluar)',
                'value' => function ($model) {
                    return $model->check_out;
                },
            ],
            [
                'label' => 'Destinasi',
                'value' => function ($model) {
                    return $model->destinasi->nama;
                },
            ],
            [
                'label' => 'Kampus',
                'value' => function ($model) {
                    return $model->campus->campus_name;
                },
            ],
            [
                'label' => 'Ulasan (Buka Kes)',
                'value' => function ($model) {
                    return $model->flag_open_reason;
                },
            ],
            [
                'label' => 'Tarikh Buka Kes',
                'value' => function ($model) {
                    return $model->flag_created_at;
                },
            ],
            [
                'label' => 'Ulasan (Tutup Kes)',
                'value' => function ($model) {
                    return $model->flag_closed_reason;
                },
            ],
            [
                'label' => 'Tarikh Tutup Kes',
                'value' => function ($model) {
                    return $model->flag_updated_at;
                },
            ],
        ];
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'beforeHeader' => [
                [
                    'columns' => [],
                    'options' => ['class' => 'skip-export'] // remove this row from export
                ]
            ],
            'toolbar' => [
                '{export}',
                '{toggleData}'
            ],
            'bordered' => true,
            'striped' => false,
            'condensed' => false,
            'responsive' => true,
            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => '<h2>Laporan Kontraktor Harian</h2>',
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>

