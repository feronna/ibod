<?php
 
use kartik\grid\GridView; 
use yii\helpers\Html; 
use yii\helpers\Url; 

?> 
<?= $this->render('/cutibelajar/_topmenu') ?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 
        <div class="x_content">  


            <div class="table-responsive">

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],
//                    [
//                           //'attribute' => 'CONm',
//                            'label' => 'JENIS PERMOHONAN',
//                            'headerOptions' => ['class'=>'text-center'],
//                                        'options' => ['style' => 'width:20%'],
//
//                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong>');
//                            }, 
//                                    'format' => 'html',
//                        ],
                    [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>', ['/tiketpenerbangan/kj-view', 'id' => $model->id]).' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred;
                            }, 
                                    'format' => 'html',
                        ],
                      [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS BSM',
                            'headerOptions' => ['class'=>'text-center'],
                                        'options' => ['style' => 'width:20%'],

                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                    return '<span class="label label-success">'.strtoupper($model->status_bsm).'</span>'.
                                    '<br><small>'.$model->no_peruntukan.'<small>';
                            }, 
                                    'format' => 'html',
                        ],
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KETUA JABATAN',
                            'headerOptions' => ['class'=>'text-center'],
                                        'options' => ['style' => 'width:20%'],

                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                if($model->status_kj)
                                {
                                    return '<span class="label label-success">'.$model->status_kj.'</span>';
                                }
                                else
                                {
                                    return '<span class="label label-warning">MENUNGGU SEMAKAN KJ</span>';
                                }
                            },
                                    'format' => 'html',
                        ],
                      
                               
                                 [
                'label' => 'TINDAKAN',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],                        
                'contentOptions' => ['class'=>'text-center'],                        
                'value'=>function ($model,$url) {
                    
                                
                                  if($model->borangID == 34)
                                {
                                      $url = Url::to(["tiketpenerbangan/kj-view-tuntutan", 'id' => $model->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
                                }
                                else{
                                    
                                      $url = Url::to(["tiketpenerbangan/kj-view", 'id' => $model->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
                                }
//                            $url = Url::to(["tiketpenerbangan/kj-view", 'id' => $model->id]);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                       return Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
//                                                            'title' => 'Lihat Permohonan']);
//                          return 
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                       },
                        
                     

                    
            ],
                        ];



                        echo GridView::widget([
                            'dataProvider' => $permohonan,
                            'columns' => $gridColumns,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [ ],
                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                ]
                            ],
                            'toolbar' => [ 
                                ['content' => '']
                            ], 
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,  
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h5>MENUNGGU TINDAKAN -  PERMOHONAN TEMPAHAN TIKET PENERBANGAN</h5>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  
</div>

