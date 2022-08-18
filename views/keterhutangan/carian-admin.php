<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 


<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/keterhutangan/_menu');?>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel"> 
        <div class="x_content">
            <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
                <?=
                $form->field($search, 'ICNO')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Nama Staff'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
                
                
            </div>

            <div class="col-md-1 col-sm-1 col-xs-1">
                <div class="form-group">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="x_panel"> 
        <div class="x_content">  


            <div class="table-responsive">

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Nama Pegawai',
                        'value' => function($model) {
                            return ucwords(strtolower($model->biodata->CONm));                       },
                        'format' => 'raw',
                    ],
                     
                   [
                        'label' => 'No. K/P',
                        'value' => function($model) {
                             if ($model->biodata->NatCd == "MYS") {
                                return $model->icno;
                            } else {
                                return $model->biodata->latestPaspot;
                            }
                        },
                        'format' => 'raw',
                    ],
                                
                      [
                        'label' => 'Sesi',
                        'value' => function($model) {
                             if ($model->sesi == 1) {
                                return ('Januari - Jun'); 
                            } else {
                                return 'Julai - Disember';
                            }
                        },
                        'format' => 'raw',
                    ],
                                
                      [
                        'label' => 'Tahun',
                        'value' => function($model) {
                            return $model->tahun;
                        },
                        'format' => 'raw',
                    ],
            
                      [
                        'label' => 'Sebab/Alasan',
                        'value' => function($model) {
                              if($model->tarikh_hantar == null){
                                return '<span class="label label-danger">Tiada Tindakan</span>'; 
                            }else{
                                return $model->reason;
                            }
          
                        },
                        'format' => 'raw',
                    ],
                                
                    [
                        'label' => 'Tarikh Hantar Sebab/Alasan',
                        'value' => function($model) {
                            if($model->tarikh_hantar == null){
                                return '<span class="label label-danger">Tiada Tindakan</span>'; 
                            }else{
                                return $model->tarikh_hantar;
                            }
          
                        },
                        'format' => 'raw',
                    ],
                                
                                
                       [
                            'label'=>'Lihat',
                            'format' => 'raw',
                            'value'=>function ($data){
                       
                          //   return  Html::button('<i class="fa fa-info" aria-hidden="true"></i> INFO', ['value' => \yii\helpers\Url::to(['keterhutangan/detail-view', 'id' => $data->icno]), 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                             return Html::a('<i class="fa fa-eye">', ["keterhutangan/detail-view-kj", 'id' => $data->icno]);                   

                            },
                                    
                                    
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ], 
                    
                        ];



                        echo GridView::widget([
                            'dataProvider' => $permohonan,
                            'columns' => $gridColumns,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [], 
                                ]
                            ],
                            'toolbar' => [ 
                            ],
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true, 
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h2>Senarai Keterhutangan Kewangan Serius Kakitangan</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

