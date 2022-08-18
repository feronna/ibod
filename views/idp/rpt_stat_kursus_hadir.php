<?php

use app\models\myidp\SiriLatihan;
use app\models\myidp\PermohonanLatihan;
use app\models\myidp\Kehadiran;
use app\models\hronline\Campus;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\select2\Select2;

echo $this->render('/idp/_topmenu');

error_reporting(0);

//$dataProvider->pagination->pageParam = 'p-page';
//$dataProvider->sort->sortParam = 'p-sort';
//
//$dataProviderA->pagination->pageParam = 'a-page';
//$dataProviderA->sort->sortParam = 'a-sort';

$gridColumns = [
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'Bil.',],
                        
                        [
                            'label' => 'Kursus',
                            //'value' => 'sasaran3.tajukLatihan',
                            'value' => function ($data){
                                            return strtoupper($data->sasaran3->tajukLatihan);
                                        },
                            'contentOptions' => ['style' => 'width:400px;'],
//                            'filterInputOptions' => [
//                                'class'       => 'form-control',
//                                'placeholder' => 'Tajuk kursus latihan dikehendaki...'
//                            ],
                        ],
                        [ 'attribute' => 'siri',
//                            'filterInputOptions' => [
//                                'class'       => 'form-control',
//                                'placeholder' => 'Siri dikehendaki...'
//                            ],
                        ],
                        [ 
                            'label' => 'Tarikh',
                            'value' => 'tarikhKursus',
                            'contentOptions' => ['style' => 'width:100px;'],
                        ],
                        [ 
                            'label' => 'Tempat',
                            'value' => function ($data){
                                            return strtoupper($data->lokasiKursus);
                                        },
                        ],
                        [ 
                            'label' => 'Kampus',
                            'value' => 'campusName.campus_name'
                        ],
                        [ 
                            'label' => 'Kategori',
                            'value' => 'sasaran3.unitBertanggungjawab'
                        ],
                        [ 
                            'label' => 'Mata IDP',
                            'value' => 'jumlahMataIDP'
                        ],
                        [ 
                            'header' => 'Jumlah <br> Sasaran',
                            'value' => 'kuota'
                        ],
                        [ 
                            'header' => 'Jumlah <br> Pemohon',
                            'value' => function ($data){
                                            return PermohonanLatihan::calculatePemohon($data->siriLatihanID);
                                        },
                        ],
                        [ 
                            'header' => 'Jumlah <br> Kehadiran',
                            'value' => function ($data){
                                            return Kehadiran::calculatePeserta($data->siriLatihanID);
                                        },
                        ],
                                                
                    ];

?><?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
<style>
    .container span {
  display: inline-block;
}
</style>   
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Laporan Pelaksanaan Kursus (2020)</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
<?php
                
    for ($i = 1; $i <= 12; $i++){
        
?>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">         
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-calendar"></i> <span class="label label-info" style="color: white"><?= SiriLatihan::getTarikh($i)?></span></strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div  class="pull-right">
                <?=
                ExportMenu::widget([
                    'dataProvider' => SiriLatihan::liveKursusByMonth($i),
                    'columns' => $gridColumns,
                    'filename' => 'laporan_myidp_'.date('Y-m-d'),
                    'clearBuffers' => true,
                    'stream' => false,
                    'folder' => '@app/web/files/myidp/.',
                    'linkPath' => '/files/myidp/',
                    'batchSize' => 10,
    //                'deleteAfterSave' => true
                ]); 
                ?>
                </div>
                <div class="clearfix"></div> 
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini --> 
                    <div class="table-responsive">
                        <!--<php $senaraiKursus = $searchModel->senaraiKursus;-->
                        <!-- $senaraiKursus is a function from myidp\VIdpSenaraiKursus-->
                <?php
                Pjax::begin([
                    // PJax options
                ]);
                
                
                echo GridView::widget([
                    'dataProvider' => SiriLatihan::liveKursusByMonth($i),
//                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
//                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: white;'],
                    //'filterModel' => $searchModelSiri,
//                    'showFooter'=>true,
//                    'showHeader' => true,
//                    'layout' => "{items}\n{pager}",
//                    'pager' => [
//                        'firstPageLabel' => 'Halaman Pertama',
//                        'lastPageLabel'  => 'Halaman Terakhir'
//                    ],
                    'columns' => $gridColumns,
                ]);
                Pjax::end();
                ?>
                    </div>  
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>
<?php } ?>

            </div> <!-- x_content -->
        </div>
    </div>
</div>