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
<?php
$forms = ActiveForm::begin([
    'action' => ['admin-post-list-keseluruhan'],
    'method' => 'post',
]);
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                 <p align="right"> 
         <?= Html::a('Kembali', ['tatatertib-staf/index'], ['class' => 'btn btn-primary btn-sm']) ?>
        </p>
            <div class="x_title">
                <h2><strong>Rekod Mesyuarat Jawatankuasa Rayuan Tatatertib Kakitangan</strong></h2>
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
                        return Html::a($data->kakitangan->CONm, ["admin-lihat-rekod-kakitangan", 'id' => $data->icno], ['target' => '_blank']);
                        },
                        'filter' => Select2::widget([
                        'name' => 'icno',
                        'value' => $icno,
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                       'data' => ArrayHelper::map(\app\models\tatatertib_staf\TblRekod::find()->all(), 'icno', 'kakitangan.CONm'),
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
                        'label' => 'JFPIB',
                        'value' => 'dept.fullname',
                         'filter' => Select2::widget([
                         'name' => 'dept_id',
                         'value' => $dept_id,
                          'data' => ArrayHelper::map(\app\models\tatatertib_staf\TblRekod::find()->orderBy(['dept_id' => SORT_ASC])->all(), 'dept_id', 'dept.fullname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],    
                                
                                
                     [
                        'label' => 'Kampus',
                        'value' => 'campus.campus_name',
                            'filter' => Select2::widget([
                            'name' => 'campus_id',
                            'value' => $campus_id,
                            'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->orderBy(['campus_id' => SORT_ASC])->all(), 'campus_id', 'campus.campus_name'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],           
                                
                                
                      [
                        'label' => 'Kumpulan Jawatan Perkhidmatan',
                        'value' => 'kumpulanJawatan.name',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],  
                        
                     [
                        'label' => 'Jenis Kesalahan (i)',
                        'value' => 'jenisKesalahan',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ], 
                                
                    [
                        'label' => 'Pelanggaran Tatakelakuan Yang Disabitkan (ii)',
                        'value' => 'kes',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ], 
                                
                  [
                        'label' => 'Representasi Bertulis',
                        'value' => 'reason',
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
                                    'SetHeader' => ['Tindakan Tatatertib'],
                                ]
                            ],
                        ],

                ],
                'showConfirmAlert' => FALSE,
                'filename' => 'Pelaporan Tatertib Staf UMS',
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
                        return Html::a($data->kakitangan->CONm, ["admin-lihat-rekod-kakitangan", 'id' => $data->icno], ['target' => '_blank']);
                        },
                        'filter' => Select2::widget([
                        'name' => 'icno',
                        'value' => $icno,
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                       'data' => ArrayHelper::map(\app\models\tatatertib_staf\TblRekod::find()->all(), 'icno', 'kakitangan.CONm'),
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
                        'label' => 'JFPIB',
                        'value' => 'dept.fullname',
                         'filter' => Select2::widget([
                         'name' => 'dept_id',
                         'value' => $dept_id,
                          'data' => ArrayHelper::map(\app\models\tatatertib_staf\TblRekod::find()->orderBy(['dept_id' => SORT_ASC])->all(), 'dept_id', 'dept.fullname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],    
                                
                                
                     [
                        'label' => 'Kampus',
                        'value' => 'campus.campus_name',
                            'filter' => Select2::widget([
                            'name' => 'campus_id',
                            'value' => $campus_id,
                            'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->orderBy(['campus_id' => SORT_ASC])->all(), 'campus_id', 'campus.campus_name'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],           
                                
                                
                      [
                        'label' => 'Kumpulan Jawatan Perkhidmatan',
                        'value' => 'kumpulanJawatan.name',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],  
                        
                     [
                        'label' => 'Jenis Kesalahan (i)',
                        'value' => 'jenisKesalahan',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ], 

                    [
                        'label' => 'Pelanggaran Tatakelakuan Yang Disabitkan (ii)',
                        'value' => 'kes',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],  
                                
                                
                    [
                        'label' => 'Representasi Bertulis',
                        'value' => 'reason',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                
                     [
                        'label' => 'Rayuan ?',
                        'value' => 'statusRayuan',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],   
                                
                      [
                        'label' => 'Catatan Rayuan',
                        'value' => 'catatan_rayuan',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                
                                [
                        'header' => 'Status',
                        'attribute' => 'displayflag.flagstatus2',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'filter' => Select2::widget([
                            'name' => 'flag',
                            'value' => $status,
                            'data' => ['0'=>'<span class="label label-warning">Belum Disahkan</span>',
                                '1' => '<span class="label label-success">Bersalah</span>',
                                '2' => '<span class="label label-danger">Tidak Bersalah</span>'],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            ],
                        ]),
                    ],
                                
                    [
                            'label' => 'Status Penentuan Kes',
                            'format' => 'raw',
                        //    'attribute' => 'statuspelulus',
                            'value'=>function ($data) {
                      
                        $statuspelulus = $data->pelulus_agree;
                     //   $pelulusId = $data->pelulus_icno;
                        
                        $list = [1 => '<span class="label label-success">ADA KES</span>', 2 => '<span class="label label-danger">TIADA KES</span>', 0  => '<span class="label label-danger">Rekod Baru</span>'];
                        if(is_null($statuspelulus)){
                            return Html::radioList("agree[$statuspelulus]", '',([1=>'ADA KES', 2 => 'TIADA KES']));
                        }
                        return  $list[$statuspelulus];//return $data->statusbsm;
                        }, 
                        
                             'hAlign' => 'center',
                          

                        ],
                         [
                            'label' => 'Status Pertuduhan',
                            'format' => 'raw',
                        //    'attribute' => 'statuspelulus',
                            'value'=>function ($data) {
                      
                        $statuspelulus2 = $data->pelulus_agree2;
                     //   $pelulusId = $data->pelulus_icno;
                        
                        $list = [1 => '<span class="label label-success">BERSALAH</span>', 2 => '<span class="label label-danger">TIDAK BERSALAH</span>', 0  => '<span class="label label-danger">Rekod Baru</span>'];
                        if(is_null($statuspelulus2)){
                            return Html::radioList("agree[$statuspelulus2]", '',([1=>'BERSALAH', 2 => 'TIDAK BERSALAH']));
                        }
                        return  $list[$statuspelulus2];//return $data->statusbsm;
                        }, 
                        
                             'hAlign' => 'center',
                          

                        ],
                                
                                
                          [
                            'label'=>'Keputusan',
                            'format' => 'raw',
                            'value'=>function ($data){
                              
                                    return Html::a('<i class="fa fa-edit">', ["hukuman", 'id' => $data->id]);
                                  
//                                    return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tindakans', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn btn btn-info']);

                                
                  

                            },
                                    'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],
                                
                                  [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
                                if((is_null($data->pelulus_agree)) || (is_null($data->rayuan)) ){
                                    return ['disabled' => true];
                                }
                                return [ 'value' => $data->id];
                            },
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
                    
               <div class="form-group" align="right">
               
                  
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                </div>
                    
                </div>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>