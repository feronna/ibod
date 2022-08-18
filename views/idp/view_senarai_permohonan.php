<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\select2\Select2;

echo $this->render('/idp/_topmenu');

error_reporting(0);

$gridColumns = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',           
            ],  
            [
                'label' => 'Kursus',
                'value' => function ($data){
                            return strtoupper($data->sasaran3->tajukLatihan);
                            }
            ],
            [
                'label' => 'Siri',
                'hAlign' => 'center',
                'value' => function ($data){
                            return ucwords(strtolower($data->sasaran6->siri));
                            },                
            ],
            [
                'header' => 'Tarikh',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($model){               
                                if (($model->sasaran6->tarikhMula != null) && ($model->sasaran6->tarikhMula != 0000-00-00)){
                                    
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->sasaran6->tarikhMula);
                                    $formatteddate = $myDateTime->format('d/m/Y');
                                    
                                    $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->sasaran6->tarikhAkhir);
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
                'headerOptions' => ['style' => 'width:100px'],
            ],
//            [
//                'label' => 'Bahan',
//                'format' => 'raw',
////                'value' => function ($data){
////                    if ($data->sasaran8->filename){
////                        foreach ($data->sasaran8->filename as $files) {
////                            //return Html::a(Yii::$app->FileManager->NameFile($data->sasaran6->filename), ('https://mediahost.ums.edu.my/api/v1/viewFile/'.$data->sasaran6->filename));
////                            return Html::a(Yii::$app->FileManager->NameFile($files), ('https://mediahost.ums.edu.my/api/v1/viewFile/'.$files));
////                        }
////                    } else {
////                        return "TIADA BAHAN";
////                    }
////                },
//                        'value' => function ($data){
//                            $datalist = [];
//                            if ($data->sasaran8){
//                                foreach ($data->sasaran8 as $files) {
//                                    $a =  Html::a(Yii::$app->FileManager->NameFile($files->filename), Yii::$app->FileManager->DisplayFile($files->filename)).'<br>';
//                                    array_push($datalist, $a); 
//                                }
//                            } else {
//                                return "TIADA BAHAN";
//                            }
//                            $all = " ";
//                            $b = count($datalist);
//                            for($i = 0; $i < count($datalist); $i++){
//                                $all = $b.') '.$datalist[$i].$all;
//                                $b--;
//                            }
//                            return $all;
//                },
//            ],
            [
                'header' => 'Pengesahan Kehadiran',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($data){
                                
                                    if ($data->sahHadirbyStaf != NULL) {
                                        //$a = $data->sahHadirbyStaf;
                                        //$a = Html::a($data->tarikhSahKehadiran, ["idp/sahhadir", 'id' => $data->kursusLatihanID], ['class' => 'btn btn-sm btn-primary disabled'] );

                                        if ($data->sahHadirbyStaf == 'TIDAK'){
                                            $a = Html::button('TELAH SAHKAN KETIDAKHADIRAN', [
                                                        'id' => 'modalButton', 
                                                        'value' => \yii\helpers\Url::to(['sahhadir', 
                                                            'id' => $data->kursusLatihanID,
                                                            'idB' => 'sudahSahHadir']),
                                                        'class' => 'btn btn-sm btn-danger mapBtn'
                                                        ]);
                                        } elseif ($data->sahHadirbyStaf == 'YA'){
                                            $a = Html::button('TELAH SAHKAN KEHADIRAN', [
                                                        'id' => 'modalButton', 
                                                        'value' => \yii\helpers\Url::to(['sahhadir', 
                                                            'id' => $data->kursusLatihanID,
                                                            'idB' => 'sudahSahHadir']),
                                                        'class' => 'btn btn-sm btn-success mapBtn',
                                                        'disabled' => true,
                                                        ]);
                                        }
                                        
                                    } else {

                                        if ($data->checkBorangpl != NULL) {
                                            //$a = $data->sahHadirbyStaf;
                                            $a = Html::a('LENGKAPKAN BORANG PENILAIAN TERDAHULU', ["idp/sahhadir", 'id' => $data->kursusLatihanID], ['class' => 'btn btn-sm btn-primary disabled',
                                                'title' => 'Sila lengkapkan borang penilaian latihan bagi kursus terdahulu.',
                                                'data-toggle' => 'tooltip'] );
                                        } else {
                                            
                                            if ($data->sasaran6->statusSiriLatihan != 'SEDANG BERJALAN'){
                                            
                                            
                                                //$a = Html::a('SILA SAHKAN KEHADIRAN ANDA', ["idp/sahhadir", 'id' => $data->kursusLatihanID], ['class' => 'btn btn-sm btn-primary'] );
                                                $a = Html::button('SAHKAN KEHADIRAN <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>', [
                                                        'id' => 'modalButton', 
                                                        'value' => \yii\helpers\Url::to(['sahhadir', 
                                                            'id' => $data->kursusLatihanID,
                                                            'idB' => 'belumSahHadir']),
                                                        'class' => 'btn btn-sm btn-primary mapBtn'
                                                        ]);
                                            
                                            } else {
                                                $a = '';
                                            }


                                        }
                                    }
                    
                                return $a;
                            }
            ],
            [
                'header' => 'Penilaian <br> Latihan',
                'hAlign' => 'center',
                'format' => 'raw',
                'value'=> function ($data){
                
                if ($data->sasaran6) {
                            if ($data->sasaran6->CheckPastProgram() == 0 && $data->sasaran6->statusSiriLatihan == "SEDANG BERJALAN") {

                                if ($data->sasaran6->sasaran5->sasaran55->kategoriKursusID == 1
                                        || $data->sasaran6->sasaran5->sasaran55->kategoriKursusID == 0 ) {
                                        return Html::button('<i class="fa fa-ban" aria-hidden="true"></i>', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true]);
                                } else {
                                
                                        if ($data->checkHadir){
                                                if ($data->CheckBorangStatus($data->siriLatihanID) == 2) {
                                                    //return Html::button('<i class="fa fa-check" aria-hidden="true"></i>', ['value' => 'borangpenilaianlatihan?id='.$data->siriLatihanID, 'class' => 'mapBtn btn-sm btn-success btn-block']);
                                                    return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', 'borangpenilaianlatihan?id='.$data->siriLatihanID.'&pesertaID='.Yii::$app->user->getId().'&type=2', [  
                                                      'title' => Yii::t('app', 'Papar Borang'),
                                                      'data-pjax' => 0,
                                                      'target' => "_blank",
                                                      'class' => 'btn-sm btn-success btn-block text-center'
                                                    ]);
                                                } else {
                                                    //return Html::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['value' => 'borangpenilaianlatihan?id='.$data->siriLatihanID, 'class' => 'mapBtn btn-sm btn-primary btn-block']);
                                                    return Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'borangpenilaianlatihan?id='.$data->siriLatihanID.'&pesertaID='.Yii::$app->user->getId().'&type=2', [
                                                      'title' => Yii::t('app', 'Papar Borang'),
                                                      'data-pjax' => 0,
                                                      'target' => "_blank",
                                                      'class' => 'btn-sm btn-primary btn-block text-center'
                                                    ]);
                                                }
                                        } else {
                                            return Html::button('BELUM HADIR', ['class' => 'btn-sm btn-warning btn-block', 'disabled' => true]);
                                            //return Html::button('Press me!', ['class' => 'teaser', 'title' => 'TEST']);
                                        }
                                }
                            } else {
                                return Html::button('BELUM DIJALANKAN', ['class' => 'btn-sm btn-info btn-block', 'disabled' => true]);
                            }
                } else {
                    return Html::button('RALAT <i class="fa fa-exclamation-triangle"></i>', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true]);
                }
                          },
            ],
            [
                'label' => 'Slip',
                'hAlign' => 'center',
                'format' => 'raw',
                'value'=> function ($data){

//                            if ($data->checkHadir){
//                                return Html::button('<i class="fa fa-pencil" aria-hidden="true"></i> BORANG PENILAIAN LATIHAN', ['value' => 'borangpenilaianlatihan?id='.$data->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-danger btn-block']);
//                            } else {
                                return Html::a('<i class="fa fa-download" aria-hidden="true"></i>', ['slip-jemputan?id='.$data->siriLatihanID], ['class' => 'btn-sm btn-default btn-block', 'target' => '_blank']);
                            //}
                          },
            ],
            [
                'label' => 'Pautan',
                'hAlign' => 'center',
                'format' => 'raw',
                'value'=> function ($data){
                              
                              if ($data->sasaran6->linkZoom){
                                return Html::a('<i class="fa fa-video-camera" aria-hidden="true" text-align="center"></i>', $data->sasaran6->linkZoom, ['class' => 'btn-sm btn-info btn-block', 'target' => '_blank']);
                              } else {
                                return Html::button('<i class="fa fa-ban" aria-hidden="true"></i>', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true]);
                              }
                          },
            ],
            
];

$gridColumnsA = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ],  
            [
                'label' => 'Kursus',
                'value' => function ($data){
                            return strtoupper($data->sasaran3->tajukLatihan);
                            }
            ],
            [
                'label' => 'Siri',
                'hAlign' => 'center',
                'value' => function ($data){
                            return $data->sasaran6->siri;
                            }
            ],
            [
                'label' => 'Tarikh',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($model){               
                                if (($model->sasaran6->tarikhMula != null) && ($model->sasaran6->tarikhMula != 0000-00-00)){
                                    
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->sasaran6->tarikhMula);
                                    $formatteddate = $myDateTime->format('d/m/Y');
                                    
                                    $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->sasaran6->tarikhAkhir);
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
            [
                'label' => 'Lokasi ',
                'format' => 'raw',
                'value'=> 'sasaran6.lokasi',
            ],
            [
                'label' => 'Kampus',
                'format' => 'raw',
                'value' => 'sasaran6.campusName.campus_name',
            ],
            [
                'label' => 'Mata IDP',
                'format' => 'raw',
                'value' => 'sasaran6.jumlahMataIDP',
            ],
            [
                'label' => 'Tarikh Pohon',
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhPermohonan;
                                $myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                return $formatteddate;
                            }
            ],
            [
                'label' => 'Status',
                'format' => 'raw',
                'value' => function ($data){
                
                                if ($data->statusPermohonan == 'BARU') {
                                    $a = '<span class="label label-default">BARU</span>';   
                                } elseif ($data->statusPermohonan == 'DIPERAKUI') {
                                    $a = '<span class="label label-info">DIPERAKUI</span>';
                                } elseif ($data->statusPermohonan == 'DILULUSKAN') {
                                    $a = '<span class="label label-success">LULUS</span>';
                                } elseif ($data->statusPermohonan == 'TIDAK DIPERAKUI') {
                                    $a = '<span class="label label-danger">TIDAK DIPERAKUI</span>';
                                } elseif ($data->statusPermohonan == 'TIDAK DILULUSKAN') {
                                    $a = '<span class="label label-danger">TIDAK DILULUSKAN</span>';
                                } elseif ($data->statusPermohonan == 'JEMPUTAN') {
                                    $a = '<span class="label label-primary">JEMPUTAN</span>';
                                }
                    
                                return $a;
                            }
            ],
            [
                'label' => 'Tarikh Diperaku',
                'value' => function ($data){
                
                            if ($data->tarikhDiperakukan){
                                $tarikhKursus = $data->tarikhDiperakukan;
                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                return $formatteddate;
                            } else {
                                return '';
                            }
                }
            ],
            
];
            
$gridColumnsLatihanLuar = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ], 
            [
                'label' => 'Program',
                'value' => function ($data){
                            return strtoupper($data->namaProgram);
                            }
            ],
            [
                'label' => 'Tarikh Pohon',
                'hAlign' => 'center',
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhPohon;
                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                return $formatteddate;
                            }
            ],
            [
                'label' => 'Status',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => 'statusPermohonann'
            ],
            ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Tindakan',
                            'headerOptions' => ['class' => 'kartik-sheet-style'],
                            'template' => '{view}',
                            'buttons' => [
                              'view' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                              'title' => Yii::t('app', 'Papar'),
                                  ]);
                              },

//                              'update' => function ($url, $model) {
//                                  return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
//                                              'title' => Yii::t('app', 'Kemaskini'),
//                                  ]);
//                              },
//                              'delete' => function ($url, $model) {
//                                  return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
//                                          ['data' => [
//                                              'confirm' => 'Adakah anda pasti anda ingin membatalkan permohonan ini?',
//                                              'method' => 'post',
//                                              ],
//                                          ],
//                                          ['title' => Yii::t('app', 'Hapus'),]);     
//                              },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                              if ($action === 'view') {
                                  $url ='view-latihan-luar-pohon?permohonanID='.$model->permohonanID.'&userLevel=user&update=NO';
                                  return $url;
                            }

//                              if ($action === 'update') {
//                                  $url ='update-latihan-luaran-pohon?id='.$model->permohonanID;
//                                  return $url;
//                              }
//                              if ($action === 'delete') {
//                                  $url ='delete-latihan-luaran-pohon?id='.$model->permohonanID; 
//                                  return $url;
//                              }
                            }
                      ],
            
];
                       
?>
<style>
    .modal-dialog{
        width: 70%;
        margin : auto;
       
    }
</style>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
                <h4>Panduan</h4>
                <div class="clearfix"></div>
        </div>
        <ul>
            <li><span class="label label-default">BARU</span> : Permohonan Baru</li>
            <li><span class="label label-info">DIPERAKUI</span> : Permohonan Telah Diperakui Oleh Pegawai Pelulus Kursus</li>  
            <li><span class="label label-success">LULUS</span> : Permohonan Telah Diluluskan Oleh BSM/Ketua JFPIB</li>
            <li><span class="label label-danger">TIDAK DIPERAKUI</span> : Permohonan Tidak Diperakui</li>
            <li><span class="label label-danger">TIDAK DILULUSKAN</span> : Permohonan Tidak Diluluskan</li>
            <li><span class="label label-primary">JEMPUTAN</span> : Permohonan Jemputan Wajib</li> 
        </ul>
    </div>
    </div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">      
        <div class="x_title">
                <h2>Senarai Permohonan Kursus Anjuran Dalaman</h2>
                <div class="clearfix"></div>
        </div>
        <div class="x_content">
<!-- auto LULUS during MCO -->
<!-- hide permohonan BARU gridview -->

<!-- <div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-check-circle"></i> Permohonan <span class="label label-default" style="color: white">BARU</span></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <?php
                // GridView::widget([
                //     'dataProvider' => $dataProviderA,
                //     'emptyText' => 'Tiada permohonan ditemui.',
                //     'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                //     'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                //     'columns' => $gridColumnsA,
                // ]);
            ?>
        </div>
        </div>
    </div>
</div> -->

<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-check-circle"></i> Permohonan <span class="label label-success" style="color: white">LULUS</span></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'emptyText' => 'Tiada permohonan lulus ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
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

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">      
        <div class="x_title">
                <h2>Senarai Permohonan Kursus Anjuran Agensi Luar</h2>
                <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <div class="table-responsive">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderLatihanLuar,
                    'emptyText' => 'Tiada permohonan ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsLatihanLuar,
                ]);
            ?>
        </div>

    </div>
</div>
</div>
</div>
    