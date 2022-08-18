<?php

use app\models\myidp\BorangPenilaianKeberkesanan;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

echo $this->render('/idp/_topmenu');
?>
<?php 

$gridColumns = [
                        ['class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',],
                        [   
                            //'attribute' => 'kursusLatihanID',
                            'contentOptions' => ['style' => 'width:400px;'],
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Cari...'
                            ],
                            'label' => 'Kursus',
                            'value' => function ($data){
                                return ucwords(strtoupper($data->sasaran9->sasaran4->sasaran3->tajukLatihan));
                            },
//                            'group' => true,  // enable grouping
                            
                        ],
                        [
                            'label' => 'Siri',
                            'hAlign' => 'center',
                            'value' => function ($data){
                                return ucwords(strtoupper($data->sasaran9->sasaran4->siri));
                            },
//                            'group' => true,  // enable grouping
//                            'subGroupOf' => 1 // supplier column index is the parent group
                        ],                                   
//                         [
//                             'class' => 'kartik\grid\EnumColumn',
//                             'label' => 'Jenis',
//                             'attribute' => 'jenis',
//                             'value' => 'sasaran9.sasaran4.sasaran3.jenisKursus',
//                             'format' => 'raw',
// //                            'enum' => [
// //                                'latihanDalaman' => '<span class="text-sucess">DALAMAN</span>',
// //                                'jfpiu' => '<span class="text-primary">JFPIU</span>',
// //                            ],
//                             //'loadEnumAsFilter' => true, // optional - defaults to `true`
//                             'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
//                                 'latihanDalaman' => 'DALAMAN',
//                                 'jfpiu' => 'JFPIU',
//                             ],
//                             'filterType' => GridView::FILTER_SELECT2,
//                             'filterWidgetOptions' => [
//                                 'pluginOptions' => ['allowClear' => true],
//                             ],
//                             'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen 
//                         ],
                        
                        [  'label' => 'Tempat', 
                            'value' => function ($data){
                                return ucwords(strtoupper($data->sasaran9->sasaran4->lokasi));
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
                            'value' => function ($model){               
                                            if (($model->sasaran9->sasaran4->tarikhMula != null) && ($model->sasaran9->sasaran4->tarikhMula != 0000-00-00)){

                                                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->sasaran9->sasaran4->tarikhMula);
                                                $formatteddate = $myDateTime->format('d/m/Y');

                                                $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->sasaran9->sasaran4->tarikhAkhir);
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
                        ['class' => 'kartik\grid\ActionColumn',
                            'header' => 'Menunggu Tindakan',
                            'hAlign' => 'center',
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'headerOptions' => ['style' => 'width:100px'],
                            'contentOptions' => ['style'=>'padding:0px 0px 0px 15px;vertical-align: middle;'],
                            'template' => '{laporan_kehadiran}',
                            //'contentOptions' => ['style'=>'padding:0px 0px 0px 30px;vertical-align: middle;'],
                            'buttons' => [
                              'laporan_kehadiran' => function ($url, $model) {
                                  return Html::a(BorangPenilaianKeberkesanan::calculateStaffByDept($model->sasaran9->siriLatihanID, $model->peserta->DeptId),
                                   $url, 
                                   [
                                       'title' => Yii::t('app', 'Papar'),
                                        'data-pjax' => '0',
                                        'target' => "_blank"
                                   ]);
                              },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                              
                              if ($action === 'laporan_kehadiran') {
                                  $url ='laporan-kehadiran-keberkesanan?id='.$model->sasaran9->siriLatihanID.'&dept='.$model->peserta->DeptId; //hantar ke Controller
                                  return $url;
                              }
                            }
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
            <h5>Senarai Kursus Dalaman Dihadiri Kakitangan
                
                    
                    <?php 
                    
                    $counter = 0;
                    
                    foreach ($deptChief as $c){
                        $counter = $counter + 1; ?>
                        <h3><span class="label label-danger" style="color: white">
                        <?= $counter ?>
                        </span>&nbsp;<span class="label label-primary" style="color: white">
                        <?php echo strtoupper($c->fullname); ?>
                        </span></h3>
                    <?php } ?>
                    
                    
                    <?php
                    // ExportMenu::widget([
                    //         'dataProvider' => $dataProvider,
                    //         'columns' => $gridColumns,
                    //         'filename' => 'Senarai Kursus Dihadiri Kakitangan '.strtoupper($getJabatan->department->fullname).' - '.date('Y-m-d'),
                    //         'clearBuffers' => true,
                    //         'stream' => false,
                    //         'folder' => '@app/web/files/myidp/.',
                    //         'linkPath' => '/files/myidp/',
                    //         'batchSize' => 10,
                    //     ]); 
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