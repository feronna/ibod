 <?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;

?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>  


<div class="x_panel" >
    <div class="x_title">
        <h2>CARIAN</h2>
        <p align="right">  <?= Html::a('Kembali', ['cbadmin/page'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
        <div class="clearfix"></div>
    </div></div>

<div class="x_panel">
    <div class="x_title">
        <h2><strong>REKOD BON DAN TUNTUTAN GANTI RUGI KAKITANGAN</strong></h2>
        <div class="clearfix"></div>
    </div>
<!--    <button style="float: right" class="btn btn-default" onclick="test()"><i class="fa fa-download"></i></button>-->
    <div class="x_content">

        <div class="table-responsive">

                     <?= GridView::widget([
        'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
        'options' => [
                'class' => 'table-responsive',
                    ],
        'dataProvider' => $dataProvider,
        'filterModel' => true,
//        'summary' => '',
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn',
            'header' => 'NO',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            ],
            [
                'label' => 'STATUS PERKHIDMATAN',
                   'format' => 'raw',
                         'vAlign' => 'middle',
                          'hAlign' => 'center',

                 'value'=>function ($data) {
                    return strtoupper($data->kakitangan->serviceStatus->ServStatusNm);
                },
                'filter' => Select2::widget([
                            'name' => 'khidmat',
                            'value' => $khidmat,
                            'data' => ArrayHelper::map(app\models\hronline\ServiceStatus::find()->all(), 'ServStatusCd', 'ServStatusNm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                    [
                        'label' => 'NAMA',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblLapordiri::find()->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            
                            
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
  return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->ICNO.'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>';
                                              
                            }, 
                                  
                     
//                        'value' => function($data){
//                        return Html::a($data->kakitangan->CONm).'<br/> '
//                                ;
//                        },
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                       'vAlign' => 'middle',
//                'hAlign' => 'center',
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
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPengajian::find()->joinWith('kakitangan.department')->all(), 'kakitangan.DeptId', 'kakitangan.department.shortname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                  
                            
                                
                                
                                
                           
                        
               
                        
//[
//                        'label'=>'PENGIRAAN BON',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) use ($bon) {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return 
//                        Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['v_bon', 'id' =>$data->icno]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-eye fa-md mapBtn']). ' | '.
//                        Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['a-bon', 'id' =>$data->laporID]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-md mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return " ";
//                        }
//                      },
//                               'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//                           
//                    ],
                              
                            
                              [
                        'label' => 'PERINCIAN',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
                                        'bon',
                                        'id' =>$model->icno,
//                                        'id' => $model->pengajian->id,
//                                        'i'=>$model->HighestEduLevelCd,
                                
//                                        'title' => 'personal',
                                            ], [
                                        'class' => 'btn btn-default',
                                    ]) ;
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
                                  
                'vAlign' => 'middle',
                'hAlign' => 'center',
                          
                            ],
                              
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
                
