<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use app\models\hronline\Kumpkhidmat;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
use kartik\date\DatePicker;
/* @var $dataProvider yii\data\ActiveDataProvider */
error_reporting(0);

?>
<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/keterhutangan/_menu');?>
</div>
<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
         
            <div class="x_content">
                     <?php
                $forms = ActiveForm::begin([
                            'action' => ['laporan-admin'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1, 
                                'class' => 'disable-submit-buttons'
                            ],

                ]);
                ?>
                  <div class="form-group">
          
                      
                       <?= Select2::widget([
                        'name' => 'ICNO',
                        'value' => Yii::$app->request->queryParams['ICNO'],
  'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                        'options' => [
                            'allowClear' => true,
                            'placeholder' => 'Nama Kakitangan',
                        ],
                    ]);?>
                  </div>
                
                  <div class="form-group">
                 <?= Select2::widget([
                        'name' => 'sesi',
                        'value' => Yii::$app->request->queryParams['sesi'],
                        'data' => ['1'=> 'JANUARI - JUN','2'=> 'JULAI - DISEMBER'],
                        'options' => ['placeholder' => 'Batch'
                            ],
                            'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);?>
                 </div>

                 <div class="form-group">
                 <?=  DatePicker::widget([
                    'name' => 'tahun',
                    'value' => Yii::$app->request->queryParams['tahun'],
                    'type' => DatePicker::TYPE_INPUT,
                     'options' => ['placeholder' => 'Tahun',
                            ],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy',
                        'minViewMode'=> "years"
                    ]
                ]);?>
                
            </div>
                <div class="form-group">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
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
                <h2><strong>Senarai Kakitangan Keterhutangan Kewangan Serius </strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
                
            </div>
            <?php
            // Html::a('<i class="fa fa-fw fa-paper-plane"></i> Hantar Surat Tunjuk Sebab',
            //         ['hantar-noti', 'tahun' => Yii::$app->request->queryParams['tahun'], 'sesi' => Yii::$app->request->queryParams['sesi']], 
            //         ['class' => 'btn btn-primary', 'title' => 'Hantar-noti',
            //     'onclick' => 'return confirm("Adakah anda pasti untuk menghantar notifikasi kepada semua staff yang bekenaan?")']) ?>
            
                 <?php
                //   Html::a('<i class="fa fa-fw fa-paper-plane"></i>  Notifikasi Peringatan Kakitangan',
                //     ['notify-kakitangan', 'tahun' => Yii::$app->request->queryParams['tahun'], 'sesi' => Yii::$app->request->queryParams['sesi']], 
                //     ['class' => 'btn btn-warning', 'title' => 'Notify-kakitangan',
                // 'onclick' => 'return confirm("Adakah anda pasti untuk menghantar notifikasi kepada semua staff yang bekenaan?")']) 
                // ?>
                <?php
                
                
            echo ExportMenu::widget([
                'dataProvider' => $permohonan,
                'clearBuffers' => true,
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'headerOptions' => [
                            'style' => 'display: none;',
                        ]
                    ],
                    
                  
                       [
                            'label' => 'Nama Kakitangan',
                            'value' => 'kakitangan.CONm',
                            
                        ],
                        
                         [
                            'label' => 'ICNO',
                            'value' => 'kakitangan.ICNO',
                            
                        ],
                        
                        [
                            'label' => 'UMSPER',
                            'value' => 'kakitangan.COOldID',
                            
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
                            'label' => 'Bil. Bulan Emolumen Lebih 60%',
                           'value' => 'cnt'
                            
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
                                    'SetHeader' => ['Laporan Admin'],
                                ]
                            ],
                        ],

                ],
                'showConfirmAlert' => FALSE,
                'filename' => 'Laporan Admin',
                'asDropdown' => false,
            ]);
                        
            ?>
            
            <div class="x_content">
                <?=
                GridView::widget([

                    'options' => [
                        'class' => 'table-responsive',
         
                    ],
                    
                    'dataProvider' => $permohonan,
               
                    'emptyText' => '',
       
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                             'hAlign' => 'center',
                              'vAlign' => 'middle',
                            
                            
                            ],

                        [
                            'label' => 'Nama Kakitangan',
                            'value' => 'kakitangan.CONm',
                            
                        ],
                        
                         [
                            'label' => 'ICNO',
                            'value' => 'kakitangan.ICNO',
                            
                        ],
                        
                        [
                            'label' => 'UMSPER',
                            'value' => 'kakitangan.COOldID',
                            
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
                            'label' => 'Bil. Bulan Emolumen Lebih 60%',
                           'value' => 'cnt'
                            
                        ],
                      
                        
                            [
                            'label'=>'Tindakan',
                            'format' => 'raw',
                            'value'=>function ($data){
                       
                        //      return  Html::button('<i class="fa fa-info" aria-hidden="true"></i> INFO', ['value' => \yii 'id' => $data->sm_ic_n\helpers\Url::to(['keterhutangan/detail-view', 'id' => $data->sm_ic_no]), 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                             return Html::a('<i class="fa fa-eye">', ["pinjaman/detail-view-payroll", 'id' => $data->sm_ic_no,'tahun' => Yii::$app->request->queryParams['tahun'], 'sesi' => Yii::$app->request->queryParams['sesi']]);                   

                            },
                                    
                                    
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
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
               
        </div>
    </div>
</div>

