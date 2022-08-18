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
                    'action' => ['senarai'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>
                <?= $form->field($searchModel, 'icno')->textInput()->input('icno', ['placeholder' => "No Kad Pengenalan Pemohon"])->label(false); ?>
                <?= $form->field($searchModel, 'nama')->textInput()->input('name', ['placeholder' => "Nama Pemohon"])->label(false); ?>
                           
                           <?=
                            $form->field($searchModel, 'kategori_jawatan')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Kumpulankhidmat::find()->all(), 'id', 'name'),
                            'options' => ['placeholder' => 'Pilih Kategori', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
                
                
                  
                
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            </div>
        </div>
    </div>

<?php
$forms = ActiveForm::begin([
    'action' => ['senarai'],
    'method' => 'post',
]);
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Rekod Kakitangan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
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
                        'label' => 'Nama Pemohon',
                        'value' => 'biodata.CONm'
                    ],

                    [
                        'label' => 'ICNO',
                        'value' => 'icno'
                    ],

                   [
                            'label' => 'UMSPER',
                            'value' => 'biodata.COOldID'
                        ],
                        
                         [
                            'label' => 'NEGERI ASAL',
                            'value' => function($data){
                                 return $data->biodata->states->State;
                            }
                        ],
                        [
                            'label' => 'NEGARA ASAL',
                            'value' => function($data){
                                 return $data->countrys->Country;
                            }
                        ],
                        [
                            'label' => 'Gred',
                            'value' => 'kakitangan.jawatan.gred'
                        ],
                        [
                            'label' => 'Jawatan',
                            'value' => 'kakitangan.jawatan.nama'
                        ],


                        [
                            'label' => 'JFPIU',
                            'value' => 'kakitangan.department.shortname'
                        ],


                        [
                            'label' => 'Status Lantikan',
                            'value' => 'lantikan.ApmtStatusNm'
                        ],
                                
                         [
                            'label' => 'Tempoh Berkhidmat/Umur Bersara',
                            'value' => function($data){
                             if ($data->lantikan->ApmtStatusCdMM == 1){
                                  return $data->rekomen->RetireAgeCd. "&nbsp;".
                                         "(". $data->rekomen->umurBersara->RetireAgeDesc. ")"; 
                              }
                              else{
                                  return ($data->tempoh);
                              }
                       
                            },
                           'format' => 'raw',
                            'hAlign' => 'left',
                        ],
                        [
                            'label' => 'Baki Berkhidmat/Tarikh Bersara',
                            'value' => function($data){
                                if ($data->lantikan->ApmtStatusCdMM == 1){
                                  return $data->rekomen->tarikhKuatkuasa;
                              }
                              else{
                                  return ($data->stringBalance);
                              }
                            }
                        ],
      
                        [
                            'label' => 'Tarikh Permohonan',
                            'value' => 'created'
                        ],
                                
                        [
                        'label' => 'Jenis Permohonan',
                         'value' => 'type.name'
                            
                       ],
                       [
                        'label' => 'JFPIU Yang Dimohon',
                        'value' => 'newDepartment.fullname'
                      ],
                                
                    
                       [
                        'label' => 'Kategori',
                        'format' => 'raw',
                         'attribute' => 'kategoriPemohon.name'
                            
                       ],
                                
                      [
                            'label' => 'Status Ketua Pentadbiran',
                             'attribute' => 'statuspp',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                       
                        ],
                             
                      
                                
                     
                        [
                            'label' => 'Status Ketua JFPIU',
                            'attribute' => 'statusjfpiu',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                       
                        
                        ],
                        
                         
                   
                        
                         [
                            'label' => 'Status Kelulusan BSM',
                            
                            
                        ],
                                
                        [
                            'label' => 'JFPIU Baharu',
                           
                            
                        ],
                        [
                            'label' => 'Kampus Baharu',
                           
                            
                        ],
                        
                        [
                            'label' => 'Justifikasi',
                         
                            
                        ],
                                
                        [
                            'label' => 'Tarikh Kuatkuasa',
                        
                            
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
                                    'SetHeader' => ['Ptb'],
                                ]
                            ],
                        ],

                ],
                'showConfirmAlert' => FALSE,
                'filename' => 'Pertukaran Tempat Bertugas',
                'asDropdown' => false,
            ]);
                        
            ?>
            
            <div class="x_content">
                <?=
                GridView::widget([

                    'options' => [
                        'class' => 'table-responsive',
                    ],
                    
                    'dataProvider' => $dataProvider,
                     'summary' => '',
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                             'hAlign' => 'center',
                              'vAlign' => 'middle',
                            
                            
                            ],

                        [
                            'label' => 'Nama Pemohon',
                            'value' => 'biodata.CONm',
                            
                        ],

                        [
                            'label' => 'ICNO',
                            'value' => 'icno'
                        ],

                        [
                            'label' => 'UMSPER',
                            'value' => 'biodata.COOldID'
                        ],
                        
                         
                        [
                            'label' => 'Gred',
                            'value' => 'biodata.jawatan.gred'
                        ],
                        [
                            'label' => 'Jawatan',
                            'value' => 'biodata.jawatan.nama'
                        ],


                        [
                            'label' => 'JFPIU',
                            'value' => 'biodata.department.shortname'
                        ],


                        [
                            'label' => 'Status Lantikan',
                            'value' => 'biodata.lantikan.ApmtStatusNm'
                        ],
                        
                        [
                            'label' => 'Tarikh Permohonan',
                            'value' => 'created_at'
                        ],
                                
                      
                                
                
                              
                       [
                        'label' => 'Kategori',
                        'format' => 'raw',
                         'attribute' => 'kategoriPemohon.name'
                            
                       ],
                                
                
                    
                     

                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
                                if((is_null($data->pelulus_agree))){
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
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                ]);
                ?>
                <div class="form-group" align="right">
                     <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Notifikasi Kelulusan'), ['class' => 'btn btn-success', 'name' => 'notiKelulusan', 'value' => 'submit_2']) ?>
                      <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Notifikasi Pegawai'), ['class' => 'btn btn-primary', 'name' => 'notipegawai', 'value' => 'submit_2']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                </div>
            
            </div>
                <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

