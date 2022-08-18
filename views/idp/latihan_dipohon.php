<?php

use yii\helpers\Html;
//use kartik\grid\GridView;
//use yii\grid\GridView; //this Yii2 Gridview cannot use 'hover'
use kartik\grid\GridView; //using this will trigger kartik confirmation dialog
use app\assets\AppAsset;

error_reporting(0);

$bundle = yiister\gentelella\assets\Asset::register($this);
AppAsset::register($this);

/* * * for popover PENCERAMAH & INFO **** */
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});
/* To initialize BS3 popovers set this below */
$(function () { 
   $("[data-toggle='popover']").popover();
//    $("[data-trigger='focus']").popover();
//    $('.popover-dismiss').popover({
//        trigger: 'focus'
//        })
});
//$(function() {
//    // use the popoverButton plugin
//    $('#kv-btn-1').popoverButton({
//        placement: 'left', 
//        target: '#myPopover5'
//    });
//});
$(function() {
    $('#testHover').popoverButton({
        trigger: 'hover focus',
        target: '#myPopover6'
    });
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);

// setup your attributes
// DetailView Attributes Configuration
//$attributes = [
//    [
//        'group'=>true,
//        'label'=>'BAHAGIAN 1: Informasi Kursus Latihan',
//        'rowOptions'=>['class'=>'table-info']
//    ],
//    [
//        'columns' => [
//            [
//                'attribute'=>'kursusLatihanID', 
//                'label'=>'Kursus Latihan #',
//                'format'=>'raw', 
//                'value'=>'<kbd>'.$modelLatihan->kursusLatihanID.'</kbd>',
//                'displayOnly'=>true,
//                'valueColOptions'=>['style'=>'width:100%']
//            ],
//        ],
//    ],
//    [
//        'columns' => [
//            [
//                'attribute'=>'tajukLatihan',
//                'value'=> ucwords(strtolower($modelLatihan->tajukLatihan)),
//                'displayOnly'=>true,
//                'type'=>DetailView::INPUT_TEXTAREA, 
//                'options'=>['rows'=>4]
//                //'valueColOptions'=>['style'=>'width:90%'],
//            ],
//        ],
//    ],
//    [
//        'columns' => [
//            [
//                'attribute'=>'penggubalModul', 
//                'label'=>'Pemilik Modul',
//                'format'=>'raw', 
//                'value'=>$modelLatihan->penggubalModul,
//                'displayOnly'=>true,
//                'valueColOptions'=>['style'=>'width:100%']
//            ],
//        ],
//    ],
//    [
//        'columns' => [  
//            [
//                'label'=>'Tahun Tawaran', 
//                'format'=>'raw',
//                'value'=>'<span class="text-justify">' . $modelLatihan->tahunTawaran  . '</span>',
//                'valueColOptions'=>['style'=>'width:30%']
//            ],
//            [
//                'label'=>'Kategori Jawatan', 
//                'format'=>'raw',
//                'value'=>'<span class="text-justify">' . $modelLatihan->kategoriJawatanID  . '</span>',
//                'valueColOptions'=>['style'=>'width:50%']
//            ],
//        ],
//    ],
//    [
//        'columns' => [
//            [
//                'attribute'=>'sinopsisKursus',
//                'format'=>'raw',
//                'value'=>'<span class="text-justify"><em>' . $modelLatihan->sinopsisKursus  . '</em></span>',
//                'type'=>DetailView::INPUT_TEXTAREA, 
//                'options'=>['rows'=>4]
//            ]
//        ],
//    ],
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
//];

//$kategori2 = kategori;

// the grid columns setup (only two column entries are shown here
// you can add more column entries you need for your use case)
$gridColumns = [
    //            ['class' => 'yii\grid\SerialColumn',
    //                                'header' => 'Siri',
    //                
    //            ],
    //            [
    //                'label' => 'Kursus Latihan #',
    //                'value' => 'kursusLatihanID'
    //            ],
    [
        'label' => 'Siri',
        'value' => 'sasaran6.siri',
    ],
    [
        'label' => 'Tarikh',
        'format' => 'raw',
        'value' => function ($model) {
            if (($model->sasaran6->tarikhMula != null) && ($model->sasaran6->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->sasaran6->tarikhMula);
                $formatteddate = $myDateTime->format('d/m/Y');

                $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->sasaran6->tarikhAkhir);
                $formatteddate2 = $myDateTime2->format('d/m/Y');

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
    [
        'label' => 'Hari',
        'value' => 'sasaran6.hari',
        'headerOptions' => ['style' => 'width:100px'],
    ],
    [
        'label' => 'Lokasi ',
        'format' => 'raw',
        //'value'=> 'sasaran6.lokasi',
        'value' => function ($data) {
            if ($data->sasaran6->linkZoom) {
                return $data->sasaran6->lokasi . '<hr>' .
                    Html::a('<i class="fa fa-video-camera" aria-hidden="true" text-align="center"></i>', $data->sasaran6->linkZoom, ['class' => 'btn-sm btn-info btn-block', 'target' => '_blank']);
            } else {
                return $data->sasaran6->lokasi . '<hr>' .
                    Html::button('<i class="fa fa-ban" aria-hidden="true"></i>', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true]);
            }
        },
        'headerOptions' => ['style' => 'width:150px'],
    ],
    //            [
    //                'label' => 'Kampus',
    //                'value'=> 'sasaran6.campusName.campus_name',
    //            ],
    //            [
    //                'label' => 'Jumlah Jam',
    //                'format' => 'raw',
    //                'value' => 'jumlahJamLatihan',
    //            ],
    //            [
    //                'label' => 'Jumlah Mata IDP',
    //                'format' => 'raw',
    //                'value' => 'jumlahMataIDP',
    //            ],
    [
        'label' => 'Status',
        'format' => 'raw',
        'value' => function ($model) {
            if ($model->sasaran6->statusSiriLatihan == 'DITANGGUHKAN') {
                $a = '<span class="btn btn-primary">DITANGGUHKAN</span>';
            } elseif ($model->sasaran6->statusSiriLatihan == 'SEDANG BERJALAN') {
                $a = '<span class="btn btn-danger" disabled>TELAH DIJALANKAN</span>';
            } elseif ($model->sasaran6->statusSiriLatihan == 'ACTIVE') {
                $a = '<span class="btn btn-primary">AKTIF</span>';
            }
            return $a;
        },
    ],
    [
        'label' => 'Penceramah',
        'format' => 'raw',
        'value' => function ($data) {
            $datalist = [];
            if ($data->sasaran6->ceramah) { // if ada penceramah

                foreach ($data->sasaran6->ceramah as $c) { //foreach penceramah

                    if ($c->kepakaran) {
                        foreach ($c->kepakaran as $model) {
                            $dataa[] = $model->bidKepakaran;
                            $dataa2[] = $model->bidang;
                        }
                    } else {
                        $dataa = [];
                        $dataa2 = [];
                    }

                    // $a = Html::tag('span', '<i class="fa fa-user-circle" aria-hidden="true"></i> PENCERAMAH', [
                    //             'data-html' => 'true',
                    //             //'data-title' => '<b>'.ucwords(strtolower($lat2->sasaran->penceramah->displayGelaran . ' ' . $lat2->sasaran->penceramah->CONm)).'</b>',
                    //             'data-title' => '<b>'.ucwords(strtolower($c->penceramah->displayGelaran . ' ' . $c->penceramah->CONm)).'</b>',
                    //             'data-content' => '<img src="https://hronline.ums.edu.my/picprofile/picstf/'.strtoupper(sha1($c->penceramahID)).'.jpeg" alt="TIADA IMEJ" class="img-circle profile_img">'
                    //             .'<br>'
                    //             .'<br><b>Jawatan : </b>'.ucwords(strtolower($c->penceramah->jawatan->nama))
                    //             .'<br>'
                    //             .'<br><b>PTJ : </b>'.ucwords(strtolower($c->penceramah->department->fullname))
                    //             .'<br>'
                    //             .'<br><b>Pendidikan : </b>'.ucwords(strtolower($c->penceramah->namaKos->EduCertTitle))
                    //             .'<br>'
                    //             .'<br><b>Kluster Kepakaran : </b>'.ucwords(strtolower(" ")).implode(", ", $dataa)
                    //             .'<br>'
                    //             .'<br><b>Bidang Kepakaran : </b>'.ucwords(strtolower(" ")).implode(", ", $dataa2),                                                                                    
                    //             'data-toggle' => 'popover',
                    //             'data-placement' => 'right',
                    //             'data-trigger' => 'hover',
                    //             'class' => 'btn btn-success',
                    //             'style' => 'text-decoration: underline: cursor:pointer;'
                    //         ]);

                    $a = Html::tag('span', '<b>' . ucwords(strtolower($c->penceramah->displayGelaran . ' ' . $c->penceramah->CONm)) . '</b>', [
                        'data-html' => 'true',
                        //'data-title' => '<b>'.ucwords(strtolower($lat2->sasaran->penceramah->displayGelaran . ' ' . $lat2->sasaran->penceramah->CONm)).'</b>',
                        //'data-title' => '<b>' . ucwords(strtolower($c->penceramah->displayGelaran . ' ' . $c->penceramah->CONm)) . '</b>',
                        // 'data-content' => '<img src="https://hronline.ums.edu.my/picprofile/picstf/'.strtoupper(sha1($c->penceramahID)).'.jpeg" alt="TIADA IMEJ" class="img-circle profile_img">'
                        // // .'<br>'
                        // // .'<br><b>Jawatan : </b>'.ucwords(strtolower($c->penceramah->jawatan->nama))
                        // // .'<br>'
                        // // .'<br><b>PTJ : </b>'.ucwords(strtolower($c->penceramah->department->fullname))
                        // // .'<br>'
                        // // .'<br><b>Pendidikan : </b>'.ucwords(strtolower($c->penceramah->namaKos->EduCertTitle))
                        // // .'<br>'
                        // // .'<br><b>Kluster Kepakaran : </b>'.ucwords(strtolower(" ")).implode(", ", $dataa)
                        // .'<br>'
                        // .'<br><b>Bidang Kepakaran : </b>'.ucwords(strtolower(" ")).implode(", ", $dataa2),                                                                                    
                        'data-toggle' => 'popover',
                        'data-placement' => 'right',
                        'data-trigger' => 'hover',
                        'class' => 'btn btn-sm btn-success',
                        //'class' => 'user-profile dropdown-toggle',
                        //'data-toggle' => 'dropdown',
                        //'href' => 'javascript:;',
                        'style' => 'text-decoration: underline: cursor:pointer;'
                    ]);

                    //$a = Html::button($c->penceramahID, [""], ['class' => 'btn btn-sm btn-primary'] );
                    //$a =  Html::a(Yii::$app->FileManager->NameFile($files->filename), Yii::$app->FileManager->DisplayFile($files->filename)).'<br>';
                    array_push($datalist, $a);
                }
            } else {
                return '<em><b>AKAN DIMAKLUMKAN</b></em>';
            }
            // $all = " ";
            // $b = count($datalist);
            // for($i = 0; $i < count($datalist); $i++){
            //     $all = $b.') '.$datalist[$i].'<br>'.$all;
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
            //return count($datalist);
        },

    ],
    //            [
    //                'label' => 'Tarikh Pohon',
    //                'value' => function ($data){
    //                                $tarikhKursus = $data->tarikhPermohonan;
    //                                $myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $tarikhKursus);
    //                                $formatteddate = $myDateTime->format('d-m-Y');
    //                                return $formatteddate;
    //                            }
    //            ],
    [
        'class' => 'yii\grid\ActionColumn',
        //'header' => 'Tindakan',
        'template' => '{delete}',
        'buttons' => [
            'delete' => function ($url, $model) {

                if ($model->sasaran6->statusSiriLatihan != 'SEDANG BERJALAN') {
                    return Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>',
                        $url,
                        [
                            'data' => [
                                'confirm' => 'Adakah anda pasti anda ingin membatalkan permohonan ini?',
                                'method' => 'post',
                            ],
                        ],
                        [
                            'title' => Yii::t('app', 'Hapus'),
                            'class' => 'btn btn-danger btn-sm',
                        ]
                    );
                } else {
                    return "";
                }
            },
        ],

        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'delete') {

                $url = 'delete-permohonan-siri?siriID=' . $model->siriLatihanID . '&staffID=' . $model->staffID;
                return $url;
            }
        },
        //'visible' => 'Condition' ? true : false
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

        if ((Date.parse(endDate) <= Date.parse(startDate))) {
            alert("RALAT! Tarikh akhir kursus haruslah selepas tarikh mula. Sila isi kembali.");
            document.getElementById("EndDate").value = "";
        }
    }
</script>
<!--<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-info-circle"></i> Maklumat Kursus</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        
                // View file rendering the widget
                //DetailView::widget([
//                    'model' => $modelLatihan,
//                    'attributes' => $attributes,
//                    'mode' => 'view',
//                    'bordered' => true,
//                    'striped' => true,
//                    'condensed' => true,
//                    'responsive' => true,
//                    'hover' => true,
//                    'hAlign' => 'right',
//                    'vAlign' => 'middle',
//                    'fadeDelay' => 1,
////                    'panel' => [
////                        'type' => 'info', 
////                        'heading' => 'Butir-Butir Latihan',
////                        //'footer' => '<div class="text-center text-muted">This is a sample footer message for the detail view.</div>'
////                    ],
//                    'buttons1' => false,
//                    'deleteOptions'=>[ // your ajax delete parameters
//                        'params' => ['id' => $modelLatihan->kursusLatihanID, 'kvdelete'=>true],
//                    ],
//                    'container' => ['id'=>'kv-demo'],
//                    'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
                //]);
                
           
        </div>
    </div>
</div>-->
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h4>Panduan</h4>
                <div class="clearfix"></div>
            </div>
            <ul>
                <li><span class="btn btn-success btn-md"><i class="fa fa-user-circle" aria-hidden="true"></i> PENCERAMAH</span> : Info Penceramah</li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Semakan Permohonan Kursus<h4><span class="label label-primary" style="color: white"><?= strtoupper($modelLatihan->tajukLatihan) ?></span></h4>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?=
                //                // Generate a bootstrap responsive striped table with row highlighted on hover
                //                GridView::widget([
                //                    //'moduleId' => 'gridviewKrajee', // change the module identifier to use the respective module's settings
                //                    'dataProvider'=> $dataProvider,
                //                    //'filterModel' => $searchModel,
                //                    'columns' => $gridColumns,
                //                    'responsive'=>true,
                //                    'hover'=>true,
                //                    'pjax'=>true,
                //                    'pjaxSettings' => [
                //                        'neverTimeout'=>true,
                //                        'beforeGrid'=>'My fancy content before.',
                //                        'afterGrid'=>'My fancy content after.',
                //                    ],
                //                    'resizableColumns'=>true,
                //                    'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
                //                    'floatHeader'=>true,
                //                    'floatHeaderOptions'=>['top'=>'50'],
                //                    'showPageSummary' => true,
                //                    'toolbar' => [
                //                        [
                //                            'content'=>
                //                                Html::button('<i class="glyphicon glyphicon-plus"></i>', [
                //                                    'type'=>'button', 
                //                                    'title'=>Yii::t('kvgrid', 'Add Book'), 
                //                                    'class'=>'btn btn-success'
                //                                ]) . ' '.
                //                                Html::a('<i class="fas fa-redo"></i>', ['grid-demo'], [
                //                                    'class' => 'btn btn-secondary', 
                //                                    'title' => Yii::t('kvgrid', 'Reset Grid')
                //                                ]),
                //                        ],
                //                        '{export}',
                //                        '{toggleData}'
                //                    ]
                //                ]);

                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>AKAN DIMAKLUMKAN</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
                ]);
                ?>
            </div>
        </div>
    </div>
</div>