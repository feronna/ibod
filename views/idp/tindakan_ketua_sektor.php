<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\detail\DetailView;
use kartik\select2\Select2;
use app\models\myidp\Kategori;
use kartik\grid\GridView;

echo $this->render('/idp/_topmenu');

//$jumlahLayak = $model->layakYuran + $model->layakTiketPenerbangan + $model->layakPenginapan;
// setup your attributes
// DetailView Attributes Configuration
$attributes = [
    [
        'group' => true,
        'label' => 'BAHAGIAN 1 : MAKLUMAT PERIBADI KAKITANGAN',
        'rowOptions' => ['class' => 'table-info']
    ],
    [
        'columns' => [
            [
                'label' => 'Pemohon',
                'format' => 'raw',
                'value' => ucwords(strtolower($model->biodata->gelaran->Title.' '.$model->biodata->CONm)),
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:100%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'UMS-PER',
                'value' => $model->biodata->COOldID,
                'displayOnly' => true,
            ],
            [
                'label' => 'MyKad / Pasport',
                'value' => $model->pemohonID,
                'displayOnly' => true,
                'valueColOptions'=>['style'=>'width:30%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Jawatan',
                'value' => ucwords(strtolower($model->biodata->jawatan->nama)),
                'displayOnly' => true,
            ],
            [
                'label' => 'Gred',
                'value' => ucwords(strtoupper($model->biodata->jawatan->gred)),
                'displayOnly' => true,
                'valueColOptions'=>['style'=>'width:30%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'JFPIU',
                'value' => ucwords(strtolower($model->biodata->department->fullname)),
                'displayOnly' => true,
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Taraf Jawatan',
                'value' => ucwords(strtolower($model->biodata->statusLantikan->ApmtStatusNm)),
                'displayOnly' => true,
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Emel',
                'value' => $model->biodata->COEmail,
                'displayOnly' => true,
            ],
            [
                'label' => 'No. Tel',
                'value' => $model->biodata->COHPhoneNo,
                'displayOnly' => true,
                'valueColOptions'=>['style'=>'width:30%'],
            ],
        ],
    ],
    [
        'group' => true,
        'label' => 'BAHAGIAN 2 : MAKLUMAT KURSUS',
        'rowOptions' => ['class' => 'table-info']
    ],
    [
        'columns' => [
            [
                'label' => 'Anjuran',
                'format' => 'raw',
                'value' => $model->penganjur,
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:30%']
            ],
            [
                'label' => 'Penganjur',
                'value' => $model->namaPenganjur,
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:70%']
            ],
        ],
    ],
    [
        'columns' => [
            [   
                'label' => 'Program',
                'format' => 'raw',
                'value' => '<span class="text-justify"><kbd>' . $model->namaProgram . '</kbd></span>',
                'type' => DetailView::INPUT_TEXTAREA,
                'options' => ['rows' => 4]
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Tarikh Mula',
                'value' => Yii::$app->formatter->asDate($model->tarikhMula),
                'displayOnly' => true,
            ],
            
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Tarikh Tamat',
                'value' => Yii::$app->formatter->asDate($model->tarikhTamat),
                'displayOnly' => true,
            ], 
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Jumlah Hari',
                'value' => $model->daysKursus,
                'format' => 'raw',
                'inputContainer' => ['class' => 'col-sm-6'],
                // hide this in edit mode by adding `kv-edit-hidden` CSS class
                'rowOptions' => ['class' => 'warning kv-edit-hidden', 'style' => 'border-top: 5px double #dedede'],
            ],
            
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Tempat',
                'format' => 'raw',
                'value' => $model->lokasi,
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:100%']
            ],
        ],
    ],
    [
        'attribute' => 'failProgram1',
        'label' => 'Dokumen 1',
        'format' => 'raw',
        //'value' => html::a(Yii::$app->FileManager->NameFile($model->failProgram1), Yii::$app->FileManager->DisplayFile($model->failProgram1)),
        'value' => $model->displayLink,
        'displayOnly' => true,
        'valueColOptions' => ['style' => 'width:100%']
    ],
    [
        'attribute' => 'failProgram2',
        'label' => 'Dokumen 2',
        'format' => 'raw',
        //'value' => html::a(Yii::$app->FileManager->NameFile($model->failProgram2), Yii::$app->FileManager->DisplayFile($model->failProgram2)),
        'value' => $model->displayLink2,
        'displayOnly' => true,
        'valueColOptions' => ['style' => 'width:100%']
    ],
    [
        'attribute' => 'failProgram3',
        'label' => 'Dokumen 3',
        'format' => 'raw',
        //'value' => html::a(Yii::$app->FileManager->NameFile($model->failProgram3), Yii::$app->FileManager->DisplayFile($model->failProgram3)),
        'value' => $model->displayLink3,
        'displayOnly' => true,
        'valueColOptions' => ['style' => 'width:100%']
    ],
    [
        'group' => true,
        'label' => 'BAHAGIAN 3 : APA YANG ANDA TELAH PELAJARI DARIPADA KURSUS INI?',
        'rowOptions' => ['class' => 'table-info']
    ],
    [
        'columns' => [
            [   
                'label' => 'Pelajaran Kursus',
                'format' => 'raw',
                'value' => '<span class="text-justify"><em>' . $model->laporan . '</em></span>',
                'type' => DetailView::INPUT_TEXTAREA,
                'options' => ['rows' => 4]
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Tarikh Permohonan',
                'format' => 'raw',
                'value' => Yii::$app->formatter->asDate($model->tarikhPohon),
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:100%'],
                'rowOptions' => ['class' => 'warning kv-edit-hidden', 'style' => 'border-top: 5px double #dedede']
            ],
        ],
    ],
];

$gridColumnsPeserta = [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions'=>['class'=>'kartik-sheet-style'],
                'width'=>'36px',
                'pageSummary'=>'Total',
                'pageSummaryOptions' => ['colspan' => 6],
                'header' => 'Bil',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
//                                'header' => 'Bil',
//                                'vAlign' => 'middle',
//                                'hAlign' => 'center',
                
            ],
//            [
//                'label' => 'Slot',
//                'value' => 'slotID'
//            ],
//            [
//                'label' => 'ID Peserta',
//                'value' => 'staffID'
//            ],
            [
                'label' => 'Nama',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->gelaran->Title)).' '.ucwords(strtolower($data->biodata->CONm));
                            }
            ],
            [
                'label' => 'JFPIU',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtoupper($data->biodata->department->shortname));
                            }
            ],
            [
                'label' => 'Kompetensi Pohon',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->sasaran9->kompetensii;
                            }
            ],
            [
                'label' => 'Kompetensi Cadangan',
                'format' => 'raw',
                'value' => 'kompetensiCadangan',
            ],
            [
                'label' => 'Mata IDP Cadangan',
                //'name' => 'momo',
                'value' => function($data){
                
                    //if ($data->statusPL == 1){
                        return Html::textInput($data->staffID, $data->mataIDPcadangan, ['disabled' => 'disabled']);
                    //} 
//                    else {
//                        return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => true]);
//                    }
                },
                'format' => 'raw',
            ],
//            [
//                'label' => 'Mata IDP Diluluskan',
//                //'name' => 'momo',
//                'value' => function($data){
//                
//                    if ($data->statusKS == 1){
//                        return Html::textInput($data->staffID, $data->mataIDPlulus, ['disabled' => 'disabled']);
//                    } else {
//                        return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => true]);
//                    }
//                },
//                'format' => 'raw',
//            ],
            
];
                
$gridColumnsPeserta2 = [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions'=>['class'=>'kartik-sheet-style'],
                'width'=>'36px',
                'pageSummary'=>'Total',
                'pageSummaryOptions' => ['colspan' => 6],
                'header' => 'Bil',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
//                                'header' => 'Bil',
//                                'vAlign' => 'middle',
//                                'hAlign' => 'center',
                
            ],
            [
                'label' => 'Nama',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->gelaran->Title)).' '.ucwords(strtolower($data->biodata->CONm));
                            }
            ],
            [
                'label' => 'JFPIU',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtoupper($data->biodata->department->shortname));
                            }
            ],
            [
                'label' => 'Kompetensi Cadangan',
                'format' => 'raw',
                'value' => 'kompetensiCadangan',
            ],
            [
                'label' => 'Mata IDP Cadangan',
                //'name' => 'momo',
                'value' => function($data){
                
                    if ($data->statusPL == 1){
                        return Html::textInput($data->staffID, $data->mataIDPcadangan, ['disabled' => 'disabled']);
                    } else {
                        return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => true]);
                    }
                },
                'format' => 'raw',
            ],
            [
                'label' => 'Kompetensi Lulus',
                'format' => 'raw',
                'value' => 'kompetensiLuluss',
            ],
            [
                'label' => 'Mata IDP Lulus',
                //'name' => 'momo',
                'value' => function($data){
                
                    if ($data->statusKS == 1){
                        return Html::textInput($data->staffID, $data->mataIDPlulus, ['disabled' => 'disabled']);
                    } else {
                        //return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => true]);
                        
                        if ($data->statusPL == 1){
                            return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => 'true']);
                        } else {
                            if ($data->jumlahJamHadir != 0){
                                return Html::textInput($data->staffID, $data->jumlahJamHadir*1, ['required' => true]);
                            } else {
                                return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => true]);
                            }
                        }
                        
                        
                    }
                    
                    
                    
                    
                    
                },
                'format' => 'raw',
            ],
            
];
                
$gridColumnsPeserta3 = [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions'=>['class'=>'kartik-sheet-style'],
                'width'=>'36px',
                'pageSummary'=>'Total',
                'pageSummaryOptions' => ['colspan' => 6],
                'header' => 'Bil',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
//                                'header' => 'Bil',
//                                'vAlign' => 'middle',
//                                'hAlign' => 'center',
                
            ],
            [
                'label' => 'Nama',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->gelaran->Title)).' '.ucwords(strtolower($data->biodata->CONm));
                            }
            ],
            [
                'label' => 'JFPIU',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtoupper($data->biodata->department->shortname));
                            }
            ],
            [
                'label' => 'Kompetensi Pohon',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->sasaran9->kompetensii;
                            }
            ],
            [
                'label' => 'Jumlah Jam Hadir',
                //'name' => 'momo',
                'value' => function($data){
                
                    if ($data->statusUL == 1){
                        return Html::textInput($data->staffID, $data->jumlahJamHadir, ['disabled' => 'disabled']);
                    } else {
                        return Html::textInput($data->staffID, $data->jumlahJamHadir, ['required' => true]);
                    }
                },
                'format' => 'raw',
//                //'footer' => Receipts::getTotal($dataProvider->models, 'price'),
//                'footer' => Html::submitButton('Hantar', ['class' => 'btn btn-primary']),
            ],
            [
                'label' => 'Kompetensi Lulus',
                'format' => 'raw',
                'value' => 'kompetensiLuluss',
            ],
            [
                'label' => 'Mata IDP Lulus',
                //'name' => 'momo',
                'value' => function($data){
                
                    if ($data->statusKS == 1){
                        return Html::textInput($data->staffID, $data->mataIDPlulus, ['disabled' => 'disabled']);
                    } else {
                        //return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => true]);
                        
                        if ($data->statusPL == 1){
                            return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => 'true']);
                        } else {
                            if ($data->jumlahJamHadir != 0){
                                return Html::textInput($data->staffID, $data->jumlahJamHadir*1, ['required' => true]);
                            } else {
                                return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => true]);
                            }
                        }
                        
                        
                    }
                    
                    
                    
                    
                    
                },
                'format' => 'raw',
            ],
            
];

?>
<!-- ************************************ DETAIL VIEW ********************************************* -->
<script>
                function checkTerms() {
                  // Get the checkbox
                  var checkBox = document.getElementById("checkbox1");

                  // If the checkbox is checked, display the output text
                  if (checkBox.checked === true){
                    document.getElementById("submitb").disabled = false;
                  } else {
                    document.getElementById("submitb").disabled = true;
                  }
                }
                    </script>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-info-circle"></i> Maklumat Kursus</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?=
            // View file rendering the widget
            DetailView::widget([
                'model' => $model,
                'attributes' => $attributes,
                'mode' => 'view',
                'bordered' => true,
                'striped' => true,
                'condensed' => true,
                'responsive' => true,
                'hover' => true,
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'fadeDelay' => 1,
                'panel' => [
                        'type' => 'info', 
                        //'heading' => 'Butir-Butir Latihan',
                        //'footer' => '<div class="text-center text-muted">This is a sample footer message for the detail view.</div>'
                ],
                'buttons1' => false,
                'deleteOptions' => [// your ajax delete parameters
                    'params' => ['id' => $model->permohonanID, 'kvdelete' => true],
                ],
                'container' => ['id' => 'kv-demo2'],
                //'formOptions' => ['action' => Url::current(['#' => 'kv-demo2'])] // your action to delete
            ]);
            ?>
        </div>
    </div>
</div>

<div class="row"> 
            <div class="x_panel">      
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Pengesahan Ketua Jabatan/Dekan/Pengarah</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">            
                <?php $forms = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="form-group">
<!--                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>-->
                            <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="x_panel">
                                    <?php 
                                        if ($model->tarikhSemakanKJ){
                                            if ($model->pengesah){
                                            echo 'Disahkan Oleh :</br></br>';
                                            echo strtoupper($model->pengesah->gelaran->Title).' '.$model->pengesah->CONm.'</br>';
                                            echo strtoupper($model->pengesah->jawatan->nama).'</br>';
                                            echo strtoupper($model->pengesah->department->fullname).'</br></br>';
                                            }
                                            echo 'Tarikh : '.Yii::$app->formatter->asDate($model->tarikhSemakanKJ);
                                            echo '</br></br>';
                                            echo 'Ulasan : ';
                                            echo '<i>'.$model->ulasanKJ.'</i>';
                                            
                                        } else {
                                            echo '';
                                        }
                                    ?>
                                </div>
                            </div>   
                        </div>
                <?php ActiveForm::end();?>
                </div>
            </div>
</div>
<?php if ($model->statusPermohonan != '33' && $model->statusBSM == '4') {?>                    
<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h5>Semakan Peserta 
                <h3>
                    <span class="label label-success" style="color: white">Senarai Peserta</span>
                </h3>
            </h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPeserta,
                ]);
            ?>
        </div>
        
        <div class="x_content">
                <?php $formk = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?= $formk->field($model, 'ulasanBSM')->textarea(array('rows' => 6, 'cols' => 5, 'disabled' => true))->label(false); ?>   
                            </div>
                        </div>
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Disemak Oleh :
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">   
                            <div class="x_panel" style="background-color: #cecece">
                                    <?php 
                                        if ($model->tarikhSemakanBSM){
                                            echo strtoupper($model->pengesahbsm->gelaran->Title).' '.$model->pengesahbsm->CONm.'</br>';
                                            echo strtoupper($model->pengesahbsm->jawatan->nama).'</br>';
                                            echo strtoupper($model->pengesahbsm->department->fullname).'</br></br>';
                                            echo 'Tarikh : '.Yii::$app->formatter->asDate($model->tarikhSemakanBSM);
                                        } else {
                                            echo '';
                                        }
                                    ?>
                                </div>
                            </div>   
                        </div>
                <?php ActiveForm::end(); ?> 
                </div>
            </div>
</div>
<?php } ?>
            
<div class="row"> 
            <div class="x_panel">      
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Semakan Ketua Sektor</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="x_content">
                        <?php 
                    //$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]);
                    //$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]);
                    $form = ActiveForm::begin([
                        'method' => 'post',
                        'action' => ['tindakan-kelulusan-bsm?permohonanID='.$pID],
                    ]);
                ?>
            <?php 
            if ($model->statusSektor != '5'){
            if ($model->statusPermohonan == '33'){
            
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPeserta3,
                ]);
            } else {
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPeserta2,
                ]);
            }
            }
            ?>
        </div>
                <?php if ($model->tarikhKelulusan == NULL) {
                
                $formv = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php
                                echo $formv->field($model, 'statusSektor')->label(false)->widget(Select2::classname(), [
                                    'data' => [
                                        '5' => 'TIDAK DILULUSKAN',
                                        '4' => 'DILULUSKAN',
                                    ],
                                    'options' => ['placeholder' => 'Sila Pilih'],
                                ]);
                                ?>
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php //$formk->field($model, 'ulasanBSM')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>
                        </div>-->
<!--                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kompetensi Diluluskan: <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php
                                
                                //use app\models\KlusterKursus;
//                                $kompetensi2 = Kategori::find()
//                                        ->orderBy("kategori_id")
//                                        ->all();
//
//                                //use yii\helpers\ArrayHelper;
//                                $listData2=ArrayHelper::map($kompetensi2,'kategori_id','kategori_nama');
//                                
//                                echo $formv->field($model, 'kompetensiLulus')->label(false)->widget(Select2::classname(), [
//                                    'data' => $listData2,
//                                    'options' => ['placeholder' => 'Sila Pilih'],
//                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mata IDP Diluluskan: 
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <? $formv->field($model, 'mataIDPlulus')->textInput(['maxlength' => true, 'type' => 'number', 'min' => '1'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <div class="col-sm-3"></div> 
                            <div class="col-sm-9">
                                <?php //Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                                <?php //Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                                <p align="right"><?= Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), ['class' => 'btn btn-primary']) ?></p>
                            </div>
                        </div>

                    </div>
                <?php ActiveForm::end();
                
                } else { 
                    
                    
                    $formv = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<!--                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php //$formk->field($model, 'ulasanBSM')->textarea(array('rows' => 6, 'cols' => 5, 'disabled' => true))->label(false); ?>   
                            </div>
                        </div>-->
<!--                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kompetensi Diluluskan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php
                                
                                //use app\models\KlusterKursus;
//                                $kompetensi = Kategori::find()
//                                        ->orderBy("kategori_id")
//                                        ->all();
//
//                                //use yii\helpers\ArrayHelper;
//                                $listData=ArrayHelper::map($kompetensi,'kategori_id','kategori_nama');
//                                
//                                echo $formk->field($model, 'kompetensiLulus')->label(false)->widget(Select2::classname(), [
//                                    'data' => $listData,
//                                    'options' => ['placeholder' => 'Sila Pilih'],
//                                    'disabled' => true
//                                ]);
                                ?>
                            </div>
                        </div>-->
<!--                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mata IDP Diluluskan: 
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <? $formk->field($model, 'mataIDPlulus')->textInput(['maxlength' => true, 'type' => 'number', 'min' => '1', 'disabled' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                            </div>
                        </div>-->
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Diluluskan Oleh :
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">   
                            <div class="x_panel" style="background-color: #cecece">
                                    <?php 
                                        if ($model->tarikhKelulusan){ 
                                            echo 'Status : '.$model->statusPermohonann.'</br></br>'; 

                                            if ($model->pelulus){
                                                echo strtoupper($model->pelulus->gelaran->Title).' '.$model->pelulus->CONm.'</br>';
                                                echo strtoupper($model->pelulus->jawatan->nama).'</br>';
                                                echo strtoupper($model->pelulus->department->fullname).'</br></br>';
                                            }
                                            echo 'Tarikh : '.Yii::$app->formatter->asDate($model->tarikhKelulusan);
                                        } else {
                                            echo '';
                                        }
                                    ?>
                                </div>
                            </div>   
                        </div>
                <?php ActiveForm::end(); }?>
                <?php ActiveForm::end(); ?> 
                </div>
            </div>
</div> 