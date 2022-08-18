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
                                return strtoupper($data->belajar->tempohpengajian);
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



<?php if($title == 'Senarai Menunggu Perakuan'){?>
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
                            'label' => 'NAMA ',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                
                                return Html::a( '<small><strong>PELANJUTAN KALI:</strong></small> '. $model->idlanjutan. '<br>'.
'<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred;
                            }, 
                                    'format' => 'html',
                        ],
                                    [
                'label' => 'TARIKH MOHON',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'tarikh_mohon',
            ],
              
           
//           [
//                'label' => 'STATUS PERAKUAN KETUA JFPIB',
//                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//                'value'=>'statusjfpiu',
//            ],
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KETUA JABATAN/DEKAN',
                            'headerOptions' => ['class'=>'text-center'],
                             'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
                                return '<strong>'.$model->statusjfpiu.'</strong><br>'
                                        .$model->app_date;
                            }, 
                                    'format' => 'html',
                                    
                                    
                        ],
                                   [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS BSM',
                            'headerOptions' => ['class'=>'text-center'],
                             'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
                                return '<strong>'.$model->statusbsm.'</strong><br>'
                                        .$model->ver_date;
                            }, 
                                    'format' => 'html',
                                    
                                    
                        ],
//              [
//                        'label'=>'SURAT KELULUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                         if ($data->checkUpload($data->id)){
//                         return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-check-square-o fa-lg', 'target' => '_blank']);}
//                        else{
//                          return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsuratlain', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
//                        }
//                      },
//             ],
//                              [
//                        'label'=>'SURAT KELULUSAN',
//                        'format' => 'raw',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],       
//                        'value'=>function ($data)  {
//                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
//                           if($data->data->dokumen)
//                           {
//                            return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-download', 'target' => '_blank']);
//                           }
//                            } else {
//                               return '<i class="fa  fa-times fa-xs style="color:black;"></i> ';
//                            }
//                      },
//             ],
                
            [
                'label' => 'TINDAKAN',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list) use ($iklan){
                            if($list->status_jfpiu === 'Tunggu Kelulusan'){
                        return  
                        Html::a('<i class="fa fa-edit">', ["tindakankj", 'id' => $list->id]);
                            }
                            else{
                        return Html::a('<i class="fa fa-edit">', ["tindakan-kj", 'id' => $list->iklan_id, 'i'=>$list->id]);
                            }
                        
                      },
            ],
            
        ],
    ]); ?>
    </div>
        </div>
     
    </div>
</div><?php }?>

