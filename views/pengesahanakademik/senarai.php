<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\pengesahan\PengesahanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 error_reporting(0); 
?>

<!--<= $this->render('/pengesahan/_topmenu') ?>-->

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
<!--                <p align="right"><= \yii\helpers\Html::a('Kembali', ['halaman-pengesahan-akademik'], ['class' => 'btn btn-primary']) ?></p>   -->
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $forms = ActiveForm::begin([
                            'action' => ['senarai'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]);
                ?>               
                <?= $forms->field($searchModel, 'status_bsm')->textInput()->input('name', ['placeholder' => "Status Kelulusan BSM"])->label(false)->widget(Select2::classname(), [
                        'data' => ['Tunggu Kelulusan'=> 'MENUNGGU KELULUSAN','Diluluskan'=> 'DILULUSKAN', 'Tidak Diluluskan'=> 'DITOLAK'],
                        'options' => ['placeholder' => 'Pilih Status Kelulusan BSM', 'class' => 'form-control col-md-7 col-xs-12',
                            ],
                            'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ],
                    ]);?>
                <br>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Cari', ['class' => 'btn btn-primary']) ?>
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
                <h2><strong>Senarai Permohonan Pengesahan Dalam Perkhidmatan [Akademik]</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>                   -->
                </ul>
                <div class="clearfix"></div>
            </div>
            <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['reportakademik', 'status' => $searchModel->status_bsm]) ?>
            <?php
            GridView::widget([
            'dataProvider' => $dataProvider,           
//            'clearBuffers' => true,
             'columns' => [
                [
                'class' => 'kartik\grid\SerialColumn', 
                'headerOptions' => [
                'style' => 'display: none;',
                ]
                ],
                  ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'BIL',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                ],
                [
                'label' => 'NAMA',
                'value' => 'kakitangan.CONm',
                    
                'contentOptions' => ['style' => 'border:solid'],
                ],
//                  [
//                'label' => 'No. IC',
//                'value' => 'icno',
//                    'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                ],
                [
                'label' => 'UMS (PER)',
                'value' => 'kakitangan.COOldID'
                ],
                [
                'label' => 'JAWATAN & GRED',
                'value' => 'kakitangan.jawatan.fname'
                ],
                [
                'label' => 'JAFPIB',
                'value' => 'kakitangan.department.fullname'
                ],
                [
                'label' => 'TARIKH LANTIKAN',
                'attribute' => 'kakitangan.startDateLantik',
                'format' => ['date', 'php:d/m/Y']
                ],
                [
                'label' => 'TEMPOH PERKHIDMATAN',
                'value' => 'kakitangan.servPeriodPermanent'
                ],
                   [
                'label' => 'BM(SPM)',
                'value' => 'gredbm.grade.grade',
                        'format' => 'raw',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                ],
                   [
                'label' => 'LATAR BELAKANG PENDIDIKAN',
                'value' => 'kakitangan.pendidikan.HighestEduLevel'
                ],
                   [
                'label' => 'PTM',
                'value' => 'tarikh_lulus_ptm'
                ], 
                   [
                'header' => 'PERAKUAN KETUA JABATAN',
                'value' => 'status_jfpiu'
                ],
                   [
                'label' => 'STATUS TATATERTIB',
                
                ], 
                    [
                'header' => 'LNPT <br>'.(date('Y')-1),
                'value' => 'markahkeseluruhan1.markah_PP'
                ],
                [
                'header' => 'LNPT <br>'.(date('Y')-2),
                'value' => 'markahkeseluruhan2.markah_PP'
                ],
                [
                'header' => 'LNPT <br>'.(date('Y')-3),
                'value' => 'markahkeseluruhan3.markah_PP'
                ],
                    [
                'label' => 'SEMAKAN KEHADIRAN',
               
                ],  
//                [
//                        'header' => 'Status Pengesahan',
//                        'attribute' => 'confirmation.statusPengesahan.ConfirmStatusNm',
//                        'format' => 'raw',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                ],       
//                [
//                'attribute' => 'tarikh_m',
//                'value' => 'tarikhmohon',
//                'label' => 'Tarikh Mohon',
//                'vAlign' => 'middle',
//                 'hAlign' => 'center',
//                ], 
                [
                'label' => 'CATATAN',
                
                ],
//                [
//                'label' => 'Keputusan Mesyuarat',
//                
//                ],
//                [
//                'label' => 'Perlanjutan',
//                'value' => 'pelanjutan'
//                ],
//                [
//                'label' => 'Pemilihan KWSP/PENCEN',
//                'value' => 'skim'
//                ],
//                [
//                'label' => 'Status Permohonan',
//                'value' => 'status_bsm'
//                ],
                ],       
//                'exportConfig' => [ // set styling for your custom dropdown list items
//                ExportMenu::FORMAT_CSV =>false,
//                ExportMenu::FORMAT_TEXT => false,
//                ExportMenu::FORMAT_HTML => false, 
//                ExportMenu::FORMAT_EXCEL => false,
//                ExportMenu::FORMAT_PDF =>false,
//                ExportMenu::FORMAT_EXCEL_X =>
//                    [
//                    'options' => ['style' => 'float: right; font-size:18px;'],
//                    'label' => 'Muat turun',
//                    'fontAwesome' => true,
//                    'icon' => ['class'=>'fa fa-download'],
//                    'config' => [
//                        'methods' => [
//                            'SetHeader' => ['Permohonan Pengesahan Dalam Perkhidmatan'],
//            ]
//        ],
//                    ],
//                    
//    ],
//            'showConfirmAlert' => FALSE,
//            'filename' => 'RINGKASAN PDP (PENTADBIRAN)',
//            'asDropdown' => false,
                ]);
                ?>
            
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
   
            <div class="x_content"> 
                <?=
                GridView::widget([
                    'options' => ['class' => 'table-responsive',],
                    'class' => 'table-responsive',
                    'dataProvider' => $dataProvider,
                    //'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'summary' => '',
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil.',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        
                        [
                            'label' => 'ICNO',
                            'value' => 'icno',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        
                        [
                            'label' => 'UMSPER',
                            'value' => 'kakitangan.COOldID',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        
                        [
                            'label' => 'Nama',
                            'attribute' => 'kakitangan.CONm',
                            'format' => 'raw',
                            'value' => function($data){
                            return Html::a($data->kakitangan->CONm, ["permohonanpengesahan", 'id' => $data->id], ['target' => '_blank']);
                            },
                            'contentOptions' => ['style' => 'text-decoration: underline;'],
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                
                        [
                            'label' => 'Jawatan & Gred',
                            'value' => 'kakitangan.jawatan.fname',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'label' => 'JAFPIB',
                            'value' => 'kakitangan.department.shortname',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'header' => 'Status Pengesahan',
                            'attribute' => 'confirmation.statusPengesahan.ConfirmStatusNm',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'header' => 'Tempoh Lantikan Tetap Di UMS',
                            'attribute' => 'kakitangan.servPeriodPermanent',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'header' => 'Skim',
                            'value' => 'skim',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
//                          'attribute' => 'tarikh_m',
                            'value' => 'tarikhmohon',
                            'label' => 'Tarikh Mohon',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ], 
                                    
                        [
    //                       'attribute' => 'status_jfpiu',
                            'label' => 'Status Perakuan Ketua Jabatan',
                            'value' => 'statusjfpiu',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'label' => 'Status Kelulusan BSM',
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
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                              
                        [
                            'label'=>'Tindakan',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'value'=>function ($data) {
//                            return Html::a('<i class="fa fa-edit">', ["pengesahan/tindakan_bsm", 'id' => $data->id]);
                            if($data->terima == NULL){
                            return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tindakan_bsm', 'id' => $data->id]),'style'=>'background-color: transparent; 
                            border: none;', 'class' => 'fa fa-edit mapBtn']).
                            Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsurat', 'id' => $data->id]),'style'=>'background-color: transparent; 
                            border: none;', 'class' => 'fa fa-upload mapBtn']);
                            }
                            else{
                            return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsurat', 'id' => $data->id]),'style'=>'background-color: transparent; 
                            border: none;', 'class' => 'fa fa-upload mapBtn']);
                            }
                          },
                        ],
                                
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) { 
                            if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
                            return ['disabled' => 'disabled'];
                            }
                            return ['value' => $data->id, 'checked'=> true];
                          },
                        ],
                        
                        [
                            'label' => 'Salinan Surat',
                            'format' => 'raw',
                            'value'=>function ($statusbsm){
                                if($statusbsm->status_bsm == "Tunggu Kelulusan"){
                                return 
                                Html::a('<i class="fa fa-download">');
                                }
                               if($statusbsm->status_bsm == "Draft Diluluskan"){
                                  return 
                                Html::a('<i class="fa fa-download">', ["pengesahan/surat-pengesahan", 'id' => $statusbsm->id], ['target' => '_blank']);
                               }
                                else if($statusbsm->status_bsm == "Diluluskan"){
                                  return 
                                Html::a('<i class="fa fa-download">', ["pengesahan/surat-pengesahan", 'id' => $statusbsm->id], ['target' => '_blank']);
                               }
                               else if ($statusbsm->status_bsm == "Draft Ditolak"){
                                 return 
                                Html::a('<i class="fa fa-download">', ["pengesahan/surat-pengesahan", 'id' => $statusbsm->id], ['target' => '_blank']);
                               }
                                else if($statusbsm->status_bsm == "Tidak Diluluskan"){
                                  return 
                                Html::a('<i class="fa fa-download">', ["pengesahan/surat-pengesahan", 'id' => $statusbsm->id], ['target' => '_blank']);
                               }
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
                
               <div class="col-md-12 col-sm-12 col-xs-12" align="right">  
                    <!--<?= Html::submitButton(Yii::t('app', '<i class="fa fa-book"></i> Senarai (Pentadbiran)'), ['class' => 'btn btn-primary', 'name' => 'belummohon', 'value' => 'submit_1']) ?>-->
                    <!--<?= Html::submitButton(Yii::t('app', '<i class="fa fa-book"></i> Senarai (Akademik)'), ['class' => 'btn btn-primary', 'name' => 'belummohonakademik', 'value' => 'submit_1']) ?>-->
                    <!--<?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Notifikasi (Pentadbiran)'), ['class' => 'btn btn-primary', 'name' => 'notipemohon', 'value' => 'submit_1']) ?> -->
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Notifikasi (Akademik)'), ['class' => 'btn btn-primary', 'data'=>['disabled-text' => 'Sila Tunggu..'], 'name' => 'notipemohonakademik', 'value' => 'submit_1']) ?> 
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Notifikasi Pegawai'), ['class' => 'btn btn-primary', 'data'=>['disabled-text' => 'Sila Tunggu..'], 'name' => 'notipegawaiakademik', 'value' => 'submit_2']) ?>                   
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'data'=>['disabled-text' => 'Sila Tunggu..'], 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'data'=>['disabled-text' => 'Sila Tunggu..'], 'name' => 'hantar', 'value' => 'submit_2']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
