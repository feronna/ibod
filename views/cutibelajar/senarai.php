<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
;

 error_reporting(0); 
?>
<?php echo $this->render('/cutibelajar/_topmenu');?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $forms = ActiveForm::begin([
                            'action' => ['senarai', 'id'=> $iklan->id],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]);
                ?>

                <?= $forms->field($searchModel, 'status_bsm')->textInput()->input('name', ['placeholder' => "Status Kelulusan BSM"])->label(false)->widget(Select2::classname(), [
                        'data' => ['Tunggu Kelulusan'=> 'MENUNGGU KELULUSAN','Diluluskan'=> 'DILULUSKAN', 'Tidak Diluluskan'=> 'DITOLAK'],
                        'options' => ['placeholder' => 'Status Kelulusan', 'class' => 'form-control col-md-7 col-xs-12',
                            ],
                            'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ],
                    ]);?>
                
        
                <br>

                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Cari', ['class' => 'btn btn-primary']) ?>
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
                <h2><strong>Senarai Permohonan Pengajian Lanjutan (Akademik)</strong></h2>
               
                <div class="clearfix"></div>
            </div>
            <?php
            echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
            'clearBuffers' => true,
             'columns' => [
                [
                'class' => 'kartik\grid\SerialColumn', 
                'headerOptions' => [
                'style' => 'display: none;',
                ]
                ],
                [
                'label' => 'NAMA',
                'value' => 'kakitangan.CONm',
                    
                'contentOptions' => ['style' => 'border:solid'],
                ],
                [
                'label' => 'UMUR',
                'value' => 'kakitangan.umur',
                
                ],
                 
                [
                'label' => 'NO. KAD PENGENALAN',
                'value' => 'kakitangan.ICNO',
                   
                ],
                [
                'label' => 'UMS (PER)',
                'value' => 'kakitangan.COOldID'
                ],
                [
                'label' => 'JAWATAN & GRED',
                'value' => 'kakitangan.jawatan.fname'
                ],
                [
                'label' => 'JFPIU',
                'value' => 'kakitangan.department.fullname'
                ],
                [
                'label' => 'EMEL',
                'value' => 'kakitangan.COEmail'
                ],
                 
                [
                'label' => 'PERINGKAT PENGAJIAN',
                'value' => 'pengajian.pendidikanTertinggi.HighestEduLevel'
                ],
                 
                [
                'label' => 'UNIVERSITI / PENEMPATAN',
                'value' => 'pengajian.InstNm'
                ],
               
                [
                'label' => 'NEGARA',
                'value' => 'pengajian.negara.Country'
                ],
                 
                [
                'label' => 'BIDANG',
                'value' => 'pengajian.mod.studyMode'
                ],
                 
                [
                'label' => 'TAJAAN',
                'value' => 'biasiswa.nama_tajaan'
                ],
                 
                [
                'label' => 'MULA',
                'value' => 'pengajian.tarikhmula'
                ],
                
                [
                'label' => 'TAMAT',
                'value' => 'pengajian.tarikhtamat'
                ],
                 
                [
                'label' => 'LANJUTAN 01',
//                'value' => 
                ],
               
                [
                'label' => 'LANJUTAN 02',
//                'value' => ""
                ],
               
                [
                'label' => 'LANJUTAN 03',
//                'value' => ""
                ],
                
               
                [
                'header' => 'Perakuan Ketua Jabatan',
                'value' => 'status_jfpiu'
                ],
                 
                
                
//                [
//                'attribute' => 'tarikh_m',
//                'value' => 'tarikhmohon',
//                'label' => 'Tarikh Mohon',
//                'vAlign' => 'middle',
//                 'hAlign' => 'center',
//                ], 
            
                [
                'label' => 'KEPUTUSAN MESYUARAT',
                'value' => 'status_bsm'
                
                ],
                [
                'header' => 'Baki Bon Perkhidmatan',
                'value' => 'baki_bon'
                ],

//                [
//                'label' => 'STATUS PERMOHONAN',
//                'value' => 'status_bsm'
//                ],
//                
               
            ],
                'exportConfig' => [ // set styling for your custom dropdown list items
                ExportMenu::FORMAT_CSV =>false,
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_HTML => false, 
                ExportMenu::FORMAT_EXCEL => false,
                ExportMenu::FORMAT_PDF =>false,
                ExportMenu::FORMAT_EXCEL_X =>
                    [
                    'options' => ['style' => 'float: right; font-size:18px;'],
                    'label' => 'Muat turun',
                    'fontAwesome' => true,
                    'icon' => ['class'=>'fa fa-download'],
                    'config' => [
                    'methods' => [
                    'SetHeader' => ['Permohonan Cuti Belajar (Akademik)'],
            ]
        ],
                    ],
                    
    ],
            'showConfirmAlert' => FALSE,
            'filename' => 'Senarai Permohonan Cuti Belajar (Akademik)',
            'asDropdown' => false,
        ]);
            ?>
            
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
   
            <div class="x_content"> 
                <?=
                GridView::widget([
                'options' => [
                'class' => 'table-responsive',
                    ],
                    'dataProvider' => $dataProvider,
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'summary' => '',
                    'columns' => [
                            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'BIL',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                ],
                        
                       
                        
                        [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ['/cbelajar/maklumat-pemohon', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id'=>$model->iklan_id]).' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikhmohon;
                            }, 
                                    'format' => 'html',
                        ],
                                    
                          
//                        [
//                        'label' => 'JAWATAN & GRED',
//                        'value' => 'kakitangan.jawatan.fname',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],
//                        [
//                        'label' => 'JFPIU',
//                            'attribute' => 'kakitangan.DeptId',
//                        'value' => 'kakitangan.department.shortname',
//                         'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],
//                    [
////                      'attribute' => 'tarikh_m',
//                        'label' => 'TARIKH MOHON',
//                        'value' => 'tarikhmohon',
//                        'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ], 
//                        
                       [
                        'label'=>'SEMAKAN URUSETIA',
                        'format' => 'raw',
                        'value'=>function ($nilai) {
                                
                        if($nilai->terima == NULL){
                          
                           
                        $ICNO = $nilai->icno;
                        return Html::a('<i class="fa fa-list fa-lg">', 
                        ["semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id'=>$nilai->iklan_id]);
                        }
                        else{
                            return Html::a('<i class="fa fa-check fa-lg">', ["cbelajar/view-semakan-syarat", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                        }
                      },
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],       
                        
                     [
//                        'attribute' => 'status_jfpiu',
                        'label' => 'SEMAKAN PERMOHONAN',
                        'value' => 'statussemakan',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                
                    [
                        'label'=>'RINGKASAN KEPUTUSAN',
                        'format' => 'raw',
                        'value'=>function ($data) {
                       
                        if($data->terima == NULL){
                        $ICNO = $data->icno;
                        
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tindakan_bsm', 'id' => $data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
                        else{
                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                        }
                      },
                              'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        
                        [
                        'label' => 'PEMAKLUMAN KEPUTUSAN',
                        'format' => 'raw',
                        'value'=>function ($data) {
                        if($data->status_bsm == 'Draft Diluluskan'){
                            $checked = 'checked';
                        }
                        if($data->status_bsm == 'Draft Ditolak'){
                            $checked1 = 'checked';
                        }
                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
                            return $data->statusbsm;
                        }
                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->id.'" value="n'.$data->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
                      },
                        
                    ],
                    [
                        'label'=>'SALINAN SURAT TAWARAN',
                        'format' => 'raw',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'value'=>function ($data) {
                         if ($data->checkUpload($data->id)){
                         return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-check-square-o fa-lg', 'target' => '_blank']);}
                        else{
                          return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsurat', 'id' => $data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
                        }
                      },
             ],
                              
                             
//                       ['class' => 'yii\grid\CheckboxColumn',
//    'header' => Html::checkBox('selection_all', false, [
//    'class' => 'select-on-check-all',
//    'label' => 'Check Attend Only',
//         'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//    ]),
//    ],     
                              
//                              [
//    'class' => 'yii\grid\CheckboxColumn',
//    'header' => Html::checkBox('selection_all', false, [
//        'class' => 'select-on-check-all',
//        'label' => 'Check All',
//          'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//    ]),
//],
                        [
                            
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($data) { 
                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
                        return ['disabled' => 'disabled'];
                            }
                            return ['value' => $data->id, 'checked'=> true];
                            },
                     ],
                        ],
                ]);
                ?>
               <div class="col-md-12 col-sm-12 col-xs-12" align="right">  
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
