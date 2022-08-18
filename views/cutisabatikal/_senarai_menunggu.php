<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\export\ExportMenu;

error_reporting(0);
?>


    <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>


    <div >
        <div>
            <?php
            $gridColumns = [

                ['class' => 'yii\grid\SerialColumn',
                    'header' => 'BIL',],
                [

                    'label' => 'JENIS PERMOHONAN',
                    'value' => function ($data) {
                        //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                        return Html::a(strtoupper($data->jenis));
                    },
                    'format' => 'raw'
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

                    'label' => 'PERINGKAT PENGAJIAN',
                    'value' => function ($data) {
                        //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                        return Html::a(strtoupper($data->belajar->tahapPendidikan));
                    },
                    'format' => 'raw'
                ],
                [

                    'label' => 'INSTITUT/UNIVERSITI',
                    'value' => function ($data) {
                        //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                        return Html::a(strtoupper($data->belajar->InstNm));
                    },
                    'format' => 'raw'
                ],
                [

                    'label' => 'NEGARA',
                    'value' => function ($data) {
                        //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                        return strtoupper($data->belajar->negara->Country);
                    },
                    'format' => 'raw'
                ],
                [

                    'label' => 'BIDANG',
                    'value' => function ($data) {
                        //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));

                        if (($data->belajar->MajorCd == NULL) && ($data->belajar->MajorMinor != NULL)) {
                            return strtoupper($data->belajar->MajorMinor);
                        } elseif (($data->belajar->MajorCd != NULL) && ($data->belajar->MajorMinor != NULL)) {
                            return strtoupper($data->belajar->MajorMinor);
                        } else {
                            return strtoupper($data->belajar->major->MajorMinor);
                        }
                    },
                    'format' => 'raw'
                ],
                [

                    'label' => 'TARIKH PENGAJIAN',
                    'value' => function ($data) {
                        //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                        return strtoupper($data->belajar->tarikhmula) . ' HINGGA ' . strtoupper($data->belajar->tarikhtamat);
                    },
                    'format' => 'raw'
                ],
                [

                    'label' => 'TEMPOH PENGAJIAN',
                    'value' => function ($data) {
                        //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                        return strtoupper($data->belajar->tempohtajaan);
                    },
                    'format' => 'raw'
                ],
                [

                    'label' => 'TAJAAN',
                    'value' => function ($data) {
                        //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                        return strtoupper($data->tajaan->penajaan->penajaan) . ' -' . strtoupper($data->tajaan->nama_tajaan);
                    },
                    'format' => 'raw'
                ],
                [

                    'label' => 'STATUS SEMAKAN BORANG',
                    'value' => function ($data) {
                        //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                        return strtoupper($data->status_semakan);
                    },
                    'format' => 'raw'
                ],
            ];
            ?>
        </div></div>

    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><b>Permohonan Baharu</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Telah Diluluskan</b></a>
                </li>
                  <li role="presentation" class=""><a href="#tab_content7" role="tab" id="profile-tab7" data-toggle="tab" aria-expanded="false"><b>Terima</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content6" role="tab" id="profile-tab5" data-toggle="tab" aria-expanded="false"><b> Tanpa Pemantauan</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><b>Telah Ditolak</b></a>
                </li>
             
                <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false"><b>Tolak Tawaran</b></a>
                </li>
                   
                <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false"><b>Belum Hantar</b></a>
                </li>
             
                
            </ul>
        </div>

        <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_content1" aria-labelledby="home-tab">
            <?php if ($title == 'Senarai Menunggu Semakan') { ?>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
                    <p align ="text-left">  <?=
                ExportMenu::widget([
                    'dataProvider' => $senarai,
                    'columns' => $gridColumns,
                    'filename' => 'SENARAI PERMOHONAN PENGAJIAN LANJUTAN ' . ' ' . $my,
                    'clearBuffers' => true,
                    'stream' => false,
                    'folder' => '@app/web/files/cb/.',
                    'linkPath' => '/files/cb/',
                    'batchSize' => 10,
                ]);
                ?></p>
                    <div class="row"> 
                        <div class="col-xs-12 col-md-12 col-lg-12"> 

                            <div class="x_content">

                                <div class="table-responsive">
    <?=
    GridView::widget([
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last'
        ],
        'dataProvider' => $senarai,
//                         'filterModel' => false,
//        'dataProvider' => $senarai,
//        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
        'options' => [
            'class' => 'table-responsive',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'header' => 'BIL',
            ],
//            [
//                           //'attrib[
//                'label' => 'JENIS PERMOHONAN',
//                'headerOptions' => ['class'=>'text-center'],
//                'contentOptions' => ['class'=>'text-center'], 
//                'value'=>function ($model) {
//                    return $model->jenis;
//                },
//              
////                        'visible' => $role,
////                'vAlign' => 'middle',
////                'hAlign' => 'center',
//            ],
            [
                //'attrib[
                'label' => 'KATEGORI',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
            return $model->kakitangan->jawatan->job_category == 1 ? 'AKADEMIK' : 'PENTADBIRAN';
        },
//                        'visible' => $role,
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
            ],
            [
                //'attribute' => 'CONm',
                'label' => 'NAMA PEMOHON ',
                'headerOptions' => ['class' => 'column-title'],
//                               'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPermohonan::find()->all(), 'icno', 'kakitangan.CONm'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                'value' => function($model) {
            $ICNO = $model->icno;
            $id = $model->id;

              if ($model->jenis == "SEPENUH MASA") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/sepenuh-masa/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
//            if ($model->jenis == "SEPARUH MASA") {
//
//
//                $ICNO = $model->icno;
//                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/cutisabatikal/adminviewsm', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
//                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
//            }
             if ($model->jenis == "ADMIN") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/pentadbiran/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->jenis == "WARTA") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/pra-warta/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->jenis == "SUB PAKAR") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/sub-kepakaran/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
              if ($model->jenis == "PENYELIDIKAN") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/cuti-penyelidikan/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
            if ($model->idBorang == "51") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/latihan-pensijilan/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
            if ($model->idBorang == 2) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/sabatikal/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->idBorang == 38) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/separuh-masa/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->idBorang == 39) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/latihan-industri/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->idBorang == 40) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/sangkutan/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
            if ($model->idBorang == 42) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/pos-doktoral/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->idBorang == 44) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/cuti-penyelidikan/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->idBorang == 51) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/latihan-pensijilan/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }else {
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/cutisabatikal/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
        },
                'format' => 'html',
            ],
//            [
//                           //'attribute' => 'CONm',
//                            'label' => 'NAMA PEMOHON',
//                             'options' => ['style' => 'width:50%'],
//                            'headerOptions' => ['class'=>'column-title'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
//                                
//                                 if($model->jenis == "SEPARUH MASA"){
//                          
//                           
//                        $ICNO = $model->icno;
//                        return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ['/cutisabatikal/adminviewsm', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id'=>$model->iklan_id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
//                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon: '. $model->tarikhmohon;
//                        }
//                        else
//                        {
//                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ['/cutisabatikal/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id'=>$model->iklan_id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
//                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon: '. $model->tarikhmohon;
//                        }
//                        }, 
//                                    'format' => 'html',
//
//                        ],
            [
                                                            //'attribute' => 'CONm',
                                                            'label' => 'PERINGKAT PENGAJIAN',
                                                            'headerOptions' => ['class' => 'text-center'],
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'value' => function($model) {
                                                                                                                $ICNO = $model->icno;

                                                        if($model->jenis == "PENYELIDIKAN")
                                                        {
                                                            return '<strong><small>LATIHAN PENYELIDIKAN</small></strong>';
                                                        }
                                                         elseif($model->jenis == "PENSIJILAN")
                                                        {
                                                            return '<strong><small>LATIHAN PENSIJILAN PROFESIONAL</small></strong>';
                                                        }
 else {
                                                        
                                                        return Html::a('<strong>' . strtoupper($model->s->tahapPendidikan) . '</strong>');
 }     },
                                                            'format' => 'html',
                                                        ],
            [
                'label' => 'STATUS  KETUA JABATAN/DEKAN',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($data) {

            if ($data->status_jfpiu == 'Diperakukan' || $data->status_jfpiu == 'Tidak Diperakukan') {
                return $data->statusjfpiu . '<br> ' . $data->app_date;
            } else {
                return $data->statusjfpiu;
            }
        },
            ],
            [
                'label' => 'SEMAKAN URUSETIA',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($nilai) {

            if ($nilai->terima == NULL && $nilai->belajar->userID == 2) {


                $ICNO = $nilai->icno;
                return Html::a('<i class="fa fa-list fa-lg">', ["/cutibelajar/semakan-syarat-admin", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id' => $nilai->iklan_id]);
            }
            if ($nilai->terima == NULL && $nilai->idBorang == 38) {


                $ICNO = $nilai->icno;
                return Html::a('<i class="fa fa-list fa-lg">', ["/separuh-masa/semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id' => $nilai->iklan_id]);
            }
            if ($nilai->terima == NULL && $nilai->jenis == "SEPENUH MASA") {


                $ICNO = $nilai->icno;
                return Html::a('<i class="fa fa-list fa-lg">', ["/sepenuh-masa/semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id' => $nilai->iklan_id]);
            }
             if ($nilai->terima == NULL && $nilai->idBorang == 39) {


                $ICNO = $nilai->icno;
                return Html::a('<i class="fa fa-list fa-lg">', ["/latihan-industri/semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id' => $nilai->iklan_id]);
            }
             if ($nilai->terima == NULL && $nilai->idBorang == 32) {


                $ICNO = $nilai->icno;
                return Html::a('<i class="fa fa-list fa-lg">', ["/pentadbiran/semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id' => $nilai->iklan_id]);
            }
             if ($nilai->terima == NULL && $nilai->idBorang == 40) {


                $ICNO = $nilai->icno;
                return Html::a('<i class="fa fa-list fa-lg">', ["/sangkutan/semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id' => $nilai->iklan_id]);
            }
             if ($nilai->terima == NULL && $nilai->idBorang == 41) {


                $ICNO = $nilai->icno;
                return Html::a('<i class="fa fa-list fa-lg">', ["/pra-warta/semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id' => $nilai->iklan_id]);
            }
             if ($nilai->terima == NULL && $nilai->idBorang == 42) {


                $ICNO = $nilai->icno;
                return Html::a('<i class="fa fa-list fa-lg">', ["/pos-doktoral/semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id' => $nilai->iklan_id]);
            }
             if ($nilai->terima == NULL && $nilai->idBorang == 43) {


                $ICNO = $nilai->icno;
                return Html::a('<i class="fa fa-list fa-lg">', ["/sub-kepakaran/semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id' => $nilai->iklan_id]);
            }
             if ($nilai->terima == NULL && $nilai->idBorang == 44) {


                $ICNO = $nilai->icno;
                return Html::a('<i class="fa fa-list fa-lg">', ["/cuti-penyelidikan/semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id' => $nilai->iklan_id]);
            }
             if ($nilai->terima == NULL && $nilai->idBorang == 51) {


                $ICNO = $nilai->icno;
                return Html::a('<i class="fa fa-list fa-lg">', ["/latihan-pensijilan/semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id' => $nilai->iklan_id]);
            }
            if ($nilai->terima == NULL && $nilai->idBorang == 2) {


                $ICNO = $nilai->icno;
                return Html::a('<i class="fa fa-list fa-lg">', ["/sabatikal/semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id' => $nilai->iklan_id]);
            } elseif ($nilai->terima != NULL && $nilai->jenis == "SEPARUH MASA") {
                return Html::a('<i class="fa fa-check fa-lg">', ["/cbelajar/view-semakan-syarat-separuh-masa", 'id' => $nilai->id, 'ICNO' => $ICNO]) | Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
            } else {
                return Html::a('<i class="fa fa-check fa-lg">', ["/cbelajar/view-semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO]) | Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
            }
        },
            ],
            [
//                     'attribute' => 'status_jfpiu',
                'label' => 'SEMAKAN PERMOHONAN',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => 'statussemakan',
                'format' => 'raw',
            ],
            [
                'label' => 'RINGKASAN KEPUTUSAN',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($data) {

            if ($data->terima == NULL) {
                $ICNO = $data->icno;

                return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cutibelajar/tindakan_bsm', 'id' => $data->id]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);
            }
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
            else {
                return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]) | Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
            }
        },
            ],
            [
                'label' => 'SALINAN SURAT TAWARAN',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($data) {
            if ($data->checkUpload($data->id)) {
                return Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class' => 'fa fa-check-square-o fa-lg', 'target' => '_blank']);
            } else {
                return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsurat', 'id' => $data->id]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
            }
        },
            ],
            [
                'label' => 'PEMAKLUMAN KEPUTUSAN',
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
            return Html::a('<input type="radio" name="' . $data->id . '" value="y' . $data->id . '" ' . $checked . '><i class="fa fa-check"></i>') . '  ' . Html::a('<input type="radio" name="' . $data->id . '" value="n' . $data->id . '" ' . $checked1 . '><i class="fa fa-remove"></i>');
        },
            ],
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($data) {
                    if (($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan')) {
                        return ['disabled' => 'disabled'];
                    }
                    return ['value' => $data->id, 'checked' => true];
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
                            </div></div><?php } ?>
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
                                                'label' => 'NAMA PEMOHON ',
                                                'headerOptions' => ['style' => 'width:20%', 'class' => 'text-left'],
//                               'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPermohonan::find()->all(), 'icno', 'kakitangan.CONm'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                                                'value' => function($model) {
                                            $ICNO = $model->icno;
                                            $id = $model->id;

                                              if ($model->jenis == "SEPENUH MASA") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/sepenuh-masa/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
//            if ($model->jenis == "SEPARUH MASA") {
//
//
//                $ICNO = $model->icno;
//                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/cutisabatikal/adminviewsm', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
//                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
//            }
             if ($model->jenis == "ADMIN") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/pentadbiran/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->jenis == "WARTA") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/pra-warta/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->jenis == "SUB PAKAR") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/sub-kepakaran/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
            if ($model->idBorang == 2) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/sabatikal/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->idBorang == 38) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/separuh-masa/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->idBorang == 39) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/latihan-industri/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->idBorang == 40) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/sangkutan/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
            if ($model->idBorang == 42) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/pos-doktoral/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }else {
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/pentadbiran/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
                                        },
                                                'format' => 'html',
                                            ],
                                            [
                                                //'attribute' => 'CONm',
                                                'label' => 'MAKLUMAT PENGAJIAN',
                                                'headerOptions' => ['style' => 'width:20%', 'class' => 'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                                                'value' => function($model) {
                                            $ICNO = $model->icno;
                                            return Html::a('<strong><small>' . strtoupper($model->s->InstNm) . '</small></strong><br>' .
                                                            '<small>' . $model->s->tahapPendidikan . '</small><br>' .
                                                            '<small>' . strtoupper($model->s->tarikhmula) . ' HINGGA</small> ' .
                                                            '<small>' . strtoupper($model->s->tarikhtamat) . '</small> ' .
                                                            '<small>(' . strtoupper($model->s->tempohtajaan) . ')</small><br>');
                                        },
                                                'format' => 'html',
                                            ],
                                        ];



                                        echo GridView::widget([
                                            'dataProvider' => $tolak,
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
                                                'heading' => '<h6><i class="fa fa-times fa-lg" style="color:red"></i> Permohonan Yang Ditolak Jawatankuasa Pengajian Lanjutan</h6>',
                                            ],
                                        ]);
                                        ?>
                                    </div>


                                </div>
                            </div>  

                        </div>  
                    </div>        
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
                                                'label' => 'NAMA PEMOHON ',
                                                'headerOptions' => ['style' => 'width:20%', 'class' => 'text-left'],
//                               'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPermohonan::find()->all(), 'icno', 'kakitangan.CONm'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                                                'value' => function($model) {
                                            $ICNO = $model->icno;
                                            $id = $model->id;

                                              if ($model->jenis == "SEPENUH MASA") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/sepenuh-masa/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
//            if ($model->jenis == "SEPARUH MASA") {
//
//
//                $ICNO = $model->icno;
//                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/cutisabatikal/adminviewsm', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
//                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
//            }
             if ($model->jenis == "ADMIN") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/pentadbiran/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->jenis == "WARTA") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/pra-warta/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->jenis == "SUB PAKAR") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/sub-kepakaran/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
              if ($model->jenis == "PENYELIDIKAN") {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/cuti-penyelidikan/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
            if ($model->idBorang == 2) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/sabatikal/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->idBorang == 38) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/separuh-masa/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->idBorang == 39) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/latihan-industri/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
             if ($model->idBorang == 40) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/sangkutan/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
            if ($model->idBorang == 42) {


                $ICNO = $model->icno;
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/pos-doktoral/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }else {
                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/pentadbiran/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
            }
                                        },
                                                'format' => 'html',
                                            ],
//                                            [
//                                                //'attribute' => 'CONm',
//                                                'label' => 'MAKLUMAT PENGAJIAN',
//                                                'headerOptions' => ['style' => 'width:20%', 'class' => 'text-left'],
////                            'contentOptions' => ['class'=>'text-center'],
//                                                'value' => function($model) {
//                                            $ICNO = $model->icno;
//                                            return Html::a('<strong><small>' . strtoupper($model->s->InstNm) . '</small></strong><br>' .
//                                                            '<small>' . $model->s->tahapPendidikan . '</small><br>' .
//                                                            '<small>' . strtoupper($model->s->tarikhmula) . ' HINGGA</small> ' .
//                                                            '<small>' . strtoupper($model->s->tarikhtamat) . '</small> ' .
//                                                            '<small>(' . strtoupper($model->s->tempohtajaan) . ')</small><br>');
//                                        },
//                                                'format' => 'html',
//                                            ],
                                            [
                                                //'attribute' => 'CONm',
                                                'label' => 'STATUS KEPUTUSAN',
                                                'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                                                'value' => function($model) {
//                                $ICNO = $model->icno;
                                            if ($model->status_bsm == "Diluluskan" || $model->status_bsm == "Lulus Bersyarat") {
                                                return Html::a($model->statusmesyuarat . '<br><small>' . strtoupper($model->ulasan_bsm) . '</small>');
                                            } else {
                                                echo '-';
                                            }
                                        },
                                                'format' => 'html',
                                            ],
                                            [
                                                'label' => 'SALINAN SURAT TAWARAN',
                                                'format' => 'raw',
                                                'headerOptions' => ['class' => 'text-center'],
                                                'contentOptions' => ['class' => 'text-center'],
                                                'value' => function ($data) {

                                            if ($data->checkUpload($data->id)) {

                                                return Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']);
                                            } else {
                                                return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsurat', 'id' => $data->id]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
                                            }
                                        },
                                            ],
                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                //'attribute' => 'CONm',
                                                'header' => 'TINDAKAN',
                                                'headerOptions' => ['class' => 'text-center'],
                                                'contentOptions' => ['class' => 'text-center'],
                                                'template' => '{update}',
                                                //'header' => 'TINDAKAN',
                                                'buttons' => [
                                                    'update' => function ($url, $model) {
                                                        $url = Url::to(['cutisabatikal/tolak-tawaran', 'id' => $model->id]);
                                                        return Html::button('<i class="fa fa-check-square fa-lg" style="color:green"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                                    },
                                                        ],
                                                    ],
                                                ];



                                                echo GridView::widget([
                                                    'dataProvider' => $permohonanlulus,
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
                                                        . '<i class="fa fa-check-square fa-lg" style="color:green"></i> Permohonan Yang Diluluskan Jawatankuasa Pengajian Lanjutan</h6>',
                                                    ],
                                                ]);
                                                ?>
                                            </div>


                                        </div>
                                    </div>  

                                </div>  
                            </div>

<div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab">


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
                                                'label' => 'NAMA PEMOHON ',
                                                'headerOptions' => ['style' => 'width:20%', 'class' => 'text-left'],
//                               'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPermohonan::find()->all(), 'icno', 'kakitangan.CONm'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                                                'value' => function($model) {
                                            $ICNO = $model->icno;
                                            $id = $model->id;

                                            if ($model->jenis == "SEPARUH MASA") {


                                                $ICNO = $model->icno;
                                                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/cutisabatikal/adminviewsm', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                                                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
                                            } else {
                                                return Html::a('<u><strong>' . $model->kakitangan->CONm . '</u></strong>', ['/cutisabatikal/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id]) . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                                                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred . '<br>Tarikh Mohon: ' . $model->tarikhmohon;
                                            }
                                        },
                                                'format' => 'html',
                                            ],
                                            [
                                                //'attribute' => 'CONm',
                                                'label' => 'MAKLUMAT PENGAJIAN',
                                                'headerOptions' => ['style' => 'width:20%', 'class' => 'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                                                'value' => function($model) {
                                            $ICNO = $model->icno;
                                            return Html::a('<strong><small>' . strtoupper($model->s->InstNm) . '</small></strong><br>' .
                                                            '<small>' . $model->s->tahapPendidikan . '</small><br>' .
                                                            '<small>' . strtoupper($model->s->tarikhmula) . ' HINGGA</small> ' .
                                                            '<small>' . strtoupper($model->s->tarikhtamat) . '</small> ' .
                                                            '<small>(' . strtoupper($model->s->tempohtajaan) . ')</small><br>');
                                        },
                                                'format' => 'html',
                                            ],
                                            [
                                                //'attribute' => 'CONm',
                                                'label' => 'STATUS KEPUTUSAN',
                                                'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                                                'value' => function($model) {
//                                $ICNO = $model->icno;
                                            if ($model->status_bsm == "Diluluskan" || $model->status_bsm == "Lulus Bersyarat") {
                                                return Html::a($model->statusmesyuarat . '<br><small>' . strtoupper($model->ulasan_bsm) . '</small>');
                                            } else {
                                                echo '-';
                                            }
                                        },
                                                'format' => 'html',
                                            ],
                                            [
                                                'label' => 'SALINAN SURAT TAWARAN',
                                                'format' => 'raw',
                                                'headerOptions' => ['class' => 'text-center'],
                                                'contentOptions' => ['class' => 'text-center'],
                                                'value' => function ($data) {

                                            if ($data->checkUpload($data->id)) {

                                                return Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']);
                                            } else {
                                                return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['muatnaiksurat', 'id' => $data->id]), 'style' => 'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
                                            }
                                        },
                                            ],
                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                //'attribute' => 'CONm',
                                                'header' => 'TINDAKAN',
                                                'headerOptions' => ['class' => 'text-center'],
                                                'contentOptions' => ['class' => 'text-center'],
                                                'template' => '{update}',
                                                //'header' => 'TINDAKAN',
                                                'buttons' => [
                                                    'update' => function ($url, $model) {
                                                        $url = Url::to(['cutisabatikal/tolak-tawaran', 'id' => $model->id]);
                                                        return Html::button('<i class="fa fa-check-square fa-lg" style="color:green"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                                    },
                                                        ],
                                                    ],
                                                ];



                                                echo GridView::widget([
                                                    'dataProvider' => $tanpa,
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
                                                        . '<i class="fa fa-check-square fa-lg" style="color:green"></i> Permohonan Yang Diluluskan Jawatankuasa Pengajian Lanjutan</h6>',
                                                    ],
                                                ]);
                                                ?>
                                            </div>


                                        </div>
                                    </div>  

                                </div>  
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">


                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel"> 


                                            <div class="table-responsive">

                                                <?php
                                                $gridColumns4 = [
                                                    ['class' => 'yii\grid\SerialColumn',
                                                        'header' => 'BIL',
                                                        'headerOptions' => ['style' => 'width:1%', 'class' => 'text-center'],
                                                        'contentOptions' => ['class' => 'text-center'],
                                                    ],
                                                    [
                                                        'format'=>'raw',
                                            'label' => 'STATUS',
                                            'value' => function($model){
                                                    
                                             if ($model->mesyuarat->status == 1) {
                                                 
                                                return '<span class="label label-success">AKTIF</span>';
                                                }
                                                else {
                                               return'<span class="label label-warning">TUTUP</span>';
                                                    
                                                }
                                            }
                                                
                                        ],
                                                    [
                                            'label' => 'NAMA MESYUARAT',
                                            'value' => function($model) {
                                             if ($model->mesyuarat->kategori->id == 1) {
                                                 
                                               return 'Mesyuarat Jawatankuasa Pengajian Lanjutan Pentadbiran Bil. ' ." ". $model->mesyuarat->nama_mesyuarat." ".'(Kali Ke -' ." ". $model->mesyuarat->kali_ke.")";
                                                }
                                                else {
                                               return 'Mesyuarat Jawatankuasa Pengajian Lanjutan Akademik Bil. ' ." ". $model->mesyuarat->nama_mesyuarat." ".'(Kali Ke -' ." ". $model->mesyuarat->kali_ke.")";
                                                    
                                                }
                                            }
                                                
                                        ],
                                                    [
                                                        //'attribute' => 'CONm',
                                                        'label' => 'NAMA KAKITANGAN',
                                                        'headerOptions' => ['class' => 'column-title'],
                                                        'options' => ['style' => 'width:50%'],
                                                        'value' => function($model) {
                                                    $ICNO = $model->icno;
                                                    $id = $model->id;
                                                    return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                                    '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred;
                                                },
                                                'format' => 'html',
                                                ],
                                                [
                           //'attribute' => 'CONm',
                            'label' => 'PENGAJIAN YANG DIPOHON',
                            'headerOptions' => ['style' => 'width:30%','class'=>'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong><small>'.strtoupper($model->InstNm).'</small></strong><br>'.
                                     '<small>'.$model->tahapPendidikan.'</small><br>'.
                                     '<small>'.strtoupper($model->tarikhmula).' HINGGA</small> '.
                                     '<small>'.strtoupper($model->tarikhtamat).'</small> '.
                                     '<small><br>('.strtoupper($model->tempohtajaan).')</small><br>');
                            }, 
                                    'format' => 'html',
                        ],  
                                    [
                                                'class' => 'yii\grid\ActionColumn',
                                                //'attribute' => 'CONm',
                                                'header' => 'TINDAKAN',
                                                'headerOptions' => ['class' => 'text-center'],
                                                'contentOptions' => ['class' => 'text-center'],
                                                'template' => '{update}',
                                                //'header' => 'TINDAKAN',
                                                'buttons' => [
                                                    'update' => function ($url, $model) {
                                                        $url = Url::to(['cutisabatikal/tukar-status', 'id' => $model->id]);
                                                        return Html::button('<i class="fa fa-exchange fa-lg" style="color:grey"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                                    },
                                                        ],
                                                    ],

//                                   [
//                           //'attribute' => 'CONm',
//                            'label' => 'MAKLUMAT PENGAJIAN',
//                            'headerOptions' => ['style' => 'width:20%','class'=>'text-left'],
////                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                return Html::a('<strong><small>'.strtoupper($model->s->InstNm).'</small></strong><br>'.
//                                     '<small>'.$model->s->tahapPendidikan.'</small><br>'.
//                                     '<small>'.strtoupper($model->s->tarikhmula).' HINGGA</small> '.
//                                     '<small>'.strtoupper($model->s->tarikhtamat).'</small> '.
//                                     '<small>('.strtoupper($model->s->tempohpengajian).')</small><br>');
//                            }, 
//                                    'format' => 'html',
//                        ],     
                                                ];



                                                echo GridView::widget([
                                                'dataProvider' => $simpan,
                                                'columns' => $gridColumns4,
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
                                                'heading' => '<h6><i class="fa fa-save fa-lg" style="color:blue"></i>  Permohonan Yang Masih Disimpan (Belum Hantar)</h6>',
                                                ],
                                                ]);
                                                ?>
                                            </div>


                                        </div>
                                    </div>  

                                </div>  
                            </div> 

                            <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">


                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel"> 


                                            <div class="table-responsive">

                                                <?php
                                                $gridColumns5 = [
                                                ['class' => 'yii\grid\SerialColumn',
                                                'header' => 'BIL',
                                                'headerOptions' => ['style' => 'width:1%', 'class' => 'text-center'],
                                                'contentOptions' => ['class' => 'text-center'],
                                                ],
                                                [
                                                //'attribute' => 'CONm',
                                                'label' => 'NAMA KAKITANGAN',
                                                'headerOptions' => ['class' => 'column-title'],
                                                'options' => ['style' => 'width:50%'],
                                                'value' => function($model) {
                                                $ICNO = $model->icno;
                                                $id = $model->id;
                                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                                '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred;
                                            },
                                                    'format' => 'html',
                                                ],
                                                [
                                                    //'attribute' => 'CONm',
                                                    'label' => 'MAKLUMAT PENGAJIAN',
                                                    'headerOptions' => ['style' => 'width:20%', 'class' => 'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                                                    'value' => function($model) {
                                                $ICNO = $model->icno;
                                                return Html::a('<strong><small>' . strtoupper($model->s->InstNm) . '</small></strong><br>' .
                                                                '<small>' . $model->s->tahapPendidikan . '</small><br>' .
                                                                '<small>' . strtoupper($model->s->tarikhmula) . ' HINGGA</small> ' .
                                                                '<small>' . strtoupper($model->s->tarikhtamat) . '</small> ' .
                                                                '<small>(' . strtoupper($model->s->tempohtajaan) . ')</small><br>');
                                            },
                                                    'format' => 'html',
                                                ],
                                                    [
                                                    //'attribute' => 'CONm',
                                                    'label' => 'CATATAN',
                                                    'headerOptions' => ['style' => 'width:20%', 'class' => 'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                                                    'value' => function($model) {
                                                $ICNO = $model->icno;
                                                if($model->catatan_tawaran)
                                                {
                                               return '<small>'.$model->catatan_tawaran.'</small>';
                                                }
                                                else{
                                                    return '-';
                                                }
                                            },
                                                    'format' => 'html',
                                                ],
//                                    [
//                                    
//                           //'attribute' => 'CONm',
//                            'label' => 'PENGAJIAN YANG DIPOHON',
//                            'headerOptions' => ['style' => 'width:30%','class'=>'text-left'],
////                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                return Html::a('<strong><small>'.strtoupper($model->InstNm).'</small></strong><br>'.
//                                     '<small>'.$model->tahapPendidikan.'</small><br>'.
//                                     '<small>'.strtoupper($model->tarikhmula).' HINGGA</small> '.
//                                     '<small>'.strtoupper($model->tarikhtamat).'</small> '.
//                                     '<small><br>('.strtoupper($model->tempohpengajian).')</small><br>');
//                            }, 
//                                    'format' => 'html',
//                        ],    
                                            ];



                                            echo GridView::widget([
                                                'dataProvider' => $tidak,
                                                'columns' => $gridColumns5,
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
                                                    'heading' => '<h6><i class="fa fa-times fa-lg" style="color:red"></i>  Tolak Penawaran Cuti Belajar</h6>',
                                                ],
                                            ]);
                                            ?>
                                        </div>


                                    </div>
                                </div>  

                            </div>  
                        </div> 
            <div role="tabpanel" class="tab-pane fade" id="tab_content7" aria-labelledby="profile-tab">


                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel"> 


                                            <div class="table-responsive">

                                                <?php
                                                $gridColumns7 = [
                                                ['class' => 'yii\grid\SerialColumn',
                                                'header' => 'BIL',
                                                'headerOptions' => ['style' => 'width:1%', 'class' => 'text-center'],
                                                'contentOptions' => ['class' => 'text-center'],
                                                ],
                                                [
                                                //'attribute' => 'CONm',
                                                'label' => 'NAMA KAKITANGAN',
                                                'headerOptions' => ['class' => 'column-title'],
                                                'options' => ['style' => 'width:50%'],
                                                'value' => function($model) {
                                                $ICNO = $model->icno;
                                                $id = $model->id;
                                                  
                                                return Html::a('<strong><u>'.$model->kakitangan->CONm.'</u></strong>',['/cbadmin/pengajian', 'id' => $model->s->id],['target'=>'_blank',  'title' => 'Lihat Maklumat']).' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                                '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred;
                                            },
                                                    'format' => 'html',
                                                ],
                                                [
                                                    //'attribute' => 'CONm',
                                                    'label' => 'MAKLUMAT PENGAJIAN',
                                                    'headerOptions' => ['style' => 'width:20%', 'class' => 'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                                                    'value' => function($model) {
                                                $ICNO = $model->icno;
                                                return Html::a('<strong><small>' . strtoupper($model->s->InstNm) . '</small></strong><br>' .
                                                                '<small>' . $model->s->tahapPendidikan . '</small><br>' .
                                                                '<small>' . strtoupper($model->s->tarikhmula) . ' HINGGA</small> ' .
                                                                '<small>' . strtoupper($model->s->tarikhtamat) . '</small> ' .
                                                                '<small>(' . strtoupper($model->s->tempohtajaan) . ')</small><br>');
                                            },
                                                    'format' => 'html',
                                                ],
                                                    [
                                                    //'attribute' => 'CONm',
                                                    'label' => 'CATATAN',
                                                    'headerOptions' => ['style' => 'width:20%', 'class' => 'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                                                    'value' => function($model) {
                                                $ICNO = $model->icno;
                                                if($model->catatan_tawaran)
                                                {
                                               return '<small>'.$model->catatan_tawaran.'</small>';
                                                }
                                                else{
                                                    return '-';
                                                }
                                            },
                                                    'format' => 'html',
                                                ],
                                                    [
                'label' => 'TINDAKAN',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($nilai) {

            
                return Html::a('<i class="fa fa-pencil-square fa-lg" style="color:green"></i> ', ["/status-perkhidmatan/view", 'icno' => $nilai->icno],['target'=>'_blank',  'title' => 'Kemaskini Status']) ;
            
        },
            ],
//                                    [
//                                    
//                           //'attribute' => 'CONm',
//                            'label' => 'PENGAJIAN YANG DIPOHON',
//                            'headerOptions' => ['style' => 'width:30%','class'=>'text-left'],
////                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                return Html::a('<strong><small>'.strtoupper($model->InstNm).'</small></strong><br>'.
//                                     '<small>'.$model->tahapPendidikan.'</small><br>'.
//                                     '<small>'.strtoupper($model->tarikhmula).' HINGGA</small> '.
//                                     '<small>'.strtoupper($model->tarikhtamat).'</small> '.
//                                     '<small><br>('.strtoupper($model->tempohpengajian).')</small><br>');
//                            }, 
//                                    'format' => 'html',
//                        ],    
                                            ];



                                            echo GridView::widget([
                                                'dataProvider' => $terima,
                                                'columns' => $gridColumns7,
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
                                                    'heading' => '<h6><i class="fa fa-check fa-lg" style="color:green"></i>  Terima Penawaran Cuti Belajar</h6>',
                                                ],
                                            ]);
                                            ?>
                                        </div>


                                    </div>
                                </div>  

                            </div>  
                        </div> 
                                            <?php if ($title == 'Permohonan Baharu') { ?>
                            <div class="row"> 
                                <div class="col-xs-12 col-md-12 col-lg-12"> 

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
                                                            'label' => 'NAMA PEMOHON',
                                                            'options' => ['style' => 'width:30%'],
                                                            'value' => function($model) {
                                                        $ICNO = $model->icno;
                                                        return Html::a('<strong>' . $model->kakitangan->CONm . '</strong>') . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                                                                '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred;
                                                    },
                                                            'format' => 'html',
                                                        ],
                                                        [
                                                            //'attribute' => 'CONm',
                                                            'label' => 'PERINGKAT PENGAJIAN',
                                                            'headerOptions' => ['class' => 'text-center'],
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'value' => function($model) {
                                                                                                                $ICNO = $model->icno;

                                                        if($model->jenis == "PENYELIDIKAN")
                                                        {
                                                            return 'LATIHAN PENYELIDIKAN';
                                                        }
 else {
                                                        
                                                        return Html::a('<strong>' . strtoupper($model->s->tahapPendidikan) . '</strong>');
 }     },
                                                            'format' => 'html',
                                                        ],
                                                        [
                                                            //'attribute' => 'CONm',
                                                            'label' => 'MAKLUMAT PENGAJIAN',
                                                            'options' => ['style' => 'width:30%'],
                                                            'headerOptions' => ['class' => 'text-center'],
                                                            'contentOptions' => ['class' => 'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],                            
                                                            'value' => function($model) {
                                                        $ICNO = $model->icno;
                                                        return Html::a(ucwords(strtoupper($model->s->InstNm)) . '<br>' . (ucwords(strtoupper($model->s->tarikhmula))) . ' - ' . (ucwords(strtolower($model->s->tarikhtamat))) . '<br> (' . (ucwords(strtolower($model->s->tempohtajaan))) . ')<br>'
                                                        );
                                                    },
                                                            'format' => 'html',
                                                        ],
                                                        [
                                                            'label' => 'STATUS KETUA JABATAN/DEKAN',
                                                            'format' => 'raw',
                                                            'headerOptions' => ['class' => 'text-center'],
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'value' => function ($data) {

                                                        if ($data->status_jfpiu == 'Diperakukan' || $data->status_jfpiu == 'Tidak Diperakukan') {
                                                            return $data->statusjfpiu . '<br> ' . $data->app_date;
                                                        } else {
                                                            return $data->statusjfpiu;
                                                        }
                                                    },
                                                        ],
                                                        [
                                                            'label' => 'STATUS BSM',
                                                            'format' => 'raw',
                                                            'headerOptions' => ['class' => 'text-center'],
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'value' => function ($data) {

                                                        if ($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan') {
                                                            return $data->statusbsm . '<br><br> ' . ' ' . $data->ver_date;
                                                        } else {
                                                            return $data->statusbsm;
                                                        }
                                                    },
                                                        ],
                                                        [
                                                            'label' => 'SURAT KELULUSAN',
                                                            'format' => 'raw',
                                                            'headerOptions' => ['class' => 'text-center'],
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'value' => function ($data) {
                                                        if ($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan') {

                                                            return Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class' => 'fa fa-download', 'target' => '_blank']);
                                                        } else {
                                                            return '<i class="fa  fa-times fa-xs style="color:black;"></i> ';
                                                        }
                                                    },
                                                        ],
                                                        [
                                                            'label' => 'TINDAKAN',
                                                            'format' => 'raw',
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'value' => function ($data, $url) use($title) {

                                                        if ($data->idBorang == 1) {
                                                            $ICNO = $data->icno;
                                                            $url = Url::to(["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id' => $data->iklan_id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                            return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                                        'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                                                        } elseif ($data->idBorang == 38) {
                                                            $ICNO = $data->icno;
                                                            $url = Url::to(["cutibelajar/tindakan-kj-sm", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id' => $data->iklan_id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                            return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                                        'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                                                        } else {
                                                            $ICNO = $data->icno;

                                                            $url = Url::to(["cutisabatikal/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id' => $data->iklan_id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                            return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                                        'title' => 'Lihat Permohonan']);
                                                        }
                                                    },
                                                        ],
                                                    ],
                                                ]);
                                                ?>
                                        </div>
                                    </div>

                                </div>
                            </div><?php } ?>



        </div>
    </div>

