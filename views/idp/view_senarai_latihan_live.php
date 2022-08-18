<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\grid\GridView; //this Yii2 Gridview cannot use 'hover'
//use \yiister\gentelella\widgets\grid\GridView; //use this one to called 'hover'
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use app\models\myidp\TblYears;

echo $this->render('/idp/_topmenu');
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h4>Panduan</h4>
                <div class="clearfix"></div>
            </div>
            <ul>
                <li><span class="btn btn-danger btn-md"><i class="glyphicon glyphicon-pencil"></i></span> : Daftar Kehadiran Peserta</li>
                <li><span class="btn btn-warning btn-md"><i class="glyphicon glyphicon-download-alt"></i></span> : Muat Turun Kehadiran Peserta</li>
                <li><span class="btn btn-primary btn-md"><i class="glyphicon glyphicon-user"></i></span> : Kemaskini Maklumat Penceramah</li>
            </ul>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Senarai Kursus Yang Telah Dijalankan</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>
                    <!-- ubah kat sini -->
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            //\yiister\gentelella\widgets\grid\GridView::widget([
                            //'hover' => true,
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'showFooter' => true,
                            'showHeader' => true,
                            'layout' => "{items}\n{pager}",
                            'pager' => [
                                'firstPageLabel' => 'Halaman Pertama',
                                'lastPageLabel'  => 'Halaman Terakhir'
                            ],
                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>AKAN DIMAKLUMKAN</b></i>'],
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'header' => 'Bil',
                                ],
                                [
                                    'attribute' => 'tajukLatihan',
                                    'vAlign' => 'middle',
                                    'contentOptions' => ['style' => 'width:300px;'],
                                    'filterInputOptions' => [
                                        'class'       => 'form-control',
                                        'placeholder' => 'Cari...'
                                    ],
                                    'label' => 'Kursus',
                                    'value' => function ($data) {
                                        if ($data->sasaran3) {
                                            return ucwords(strtoupper($data->sasaran3->tajukLatihan));
                                        }
                                    },
                                ],
                                [
                                    'label' => 'Siri',
                                    'hAlign' => 'center',
                                    'vAlign' => 'middle',
                                    'value' => 'siri',
                                ],

                                [
                                    'class' => 'kartik\grid\EnumColumn',
                                    'label' => 'Anjuran',
                                    'hAlign' => 'center',
                                    'vAlign' => 'middle',
                                    'attribute' => 'jenis',
                                    'value' => 'sasaran3.jenisKursus',
                                    'format' => 'raw',
                                    'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
                                        'latihanDalaman' => 'DALAMAN',
                                        'jfpiu' => 'JAFPIB',
                                    ],
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen
                                    'contentOptions' => ['style' => 'padding:0px 0px 0px 15px;vertical-align: middle;'],
                                ],

                                [
                                    'label' => 'Tempat',
                                    'hAlign' => 'center',
                                    'vAlign' => 'middle',
                                    'value' => function ($data) {
                                        return ucwords(strtoupper($data->lokasi));
                                    },
                                    'contentOptions' => ['style' => 'width:100px;'],
                                ],

                                [
                                    'label' => 'Tarikh',
                                    'hAlign' => 'center',
                                    'vAlign' => 'middle',
                                    'format' => 'raw',
                                    'attribute' => 'bulan',
                                    'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
                                        '1' => 'Januari',
                                        '2' => 'Februari',
                                        '3' => 'Mac',
                                        '4' => 'April',
                                        '5' => 'Mei',
                                        '6' => 'Jun',
                                        '7' => 'Julai',
                                        '8' => 'Ogos',
                                        '9' => 'September',
                                        '10' => 'Oktober',
                                        '11' => 'November',
                                        '12' => 'Disember',

                                    ],
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen    
                                    'value' => function ($model) {
                                        if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                                            $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                                            $formatteddate = $myDateTime->format('d/m/Y');

                                            if (($model->tarikhAkhir != null) && ($model->tarikhAkhir != 0000 - 00 - 00)) {
                                                $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhAkhir);
                                                $formatteddate2 = $myDateTime2->format('d/m/Y');
                                            } else {
                                                $formatteddate2 = '<em><b>AKAN DIMAKLUMKAN</b></em>';
                                            }

                                            if ($formatteddate == $formatteddate2) {
                                                $formatteddate = $formatteddate;
                                            } else {
                                                $formatteddate = $formatteddate . ' - ' . $formatteddate2;
                                            }
                                        } else {
                                            $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
                                        }
                                        return $formatteddate;
                                    },
                                    'headerOptions' => ['style' => 'width:100px'],
                                ],
                                //                        [
                                //                            'label' => 'Slip Kursus',
                                //                            'format' => 'raw',
                                //                            'value'=> function ($data){
                                //                                            
                                //                                            if ($data->sasaran3->jenisLatihanID != 'jfpiu'){
                                //                                                return Html::a('<i class="fa fa-download" aria-hidden="true"></i>', ['slip-kod-kursus?id='.$data->siriLatihanID], ['class' => 'btn-sm btn-primary', 'target' => '_blank']);
                                //                                            } else {
                                //                                                return "";
                                //                                            }
                                //                                      },
                                //                            'contentOptions' => ['style'=>'padding:0px 0px 0px 30px;vertical-align: middle;'],
                                //                        ],
                                [
                                    'label' => 'Tahun',
                                    'hAlign' => 'center',
                                    'vAlign' => 'middle',
                                    'format' => 'raw',
                                    'attribute' => 'tahun',
                                    'filter' => ArrayHelper::map(TblYears::findAll(['admin_status' => 1]), 'year', 'year'),
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen    
                                    'contentOptions' => ['style' => 'width:50px;'],
                                    'value' => function ($model) {
                                        if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                                            $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                                            $formatteddate = $myDateTime->format('Y');
                                        } else {
                                            $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
                                        }
                                        return $formatteddate;
                                    },
                                    'headerOptions' => ['style' => 'width:100px'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Tindakan',
                                    //'headerOptions' => ['style' => 'color:#337ab7'],
                                    'headerOptions' => ['style' => 'width:150px'],
                                    'contentOptions' => ['style' => 'padding:0px 0px 0px 15px;vertical-align: middle;'],
                                    'template' => '{view}{laporan_kehadiran}{view_penceramah}',
                                    //'contentOptions' => ['style'=>'padding:0px 0px 0px 30px;vertical-align: middle;'],
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                                'title' => Yii::t('app', 'Papar'),
                                                'class' => 'btn btn-danger btn-sm',
                                                'target' => "_blank"
                                            ]);
                                        },
                                        'view_penceramah' => function ($url, $model) {
                                            return $model->sasaran3->jenisLatihanID != 'jfpiu' ? Html::a('<span class="glyphicon glyphicon-user""></span>', $url, [
                                                'title' => Yii::t('app', 'Papar'),
                                                'class' => 'btn btn-primary btn-sm',
                                                'target' => "_blank"
                                            ]) : '';
                                        },
                                        'laporan_kehadiran' => function ($url, $model) {
                                            return $model->sasaran3->jenisLatihanID != 'jfpiu' ? Html::a('<span class="glyphicon glyphicon-download-alt"></span>', $url, [
                                                'title' => Yii::t('app', 'Papar'),
                                                'class' => 'btn btn-warning btn-sm',
                                                'target' => "_blank"
                                            ]) : '';
                                        },
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'view') {
                                            if ($model->sasaran5) {
                                                $url = 'view-latihan-live?id=' . $model->siriLatihanID . '&slotID=' . $model->sasaran5->slotID;
                                                //$url ='view-sahkehadiran?id='.$model->siriLatihanID;
                                                return $url;
                                            }
                                        }

                                        if ($action === 'view_penceramah') {
                                            $url = 'view-senarai-penceramah?id=' . $model->siriLatihanID; //hantar ke Controller
                                            return $url;
                                        }

                                        if ($action === 'laporan_kehadiran') {
                                            $url = 'laporan-kehadiran-siri?id=' . $model->siriLatihanID; //hantar ke Controller
                                            return $url;
                                        }
                                    }
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>