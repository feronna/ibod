<?php
use kartik\export\ExportMenu;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
error_reporting(0); 
use yii\widgets\Pjax;
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
         <?= Html::a('Kembali', ['tatatertib-staf/index'], ['class' => 'btn btn-primary btn-sm']) ?>
        </p>
            <div class="x_title">
                <h2><strong>Keputusan NC</strong></h2>
<!--                <p align="right"><= \yii\helpers\Html::a('Kembali', ['halaman-utama-keseluruhan'], ['class' => 'btn btn-primary']) ?></p>   -->
                <div class="clearfix"></div>
            </div>
          <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

           <?php
            echo ExportMenu::widget([
                      'filterModel' => true,
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
//                         'filterWidgetOptions' => [
//                    'pluginOptions' => ['allowClear' => true],
//                ],
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
                       <?php Pjax::begin(); ?>
            <?=
              
                        GridView::widget([
                        'options' => [
                        'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        'filterModel' => true,
                        'summary' => '',
                        //'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        'filterModel' => $searchModel,
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
                        'value' => 'jenisKesalahan->kesalahan_nm',
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
                                                            'label' => 'Laporan Siasatan',
                                                            'format' => 'raw',
                                                            'headerOptions' => ['class' => 'text-center'],
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'value' => function ($data) {
                                                    

                                                            return Html::a('', ['tatatertib-staf/surat-pertuduhan', 'id' => $data->id], ['class' => 'fa fa-download', 'target' => '_blank']);
                                       
                                                    },
                                                        ],
                                                    
                           [
                        'label' => 'Keputusan Nc',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) {
                        if($data->status_nc == '1'){
                            $checked = 'checked';
                        }
                        if($data->status_nc == '2'){
                            $checked1 = 'checked';
                        }
                        if($data->status_nc == '1' || $data->status_nc == '2'){
                            return $data->statusNc;
                        }
                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->id.'" value="n'.$data->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
                      },
                       
                    ],
    
                                
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
                                if((is_null($data->status_nc))){
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
                        'resizableColumnsOptions' => ['resizeFromBody' => true],
                                         'filterModel' => $searchModel,
                                
                        ]);
                    ?>
                       <?php Pjax::end(); ?>
               <div class="form-group" align="right">
            <div class="col-md-12 col-sm-12 col-xs-12" align="right"> 
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                </div>
      <?php ActiveForm::end(); ?>
                </div>
                   
                
            </div>
        </div>
    </div>
</div>
</div>