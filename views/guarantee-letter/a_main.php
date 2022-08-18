<?php
 
use kartik\grid\GridView; 
use yii\helpers\Html;  
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 
        <div class="x_content">  


            <div class="table-responsive">

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'], 
                    [
                        'label' => 'Nama Pegawai',
                        'value' => function($model) {
                            return ucwords(strtolower($model->biodata->CONm));                       },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Nama Pemohon',
                        'value' => function($model) {
                            return ucwords(strtolower($model->gl_nama));                       },
                        'format' => 'raw',
                    ],
                                [
                        'label' => 'No. K/P',
                        'value' => function($model) {
                            if ($model->biodata->NatCd == "MYS") {
                                return $model->gl_ICNO;
                            } else {
                                return $model->biodata->latestPaspot;
                            }
                        },
                        'format' => 'raw',
                    ],
                                [
                        'label' => 'Hubungan',
                        'value' => function($model) {
                            return $model->gl_hubungan;
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
                        'label' => 'Tindakan',
                        'value' => function($model) {
                            return Html::button('<i class="fa fa-lg fa-eye"></i>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['detail-permohonan', 'id' => $model->id]), 'class' => 'mapBtn btn btn-default btn-sm']);
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                        ];



                        echo GridView::widget([
                            'dataProvider' => $permohonan,
                            'columns' => $gridColumns,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [ ],
                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                ]
                            ],
                            'toolbar' => [ 
                                ['content' => '']
                            ], 
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,  
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h2>Rekod Permohonan (eGL)</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

