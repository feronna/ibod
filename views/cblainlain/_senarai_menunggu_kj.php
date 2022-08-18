<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url; 
use yii\widgets\ActiveForm;

error_reporting(0);
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
                                'header' => 'BIL',
                                ],
            [
                           //'attribute' => 'CONm',
                            'label' => 'JENIS PERMOHONAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong>');
                            }, 
                                    'format' => 'html',
                        ],
           [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
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
    
                                     [
                'label' => 'STATUS  KETUA JABATAN/DEKAN',
                'format' => 'raw',
                 'headerOptions' => ['class'=>'text-center'],
                 'contentOptions' => ['class'=>'text-center'],                        
                'value'=>function ($data)  {

                      if($data->status_jfpiu == 'Diperakukan' || $data->status_jfpiu == 'Tidak Diperakukan'){
                           return $data->statusjfpiu. '<br>'.' '. $data->app_date;
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
                            return $data->statusbsm.'<br><br> '. '[Tarikh  Diluluskan:'.' '. $data->ver_date.']';;
                        }
                       
                        else {
                              return $data->statusbsm;
                          }  
                      },
                        
            ],
            
           
//              [
//                        'label'=>'SURAT KELULUSAN',
//                        'format' => 'raw',
//                          
//                        'value'=>function ($data)  {
//                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
//                           
//                            return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-download', 'target' => '_blank']);
//
//                            } else {
//                                return 'Belum Dimuatnaik';
//                            }
//                      },
//             ],
                              [
                        'label'=>'SURAT KELULUSAN',
                        'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],       
                        'value'=>function ($data)  {
                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
                           
                            return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-download', 'target' => '_blank']);

                            } else {
                               return '<i class="fa  fa-times fa-xs style="color:black;"></i> ';
                            }
                      },
             ],
                                 
              
           [
                'label' => 'TINDAKAN',
                'format' => 'raw',
                'contentOptions' => ['class'=>'text-center'],                        
                'value'=>function ($data, $url) use($title){
                          
//                      if($data->status_jfpiu === 'Tunggu Kelulusan'){
//                        return  
//                        Html::a('<i class="fa fa-edit">', ["tindakankj", 'id' => $list->id]);
//                            }
                            if($data->idBorang == 22){
                        return Html::a('<i class="fa fa-edit">', ["tindakan-kjbidang", 'id' => $data->iklan_id, 'i'=>$data->id]);
                            }
                             elseif($data->idBorang == 23){
                        return Html::a('<i class="fa fa-edit">', ["tindakan-kjtarikh", 'id' => $data->iklan_id, 'i'=>$data->id]);
                            }
                             elseif($data->idBorang == 24){
                        return Html::a('<i class="fa fa-edit">', ["tindakan-kj", 'id' => $data->iklan_id, 'i'=>$data->id]);
                            }
                             elseif($data->idBorang == 31){
                        return Html::a('<i class="fa fa-edit">', ["tindakan-kjtangguh", 'id' => $data->iklan_id, 'i'=>$data->id]);
                            }
                             elseif($data->idBorang == 49){
                        return Html::a('<i class="fa fa-edit">', ["tindakan-kjmod", 'id' => $data->iklan_id, 'i'=>$data->id]);
                            }
                        
                      },

                    
            ],
         
            
        ],
    ]); ?>
    </div>
        </div>
     
    </div>
</div><?php }?>
 <?php if($title == 'Senarai Menunggu Kelulusan'){?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
        'dataProvider' => $senarai,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
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
                'label' => 'Nama Pemohon',
                'value' => 'kakitangan.CONm',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Jenis Permohonan',
                'value' => 'displayjenis.kemudahan',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Tarikh Mohon',
                'value' => 'entrydate',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
           
           
            [
                'label' => 'Status Ketua BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'status_jfpiu',
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list){
                            if($list->status_kj == 'MENUNGGU TINDAKAN'   ){
                        return  
                        Html::a('<i class="fa fa-edit">', ["borangyuran/tindakan_kj", 'id' => $list->id]);
                            }
                            else{
                        return Html::a('<i class="fa fa-edit">', ["borangyuran/tindakan_kj", 'id' => $list->id]);
                            }
                        
                      },
            ],
            
        ],
    ]); ?>
    </div>
        </div>
     
    </div>
</div><?php }?>