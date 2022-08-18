<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\detail\DetailView;
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
                'label' => 'Kompetensi Dipohon',
                'format' => 'raw',
                'value' => function ($data){
                            return $data->sasaran9->kompetensii;
                            }
            ],
            [
                'label' => 'Status Kehadiran',
                'format' => 'raw',
                'value' => 'statusKehadirann',
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
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
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
    </div>
</div>

<div class="row"> 
            <div class="x_panel">      
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> PENGESAHAN KETUA JABATAN/DEKAN/PENGARAH</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">            
                <?php if ($model->tarikhSemakanKJ == NULL) {
                    
                    $forms = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                        <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <?= $forms->field($model, 'ulasanKJ')->textarea(array('rows'=>6,'cols'=>5, 'placeholder' => 'Sila tulis ulasan anda di sini...'))->label(false);?>   
                        </div>
                        </div>
                        <div class="form-group">
<!--                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>-->
                            <div class="col-md-8 col-sm-8 col-xs-12">
                            <?= $forms->field($model, 'statusKJ')->checkBox([
                                'label' => '<div>Saya telah menyemak dan bersetuju mengesahkan permohonan mata IDP oleh kakitangan ini</div>',
//                                'data-size'=>'small', 
//                                'class'=>'bs_switch',
//                                'style'=>'margin-bottom:4px;', 
                                'id' => 'checkbox1',
                                'onclick' => 'checkTerms()',
                                ]) ?>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <p><?= Html::submitButton(Yii::t('app', 'HANTAR PENGESAHAN'), ['id' => 'submitb', 'class' => 'btn btn-primary', 'disabled'=> true, 'data' => ['confirm' => 'Sila pastikan maklumat permohonan adalah tepat. Teruskan?']]) ?></p>
                            </div>    
                        </div>
                <?php 
                    ActiveForm::end(); 
                } else { $forms = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="form-group">
<!--                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>-->
                            <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="x_panel">
                                    <?php 
                                        if ($model->tarikhSemakanKJ){
                                            
                                            if ($model->kjPenyemak){
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
                <?php ActiveForm::end(); }?>
                </div>
            </div>
        </div>
            
