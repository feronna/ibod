<?php

use kartik\grid\GridView;
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
                            return ucwords(strtolower($model->biodata->CONm));
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Surat Jaminan',
                        'value' => function($model) {


                            if ($model->biodata->NatCd == "MYS") {
                                $fmy = app\models\hronline\Tblkeluarga::find()->where(['FamilyId' => $model->gl_ICNO])->one();
                                if ($fmy) {
                                    return $model->gl_ICNO . ' (' . ucwords(strtolower($fmy->FmyNm)) . ')';
                                } else {
                                    return $model->gl_ICNO. ' (' .ucwords(strtolower($model->biodata->CONm)). ')';
                                }
                            } else {
                                return $model->biodata->latestPaspot;
                            }
                        },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Hopital',
                                'value' => function($model) {
                                    return ucwords(strtolower($model->hospital->nama));
                                },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Tarikh/Masa',
                                'value' => function($model) {
                                    return $model->datetime;
                                },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Pegawai Bertugas',
                                'value' => function($model) {
                                    return ucwords(strtolower($model->pengkemaskini->CONm));
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
                                'heading' => '<h2>Rekod Permohonan Batal</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

