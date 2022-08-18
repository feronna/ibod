<?php
use kartik\grid\GridView;
use yii\helpers\Html;

echo $this->render('/idp/_topmenu');

error_reporting(0);

// the grid columns setup (only two column entries are shown here
// you can add more column entries you need for your use case)
$gridColumnsC = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ], 
            [
                'label' => 'Pemohon',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->CONm));
                            }
            ],
            [
                'label' => 'Kursus Dipohon',
                'value' => function ($data){
                            return strtoupper($data->sasaran3->tajukLatihan);
                            }
            ],
            // [
            //     'label' => 'Kategori',
            //     'hAlign' => 'center',
            //     'value' => function ($data){
            //                 return ucwords(strtolower($data->Kategori($data->biodata->gredJawatan))); 
            //                 }
            // ],
            [
                'label' => 'Tarikh Kursus',
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
            [
                'label' => 'Tarikh Permohonan',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhPermohonan;
                                $myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                
                                return ucwords(strtolower($formatteddate));
                            }
            ],
            [
                'label' => 'Tindakan',
                'hAlign' => 'center',
                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
                'value' => function ($data){
                            if($data->statusPermohonan === 'BARU'){
                                return Html::button('', [
                                    'id' => 'modalButton', 
                                    'value' => \yii\helpers\Url::to(['tindakan-pelulus', 
                                        'staffID' => $data->staffID, 
                                        'kursusLatihanID' => $data->kursusLatihanID]),
                                    'style'=>'background-color: transparent; border: none;', 
                                    'class' => 'fa fa-edit mapBtn'
                                    ]);
                                //Html::a('<i class="fa fa-eye">', ["kontrak/tindakan_pp", 'id' => $data->staffID, 'kursusID' => $data->kursusLatihanID]);
//                            }else{
//                                return Html::a('<i class="fa fa-eye">', ["idp/peraku", 'staffID' => $data->staffID, 'kursusLatihanID' => $data->kursusLatihanID]);
//                            }
                            } 
//                            elseif ($data->statusPermohonan === 'DIPERAKUI') {
//                                return Html::a('<i class="fa fa-eye">', ["idp/peraku", 'staffID' => $data->staffID, 'kursusLatihanID' => $data->kursusLatihanID]);
//                            } elseif ($data->statusPermohonan === 'DILULUSKAN') {
//                                return Html::a('<i class="fa fa-eye">', ["kontrak/tindakan_pp", 'staffID' => $data->staffID, 'kursusLatihanID' => $data->kursusLatihanID]);
//                            }
                        },
            ],
            
];



$gridColumns = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ], 
            [
                'label' => 'Pemohon',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->CONm));
                            }
            ],
            [
                'label' => 'Kursus Dipohon',
                'value' => function ($data){
                            return strtoupper($data->sasaran3->tajukLatihan);
                            }
            ],
            [
                'label' => 'Tarikh Kursus',
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
            [
                'label' => 'Tarikh Permohonan',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhPermohonan;
                                $myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                
                                return ucwords(strtolower($formatteddate));
                            }
            ],
            [
                'label' => 'Tarikh Perakuan',
                'hAlign' => 'center',
                'format' => 'raw',
                //'visible' => 'Condition' ? true : false,
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhDiperakukan;
                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                
                                return ucwords(strtolower($formatteddate));
                            }
            ],
            [
                'label' => 'Tindakan',
                'hAlign' => 'center',
                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
                'value' => function ($data){
                            if($data->statusPermohonan === 'DIPERAKUI'){
                                return Html::button('', [
                                    'id' => 'modalButton', 
                                    'value' => \yii\helpers\Url::to(['tindakan-pelulus', 
                                        'staffID' => $data->staffID, 
                                        'kursusLatihanID' => $data->kursusLatihanID]),
                                    'style'=>'background-color: transparent; border: none;', 
                                    'class' => 'fa fa-edit mapBtn'
                                    ]);
                                //Html::a('<i class="fa fa-eye">', ["kontrak/tindakan_pp", 'id' => $data->staffID, 'kursusID' => $data->kursusLatihanID]);
//                            }else{
//                                return Html::a('<i class="fa fa-eye">', ["idp/peraku", 'staffID' => $data->staffID, 'kursusLatihanID' => $data->kursusLatihanID]);
//                            }
                            } 
//                            elseif ($data->statusPermohonan === 'DIPERAKUI') {
//                                return Html::a('<i class="fa fa-eye">', ["idp/peraku", 'staffID' => $data->staffID, 'kursusLatihanID' => $data->kursusLatihanID]);
//                            } elseif ($data->statusPermohonan === 'DILULUSKAN') {
//                                return Html::a('<i class="fa fa-eye">', ["kontrak/tindakan_pp", 'staffID' => $data->staffID, 'kursusLatihanID' => $data->kursusLatihanID]);
//                            }
                        },
            ],
            
];

$gridColumnsA = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ], 
            [
                'label' => 'Pemohon',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->CONm));
                            }
            ],
            [
                'label' => 'Kursus Dipohon',
                'value' => function ($data){
                            return strtoupper($data->sasaran3->tajukLatihan);
                            }
            ],
            [
                'label' => 'Tarikh Kursus',
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
            [
                'label' => 'Tarikh Permohonan',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhPermohonan;
                                $myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                
                                return ucwords(strtolower($formatteddate));
                            }
            ],
            [
                'label' => 'Tarikh Kelulusan',
                'hAlign' => 'center',
                'format' => 'raw',
                //'visible' => 'Condition' ? true : false,
                'value' => function ($data){
                
                                if ($data->tarikhKelulusan){
                                    $tarikhKursus = $data->tarikhKelulusan;
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                    $formatteddate = $myDateTime->format('d-m-Y');

                                    return ucwords(strtolower($formatteddate));
                                } else {
                                    return " ";
                                }
                            }
            ],
            
];
?>
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
            <li><span class="label label-success">LULUS</span> : Permohonan Telah Diluluskan Oleh Ketua JFPIB</li>
            <li><span class="label label-danger">TIDAK DIPERAKUI</span> : Permohonan Tidak Diperakui</li>
            <li><span class="label label-danger">TIDAK DILULUSKAN</span> : Permohonan Tidak Diluluskan</li>
        </ul>
    </div>
    </div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">      
        <div class="x_title">
                <h2>Senarai Permohonan Kursus Anjuran Dalaman Kakitangan</h2>
                <div class="clearfix"></div>
        </div>
        <div class="x_content">

<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-check-circle"></i> Permohonan <span class="label label-default" style="color: white">BARU</span></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderC,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsC,
                ]);
            ?>
        </div>
    </div>
</div>

<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-check-circle"></i> Permohonan <span class="label label-info" style="color: white">DIPERAKUI</span></strong></h2>
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

<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-check-circle"></i> Permohonan <span class="label label-success" style="color: white">DILULUSKAN</span></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderA,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsA,
                ]);
            ?>
        </div>
    </div>
</div>

        </div>
    </div>
    </div>
</div>