<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url; 
use yii\widgets\ActiveForm;

error_reporting(0);
?>
<?php if($title == 'Senarai Menunggu Semakan'){?>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

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
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ['/cutisabatikal/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id'=>$model->iklan_id]).' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>';
//                                       '<br>Tarikh Mohon:'. $model->tarikhmohon;
                            }, 
                                    'format' => 'html',
                        ],
                                    
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'FPIU',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                return Html::a('<strong>'.$model->kakitangan->department->shortname.'</strong>');
                            },
                                    'format' => 'html',
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'JAWATAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                return Html::a($model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred.' ');
                            },
                                    'format' => 'html',
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'PERINGKAT PENGAJIAN YANG DIPOHON',
                            'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],

                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->study->pendidikanTertinggi->HighestEduLevel.'</strong>')
                                      .'<br>'.$model->study->InstNm;
                            }, 
                                    'format' => 'html',
                        ],    
                       [
                           //'attribute' => 'CONm',
                            'label' => 'PEMBIAYAAN / PINJAMAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->biasiswa->nama_tajaan);
                            }, 
                                    'format' => 'html',
                        ],
                       
                        [
                                            'header' => 'LKK',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model) 
                                                {
                                                        $ICNO = $model->icno;
                                                        $url = Url::to(['cbadmin/view-lkk', 'id'=>$ICNO]);
                                                       return 
                                                        Html::a('<i class="fa fa-file fa-xs"></i>', $url, ['title' => 'Lihat Data']); 
                                                    
                                                },
                                                        
                                                
                                                
                                        ],
                                                
                                            'contentOptions' => ['class' => 'text-center'],
                                        ]
                              
                    
             
            
                              
            
                   
            
        ],
    ]); ?>
    </div>
        </div>
          <div class="col-md-12 col-sm-12 col-xs-12" align="right"> 
                    <?= Html::a('<i class="fa fa-book"></i> Statisik Data', ['ringkasan_data'], ['class'=>'btn btn-danger', 'target' => '_blank']) ?>
                </div>
      <?php ActiveForm::end(); ?>
    </div>
</div><?php }?>


 