<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
error_reporting(0); 
?>


<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
     
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>SENARAI REKOD CARTA JAFPIB</strong></h2>
        
      
                <div class="clearfix"></div>
            </div>
  
           
            <div class="x_content">
                
             <div class="table-responsive">
                 
                       
                    <?=
                        GridView::widget([
                        'options' => [
                        'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        'filterModel' => true,
                        //'summary' => '',
                        //'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        //'filterModel' => $searchModel,
                        'columns' => [
                             
                                [
                         'class' => 'kartik\grid\SerialColumn',
                        'header' => 'Bil.',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
    
                               [
                        'format' => 'raw',
                        'label' => 'JAFPIB',
                        'value' => function($data){
                       return '<u>'.Html::a(strtoupper($data->fullname), ["carta-organ-jafpib", 'dept_id' => $data->id], ['target' => '_blank']).'</u>';
                   
                        },
                    
                        'filter' => Select2::widget([
                        'name' => 'id',
                        'value' => $id,
                         'data' => ArrayHelper::map(\app\models\hronline\Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname'),
                          'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                        
                        'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],        
                    
                            
                       [
                        'label' => 'Ketua Jabatan',
                        'value' => 'chiefBiodata.CONm',
                         'filter' => Select2::widget([
                         'name' => 'chief',
                         'value' => $chief,
                          'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],
                            
                            
                   [
                        'label' => 'Ketua Pentadbiran',
                        'value' => 'ppBiodata.CONm',
                         'filter' => Select2::widget([
                         'name' => 'pp',
                         'value' => $pp,
                          'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],
                            
                            
                           [
                        'label' => 'Pegawai Meluluskan',
                        'value' => 'cartaOrgan.kakitanganMelulus.CONm',
                         'filter' => Select2::widget([
                         'name' => 'icnoMelulus',
                         'value' => $icnoMelulus,
                          'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],
                                
                                
                    [
                                                'label' => 'SALINAN CARTA',
                                                'format' => 'raw',
                                                'headerOptions' => ['class' => 'text-center'],
                                                'contentOptions' => ['class' => 'text-center'],
                                                'value' => function ($data) {
                            
                            

                                            if ($data->checkUpload($data->id) && ($data->cartaOrgan->file != null) ){

                                                return Html::a('', (Yii::$app->FileManager->DisplayFile($data->cartaOrgan->file)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']);
                                            } else {
                                                return '-';
                                                
                                            }
                                            
                                            
                                        },
                                            ],
                            
                                         
                            ],
                                
                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                        'resizableColumns' => true,
                        'responsive' => false,
                                                           'pager' => [
                            'firstPageLabel' => 'Halaman Pertama',
                              'lastPageLabel'  => 'Halaman Terakhir'
    ],
                        'responsiveWrap' => false,
                        'floatHeader' => true,
                        'floatHeaderOptions' => ['position' => 'absolute'],
                        'resizableColumnsOptions' => ['resizeFromBody' => true]
                                
                        ]);
                    ?>
                </div>

            </div>
            
                 
        </div>
    </div>
</div>