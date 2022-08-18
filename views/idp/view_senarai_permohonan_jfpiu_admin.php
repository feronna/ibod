<?php
use yii\grid\GridView;
use yii\helpers\Html;
//use kartik\grid\GridView;

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

// the grid columns setup (only two column entries are shown here
// you can add more column entries you need for your use case)
$gridColumns = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ],  
            [
                'label' => 'Kursus Latihan',
                'value' => function ($data){
                            return ucwords(strtolower($data->sasaran3->tajukLatihan));
                            }
            ],
            [
                'label' => 'Siri',
                'value' => function ($data){
                            return ucwords(strtolower($data->sasaran6->siri));
                            }
            ],
            [
                'label' => 'Status Permohonan',
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
                'label' => 'Bahan Latihan',
                'format' => 'raw',
//                'value' => function ($data){
//                    if ($data->sasaran8->filename){
//                        foreach ($data->sasaran8->filename as $files) {
//                            //return Html::a(Yii::$app->FileManager->NameFile($data->sasaran6->filename), ('https://mediahost.ums.edu.my/api/v1/viewFile/'.$data->sasaran6->filename));
//                            return Html::a(Yii::$app->FileManager->NameFile($files), ('https://mediahost.ums.edu.my/api/v1/viewFile/'.$files));
//                        }
//                    } else {
//                        return "TIADA BAHAN";
//                    }
//                },
                        'value' => function ($data){
                            $datalist = [];
                            if ($data->sasaran8){
                                foreach ($data->sasaran8 as $files) {
                                    $a =  Html::a(Yii::$app->FileManager->NameFile($files->filename), Yii::$app->FileManager->DisplayFile($files->filename)).'<br>';
                                    array_push($datalist, $a); 
                                }
                            } else {
                                return "TIADA BAHAN";
                            }
                            $all = " ";
                            $b = count($datalist);
                            for($i = 0; $i < count($datalist); $i++){
                                $all = $b.') '.$datalist[$i].$all;
                                $b--;
                            }
                            return $all;
                },
            ],
//            [
//                'label' => 'Sah Hadir?',
//                'format' => 'raw',
//                'value' => function ($data){
//                                if ($data->sahHadirbyStaf != NULL) {
//                                    //$a = $data->sahHadirbyStaf;
//                                    $a = Html::a('ANDA TELAH SAHKAN KEHADIRAN', ["idp/sahhadir", 'id' => $data->kursusLatihanID], ['class' => 'btn btn-sm btn-primary disabled'] );
//                                } else {
//                                    
//                                    if ($data->checkBorangpl != NULL) {
//                                        //$a = $data->sahHadirbyStaf;
//                                        $a = Html::a('LENGKAPKAN BORANG PENILAIAN TERDAHULU', ["idp/sahhadir", 'id' => $data->kursusLatihanID], ['class' => 'btn btn-sm btn-primary disabled',
//                                            'title' => 'Sila lengkapkan borang penilaian latihan bagi kursus terdahulu.',
//                                            'data-toggle' => 'tooltip'] );
//                                    } else {
//                                        $a = Html::a('SILA SAHKAN KEHADIRAN ANDA', ["idp/sahhadir", 'id' => $data->kursusLatihanID], ['class' => 'btn btn-sm btn-primary'] );
//                                    //$a = Html::button('MOHON LATIHAN', ['value' => 'mohon-latihan?id='.$data->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-primary btn-block']);
//                                    }
//                                } 
//                    
//                                return $a;
//                            }
//            ],
//            [
//                'label' => 'Tarikh Sah Hadir',
//                'value' => 'tarikhSahHadir',
//            ],
//            [
//                'label' => 'Borang Penilaian Latihan',
//                'format' => 'raw',
//                'value'=> function ($data){
//                
////                            $checkHadir = BorangPenilaianLatihan::find()
////                                ->where(['pesertaID' => $data->staffID])
////                                ->andWhere(['kursusLatihanID' => $data->kursusLatihanID])
////                                ->one();
//
//                            if ($data->checkHadir){
//                                return Html::button('<i class="fa fa-pencil" aria-hidden="true"></i> BORANG PENILAIAN LATIHAN', ['value' => 'borangpenilaianlatihan?id='.$data->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-danger btn-block']);
//                            } else {
//                                return Html::button('<i class="fa fa-pencil" aria-hidden="true"></i> BELUM HADIR LATIHAN', ['class' => 'btn-sm btn-warning btn-block', 'disabled' => true]);
//                                //return Html::button('Press me!', ['class' => 'teaser', 'title' => 'TEST']);
//                            }
//                            //return Html::button('<i class="fa fa-pencil" aria-hidden="true"></i> BORANG PENILAIAN LATIHAN', ['value' => 'borangpenilaianlatihan?id='.$data->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-danger btn-block']);
//                          },
//            ],
            
];

// the grid columns setup (only two column entries are shown here
// you can add more column entries you need for your use case)
$gridColumnsA = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ],  
            [
                'label' => 'Program',
                'value' => function ($data){
                            return ucwords(strtolower($data->sasaran3->tajukLatihan));
                            }
            ],
//            [
//                'label' => 'Kursus Latihan ID',
//                'value' => 'kursusLatihanID'
//            ],
//            [
//                'label' => 'Siri Latihan ID',
//                'value' => 'siriLatihanID'
//            ],
            [
                'label' => 'Tarikh Permohonan',
                'format' => 'raw',
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhPermohonan;
                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                return $formatteddate;
                            }
            ],
            [
                'label' => 'Status Permohonan',
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
                'label' => 'Mata Dipohon',
                'format' => 'raw',
                'value' => 'mataDipohon',
            ],
            [
                'label' => 'Mata Diluluskan',
                'format' => 'raw',
                'value' => 'mataDiluluskan',
            ],
            [
                'label' => 'Tarikh Semakan',
                'format' => 'raw',
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhPermohonan;
                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                return $formatteddate;
                            }
            ],
            [
                'label' => 'Disemak Oleh',
                'format' => 'raw',
                'value' => 'penyemak',
            ],
            [
                'label' => 'Tarikh Kelulusan',
                'format' => 'raw',
                'value' => function ($data){
                                $tarikhKursus = $data->tarikhPermohonan;
                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                $formatteddate = $myDateTime->format('d-m-Y');
                                return $formatteddate;
                            }
            ],
            [
                'label' => 'Diluluskan Oleh',
                'format' => 'raw',
                'value' => 'pelulus'
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
                'value'=> function ($data){
                                //return Html::a('<i class="fa fa-hand-o-right" aria-hidden="true"></i> PESERTA', ['value' => 'borangsemakanpeserta?id='.$lat2->kursusLatihanID, 'class' => 'btn-sm btn-primary btn-block']);
                                return Html::a('PAPAR', 'borangsemakanpeserta?id='.$data->siriLatihanID.'&slotID='.$data->sasaran5->slotID.'&userLevel=urusetiaLatihan', ['title' => Yii::t('app', 'Papar'), 'class' => 'btn-sm btn-primary']);
                                //$url ='view-latihan-live?id='.$data->siriLatihanID.'&slotID='.$data->sasaran5->slotID;
                          }     
            ],
            
            
            
];
?>
<div class="clearfix"></div>
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
</div>

<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-check-circle"></i> Kursus <span class="label label-default" style="color: white">BARU</span></strong></h2>
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
                    'tableOptions' => [
                        'class' => 'table table-condensed',
                    ],
                ]);
            ?>
        </div>
    </div>
</div>

<!--<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-check-circle"></i> Kursus <span class="label label-success" style="color: white">LULUS</span></strong></h2>
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
</div>-->