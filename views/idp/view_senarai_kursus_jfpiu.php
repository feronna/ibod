<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView; //using this will trigger kartik confirmation dialog


echo $this->render('/idp/_topmenu');

//$dataProvider->pagination->pageParam = 'p-page';
//$dataProvider->sort->sortParam = 'p-sort';
//
//$dataProviderA->pagination->pageParam = 'a-page';
//$dataProviderA->sort->sortParam = 'a-sort';
$gridColumnsA = [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',            
            ],  
            [
                'label' => 'Program',
                'value' => function ($data){
                            return ucwords(strtolower($data->sasaran4->sasaran3->tajukLatihan));
                            }
            ],
            [
                'label' => 'Tarikh',
                //'vAlign' => 'middle',
                //'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($model){               
                                if (($model->sasaran4->tarikhMula != null) && ($model->sasaran4->tarikhMula != 0000-00-00)){
                                    
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->sasaran4->tarikhMula);
                                    $formatteddate = $myDateTime->format('d/m/Y');
                                    
                                    $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->sasaran4->tarikhAkhir);
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
                'label' => 'Tempat ',
                //'vAlign' => 'middle',
                //'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($data){
                            return ucwords(strtolower($data->sasaran4->lokasi));
                            }
            ],
            [
                'label' => 'Anjuran',
                'value' => function ($data){
                            return ucwords(strtolower($data->sasaran4->sasaran3->penggubalModul));
                            }
            ],
            [
                'label' => 'Mata',
                'format' => 'raw',
                'value' => function ($data){
                            return ucwords(strtolower($data->sasaran4->jumlahMataIDP));
                            }
            ],
            [
                'label' => 'Kompetensi',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->sasaran4->sasaran3->kompetensii;
                            }
            ],
            [
                'label' => 'Peserta',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'width' => '500px',
                'format' => 'raw',
                'value' => function ($data){
                            $datalist = [];
                            if ($data->pesertaa){ // if ada penceramah
                                
                                foreach ($data->pesertaa as $c) { //foreach penceramah

                                    $a = Html::a(ucwords(strtolower($c->peserta->displayGelaran . ' ' . $c->peserta->CONm)), [""], ['class' => 'btn btn-success disabled'] );
                                    //$a =  Html::a(Yii::$app->FileManager->NameFile($files->filename), Yii::$app->FileManager->DisplayFile($files->filename)).'<br>';
                                    array_push($datalist, $a); 
                                }
                            }
                            else {
                                return '<em><b>TIADA</b></em>';
                            }
                            $all = " ";
                            $b = count($datalist);
                            for($i = 0; $i < count($datalist); $i++){
                                $all = $b.') '.$datalist[$i].'<br>'.$all;
                                $b--;
                            }
                            return $all;
                            //return count($datalist);
                },
                 
            ],
            ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Tindakan',
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{update} | {delete}',
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
                                  $url ='view-kursus-jfpiu?id='.$model->sasaran4->sasaran3->kursusLatihanID;
                                  return $url;
                              }

                              if ($action === 'update') {
                                  $url ='update-latihan-jfpiu-admin?id='.$model->sasaran4->sasaran3->kursusLatihanID; //hantar ke Controller
                                  return $url;
                              }
                              if ($action === 'delete') {
                                  $url ='delete-kursus-jfpiu?id='.$model->sasaran4->sasaran3->kursusLatihanID; 
                                  return $url;
                              }
                            }
                      ],
//            [
//                'label' => 'Tindakan',
//                'format' => 'raw',
////                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
//                'value'=> function ($data){
//                                //return Html::a('<i class="fa fa-hand-o-right" aria-hidden="true"></i> PESERTA', ['value' => 'borangsemakanpeserta?id='.$lat2->kursusLatihanID, 'class' => 'btn-sm btn-primary btn-block']);
//                                return Html::a('PAPAR', 'borangsemakanpeserta?id='.$data->siriLatihanID.'&slotID='.$data->sasaran5->slotID.'&userLevel=urusetiaJfpiu', ['title' => Yii::t('app', 'Papar'), 'class' => 'btn-sm btn-primary']);
//                                //$url ='view-latihan-live?id='.$data->siriLatihanID.'&slotID='.$data->sasaran5->slotID;
//                          }     
//            ],
            
            
            
];
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
                <h2><strong><i class="fa fa-envelope"></i> Senarai Kursus <span class="label label-info" style="color: white">JFPIU</span></strong></h2>
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
                    //'filterModel' => $searchModel,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'showFooter'=>true,
                    'showHeader' => true,
                    'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'columns' => $gridColumnsA,
                ]);
                Pjax::end();
                ?>
                    </div>  
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>