<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use app\models\hronline\Kumpkhidmat;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Kumpulankhidmat;
/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */
error_reporting(0);

?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
         <div class="x_content"> 
<?php
  echo Html::a(Yii::t('app',' SENARAI LATIHAN 2017-2019'), ['senarai-latihan-lama'], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app',' SENARAI LATIHAN 2020-2022'), ['senarai-latihan'], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app',' SENARAI LATIHAN LUAR'), ['senarai-latihan-luar'], ['class' => 'btn btn-warning']);
 
?>
         </div>
    </div>
</div>
</div>



<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
              
            </div>
            <div class="x_content">
                
                <?php
                $form = ActiveForm::begin([
                    'action' => ['senarai-latihan-luar'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>
                                    <?= $form->field($searchModel, 'namaPenganjur')->textInput(['placeholder' => 'Pilih Penganjur','style'=>'width:1000px'])->label(false) ?> 

<!--                  
//                            $form->field($searchModel, 'permohonanID')->label(false)->widget(Select2::classname(), [
//                            'data' => ArrayHelper::map(\app\models\myidp\PermohonanKursusLuar::find()->all(), 'permohonanID', 'namaPenganjur'),
//                             // 'data' => [1 => 'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN'],
//                             'options' => ['placeholder' => 'Pilih Penganjur', 'class' => 'form-control col-md-7 col-xs-12'],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                                ],
//                            ]);-->
                           
                
                            <?=
                            $form->field($searchModel, 'kategori_latihan')->label(false)->widget(Select2::classname(), [
                         //   'data' => ArrayHelper::map(Kumpulankhidmat::find()->all(), 'id', 'name'),
                              'data' => [1 => 'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN'],
                             'options' => ['placeholder' => 'Pilih Kategori Latihan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
                
                    <?=
                            $form->field($searchModel, 'peringkat')->label(false)->widget(Select2::classname(), [
                         //   'data' => ArrayHelper::map(Kumpulankhidmat::find()->all(), 'id', 'name'),
                                'data' => ArrayHelper::map(app\models\myidp\IdpRefPeringkat::find()->all(), 'id', 'nama'),
                          //    'data' => [1 => 'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN'],
                             'options' => ['placeholder' => 'Pilih Peringkat', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
            
                
                
                  
                
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                  
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            </div>
        </div>
    </div>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Latihan Luar Dihadiri</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>

            </div>
     
            
            <div class="x_content">
                
                   <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <?=
                GridView::widget([

                    'options' => [
                        'class' => 'table-responsive',
                    ],
                    
                    'dataProvider' => $dataProvider,
                    'layout'=>"{summary}\n{items}\n{pager}",
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                             'hAlign' => 'center',
                              'vAlign' => 'middle',
                            
                            
                            ],
   [
                        'label' => 'KOD LATIHAN',
                        'value' => 'permohonanID'
                    ],
                        
                            [
                        'label' => 'NAMA PROGRAM',
                        'value' => 'namaProgram'
                    ],
                         [
                        'label' => 'PENGANJUR',
                        'value' => 'namaPenganjur'
                    ],

                    [
                        'label' => 'TAHUN',
                        'value' => 'tarikhMula'
                    ],
                        
                      

                    [
                        'label' => 'LOKASI',
                        'value' => 'lokasi'
                    ],


                                                [
                        'label' => 'PENGEMASKINI',
                        'value' => 'pengemaskini.CONm'
                    ],
                         [
                        'label' => 'TARIKH KEMASKINI',
                        'value' => 'updated'
                    ],

                                
//                       [
//                            'label' => 'KEMASKINI',
//                            'format' => 'raw',
//                            //'attribute' => 'statuspelulus',
//                            'value'=>function ($data) {
//
//                          $pelulusId = $data->permohonanID;
//     
//                          return Html::radioList("kategori_latihan[$pelulusId]",([1, 0 ]),([1=>'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN']));
//                        
//
//                        }, 
//                        
//                               'hAlign' => 'center',
//                              'vAlign' => 'middle',
//                          
//
//                        ],
//                                
//                                   [
//                            'label' => 'PERINGKAT',
//                            'format' => 'raw',
//                            'value'=>function ($data) {
//                      
//                        $statuspelulus= $data->peringkat;
//                        $list = [1 => '<span class="label label-success">UNIVERSITI</span>', 2 => '<span class="label label-danger">NEGARA</span>',];
//                    
//                        return  $list[$statuspelulus];
//                        }, 
//                        
//                             'hAlign' => 'center',
//                          
//
//                        ],
                                
                                
                                     [
                            'label' => 'KATEGORI LATIHAN',
                            'format' => 'raw',
                
                                       'value' => function ($data) {
                                if ($data->kategori_latihan == '1') {
                                    $checked = 'checked';
                                }
                                if ($data->kategori_latihan == '0') {
                                    $checked1 = 'checked';
                                }
                              
                                return Html::a('<input type="radio" name="' . $data->permohonanID . '" value="y' . $data->permohonanID . '" ' . $checked . '><span class="label label-success">KEPIMPINAN</span>') . '  ' . Html::a('<input type="radio" name="' . $data->permohonanID . '" value="n' . $data->permohonanID . '" ' . $checked1 . '><span class="label label-danger">BUKAN KEPIMPINAN</span>');
                            },
                        
                               'hAlign' => 'center',
                              'vAlign' => 'middle',
                          

                        ],
                                

                                
                                
                                       [
                            'label' => 'PERINGKAT',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'contentOptions' => ['style' => 'width: 150px;'],
                            'value' => function ($data) {
                              
                                    return Select2::widget([
                                        'name' => 't' . $data->permohonanID,
                                        'value' => $data->peringkat,
                                         'data' => ArrayHelper::map(app\models\myidp\IdpRefPeringkat::find()->all(), 'id', 'nama'),
                                        'options' => ['placeholder' => ''],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        ],
                                    ]);
                                
                            },
                        ],
                                    
                
                                
                                
                             [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
//                                if (($data->status_bsm == '4' || $data->status_bsm == '5')) {
//                                    return ['disabled' => 'disabled'];
//                                }
                                return ['value' => $data->permohonanID, 'checked' => true];
                            },
                        ],




                    ],
                 'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => true,
                'responsive' => true,
                              'pager' => [
                            'firstPageLabel' => 'Halaman Pertama',
                              'lastPageLabel'  => 'Halaman Terakhir'
    ],
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                ]);
                            
                   
                            
                            
                ?>
                <div class="form-group" align="right">
     
              <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']) ?>

                </div>
            
            </div>
                <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
    

