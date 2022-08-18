<?php
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;
use app\models\myidp\BorangPenilaianKeberkesanan;

/* @var $this yii\web\View */
/* @var $model app\models\Fruit */

error_reporting(0);

echo $this->render('/idp/_topmenu');

$dataProvider->pagination->pageParam = 'p-page';
$dataProvider->sort->sortParam = 'p-sort';

$dataProvider2->pagination->pageParam = 'a-page';
$dataProvider2->sort->sortParam = 'a-sort';

$gridColumns2 = [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions'=>['class'=>'kartik-sheet-style'],
                'width'=>'36px',
                'pageSummary'=>'Total',
                'pageSummaryOptions' => ['colspan' => 6],
                'header' => 'Bil',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
//                                'header' => 'Bil',
//                                'vAlign' => 'middle',
//                                'hAlign' => 'center',
                
            ],
            [
                'label' => 'Nama',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->peserta->CONm));
                            }
            ],
////            [
////                'attribute' => 'CONm',
////                'contentOptions' => ['style' => 'width:400px;'],
////                'filterInputOptions' => [
////                    'class'  => 'form-control',
////                    'placeholder' => 'Cari...'
////                ],
////                'label' => 'Nama',
////                'value' => function ($data){
////                            return ucwords(strtolower($data->peserta->CONm));
////                            },
//////                'filter'    => ArrayHelper::map(Kehadiran::find()
//////                        ->joinWith('peserta')
//////                        ->where(['slotID' => $slotID])
//////                        ->all(), 'staffID', 'peserta.CONm'),
//////                'filterType' => GridView::FILTER_SELECT2,
////                'filterWidgetOptions' => [
////                    'pluginOptions' => ['allowClear' => true],
////                ],
////            ],
            [
                'label' => 'Jawatan Disandang',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->peserta->jawatan->nama)).' ('.ucwords(strtoupper($data->peserta->jawatan->gred)).')';
                            }
            ],
            [
                'label' => 'JAFPIB',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtoupper($data->peserta->department->shortname));
                            }
            ],
//            [
//                'attribute' => 'DeptId',
////                'contentOptions' => ['style' => 'width:400px;'],
//                'label' => 'JFPIU',
//                'value' => function ($data){
//                            return ucwords(strtoupper($data->peserta->department->shortname));
//                           },
//                'filter'    => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
//                'filterType' => GridView::FILTER_SELECT2,
//                'filterWidgetOptions' => [
//                    'pluginOptions' => ['allowClear' => true],
//                ],
//                'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen                  
//            ],
//            [
//                'label' => 'Tarikh & Jam Pendaftaran',
//                'format' => 'raw',
//                'vAlign' => 'middle',
//                'value' => 'tarikhKursus',
//            ],
            [
                'label' => 'Status',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'format' => 'raw',
                'value' => 'statusPeserta_',
            ],
//            [
//                'label' => 'Jenis Kursus',
//                'format' => 'raw',
//                'value' => 'jenisKursus',
//            ],
//            [
//                'label' => 'Tindakan',
//                'format' => 'raw',
//                'value'=> function ($data){
//                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'delete-peserta?slotID='.$data->slotID.'&staffID='.$data->staffID,
//                                          ['data' => [
//                                              'confirm' => 'Adakah anda pasti anda ingin menghapuskan kehadiran peserta ini?',
//                                              'method' => 'post',
//                                              ],
//                                          ],
//                                          ['title' => Yii::t('app', 'Hapus'),]
//                                          
//                                    );
//                          },
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//            ],
//            [
//                'class' => 'yii\grid\CheckboxColumn',
//                'name' => 'momo',
//                'checkboxOptions' => function ($model, $key, $index, $column){
//                    return ['value' => $model->staffID, 'checked'=> true]; },
//            ],
////            [
////                'label' => 'Mata Diperoleh',
////                'format' => 'raw',
////                'value' => 'sasaran9.mataSlot',
////            ],
                [
                'header' => 'Pengesahan Kehadiran',
                'format' => 'raw',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function ($data){
                                
                                    if ($data->sasaran9->sasaran4->sasaran66->sahHadirbyStaf != NULL) {

                                        if ($data->sasaran9->sasaran4->sasaran66->sahHadirbyStaf == 'TIDAK'){
                                            $a = '<span class="label label-danger">TELAH SAHKAN KETIDAKHADIRAN</span>';
                                        } elseif ($data->sasaran9->sasaran4->sasaran66->sahHadirbyStaf == 'YA'){
                                            $a = '<span class="label label-success">TELAH SAHKAN KEHADIRAN</span>';
                                        }
                                        
                                    } else {
                                        $a = '<span class="label label-warning">TIDAK MEMBUAT PENGESAHAN KEHADIRAN</span>';
                                    }
                    
                                return $a;
                            }
                ],
                [
                    'header' => 'Penilaian Keberkesanan',
                    'format' => 'raw',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'value' => function ($data){
                        
                                    return BorangPenilaianKeberkesanan::checkBorangStatusk($data->sasaran9->siriLatihanID, $data->staffID);
                                }
                ],
];

$gridColumns = [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions'=>['class'=>'kartik-sheet-style'],
                'width'=>'36px',
                'pageSummary'=>'Total',
                'pageSummaryOptions' => ['colspan' => 6],
                'header' => 'Bil',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                
            ],
            [
                'label' => 'Nama',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->CONm));
                            }
            ],
            [
                'label' => 'Jawatan Disandang',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->jawatan->nama)).' ('.ucwords(strtoupper($data->biodata->jawatan->gred)).')';
                            }
            ],
            [
                'label' => 'JAFPIB',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtoupper($data->biodata->department->shortname));
                            }
            ],
            [
                'header' => 'Pengesahan Kehadiran',
                'format' => 'raw',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function ($data){
                                
                                    if ($data->sahHadirbyStaf != NULL) {

                                        if ($data->sahHadirbyStaf == 'TIDAK'){
                                            $a = '<span class="label label-danger">TELAH SAHKAN KETIDAKHADIRAN</span>';
                                        } elseif ($data->sahHadirbyStaf == 'YA'){
                                            $a = '<span class="label label-success">TELAH SAHKAN KEHADIRAN</span>';
                                        }
                                        
                                    } else {
                                        $a = '<span class="label label-warning">TIDAK MEMBUAT PENGESAHAN KEHADIRAN</span>';
                                    }
                    
                                return $a;
                            }
            ],
            
];

?>
<script>
    $(function(){
    
    $('.mapBtn').click(function (){
       $('#modal').modal('show')
               .find('#modalContent')
               .load($(this).attr('value'));
    });
    
    
    
});
</script>
<!--<style>
    .label{
        white-space: pre-wrap;
    }
</style>-->
<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h5>Semakan Kursus <h3><span class="label label-primary" style="color: white"><?= ucwords($model->sasaran3->tajukLatihan).' Siri '.ucwords(strtolower($model->siri)) ?></span></h3></h5>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
                <h4>Panduan</h4>
                <div class="clearfix"></div>
        </div>
        <ul>
            <li><span class="btn btn-primary btn-md"><i class="fa fa-check" aria-hidden="true"></i></span> : Ketua Jabatan Sudah Mengisi Borang Penilaian Enam Bulan</li>
            <li><span class="btn btn-success btn-md"><i class="fa fa-check" aria-hidden="true"></i></span> : Kakitangan Sudah Mengisi Borang Penilaian, Menunggu Tindakan Ketua Jabatan</li>
            <li><span class="btn btn-danger btn-md"><i class="fa fa-warning" aria-hidden="true"></i></span> : Kakitangan Belum Mengisi Borang Penilaian</li>
        </ul>
    </div>
    </div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">    
        <div class="x_title">
            <h5>Senarai
                <h3>
                    <span class="label label-success" style="color: white">Kehadiran</span>
                    
                    <?=
                    ExportMenu::widget([
                            'dataProvider' => $dataProvider2,
                            'columns' => $gridColumns2,
                            'filename' => 'Senarai Kehadiran Kursus '.ucwords(strtolower($model->sasaran3->tajukLatihan)).' Siri '.$model->siri.'',
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/myidp/.',
                            'linkPath' => '/files/myidp/',
                            'batchSize' => 10,
                        ]); 
                    ?>
                
                </h3>
                
            </h5>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php 
            Pjax::begin([
                    // PJax options
                ]);
            
            echo GridView::widget([
                    'dataProvider' => $dataProvider2,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns2,
                ]);
            
            Pjax::end();
            ?>
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">    
        <div class="x_title">
            <h5>Senarai
                <h3>
                    <span class="label label-danger" style="color: white">Pemohon Tidak Hadir</span>
                    
                    <?=
                    ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'filename' => 'Senarai Pemohon Tidak Hadir Kursus '.ucwords(strtolower($model->sasaran3->tajukLatihan)).' (Siri '.$model->siri.')',
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/myidp/.',
                            'linkPath' => '/files/myidp/',
                            'batchSize' => 10,
                        ]); 
                    ?>
                
                </h3>
                
            </h5>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php
            
            Pjax::begin([
                    // PJax options
                ]);
            
            echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
                ]);
            
            Pjax::end();
            ?>
        </div>
    </div>
</div>
</div>

