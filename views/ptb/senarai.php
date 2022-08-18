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

<div class="col-md-12">
    <?php echo $this->render('/ptb/_menu'); ?>
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
                    'action' => ['senarai'],
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
             <div class="form-group">
                     <?= Html::a('Urus Mesyuarat', ['urus-mesyuarat'], ['class' => 'btn btn-primary']) ?>
                </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Mesyuarat PBPU</strong></h2>
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
                    if($mesyuaratPbpu){
                    foreach ($mesyuaratPbpu as $mesyuaratPbpu) { 
                        ?>
                        <tr>
                          
                            <td><?= $mesyuaratPbpu->kali_ke?></td>
                             <td><?= $mesyuaratPbpu->tarikhMesyuarat?></td>
                              <td><?= date('h:i:s A', strtotime($mesyuaratPbpu['masa_mesyuarat']));?></td>
                            <td><?= $mesyuaratPbpu->nama_mesyuarat?></td>
                          
                            <td><?= $mesyuaratPbpu->tempat_mesyuarat?></td>
           
                    <?php }} ?>
                            
                            
                          
                </tbody>
            </table>
             <div class="form-group">
                     <?= Html::a('Mesyuarat PBPU', ['mesyuarat-pbpu'], ['class' => 'btn btn-primary']) ?>
                </div>
             </div>
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
                            'label' => 'Ketua Pentadbiran',
                             'attribute' => 'pensetuju.staff.CONm',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                       
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
                            'label' => 'Ketua JFPIU',
                             'attribute' => 'peraku.staff.CONm',
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
                            'label' => 'Ketua Pentadbiran',
                             'attribute' => 'pensetuju.staff.CONm',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                       
                        ],
                                
                      [
                            'label' => 'Status Ketua Pentadbiran',
                            'attribute' =>function($data){
                    
                          
                              if($data->type->id == '2'){
                                return 'Cadangan Ketua JFPIU';
                              }if($data->type->id == '3'){
                                return 'Cadangan BSM';
                              }
                              if ($data->type->id != '2,3'){
                                  return ($data->statuspp);
                              }
                          
                           
                            },
                            'format' => 'raw',
                       
                            'hAlign' => 'center',
                       

                        ],
                                    
                          [
                            'label' => 'Ketua JFPIU',
                             'attribute' => 'peraku.staff.CONm',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                       
                        ],
                      
                        [
                            'label' => 'Status Ketua JFPIU',
                           
                            'attribute' => function($data){
                              if($data->type->id == '2'){
                                return 'Cadangan Ketua JFPIU';
                              }if($data->type->id == '3'){
                                return 'Cadangan BSM';
                              }
                              if ($data->type->id != '2,3'){
                                  return ($data->statusjfpiu);
                              }
                           
                            },
                            'format' => 'raw',
                 
                            'hAlign' => 'center',
                       
                        ],
                       
                        [
                            'label' => 'Status Kelulusan BSM',
                            'format' => 'raw',
                            //'attribute' => 'statuspelulus',
                            'value'=>function ($data) {
                      
                        $statuspelulus= $data->pelulus->agree;
                        $pelulusId = $data->pelulus->id;
                        $list = [1 => '<span class="label label-success">DILULUSKAN</span>', 0 => '<span class="label label-danger">TIDAK DILULUSKAN</span>',];
                        if(is_null($statuspelulus)){
                            return Html::radioList("agree[$pelulusId]", '',([1=>'DILULUSKAN', 0 => 'TIDAK DILULUSKAN']));
                        }
                        return  $list[$statuspelulus];//return $data->statusbsm;
                        }, 
                        
                             'hAlign' => 'center',
                          

                        ],

                        [
                            'label'=>'Tindakan',
                            'format' => 'raw',
                            'value'=>function ($data){
                                if(is_null($data->pelulus->agree) || is_null($data->letter_reference)){
                                    return Html::a('<i class="fa fa-edit">', ["ptb/tindakans", 'id' => $data->id]);
                                  
//                                    return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tindakans', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn btn btn-info']);

                                }
                              else{
                                    return Html::a('<i class="fa fa-eye">', ["ptb/lihat-permohonan", 'id' => $data->id]);

                                }

                            },
                                    'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],

                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
                                if((is_null($data->pelulus->agree) || is_null($data->letter_reference))){
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

