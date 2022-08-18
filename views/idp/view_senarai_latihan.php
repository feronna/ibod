<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView; //using this will trigger kartik confirmation dialog


echo $this->render('/idp/_topmenu');

$dataProvider->pagination->pageParam = 'p-page';
$dataProvider->sort->sortParam = 'p-sort';

$dataProviderA->pagination->pageParam = 'a-page';
$dataProviderA->sort->sortParam = 'a-sort';

$dataProviderB->pagination->pageParam = 'b-page';
$dataProviderB->sort->sortParam = 'b-sort';

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
                <h2><strong><i class="fa fa-envelope"></i> Senarai Latihan <span class="label label-info" style="color: white">PENTADBIRAN</span></strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini --> 
                    <div class="table-responsive">
                        <!--<php $senaraiKursus = $searchModel->senaraiKursus;-->
                        <!-- $senaraiKursus is a function from myidp\VIdpSenaraiKursus-->
                <?php
                Pjax::begin([
                    // PJax options
                ]);
                echo GridView::widget([
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
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'Bil',],
                        ['attribute' => 'tajukLatihan',
                            'contentOptions' => ['style' => 'width:400px;'],
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Tajuk kursus latihan dikehendaki...'
                            ],
                        ],
                        [ 'attribute' => 'penggubalModul',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Penggubal modul dikehendaki...'
                            ],
                        ],
                        [ 'attribute' => 'tahunTawaran',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Tahun dikehendaki...'
                            ],
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Tindakan',
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{view} | {update} | {delete}',
                            'buttons' => [
                              'view' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                              'title' => Yii::t('app', 'Papar'),
                                  ]);
                              },

                              'update' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                              'title' => Yii::t('app', 'Kemaskini'),
                                  ]);
                              },
                              'delete' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                          ['data' => [
                                              'confirm' => 'Adakah anda pasti anda ingin menghapuskan rekod ini?',
                                              'method' => 'post',
                                              ],
                                          ],
                                          ['title' => Yii::t('app', 'Hapus'),]);     
                              },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                              if ($action === 'view') {
                                  $url ='view-latihan?id='.$model->kursusLatihanID;
                                  return $url;
                              }

                              if ($action === 'update') {
                                  $url ='update-latihan?id='.$model->kursusLatihanID; //hantar ke Controller
                                  return $url;
                              }
                              if ($action === 'delete') {
                                  $url ='delete-latihan?id='.$model->kursusLatihanID; 
                                  return $url;
                              }
                            }
                      ],
                              //'class' => 'yii\grid\CheckboxColumn'],
                      ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Penetapan',
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{linkSiri}',
                            'buttons' => [
                              'linkSiri' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-tags"></span>', $url, [
                                              'title' => Yii::t('app', 'Tambah Siri'),
                                  ]);
                              },

//                              'linkSasaran' => function ($url, $model) {
//                                  return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, [
//                                              'title' => Yii::t('app', 'Tetapan Sasaran'),
//                                  ]);
//                              },
//                              'link' => function ($url,$model,$key) {
//                                  return Html::a('TAMBAH SIRI', $url);
//                              },
//                              'link2' => function ($url,$model,$key) {
//                                  return Html::a('TETAPAN SASARAN', $url);        
//                              },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                              if ($action === 'linkSasaran') {
                                  $url ='view-senarai-jawatan?id='.$model->kursusLatihanID; //hantar ke Controller
                                  return $url;
                              }

                              if ($action === 'linkSiri') {
                                  $url ='form-tambah-siri?id='.$model->kursusLatihanID;
                                  return $url;
                              }
                            }
                      ],
                    ],
                ]);
                Pjax::end();
                ?>
                    </div>  
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>

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
                <h2><strong><i class="fa fa-envelope"></i> Senarai Latihan <span class="label label-danger" style="color: white">AKADEMIK</span></strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini --> 
                    <div class="table-responsive">
                        <!--<php $senaraiKursus = $searchModel->senaraiKursus;-->
                        <!-- $senaraiKursus is a function from myidp\VIdpSenaraiKursus-->
                <?php
                Pjax::begin([
                    // PJax options
                ]);
                echo GridView::widget([
                //\yiister\gentelella\widgets\grid\GridView::widget([
                    //'hover' => true,
                    //'dataProvider' => $senaraiKursus,
                    'dataProvider' => $dataProviderA,
                    'filterModel' => $searchModelA,
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
                        ['attribute' => 'tajukLatihan',
                            'contentOptions' => ['style' => 'width:400px;'],
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Tajuk kursus latihan dikehendaki...'
                            ],
                        ],
                        [ 'attribute' => 'penggubalModul',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Penggubal modul dikehendaki...'
                            ],
                        ],
                        [ 'attribute' => 'tahunTawaran',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Tahun dikehendaki...'
                            ],
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Tindakan',
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{view} | {update} | {delete}',
                            'buttons' => [
                              'view' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                              'title' => Yii::t('app', 'Papar'),
                                  ]);
                              },

                              'update' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                              'title' => Yii::t('app', 'Kemaskini'),
                                  ]);
                              },
                              'delete' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                          ['data' => [
                                              'confirm' => 'Adakah anda pasti anda ingin menghapuskan rekod ini?',
                                              'method' => 'post',
                                              ],
                                          ],
                                          ['title' => Yii::t('app', 'Hapus'),]);     
                              },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                              if ($action === 'view') {
                                  $url ='view-latihan?id='.$model->kursusLatihanID;
                                  return $url;
                              }

                              if ($action === 'update') {
                                  $url ='update-latihan?id='.$model->kursusLatihanID; //hantar ke Controller
                                  return $url;
                              }
                              if ($action === 'delete') {
                                  $url ='delete-latihan?id='.$model->kursusLatihanID; 
                                  return $url;
                              }
                            }
                      ],
                              //'class' => 'yii\grid\CheckboxColumn'],
                      ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Penetapan',
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{linkSiri}',
                            'buttons' => [
                              'linkSiri' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-tags"></span>', $url, [
                                              'title' => Yii::t('app', 'Tambah Siri'),
                                  ]);
                              },

//                              'linkSasaran' => function ($url, $model) {
//                                  return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, [
//                                              'title' => Yii::t('app', 'Tetapan Sasaran'),
//                                  ]);
//                              },
//                              'link' => function ($url,$model,$key) {
//                                  return Html::a('TAMBAH SIRI', $url);
//                              },
//                              'link2' => function ($url,$model,$key) {
//                                  return Html::a('TETAPAN SASARAN', $url);        
//                              },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                              if ($action === 'linkSasaran') {
                                  $url ='view-senarai-jawatan?id='.$model->kursusLatihanID; //hantar ke Controller
                                  return $url;
                              }

                              if ($action === 'linkSiri') {
                                  $url ='form-tambah-siri?id='.$model->kursusLatihanID;
                                  return $url;
                              }
                            }
                      ],
                    ],
                ]);
                Pjax::end();
                ?>
                    </div>  
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>

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
                <h2><strong><i class="fa fa-envelope"></i> Senarai Latihan <span class="label label-danger" style="color: white">JFPIU</span></strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini --> 
                    <div class="table-responsive">
                        <!--<php $senaraiKursus = $searchModel->senaraiKursus;-->
                        <!-- $senaraiKursus is a function from myidp\VIdpSenaraiKursus-->
                <?php
                Pjax::begin([
                    // PJax options
                ]);
                echo GridView::widget([
                //\yiister\gentelella\widgets\grid\GridView::widget([
                    //'hover' => true,
                    //'dataProvider' => $senaraiKursus,
                    'dataProvider' => $dataProviderB,
                    'filterModel' => $searchModelB,
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
                        ['attribute' => 'tajukLatihan',
                            'contentOptions' => ['style' => 'width:400px;'],
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Tajuk kursus latihan dikehendaki...'
                            ],
                        ],
                        [ 'attribute' => 'penggubalModul',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Penggubal modul dikehendaki...'
                            ],
                        ],
                        [ 'attribute' => 'tahunTawaran',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Tahun dikehendaki...'
                            ],
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Tindakan',
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{view} | {update} | {delete}',
                            'buttons' => [
                              'view' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                              'title' => Yii::t('app', 'Papar'),
                                  ]);
                              },

                              'update' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                              'title' => Yii::t('app', 'Kemaskini'),
                                  ]);
                              },
                              'delete' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                          ['data' => [
                                              'confirm' => 'Adakah anda pasti anda ingin menghapuskan rekod ini?',
                                              'method' => 'post',
                                              ],
                                          ],
                                          ['title' => Yii::t('app', 'Hapus'),]);     
                              },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                              if ($action === 'view') {
                                  $url ='view-latihan?id='.$model->kursusLatihanID;
                                  return $url;
                              }

                              if ($action === 'update') {
                                  $url ='update-latihan?id='.$model->kursusLatihanID; //hantar ke Controller
                                  return $url;
                              }
                              if ($action === 'delete') {
                                  $url ='delete-latihan?id='.$model->kursusLatihanID; 
                                  return $url;
                              }
                            }
                      ],
                              //'class' => 'yii\grid\CheckboxColumn'],
                      ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Penetapan',
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{linkSiri}',
                            'buttons' => [
                              'linkSiri' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-tags"></span>', $url, [
                                              'title' => Yii::t('app', 'Tambah Siri'),
                                  ]);
                              },

//                              'linkSasaran' => function ($url, $model) {
//                                  return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, [
//                                              'title' => Yii::t('app', 'Tetapan Sasaran'),
//                                  ]);
//                              },
//                              'link' => function ($url,$model,$key) {
//                                  return Html::a('TAMBAH SIRI', $url);
//                              },
//                              'link2' => function ($url,$model,$key) {
//                                  return Html::a('TETAPAN SASARAN', $url);        
//                              },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                              if ($action === 'linkSasaran') {
                                  $url ='view-senarai-jawatan?id='.$model->kursusLatihanID; //hantar ke Controller
                                  return $url;
                              }

                              if ($action === 'linkSiri') {
                                  $url ='form-tambah-siri?id='.$model->kursusLatihanID;
                                  return $url;
                              }
                            }
                      ],
                    ],
                ]);
                Pjax::end();
                ?>
                    </div>  
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>