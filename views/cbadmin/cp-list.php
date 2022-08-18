<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use app\models\cuti\Layak;
use yii\widgets\ActiveForm; 


error_reporting(0);
$this->title = 'SENARAI MENUNGGU SEMAKAN';
?>
<?php echo $this->render('/cutibelajar/_topmenu');?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


<p align="right"><?= Html::a('Kembali', ['page-semak'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
    <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 
             <div class="x_title">
                <h5><b> <i class="fa fa-th-list"></i> SENARAI PERMOHONAN CUTI PENYELIDIKAN</b></h5><div  class="pull-right">
            </div>
            
        </div>


            <div class="table-responsive">

                <?php
                $gridColumns3 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],
                    
                    [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA KAKITANGAN',
                             'options' => ['style' => 'width:30%'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return                                
                                

                                Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.
                                        $model->kakitangan->jawatan->gred.'<br>Tarikh Mohon: '.$model->mohon_dt;
                            }, 
                                    'format' => 'html',
                        ],
                                    
                                    
                         [
                           //'attribute' => 'CONm',
                            'label' => 'MAKLUMAT CUTI',
                             'options' => ['style' => 'width:30%'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                if($model->remark)
                                {
                                return Html::a('<strong>'.$model->jenisCuti->jenis_cuti_catatan.'</strong>').
                                        '<br><i class="fa fa-calendar fa-lg" style="color:green"></i> :'.$model->full_date.
                                        '<br>Tempoh: '.$model->tempohpenyelidikan.
                                        '<br>Catatan: '.$model->remark.'<br>';
                                }
                                else
                                {
                                    return Html::a('<strong>'.$model->jenisCuti->jenis_cuti_catatan.'</strong>').
                                        '<br><i class="fa fa-calendar fa-lg" style="color:green"></i> :'.$model->full_date.
                                         '<br>Tempoh: '.$model->tempohpenyelidikan.
                                        '<br>Catatan: - <br>';
                                }
                            }, 
                                    'format' => 'html',
                        ],
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS',
                            'headerOptions' => ['style' => 'width:10%', 'class' => 'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                if($model->status == "APPROVED")
                                {
                                return Html::a('<strong> <span class="label label-success">'.$model->status.'</span></strong> '
                                        .$model->peraku_dt);
                                }
                                elseif($model->status == "ENTRY")
                                {
                                    return Html::a('<strong> <span class="label label-default">'.$model->status.'</span></strong>'
                                             .$model->mohon_dt);

                                }
                                  elseif($model->status == "CHECKED")
                                {
                                    return Html::a('<strong> <span class="label label-warning">'.$model->status.'</span></strong>'
                                            .$model->semakan_dt);

                                }
                                 
                                else
                                {
                                    return Html::a('<strong> <span class="label label-info">'.$model->status.'</span></strong>');
  
                                }
                            }, 
                                    'format' => 'html',
                        ],
                          
                         [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'PERMOHONAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $apps)  {
                                
                                
                                    $url = Url::to(['cbadmin/cp-details-bsm', 'id' => $apps->id]);
                                    return Html::button('<i class="fa fa-search"></i> Lihat ', ['value' => $url, 'class' => 'btn btn-primary btn-sm modalButton']);
                               
                                },
                            ],
                        ],
                                        
                         [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'TINDAKAN BSM',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $apps) {
                                    $url = Url::to(['cbadmin/leave-detail-lulus', 'id' => $apps->id]);
                                    return Html::button('<i class="fa fa-check"></i> Keputusan ', ['value' => $url, 'class' => 'btn btn-success btn-sm modalButton']);
                                    
                                },
                            ],
//                            [
//                                'class' => 'yii\grid\CheckboxColumn',
//                                'checkboxOptions' => function ($model) {
//                                    var_dump($model);die;
//                                    return ['value' => $model->id];
//                                }
//                                    ],
                        ],                           
//                         [
//                           //'attribute' => 'CONm',
//                            'label' => 'TINDAKAN',
//                             'options' => ['style' => 'width:30%'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                return Html::a('<strong>'.$model->jenisCuti->jenis_cuti_catatan.'</strong>').
//                                        '<br><i class="fa fa-calendar fa-lg" style="color:green"></i> :'.$model->full_date.
//                                        '<br><small>Catatan: '.$model->remark.'</small><br>';
//                            }, 
//                                    'format' => 'html',
//                        ],
                    
                        ];



                        echo GridView::widget([
                            'dataProvider' => $cp,
                            'columns' => $gridColumns3,
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
                                'heading' => '<h6><i class="fa fa-book fa-lg" style="color:green"></i> Permohonan Cuti Penyelidikan</h6>',
                            ],
                        ]);
                        ?>
            </div>
        
       
                                <?php ActiveForm::end(); ?>


        </div>
    </div>  
<div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="tile-stats" style='padding:10px'>
                        <div class="x_content">

                            <div style='padding: 15px;' class="table-bordered">
                                <font><u><strong>RUJUKAN /<i> REFERENCE</i></u> </strong></font><br><br>

                                <span class="label label-default">ENTRY</span> : Permohonan Baru / <i>New Leave Application</i> &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <span class="label label-warning">CHECKED</span> : Permohonan Cuti Diperaku Ketua Jabatan / <i>Leave Application Has Been Verified</i>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <span class="label label-info">VERIFIED</span> : Permohonan Cuti Diperaku NC / <i>Leave Application Has Been Verified</i>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <span class="label label-success">APPROVED</span> : Permohonan Cuti Diluluskan / <i> Leave Application Has Been Approved</i>


                            </div>
                        </div>

                    </div>
                </div>
</div>
