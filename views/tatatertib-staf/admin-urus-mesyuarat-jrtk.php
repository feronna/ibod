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

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
            <p align="right"> 
         <?= Html::a('Kembali', ['tatatertib-staf/index'], ['class' => 'btn btn-primary btn-sm']) ?>
        </p>
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Mesyuarat Jawatankuasa Rayuan Tatatertib Kakitangan</strong></h2>
        
      
                <div class="clearfix"></div>
            </div>
             <?php   echo Html::a('<span class="fa fa-info-circle" aria-hidden="true">  Tambah Mesyuarat</span>', ['tatatertib-staf/admin-tambah-mesyuarat-jrtk'], ['class' => 'btn btn-success btn-block']); 
               //echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tatatertib-staf/admin-tambah-mesyuarat']), 'class' => 'fa fa-plus mapBtn btn btn-info']);
               ?>
           
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
                        'label' => 'Nama Mesyuarat',
                        'value' => function($data){
                        return Html::a($data->nama_mesyuarat, ["detail-mesyuarat", 'id' => $data->id], ['target' => '_blank']);
                        },
                        'filter' => Select2::widget([
                        'name' => 'nama_mesyuarat',
                        'value' => $nama_mesyuarat,
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                       'data' => ArrayHelper::map(\app\models\tatatertib_staf\TblUrusMesyuaratJrtk::find()->orderBy(['nama_mesyuarat' => SORT_ASC])->all(), 'nama_mesyuarat', 'nama_mesyuarat'),
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                
                    [
                        'label' => 'Tarikh Mesyuarat',
                        'attribute' => 'tarikhMesyuarat',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ], 
           
                    [
                        'label' => 'Tempat Mesyuarat',
                        'value' => 'tempat_mesyuarat',
                         'filter' => Select2::widget([
                         'name' => 'tempat_mesyuarat',
                         'value' => $tempat_mesyuarat,
                          'data' => ArrayHelper::map(\app\models\tatatertib_staf\TblUrusMesyuaratJrtk::find()->orderBy(['tempat_mesyuarat' => SORT_ASC])->all(), 'tempat_mesyuarat', 'tempat_mesyuarat'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ], 
                                
                  
                                
                    [
                        'label' => 'Pengerusi',
                        'attribute' => 'namaPengerusi.CONm',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ], 
                                 
                     
                     [
                        'header' => 'Status',
                        'attribute' => 'displayflag.flagstatus',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'filter' => Select2::widget([
                            'name' => 'flag',
                            'value' => $status,
                            'data' => 
                             [
                                '1' => '<span class="label label-success">Aktif</span>',
                                '2' => '<span class="label label-danger">Tidak Aktif</span>'],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            ],
                        ]),
                    ],
                                
                    [
                        'label' => 'Kemaskini',
                        'value' => function($model) {
                            return 
                          Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['admin-kemaskini-urus-mesyuarat', 'id' => $model->id]);
        
                           // Html::button('', ['value' => \yii\helpers\Url::to(['delete-urus-mesyuarat', 'id' => $model->id]), 'class' => 'btn btn-default fa fa-window-close mapBtn']);
                        },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 10%;'],
                    ],
                     
                        [
                        'label' => 'Padam',
                        'value' => function($model) {
                            return 
                          Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-urus-mesyuarat', 'id' => $model->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]);
                           // Html::button('', ['value' => \yii\helpers\Url::to(['delete-urus-mesyuarat', 'id' => $model->id]), 'class' => 'btn btn-default fa fa-window-close mapBtn']);
                        },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 10%;'],
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