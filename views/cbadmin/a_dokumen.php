<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 
<?= $this->render('/cutibelajar/_topmenu') ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel"> 
            <div class="x_content">  


                <div class="table-responsive">

                    <?php
                    $gridColumns = [
//                     'pager' => [
//                    'firstPageLabel' => 'First',
//                    'lastPageLabel'  => 'Last'
//                ],
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'BIL',
                            'headerOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:1%',
                            ],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            //'attribute' => 'CONm',
                            'label' => 'NAMA DOKUMEN',
                            'headerOptions' => ['class' => 'text-left'],
                            'options' => ['style' => 'width:40%'],
                            'filter' => Select2::widget([
                                'name' => 'nama_dokumen',
                                'value' => isset(Yii::$app->request->queryParams['nama_dokumen']) ? Yii::$app->request->queryParams['nama_dokumen'] : '',
                                'data' => ArrayHelper::map(\app\models\cbelajar\TblFileKpm::find()->groupBy('nama_dokumen')->all(), 'nama_dokumen', 'nama_dokumen'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                        $ICNO = $model->uploaded_by;
                        return Html::a('<strong>' . strtoupper($model->nama_dokumen) . '</strong><br>' .
                                        strtoupper($model->created_dt));
                    },
                            'format' => 'html',
                        ],
                        [
                            //'attribute' => 'CONm',
                            'label' => 'DIMUAT NAIK OLEH',
                            'headerOptions' => ['class' => 'column-title'],
                            'options' => ['style' => 'width:15%'],
                            'filter' => Select2::widget([
                                'name' => 'uploaded_by',
                                'value' => isset(Yii::$app->request->queryParams['uploaded_by']) ? Yii::$app->request->queryParams['uploaded_by'] : '',
                                'data' => ArrayHelper::map(\app\models\cbelajar\TblFileKpm::find()->joinWith('mohon')
                                                ->where(['cb_tbl_permohonan.status' => ["LULUS", "DALAM TINDAKAN BSM", "DALAM TINDAKAN KETUA JABATAN"]])->all(), 'uploaded_by', 'kakitangan.CONm'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'value' => function($model) {
                        $ICNO = $model->uploaded_by;
                        $id = $model->id;
                        return Html::a('<strong>' . $model->kakitangan->CONm . '</strong>', ['/tiketpenerbangan/kj-view', 'id' => $model->id]) . ' <br><small><b>UMSPER (' . $model->kakitangan->COOldID . ')</b></small>' . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                                '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred;
                    },
                            'format' => 'html',
                        ],
                        [
                            'label' => 'MUAT TURUN',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:2%'],
                            'contentOptions' => ['class' => 'text-center'],
                            'value' => function ($data) {
                        if($data->namafile)
                        {
                        return Html::a('', (Yii::$app->FileManager->DisplayFile($data->namafile)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']);
                        }
                        else
                        {
                            return '<small><strong>TIADA DOKUMEN</strong></small>';
                        }
                        
                        },
                        ],
                    ];



                    echo GridView::widget([
                        'pager' => [
                            'firstPageLabel' => 'First',
                            'lastPageLabel' => 'Last'
                        ],
                        'dataProvider' => $permohonan,
                        'filterModel' => true,
                        'columns' => $gridColumns,
                        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                        'beforeHeader' => [
                            [
                                'columns' => [],
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
                            'heading' => '<h5>SENARAI DOKUMEN YANG DIMUATNAIK -  BORANG KPT</h5>',
                        ],
                    ]);
                    ?>
                </div>


            </div>
        </div>  

    </div>  
</div>

