<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use kartik\select2\Select2;
use app\models\myidp\Kategori;
use kartik\widgets\DatePicker;
use app\models\hronline\Department;

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
//            [
//                'label' => 'Nama',
//                'format' => 'raw',
//                'vAlign' => 'middle',
//                'value' => function ($data){
//                            return ucwords(strtolower($data->biodata->gelaran->Title)).' '.ucwords(strtolower($data->biodata->CONm));
//                            }
//            ],
            [
                'attribute' => 'CONm',
                'contentOptions' => ['style' => 'width:400px;'],
                'filterInputOptions' => [
                    'class'  => 'form-control',
                    'placeholder' => 'Cari...'
                ],
                'label' => 'Nama',
                'value' => function ($data){
                                return ucwords(strtolower($data->biodata->CONm));
                           },
//                'filter'    => ArrayHelper::map(PermohonanMataIdpIndividu::find()
//                        ->joinWith('biodata.jawatan')
//                        ->where(['statusPermohonan' => '3', 'job_category' => $type])
//                        ->orWhere(['statusPermohonan' => '33', 'job_category' => $type])
//                        ->all(), 'pemohonID', 'biodata.CONm'),
//                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
            ],
//            [
//                'label' => 'JFPIU',
//                'format' => 'raw',
//                'vAlign' => 'middle',
//                'value' => function ($data){
//                            return ucwords(strtoupper($data->biodata->department->shortname));
//                            }
//            ],
            [
                'attribute' => 'DeptId',
//                'contentOptions' => ['style' => 'width:400px;'],
                'label' => 'JFPIU',
                'value' => function ($data){
                            return ucwords(strtoupper($data->biodata->department->shortname));
                           },
                'filter'    => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen                  
            ],
            [
                'label' => 'Status',
                'format' => 'raw',
                'value' => 'statusKehadirann',
            ],
            [
                'header' => 'Kompetensi <br> Dipohon',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->sasaran9->kompetensii;
                            }
            ],
            [
                'header' => 'Kompetensi <br> Dicadangkan',
                'format' => 'raw',
                'value' => 'kompetensiCadangan',
            ],
            [
                'header' => 'Jumlah <br> Jam Hadir',
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
                'header' => 'Cadangan <br> Mata',
                //'name' => 'momo',
                'value' => function($data){
                    
                    if ($data->statusPL == 1){
                        return Html::textInput($data->staffID, $data->mataIDPcadangan, ['disabled' => 'disabled']);
                    } elseif ($data->statusPL == 2){
                        return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => true]);                    
                    } else {
                        if ($data->jumlahJamHadir != 0){
                            return Html::textInput($data->staffID, $data->jumlahJamHadir*1, ['required' => true]);
                        } else {
                            return Html::textInput($data->staffID, $data->mataIDPcadangan, ['required' => true]);
                        }
                    }
                
                    
                },
                'format' => 'raw',
//                //'footer' => Receipts::getTotal($dataProvider->models, 'price'),
//                'footer' => Html::submitButton('Hantar', ['class' => 'btn btn-primary']),
            ],
//            [
//                'class' => 'yii\grid\CheckboxColumn',
//                'checkboxOptions' => function ($data) { 
//                if(($data->status_bsm=='4' ||$data->status_bsm=='5')){
//                return ['disabled' => 'disabled'];
//                }
//                return ['value' => $data->id, 'checked'=> true];
//                },
//            ],
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'momo',
                'checkboxOptions' => function ($model, $key, $index, $column){
                    return ['value' => $model->staffID, 'checked'=> true, 'disabled' => $model->sasaran9->statusBSM ? true : false]; },
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
                    
<div class="row"> 
    <div class="x_panel">      
<!--        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Senarai Peserta</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>-->
        <div class="x_title">
            <h5>Semakan Peserta 
                <h3>
                    <span class="label label-success" style="color: white">Senarai Peserta</span>
                </h3>
            </h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php 
                    //$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]);
                    //$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]);
                    if ($model->tarikhSemakanBSM == NULL){
                        $form = ActiveForm::begin([
                        'method' => 'post',
                        'action' => ['tindakan-pengesahan-bsm?permohonanID='.$pID],
                    ]);
                    }    
                ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
//                    'pager' => [
//                        'firstPageLabel' => 'Halaman Pertama',
//                        'lastPageLabel'  => 'Halaman Terakhir'
//                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPeserta,
                ]);
            ?>
        </div>

        <div class="x_content">
                <?php if ($model->tarikhSemakanBSM == NULL) {
                
                $formk = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
<!--                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php
//                                $formk->field($model, 'statusBSM')->label(false)->widget(Select2::classname(), [
//                                    'data' => [
//                                        '7' => 'TIDAK DILULUSKAN',
//                                        '8' => 'DILULUSKAN',
//                                    ],
//                                    'options' => ['placeholder' => 'Sila Pilih'],
//                                ]);
                                ?>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $formk->field($model, 'ulasanBSM')->textarea(array('rows' => 6, 'cols' => 5, 'placeholder' => 'Sila tulis ulasan anda di sini...'))->label(false); ?>   
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                    <p align="right"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Ubah Kompentensi dan Mata <i class="fa fa-paper-plane"></i></button><br><br></p>
                                        <?= Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), ['class' => 'btn btn-primary', 'name' => 'submit', 'value' => '0']) ?>
                                        
                                        <?php 
//                                        Html::button('Ubah', [
//                                                'id' => 'modalButton', 
//                                                'value' => \yii\helpers\Url::to(['ubahx']), 
////                                                    'id' => $data->kursusLatihanID,
////                                                    'idB' => 'sudahSahHadir']),
//                                                'class' => 'btn btn-primary mapBtn'
//                                                ]); 
                                        ?>
                                    
                            </div>

                        </div>
<!--                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kompetensi Dipohon : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?php //$model->kompetensii;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cadangan Kompetensi : <span class="required"></span>
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
//                                echo $formk->field($model, 'kompetensiCadangan')->label(false)->widget(Select2::classname(), [
//                                    'data' => $listData,
//                                    'options' => ['placeholder' => 'Sila Pilih'],
//                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Hari : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?php //$model->daysKursus.' hari';
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cadangan Mata IDP: 
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php //$formk->field($model, 'mataIDPcadangan')->textInput(['maxlength' => true, 'type' => 'number', 'min' => '1'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                            </div>
                        </div>-->
<!--                        <div class="form-group">
                            <div class="col-sm-3"></div> 
                            <div class="col-sm-9">
                                <p align="right"><?php //Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), ['class' => 'btn btn-primary']) ?></p>
                            </div>
                        </div>-->
                        
                    </div>
            <div class="modal fade" id="myModal" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                  <div class="form-group">
                                      
                                      <div class="latihan-form"> 
    <div class="col-md-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2>Tukar Kompetensi / Mata Diperoleh</h2> 
                    <div class="clearfix"></div>
                </div>
            <div class="x_content">
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="kod">Kompetensi Untuk Peserta Akademik: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=  Select2::widget([
                        'name' => 'momok',
                        'data' => ArrayHelper::map(Kategori::find()->where(['academic' => '1'])->all(), 'kategori_id', 'kategori_nama'),
                        'options' => ['placeholder' => 'Sila pilih...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => false,
                        ],
                    ]);
                                ?>
                    </div>
                </div>
                <br><br>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="kod">Kompetensi Untuk Peserta Pentadbiran: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=  Select2::widget([
                        'name' => 'momokk',
                        'data' => ArrayHelper::map(Kategori::find()->where(['admin' => '1'])->all(), 'kategori_id', 'kategori_nama'),
                        'options' => ['placeholder' => 'Sila pilih...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => false,
                        ],
                    ]);
                                ?>
                    </div>
                </div>
                <br><br>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="id">Mata: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?= Html::textInput('cadanganMata', '', ['class' => 'form-control']); ?>
                    </div>
                </div>
<!--                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muatnaik Bahan Kursus: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                        <?php
                           //echo $form->field($model2, 'file[]')->fileInput(['multiple' => true])->label(false);
                        ?>
                    </div>
                </div> -->
                <div class="card-footer text-right">
                    <?= Html::resetButton('Batal', ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'name' => 'submit', 'value' => '1']) ?>
                </div>
                
       </div>
        </div>
    </div>
</div>
                                  
                              </div>
                              <div class="modal-footer">
<!--                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <? Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), ['class' => 'btn btn-primary', 'name' => 'submit', 'value' => '1']) ?>
                                        <?php //Html::submitButton('HANTAR', ['name' => 'submit', 'value' => 'submit_1']) ?>
                                    </div>
                                </div>-->
                              </div>
                            </div>

                          </div>
                        </div>
                <?php ActiveForm::end();
                
                } else { $formk = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?= $formk->field($model, 'ulasanBSM')->textarea(array('rows' => 6, 'cols' => 5, 'disabled' => true))->label(false); ?>   
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kompetensi Dipohon : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?php //$model->kompetensii;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cadangan Kompetensi : <span class="required"></span>
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
//                                echo $formk->field($model, 'kompetensiCadangan')->label(false)->widget(Select2::classname(), [
//                                    'data' => $listData,
//                                    'options' => ['placeholder' => 'Sila Pilih'],
//                                    'disabled' => true
//                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Hari : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?php //$model->daysKursus.' hari';
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cadangan Mata IDP: 
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php //$formk->field($model, 'mataIDPcadangan')->textInput(['maxlength' => true, 'type' => 'number', 'min' => '1', 'disabled' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                            </div>
                        </div>-->
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
                <?php ActiveForm::end(); }?>
                <?php if ($model->tarikhSemakanBSM == NULL){
                ActiveForm::end(); } ?> 
                </div>
            </div>
</div> 
            
