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
                            'header' => 'Bil',
                            'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],],
                        [   
                            'attribute' => 'tajukLatihan',
                            'contentOptions' => ['style' => 'width:250px;'],
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Cari...'
                            ],
                            'label' => 'Tajuk Latihan',
                            'value' => function ($data){
                                return ucwords(strtoupper($data->sasaran3->tajukLatihan));
                            },
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                        ],
                        [
                            'label' => 'Siri #',
                            'value' => 'siri',
                            'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                        ],
//                             
//                        [  'label' => 'Tempat', 
//                            'value' => function ($data){
//                                return ucwords(strtoupper($data->lokasi));
//                            },
//                        ],
//                                    
//                        [
//                            'label' => 'Tarikh',
//                            'format' => 'raw',
//                            'attribute' => 'bulan',
//                            'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
//                                '1' => 'Januari',
//                                '2' => 'Februari',
//                                '3' => 'Mac',
//                                '4' => 'April',
//                                '5' => 'Mei',
//                                '6' => 'Jun',
//                                '7' => 'Julai',
//                                '8' => 'Ogos',
//                                '9' => 'September',
//                                '10' => 'Oktober',
//                                '11' => 'November',
//                                '12' => 'Disember',
//                                
//                            ],
//                            'filterType' => GridView::FILTER_SELECT2,
//                            'filterWidgetOptions' => [
//                                'pluginOptions' => ['allowClear' => true],
//                            ],
//                            'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen    
//                            'contentOptions' => ['style' => 'width:50px;'],
//                            'value' => function ($model){               
//                                            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
//
//                                                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
//                                                $formatteddate = $myDateTime->format('d/m/Y');
//
//                                                $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhAkhir);
//                                                $formatteddate2 = $myDateTime2->format('d/m/Y');
//
//                                                if ($formatteddate == $formatteddate2 ){
//                                                    $formatteddate = $formatteddate;    
//                                                } else {
//                                                    $formatteddate = $formatteddate.' - '.$formatteddate2;
//                                                }
//
//                                            } else {
//                                                $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
//                                            } 
//                                            return $formatteddate;
//                                        },
//                            'headerOptions' => ['style' => 'width:100px'],
//                        ],
//                        [ 
//                            'label' => 'Mata IDP',
//                            'value' => 'jumlahMataIDP'
//                        ],
//                        [ 
//                            'header' => 'Jumlah <br> Sasaran',
//                            'value' => 'kuota'
//                        ],
//                        [ 
//                            'header' => 'Jumlah <br> Pemohon',
//                            'value' => function ($data){
//                                            return PermohonanLatihan::calculatePemohon($data->siriLatihanID);
//                                        },
//                        ],
                        [ 
                            'header' => 'Jumlah <br> Kehadiran',
                            'value' => function ($data){
                                            return Kehadiran::calculatePeserta($data->siriLatihanID);
                                        },
                            'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                        ],
                        [ 
                            'header' => 'Pengisian <br> Borang Penilaian',
                            'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                            'format' => 'raw',
                            'value' => function ($data){
                                            return BorangPenilaianLatihan::calculateSudahIsi($data->siriLatihanID).''.
                                                   BorangPenilaianLatihan::calculateBelumIsi($data->siriLatihanID);
//                                            return Html::a(BorangPenilaianLatihan::calculateSudahIsi($data->siriLatihanID), ["statistik-senarai"]).''.
//                                                   Html::a(BorangPenilaianLatihan::calculateBelumIsi($data->siriLatihanID), ["statistik-senarai"]) ;
                                        },
                        ],
                    ];

?>
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
                <h2>Senarai Latihan</h2>
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
                    'beforeHeader' => [
                                                    [
                                                        'columns' => [
                                                            ['content' => 'BIL', 'options' => ['colspan' => 1, 'rowspan' => 2], 
                                                                'vAlign' => 'middle',
                                                                'hAlign' => 'center'],
                                                            ['content' => 'TAJUK', 'options' => ['colspan' => 1, 'rowspan' => 2]],
                                                            ['content' => 'SIRI', 'options' => ['colspan' => 1, 'rowspan' => 2]],
                                                            ['content' => 'JUMLAH HADIR', 'options' => ['colspan' => 1, 'rowspan' => 2]],
                                                            ['content' => 'JUMLAH PENGISIAN BORANG', 'options' => ['colspan' => 1, 'rowspan' => 2]],
                                                            ['content' => 'TERAS UNIVERSITI', 'options' => ['colspan' => 4]],
                                                            ['content' => 'TERAS SKIM', 'options' => ['colspan' => 4]],
                                                            ['content' => 'ELEKTIF', 'options' => ['colspan' => 4]],
                                                            ['content' => 'ELEKTIF', 'options' => ['colspan' => 4]],
                                                            //['content' => 'Date', 'options' => ['colspan' => 2, 'class' => 'text-center warning']],
                                                        ],
                                                    ]
                                                ],
                    'columns' => $gridColumns,
                ]);
                ?>
                    </div>  
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>