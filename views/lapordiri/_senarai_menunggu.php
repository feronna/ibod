<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;

error_reporting(0);
?>

<?php if ($title == 'Senarai Menunggu Semakan') { ?>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="row"> 
        <div class="col-xs-12 col-md-12 col-lg-12"> 
            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" 
                                                                  aria-expanded="true"><b>Pemakluman Semakan</b></a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" 
                                                            data-toggle="tab" aria-expanded="false"><b>Penerimaan Lapor Diri</b></a>
                        </li>

                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" 
                                                            data-toggle="tab" aria-expanded="false"><b>Belum Buat Pengesahan</b></a>
                        </li>



                    </ul>
                </div>

                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab_content1" aria-labelledby="home-tab">
                        <div class="x_content">
                            <div class="table-responsive">
                                <?=
                                GridView::widget([
                                    'dataProvider' => $senarai,
                                    'summary' => '',
                                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                                    'options' => [
                                        'class' => 'table-responsive',
                                    ],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => 'Bil',
                                        ],
                                        [
                                            //'attribute' => 'CONm',
                                            'label' => 'NAMA',
                                            'headerOptions' => ['class' => 'column-title'],
                                            'value' => function($model) {

                                        if ($model->status_pengajian == 1) {
                                            return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ["lapordiri/adminviewselesai", 'id' => $model->iklan_id, 'i' => $model->laporID]) . ' <br><small><b>UMSPER (' . $model->kakitangan->COOldID . ')</b></small>' . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                                                    '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Hantar:' . $model->tarikh_mohon;
                                        } else {
                                            return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ["lapordiri/adminview", 'id' => $model->iklan_id, 'i' => $model->laporID]) . ' <br><small><b>UMSPER (' . $model->kakitangan->COOldID . ')</b></small>' . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                                                    '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Hantar:' . $model->tarikh_mohon;
                                        }
                                    },
                                            'format' => 'html',
                                        ],
                                        [
                                            //'attribute' => 'CONm',
                                            'label' => 'STATUS KETUA JABATAN/DEKAN',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
                                        return '<strong>' . $model->statusjfpiu . '</strong><br>'
                                                . $model->app_date;
                                    },
                                            'format' => 'html',
                                        ],
                                        [
                                            //'attribute' => 'CONm',
                                            'label' => 'STATUS PENGAJIAN',
                                            'headerOptions' => ['class' => 'column-title text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                        if ($model->study->status_pengajian) {
                                            return Html::a($model->study->status_pengajian);
                                        } else {
                                            return $model->status_pengajian;
                                        }
                                    },
                                            'format' => 'html',
                                        ],
//                           [
//                           //'attribute' => 'CONm',
//                            'label' => 'PENGESAHAN PERKHIDMATAN',
//                            'headerOptions' => ['class'=>'column-title text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
////                                $ICNO = $model->icno;
////                                $id = $model->laporID;
//                             return  
//                        Html::a('<i class="fa fa-edit fa-lg">', ["status-perkhidmatan/view?icno=$model->icno"]);
//                                
//                            }, 
//                                   
//                                    'format' => 'html',
//                        ],
//                        [
//                           //'attribute' => 'CONm',
//                            'label' => 'TARIKH MULA NOMINAL DAMAGES',
//                            'headerOptions' => ['class'=>'column-title text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
////                                $ICNO = $model->icno;
////                                $id = $model->laporID;
//                             return  
//                        Html::a('<i class="fa fa-legal fa-lg">', ["status-perkhidmatan/view?icno=$model->icno"]);
//                                
//                            }, 
//                                   
//                                    'format' => 'html',
//                        ],
                                        [
                                            'label' => 'PERINCIAN STATUS PENGAJIAN',
                                            'format' => 'raw',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function ($data) use ($pengajian) {
                                          if ($data->kakitangan->Status == 1 && $data->kakitangan->jawatan->job_category == 2 
                                              && in_array($data->HighestEduLevelCd, [8])) {
                                            return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['v_rekodpjj', 'id' => $data->laporID]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-legal fa-lg mapBtn']);
                                        }
                                        elseif ($data->kakitangan->Status == 1 && in_array($data->HighestEduLevelCd, [202, 1, 20])) {
                                            return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['v_rekod', 'id' => $data->laporID]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);
                                        } elseif ($data->terima == NULL) {
                                            $ICNO = $data->icno;

                                            return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['lapordiri/view_2', 'id' => $pengajian->id, 'laporID' => $data->laporID]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-legal fa-lg mapBtn']);
                                        }
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
                                        else {
                                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]) | Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                                        }
                                    },
                                        ],
//                    [
//                        'label'=>'SALINAN SURAT TAWARAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                         if ($data->checkUpload($data->laporID)){
//                         return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-check-square-o fa-lg', 'target' => '_blank']);}
//                        else{
//                          return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsuratlapor', 'id' => $data->laporID]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
//                        }
//                      },
//             ],
                                        [
                                            'label' => 'PEMAKLUMAN',
                                            'format' => 'raw',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function ($data) {
                                        if ($data->status_bsm == 'Draft Diluluskan') {
                                            $checked = 'checked';
                                        }
                                        if ($data->status_bsm == 'Draft Ditolak') {
                                            $checked1 = 'checked';
                                        }
                                        if ($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan') {
                                            return $data->statusbsm;
                                        }
                                        return Html::a('<input type="radio" name="' . $data->laporID . '" value="y' . $data->laporID . '" ' . $checked . '><i class="fa fa-check"></i>') . '  ' . Html::a('<input type="radio" name="' . $data->laporID . '" value="n' . $data->laporID . '" ' . $checked1 . '><i class="fa fa-remove"></i>');
                                    },
                                        ],
                                        [
                                            'class' => 'yii\grid\CheckboxColumn',
                                            'checkboxOptions' => function ($data) {
                                                if (($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan')) {
                                                    return ['disabled' => 'disabled'];
                                                }
                                                return ['value' => $data->laporID, 'checked' => true];
                                            },
                                                ],
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12" align="right">  
                                        <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                                        <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                                </div>
                                        <?php ActiveForm::end(); ?>
                            </div>

                                    <?php } ?>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">


                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel"> 


                                        <div class="table-responsive">

                                <?php
                                $gridColumns2 = [
                                    ['class' => 'yii\grid\SerialColumn',
                                        'header' => 'BIL',
                                        'headerOptions' => ['style' => 'width:1%', 'class' => 'text-center'],
                                        'contentOptions' => ['class' => 'text-center'],
                                    ],
                                    [
                                        //'attribute' => 'CONm',
                                        'label' => 'NAMA',
                                        'headerOptions' => ['class' => 'column-title'],
                                        'value' => function($model) {

                                    if ($model->status_pengajian == 1) {
                                        return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ["lapordiri/adminviewselesai", 'id' => $model->iklan_id, 'i' => $model->laporID]) . ' <br><small><b>UMSPER (' . $model->kakitangan->COOldID . ')</b></small>' . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                                                '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Hantar:' . $model->tarikh_mohon;
                                    } else {
                                        return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ["lapordiri/adminview", 'id' => $model->iklan_id, 'i' => $model->laporID]) . ' <br><small><b>UMSPER (' . $model->kakitangan->COOldID . ')</b></small>' . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                                                '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Hantar:' . $model->tarikh_mohon;
                                    }
                                },
                                        'format' => 'html',
                                    ],
                                    [
                                        //'attribute' => 'CONm',
                                        'label' => 'STATUS KETUA JABATAN/DEKAN',
                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
                                    return '<strong>' . $model->statusjfpiu . '</strong><br>'
                                            . $model->app_date;
                                },
                                        'format' => 'html',
                                    ],
                                    [
                                        //'attribute' => 'CONm',
                                        'label' => 'STATUS PENGAJIAN',
                                        'headerOptions' => ['class' => 'column-title text-center'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                    if ($model->study->status_pengajian) {
                                        return Html::a('<strong style=color:green><small>' . $model->study->status_pengajian) . '<br><strong><small>TARIKH LAPOR DIRI:' .
                                                strtoupper($model->dtlapor) . '</strong></small>';
                                    } else {
                                        return $model->status_pengajian;
                                    }
                                },
                                        'format' => 'html',
                                    ],
//                           
                                    [
                                        'label' => 'KEMASKINI STATUS PENGAJIAN',
                                        'format' => 'raw',
                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'value' => function ($data) use ($pengajian) {
                                    if ($data->kakitangan->Status == 1 && in_array($data->HighestEduLevelCd, [202, 1, 20])) {
                                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['v_rekod', 'id' => $data->laporID]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);
                                    } elseif ($data->terima == NULL) {
                                        $ICNO = $data->icno;

                                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['lapordiri/view_2', 'id' => $pengajian->id, 'laporID' => $data->laporID]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-legal fa-lg mapBtn']);
                                    }
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
                                    else {
                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]) | Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                                    }
                                },
                                    ],
                                    [
                                        'label' => 'PPUU',
                                        'format' => 'raw',
                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'value' => function ($data) use ($pengajian) {

//                             return Html::a('PPPU', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['pengesahan-lapor-diri', 'id' =>$data->laporID]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-legal fa-lg']);

                                    return Html::a(' Pengesahan', ['/lapordiri/pengesahan-lapor-diri', 'i' => $data->laporID], ['class' => 'fa fa-download', 'target' => '_blank']);
                                },
                                    ],
                                ];



                                echo GridView::widget([
                                    'dataProvider' => $terima,
                                    'columns' => $gridColumns2,
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
                                        'heading' => '<h6> '
                                        . '<i class="fa fa-check-square fa-lg" style="color:green"></i> Pemakluman Lapor Diri Yang Diterima</h6>',
                                    ],
                                ]);
                                ?>
                                        </div>


                                    </div>
                                </div>  

                            </div>  
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">


                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel"> 


                                        <div class="table-responsive">

                                            <?php
                                            $gridColumns3 = [
                                                ['class' => 'yii\grid\SerialColumn',
                                                    'header' => 'BIL',
                                                    'headerOptions' => ['style' => 'width:1%', 'class' => 'text-center'],
                                                    'contentOptions' => ['class' => 'text-center'],
                                                ],
                                                [
                                                    //'attribute' => 'CONm',
                                                    'label' => 'NAMA',
                                                    'headerOptions' => ['class' => 'column-title'],
                                                    'value' => function($model) {

                                                if ($model->status_pengajian == 1) {
                                                    return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ["lapordiri/adminviewselesai", 'id' => $model->iklan_id, 'i' => $model->laporID]) . ' <br><small><b>UMSPER (' . $model->kakitangan->COOldID . ')</b></small>' . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                                                            '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred;
                                                } else {
                                                    return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ["lapordiri/adminview", 'id' => $model->iklan_id, 'i' => $model->laporID]) . ' <br><small><b>UMSPER (' . $model->kakitangan->COOldID . ')</b></small>' . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                                                            '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred;
                                                }
                                            },
                                                    'format' => 'html',
                                                ],
                                                [
                                                    //'attribute' => 'CONm',
                                                    'label' => 'STATUS PENGAJIAN',
                                                    'headerOptions' => ['class' => 'column-title text-center'],
                                                    'contentOptions' => ['class' => 'text-center'],
                                                    'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                                if ($model->study->status_pengajian && $model->agree == NULL) {
                                                    return Html::a('<strong style=color:green><small>' . $model->study->status_pengajian) . '<br><strong><small>BELUM BUAT PENGESAHAN';
                                                }
//                             else
//                             {
//                                 return $model->status_pengajian;
//                             }
                                            },
                                                    'format' => 'html',
                                                ],
                                                    
                                                [
                                                    //'attribute' => 'CONm',
                                                    'label' => 'TINDAKAN',
                                                    'headerOptions' => ['class' => 'column-title text-center'],
                                                    'contentOptions' => ['class' => 'text-center'],
                                                    'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                                if ($model->study->status_pengajian && $model->agree == NULL) {
                                 return '<i class="fa fa-exclamation-triangle fa-xs" style="color:red"></i> '. "Belum Buat Pengesahan".'<br>'.
                                               Html::a('<i class="fa fa-bell" aria-hidden="true"></i>', [
                                        '/lkk/notifistaflapor',
//                                        'icno' =>$model->icno,
                                        'id' => $model->laporID,
                                
                                            ], [
                                        'class' => 'btn btn-default','title' => 'Notifi Staf'
//                                        'target' => '_blank',
                                    ]) ;                                                }
//                             else
//                             {
//                                 return $model->status_pengajian;
//                             }
                                            },
                                                    'format' => 'html',
                                                ],
//                           
                                            ];



                                            echo GridView::widget([
                                                'dataProvider' => $belum,
                                                'columns' => $gridColumns3,
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
                                                    'heading' => '<h6> '
                                                    . '<i class="fa fa-check-square fa-lg" style="color:green"></i> '
                                                    . 'Belum Buat Pengesahan Lapor Diri</h6>',
                                                ],
                                            ]);
                                            ?>
                                </div>


                            </div>
                        </div>  

                    </div>  
                </div>
            </div></div></div> </div>