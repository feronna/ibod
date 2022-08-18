<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use Da\QrCode\QrCode;
use yii\helpers\Url;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Fruit */

Url::base();         // /myapp
Url::base(true);     // http(s)://example.com/myapp - depending on current schema
$test = Url::base('https');  // https://example.com/myapp
Url::base('http');   // http://example.com/myapp
Url::base('');       // //example.com/myapp

$qrCode = (new QrCode($test.'/idp/hadir-latihan?id='.$slotID.'&siriID='.$id.'&kursusID='.$model->kursusLatihanID.'&userID='.Yii::$app->user->getId()))
    ->setSize(250)
    ->setMargin(5)
    ->useForegroundColor(0, 0, 0);

/******************************************************/
// display directly to the browser 
header('Content-Type: '.$qrCode->getContentType());

$this->title = $model->sasaran3->tajukLatihan;
$ayat = 'SILA SCAN DI SINI';

// setup your attributes
// DetailView Attributes Configuration
$attributes = [
    [
        'group'=>true,
        'label'=>'BAHAGIAN 1: Informasi Kursus Latihan',
        'rowOptions'=>['class'=>'table-info']
    ],
    [
        'columns' => [
            [
                'attribute'=>'tajukLatihan',
                'value'=> ucwords(strtolower($model->sasaran3->tajukLatihan)),
                'displayOnly'=>true,
                'type'=>DetailView::INPUT_TEXTAREA, 
                'options'=>['rows'=>4]
                //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute'=>'tarikhMula',
                'value' => $model->tarikhMula,
//                'value'=> function ($model){               
//                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
//                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
//                                    $formatteddate = $myDateTime->format('d-m-Y');
//                                } else {
//                                    $formatteddate = '<em><b>TIADA DATA</b></em>';
//                                } 
//                                return $formatteddate;
//                            },
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:50%']
            ],
            [
                'attribute'=>'tarikhAkhir',
                'value' => $model->tarikhAkhir,
//                'value'=> function ($model){               
//                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
//                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
//                                    $formatteddate = $myDateTime->format('d-m-Y');
//                                } else {
//                                    $formatteddate = '<em><b>TIADA DATA</b></em>';
//                                } 
//                                return $formatteddate;
//                            },
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:50%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label'=>'Sinopsis Kursus',
                'format'=>'raw',
                'value'=>'<span class="text-justify"><em>' . $model->sasaran3->sinopsisKursus  . '</em></span>',
                'type'=>DetailView::INPUT_TEXTAREA, 
                'options'=>['rows'=>4]
            ],
        ],
    ],
];

// the grid columns setup (only two column entries are shown here
// you can add more column entries you need for your use case)
$gridColumns = [
            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                
            ],
//            [
//                'label' => 'Slot ID (Hide later)',
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//                'value' => 'slotID'
//            ],
//            [
//                'label' => 'Siri Latihan ID',
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//                'value' => 'siriLatihanID'
//            ],
            [
                'label' => 'Slot',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value'=> 'slot',
            ],
//            [
//                'label' => 'Slot Kini?',
//                'value'=> 'slotKini',
//            ],
            [
                'label' => 'TEKAN SINI',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value'=> function ($data){
                            //return Html::button('<i class="fa fa-eye">', ['idp/daftarkehadiran', 'id' => $data->siriLatihanID, 'slotID' => $data->slotID], ['class' => 'mapBtn btn-sm btn-danger btn-block'] );
                            //Html::a("Refresh", ['site/index'], ['class' => 'btn btn-lg btn-primary']);
                            return Html::button('<i class="fa fa-pencil" aria-hidden="true"></i> DAFTAR KEHADIRAN', ['value' => 'daftarkehadiranslot?id='.$data->siriLatihanID.'&slotID='.$data->slotID, 'class' => 'btn btn-primary btn-md fa fa-edit mapButton']);
                          },
            ],
                                 
    ];     
                          
$gridColumnsPeserta = [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions'=>['class'=>'kartik-sheet-style'],
                'width'=>'36px',
                'pageSummary'=>'Total',
                'pageSummaryOptions' => ['colspan' => 6],
                'header' => 'Bil',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
//                                'header' => 'Bil',
//                                'vAlign' => 'middle',
//                                'hAlign' => 'center',
                
            ],
            [
                'label' => 'Slot',
                'value' => 'slotID'
            ],
//            [
//                'label' => 'ID Peserta',
//                'value' => 'staffID'
//            ],
            [
                'label' => 'Nama Peserta',
                'format' => 'raw',
                'value' => function ($data){
                            return ucwords(strtolower($data->peserta->CONm));
                            }
            ],
            [
                'label' => 'JFPIU',
                'format' => 'raw',
                'value' => function ($data){
                            return ucwords(strtolower($data->peserta->department->fullname));
                            }
            ],
            [
                'label' => 'Tarikh & Masa',
                'format' => 'raw',
                'value' => 'tarikhMasa',
            ],
            [
                'label' => 'Status Peserta',
                'format' => 'raw',
                'value' => 'statusPeserta',
            ],
            [
                'label' => 'Jenis Kursus',
                'format' => 'raw',
                'value' => 'jenisKursus',
            ],
//            [
//                'label' => 'Mata Diperoleh',
//                'format' => 'raw',
//                'value' => 'sasaran9.mataSlot',
//            ],
];
?>
<script>$(function(){
    
    $('.mapButton').click(function (){
       $('#mod').modal('show')
               .find('#content')
               .load($(this).attr('value'));
    });
    
    
    
});</script>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-info-circle"></i> Maklumat Kursus</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        
            <?=
                // View file rendering the widget
                DetailView::widget([
                    'model' => $model,
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
//                    'panel' => [
//                        'type' => 'info', 
//                        'heading' => 'Butir-Butir Latihan',
//                        //'footer' => '<div class="text-center text-muted">This is a sample footer message for the detail view.</div>'
//                    ],
                    'buttons1' => false,
                    'deleteOptions'=>[ // your ajax delete parameters
                        'params' => ['id' => $model->kursusLatihanID, 'kvdelete'=>true],
                    ],
                    'container' => ['id'=>'kv-demo'],
                    'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
                ]);
                
            ?>
        </div>
    </div>
</div>

<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-plus-circle"></i> Slot Kursus</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
                ]);
            ?>
        </div>
    </div>
</div>

<!--<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-qrcode"></i> Pengesahan Kehadiran</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php Pjax::begin(); ?>
             Content that needs to be updated 
            Imbas di sini
            <?// '<br><img src="' . $qrCode->writeDataUri() . '">'; ?>
            <?php Pjax::end(); ?>
            Imbas di sini
        </div>
    </div>
</div>-->

<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Semakan Kehadiran</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php Pjax::begin(); ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderKehadiran,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPeserta,
                ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>