<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
error_reporting(0); 
?>

<!--<div class="row">
<div class="col-md-12">
    <php echo $this->render('/tblrscoadminpost/_topmenu'); ?> 
</div>
</div>-->

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/harta/_menu');?>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
     
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>SENARAI REKOD PERISYTIHARAN HARTA</strong></h2>
        
      
                <div class="clearfix"></div>
            </div>
  
           
            <div class="x_content">
                
                <strong><p style="color: red">
               * PENYELIA HENDAKLAH MEMASTIKAN PEGAWAI PERAKU ADALAH BETUL MENGIKUT KETUA JABATAN SEMASA STAF.
               </p></strong>
                
                <strong><p style="color: red">
               * PENYELIA HENDAKLAH MEMASTIKAN KAKITANGAN DIJABATAN MEMBUAT PERISYTIHARAN HARTA.
                </p></strong>
                
                <strong><p style="color: red">
               * SEKIRANYA BERLAKU (PTB) PENYELIA HENDAKLAH MENGEMASKINI PEGAWAI PERAKU KAKITANGAN ADALAH MENGIKUT KETUA JABATAN SEMASA STAF.
                </p></strong>

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
                        'label' => 'Nama Kakitangan',
                        'value' => function($data){
                       // return Html::a($data->CONm, ["deskripsi-tugas-admin", 'id' => $data->myjd->id], ['target' => '_blank']);
                          if($data->biodataHarta->id == null){
                             return $data->CONm."</br>".'<span style="color:#FF0000;text-align:center;">** BELUM ISYTIHAR HARTA</span>';
                         }else{
                          return $data->CONm;
                        
                         }
                        
                        },
                    
                        'filter' => Select2::widget([
                        'name' => 'ICNO',
                        'value' => $ICNO,
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                       'data' =>  ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['DeptId' => Yii::$app->user->identity->DeptId])->andWhere(['Status' => 1])->all(), 'ICNO', 'CONm'),
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                        
                        'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],
                                
                   
                                
                     [
                        'label' => 'Jawatan',
                        'value' => 'jawatan.fname',
                         'filter' => Select2::widget([
                         'name' => 'gredJawatan',
                         'value' => $gredJawatan,
                          'data' => ArrayHelper::map(\app\models\hronline\GredJawatan::find()->all(), 'id', 'fname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ], 
           
                    [
                        'label' => 'JFPIU',
                        'value' => 'department.fullname',
                        'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],
                                           
                          [
                            'label'=>'Pegawai Peraku',
                            'format' => 'raw',
                            'value'=>function ($data){
                            
                        if($data->biodataHarta->id != null){
                          
                               if(!is_null($data->biodataHarta->ketua_jabatan)){
                                   return $data->biodataHarta->ketuaJabatan->CONm. "</br>". Html::a('Kemaskini Peraku', ['harta/kemaskini-data-peraku', 'id' => $data->biodataHarta->id, 'page' => Yii::$app->getRequest()->getQueryParam('page')], ['class'=>'btn btn-info btn-xs']);
                                }else{
                                return Html::a('Tambah Peraku', ['harta/kemaskini-data-peraku', 'id' => $data->biodataHarta->id], ['class'=>'btn btn-success btn-xs']);
                                }
                                  }
                              else{
                                  return  $data->biodataHarta->ketuaJabatan->CONm;
                                  
                               }
                      
                            },
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],
          
                      
                                [
                        'label' => 'Status Borang',
                        'value' => function($model) {
                             if ($model->biodataHarta->status != NULL) {
                                  return '<span class="label label-primary">TELAH DIHANTAR</span>';
                            }if (($model->biodataHarta->status == null) && ($model->biodataHarta->status_kj == 2)) {
                                  return '<span class="label label-danger">DITOLAK</span>';
                            } else {
                                  return '<span class="label label-danger">BELUM DIHANTAR</span>';
                            }
                        },
                        'format' => 'raw',
                    ],
                                
                       [
                        'label' => 'Tarikh Isytihar',
                        'value' => function($model) {
                          return  $model->biodataHarta->tarikhDihantar;
                        },
                        'format' => 'raw',
                        'hAlign' => 'center',
                        'vAlign' => 'middle',
                    ],
                                
                                
                    [
                        'label' => 'Status Perakuan Ketua Jabatan',
                        'value' => function($model) {
                            
                       
                            if ($model->biodataHarta->status_kj == null){
                             return '<span class="label label-danger">BELUM DIPERAKUKAN</span>';
                           
                            }if ($model->biodataHarta->status_kj == 1){
                             return '<span class="label label-success">DERAKUKAN</span>';
                           
                            } if ($model->biodataHarta->status_kj == 2){
                             return '<span class="label label-danger">DITOLAK</span>';
                           
                            }
                         
                       
                        },
                        'format' => 'raw',
                    ],
                         [
                        'label' => 'Perakuan Ketua Jabatan',
                        'value' => function($model) {
          
                            if ($model->biodataHarta->status_kj == null){
                             return '';
                           
                            }else{
                             return $model->biodataHarta->ulasan_kj;
                            }
                           
                       
                        },
                        'format' => 'raw',
                    ],
                                
                                         
                            ],
                                
                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                        'resizableColumns' => true,
                        'responsive' => false,
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