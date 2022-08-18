 <?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;
use kartik\date\DatePicker;


error_reporting(0);
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
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <p align="right">  <?= Html::a('Kembali', ['senarai-elaun'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
        <div class="form-group ">
            <div class="form-group">
                

                
             <?php $form = ActiveForm::begin([
            'action' => ['tetap'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>

                <div class=" col-md-3 col-sm-3 col-xs-12">
                <?=
                $form->field($searchModel, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\cbelajar\TblElaun::find()->all(), 'icno', 'kakitangan.CONm'),
                        'options' => ['placeholder' => 'Nama '],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
                
                
            </div>
                
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($searchModel, 'jenis_elaun')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\cbelajar\RefElaun::find()->all(), 'id', 'elaun'),
                        'options' => ['placeholder' => 'Jenis Elaun', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                
               
                
                  
                
               
                <div class=" col-md-2 col-sm-2 col-xs-12">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
<?= Html::a('Reset', ['tetap'], ['class' => 'btn btn-danger']) ?>
                </div>
            </div>
        </div> 
                <?php ActiveForm::end(); ?>   

    </div>
        </div>
    </div>
</div>


<div class="x_panel">
    <div class="x_title">
        <h2><strong>PROSES PEMBAYARAN ELAUN</strong></h2>
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
<!--    <button style="float: right" class="btn btn-default" onclick="test()"><i class="fa fa-download"></i></button>-->
          
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="x_content">
        
        <div class="table-responsive">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => false,
                'columns' => [
                         ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil',
                                'vAlign' => 'middle',
                        'hAlign' => 'center',
                                ],
                     [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($data) { 
                if(($data->status_bayaran=='0' ||$data->status_bayaran=='1')){
                return ['disabled' => 'disabled'];
                }
                return ['value' => $data->icno, 'checked'=> true];
                },
            ],
                   [
                        'label' => 'NAMA',
                        'format' => 'raw',
                        
                        
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')'.' <br>'.$model->kakitangan->department->fullname.
                                        ' ('.$model->kakitangan->department->shortname.')';
                            }, 
                                  
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        
                     
                         'group' => true,
                    ],
                                    
                                    [
                        'label' => 'JENIS ELAUN',
                        'format' => 'raw',
//                        'filter' => Select2::widget([
//                            'name' => 'elaun',
//                            'value' => isset(Yii::$app->request->queryParams['elaun'])? Yii::$app->request->queryParams['elaun']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\RefElaun::find()->all(), 'id', 'elaun'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                                
//                            ],
//                        ]),
                         'value'=>function ($data)  {
                    return $data->elaun;
                },
                                     'vAlign' => 'middle',
//                                     'hAlign' => 'center',
                       ],
//                        [
//                        'label' => 'BAYARAN',
//                        'format' => 'raw',
//
//                         'value'=>function ($data)  {
//                    return $data->amaun;
//                },
//                                     'vAlign' => 'middle',
////                                     'hAlign' => 'center',
//                       ],
// 
               [
                'label' => ' AMAUN PERLU DIBAYAR',
                'value'=>function ($data) use ($jum){
//                    var_dump ($data->tempohpengajian);
//                  var_dump($data->lah);
                    return 'RM'.$data->lah* 3;
//                    return 320 *2;
//                    return $data->am                   }
//                    else
//                    {
//                        return "Tiada Maklumat";
//                    }
              },
                
                 
                'vAlign' => 'middle',
                'hAlign' => 'center',
                          
            ],
                      
                      [
                'label' => 'TARIKH MULA PEMBAYARAN',
                'value'=>function ($data) use ($jum){
//                    var_dump ($data->tempohpengajian);
//                  var_dump($data->lah);
                   if($data->dt_sbayar)
                   {
                       return $data->dt_sbayar.' HINGGA '. $data->dt_nbayar;
                   }
                   
//                    return 320 *2;
//                    return $data->am                   }
                    else
                    {
                        return "BELUM DIPROSES";
                    }
              },
                
                 
                'vAlign' => 'middle',
                'hAlign' => 'center',
                          
            ],
//                       [
//                'label' => 'JFPIB',
//                                                     'format' => 'raw',
//
//                'value'=>function ($data) {
//                    return $data->kakitangan->department->shortname;
//                },
//                'filter' => Select2::widget([
//                            'name' => 'jfpiu',
//                            'value' => $jfpiu,
//                            'data' => ArrayHelper::map(app\models\hronline\Department::find(['isActive' => 1])->all(), 'id', 'shortname'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//            ],
                         
                                
//                    [
//                        'label'=>'TINDAKAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data)  {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['proses-elaun', 'id' =>$data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-pencil fa-md mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->laporID, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                               'vAlign' => 'middle',
//                                                'hAlign' => 'center',
////                             [ 'group'=> true,
//                           
//                    ],   
                         
                        
                                ],
                            ]);
                            ?>
           
<!--                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-paper-plane"></i>Hantar</button>-->

                        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" align="right"> 
                   
                    <div class="container">
                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">TARIKH PEMBAYARAN</button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                  <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Tarikh Mula Pembayaran<span style="color: red" class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <?=  DatePicker::widget([
                                    'name' => 'tutup',
//                                     'readonly' => true,
                                    'type' => DatePicker::TYPE_INPUT,
                                     'options' => ['placeholder' => '','autocomplete' => 'off'
                                            ],
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ]);?>
                                    </div>
                                </div>
                                  &nbsp;   &nbsp;
                                  <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Tarikh Akhir Pembayaran<span style="color: red" class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <?=  DatePicker::widget([
                                    'name' => 'tahun',
//                                     'readonly' => true,
                                    'type' => DatePicker::TYPE_INPUT,
                                     'options' => ['placeholder' => '','autocomplete' => 'off'
                                            ],
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ]);?>
                                    </div>
                                </div>

                              </div>
                              <div class="modal-footer">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                                    </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>

                      </div>
                </div> <?php ActiveForm::end(); ?>
                    </div>
    
    
                </div>


<!--//                    [
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
                            ?>-->
                        </div>
                    </div>
                </div> 

                <?php
                $icno = '';
                foreach ($dataProvider->query->all() as $d) {
                    $icno = $icno . ',' . $d->icno;
                }
                ?>
                