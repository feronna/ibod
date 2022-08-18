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
$dataProviderSah->sort->sortParam = 'p-sort';

$dataProviderSemak->pagination->pageParam = 'b-page';
$dataProviderSemak->sort->sortParam = 'b-sort';

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
                        ->where(['statusPermohonan' => '3', 'job_category' => $type])
                        ->orWhere(['statusPermohonan' => '33', 'job_category' => $type])
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
//            [
//                'label' => 'Anjuran',
//                'value' => function ($data){
//                            return ucwords(strtolower($data->penganjur)).' - '.ucwords(strtoupper($data->namaPenganjur));
//                            }
//            ], 
            [
                'label' => 'Kompetensi Dipohon',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->kompetensii;
                            }
            ],
//            [
//                'label' => 'Tarikh Pohon',
//                'value' => function ($data){
//                                $tarikhKursus = $data->tarikhPohon;
//                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
//                                $formatteddate = $myDateTime->format('d-m-Y');
//                                return $formatteddate;
//                            }
//            ],
//            [
//                'label' => 'Tarikh Pengesahan',
//                'format' => 'raw',
//                'value' => function ($data){
//                              
//                              if ($data->tarikhSemakanKJ){
//                                    $tarikhKursus = $data->tarikhSemakanKJ;
//                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
//                                    $formatteddate = $myDateTime->format('d-m-Y');
//                                
//                                    return ucwords(strtolower($formatteddate));
//                              
//                              }
//                            },
//                'headerOptions' => ['style' => 'width:100px'],
//                //'visible' => Yii::$app->user->can('supervisor'),
//                //'visible' => 'Condition' ? true : false
//            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
                'value'=> function ($data){
                                //return Html::a('<i class="fa fa-hand-o-right" aria-hidden="true"></i> PESERTA', ['value' => 'borangsemakanpeserta?id='.$lat2->kursusLatihanID, 'class' => 'btn-sm btn-primary btn-block']);
                                
                                if ($data->tarikhSemakanKJ){
                
                                    return Html::a('<i class="fa fa-edit">', ["idp/tindakan-pengesahan-bsm", 'permohonanID' => $data->permohonanID]);
                                } 
                          },
                'headerOptions' => ['style' => 'width:100px'],
            ]
                       
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
                        ->where(['statusBSM' => '4', 'job_category' => $type])
                        ->all(), 'pemohonID', 'biodata.CONm'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
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
//            [
//                'label' => 'Tarikh',
//                'format' => 'raw',
//                'value' => function ($model){               
//                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
//                                    
//                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
//                                    $formatteddate = $myDateTime->format('d/m/Y');
//                                    
//                                    $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhTamat);
//                                    $formatteddate2 = $myDateTime2->format('d/m/Y');
//                                    
//                                    if ($formatteddate == $formatteddate2 ){
//                                        $formatteddate = $formatteddate;    
//                                    } else {
//                                        $formatteddate = $formatteddate.' - '.$formatteddate2;
//                                    }
//                                    
//                                } else {
//                                    $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
//                                } 
//                                return $formatteddate;
//                            },
//            ],
//            [
//                'label' => 'Tempat',
//                'value' => function ($data){
//                            return ucwords(strtolower($data->lokasi));
//                            }
//            ],
//            [
//                'label' => 'Anjuran',
//                'value' => function ($data){
//                            return ucwords(strtolower($data->penganjur)).' - '.ucwords(strtoupper($data->namaPenganjur));
//                            }
//            ],
            
            [
                'label' => 'Kompetensi Dipohon',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->kompetensii;
                            }
            ],
//            [
//                'label' => 'Tarikh Pohon',
//                'value' => function ($data){
//                                $tarikhKursus = $data->tarikhPohon;
//                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
//                                $formatteddate = $myDateTime->format('d-m-Y');
//                                return $formatteddate;
//                            }
//            ],
//            [
//                'label' => 'Tarikh Pengesahan',
//                'format' => 'raw',
//                'value' => function ($data){
//                              
//                              if ($data->tarikhSemakanKJ){
//                                    $tarikhKursus = $data->tarikhSemakanKJ;
//                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
//                                    $formatteddate = $myDateTime->format('d-m-Y');
//                                
//                                    return ucwords(strtolower($formatteddate));
//                              
//                              }
//                            },
//                'headerOptions' => ['style' => 'width:100px'],
//                //'visible' => Yii::$app->user->can('supervisor'),
//                //'visible' => 'Condition' ? true : false
//            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
                'value'=> function ($data){
                                //return Html::a('<i class="fa fa-hand-o-right" aria-hidden="true"></i> PESERTA', ['value' => 'borangsemakanpeserta?id='.$lat2->kursusLatihanID, 'class' => 'btn-sm btn-primary btn-block']);
                                
                                if ($data->tarikhSemakanKJ){
                
                                    return Html::a('<i class="fa fa-eye">', ["idp/tindakan-pengesahan-bsm", 'permohonanID' => $data->permohonanID]);
                                } 
                          },
                'headerOptions' => ['style' => 'width:100px'],
            ],
            [
                'attribute' => 'statusPermohonan',
                'label' => 'Status Permohonan',
                'format' => 'raw',
                'value' => 'statusPermohonann',
                'filter'    => [ 
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
            <h5><h3><span class="label label-primary" style="color: white">MENUNGGU PERAKUAN</span>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            </h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderSah,
                    'filterModel' => $searchModel,
                    'emptyText' => 'Tiada permohonan ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsSah,
                ]);
            ?>
        </div>
        </div>
    </div>
</div>
            
            
            
<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h5><h3><span class="label label-success" style="color: white">DIPERAKUKAN</span>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            </h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderSemak,
                    'filterModel' => $searchModelSemak,
                    'emptyText' => 'Tiada permohonan ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsSemak,
                ]);
            ?>
        </div>
        </div>
    </div>
</div>
    
</div>
    </div>
</div>
</div>