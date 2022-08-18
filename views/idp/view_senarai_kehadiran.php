<?php

use yii\helpers\Html;
use yii\grid\GridView; //this Yii2 Gridview cannot use 'hover'
//use \yiister\gentelella\widgets\grid\GridView; //use this one to called 'hover'

echo $this->render('/idp/_topmenu');

?><?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
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
                <h2>Transkrip Latihan Dihadiri</h2>
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
                    'dataProvider' => $dataProviderKehadiran,
                    //'filterModel' => $searchModel,
                    'showFooter'=>true,
                    'showHeader' => true,
                    'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'Bil',],
                        ['attribute' => 'slotID',
//                            'contentOptions' => ['style' => 'width:400px;'],
//                            'filterInputOptions' => [
//                                'class'       => 'form-control',
//                                'placeholder' => 'Tajuk kursus latihan dikehendaki...'
//                            ],
                            'label' => 'Slot ID',
                        ],
                        [
                            'label' => 'Kursus Latihan',
                            'value' => 'sasaran9.sasaran4.sasaran3.tajukLatihan',
                        ],
//                        [
//                            'label' => 'Status Kehadiran',
//                            'value' => 'statusPeserta',
//                        ],
                        [ 'attribute' => 'tarikhMasa',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Penggubal modul dikehendaki...'
                            ],
                            'label' => 'Tarikh & Masa Hadir',
                        ],
//                        ['class' => 'yii\grid\ActionColumn',
//                            'header' => 'Tindakan',
//                            //'headerOptions' => ['style' => 'color:#337ab7'],
//                            'template' => '{view}',
//                            'buttons' => [
//                              'view' => function ($url, $model) {
//                                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
//                                              'title' => Yii::t('app', 'Papar'),
//                                  ]);
//                              },
//                            ],
//                            'urlCreator' => function ($action, $model, $key, $index) {
//                              if ($action === 'view') {
//                                  $url ='view-kehadiran?kursusID='.$model->sasaran9->sasaran4->sasaran3->kursusLatihanID;
//                                  return $url;
//                              }
//                            }
//                      ],
                    ],
                ]);
                ?>
                    </div>  
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>