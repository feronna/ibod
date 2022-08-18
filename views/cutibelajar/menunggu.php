<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url; 

error_reporting(0);
?>
<?php echo $this->render('/cutibelajar/_topmenu');?>
<div class="row" style="display: <?php echo $displaypentadbiran;?>"> 
       <div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $titlepentadbiran;?></strong></h2>
           
            <div class="clearfix"></div>
        </div>
        <center><h4><strong> Permohonan Pengajian Lanjutan (Akademik)</strong></h4></center>
        <div class="x_content">
             <?= GridView::widget([
        'dataProvider' => $senaraipentadbiran,
        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                ],
            [
                           //'attribute' => 'CONm',
                            'label' => 'JENIS PERMOHONAN',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->borang->alt.'</strong>');
                            }, 
                                    'format' => 'html',
                                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                        ],
            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small><b>('.$model->kakitangan->COOldID.')</b></small>'.'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred.'<br>Tarikh Mohon: '. $model->tarikhmohon;
                            }, 
                                    'format' => 'html',
                        ],
     
                                      [
                           //'attribute' => 'CONm',
                            'label' => 'PERINGKAT PENGAJIAN YANG DIPOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->study->pendidikanTertinggi->HighestEduLevel.'</strong>').'<br>'.$model->study->tarikhmula.' - '.$model->study->tarikhtamat.'<br>Tempoh Pengajian: '.
                                        $model->study->tempohpengajian.'<br>'.
                                        'Institusi: '.$model->study->InstNm;
                            }, 
                                    'format' => 'html',
                        ],
//            [
//                'label' => 'PERINGKAT PENGAJIAN YANG DIPOHON',
//                'value' => 'pengajian.pendidikanTertinggi.HighestEduLevel',
//            ],                     
            [
                'label' => 'STATUS PERAKUAN KETUA JABATAN',
                'format' => 'raw',
                'value'=>function ($data)  {

                      if($data->status_jfpiu == 'Diperakukan' || $data->status_jfpiu == 'Tidak Diperakukan'){
                           return $data->statusjfpiu. '<br><br> '. '[Tarikh  Perakuan:'.' '. $data->app_date.']';
                       }
                        else {
                              return $data->statusjfpiu;
                          } 
                      },
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
            ],
            [
                'label' => 'STATUS BSM',
                'format' => 'raw',
                'value'=>function ($data) {
                
                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
                            return $data->statusbsm.'<br><br> '. '[Tarikh  Diluluskan:'.' '. $data->ver_date.']';;
                        }
                       
                        else {
                              return $data->statusbsm;
                          }  
                      },
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
            ],
            [
                        'label'=>'SALINAN SURAT',
                        'format' => 'raw',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'value'=>function ($data)  {
                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
                           
                            return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-download', 'target' => '_blank']);

                            } else {
                                return 'Belum Dimuatnaik';
                            }
                      },
             ],
            [
                'label' => 'TINDAKAN',
                'format' => 'raw',
                'value'=>function ($data, $url) use($titlepentadbiran){
                          
                       if($titlepentadbiran == 'Senarai Menunggu Perakuan'){
                            $ICNO = $data->icno;
                            $url = Url::to(["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO, 'takwim_id'=>$data->iklan_id ]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                       }
                        
                      },

                      'vAlign' => 'middle',
                        'hAlign' => 'center',
            ],
         
        ],
    ]); ?>
    </div>
        
    </div>
</div>
    
    
</div>