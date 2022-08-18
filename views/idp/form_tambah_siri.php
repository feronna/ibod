<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\detail\DetailView;

echo $this->render('/idp/_topmenu');

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// setup your attributes
// DetailView Attributes Configuration
$attributes = [
    [
        'group' => true,
        'label' => 'BAHAGIAN 1: Informasi Kursus Latihan',
        'rowOptions' => ['class' => 'table-info']
    ],
    [
        'columns' => [
            [
                'attribute' => 'kursusLatihanID',
                'label' => 'Kursus Latihan #',
                'format' => 'raw',
                'value' => '<kbd>' . $modelLatihan->kursusLatihanID . '</kbd>',
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:100%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute' => 'tajukLatihan',
                'value' => ucwords(strtolower($modelLatihan->tajukLatihan)),
                'displayOnly' => true,
                'type' => DetailView::INPUT_TEXTAREA,
                'options' => ['rows' => 4]
                //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute' => 'penggubalModul',
                'label' => 'Pemilik Modul',
                'format' => 'raw',
                'value' => $modelLatihan->penggubalModul,
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:100%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Tahun Tawaran',
                'format' => 'raw',
                'value' => '<span class="text-justify">' . $modelLatihan->tahunTawaran  . '</span>',
                'valueColOptions' => ['style' => 'width:30%']
            ],
            [
                'label' => 'Kategori Jawatan',
                'format' => 'raw',
                'value' => '<span class="text-justify">' . $modelLatihan->kategoriJawatanID  . '</span>',
                'valueColOptions' => ['style' => 'width:50%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute' => 'sinopsisKursus',
                'format' => 'raw',
                'value' => '<span class="text-justify"><em>' . $modelLatihan->sinopsisKursus  . '</em></span>',
                'type' => DetailView::INPUT_TEXTAREA,
                'options' => ['rows' => 4]
            ]
        ],
    ],
    //    [
    //        'group'=>true,
    //        'label'=>'BAHAGIAN 2: Informasi Penceramah',
    //        'rowOptions'=>['class'=>'table-info'],
    //        //'groupOptions'=>['class'=>'text-center']
    //    ],
    //    [
    //        'columns' => [ 
    //            [   
    //                'label' => 'Penceramah',
    //                'format'=>'raw',
    //                'value'=> ucwords(strtolower($modelLatihan->penceramah->displayGelaran . ' ' . $modelLatihan->penceramah->CONm)),
    //                'valueColOptions'=>['style'=>'width:30%']
    //            ],
    //            [   
    //                'label' => 'Jawatan',
    //                'format'=>'raw',
    //                'value'=> ucwords(strtolower($modelLatihan->penceramah->jawatan->nama)),
    //                'valueColOptions'=>['style'=>'width:50%']
    //            ],
    //            
    //        ],
    //    ],
    //    [
    //        'columns' => [ 
    //            [   
    //                'label' => 'JFPIU',
    //                'format'=>'raw',
    //                'value'=> ucwords(strtolower($modelLatihan->penceramah->department->fullname)),
    //                'valueColOptions'=>['style'=>'width:30%']
    //            ],
    //            [   
    //                'label' => 'Pendidikan',
    //                'format'=>'raw',
    //                'value'=> ucwords(strtolower($modelLatihan->penceramah->namaKos->EduCertTitle)),
    //                'valueColOptions'=>['style'=>'width:50%']
    //            ],
    //            
    //        ],
    //    ],
];

// the grid columns setup (only two column entries are shown here
// you can add more column entries you need for your use case)
$gridColumns = [
    [
        'label' => 'Tahun',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($model) {
            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                $formatteddate = $myDateTime->format('Y');
            } else {
                $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
            }
            return $formatteddate;
        },
    ],
    [
        'label' => 'Siri',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'value' => 'siri',
    ],
    [
        'label' => 'Tarikh',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
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
    ],
    [
        'label' => 'Tempat ',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => 'lokasi',
    ],
    // [
    //     'header' => 'Jumlah <br> Jam',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'format' => 'raw',
    //     'value' => 'jumlahJamLatihan',
    //     'width' => '50px',
    // ],
    [
        'header' => 'Mata <br> IDP',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => 'jumlahMataIDP',
    ],
    [
        'label' => 'Status',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($model) {
            if ($model->statusSiriLatihan != 'SEDANG BERJALAN') {

                if ($model->statusSiriLatihan == 'ACTIVE') {
                    $a = '<span class="label label-primary">AKTIF</span>';
                } else {
                    $a = '<span class="label label-danger">' . $model->statusSiriLatihan . '</span>';
                }
            } else {
                $a = '<span class="label label-success">LIVE</span>';
            }
            return $a;
        },
    ],
    // [
    //     'label' => 'Bahan',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'format' => 'raw',
    //     'value' => function ($data) {
    //         $datalist = [];
    //         if ($data->sasaran7) {
    //             foreach ($data->sasaran7 as $files) {
    //                 $a =  Html::a(Yii::$app->FileManager->NameFile($files->filename), Yii::$app->FileManager->DisplayFile($files->filename)) . '<br>';
    //                 array_push($datalist, $a);
    //             }
    //         } else {
    //             return "TIADA BAHAN";
    //         }
    //         $all = " ";
    //         $b = count($datalist);
    //         for ($i = 0; $i < count($datalist); $i++) {
    //             $all = $b . ') ' . $datalist[$i] . $all;
    //             $b--;
    //         }
    //         return $all;
    //     },
    // ],
    [
        'label' => 'Penceramah',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '300px',
        'format' => 'raw',
        'value' => function ($data) {
            $datalist = [];
            if ($data->ceramah) { // if ada penceramah

                foreach ($data->ceramah as $c) { //foreach penceramah

                    if ($c->penceramah) {
                        $a = Html::a(ucwords(strtolower($c->penceramah->displayGelaran . ' ' . $c->penceramah->CONm)), [""], ['class' => 'btn btn-success disabled']);
                    } else {
                        $a = Html::a(ucwords(strtolower($c->penceramahluar->penceramah_name)), [""], ['class' => 'btn btn-success disabled']);
                    }

                    //$a = Html::a(ucwords(strtolower($c->penceramah->displayGelaran . ' ' . $c->penceramah->CONm)), [""], ['class' => 'btn btn-success disabled'] );
                    //$a =  Html::a(Yii::$app->FileManager->NameFile($files->filename), Yii::$app->FileManager->DisplayFile($files->filename)).'<br>';
                    array_push($datalist, $a);
                }
            } else {
                return '<em><b>TIADA PENETAPAN</b></em>';
            }
            // $all = " ";
            // $b = count($datalist);
            // for ($i = 0; $i < count($datalist); $i++) {
            //     $all = $b . ') ' . $datalist[$i] . '<br>' . $all;
            //     $b--;
            // }
            // return $all;

            $all = " ";
            $b = count($datalist);
            if (count($datalist) > 1) {
                for ($i = 0; $i < count($datalist); $i++) {
                    // $all = $b . ') ' . $datalist[$i] . '<br>' . $all;
                    $all = $datalist[$i] . '<br>' . $all;
                    $b--;
                }
            } else {
                $all = $datalist[0] . '<br>' . $all;
            }
            return $all;
        },

    ],
    [
        'label' => 'Kuota',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'value' => 'kuota'
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Tindakan',
        //'headerOptions' => ['style' => 'color:#337ab7'],
        //'template' => '{update} | {delete} | {linkSasaran} | {linkJemputan} | {semakPermohonan} | {jemputPeserta} ',
        'template' => '{update} | {delete} | {linkSasaran} | {semakPermohonan} ',
        'buttons' => [
            // 'jemputPeserta' => function ($url, $model) {
            //     return Html::a('<span class="glyphicon glyphicon-briefcase"></span>', $url, [
            //         'title' => Yii::t('app', 'Jemput Peserta'),
            //     ]);
            // },
            'semakPermohonan' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-share"></span>', $url, [
                    'title' => Yii::t('app', 'Semak Permohonan'),
                ]);
            },
            'linkSasaran' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, [
                    'title' => Yii::t('app', 'Tetapan Sasaran'),
                ]);
            },
            // 'linkJemputan' => function ($url, $model) {
            //     return Html::a('<span class="glyphicon glyphicon-envelope"></span>', $url, [
            //         'title' => Yii::t('app', 'Tetapan Jemputan'),
            //     ]);
            // },
            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => Yii::t('app', 'Kemaskini'),
                    //'class' => 'mapBtn btn btn-primary',
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-trash"></span>',
                    $url,
                    [
                        'data' => [
                            'confirm' => 'Adakah anda pasti anda ingin menghapuskan rekod ini?',
                            'method' => 'post',
                        ],
                    ],
                    ['title' => Yii::t('app', 'Hapus'),]
                );
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'linkSasaran') {
                $url = 'view-senarai-jawatan?id=' . $model->siriLatihanID; //hantar ke Controller
                return $url;
            }

            // if ($action === 'linkJemputan') {
            //     $url = 'view-jemputan?id=' . $model->siriLatihanID; //hantar ke Controller
            //     return $url;
            // }

            if ($action === 'update') {
                $url = 'update-siri?id=' . $model->siriLatihanID; //hantar ke Controller
                return $url;
            }
            if ($action === 'delete') {
                $url = 'delete-siri?id=' . $model->siriLatihanID;
                return $url;
            }

            if ($action === 'semakPermohonan') {
                $url = 'semak-permohonan-siri?id=' . $model->siriLatihanID . '&pagee=viewPemohon';
                return $url;
            }

            // if ($action === 'jemputPeserta') {
            //     $url = 'jemput-peserta?id=' . $model->siriLatihanID;
            //     return $url;
            // }
        }
    ],
];
?>

<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v3.3.1/css/all.css">
    <style>
        #myBtn {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Fixed/sticky position */
            bottom: 20px;
            /* Place the button at the bottom of the page */
            right: 30px;
            /* Place the button 30px from the right */
            z-index: 99;
            /* Make sure it does not overlap */
            border: none;
            /* Remove borders */
            outline: none;
            /* Remove outline */
            background-color: grey;
            /* Set a background color */
            color: white;
            /* Text color */
            cursor: pointer;
            /* Add a mouse pointer on hover */
            padding: 15px;
            /* Some padding */
            border-radius: 10px;
            /* Rounded corners */
            font-size: 18px;
            /* Increase font size */
        }

        #myBtn:hover {
            background-color: #555;
            /* Add a dark-grey background on hover */
        }
    </style>
</head>
<button onclick="topFunction()" id="myBtn" title="Go to top">&uarr;</button>
<script>
    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    function checkDate() {
        var startDate = new Date(document.getElementById("StartDate").value);
        var endDate = new Date(document.getElementById("EndDate").value);

        if ((Date.parse(endDate) < Date.parse(startDate))) {
            alert("RALAT! Tarikh akhir kursus haruslah selepas tarikh mula. Sila isi kembali.");
            document.getElementById("EndDate").value = "";
        }
    }
</script>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>
                    <h3><span class="label label-primary" style="color: white">Maklumat Kursus</span>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                    </h3>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?=
                // View file rendering the widget
                DetailView::widget([
                    'model' => $modelLatihan,
                    'attributes' => $attributes,
                    'mode' => 'view',
                    'bordered' => true,
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'hover' => true,
                    'hAlign' => 'right',
                    'vAlign' => 'middle',
                    'fadeDelay' => 1,
                    'panel' => [
                        'type' => 'success',
                        'heading' => 'Butir-Butir Latihan',
                        //'footer' => '<div class="text-center text-muted">This is a sample footer message for the detail view.</div>'
                    ],
                    'buttons1' => false,
                    'deleteOptions' => [ // your ajax delete parameters
                        'params' => ['id' => $modelLatihan->kursusLatihanID, 'kvdelete' => true],
                    ],
                    'container' => ['id' => 'kv-demo'],
                    'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
                ]);

                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>
                    <h3><span class="label label-info" style="color: white">Maklumat Siri</span>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                    </h3>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?=

                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <?= Html::a(
                    'TAMBAH SIRI',
                    ['tambahsiri', 'id' => $modelLatihan->kursusLatihanID],
                    ['class' => 'btn btn-primary']
                )
                ?>
                <?= Html::a('KEMBALI', ['view-senarai-latihan'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>