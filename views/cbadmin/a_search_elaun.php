 <?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;



?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>  
<?php 

$gridColumns = [
    
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'BIL',],

                        
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
                            
                            'label' => 'TARIKH PENAJAAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->dt_stajaan)).' HINGGA '.(strtoupper($data->dt_ntajaan));
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                                    [   
                            
                            'label' => 'ESH',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->esh));
                            },
                            'format' => 'raw'
                            
                        ],
                         
                                    
                           
                        
                                
                                     
                        
                        
                        
                    ];


?>

<div class="x_panel" >
    <div class="x_title">
        <h2>Carian</h2>
        <p align="right">  <?= Html::a('Kembali', ['cbadmin/page-tuntutan'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group ">
            <div class="form-group">
                

                
             <?php $form = ActiveForm::begin([
            'action' => ['search-elaun'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>

                <div class=" col-md-3 col-sm-3 col-xs-12">
                <?=
                $form->field($searchModel, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\cbelajar\TblElaun::find()->where(['bayaran'=>"UMS"])->all(), 'icno', 'kakitangan.CONm'),
                        'options' => ['placeholder' => 'Nama '],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
                
                
            </div>
                
                <div class=" col-md-3 col-sm-3 col-xs-12">
                <?=
                $form->field($searchModel, 'jenis_elaun')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\cbelajar\RefElaun::find()->all(), 'id', 'elaun'),
                        'options' => ['placeholder' => 'Jenis Elaun'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
                
                
            </div>
                
               
                
                   

                
               
                <div class=" col-md-2 col-sm-2 col-xs-12">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
<?= Html::a('Reset', ['search-elaun'], ['class' => 'btn btn-danger']) ?>
                </div>
            </div>
        </div>           
    </div>
</div>
<?php ActiveForm::end(); ?>   

<div class="x_panel">
    <div class="x_title">
        <h2><strong>REKOD KAKITANGAN YANG DILULUSKAN ELAUN</strong></h2>
        &nbsp;
     <?=
                    ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'filename' => 'Senarai Kakitangan Yang Diluluskan Elaun '.date('Y-m-d'),
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/cb/.',
                            'linkPath' => '/files/cb/',
                            'batchSize' => 10,
                        ]); 
                    ?>
        <div class="clearfix"></div>
    </div>
    <button style="float: right" class="btn btn-default" onclick="test()"><i class="fa fa-download"></i></button>
    <div class="x_content">

        <div class="table-responsive">

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => true,
                'columns' => [
                         ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil',
                                'vAlign' => 'middle',
                        'hAlign' => 'center',
                                ],
                   [
                        'label' => 'NAMA',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblElaun::find()->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                                
                            ],
                        ]),
                         'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->ICNO.'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
                            }, 
                                     'vAlign' => 'middle',
//                                     'hAlign' => 'center',
                                    'group' => true
                       ],
                                    
                                    [
                        'label' => 'JENIS ELAUN',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'jenis_elaun',
                            'value' => isset(Yii::$app->request->queryParams['jenis_elaun'])? Yii::$app->request->queryParams['jenis_elaun']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\RefElaun::find()->all(), 'id', 'elaun'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                                
                            ],
                        ]),
                         'value'=>function ($data) {
                    return $data->jenise->elaun;
                },
                                     'vAlign' => 'middle',
//                                     'hAlign' => 'center',
                       ],
//                                        [
//                'label' => 'JENIS ELAUN',
//                'value'=>function ($data) {
//                    return $data->jenise->elaun;
//                },
//                
//                 
//                'vAlign' => 'middle',
//                          
//            ], 
                                              [
                'label' => ' AMAUN PERLU DIBAYAR',
                'value'=>function ($data) {
                    
                  
                    return 'RM'.round(($data->amaun)/ 30 * ($data->tempoh));
//                    }
//                    else
//                    {
//                        return "Tiada Maklumat";
//                    }
              },
                
                 
                'vAlign' => 'middle',
                'hAlign' => 'center',
                          
            ],
                       [
                'label' => 'JFPIB',
                                                     'format' => 'raw',

                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                'filter' => Select2::widget([
                            'name' => 'jfpiu',
                            'value' => $jfpiu,
                            'data' => ArrayHelper::map(app\models\hronline\Department::find(['isActive' => 1])->all(), 'id', 'shortname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                         
                                
                    [
                        'label'=>'TINDAKAN',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data)  {
                       
                        if($data->terima == NULL){
                        $ICNO = $data->icno;
                        
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['proses-elaun', 'id' =>$data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-pencil fa-md mapBtn']);}
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
                        else{
                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->laporID, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                        }
                      },
                               'vAlign' => 'middle',
                                                'hAlign' => 'center',
                           
                    ],       
//                    [
//                        'label' => 'PERINCIAN',
//                        'value' => function($model) {
//                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
//                                        'view-ledger-tajaan',
//                                        'id' => $model->icno,
////                                        'title' => 'personal',
//                                            ], [
//                                        'class' => 'btn btn-default',
//                                        'target' => '_blank',
//                                    ]) ;
//                        },
//                                'format' => 'raw',
//                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
//                            ],
                            
                                ],
                     ]);
                            ?>
                        </div>
                    </div>
                </div> 

                <?php
                $icno = '';
                foreach ($dataProvider->query->all() as $d) {
                    $icno = $icno . ',' . $d->icno;
                }
                ?>
                