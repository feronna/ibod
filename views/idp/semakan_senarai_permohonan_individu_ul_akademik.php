<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

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
                'label' => 'Nama',
                //'value' => ucwords(strtolower('biodata.CONm')),
                'attribute' => 'pemohonID',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->CONm));
                            },
                'headerOptions' => ['style' => 'width:250px'],
                'filter'    => $senarai,
            ],
            [
                'label' => 'Program',
                'value' => function ($data){
                            return ucwords(strtolower($data->namaProgram));
                            },
                'headerOptions' => ['style' => 'width:150px'],
            ],
            [
                'label' => 'Tarikh',
                'format' => 'raw',
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
//            [
//                'header' => 'Tempat',
//                'value' => function ($data){
//                            return ucwords(strtolower($data->lokasi));
//                            },
//                 'headerOptions' => ['style' => 'width:40px'],
//            ],
            [
                'label' => 'Anjuran',
                'value' => function ($data){
                            return ucwords(strtolower($data->penganjur)).' - '.ucwords(strtoupper($data->namaPenganjur));
                            }
            ],
            
            [
                'header' => 'Kompetensi <br> Dipohon',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->kompetensii;
                            }
            ],
            [
                'header' => 'Tarikh Pohon',
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhPohon;
                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                return $formatteddate;
                            }
            ],
            [
                'header' => 'Tarikh <br> Pengesahan',
                'format' => 'raw',
                'value' => function ($data){
                              
                              if ($data->tarikhSemakanKJ){
                                    $tarikhKursus = $data->tarikhSemakanKJ;
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                    $formatteddate = $myDateTime->format('d-m-Y');
                                
                                    return ucwords(strtolower($formatteddate));
                              
                              }
                            },
                'headerOptions' => ['style' => 'width:100px'],
                //'visible' => Yii::$app->user->can('supervisor'),
                //'visible' => 'Condition' ? true : false
            ],
//            [
//                'label' => 'Status',
//                'format' => 'raw',
//                'value' => 'statusPermohonann'
//            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
                'value'=> function ($data){
                                //return Html::a('<i class="fa fa-hand-o-right" aria-hidden="true"></i> PESERTA', ['value' => 'borangsemakanpeserta?id='.$lat2->kursusLatihanID, 'class' => 'btn-sm btn-primary btn-block']);
                                
                                if ($data->tarikhSemakanKJ){
                
                                    $a = Html::a('<i class="fa fa-edit">', ["idp/tindakan-semakan-ul", 'permohonanID' => $data->permohonanID]);
                                    
                                    return $a;
                                } 
                          },
                'headerOptions' => ['style' => 'width:100px'],
            ],
            [
                'header' => 'Batal <br> Permohonan',
                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
                'value'=> function ($data){
                                //return Html::a('<i class="fa fa-hand-o-right" aria-hidden="true"></i> PESERTA', ['value' => 'borangsemakanpeserta?id='.$lat2->kursusLatihanID, 'class' => 'btn-sm btn-primary btn-block']);
                                
                                if ($data->tarikhBatalPermohonan){
                
                                    $a = Html::button('TARIKH BATAL : '.$data->tarikhBatalPermohonan, [
                                                'id' => 'modalButton', 
                                                'value' => \yii\helpers\Url::to(['batal-permohonan', 
                                                    'id' => $data->permohonanID,
                                                    'idB' => 'sudahBatal']),
                                                'class' => 'btn btn-sm btn-primary mapBtn'
                                                ]);
                                } else {
                                    
                                    $a = Html::button('BATAL PERMOHONAN <i class="fa fa-exclamation-triangle"></i>', [
                                                'id' => 'modalButton', 
                                                'value' => \yii\helpers\Url::to(['batal-permohonan', 
                                                    'id' => $data->permohonanID,
                                                    'idB' => 'belumBatal']),
                                                'class' => 'btn btn-sm btn-danger mapBtn'
                                                ]);
                                }
                                
                                return $a;
                          },
                'headerOptions' => ['style' => 'width:100px'],
            ],
                       
];
                          
$gridColumnsSemak = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ],
            [
                'label' => 'Nama',
                //'value' => ucwords(strtolower('biodata.CONm')),
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->CONm));
                            },
                'headerOptions' => ['style' => 'width:150px'],
            ],
            [
                'label' => 'Program',
                'value' => function ($data){
                            return ucwords(strtolower($data->namaProgram));
                            },
                'headerOptions' => ['style' => 'width:150px'],
            ],
            [
                'label' => 'Tarikh',
                'format' => 'raw',
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
//            [
//                'header' => 'Tempat',
//                'value' => function ($data){
//                            return ucwords(strtolower($data->lokasi));
//                            },
//                 'headerOptions' => ['style' => 'width:40px'],
//            ],
            [
                'label' => 'Anjuran',
                'value' => function ($data){
                            return ucwords(strtolower($data->penganjur)).' - '.ucwords(strtoupper($data->namaPenganjur));
                            }
            ],           
            [
                'header' => 'Kompetensi <br> Dipohon',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->kompetensii;
                            }
            ],
            [
                'header' => 'Tarikh <br> Pohon',
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhPohon;
                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                return $formatteddate;
                            }
            ],
            [
                'header' => 'Tarikh <br> Pengesahan',
                'format' => 'raw',
                'value' => function ($data){
                              
                              if ($data->tarikhSemakanKJ){
                                    $tarikhKursus = $data->tarikhSemakanKJ;
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                    $formatteddate = $myDateTime->format('d-m-Y');
                                
                                    return ucwords(strtolower($formatteddate));
                              
                              }
                            },
                'headerOptions' => ['style' => 'width:100px'],
                //'visible' => Yii::$app->user->can('supervisor'),
                //'visible' => 'Condition' ? true : false
            ],
//            [
//                'label' => 'Status',
//                'format' => 'raw',
//                'value' => 'statusPermohonann'
//            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
                'value'=> function ($data){
                                //return Html::a('<i class="fa fa-hand-o-right" aria-hidden="true"></i> PESERTA', ['value' => 'borangsemakanpeserta?id='.$lat2->kursusLatihanID, 'class' => 'btn-sm btn-primary btn-block']);
                                
                                if ($data->tarikhSemakanKJ){
                
                                    return Html::a('<i class="fa fa-eye">', ["idp/tindakan-semakan-ul", 'permohonanID' => $data->permohonanID]);
                                } 
                          },
                'headerOptions' => ['style' => 'width:100px'],
            ]
                       
];
                          
$gridColumnsBatal = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ],
            [
                'label' => 'Nama',
                //'value' => ucwords(strtolower('biodata.CONm')),
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->CONm));
                            },
                'headerOptions' => ['style' => 'width:150px'],
            ],
            [
                'label' => 'Program',
                'value' => function ($data){
                            return ucwords(strtolower($data->namaProgram));
                            },
                'headerOptions' => ['style' => 'width:150px'],
            ],
            [
                'label' => 'Tarikh',
                'format' => 'raw',
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
//            [
//                'header' => 'Tempat',
//                'value' => function ($data){
//                            return ucwords(strtolower($data->lokasi));
//                            },
//                 'headerOptions' => ['style' => 'width:40px'],
//            ],
            [
                'label' => 'Anjuran',
                'value' => function ($data){
                            return ucwords(strtolower($data->penganjur)).' - '.ucwords(strtoupper($data->namaPenganjur));
                            }
            ],
            
            [
                'header' => 'Kompetensi <br> Dipohon',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->kompetensii;
                            }
            ],
            [
                'header' => 'Tarikh <br> Pohon',
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhPohon;
                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                return $formatteddate;
                            }
            ],
            [
                'header' => 'Tarikh <br> Pengesahan',
                'format' => 'raw',
                'value' => function ($data){
                              
                              if ($data->tarikhSemakanKJ){
                                    $tarikhKursus = $data->tarikhSemakanKJ;
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                    $formatteddate = $myDateTime->format('d-m-Y');
                                
                                    return ucwords(strtolower($formatteddate));
                              
                              }
                            },
                'headerOptions' => ['style' => 'width:100px'],
                //'visible' => Yii::$app->user->can('supervisor'),
                //'visible' => 'Condition' ? true : false
            ],
            [
                'header' => 'Tarikh <br> Dibatalkan',
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
                                //return Html::a('<i class="fa fa-hand-o-right" aria-hidden="true"></i> PESERTA', ['value' => 'borangsemakanpeserta?id='.$lat2->kursusLatihanID, 'class' => 'btn-sm btn-primary btn-block']);
                                
                                //if ($data->tarikhSemakanKJ){
                
                                    return Html::a('<i class="fa fa-eye">', ["idp/tindakan-semakan-ul", 'permohonanID' => $data->permohonanID]);
                                //} 
                          },
                'headerOptions' => ['style' => 'width:100px'],
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
    <div class="x_panel">      
        <div class="x_title">
            <h5>Senarai Permohonan Mata IDP <h3><span class="label label-danger" style="color: white">BARU</span>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            </h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <?php
//                GridView::widget([
//                    'dataProvider' => $dataProviderSah,
//                    'emptyText' => 'Tiada permohonan ditemui.',
//                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
//                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
//                    'columns' => $gridColumnsSah,
//                ]);

                Pjax::begin([
                    // PJax options
                ]); 
                echo GridView::widget([
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
            <h5>Senarai Permohonan Mata IDP <h3><span class="label label-success" style="color: white">DISEMAK</span>
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

<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h5>Senarai Permohonan Mata IDP <h3><span class="label label-danger" style="color: white">DIBATALKAN</span>
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
                    'dataProvider' => $dataProviderBatal,
                    'emptyText' => 'Tiada permohonan ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsBatal,
                ]);
            ?>
        </div>
        </div>
    </div>
</div>
    