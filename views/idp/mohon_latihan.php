<?php

use yii\helpers\Html;
//use yii\grid\GridView; //this Yii2 Gridview cannot use 'hover'
use app\assets\AppAsset;
use yii\bootstrap\Modal;
use kartik\popover\PopoverX;
use kartik\grid\GridView; //using this will trigger kartik confirmation dialog

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
});

// $(function() {
//     $('#testHover').popoverButton({
//         trigger: 'hover focus',
//         target: '#myPopover6'
//     });
// });
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
        'label' => 'Siri #',
        'value' => 'siri',
    ],
    [
        'label' => 'Tarikh',
        'format' => 'raw',
        'value' => function ($model) {
            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                $formatteddate = $myDateTime->format('d/m/Y');

                $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhAkhir);
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
    //            [
    //                'label' => 'Tarikh Mula',
    //                'format' => 'raw',
    //                'value' => function ($model){               
    //                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
    //                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
    //                                    $formatteddate = $myDateTime->format('d-m-Y');
    //                                } else {
    //                                    $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
    //                                } 
    //                                return $formatteddate;
    //                            },
    //            ],
    //            [
    //                'label' => 'Tarikh Tamat',
    //                'format' => 'raw',
    //                'value' => function ($model){               
    //                                if (($model->tarikhAkhir != null) && ($model->tarikhAkhir != 0000-00-00)){
    //                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhAkhir);
    //                                    $formatteddate = $myDateTime->format('d-m-Y');
    //                                } else {
    //                                    $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
    //                                } 
    //                                return $formatteddate;
    //                            },
    //            ],
    [
        'label' => 'Hari',
        'value' => 'hari',
        'headerOptions' => ['style' => 'width:100px'],
    ],
    [
        'label' => 'Lokasi ',
        'format' => 'raw',
        'value' => 'lokasi',
        'headerOptions' => ['style' => 'width:150px'],
        //'class' => 'kartik\grid\EditableColumn',
        //'attribute' => 'lokasi',
        //                'pageSummary' => 'Jumlah',
        //                'vAlign' => 'middle',
        //                'width' => '210px',
        //                'readonly' => function($model, $key, $index, $widget) {
        //                    return (!$model->status); // do not allow editing of inactive records
        //                },
        //                'editableOptions' =>  function ($model, $key, $index) use ($colorPluginOptions) {
        //                    return [
        //                        'header' => 'Lokasi', 
        //                        'size' => 'sm',
        //                        'afterInput' => function ($form, $widget) use ($model, $index, $colorPluginOptions) {
        //                            return $form->field($model, "color")->widget(\kartik\color\ColorInput::classname(), [
        //                                'showDefaultPalette' => false,
        //                                'options' => ['id' => "color-{$index}"],
        //                                'pluginOptions' => $colorPluginOptions,
        //                            ]);
        //                        }
        //                    ];
        //                }
        //'pageSummary'=>true,
        //                'editableOptions'=> function ($model, $key, $index) {
        //                    return [
        //                        'header'=>'Lokasi',
        //                        'size'=>'sm',
        //                        'formOptions'=>['action' => ['/idp/editsiri']], // point to the new action
        //                    ];
        //                }
    ],
    //            [
    //                'label' => 'Kampus',
    //                'value'=> 'campusName.campus_name',
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
        'label' => 'Status Siri',
        'format' => 'raw',
        'value' => function ($model) {
            if ($model->statusSiriLatihan == 'DITANGGUHKAN') {
                $a = '<span class="btn btn-primary">DITANGGUHKAN</span>';
            } elseif ($model->statusSiriLatihan == 'SEDANG BERJALAN') {
                $a = '<span class="btn btn-danger" disabled>TELAH DIJALANKAN</span>';
            } elseif ($model->statusSiriLatihan == 'ACTIVE') {
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
            if ($data->ceramah) { // if ada penceramah

                foreach ($data->ceramah as $c) { //foreach penceramah

                    if ($c->kepakaran) {
                        foreach ($c->kepakaran as $model) {
                            $dataa[] = $model->bidKepakaran;
                            $dataa2[] = $model->bidang;
                        }
                    } else {
                        $dataa = [];
                        $dataa2 = [];
                    }

                    // <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    
                    //                 <img src="https://hronline.ums.edu.my/picprofile/picstf/F381FFEFF6CF3AC977A7A731FE421E5BC72CB539.jpeg" alt="">                                    <span class=" fa fa-angle-down"></span>
                    //             </a>

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

                    // $a = 'Testing for ' . Html::tag('span', 'popover', [
                    //     'data-title' => 'Heading',
                    //     'data-content' => 'This is the content for the popover',
                    //     'data-toggle' => 'popover',
                    //     'style' => 'text-decoration: underline; cursor:pointer;'
                    // ]);

                    // Advanced usage of PopoverX inside a Bootstrap Modal Dialog.
                    // Advanced usage of PopoverX inside a Bootstrap Modal Dialog.
                    // Modal::begin([
                    //     'title' => 'My Modal',
                    //     'toggleButton' => ['label' => 'Popover inside Modal', 'class' => 'btn btn-primary']
                    // ]);
                    // echo '<p>Some custom content above in my modal dialog. Popover can be clicked below to see details:</p>';
                    // echo PopoverX::widget([
                    //     'header' => 'Hello world',
                    //     'type' => PopoverX::TYPE_INFO,
                    //     'placement' => PopoverX::ALIGN_BOTTOM,
                    //     'content' => 'a',
                    //     'toggleButton' => ['label' => 'My Popover', 'class' => 'btn btn-info'],
                    // ]);
                    // echo '<hr><p>Some more custom content below in my modal dialog.</p>';
                    // Modal::end();

                    //$a = Html::button($c->penceramahID, [""], ['class' => 'btn btn-sm btn-primary'] );
                    //$a =  Html::a(Yii::$app->FileManager->NameFile($files->filename), Yii::$app->FileManager->DisplayFile($files->filename)).'<br>';

                    array_push($datalist, $a);
                }
            } else {
                return '<em><b>AKAN DIMAKLUMKAN</b></em>';
            }
            $all = " ";
            $b = count($datalist);
            if (count($datalist) > 1){
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
        'headerOptions' => ['style' => 'width:200px'],

    ],
    [
        'label' => 'Tindakan',
        'format' => 'raw',
        'value' => function ($data) use ($kategori) {

            if ($data->kuota) {

                if ($data->checkKuota($data->siriLatihanID) < $data->kuota) {

                    /** for MCO only until 28 April - modify checkPastProgram to allow permohonan on the day of program **/
                    if ($data->checkPastProgram() == 1) {
                        //return Html::a('MOHON', ["idp/mohon-siri-latihan", 'id' => $data->kursusLatihanID, 'siriID' => $data->siriLatihanID, 'kategor' => $kategori], ['class' => 'btn btn-sm btn-primary'] );
                        return Html::a(
                            'MOHON',
                            ["idp/mohon-siri-latihan", 'id' => $data->kursusLatihanID, 'siriID' => $data->siriLatihanID, 'kategor' => $kategori],
                            [
                                'class' => 'btn btn-primary',
                                'data' => [
                                    'confirm' => 'Sila semak butiran permohonan anda. '
                                        . '<br>'
                                        . '<br>'
                                        . 'Kursus Dipohon : ' . $data->sasaran3->tajukLatihan
                                        . '<br>'
                                        . 'Siri # : ' . $data->siri
                                        . '<br>'
                                        . 'Lokasi : ' . $data->lokasiKursus
                                        . '<br>'
                                        . 'Tarikh : ' . $data->tarikhKursus
                                        . '<br>'
                                        . '<br>'
                                        . 'Hantar permohonan anda?'
                                ]
                            ]
                        );
                    } else {
                        return Html::button('PERMOHONAN DITUTUP', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true]);
                    }
                } elseif ($data->checkKuota($data->siriLatihanID) >= $data->kuota) {
                    return Html::button('PERMOHONAN DITUTUP', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true]);
                    //$v = Html::button('TELAH DIJEMPUT', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true]);
                }
            } else {
                return Html::button('DALAM PROSES', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true]);
            }


            //return Html::a('MOHON', ["idp/mohon-siri-latihan", 'id' => $data->kursusLatihanID, 'siriID' => $data->siriLatihanID, 'kategor' => $kategori], ['class' => 'btn btn-sm btn-primary'] );
            //return Html::button('MOHON', ['value' => 'mohon-latihan?id='.$data->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-primary btn-block']);
        },

    ],
];
?>
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
                <li><span class="btn btn-primary btn-md"> MOHON</span> : Sila klik untuk memohon siri ini.</li>
                <li><span class="btn btn-danger btn-md"> PERMOHONAN DITUTUP</span> : Permohonan ditutup bagi siri ini.</li>
                <li><span class="btn btn-success btn-md"><i class="fa fa-user-circle" aria-hidden="true"></i> PENCERAMAH</span> : Info Penceramah</li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Senarai Siri Kursus<h4><span class="label label-primary" style="color: white"><?= strtoupper($modelLatihan->tajukLatihan) ?></span></h4>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <?php echo
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
                        'class' => 'table-responsive',
                        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>AKAN DIMAKLUMKAN</b></i>'],
                        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        'columns' => $gridColumns,
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>