<?php
use kartik\export\ExportMenu;
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
        <div class="x_panel">
                 <p align="right"> 
         <?= Html::a('Kembali', ['hrpayroll/index'], ['class' => 'btn btn-primary btn-sm']) ?>
        </p>
            <div class="x_title">
                <h2><strong>SENARAI PROFIL GAJI KAKITANGAN</strong></h2>
<!--                <p align="right"><= \yii\helpers\Html::a('Kembali', ['halaman-utama-keseluruhan'], ['class' => 'btn btn-primary']) ?></p>   -->
                <div class="clearfix"></div>
            </div>
           <?php
            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'clearBuffers' => true,
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'headerOptions' => [
                            'style' => 'display: none;',
                        ]
                    ],
                    
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
                        return Html::a($data->CONm, ["list-kakitangan-keseluruhan", 'id' => $data->ICNO], ['target' => '_blank']);
                        },
                        'filter' => Select2::widget([
                        'name' => 'ICNO',
                        'value' => $ICNO,
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                       'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(),
                        'ICNO', 'CONm'),
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],
                                
                      [
                        'label' => 'Jawatan',
                        'value' => 'jawatan.fname',
                         'filter' => Select2::widget([
                         'name' => 'gredJawatan',
                         'value' => $gredJawatan,
                          'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->orderBy(['gredJawatan' => SORT_ASC])->all(), 'gredJawatan', 'jawatan.fname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],    
                       
                                
                     [
                        'label' => 'JFPIB',
                        'value' => 'department.fullname',
                         'filter' => Select2::widget([
                         'name' => 'DeptId',
                         'value' => $DeptId,
                          'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->orderBy(['DeptId' => SORT_ASC])->all(), 'DeptId', 'department.fullname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],    
                                
                                
                     [
                        'label' => 'Kampus',
                        'value' => 'kampus.campus_name',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ], 
                       
               
                ],
                'exportConfig' => [ // set styling for your custom dropdown list items
                    ExportMenu::FORMAT_CSV => false,
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_EXCEL => false,
                    ExportMenu::FORMAT_EXCEL_X =>
                        [
                            'options' => ['style' => 'float: right; font-size:18px;'],
                            'label' => 'Muat turun',
                            'fontAwesome' => true,
                            'icon' => ['class'=>'fa fa-download'],
                            'config' => [
                                'methods' => [
                                    'SetHeader' => ['SENARAI PROFIL GAJI KAKITANGAN'],
                                ]
                            ],
                        ],

                ],
                'showConfirmAlert' => FALSE,
                'filename' => 'SENARAI PROFIL GAJI KAKITANGAN',
                'asDropdown' => false,
            ]);
                        
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
                        'label' => 'Nama Kakitangan',
                        'value' => function($data){
                        return Html::a($data->CONm, ["hrpayroll/profile-gaji", 'umsper' => $data->COOldID], ['target' => '_blank']);
                        },
                        'filter' => Select2::widget([
                        'name' => 'ICNO',
                        'value' => $ICNO,
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                       'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(),
                        'ICNO', 'CONm'),
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],
                                
                    [
                        'format' => 'raw',
                        'label' => 'ICNO',
                        'value' => 'ICNO',
                        'filter' => Select2::widget([
                        'name' => 'ICNO',
                        'value' => $ICNO,
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                       'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(),
                        'ICNO', 'ICNO'),
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
                        'format' => 'raw',
                        'label' => 'UMSPER',
                        'value' => 'COOldID',
                        'filter' => Select2::widget([
                        'name' => 'COOldID',
                        'value' => $COOldID,
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                       'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(),
                        'ICNO', 'COOldID'),
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
                          'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->orderBy(['gredJawatan' => SORT_ASC])->all(), 'gredJawatan', 'jawatan.fname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ], 
                
                     [
                        'label' => 'JFPIB',
                        'value' => 'department.fullname',
                         'filter' => Select2::widget([
                         'name' => 'DeptId',
                         'value' => $DeptId,
                          'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->orderBy(['DeptId' => SORT_ASC])->all(), 'DeptId', 'department.fullname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],    
                                
                                
//                     [
//                        'label' => 'Kampus',
//                        'value' => 'kampus.campus_name',
//                        'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ], 
                                
                                
                     [
                        'label' => 'Kampus',
                        'value' => 'displayKampusHakiki',
                            'filter' => Select2::widget([
                            'name' => 'campus.campus_name',
                            'value' => $campus_id,
                            'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->orderBy(['campus_id' => SORT_ASC])->all(), 'campus_id', 'campus.campus_name'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
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