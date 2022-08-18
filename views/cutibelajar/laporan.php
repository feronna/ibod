<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'REKOD PENGAJIAN LANJUTAN';
 error_reporting(0); 
?>
<?php echo $this->render('/cutibelajar/_topmenu');?>  
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Carian</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['laporan ', 'id' => $icno], 'GET'); ?>
                <?= Html::dropDownList('tahun', $tahun, ['2020' => '2020','2019' => '2019', '2018' => '2018', '2017' => '2017', '2016' => '2016', '2015' => '2015'], ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>

                <?= Html::dropDownList('bulan', $bulan, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Cari', ['class' => 'btn btn-primary']); ?>
                <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
                 <?= Html::endForm(); ?>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
             <div class="x_title" style="color:#37393b;">
                 <h2> <?= Html::encode($this->title) ?></h2>
                 <p align="right">
                <?php echo Html::a('Daftar Pengajian Lanjutan', ['cutibelajar/daftar-pengajian-lanjutan', 'id' => $iklan->id], ['class' => 'btn btn-danger btn-sm']); ?>
                
                </p>
            <div class="clearfix"></div>
        </div>
            <div class="x_content">
              <?= $this->render('_sub', ['dataProvider' => $dataProvider,'model' => $model]) ?>
                <div class="row"> 
                <div class="col-xs-12 col-md-12 col-lg-12"> 
    
                  
                    <?php // $this->render('_sub', ['dataProvider' => $dataProvider]) ?>
                    <div class="x_content">
                        <div class="table-responsive">
                         <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'options' => [
                            'class' => 'table-responsive',
                                ],
                   
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => 'Bil',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ],
                        
                        [
                           //'attribute' => 'CONm',
                            'label' => 'Nama Kakitangan',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a ('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ['/cbelajar/maklumat-pemohon', 'id' => $model->id, 'ICNO' => $ICNO, 'takwim_id'=>$model->iklan_id]);
                            }, 
                                    'format' => 'html',
                        ],
                                
                        [
                            'label' => 'No. KP',
                            'value' => 'kakitangan.ICNO',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        
                         [
                            'label' => 'UMSPER',
                            'value' => 'kakitangan.COOldID',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        
                        [
                            'label' => 'Jawatan ',
                            'value' => 'kakitangan.jawatan.fname',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        
                        [
                            'label' => 'Jabatan',
                            'value' => 'kakitangan.displayDepartment',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                       
                         
                        
                                    [
                            
                            'label' => 'Peringkat Pengajian',
                            'value' => 'pengajian.pendidikanTertinggi.HighestEduLevel',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        [
                            
                            'label' => 'Tajaan',
                            'value' => 'biasiswa.nama_tajaan',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        [
                            'label' => 'Status ',
                            'value' => 'kakitangan.displayServiceStatus',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                         [
                                            'header' => 'Tindakan',
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model) 
                                                {
                                                        $ICNO = $model->icno;
                                                        $url = Url::to(['cutibelajar/view', 'id' => $model->id, 'ICNO' => $ICNO]);
                                                        $url2 =  Url::to(['/cbelajar/maklumat-pemohon', 'id' => $model->id, 'ICNO' => $ICNO, 'takwim_id'=>$model->iklan_id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return 
                                                        Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, ['title' => 'Lihat Data']).' '. 
                                                        Html::a('<i class="fa fa-file-pdf-o fa-lg"></i>', $url2, ['title' => 'Borang']);
                                                    
                                                },
                                                        
                                                
                                                
                                        ],
                                                
                                            'contentOptions' => ['class' => 'text-center'],
                                        ]
//                        [
//                            'label' => 'JUMLAH',
//                            'format' => 'raw',
//                            'headerOptions' => ['class'=>'text-center'],
//                                            'contentOptions' => ['class'=>'text-center'],
//                            'value'=>'jumlah',
//                        ],
//
//                         

                    ],
                ]); ?>
                </div>
                    </div>

                </div>
            </div>

            </div>
        </div>
    </div>
</div>
