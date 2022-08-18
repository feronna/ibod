<?php

use yii\helpers\Html;
use app\models\myidp\SiriLatihan;
use app\models\myidp\PermohonanLatihan;
use app\models\myidp\Kehadiran;
use app\models\hronline\Campus;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\select2\Select2;
use app\models\myidp\BorangPenilaianLatihan;

echo $this->render('/idp/_topmenu');
?><?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
<?php 

$gridColumns = [
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'Bil',],
//                        ['attribute' => 'kursusLatihanID',
//                            'contentOptions' => ['style' => 'width:400px;'],
//                            'filterInputOptions' => [
//                                'class'       => 'form-control',
//                                'placeholder' => 'Tajuk kursus latihan dikehendaki...'
//                            ],
//                            'label' => 'Kursus Latihan #',
//                        ],
//                        [ 'attribute' => 'siriLatihanID',
//                            'filterInputOptions' => [
//                                'class'       => 'form-control',
//                                'placeholder' => 'Penggubal modul dikehendaki...'
//                            ],
//                            'label' => 'Siri Latihan ID #',
//                        ],
                        [   
                            'attribute' => 'tajukLatihan',
                            'contentOptions' => ['style' => 'width:250px;'],
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Cari...'
                            ],
                            'label' => 'Tajuk Latihan',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->sasaran3->tajukLatihan), ["idp/laporan-kehadiran-siri", 'id' => $data->siriLatihanID]);
                            },
                            'format' => 'raw'
                            
                        ],
                        [
                            'label' => 'Siri #',
                            'value' => 'siri',
                        ],
                             
                        [  'label' => 'Tempat', 
                            'value' => function ($data){
                                return ucwords(strtoupper($data->lokasi));
                            },
                        ],
                                    
                        [
                            'label' => 'Tarikh',
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
                            'contentOptions' => ['style' => 'width:50px;'],
                            'value' => function ($model){               
                                            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){

                                                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                                                $formatteddate = $myDateTime->format('d/m/Y');

                                                $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhAkhir);
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
                            'class' => 'kartik\grid\EnumColumn',
                            'attribute' => 'unitBertanggungjawab',
                            'label' => 'Jenis',
                            'format' => 'raw',
                            'value' => function ($data){
                                            return ucwords(strtoupper($data->sasaran3->unitBertanggungjawab));
                                        },
//                            'enum' => [
//                                'AKADEMIK' => '<span class="text-muted">AKADEMIK</span>',
//                                'PENTADBIRAN' => '<span class="text-success">PENTADBIRAN</span>',
//                                'JFPIU' => '<span class="text-primary">JFPIU</span>',
//                            ],
                            //'loadEnumAsFilter' => true, // optional - defaults to `true`
                            'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
                                'AKADEMIK' => 'AKADEMIK',
                                'PENTADBIRAN' => 'PENTADBIRAN',
                            ],
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen    
                            'contentOptions' => ['style' => 'width:50px;'],
                        ],
                        [ 
                            'header' => 'Mata <br> IDP',
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
                        [ 
                            'header' => 'Jumlah Lengkap <br> Borang Penilaian',
                            'format' => 'raw',
                            'value' => function ($data){
                                            return BorangPenilaianLatihan::calculateSudahIsi($data->siriLatihanID);
                                        },
                        ],
                        [ 
                            'header' => 'Jumlah Belum Lengkap <br> Borang Penilaian',
                            'format' => 'raw',
                            'value' => function ($data){
                                            return BorangPenilaianLatihan::calculateBelumIsi($data->siriLatihanID);
                                        },
                        ],
                        
                    ];


?>
<style>
a:link {
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
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">       
<!--        <div class="x_panel">
            <div class="x_title">
                <h2>Cari Latihan</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>  ubah kat sini 
            
            $this->render('form_search_latihan',['model'=>$model1]);
                </div>  ubah sini 
            </div>  x_content 
        </div>-->        
        <div class="x_panel">
            <div class="x_title">
            <h5>Laporan Pelaksanaan Kursus
                    
                    <?=
                    ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'filename' => 'Laporan Pelaksanaan Kursus '.date('Y-m-d'),
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/myidp/.',
                            'linkPath' => '/files/myidp/',
                            'batchSize' => 10,
                        ]); 
                    ?>
                
            </h5>
            
            <div class="clearfix"></div>
        </div>
            <div class="x_content">
                <div> <!-- ubah kat sini --> 
                    <div class="table-responsive">
                        <!--<php $senaraiKursus = $searchModel->senaraiKursus;-->
                        <!-- $senaraiKursus is a function from myidp\VIdpSenaraiKursus-->
                <?=
                GridView::widget([
                //\yiister\gentelella\widgets\grid\GridView::widget([
                    //'hover' => true,
                    //'dataProvider' => $senaraiKursus,
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'showFooter'=>true,
                    'showHeader' => true,
                    'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>AKAN DIMAKLUMKAN</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
                ]);
                ?>
                    </div>  
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>