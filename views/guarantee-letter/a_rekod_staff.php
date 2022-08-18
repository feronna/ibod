<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel"> 
        <div class="x_content">
            <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                <?= $form->field($permohonan, 'gl_ICNO')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Nama Staff'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);?>
            </div>
            <div class="text-center col-md-1 col-sm-1 col-xs-1">
                <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>  
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div> 

    <div class="x_panel"> 
        <div class="x_content">   
            <div class="table-responsive">

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Butiran Permohonan',
                        'value' => function($model) {
                            if ($model->biodata->NatCd == "MYS") {
                                $icno = $model->ICNO;
                            } else {
                                $icno = $model->biodata->latestPaspot;
                            }
                            return 'Nama : ' . ucwords(strtolower($model->gl_nama)) . '<br/>No. K/P : ' . $icno . '<br/>Hubungan : ' . $model->gl_hubungan.'</br>Tempat : '.ucwords(strtolower($model->hospital->nama));
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Kelas Wad',
                        'value' => function($model) {
                            return ucwords(strtolower($model->kelasWad->nama));
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Tarikh/Masa Mohon',
                        'value' => function($model) {
                            return $model->tarikh_mohon;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Status Permohonan',
                        'value' => function() {
                            return '<span class="label label-success">Diterima </span>';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Tindakan',
                        'value' => function($model) { 
                                return Html::button(' ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kemaskini-surat-jaminan', 'id' => $model->id]), 'class' => 'fa fa-edit mapBtn btn btn-default btn-lg'])
                                       .Html::button('  Batal', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['batal-permohonan', 'id' => $model->id]), 'class' => 'fa fa-trash mapBtn btn btn-danger btn-lg'])
                                        ; 
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                        ];



                        echo GridView::widget([
                            'dataProvider' => $model,
                            'columns' => $gridColumns,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [],
                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                ]
                            ],
                            'toolbar' => [
//                                '{export}',
//                                '{toggleData}'
                            ],
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h2>Rekod Permohonan Surat Jaminan (eGL)</h2>',
                            ],
                        ]);
                        ?>
                    </div> 
                </div>
            </div>  

</div>  

