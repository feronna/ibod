<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use app\models\hronline\Department;
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
     
$gridColumnsKursusLuar = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',
            ], 
            [
                'attribute' => 'CONm',
                'contentOptions' => ['style' => 'width:150px;'],
                'filterInputOptions' => [
                    'class'  => 'form-control',
                    'placeholder' => 'Cari...'
                ],
                'label' => 'Nama',
                'value' => function ($data){
                                return ucwords(strtolower($data->biodata->CONm));
                           },                
            ],                               
            [
                'attribute' => 'DeptId',
//                'contentOptions' => ['style' => 'width:400px;'],
                'label' => 'JFPIB',
                'hAlign' => 'center',
                'value' => function ($data){
                            return ucwords(strtoupper($data->biodata->department->shortname));
                           },
                'filter'    => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
                'filterType' => GridView::FILTER_SELECT2,
                 'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen                  
            ],
            [
                'header' => 'Kursus',
                'format' => 'raw',
                'value' => function ($data){
                            //return strtoupper($data->namaProgram);
                            return Html::a(strtoupper($data->namaProgram), '/staff/web/idp/view-latihan-luar-pohon?permohonanID='.$data->permohonanID.'&userLevel='.$userLevel.'&update=NO', 
                                    [
                                        'title' => Yii::t('app', 'Papar'),
                                        'class' => 'testLink',
                                    ]);
                            },
            ],
            [
                            'label' => 'Tarikh',
                            'hAlign' => 'center',
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
                            //'contentOptions' => ['style' => 'width:50px;'],
                            'value' => function ($model){               
                                            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){

                                                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                                                $formatteddate = $myDateTime->format('d/m/Y');

                                                $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhTamat);
                                                $formatteddate2 = $myDateTime2->format('d/m/Y');

                                                if ($formatteddate == $formatteddate2 ){
                                                    $formatteddate = $formatteddate;    
                                                } else {
                                                    $formatteddate = $formatteddate.' - '.$formatteddate2;
                                                }

                                            } else {
                                                $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
                                            } 
                                            return $formatteddate;
                                        },
            ],
            // [
            //                 'label' => 'Tahun',
            //                 'hAlign' => 'center',
            //                 'format' => 'raw',
            //                 'attribute' => 'tahun',
            //                 'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
            //                     '2020' => '2020',
            //                     '2021' => '2021',
                                
            //                 ],
            //                 'filterType' => GridView::FILTER_SELECT2,
            //                 'filterWidgetOptions' => [
            //                     'pluginOptions' => ['allowClear' => true],
            //                 ],
            //                 'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen    
            //                 //'contentOptions' => ['style' => 'width:25px;'],
            //                 'value' => function ($model){               
            //                                 if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){

            //                                     $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
            //                                     $formatteddate = $myDateTime->format('Y');

            //                                 } else {
            //                                     $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
            //                                 } 
            //                                 return $formatteddate;
            //                             },
            // ],
            [
                'header' => 'Tarikh <br> Lulus',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($data){
                                
                                if ($data->tarikhSemakanBSM){
                                    $tarikhKursus = $data->tarikhSemakanBSM;
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                    $formatteddate = $myDateTime->format('d/m/Y');

                                    return ucwords(strtolower($formatteddate));
                                }
                            },
            ],
            [
                'header' => 'Jumlah <br> Pembiayaan',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($data){
                                return 'RM '.$data->jumlahLuluss;
                            },
            ],
            [
                'header' => 'Surat <br> Kursus',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($data){
                            return Html::a('<i class="fa fa-envelope-open-o" aria-hidden="true">', '/staff/web/idp/surat-kursus-luar?permohonanID='.$data->permohonanID, 
                                    [
                                        'title' => Yii::t('app', 'Papar'), 
                                        'data-pjax' => 0,
                                        'target' => "_blank"
                                    ]);
                            },
            ],
            [
                'header' => 'Tindakan <br> Urusetia',
                'format' => 'raw',
                'hAlign' => 'center',
                'value'=> function ($data){
                                
                                if (!$data->suratLulus){
                                        //return Html::a('<i class="fa fa-edit">', '/staff/web/idp/view-latihan-luar-pohon?permohonanID='.$data->permohonanID.'&userLevel='.$userLevel.'&update=NO', ['title' => Yii::t('app', 'Papar')]);
                                        
                                        // return Html::a('<i class="fa fa-hand-pointer-o" aria-hidden="true"></i>',
                                        //         ["idp/jana-surat-kursus-luar", 'id' => $data->permohonanID],
                                        //         [
                                        //     'class' => 'btn-sm btn-primary btn-block', 
                                        //     'data'=> [
                                        //         'confirm' => 'Berjaya membuat pengesahan semakan surat kursus luar. Hantar pengesahan?'
                                        //         ]
                                        //     ]);

                                        return Html::button('<i class="fa fa-hand-pointer-o" aria-hidden="true"></i>', [
                                                'id' => 'modalButton', 
                                                'value' => \yii\helpers\Url::to(['semaksurat', 
                                                    'id' => $data->permohonanID,
                                                    'idB' => 'belumSemak']),
                                                'class' => 'btn btn-sm btn-primary mapBtn'
                                                ]);
                                } else {
                                    
                                    if ($data->suratLulus->date_ul){

                                        if ($data->suratLulus->status_ul == '1'){
                                            return Html::button('<i class="fa fa-check" aria-hidden="true"></i>', ['class' => 'btn-sm btn-success btn-block', 'disabled' => true] );
                                        } else {

                                            return Html::button('<i class="fa fa-ban" aria-hidden="true"></i>', [
                                                'id' => 'modalButton', 
                                                'value' => \yii\helpers\Url::to(['semaksurat', 
                                                    'id' => $data->permohonanID,
                                                    'idB' => 'sudahSemak']),
                                                'class' => 'btn btn-sm btn-danger mapBtn'
                                                ]);

                                        }
                                    } else {

                                        if (!$data->suratLulus->date_pl){ 
                                            return Html::button('<i class="fa fa-check" aria-hidden="true"></i>', ['class' => 'btn-sm btn-success btn-block', 'disabled' => true] );
                                        } else {
                                            return "";
                                        }

                                    
                                    }
                                    
                                }
                          },
            ],
            [
                'header' => 'Tindakan <br> Pegawai',
                'format' => 'raw',
                'hAlign' => 'center',
                'value'=> function ($data){
                                
                                if ($data->suratLulus->date_ul){
                                        //return Html::a('<i class="fa fa-edit">', '/staff/web/idp/view-latihan-luar-pohon?permohonanID='.$data->permohonanID.'&userLevel='.$userLevel.'&update=NO', ['title' => Yii::t('app', 'Papar')]);
                                    
                                    if ($data->suratLulus->status_ul == '1'){
                                        if (!$data->suratLulus->date_pl){ 
                                            return Html::a('<i class="fa fa-hand-pointer-o" aria-hidden="true"></i>',
                                                    ["idp/jana-surat-kursus-luar", 'id' => $data->permohonanID],
                                                    [
                                                'class' => 'btn-sm btn-primary btn-block', 
                                                'data'=> [
                                                    'confirm' => 'Adakah anda pasti ingin menjana surat ini kepada pemohon?'
                                                    ]
                                                ]);
                                        } else {
                                            return Html::button('<i class="fa fa-check" aria-hidden="true"></i>', ['class' => 'btn-sm btn-success btn-block', 'disabled' => true] );
                                        }
                                    } else {
                                        return "";
                                    }
                                } else {

                                    // if (!$data->suratLulus->date_pl){ 
                                    //     return Html::a('<i class="fa fa-hand-pointer-o" aria-hidden="true"></i>',
                                    //             ["idp/jana-surat-kursus-luar", 'id' => $data->permohonanID],
                                    //             [
                                    //         'class' => 'btn-sm btn-primary btn-block', 
                                    //         'data'=> [
                                    //             'confirm' => 'Adakah anda pasti ingin menjana surat ini kepada pemohon?'
                                    //             ]
                                    //         ]);
                                    // } else {
                                    //     return Html::button('<i class="fa fa-check" aria-hidden="true"></i>', ['class' => 'btn-sm btn-success btn-block', 'disabled' => true] );
                                    // }

                                    return "";
                                }
                          },
            ],

            
];
?>
<style>
/*a:link {*/
a.testLink {
  color: green;
  background-color: transparent;
  text-decoration: none;
}
a:visited {
  color: indigo;
  background-color: transparent;
  text-decoration: none;
}
a:hover {
  color: red;
  background-color: transparent;
  text-decoration: underline;
}
a:active {
  color: yellow;
  background-color: transparent;
  text-decoration: underline;
}
</style>
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
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h5>Senarai Permohonan Kursus Anjuran Agensi Luar <h3><span class="label label-success" style="color: white">DILULUSKAN</span></h3></h5>
            <h5><h3><span class="label label-primary" style="color: white"><?php if ($type == 'aka'){ echo 'Akademik';} elseif($type == 'pen') { echo 'Pentadbiran';} else { echo 'DILULUSKAN';}?></span></h3></h5>
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
                    'dataProvider' => $dataProviderKursusLuar,
                    'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsKursusLuar,
                ]);
            ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>    
</div>