<?php
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use app\models\myidp\PermohonanMataIdpIndividu;
use app\models\hronline\Department;

echo $this->render('/idp/_topmenu');

$dataProviderSah->pagination->pageParam = 'p-page';
//$dataProviderSah->sort->sortParam = 'p-sort';

$dataProviderBatal->pagination->pageParam = 'a-page';
//$dataProviderBatal->sort->sortParam = 'a-sort';

$dataProviderSemak->pagination->pageParam = 'b-page';
//$dataProviderSemak->sort->sortParam = 'b-sort';

//this to sort different data provider in one page

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

$("#modal").on('hidden.bs.modal', function(){
       $("html").css({"overflow":"auto"});
  });

$("#mod").on('hidden.bs.modal', function(){
       $("html").css({"overflow":"hidden"});
       $('#modal').css({"overflow":"auto"});
  });
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
                            
$gridColumnsSah = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ],
//            [
//                'label' => 'Nama',
//                //'value' => ucwords(strtolower('biodata.CONm')),
//                'attribute' => 'pemohonID',
//                'value' => function ($data){
//                            return ucwords(strtolower($data->biodata->CONm));
//                            },
//                'headerOptions' => ['style' => 'width:250px'],
//                'filter'    => $senarai,
//                                            
//            ],
            [
                'attribute' => 'CONm',
                'contentOptions' => ['style' => 'width:400px;'],
                'filterInputOptions' => [
                    'class'  => 'form-control',
                    'placeholder' => 'Cari...'
                ],
                'label' => 'Nama',
                'value' => function ($data){
                                return ucwords(strtolower($data->biodata->CONm));
                           },
                'filter'    => ArrayHelper::map(PermohonanMataIdpIndividu::find()
                        ->joinWith('biodata.jawatan')
                        ->where(['statusPermohonan' => '2', 'job_category' => $type])
                        ->all(), 'pemohonID', 'biodata.CONm'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
            ],
            [
                'attribute' => 'DeptId',
//                'contentOptions' => ['style' => 'width:400px;'],
                'label' => 'JFPIU',
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
//            [
//                'label' => 'Program',
//                'value' => function ($data){
//                            return ucwords(strtolower($data->namaProgram));
//                            },
//                'headerOptions' => ['style' => 'width:150px'],
//            ],
            [
                'attribute' => 'program',
                'contentOptions' => ['style' => 'width:400px;'],
                'filterInputOptions' => [
                    'class'  => 'form-control',
                    'placeholder' => 'Cari...'
                ],
                'label' => 'Program',
                'value' => function ($data){
                                return ucwords(strtolower($data->namaProgram));
                           },
            ],
            [
                'label' => 'Tarikh',
                'format' => 'raw',
                'value' => function ($model){               
                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
                                    
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                                    $formatteddate = $myDateTime->format('d/m/Y');
                                    
                                    if ($model->tarikhTamat != null){
                                        $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhTamat);
                                        $formatteddate2 = $myDateTime2->format('d/m/Y');
                                    } else {
                                        $formatteddate2 = '';
                                    }
                                    
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
            [
                'header' => 'Kompetensi <br> Dipohon',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->kompetensii;
                            }
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
                'value'=> function ($data){
                
                                    return Html::a('<i class="fa fa-edit"></i>', 
                                            ["idp/tindakan-semakan-ul", 
                                                'permohonanID' => $data->permohonanID]).'&nbsp;'.
                                            Html::button('<i class="fa fa-window-close" aria-hidden="true"></i>', [
                                                'id' => 'modalButton', 
                                                'value' => \yii\helpers\Url::to(['batal-permohonan', 
                                                    'id' => $data->permohonanID,
                                                    'idB' => 'belumBatal']),
                                                'class' => 'btn btn-sm btn-danger mapBtn'
                                                ]);
                          },
                'headerOptions' => ['style' => 'width:100px'],
            ],                     
];
                          
$gridColumnsSemak = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ],
            [
                'attribute' => 'CONm2',
                'contentOptions' => ['style' => 'width:400px;'],
                'filterInputOptions' => [
                    'class'  => 'form-control',
                    'placeholder' => 'Cari...'
                ],
                'label' => 'Nama',
                'value' => function ($data){
                                return ucwords(strtolower($data->biodata->CONm));
                           },
                'filter'    => ArrayHelper::map(PermohonanMataIdpIndividu::find()
                        ->joinWith('biodata.jawatan')
                        ->where(['statusUL' => '1', 'job_category' => $type])
                        ->all(), 'pemohonID', 'biodata.CONm'),
                'filterType' => GridView::FILTER_SELECT2,
            ],
            [
                'attribute' => 'DeptId2',
//                'contentOptions' => ['style' => 'width:400px;'],
                'label' => 'JFPIU',
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
                'attribute' => 'program2',
                'contentOptions' => ['style' => 'width:400px;'],
                'filterInputOptions' => [
                    'class'  => 'form-control',
                    'placeholder' => 'Cari...'
                ],
                'label' => 'Program',
                'value' => function ($data){
                                return ucwords(strtolower($data->namaProgram));
                           },
            ],
            [
                'label' => 'Tarikh',
                'format' => 'raw',
                'value' => function ($model){               
                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
                                    
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                                    $formatteddate = $myDateTime->format('d/m/Y');
                                    
                                    if ($model->tarikhTamat != null){
                                        $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhTamat);
                                        $formatteddate2 = $myDateTime2->format('d/m/Y');
                                    } else {
                                        $formatteddate2 = '';
                                    }
                                    
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
            [
                'header' => 'Kompetensi <br> Dipohon',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->kompetensii;
                            }
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
                'value'=> function ($data){
                                //return Html::a('<i class="fa fa-hand-o-right" aria-hidden="true"></i> PESERTA', ['value' => 'borangsemakanpeserta?id='.$lat2->kursusLatihanID, 'class' => 'btn-sm btn-primary btn-block']);
                                
                                //if ($data->tarikhSemakanKJ){
                
                                    return Html::a('<i class="fa fa-eye">', ["idp/tindakan-semakan-ul", 'permohonanID' => $data->permohonanID]);
                                //} 
                          },
                'headerOptions' => ['style' => 'width:100px'],
            ],
            [
                'attribute' => 'statusPermohonan',
                'label' => 'Status Permohonan',
                'format' => 'raw',
                'value' => 'statusPermohonann',
                'filter'    => [ 
                    3 => "MENUNGGU PERAKUAN",
                    4 => "MENUNGGU KELULUSAN",
                    5 => "PERMOHONAN DITOLAK",
                    6 => "PERMOHONAN BERJAYA"],
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen
            ]
                       
]; 
                          
$gridColumnsBatal = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ],
            [
                'attribute' => 'CONm3',
                'contentOptions' => ['style' => 'width:400px;'],
                'filterInputOptions' => [
                    'class'  => 'form-control',
                    'placeholder' => 'Cari...'
                ],
                'label' => 'Nama',
                'value' => function ($data){
                                return ucwords(strtolower($data->biodata->CONm));
                           },
                'filter'    => ArrayHelper::map(PermohonanMataIdpIndividu::find()
                        ->joinWith('biodata.jawatan')
                        ->where(['statusPermohonan' => '11', 'job_category' => $type])
                        ->all(), 'pemohonID', 'biodata.CONm'),
                'filterType' => GridView::FILTER_SELECT2,
            ],
            [
                'attribute' => 'DeptId3',
//                'contentOptions' => ['style' => 'width:400px;'],
                'label' => 'JFPIU',
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
                'attribute' => 'program3',
                'contentOptions' => ['style' => 'width:400px;'],
                'filterInputOptions' => [
                    'class'  => 'form-control',
                    'placeholder' => 'Cari...'
                ],
                'label' => 'Program',
                'value' => function ($data){
                                return ucwords(strtolower($data->namaProgram));
                           },
            ],       
            [
                'header' => 'Kompetensi <br> Dipohon',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->kompetensii;
                            }
            ],
            [
                'header' => 'Tarikh Dibatalkan',
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhBatalPermohonan;
                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                return $formatteddate;
                            }
            ],
            [
                'header' => 'Dibatalkan <br> Oleh',
//                'value' => ucwords(strtolower('biodata.CONm')),
//                'value' => function ($data){
//                            return ucwords(strtolower($data->pembatal->CONm));
//                            },
                'format' => 'raw',
                'value' => function ($data){
                            return $data->pembatall;
                            },
                'headerOptions' => ['style' => 'width:150px'],
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
                'value'=> function ($data){
                
                                    return Html::button('<i class="fa fa-window-close" aria-hidden="true"></i>', [
                                                'id' => 'modalButton', 
                                                'value' => \yii\helpers\Url::to(['batal-permohonan', 
                                                    'id' => $data->permohonanID,
                                                    'idB' => 'sudahBatal']),
                                                'class' => 'btn btn-sm btn-danger mapBtn'
                                                ]);
                          },
                'headerOptions' => ['style' => 'width:100px'],
            ],
                       
]; 
            
?>
<style>
    .modal-dialog{
        width: 70%;
        margin : auto;
       
    }
</style>
<!--<div class="clearfix"></div>
<div class="row">
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
<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">      
        <div>
            <h5>Senarai Permohonan Mata IDP <h3><span class="label label-danger" style="color: white"><?php if ($type == '1'){ echo 'Akademik';} else { echo 'Pentadbiran';}?></span></h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h5><h3><span class="label label-primary" style="color: white">BARU</span>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            </h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <?php 
            
            Pjax::begin([
                    // PJax options
                ]); 
            echo GridView::widget([
                    'options' => ['class' => 'table-responsive'],
                    'dataProvider' => $dataProviderSah,
                    'filterModel' => $searchModel,
                    'emptyText' => 'Tiada permohonan ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsSah,
                ]);
            Pjax::end();
            ?>
        </div>
        </div>
    </div>
</div>
                       
<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h5><h3><span class="label label-success" style="color: white">DISEMAK</span>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            </h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <?php 
            
            Pjax::begin([
                    // PJax options
                ]); 
                echo GridView::widget([
                    'dataProvider' => $dataProviderSemak,
                    'filterModel' => $searchModelSemak,
                    'emptyText' => 'Tiada permohonan ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsSemak,
                ]);
            Pjax::end();
            ?>
        </div>
        </div>
    </div>
</div>

<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h5><h3><span class="label label-danger" style="color: white">DIBATALKAN</span>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            </h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <?php 
            
            Pjax::begin([
                    // PJax options
                ]); 
                echo GridView::widget([
                    'dataProvider' => $dataProviderBatal,
                    'filterModel' => $searchModelBatal,
                    'emptyText' => 'Tiada permohonan ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsBatal,
                ]);
            Pjax::end();
            ?>
        </div>
        </div>
    </div>
</div>

</div>
    </div>
</div>    
</div>
    