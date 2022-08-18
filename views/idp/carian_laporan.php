<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use app\models\hronline\Department;
use app\models\hronline\GredJawatan;
use app\models\myidp\UserAccess;
use kartik\grid\GridView;

echo $this->render('/idp/_topmenu');

error_reporting(0);
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
     
$gridColumns = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',
            ], 
            [
                'attribute' => 'rpt_title',
                'contentOptions' => ['style' => 'width:400px;'],
//                'filterInputOptions' => [
//                    'class'  => 'form-control',
//                    'placeholder' => 'Cari...'
//                ],
//                'filterWidgetOptions' => [
//                    'pluginOptions' => ['allowClear' => true],
//                ],
                'label' => 'Laporan',
                'value' => function ($data){
                                return ucwords(strtolower($data->rpt_title));
                           },                
            ],
            ['class' => 'yii\grid\ActionColumn',
                            'header' => $previousYear,
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{view}',
                            'buttons' => [
                              'view' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                              'title' => Yii::t('app', 'Papar Profil'),
                                              'data-pjax' => 0,
                                              'target' => "_blank",
                                  ]);
                              },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                              if ($action === 'view') {
                                  $url ='index-laporan2?year='.date("Y",strtotime("-1 year"));
                                  return $url;
                              }
                            }
            ],
            ['class' => 'yii\grid\ActionColumn',
                            'header' => $currentYear,
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{view}',
                            'buttons' => [
                              'view' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                              'title' => Yii::t('app', 'Papar Profil'),
                                              'data-pjax' => 0,
                                              'target' => "_blank",
                                  ]);
                              },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                              if ($action === 'view') {
                                  $url ='index-laporan2?year='.date('Y');
                                  return $url;
                              }
                            }
            ],
            
];
?>
<div class="clearfix"></div>

<!--<div class="row">
    <div class="x_panel"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul>
            <li><span class="label label-default">BARU</span> : Permohonan Baru</li>
            <li><span class="label label-info">DIPERAKUI</span> : Permohonan Telah Diperakui Oleh Pegawai Pelulus Kursus</li>  
            <li><span class="label label-success">LULUS</span> : Permohonan Telah Diluluskan Oleh Ketua JFPIU</li>
            <li><span class="label label-danger">TIDAK DIPERAKUI</span> : Permohonan Tidak Diperakui</li>
            <li><span class="label label-danger">TIDAK DILULUSKAN</span> : Permohonan Tidak Diluluskan</li>
            <li><span class="label label-primary">JEMPUTAN</span> : Permohonan Jemputan Wajib</li>  
        </ul>
    </div>
    </div>
</div>-->

<div class="clearfix"></div> 
<div class="row">
    <div class="x_panel">
        <div class="x_title">
            <h5>Senarai<h3><span class="label label-primary" style="color: white">Laporan</span></h3></h5>
            <div class="clearfix"></div>
        </div>
<!--        <div class="x_title">
            <h2><strong>Hasil Carian</strong></h2><div  class="pull-right"><?php 
//            ExportMenu::widget([
//                'dataProvider' => $dataProviderKursusLuar,
//                'columns' => $gridColumnsKursusLuar,
//                'filename' => 'laporan_elnpt_akademik_'.date('Y-m-d'),
//                'clearBuffers' => true,
//                'stream' => false,
//                'folder' => '@app/web/files/elnpt/.',
//                'linkPath' => '/files/elnpt/',
//                'batchSize' => 10,
////                'deleteAfterSave' => true
//            ]); 
            ?></div>
            <div class="clearfix"></div>
            
        </div>-->
        <div class="x_content">
            
            <?php Pjax::begin(); ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
                ]);
            ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>