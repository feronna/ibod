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
?>
<?= $this->render('/cutibelajar/_topmenu') ?>
<!-- $this->render('/lkk/menu_jumlah')-->
<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<?php
$gridColumns = [

    ['class' => 'yii\grid\SerialColumn',
        'header' => 'BIL',],
//[   
//                            
//                            'label' => 'TARIKH AKHIR HANTAR LKP',
//                            'value' => function ($data){
//                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
//                                return strtoupper ($data->dt)
//                                  ;
//                            },
//                            'format' => 'raw'
//                            
//                        ],   
//                        [
//                'label' => 'SEMESTER/SESI',
//                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
////                 'contentOptions' => ['class'=>'text-center'],
//                 'value'=>function ($list)
//                            {
//                                return
//                    '<small>: '.strtoupper($list->semester. ' / '. $list->session).'</small>';
//                 }
//                 
//                 
//            ],
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
            return Html::a(strtoupper($data->InstNm));
        },
        'format' => 'raw'
    ],
    [

        'label' => 'PERINGKAT PENGAJIAN',
        'value' => function ($data) {
            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
            return strtoupper($data->tahapPendidikan);
        },
        'format' => 'raw'
    ],
    [

        'label' => 'NEGARA',
        'value' => function ($data) {
            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
            return strtoupper($data->negara->Country);
        },
        'format' => 'raw'
    ],
    [

        'label' => 'BIDANG',
        'value' => function ($data) {
            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));

            if (($data->MajorCd == NULL) && ($data->MajorMinor != NULL)) {
                return strtoupper($data->MajorMinor);
            } elseif (($data->MajorCd != NULL) && ($data->MajorMinor != NULL)) {
                return strtoupper($data->MajorMinor);
            } else {
                return strtoupper($data->major->MajorMinor);
            }
        },
        'format' => 'raw'
    ],
    [

        'label' => 'TARIKH PENGAJIAN',
        'value' => function ($data) {
            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
            return strtoupper($data->tarikhmula) . ' HINGGA ' . strtoupper($data->tarikhtamat);
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

            return strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno' => $data->icno, 'idLanjutan' => 1,'HighestEduLevelCd'=>$data->HighestEduLevelCd])->one()->stlanjutan)
                    . ' HINGGA ' . strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno' => $data->icno, 'idLanjutan' => 1,'HighestEduLevelCd'=>$data->HighestEduLevelCd])->one()->ndlanjutan);



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

                    return strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno' => $data->icno, 'idLanjutan' => 2,'HighestEduLevelCd'=>$data->HighestEduLevelCd])->one()->stlanjutan)
                            . ' HINGGA ' . strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno' => $data->icno, 'idLanjutan' => 2,'HighestEduLevelCd'=>$data->HighestEduLevelCd])->one()->ndlanjutan);



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

                            return strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno' => $data->icno, 'idLanjutan' => 3,'HighestEduLevelCd'=>$data->HighestEduLevelCd])->one()->stlanjutan)
                                    . ' HINGGA ' . strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno' => $data->icno, 'idLanjutan' => 3,'HighestEduLevelCd'=>$data->HighestEduLevelCd])->one()->ndlanjutan);


                            //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
//                                return  $data->tajaan->penajaan->penajaan.' - '.strtoupper($data->tajaan->nama_tajaan);
                        },
                                'format' => 'raw'
                            ],
                        ];
                        ?>



                        <p align="right"><?= Html::a('Kembali', ['lkk/statistik-jabatan'], ['class' => 'btn btn-primary btn-sm'])
                        ?></p>
                        <div class="x_panel">
                            <div class="row"> 

                                <div class="col-md-12 col-xs-12"> 
                                    <div class="x_title">
                                        <h5><strong><i class="fa fa-check-circle fa-lg" style="color:green"></i> SENARAI KAKITANGAN YANG <i>PASS PROPOSAL DEFENSE</i></strong></h5>
                                        <p align ="left">  <?=
                        ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'filename' => '_senarai_pass_pd ' . ' ' . $my,
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
                            'dataProvider' => $dataProvider,
//                         'filterModel' => FALSE,
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
//               
                                [
                                    //'attribute' => 'CONm',
                                    'label' => 'MAKLUMAT PENGAJIAN',
                                    'headerOptions' => ['style' => 'width:30%', 'class' => 'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {

                                return Html::a('<strong><small>' . strtoupper($model->InstNm) . '</small></strong><br>' .
                                                '<small>' . $model->tahapPendidikan . '</small><br>' .
                                                '<small>' . strtoupper($model->tarikhmula) . ' HINGGA</small> ' .
                                                '<small>' . strtoupper($model->tarikhtamat) . '</small> ' .
                                                '<small>(' . strtoupper($model->tempohpengajian) . ')</small><br>');
                            },
                                    'format' => 'html',
                                ],
                                [
                                    //'attribute' => 'CONm',
                                    'label' => 'MAKLUMAT BIASISWA',
                                    'headerOptions' => ['style' => 'width:30%', 'class' => 'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {

                                return Html::a('<strong><small>' . strtoupper($model->tajaan->penajaan->penajaan) .
                                                '</small></strong><br>');
//                                echo $b->tajaan->penajaan->penajaan.' - '. $b->tajaan->nama_tajaan;
                            },
                                    'format' => 'html',
                                ],
                                [
                                    //'attribute' => 'CONm',
                                    'label' => 'PROPOSAL DEFENSE',
                                    'headerOptions' => ['style' => 'width:10%', 'class' => 'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                if ($model->lkp->got->result == 1) {
                                    return '<b style="color:green">YES</b><br>'. '<small>'.$model->lkp->got->created_dt.'</small>';
                                }  else {
                                    return '<small><b>NO RECORD</small></b>';
                                }
//                                return Html::a('<strong><small>' . strtoupper($model->lkk->got->result) . 
//                               '</small></strong><br>');
//                                echo $b->tajaan->penajaan->penajaan.' - '. $b->tajaan->nama_tajaan;
                            },
                                    'format' => 'html',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                ],
                                    [
                        'label'=>'EVIDENCE',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                       'value'=>function ($data)  {
                         if ($data->lkp->got->namafile){
                         return  Html::a('', 
                            (Yii::$app->FileManager->DisplayFile($data->lkp->got->namafile)), 
                            ['style="color: green" class'=>'fa fa-download fa-lg' , 'target' => '_blank',]);}
                        else{
                                    return '<small><b>NO RECORD</small></b>';
                        }
                        
                      },
                               'format' => 'html',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
             ],
                             
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
    </div></div>


