<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use yii\widgets\TopMenuWidget;
use app\models\hronline\Kumpulankhidmat;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */
error_reporting(0);

?>

    <?php echo $this->render('/ptb/_menu'); ?>


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
                    'action' => ['admin-lihat-data'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>
               <?= $form->field($searchModel, 'icno')->textInput()->input('icno', ['placeholder' => "No Kad Pengenalan Pemohon"])->label(false); ?>
               <?= $form->field($searchModel, 'name')->textInput()->input('name', ['placeholder' => "Nama Pemohon"])->label(false); ?>
   <?=
                            $form->field($searchModel, 'kategori')->label(false)->widget(Select2::classname(), [
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
<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Mesyuarat</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
              <div class="table-responsive">
            <table class="table table-sm table-bordered " style="text-align:center">
                <thead>
                    <tr class="headings">
                 
                        <th class="column-title text-center">Mesyuarat kali ke</th>
                        <th class="column-title text-center">Tarikh Mesyuarat</th>
                        <th class="column-title text-center">Masa Mesyuarat</th>
                        <th class="column-title text-center">Nama Mesyuarat</th>
                        <th class="column-title text-center">Tempat Mesyuarat</th>
                    
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($urusMesyuarat){
                    foreach ($urusMesyuarat as $admins) { 
                        ?>
                        <tr>
                          
                            <td><?= $admins->kali_ke?></td>
                           <td><?= $admins->tarikhMesyuarat?></td>
                              <td><?= $date = date('h:i:s A', strtotime($admins['masa_mesyuarat']));?></td>
                            <td><?= $admins->nama_mesyuarat?></td>
                          
                            <td><?= $admins->tempat_mesyuarat?></td>
           
                    <?php }} ?>
                            
                            
                          
                </tbody>
            </table>
              </div>
        </div>
    </div>
</div>
</div>

<?php
$form = ActiveForm::begin([
    'action' => ['senarai'],
    'method' => 'post',
]);
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Permohonan PTB</strong></h2>
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
                        'value' => 'kakitangan.CONm'
                    ],

                    [
                        'label' => 'ICNO',
                        'value' => 'icno'
                    ],

                   [
                            'label' => 'UMSPER',
                            'value' => 'kakitangan.COOldID'
                        ],
                        
                         [
                            'label' => 'NEGERI ASAL',
                            'value' => function($data){
                                 return $data->states->State;
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
                        'label' => 'Sebab Permohonan',
                        'value' => function($data){
                              if($data->type->id == '2'){
                                return 'Cadangan Ketua JFPIU';
                              }if($data->type->id == '3'){
                                return 'Cadangan BSM';
                              }
                              if ($data->type->id != '2,3'){
                                  return ($data->reason);
                              }
                           
                            }
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
                            'label' => 'Ulasan Ketua Pentadbiran',
                           'value' => function($data){
                               if($data->pensetuju->notes == null){
                                return 'Menunggu Ulasan';
                              }else{
                                return $data->pensetuju->notes;
                              }
                            }
                        ],
                        [
                            'label' => 'Status Ketua JFPIU',
                            'attribute' => 'statusjfpiu',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                       
                        
                        ],
                        
                         
                        [
                            'label' => 'Ulasan Ketua JFPIU',
                            'value' => function($data){
                               if($data->peraku->notes == null){
                                return 'Menunggu Ulasan';
                              }else{
                                return $data->peraku->notes;
                              }
                            }
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
                            'label' => 'Download',
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
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'Bil'],

                        [
                            'label' => 'Nama Pemohon',
                            'value' => 'kakitangan.CONm'
                        ],

                        [
                            'label' => 'ICNO',
                            'value' => 'icno'
                        ],

                        [
                            'label' => 'UMSPER',
                            'value' => 'kakitangan.COOldID'
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
                   
                            'hAlign' => 'center',
                         
                            
                        ],
                   
                        [
                            'label' => 'Status Ketua JFPIU',
                            'attribute' => 'statusjfpiu',
                            'format' => 'raw',
                    
                            'hAlign' => 'center',
                        ],
                        
                    
                            [
                            'label' => 'Status Kelulusan BSM',
                            'format' => 'raw',

                            'value'=>function ($data) {
                               $pelulus = $data->pelulus->agree;
                               $list = [null => '<span class="label label-warning">MENUNGGU TINDAKAN</span>', 1 => '<span class="label label-success">DILULUSKAN</span>', 0 => '<span class="label label-danger">TIDAK DILULUSKAN</span>'];
                                if(is_null($pelulus)){
                                 return $list[$pelulus];  

                                }else if($pelulus == 1){
                                    return $list[$pelulus];
                                }else{
                                    return $list[$pelulus];
                                }

                            },
                          
                            'hAlign' => 'center',
                        ], [
                            'label'=>'Lihat',
                            'format' => 'raw',
                            'value'=>function ($data) {
                                
                                    return Html::a('<i class="fa fa-eye">', ["ptb/meeting-lihat-permohonan", 'id' => $data->id]);
                               
                                

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
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
