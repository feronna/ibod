<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\helpers\Url; 
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\export\ExportMenu;
use app\models\cbelajar\TblWarta;
error_reporting(0);
?>
 <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

    <?php 

$gridColumns = [
    
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'BIL',],

                        [   
                            
                            'label' => 'JENIS PERMOHONAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->jenis));
                            },
                            'format' => 'raw'
                            
                        ],
                        [   
                            
                            'label' => 'NAMA KAKITANGAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->kakitangan->CONm));
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                             [   
                            
                            'label' => 'NO KAD PENGENALAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->icno));
                            },
                            'format' => 'raw'
                            
                        ],
                         [
                'label' => 'JFPIB',
                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                
                                            'format' => 'raw'

                          
            ],
                        [   
                            
                            'label' => 'PERINGKAT PENGAJIAN',
                            'value' => function ($data) {
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->belajar->tahapPendidikan));
                            },
                            'format' => 'raw'
                            
                        ],
                               
                         [   
                            
                            'label' => 'INSTITUT/UNIVERSITI',
                            'value' => function ($data) {
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->belajar->InstNm));
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                                 
                        [   
                            
                            'label' => 'NEGARA',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->belajar->negara->Country);
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                           [   
                            
                            'label' => 'BIDANG',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                              
                                if(($data->belajar->MajorCd == NULL) && ($data->belajar->MajorMinor != NULL))
                        {
                                return  strtoupper($data->belajar->MajorMinor);
                        }
                        elseif (($data->belajar->MajorCd != NULL) && ($data->belajar->MajorMinor != NULL))  {
                            return   strtoupper($data->belajar->MajorMinor);

                        }
                        else
                        {
                          return   strtoupper($data->belajar->major->MajorMinor);
                        }
                            },
                            'format' => 'raw'
                            
                        ],
                        
                         [   
                            
                            'label' => 'TARIKH PENGAJIAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->belajar->tarikhmula).' HINGGA '.strtoupper($data->belajar->tarikhtamat);
                            },
                            'format' => 'raw'
                            
                        ], 
                                    [   
                            
                            'label' => 'TEMPOH PENGAJIAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->belajar->tempohtajaan);
                            },
                            'format' => 'raw'
                            
                        ], 
                                    [   
                            
                            'label' => 'TAJAAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->tajaan->penajaan->penajaan).' -'.strtoupper($data->tajaan->nama_tajaan);
                            },
                            'format' => 'raw'
                            
                        ], 
                                    [   
                            
                            'label' => 'STATUS SEMAKAN BORANG',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->status_semakan);
                            },
                            'format' => 'raw'
                            
                        ], 
                                    
                        
                        
                        
                        
                    ];


?>



<?php if($title == 'Permohonan Baharu'){?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
        'dataProvider' => $senarai,
        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                 'options' => [
                'class' => 'table-responsive',
                    ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',
                                ],
            
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                             'options' => ['style' => 'width:30%'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred;
                            }, 
                                    'format' => 'html',
                        ],
             [
                           //'attribute' => 'CONm',
                            'label' => 'PERINGKAT PENGAJIAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong><small>'.strtoupper($model->s->tahapPendidikan).'</strong></small>');
                            }, 
                                    'format' => 'html',
                        ],
           
           [
                           //'attribute' => 'CONm',
                            'label' => 'MAKLUMAT PENGAJIAN',
                             'options' => ['style' => 'width:30%'],
                            'headerOptions' => ['class'=>'text-center'],

                                           'contentOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],                            
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return '<small>'.Html::a(ucwords(strtoupper($model->s->InstNm)).'<br>'. (ucwords(strtoupper($model->s->tarikhmula))).' - '. (ucwords(strtoupper($model->s->tarikhtamat)))
                                        .'<br> ('. (ucwords(strtoupper($model->s->tempohtajaan))).')<br></small>'
                                );
                            }, 
                                    'format' => 'html',
                        ],
                                     [
                'label' => 'STATUS KETUA JABATAN/DEKAN',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],       
                'value'=>function ($data)  {

                      if($data->status_jfpiu == 'Diperakukan' || $data->status_jfpiu == 'Tidak Diperakukan'){
                           return $data->statusjfpiu. '<br> '. $data->app_date;
                       }
                        else {
                              return $data->statusjfpiu;
                          } 
                      },
                        
            ],
           
            [
                'label' => 'STATUS BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],           
                'value'=>function ($data) {
                
                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
                            return $data->statusbsm.'<br><br> '. ' '. $data->ver_date;
                        }
                       
                        else {
                              return $data->statusbsm;
                          }  
                      },
                        
            ],
            
           
              
                                 
              
           [
                'label' => 'TINDAKAN',
                'format' => 'raw',
                'contentOptions' => ['class'=>'text-center'],                        
                'value'=>function ($data, $url) use($title){
                          
                       if($data->idBorang == 1){
                            $ICNO = $data->icno;
                            $url = Url::to(["sepenuh-masa/pa-view", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id'=>$data->iklan_id ]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                       }
                       elseif($data->idBorang == 32){
                            $ICNO = $data->icno;
                            $url = Url::to(["pentadbiran/pa-view", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id'=>$data->iklan_id ]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                       }
                        elseif($data->idBorang == 38){
                            $ICNO = $data->icno;
                            $url = Url::to(["separuh-masa/pa-view", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id'=>$data->iklan_id ]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                       }
                       elseif($data->idBorang == 40){
                            $ICNO = $data->icno;
                            $url = Url::to(["sangkutan/pa-view", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id'=>$data->iklan_id ]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                       }
                       elseif($data->idBorang == 41){
                            $ICNO = $data->icno;
                            $url = Url::to(["pra-warta/pa-view", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id'=>$data->iklan_id ]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                       }
                        elseif($data->idBorang == 42){
                            $ICNO = $data->icno;
                            $url = Url::to(["pos-doktoral/pa-view", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id'=>$data->iklan_id ]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                       }
                        elseif($data->idBorang == 43){
                            $ICNO = $data->icno;
                            $url = Url::to(["sub-kepakaran/pa-view", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id'=>$data->iklan_id ]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                       }
                        elseif($data->idBorang == 39){
                            $ICNO = $data->icno;
                            $url = Url::to(["latihan-industri/pa-view", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id'=>$data->iklan_id ]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                       }
                       elseif($data->idBorang == 44){
                            $ICNO = $data->icno;
                            $url = Url::to(["cuti-penyelidikan/pa-view", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id'=>$data->iklan_id ]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                       }
                        elseif($data->idBorang == 2){
                            $ICNO = $data->icno;
                            $url = Url::to(["sabatikal/pa-view", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id'=>$data->iklan_id ]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                       }
                       
//                       else{
//                                                       $ICNO = $data->icno;
//
//                           $url = Url::to(["cutisabatikal/pa-view", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id'=>$data->iklan_id ]);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
//                                                            'title' => 'Lihat Permohonan']);
//                       }
                        
                      },

                    
            ],
         
            
        ],
    ]); ?>
    </div>
        </div>
  <?php }?>
   
    </div>
</div>