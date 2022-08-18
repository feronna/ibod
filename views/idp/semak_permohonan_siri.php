<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use app\widgets\IdpTileWidget;
use kartik\grid\GridView;
use app\models\myidp\PermohonanLatihan;
use kartik\export\ExportMenu;

echo $this->render('/idp/_topmenu');

$gridColumnsPemohon = [
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
                'label' => 'Nama',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'format' => 'raw',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->gelaran->Title)).' '.ucwords(strtolower($data->biodata->CONm));
                            }
            ],
            [
                'label' => 'Jawatan',
                'format' => 'raw',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->jawatan->nama)).' ('.ucwords(strtoupper($data->biodata->jawatan->gred)).')';
                            }
            ],
            [
                'label' => 'JAFPIB',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'format' => 'raw',
                'value' => function ($data){
                            return ucwords(strtoupper($data->biodata->department->shortname));
                            }
            ],
            [
                'label' => 'Tarikh Permohonan',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'format' => 'raw',
                'value' => 'tarikhPermohonan',
            ],
            [
                'label' => 'Status Permohonan',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'format' => 'raw',
                'value' => 'statusPermohona',
            ],
//            [
//                'label' => 'Jenis Kursus',
//                'format' => 'raw',
//                'value' => 'jenisKursus',
//            ],
            [
                'header' => 'Pengesahan Kehadiran',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'format' => 'raw',
                'value' => function ($data){
                                
                                    if ($data->sahHadirbyStaf != NULL) {

                                        if ($data->sahHadirbyStaf == 'TIDAK'){
                                            $a = '<span class="label label-danger">TELAH SAHKAN KETIDAKHADIRAN</span>';
                                        } elseif ($data->sahHadirbyStaf == 'YA'){
                                            $a = '<span class="label label-success">TELAH SAHKAN KEHADIRAN</span>';
                                        }
                                        
                                    } else {
                                        $a = '<span class="label label-warning">TIDAK MEMBUAT PENGESAHAN KEHADIRAN</span>';
                                    }
                    
                                return $a;
                            }
                ],
];

?>

<div class="clearfix"></div> 
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h5>Semakan Kursus <h3><span class="label label-success" style="color: white"><?= ucwords(strtolower($modelSiriLatihan->sasaran3->tajukLatihan)).' Siri '.ucwords(strtolower($modelSiriLatihan->siri)) ?></span></h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="row">
        <div class="col-xs-12 col-md-4">
            <?php
            $testingPage1 = IdpTileWidget::widget(
                            [
                                'icon' => 'external-link',
                                //'icon' => 'fas fa-chart-pie',
                                'header' => 'Permohonan',
                                //'text' => '<p class="bg-primary">Kursus wajib universiti</p>',
                                'text' => 'Jumlah permohonan per kuota',
                                'number' => PermohonanLatihan::calculatePemohon($siriID). '/' .$modelSiriLatihan->kuota,
    //                            'pbar' => '<div class="'.$uprogressBarColour.' role="progressbar" data-transitiongoal="'.$percentageTerasUniversiti.'">'.$percentageTerasUniversiti.'%</div>',
                            ]
            );
            echo Html::a($testingPage1, ['idp/semak-permohonan-siri?id='.$siriID.'&pagee=viewPemohon']);
            ?> 
        </div>
        <div class="col-xs-12 col-md-4">
            <?php
            $testingPage2 = IdpTileWidget::widget(
                            [
                                'icon' => 'external-link',
                                'header' => 'Sahkan Hadir',
                                'text' => 'Jumlah pemohon mengesahkan kehadiran',
                                'number' => PermohonanLatihan::calculateSahHadir($siriID). '/' .$modelSiriLatihan->kuota,
    //                            'pbar' => '<div class="'.$sprogressBarColour.' role="progressbar" data-transitiongoal="'.$percentageTerasSkim.'">'.$percentageTerasSkim.'%</div>',
                            ]
            );
            echo Html::a($testingPage2, ['idp/semak-permohonan-siri?id='.$siriID.'&pagee=viewSahHadir']);
            ?>
        </div>
        <div class="col-xs-12 col-md-4">
            <?php
            $testingPage3 = IdpTileWidget::widget(
                            [
                                'icon' => 'external-link',
                                'header' => 'Sahkan Ketidakhadiran',
                                'text' => 'Jumlah pemohon mengesahkan ketidakhadiran',
                                'number' => PermohonanLatihan::calculateSahTidakHadir($siriID). '/' .$modelSiriLatihan->kuota,
    //                            'pbar' => '<div class="'.$eprogressBarColour.' role="progressbar" data-transitiongoal="'.$percentageElektif.'">'.$percentageElektif.'%</div>',
                            ]
            );
            echo Html::a($testingPage3, ['idp/semak-permohonan-siri?id='.$siriID.'&pagee=viewSahTidakHadir']);
            ?>
        </div>
        </div>
        </div>
    </div>
</div>
</div>

<?php if (isset($_GET['pagee'])){
    if ($_GET['pagee'] == "viewPemohon"){ ?>

<div class="clearfix"></div> 
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
                <h5>Senarai <h3><span class="label label-primary" style="color: white">Pemohon</span>
                
                <?=
                ExportMenu::widget([
                    'dataProvider' => $dataProviderPemohon,
                    'columns' => $gridColumnsPemohon,
                    'filename' => 'Senarai Pemohon Kursus '.ucwords(strtolower($modelSiriLatihan->sasaran3->tajukLatihan)).' Siri '.$modelSiriLatihan->siri,
                    'clearBuffers' => true,
                    'stream' => false,
                    'folder' => '@app/web/files/myidp/.',
                    'linkPath' => '/files/myidp/',
                    'batchSize' => 10,
    //                'deleteAfterSave' => true
                ]); 
                ?>
                
                </h3></h5>
                <div class="clearfix"></div>    
            </div>
        <div class="x_content">
            
            <?php Pjax::begin(); ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderPemohon,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPemohon,
                ]);
            ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
</div>

<?php } elseif ($_GET['pagee'] == "viewSahHadir"){ ?>

<div class="clearfix"></div> 
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h5>Senarai <h3><span class="label label-primary" style="color: white">Pemohon</span></h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <?php Pjax::begin(); ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderPemohon,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPemohon,
                ]);
            ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
</div>

<?php } elseif ($_GET['pagee'] == "viewSahTidakHadir"){ ?>

<div class="clearfix"></div> 
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h5>Senarai <h3><span class="label label-primary" style="color: white">Pemohon</span></h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <?php Pjax::begin(); ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderPemohon,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPemohon,
                ]);
            ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
</div>

<?php } } ?>

