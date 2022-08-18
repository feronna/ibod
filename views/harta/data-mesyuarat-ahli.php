<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use app\models\hronline\Kumpulankhidmat;
/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */
error_reporting(0);
?>
<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
    <?php echo $this->render('/harta/_menu'); ?>
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
                    'action' => ['data-mesyuarat'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>
                <?= $form->field($searchModel, 'icno')->textInput()->input('icno', ['placeholder' => "No Kad Pengenalan Pemohon"])->label(false); ?>
                <?= $form->field($searchModel, 'AssetOwnerNm')->textInput()->input('icno', ['placeholder' => "Nama Pemohon"])->label(false); ?>
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
            <h2><strong>Mesyuarat JKTT</strong></h2>
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
                 
                
                        <th class="column-title text-center">Tarikh Mesyuarat</th>
                        <th class="column-title text-center">Masa Mesyuarat</th>
                        <th class="column-title text-center">Nama Mesyuarat</th>
                        <th class="column-title text-center">Tempat Mesyuarat</th>
                    
                    </tr>
                </thead>
                <tbody>
                     <?php 
                    $bil=1;
                    if($urusMesyuarat){
                    foreach ($urusMesyuarat as $admins) { 
                        ?>
                        <tr>
                   
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
$forms = ActiveForm::begin([
    'action' => ['data-mesyuarat'],
    'method' => 'post',
]);
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Permohonan Isytihar Harta</strong></h2>
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
                            'value' => 'status_lantikan'
                        ],
                                
                    
                        [
                            'label' => 'Tarikh Permohonan',
                            'value' => 'tarikhDihantar'
                        ],
                                
                        [
                        'label' => 'Jenis Permohonan',
                         'value' => 'jenisPermohonan'
                            
                       ],
                    
                     [
                        'label' => 'Kategori',
                        'format' => 'raw',
                         'attribute' => 'kategoriPemohon.name'
                            
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
                               if($data->ulasan_kj == null){
                                return 'Menunggu Ulasan';
                              }else{
                                return $data->ulasan_kj;
                              }
                            }
                        ],
                        
                         [
                            'label' => 'Status Kelulusan JKTT',
                            
                            
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
                'filename' => 'Isytihar Harta',
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
                            'value' => 'kakitangan.CONm',
                            
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
                            'value' => 'status_lantikan'
                        ],
                        
                        [
                            'label' => 'Tarikh Permohonan',
                            'value' => 'tarikhDihantar'
                        ],
                                
                        [
                        'label' => 'Jenis Permohonan',
                        'value' => 'jenisPermohonan'
                       ],
                        
                         [
                        'label' => 'Kategori',
                        'format' => 'raw',
                         'attribute' => 'kategoriPemohon.name'
                            
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
                             'format' => 'raw',
                            'value' => function($data){
                               if($data->ulasan_kj == null){
                                return 'Menunggu Ulasan';
                              }else{
                                return $data->ulasan_kj;
                              }
                            }
                             
                        ],
                        
                         
                        [
                            'label' => 'Status Kelulusan JKTT',
                           
                            'attribute' => 'statusPelulus',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                       
                        ],
                   
                                      [
                            'label'=>'Lihat',
                            'format' => 'raw',
                            'value'=>function ($data){
                               
                                 //   return Html::a('<i class="fa fa-edit">', ["ptb/tindakans", 'id' => $data->id]);
                                 
                              
                              return  Html::a('<i class="fa fa-eye">', ["harta/borang", 'id' => $data->id]);

                                

                            },
                                    'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],

                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
                                if((is_null($data->status_pelulus) )){
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
   
            </div>
                <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


