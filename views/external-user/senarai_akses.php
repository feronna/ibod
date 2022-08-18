<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TblBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<p align="right">   <?= Html::a('Tambah', ['register-external-user'], 
                        ['class' => 'btn btn-success btn-sm',    'target' => '_blank',]) ?>
                            </p>
<!--<div class="x_panel" >
    <div class="x_title">
        <h5>CARIAN PENGGUNA</h5>
        
        
        <div class="clearfix"></div>
    </div>
</div>-->

<div class="x_panel">
    <div class="x_title">
        <h5><strong><i class="fa fa-th-list"></i> LIST OF EXTERNAL USER</strong></h5>
         &nbsp;
   
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="table-responsive">

            <?=
            GridView::widget([
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
            'header' => 'No',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            ],
            
            [
                'label' => 'USERID',
                   'format' => 'raw',
//                         'vAlign' => 'middle',
//                          'hAlign' => 'center',

                 'value'=>function ($data) {
                    return '<small>'. strtoupper($data->user_id). '</small>';
                },
              
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
            ],
          
            [
                'label' => 'USER NAME',
                   'format' => 'raw',
                 'filter' => Select2::widget([
                            'name' => 'name',
                            'value' => isset(Yii::$app->request->queryParams['name'])? Yii::$app->request->queryParams['name']:'',
                            'data' => ArrayHelper::map(\app\models\system_core\ExternalUser::find()->all(), 'name', 'name'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                             'allowClear' => true
                            ],
                        ]),
//                         'vAlign' => 'middle',
//                          'hAlign' => 'center',

                 'value'=>function ($data) {
                    return '<small>'. strtoupper($data->name). '</small>';
                },
              
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
            ],
            [
                'label' => 'EMAIL',
                   'format' => 'raw',
//                         'vAlign' => 'middle',
//                          'hAlign' => 'center',

                 'value'=>function ($data) {
                    return ($data->username);
                },
              
                
            ],
                         [
                'label' => 'ACCESS',
                   'format' => 'raw',
//                         'vAlign' => 'middle',
//                          'hAlign' => 'center',

                 'value'=>function ($data) {
                    
                    if($data->access == 1){
            return '<span class="label label-success">YES</span>';
                    }
                    else{
            return '<span class="label label-danger">NO</span>';
                    }
                    
                },
              
               'vAlign' => 'middle',
                'hAlign' => 'center',   
            ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'TINDAKAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['update', 'id' => $model->id]);
                                    return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
                        
//                        [
//                        'label'=>'KEMASKINI',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data)  {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->username;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['update', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-md mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $nd->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                          'vAlign' => 'middle',
//                'hAlign' => 'center',  
//                    ],
////                            
//            [
//                'label' => 'JAWATAN',
//                   'format' => 'raw',
////                         'vAlign' => 'middle',
////                          'hAlign' => 'center',
//
//                 'value'=>function ($data) {
//                    return '<small>'. strtoupper($data->jawatan).'</small>';
//                },
//              
//                
//            ],
//                        [
//                'label' => 'JABATAN',
//                   'format' => 'raw',
////                         'vAlign' => 'middle',
////                          'hAlign' => 'center',
//
//                 'value'=>function ($data) {
//                    return '<small>'. strtoupper($data->jabatan). '</small>';
//                },
//              
//                
//            ],
//                         [
//                'label' => 'NAMA KAKITANGAN',
//                   'format' => 'raw',
////                         'vAlign' => 'middle',
////                          'hAlign' => 'center',
//
//                 'value'=>function ($data) {
//                    return strtoupper($data->staff_icno);
//                },
//              
//                
//            ],
                        
                      
            
//                    [
//                        'label' => 'NAMA',
//                        'format' => 'raw',
//                        
//                        
//                            'value' => function($model) {
////                                $ICNO = $model->icno;
////                                $id = $model->laporID;
//                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').
//                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')'.' <br>'.$model->kakitangan->department->fullname.
//                                        ' ('.$model->kakitangan->department->shortname.')';
//                            }, 
//                                  
////                        'contentOptions' => ['style' => 'text-decoration: underline;'],
//                        'vAlign' => 'middle',
//                        
//                     
////                         'group' => true,
//                    ],
//                            
//                               [                      'label' => 'PERINGKAT PENGAJIAN',
//                       'value' => function($model) {
//                          if($model->tahapPendidikan)
//                                {
//                                return strtoupper($model->tahapPendidikan);}
//                       },
//                               'vAlign' => 'middle',
//                                               'hAlign' => 'center',
//
//                   ],
                                
//[
//                        'label' => 'PERINGKAT PENGAJIAN',
//                        'format' => 'raw',
//                        'filter' => Select2::widget([
//                            'name' => 'HighestEduLevelCd',
//                            'value' => isset(Yii::$app->request->queryParams['HighestEduLevelCd'])? Yii::$app->request->queryParams['HighestEduLevelCd']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\Edulevel::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
//                            
//                             'value'=>function ($model)  {
//                    
//                             if($model->HighestEduLevel)
//                             {
//                             return $model->HighestEduLevel;}
//                             else
//                             {
//    return strtoupper($model->tahapPendidikan);
//                             }
//                },
//                            
//                     
//                        'vAlign' => 'middle',
//                'hAlign' => 'center', 
//                     
//                    ],
                    
                                      
//                                [
//                        'label' => 'JENIS TAJAAN',
//                        'value' => function($model) {
//                            return strtoupper($model->nama_tajaan);
//                        },
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//
//                    ],
////                           [
//                'label' => 'JFPIB',
//                'value'=>function ($data) {
//                    return $data->kakitangan->department->shortname;
//                },
//                
//                 
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//                          
//            ],

//                                [
//                        'label'=>'TINDAKAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data)  {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['view_biasiswa', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-md mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                               'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//                           
//                    ],
////                              
//                            [
//                                'class' => 'yii\grid\CheckboxColumn',
//                                'checkboxOptions' => function ($model, $key, $index, $column) {
//
//                                    return ['value' => $model->icno, 'id' => $model->icno, 'onclick' => 'check(this.value, this.checked)'];
//                                }
//                                    ],
                                ],
                                             'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => false,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                        
                            ]);
                            ?>
                        </div>
                    </div>
                </div> 
