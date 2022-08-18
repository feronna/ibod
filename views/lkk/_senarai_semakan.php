<?php
$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use kartik\export\ExportMenu;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

error_reporting(0);
$url1 = Url::to(['senaraisemakan']);
$js = <<<js
    $('.hantar').on('click',function (){

        var keys = $('#grid').yiiGridView('getSelectedRows');
        $.post("$url1",
        {'keylist': keys},
        function(data){

        });

    });

js;
$this->registerJs($js);
?>
<?= $this->render('/cutibelajar/_topmenu') ?>
<!-- $this->render('/lkk/menu_jumlah')-->
<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<?php
$gridColumns = [

    ['class' => 'yii\grid\SerialColumn',
        'header' => 'BIL',],
    [

        'label' => 'TARIKH AKHIR HANTAR LKP',
        'value' => function ($data) {
            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
            return strtoupper($data->dt)
            ;
        },
        'format' => 'raw'
    ],
    [
        'label' => 'SEMESTER/SESI',
        'format' => 'raw',
        'headerOptions' => ['class' => 'text-center'],
//                 'contentOptions' => ['class'=>'text-center'],
        'value' => function ($list) {
    return
            '<small>: ' . strtoupper($list->semester . ' / ' . $list->session) . '</small>';
}
    ],
    [

        'label' => 'NAMA KAKITANGAN',
        'value' => function ($data) {
            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
            return Html::a(strtoupper($data->kakitangan->CONm));
        },
        'format' => 'raw'
    ],
    [

        'label' => 'NO KAD PENGENALAN',
        'value' => function ($data) {
            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
            return Html::a(strtoupper($data->icno));
        },
        'format' => 'raw'
    ],
    [
        'label' => 'JFPIB',
        'value' => function ($data) {
            return $data->kakitangan->department->shortname;
        },
        'format' => 'raw'
    ],
    [

        'label' => 'INSTITUT/UNIVERSITI',
        'value' => function ($data) {
            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
            return Html::a(strtoupper($data->pengajian->InstNm));
        },
        'format' => 'raw'
    ],
    [

        'label' => 'PERINGKAT PENGAJIAN',
        'value' => function ($data) {
            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
            return strtoupper($data->pengajian->tahapPendidikan);
        },
        'format' => 'raw'
    ],
    [

        'label' => 'NEGARA',
        'value' => function ($data) {
            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
            return strtoupper($data->pengajian->negara->Country);
        },
        'format' => 'raw'
    ],
    [

        'label' => 'BIDANG',
        'value' => function ($data) {
            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));

            if (($data->pengajian->MajorCd == NULL) && ($data->pengajian->MajorMinor != NULL)) {
                return strtoupper($data->pengajian->MajorMinor);
            } elseif (($data->pengajian->MajorCd != NULL) && ($data->pengajian->MajorMinor != NULL)) {
                return strtoupper($data->pengajian->MajorMinor);
            } else {
                return strtoupper($data->pengajian->major->MajorMinor);
            }
        },
        'format' => 'raw'
    ],
    [

        'label' => 'TARIKH PENGAJIAN',
        'value' => function ($data) {
            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
            return strtoupper($data->pengajian->tarikhmula) . ' HINGGA ' . strtoupper($data->pengajian->tarikhtamat);
        },
        'format' => 'raw'
    ],
    [

        'label' => 'LANJUTAN 01',
        'value' => function ($data) {

//                             if($data->lanjutan->idLanjutan == 1)
//                             {
//                                 return $data->lanjutan->stlanjutan;
//                             }

            return strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno' => $data->pengajiansemasa->icno, 'idLanjutan' => 1, 'HighestEduLevelCd' => $data->pengajiansemasa->HighestEduLevelCd])->one()->stlanjutan)
                    . ' HINGGA ' . strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno' => $data->pengajiansemasa->icno, 'idLanjutan' => 1, 'HighestEduLevelCd' => $data->pengajiansemasa->HighestEduLevelCd])->one()->ndlanjutan);



            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
//                                return  $data->tajaan->penajaan->penajaan.' - '.strtoupper($data->tajaan->nama_tajaan);
        },
                'format' => 'raw'
            ],
            [

                'label' => 'LANJUTAN 02',
                'value' => function ($data) {

//                             if($data->lanjutan->idLanjutan == 1)
//                             {
//                                 return $data->lanjutan->stlanjutan;
//                             }

                    return strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno' => $data->pengajiansemasa->icno, 'idLanjutan' => 2, 'HighestEduLevelCd' => $data->pengajiansemasa->HighestEduLevelCd])->one()->stlanjutan)
                            . ' HINGGA ' . strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno' => $data->pengajiansemasa->icno, 'idLanjutan' => 2, 'HighestEduLevelCd' => $data->pengajiansemasa->HighestEduLevelCd])->one()->ndlanjutan);



                    //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
//                                return  $data->tajaan->penajaan->penajaan.' - '.strtoupper($data->tajaan->nama_tajaan);
                },
                        'format' => 'raw'
                    ],
                    [

                        'label' => 'LANJUTAN 03',
                        'value' => function ($data) {

//                             if($data->lanjutan->idLanjutan == 1)
//                             {
//                                 return $data->lanjutan->stlanjutan;
//                             }

                            return strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno' => $data->pengajiansemasa->icno, 'idLanjutan' => 3, 'HighestEduLevelCd' => $data->pengajiansemasa->HighestEduLevelCd])->one()->stlanjutan)
                                    . ' HINGGA ' . strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno' => $data->pengajiansemasa->icno, 'idLanjutan' => 3, 'HighestEduLevelCd' => $data->pengajiansemasa->HighestEduLevelCd])->one()->ndlanjutan);


                            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
//                                return  $data->tajaan->penajaan->penajaan.' - '.strtoupper($data->tajaan->nama_tajaan);
                        },
                                'format' => 'raw'
                            ],
                            [
                                'label' => 'STATUS',
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => function($list) {
                                    if ($list->status == NULL) {
                                        return 'BELUM HANTAR';
                                    } elseif ($list->status == "MANUAL UPLOAD") {
                                        return "<strong><small>TELAH DIHANTAR</small></strong><br>" . '<br> [' . $list->tarikh_hantar . ']';
                                    } elseif ($list->tarikh_mohon) {
                                        return "<strong><small>TELAH DIHANTAR</small></strong><br>" .
                                                '<br> [' . $list->tarikh_mohon . ']';
                                    } else {
                                        return "<strong><small>BELUM BUAT PENGESAHAN</small></strong><br>";
                                    }
                                }
                                ,
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'STATUS PENYELIA',
                                'attribute' => 'statuspenyelia',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->status_r == "DONE" || $model->status_r == "BYPASS") {
                                        return $model->statuspenyelia . '<br> [' .
                                                $model->r_dt . ' ]';
                                    } else {
                                        return 'MENUNGGU SEMAKAN';
                                    }
                                }
                                ,
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'STATUS KETUA JABATAN',
                                'attribute' => 'statuspenyelia',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if (($model->status_r == "DONE" && $model->status_jfpiu == "Diperakukan") || ($model->status_r == "BYPASS" && $model->status_jfpiu == "Diperakukan")) {
                                        return $model->statusjfpiu . '<br> [' .
                                                $model->verify_dt . ' ]';
                                    } else {
                                        return 'MENUNGGU SEMAKAN';
                                    }
                                }
                                ,
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'STATUS PENGHANTARAN LKP',
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if (($model->status == "DALAM TINDAKAN KETUA JABATAN" ) ||
                                            ($model->status == "DALAM TINDAKAN BSM" ) || ($model->status == "TELAH DISEMAK" )) {
                                        return "<strong><small>ATAS TALIAN</small></strong>";
                                    } elseif ($model->status == "MANUAL UPLOAD") {
                                        return "<strong><small>MANUAL UPLOAD</small></strong><br>";
                                    } else {
                                        return "-";
                                    }
                                }
                                ,
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'GOT - PROPOSAL DEFENCE',
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->got->result == 1) {
                                        return 'YES';
                                    } elseif ($model->got->result == 2) {
                                        return 'NO';
                                    } else {
                                        return 'NO RECORD';
                                    }
                                }
                                ,
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'KERJA KURSUS/CAMPURAN',
                                'attribute' => 'cw_gpa',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->cw_gpa) {
                                        return $model->cw_gpa;
                                    } else {
                                        return '-';
                                    }
                                }
                                ,
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'OVERALL PERFORMANCE',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($list) {

                            $c = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 5])->one();
                            $b = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 7])->one();
                            $a = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 6])->one();
                            $d = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 4])->one();
                            $e = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 3])->one();
                            $f = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 2])->one();
                            $g = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 1])->one();

                            if ($list->status_r == "DONE") {
                                $total = 0;
                                $total = ($a->p_komen + $b->p_komen + $c->p_komen + $d->p_komen + $e->p_komen + $f->p_komen + $g->p_komen);
                                return '<strong style="color:red">' . (( $total / 56) * 100) . '%'
                                        . '</strong>';

//                       return '<strong style="color:red">'.(( $c->p_komen  / 8) * 100).'%'
//                                    .'</strong>';
                            } else {
                                return '-';
                            }
                        }
                            ],
                            [
                                'label' => 'SUPERVISOR COMMENT',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($list) {
                            if ($list->status_r == "DONE") {
                                return $list->p_comment;
                            } else {
                                return '-';
                            }
                        }
                            ],
                        ];
                        ?>
                        <div class="row">
                            <div class="col-md-12 col-xs-12"> 
                                <div class="x_panel" id="rcorners2">
                                    <!--         <div class="x_title">
                                              <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
                                             </div>-->
                                    <div class="x_title">
                                        <h5><strong>LAPORAN KEMAJUAN PENGAJIAN (LKP)</strong></h5>

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">

                                        <?php
                                        echo Html::a(Yii::t('app', '<i class="fa fa-address-card"></i> <span class="label label-info">REKOD KESELURUHAN</span>'), ['cbadmin/search-lkk'], ['class' => 'btn btn-default btn-lg']);
                                        echo Html::a(Yii::t('app', '<i class="fa fa-calendar"></i> <span class="label label-info">LKP BULANAN</span>'), ['cbadmin/lkk-report'], ['class' => 'btn btn-default btn-lg']);
                                        echo Html::a(Yii::t('app', '<i class="fa fa-bar-chart"></i> <span class="label label-success">SEMAKAN LKP</span>'), ['lkk/senaraisemakan'], ['class' => 'btn btn-default btn-lg']);
                                        echo Html::a(Yii::t('app', '<i class="fa fa-book"></i> <span class="label label-info">LAPORAN AKHIR</span>'), ['lkk/laporan-akhir'], ['class' => 'btn btn-default btn-lg']);
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12"> 

                                <div class="x_panel">
                                    <div class="x_content">
                                        <?php
                                        $forms = ActiveForm::begin([
                                                    'action' => [''],
                                                    'method' => 'get',
                                                    'options' => [
                                                        'data-pjax' => 1
                                                    ],
                                        ]);
                                        ?>
                                        <div class="form-group">
                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                <?=
                                                DatePicker::widget([
                                                    'name' => 'my',
                                                    'value' => $my,
                                                    'type' => DatePicker::TYPE_INPUT,
                                                    'options' => ['placeholder' => 'Tahun', 'autocomplete' => 'off'
                                                    ],
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'format' => 'yyyy-mm',
                                                        //                        'viewMode' => "years", 
                                                        'minViewMode' => "months"
                                                    ]
                                                ]);
                                                ?>
                                            </div>
                                        </div>

                                        <!--                <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
                                                 
                                                            <?//php
                                                            $form->field($model, 'jabatan_semasa')->label(false)->widget(Select2::classname(), [
                                                                'data' => ArrayHelper::map(app\models\hronline\Department::find()->all(), 'id', 'shortname'),
                                                                'options' => ['placeholder' => 'Jabatan', 'class' => 'form-control col-md-4 col-xs-12'],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true
                                                                ],
                                                            ]);
                                                            ?>
                                                 
                                                    </div>
                                        -->

                                        <div class="form-group">
                                            <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
                                        </div>


                                        <?php ActiveForm::end(); ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($title == 'Senarai Menunggu Semakan') { ?>
                            <div class="x_panel">
                                <div class="row"> 

                                    <div class="col-md-12 col-xs-12"> 
                                        <div class="x_title">
                                            <h5><strong><i class="fa fa-check-circle fa-lg" style="color:green"></i> SENARAI KAKITANGAN YANG MENGHANTAR LKP</strong></h5>
                                            <p align ="left">  <?=
                                                ExportMenu::widget([
                                                    'dataProvider' => $senarai,
                                                    'columns' => $gridColumns,
                                                    'filename' => 'LAPORAN PENGHANTARAN LKP' . ' ' . $my,
                                                    'clearBuffers' => true,
                                                    'stream' => false,
                                                    'folder' => '@app/web/files/cb/.',
                                                    'linkPath' => '/files/cb/',
                                                    'batchSize' => 10,
                                                ]);
                                                ?></p>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div class="table-responsive">
                                                <?=
                                                GridView::widget([
                                                    'pager' => [
                                                        'firstPageLabel' => 'First',
                                                        'lastPageLabel' => 'Last'
                                                    ],
                                                    'dataProvider' => $senarai,
                                                    'filterModel' => true,
//        'summary' => '',
                                                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                                                    'options' => [
                                                        'class' => 'table-responsive',
                                                    ],
                                                    'columns' => [
//            ['class' => 'kartik\grid\SerialColumn',
//            'header' => 'No',
//            'vAlign' => 'middle',
//            'hAlign' => 'center',
//            ],
                                                        ['class' => 'kartik\grid\SerialColumn',
                                                            'header' => 'BIL',
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'vAlign' => 'middle',
                                                            'hAlign' => 'center',
                                                        ],
//            [
//                'label' => 'EMEL PENYELIA',
//                'format' => 'raw',
////                'headerOptions' => ['class'=>'text-center'],
////                                'contentOptions' => ['class'=>'text-center'],
//                        'value' => function($model) {                                        
//                                 return '<small>'.  strtolower($model->pengajian->emel_penyelia).'</small>';
//                                
// },
//            ],
                                                        [
                                                            'label' => 'TARIKH AKHIR PENGHANTARAN',
                                                            'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
                                                            'value' => function($model) {
                                                                return '<small>' . strtoupper($model->datehantar) . '</small>' .
                                                                        '<br><small style="color:green">Updated:' . $model->tarikh_hantar . '</small>';
                                                            },
                                                        ],
                                                        [
                                                            'label' => 'SEMESTER/SESI',
                                                            'format' => 'raw',
                                                            'headerOptions' => ['class' => 'text-center'],
//                 'contentOptions' => ['class'=>'text-center'],
                                                            'value' => function ($list) {
                                                        return
                                                                '<small><strong>' . strtoupper($list->pengajian->tahapPendidikan) . '</small></strong>'
                                                                . '<small>: ' . strtoupper($list->semester . ' / ' . $list->session) . '</small>';
                                                    }
                                                        ],
                                                        [
                                                            //'attribute' => 'CONm',
                                                            'label' => 'NAMA',
                                                            'headerOptions' => ['class' => 'column-title'],
                                                            'filter' => Select2::widget([
                                                                'name' => 'icno',
                                                                'value' => isset(Yii::$app->request->queryParams['icno']) ? Yii::$app->request->queryParams['icno'] : '',
                                                                'data' => ArrayHelper::map(\app\models\cbelajar\TblLkk::find()->all(), 'icno', 'kakitangan.CONm'),
                                                                'options' => ['placeholder' => ''],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true
                                                                ],
                                                            ]),
                                                            'value' => function($model) {
                                                        $ICNO = $model->icno;
                                                        return Html::a('<strong>' . $model->kakitangan->CONm . '</strong>') . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                                                                '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred;
                                                    },
                                                            'format' => 'html',
                                                        ],
//                                    [
//                'label' => 'TARIKH HANTAR',
//                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//                        'value' => function($model) {                                         
//                                 if($model->agree == 1)
//                                 {
//                                     return '<i class="fa fa-check-circle fa-xs" style="color:green"></i> ' . $model->tarikh_mohon;
//                                 }
//                                 else
//                                 {
//                                     return '<i class="fa fa-exclamation-triangle fa-xs" style="color:red"></i> '. "Not Verify Yet";
//                                 }
// },
//            ],
                                                        [
                                                            'header' => 'TARIKH HANTAR',
                                                            'attribute' => 'agree',
                                                            'format' => 'raw',
                                                            'vAlign' => 'middle',
                                                            'hAlign' => 'center',
                                                            'filter' => Select2::widget([
                                                                'name' => 'agree',
                                                                'value' => $agree,
                                                                'data' => ['1' => '<span class="label label-warning">VERIFIED</span>',
                                                                    '2' => '<span class="label label-success">NOT YET</span>',
                                                                ],
                                                                'options' => ['placeholder' => ''],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                                ],
                                                            ]),
                                                            'value' => function($model) {
                                                        $url = Url::to(['notifistaf', 'id' => $model->reportID]);

                                                        if ($model->agree == 1) {
                                                            return '<i class="fa fa-check-circle fa-xs" style="color:green"></i> ' . $model->tarikh_mohon;
                                                        }if ($model->agree == 2) {

                                                            return '<i class="fa fa-exclamation-triangle fa-xs" style="color:red"></i> ' . "Not Verify Yet" . '<br>' .
                                                                    Html::a('<i class="fa fa-bell" aria-hidden="true"></i>', [
                                                                        'notifistaf',
//                                        'icno' =>$model->icno,
                                                                        'id' => $model->reportID,
                                                                            ], [
                                                                        'class' => 'btn btn-default', 'title' => 'Notifi Staf'
//                                        'target' => '_blank',
                                                            ]);
//                                     return '<i class="fa fa-exclamation-triangle fa-xs" style="color:red"></i> '. "Not Verify Yet".
//                                         '<br>'. Html::a('<i class="fa fa-bell fa-lg " style="color:midnightblue aria-hidden="true""></i>', $url, ['title' => 'Notifi SV'],['class' => 'btn btn-primary btn-xs']); 
                                                        }
//                                 {
//                                     return '<i class="fa fa-exclamation-triangle fa-xs" style="color:red"></i> '. "Not Verify Yet".
//                                         '<br>'. Html::a('<i class="fa fa-bell fa-lg " style="color:midnightblue"></i>', $url, ['title' => 'Notifi']); ;
//                                 }
                                                    },
                                                        ],
                                                        [
                                                            'header' => 'STATUS PENYELIA',
                                                            'attribute' => 'statuspenyelia',
                                                            'format' => 'raw',
                                                            'vAlign' => 'middle',
                                                            'hAlign' => 'center',
                                                            'filter' => Select2::widget([
                                                                'name' => 'statuspenyelia',
                                                                'value' => $statuspenyelia,
                                                                'data' => ['DONE' => '<span class="label label-warning">CHECKED</span>',
                                                                    'BYPASS' => '<span class="label label-info">BYPASS</span>',
                                                                    'NOT YET' => '<span class="label label-success">NOT YET</span>',
                                                                ],
                                                                'options' => ['placeholder' => ''],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                                ],
                                                            ]),
                                                            'value' => function($model) {
                                                        $url = Url::to(['notifisv', 'id' => $model->reportID]);

                                                        if ($model->status_r == "DONE") {
                                                            return $model->statuspenyelia . '<br>' . $model->r_dt;
                                                        } elseif ($model->status_r == "BYPASS" && $model->agree = 1) {
                                                            return $model->statuspenyelia . '<br>' . $model->r_dt;
                                                        } elseif ($model->status_r == "NOT YET" && $model->agree = 1) {

                                                            return '<i class="fa fa-exclamation-triangle fa-xs" style="color:red"></i> ' . "Not Verify Yet" . '<br>' .
                                                                    Html::a('<i class="fa fa-bell" aria-hidden="true"></i>', [
                                                                        'notifisv',
//                                        'icno' =>$model->icno,
                                                                        'id' => $model->reportID,
                                                                            ], [
                                                                        'class' => 'btn btn-default', 'title' => 'Notifi SV'
//                                        'target' => '_blank',
                                                            ]);
//                                     return '<i class="fa fa-exclamation-triangle fa-xs" style="color:red"></i> '. "Not Verify Yet".
//                                         '<br>'. Html::a('<i class="fa fa-bell fa-lg " style="color:midnightblue aria-hidden="true""></i>', $url, ['title' => 'Notifi SV'],['class' => 'btn btn-primary btn-xs']); 
                                                        } else {
                                                            return '-';
                                                        }
                                                    },
//                     'value'=>function ($list) 
//                {
//                                return $list->statuspenyelia.'<br>'.$list->r_dt;
//                }
                                                        ],
//            [
//                'label' => ' STATUS PENYELIA',
//                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//                'value'=>function ($list) 
//                {
//                                return $list->statuspenyelia.'<br>'.$list->r_dt;
//                }
//            ],
                                                        [
                                                            'header' => 'STATUS DEKAN',
                                                            'attribute' => 'statusjfpiu',
                                                            'format' => 'raw',
                                                            'vAlign' => 'middle',
                                                            'hAlign' => 'center',
                                                            'filter' => Select2::widget([
                                                                'name' => 'statusjfpiu',
                                                                'value' => $statusjfpiu,
                                                                'data' => ['Tunggu Perakuan' => '<span class="label label-warning">MENUNGGU SEMAKAN</span>',
                                                                    'Diperakukan' => '<span class="label label-success">DISAHKAN</span>',
                                                                    'Tidak Diperakukan' => '<span class="label label-danger">DITOLAK</span>'
                                                                ],
                                                                'options' => ['placeholder' => ''],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                                ],
                                                            ]),
                                                            'value' => function ($list) {
                                                        if ($list->status_r == "DONE" && $list->status_jfpiu == "Tunggu Perakuan") {
                                                            return $list->statusjfpiu . '<br>' . $list->verify_dt;
                                                        } elseif (($list->status_r == "DONE" && $list->status_jfpiu == "Diperakukan") || ($list->status_r == "BYPASS" && $list->status_jfpiu == "Diperakukan")) {
                                                            return $list->statusjfpiu . '<br>' . $list->verify_dt;
                                                        } elseif ($list->status_r == "DONE" && $list->status_jfpiu == "Tidak Diperakukan") {
                                                            return $list->statusjfpiu . '<br>' . $list->verify_dt;
                                                        } else {
                                                            return '-';
                                                        }
                                                    }
                                                        ],
//           [
//                'label' => 'STATUS DEKAN',
//                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//                'value'=>function ($list) 
//                {
//                if($list->status_r == "DONE")
//                {
//                                return $list->statusjfpiu.'<br>'.$list->verify_dt;
//                }
//                else
//                {
//                    return '-';
//                }
//                }
//            ],
                                                        [
                                                            'label' => 'STATUS BSM',
                                                            'format' => 'raw',
                                                            'headerOptions' => ['class' => 'text-center'],
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'filter' => Select2::widget([
                                                                'name' => 'statusbsm',
                                                                'value' => $statusbsm,
                                                                'data' => ['Tunggu Kelulusan' => '<span class="label label-warning">MENUNGGU SEMAKAN</span>',
                                                                    'Diperakukan' => '<span class="label label-success">DISEMAK</span>',
                                                                ],
                                                                'options' => ['placeholder' => ''],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                                ],
                                                            ]),
                                                            'value' => function ($list) {
                                                        if ($list->verify_dt) {
                                                            return $list->statusbsm . '<br>' . $list->ver_date;
                                                        } else {
                                                            return '-';
                                                        }
                                                    }
                                                        ],
                                                        [
                                                            'label' => 'OVERALL PERFORMANCE',
                                                            'format' => 'raw',
                                                            'headerOptions' => ['class' => 'text-center'],
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'value' => function ($list) {

                                                        $c = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 5])->one();
                                                        $b = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 7])->one();
                                                        $a = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 6])->one();
                                                        $d = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 4])->one();
                                                        $e = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 3])->one();
                                                        $f = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 2])->one();
                                                        $g = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID, 'idKriteria' => 1])->one();

                                                        if ($list->status_r == "DONE") {
                                                            $total = 0;
                                                            $total = ($a->p_komen + $b->p_komen + $c->p_komen + $d->p_komen + $e->p_komen + $f->p_komen + $g->p_komen);
                                                            return '<strong style="color:red">' . round(( $total / 56) * 100) . '%'
                                                                    . '</strong>';

//                       return '<strong style="color:red">'.(( $c->p_komen  / 8) * 100).'%'
//                                    .'</strong>';
                                                        } else {
                                                            return '-';
                                                        }
                                                    }
                                                        ],
                                                        [
                                                            'header' => 'LKP',
                                                            'headerOptions' => ['class' => 'text-center'],
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'class' => 'yii\grid\ActionColumn',
                                                            'template' => '{mohon}',
                                                            'buttons' => [
                                                                'mohon' => function($url, $model) {

                                                                    $ICNO = $model->icno;
                                                                    $url = Url::to(['lkk/pengesahan-admin', 'id' => $model->reportID, 'icno' => $ICNO]);
                                                                    $urls = Url::to(['lkk/pengesahan-admin-ir', 'id' => $model->reportID, 'icno' => $ICNO]);
                                                                    if ($model->HighestEduLevelCd == 210) {
                                                                        return
                                                                                Html::a('<i class="fa fa-bar-chart fa-xs"></i>', $urls, ['title' => 'Lihat LKP']);
                                                                    } else {
                                                                        return
                                                                                Html::a('<i class="fa fa-bar-chart fa-xs"></i>', $url, ['title' => 'Lihat LKP']);
                                                                    }
                                                                },
                                                                    ],
                                                                ],
                                                                [
                                                                    'class' => 'yii\grid\ActionColumn',
                                                                    //'attribute' => 'CONm',
                                                                    'header' => 'KEMASKINI BORANG',
                                                                    'headerOptions' => ['class' => 'text-center'],
                                                                    'contentOptions' => ['class' => 'text-center'],
                                                                    'template' => '{kemaskini}',
                                                                    //'header' => 'TINDAKAN',
                                                                    'buttons' => [
                                                                        'kemaskini' => function ($url, $model) {
                                                                            $url = Url::to(['kemaskini-borang', 'id' => $model->reportID]);
                                                                            return Html::a('<i class="fa fa-edit fa-xs"></i>', $url, ['title' => 'Lihat Laporan']);
                                                                        },
                                                                            ],
                                                                        ],
                                                                        [
                                                                            'class' => 'yii\grid\ActionColumn',
                                                                            //'attribute' => 'CONm',
                                                                            'header' => ' BORANG',
                                                                            'headerOptions' => ['class' => 'text-center'],
                                                                            'contentOptions' => ['class' => 'text-center'],
                                                                            'template' => '{update}',
                                                                            //'header' => 'TINDAKAN',
                                                                            'buttons' => [
                                                                                'update' => function ($url, $model) {
                                                                                
                                                                            if($model->HighestEduLevelCd == 210)
                                                                            {
                                                                              return Html::a('<i class="fa fa-print" aria-hidden="true"></i>', [
                                                                                                    'print-report-ir',
                                                                                                    'id' => $model->reportID,
                                                                                                        ], [
                                                                                                    'class' => 'btn btn-default',
                                                                                                    'target' => '_blank',
                                                                                        ]);
                                                                                    }  
                                                                           
                                                                                    elseif ($model->status_bsm == "Diperakukan") {
                                                                                        return Html::a('<i class="fa fa-print" aria-hidden="true"></i>', [
                                                                                                    'print-report',
                                                                                                    'id' => $model->reportID,
                                                                                                        ], [
                                                                                                    'class' => 'btn btn-default',
                                                                                                    'target' => '_blank',
                                                                                        ]);
                                                                                    } else {
                                                                                        $url = Url::to(['buka-borang', 'id' => $model->reportID]);
                                                                                        return Html::button('<i class="fa fa-unlock-alt fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                                                                    }
                                                                                },
                                                                                    ],
                                                                                ],
//                                                                                [
//                                                                                    'class' => 'yii\grid\CheckboxColumn',
//                                                                                    'checkboxOptions' => function ($model) {
//                                                                                        return ['value' => $model->sv->emel];
//                                                                                    }
//                                                                                        ],
////                                        [
//                            'class' => 'yii\grid\ActionColumn',
//                           //'attribute' => 'CONm',
//                            'header' => 'NOTIFI',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'template' => '{kemaskini}',
//                            //'header' => 'TINDAKAN',
//                            'buttons' => [
//                                'kemaskini' => function ($url, $model) {
//                                    $url = Url::to(['notifistaf', 'id' => $model->reportID]);
//                                                 return       Html::a('<i class="fa fa-bullhorn fa-lg " style="color:blue"></i>', $url, ['title' => 'Notifi']); 
//                                    
//                                },
//                            ],
//                        ],
//                        [
//                            'class' => 'yii\grid\ActionColumn',
//                           //'attribute' => 'CONm',
//                            'header' => 'NOTIFY',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'template' => '{update}',
//                            //'header' => 'TINDAKAN',
//                            'buttons' => [
//                                'update' => function ($url, $model) {
//                                    $url = Url::to(['notifi-staf', 'id' => $model->reportID]);
//                                    return Html::a('<i class="fa fa-bullhorn fa-xs"></i>', ['value' => $url]);
//                                    
//                                },
//                            ],
//                        ],
//                                                        [
//                                            'header' => 'BUKA BORANG',
//                                            'headerOptions' => ['class'=>'text-center'],
//                                                   'contentOptions' => ['class'=>'text-center'],
//
//                                            'class' => 'yii\grid\ActionColumn',
//                                            'template' => '{mohon}',
//                                            'buttons' => [
//                                                'mohon' => function($url, $model) 
//                                                {
//                                                        $ICNO = $model->icno;
//                                                        $url = Url::to(['lkk/buka-borang', 'id'=>$model->reportID]);
//                                                       return 
//                                                        Html::a('<i class="fa fa-unlock-alt fa-xs"></i>', $url, ['title' => 'Lihat Laporan']); 
//                                                    
//                                                },
//                                                        
//                                                
//                                                
//                                        ],
//                                                        ],
//            [
//                'label' => 'LKP',
//                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//                'value'=>function ($list) use ($iklan){
//                            if($list->status_jfpiu === 'Tunggu Kelulusan'){
//                        return  
//                        Html::a('<i class="fa fa-bar-chart">', ["tindakankj",  'i' => $list->reportID]);
//                            }
//                            else{
//                        return Html::a('<i class="fa fa-bar-chart">', ["tindakan-kj", 'i'=>$list->reportID ]);
//                            }
//                        
//                      },
//            ],
//           [
//                'label' => 'COMPLETED BY DEAN/DIRECTOR',
//                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//                'value'=>function ($list) use ($iklan){
//                            if($list->status_jfpiu === 'Tunggu Kelulusan'){
//                        return  
//                        Html::a('<i class="fa fa-edit">', ["tindakankj",  'i' => $list->reportID]);
//                            }
//                            elseif ($list->pengajian->HighestEduLevelCd == 1){
//                        return Html::a('<i class="fa fa-edit">', ["kj-achievement-phd?i=".$list->reportID.'&id='.$list->icno ]);
//                            }
//                            else
//                            {
//                            return Html::a('<i class="fa fa-edit">', ["kj-achievement-master?i=".$list->reportID.'&id='.$list->icno ]);
// 
//                            }
//                        
//                      },
//            ],
                                                                                    ],
                                                                                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                                                                                    'resizableColumns' => false,
                                                                                    'responsive' => false,
                                                                                    'responsiveWrap' => false,
                                                                                    'hover' => true,
                                                                                    'floatHeader' => true,
                                                                                    'floatHeaderOptions' => [
                                                                                        'position' => 'absolute',
                                                                                    ],
                                                                                ]);
                                                                                ?>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div></div>   <?php } ?>
 