<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

echo $this->render('/idp/_topmenu');

//$jumlahLayak = $model->layakYuran + $model->layakTiketPenerbangan + $model->layakPenginapan;
// setup your attributes
// DetailView Attributes Configuration
$attributes = [
    [
        'group' => true,
        'label' => 'BAHAGIAN 1 : Informasi Pemohon',
        'rowOptions' => ['class' => 'table-info']
    ],
    [
        'columns' => [
            [
//                'attribute' => 'jenisPenganjur',
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
            //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'No. MyKad/Passport',
                'value' => $model->pemohonID,
                'displayOnly' => true,
            //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Jawatan dan Gred',
                'value' => ucwords(strtolower($model->biodata->jawatan->nama.' - '.$model->biodata->jawatan->gred)),
                'displayOnly' => true,
            //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'JFPIB',
                'value' => ucwords(strtolower($model->biodata->department->fullname)),
                'displayOnly' => true,
            //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label' => 'Taraf Jawatan',
                'value' => ucwords(strtolower($model->biodata->statusLantikan->ApmtStatusNm)),
                'displayOnly' => true,
            //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'group' => true,
        'label' => 'BAHAGIAN 2 : Informasi Program',
        'rowOptions' => ['class' => 'table-info']
    ],
    [
        'columns' => [
            [
                'attribute' => 'jenisPenganjur',
                'label' => 'Jenis Penganjur',
                'format' => 'raw',
                'value' => '<kbd>' . $model->penganjur . '</kbd>',
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:100%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute' => 'namaPenganjur',
                'label' => 'Penganjur',
                'value' => $model->namaPenganjur,
                'displayOnly' => true,
            //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute' => 'namaProgram',
                'label' => 'Program',
                'format' => 'raw',
                'value' => $model->namaProgram,
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:100%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute' => 'tarikhMula',
                'value' => $model->tarikhMula,
                'displayOnly' => true,
            //'valueColOptions'=>['style'=>'width:90%'],
            ],
            [
                'attribute' => 'tarikhTamat',
                'value' => $model->tarikhTamat,
                'displayOnly' => true,
            //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute' => 'lokasi',
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
        'label' => 'BAHAGIAN 3 : Maklumat Anggaran Pembiayaan',
        'rowOptions' => ['class' => 'table-info']
    ],
    [
        'columns' => [
            [
                'attribute' => 'jumlahYuran',
                'label' => '<i class="fa fa-money" aria-hidden="true"></i> Yuran Program (RM)',
                'format'=>['decimal', 2],
                'value' => $model->jumlahYuran,
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:100%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute' => 'jumlahTiketPenerbangan',
                'label' => '<i class="fa fa-plane" aria-hidden="true"></i> Jumlah Tiket Penerbangan (RM)',
                'format'=>['decimal', 2],
                'value' => $model->jumlahTiketPenerbangan,
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:100%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute' => 'jumlahPenginapan',
                'label' => '<i class="fa fa-bed" aria-hidden="true"></i> Jumlah Bayaran Penginapan (RM)',
                'format'=>['decimal', 2],
                'value' => $model->jumlahPenginapan,
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:100%']
            ],
        ],
    ],
    [
        'label' => 'Jumlah (RM)',
        'value' => $model->jumlahYuran + $model->jumlahTiketPenerbangan + $model->jumlahPenginapan,
        'format' => ['decimal', 2],
        'inputContainer' => ['class' => 'col-sm-6'],
        // hide this in edit mode by adding `kv-edit-hidden` CSS class
        'rowOptions' => ['class' => 'warning kv-edit-hidden', 'style' => 'border-top: 5px double #dedede'],
    ],
    [
        'group' => true,
        'label' => 'BAHAGIAN 4 : Lain - lain',
        'rowOptions' => ['class' => 'table-info']
    ],
    [
        'columns' => [
            [
                'label' => 'Aspek Tugas Utama',
                'format' => 'raw',
                'value' => '<span class="text-justify"><em>' . $model->aspekTugasUtama . '</em></span>',
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
                'value' => $model->tarikhPohon,
                'displayOnly' => true,
                'valueColOptions' => ['style' => 'width:100%']
            ],
        ],
    ],
];

?>
<script>
    
//    document.getElementById("fname").addEventListener("change", myFunction);
//    document.getElementById("fname").addEventListener("change", myFunction);
//    document.getElementById("fname").addEventListener("change", myFunction);
    
    function countLayak(){
        
        var layakYuran = document.getElementById("LayakYuran").value == '' ? 0 : document.getElementById("LayakYuran").valueAsNumber;
        var layakTiket = document.getElementById("LayakTiket").value == '' ? 0 : document.getElementById("LayakTiket").valueAsNumber;
        var layakInap = document.getElementById("LayakInap").value == '' ? 0 : document.getElementById("LayakInap").valueAsNumber;

        var jumlahLayak = 0;
        jumlahLayak = layakYuran + layakTiket + layakInap;
        
        document.getElementById("JumlahLayak").innerHTML = jumlahLayak;
    }
    
    function countSyor(){

        var layakYuran = document.getElementById("SyorYuran").value == '' ? 0 : document.getElementById("SyorYuran").valueAsNumber;
        var layakTiket = document.getElementById("SyorTiket").value == '' ? 0 : document.getElementById("SyorTiket").valueAsNumber;
        var layakInap = document.getElementById("SyorInap").value == '' ? 0 : document.getElementById("SyorInap").valueAsNumber;
        
        var jumlahLayak = 0;
        jumlahLayak = layakYuran + layakTiket + layakInap;
        
        document.getElementById("JumlahSyor").innerHTML = jumlahLayak;
        
        
    }
    
    function countLulus(){

        var layakYuran = document.getElementById("LulusYuran").value == '' ? 0 : document.getElementById("LulusYuran").valueAsNumber;
        var layakTiket = document.getElementById("LulusTiket").value == '' ? 0 : document.getElementById("LulusTiket").valueAsNumber;
        var layakInap = document.getElementById("LulusInap").value == '' ? 0 : document.getElementById("LulusInap").valueAsNumber;
        
        var jumlahLayak = 0;
        jumlahLayak = layakYuran + layakTiket + layakInap;
        
        document.getElementById("JumlahLulus").innerHTML = jumlahLayak;
        
        
    }
</script>
<!--<script>
document.getElementById("fname").addEventListener("change", myFunction);

function myFunction() {
  var x = document.getElementById("fname");
  x.value = x.value.toUpperCase();
}
</script>-->
<!-- ************************************ DETAIL VIEW ********************************************* -->

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
//                    'panel' => [
//                        'type' => 'info', 
//                        'heading' => 'Butir-Butir Latihan',
//                        //'footer' => '<div class="text-center text-muted">This is a sample footer message for the detail view.</div>'
//                    ],
                'buttons1' => false,
                'deleteOptions' => [// your ajax delete parameters
                    'params' => ['id' => $model->permohonanID, 'kvdelete' => true],
                ],
                'container' => ['id' => 'kv-demo'],
                'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
            ]);
            ?>
            
<!-- ************************************ UPDATE / DELETE BUTTON ********************************************* -->
<!-- If user application status is NEW, then and only then USER can update or delete his application -->
<?php if ($userLevel == "user" && $model->statusPermohonan == '1') { ?>
                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">  
                        <?= Html::a('<i class="fa fa-edit"></i> Kemaskini ', ['update-latihan-luaran-pohon', 'permohonanID' => $model->permohonanID], ['class' => 'btn btn-primary']) ?>
                        <?=
                        Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Hapus', ['delete-latihan-luaran-pohon', 'id' => $model->permohonanID], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Adakah anda pasti anda ingin menghapuskan permohonan ini?',
                                'method' => 'post',
                            ],
                        ])
                        ?>
                    </div>
                </div>
 
 <!-- ************************************ JFPIB'S CHIEF CHECKING RESULT ********************************************* -->
 <!-- If user application status was already being checked by his chief, 
 his result will be shown -->
<?php } 

//    elseif (($userLevel == "user" && $model->statusKJ == '3') 
//        || ($userLevel == "user" && $model->statusKJ == '4') 
//        || (($userLevel == "ul" && $model->statusPermohonan == '3') 
//        || ($userLevel == "ul" && $model->statusPermohonan == '4')))

    elseif (($model->statusKJ && $update == "NO") || ($model->statusUL && $update == "YES"))
    
    {
            ?>
        <div class="row"> 
            <div class="x_panel">      
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Semakan Ketua JFPIB</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
        <?php //$forms = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <?php $forms = ActiveForm::begin([
                            'action' => ['view-latihan-luar-pohon?permohonanID='.$model->permohonanID.'&userLevel=chief&update=YES'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]); 
                ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->statusKJJ;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12"><!--
                            <?php //$formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>-->
                                <div class="x_panel" style="background-color: #cecece">
                                    <?php 
                                        if ($model->ulasanKJ){
                                            echo $model->ulasanKJ;
                                        } else {
                                            echo 'TIADA ULASAN';
                                        } 
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12"><!--
                            <?php //$formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>-->
                                <div class="x_panel" style="background-color: #cecece">
                                    <?= $model->tarikhSemakanKJ; ?>
                                </div>
                            </div>
                        </div>
                        <!-- ********** Failed application notification for USER ********* -->
                        <?php if ($model->statusKJ == '3' && $userLevel == 'user') { ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                            <div class="col-md-8 col-sm-8 col-xs-12"><!--
                            <?php //$formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>-->
                                <div class="x_panel" style="background-color: #cecece">HARAP MAAF. Permohonan anda tidak berjaya.
                                </div>
                            </div>
                        </div> 
                        <?php } ?>
                        <!-- ************************************************************** -->
                        <?php if (($userLevel == "chief" && $model->statusPermohonan == "3") || ($userLevel == "chief" && $model->statusPermohonan == "4") ) { ?>
                        <div class="form-group">
                            <div class="col-sm-3"></div> 
                            <div class="col-sm-9">
                                <?php //Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                                <?php //Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                                <p align="right"><?= Html::submitButton(Yii::t('app', 'Kemaskini <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'), ['class' => 'btn btn-primary']) ?></p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
        <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
<!-- ul checking form -->
        <?php } ?>
        </div>
    </div>
</div>

<?php
//if ($userLevel == "chief") AND belum buat pengesahan by chief ATAU mahu kemaskini by chief (ada form kemaskini) {
if (($userLevel == "chief" && $model->statusPermohonan == '1') || ($userLevel == "chief" && $update == 'YES')) {
        ?>
        <div class="row"> 
            <div class="x_panel">      
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Semakan Ketua JFPIB</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <?php $formx = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?=
                                $formx->field($model, 'statusKJ')->label(false)->widget(Select2::classname(), [
                                    'data' => [
                                        '3' => 'TIDAK LAYAK MENGHADIRI KURSUS',
                                        '4' => 'LAYAK MENGHADIRI KURSUS',
                                    ],
                                    'options' => ['placeholder' => 'Sila Pilih'],
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?= $formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3"></div> 
                            <div class="col-sm-9">
                                <?php //Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                                <?php //Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                                <p align="right"><?= Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), ['class' => 'btn btn-primary']) ?></p>
                            </div>
                        </div>

                    </div>
        <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div> 
    <?php } ?>

 <!-- ************************************ UNIT LATIHAN CHECKING FORM ********************************************* -->
 <!-- If user application status was already being checked by his chief AND not being checked by UL, 
 then a checking form will be shown for UL only -->
<?php 
if ($userLevel == "ul" || $userLevel == "user" || $userLevel == "pegawaiLatihan" || $userLevel == "ketuaSektor") {
    if (($userLevel == "ul" && $model->statusKJ == '4' && !$model->statusUL) || ($userLevel == "ul" && $update == 'YES')) {
        
// if ( ($userLevel == "ul" && $model->statusPermohonan == '3') || ($userLevel == "ul" && $model->statusPermohonan == '4')){   
?>
        <div class="row"> 
            <div class="x_panel">      
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Semakan Unit Latihan 1</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php $formv = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <?php
            // View file rendering the widget
//            DetailView::widget([
//                'model' => $model,
//                'attributes' => $attributes2,
//                'mode' => 'edit',
//                'bordered' => true,
//                'striped' => true,
//                'condensed' => true,
//                'responsive' => true,
//                'hover' => true,
//                'hAlign' => 'right',
//                'vAlign' => 'middle',
//                'fadeDelay' => 1,
//                'panel' => [
//                        'type' => 'info', 
//                        //'heading' => 'Butir-Butir Latihan',
//                        'footer' => '<p align="right">'.Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), 
//                                ['class' => 'btn btn-primary']).'</p>',
//                ],
//                //'buttons1' => '{update}',
//                'buttons2' => false,
//                'deleteOptions' => [// your ajax delete parameters
//                    'params' => ['id' => $model->permohonanID, 'kvdelete' => true],
//                ],
//                'container' => ['id' => 'kv-demo'],
//                'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])], // your action to delete
//                //'saveOptions' => ['label' => Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), ['class' => 'btn btn-primary'])],
//                'buttonContainer' => ['class' => 'float-right pull-right'],
//            ]);
            ?>
                    <?php ActiveForm::end(); ?>
               <?php $forma = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kelayakan Yuran Program (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                        <?= $forma->field($model, 'layakYuran')->textInput(['class' => 'form-control col-md-7 col-xs-12', 'oninput' => 'countLayak()', 'id' => 'LayakYuran', 'type' => 'number', 'min' => '0'])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kelayakan Tiket Penerbangan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                        <?= $forma->field($model, 'layakTiketPenerbangan')->textInput(['class' => 'form-control col-md-7 col-xs-12', 'oninput' => 'countLayak()', 'id' => 'LayakTiket', 'type' => 'number', 'min' => '0'])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Kelayakan Penginapan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                        <?= $forma->field($model, 'layakPenginapan')->textInput(['class' => 'form-control col-md-7 col-xs-12', 'oninput' => 'countLayak()', 'id' => 'LayakInap', 'type' => 'number', 'min' => '0'])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Kelayakan RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12" >
                                <div class="x_panel" style="background-color: #cecece" id="JumlahLayak">
                                    <?php 
                                        
                                        if ($model->statusUL){
                                            echo $model->jumlahLayakk;
                                        } else {
                                            echo '0';
                                        }
                                    
                                    ?>
                                    
                                </div>
                        </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                //<?php 
//                                $forma->field($model, 'statusUL')->label(false)->widget(Select2::classname(), [
//                                    'data' => [
//                                        '5' => 'TIDAK LAYAK MENGHADIRI KURSUS',
//                                        '6' => 'LAYAK MENGHADIRI KURSUS',
//                                    ],
//                                    'options' => ['placeholder' => 'Sila Pilih'],
//                                ]);
                                ?>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?= $forma->field($model, 'ulasanUL')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3"></div> 
                            <div class="col-sm-9">
                                <?php //Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                                <?php //Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                                <p align="right"><?= Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), ['class' => 'btn btn-primary']) ?></p>
                            </div>
                        </div>

                    </div>
        <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div> 
<?php } elseif ($model->statusUL || $userLevel == "pegawaiLatihan"){ ?>
 
             <div class="row"> 
            <div class="x_panel">      
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Semakan Unit Latihan 2</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
        <?php //$formx = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <?php $formb = ActiveForm::begin([
                            'action' => ['view-latihan-luar-pohon?permohonanID='.$model->permohonanID.'&userLevel=ul&update=YES'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],

                ]); ?> 
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <?php if ($userLevel != 'user'){ ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kelayakan Yuran Program (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->layakYuran;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kelayakan Tiket Penerbangan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->layakTiketPenerbangan;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kelayakan Penginapan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->layakPenginapan;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Kelayakan RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12" >
                                <div class="x_panel" style="background-color: #cecece" id="JumlahLayak">
                                    <?= $model->jumlahLayakk; ?>
                                </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12"><!--
                            <?php //$formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>-->
                                <div class="x_panel" style="background-color: #cecece">
                                    <?php 
                                        if ($model->ulasanUL){
                                            echo $model->ulasanUL;
                                        } else {
                                            echo 'TIADA ULASAN UNIT LATIHAN';
                                        } 
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->statusULL;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12"><!--
                            <?php //$formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>-->
                                <div class="x_panel" style="background-color: #cecece">
                                    <?= $model->tarikhSemakanUL; ?>
                                </div>
                            </div>
                        </div>
                        <?php //if ($userLevel == "ul") { ?>
<!--                        <div class="form-group">
                            <div class="col-sm-3"></div> 
                            <div class="col-sm-9">
                                <?php //Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                                <?php //Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                                <p align="right"><?= Html::submitButton(Yii::t('app', 'Kemaskini <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'), ['class' => 'btn btn-primary']) ?></p>
                            </div>
                        </div>-->
                        <?php //} ?>
                    </div>
        <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div> 
 <?php } ?>
<?php } ?>

<?php 
 //if ($userLevel == "chief") AND belum buat pengesahan by chief ATAU mahu kemaskini by chief (ada form kemaskini) {
if (($userLevel == "pegawaiLatihan" && $model->statusBSM == NULL) || ($userLevel == "pegawaiLatihan" && $update == 'YES')) {
        ?>
        <div class="row"> 
            <div class="x_panel">      
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Semakan Pegawai BSM 1</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <?php $formk = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Syor Yuran Program (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                        <?= $formk->field($model, 'syorYuran')->textInput(['class' => 'form-control col-md-7 col-xs-12', 'oninput' => 'countSyor()', 'id' => 'SyorYuran', 'type' => 'number', 'min' => '0', 'value' => $model->syorYuran != 0 ? $model->syorYuran : $model->layakYuran])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Syor Tiket Penerbangan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                        <?= $formk->field($model, 'syorTiketPenerbangan')->textInput(['class' => 'form-control col-md-7 col-xs-12', 'oninput' => 'countSyor()', 'id' => 'SyorTiket', 'type' => 'number', 'min' => '0', 'value' => $model->syorTiketPenerbangan != 0 ? $model->syorTiketPenerbangan : $model->layakTiketPenerbangan])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Syor Penginapan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                        <?= $formk->field($model, 'syorPenginapan')->textInput(['class' => 'form-control col-md-7 col-xs-12', 'oninput' => 'countSyor()', 'id' => 'SyorInap', 'type' => 'number', 'min' => '0', 'value' => $model->syorPenginapan != 0 ? $model->syorPenginapan : $model->layakPenginapan])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Syor (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12" >
                                <div class="x_panel" style="background-color: #cecece" id="JumlahSyor">
                                    <?php 
                                        
                                        if ($model->statusBSM){
                                            echo $model->jumlahSyorr;
                                        } else {
                                            
                                            if ($model->statusUL && !$model->statusBSM){
                                                echo $model->jumlahLayakk;
                                            } else {
                                                echo '0';
                                            }
                                        }
                                    
                                    ?>
                                    
                                </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?=
                                $formk->field($model, 'statusBSM')->label(false)->widget(Select2::classname(), [
                                    'data' => [
                                        '7' => 'TIDAK LAYAK MENGHADIRI KURSUS',
                                        '8' => 'LAYAK MENGHADIRI KURSUS',
                                    ],
                                    'options' => ['placeholder' => 'Sila Pilih'],
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?= $formk->field($model, 'ulasanBSM')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3"></div> 
                            <div class="col-sm-9">
                                <?php //Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                                <?php //Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                                <p align="right"><?= Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), ['class' => 'btn btn-primary']) ?></p>
                            </div>
                        </div>

                    </div>
        <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div> 
    <?php } 

    //if ($userLevel == "chief" ATAU "ul") AND sudah buat pengesahan by chief/ul AND ada button kemaskini untuk chief {
    
    elseif ($userLevel == "pegawaiLatihan" || $userLevel == "ketuaSektor" || ($userLevel == "ul" && $model->statusBSM != NULL) || ($userLevel == "user" && $model->statusBSM != NULL)) {
    //elseif (($userLevel == "pegawaiLatihan" && $model->statusBSM == NULL) || ($userLevel == "pegawaiLatihan" && $update == 'YES')) {
        ?>
        <div class="row"> 
            <div class="x_panel">      
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Semakan Pegawai BSM 2</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
        <?php //$formx = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <?php $formj = ActiveForm::begin([
                            'action' => ['view-latihan-luar-pohon?permohonanID='.$model->permohonanID.'&userLevel=pegawaiLatihan&update=YES'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],

                ]); ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <?php if ($userLevel != 'user'){ ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Syor Yuran Program (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->syorYuran;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Syor Tiket Penerbangan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->syorTiketPenerbangan;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Syor Penginapan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->syorPenginapan;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Syor (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12" >
                                <div class="x_panel" style="background-color: #cecece" id="JumlahLayak">
                                    <?= $model->jumlahSyorr; ?>
                                </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12"><!--
                            <?php //$formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>-->
                                <div class="x_panel" style="background-color: #cecece">
                                    <?php 
                                        if ($model->ulasanBSM){
                                            echo $model->ulasanBSM;
                                        } else {
                                            echo 'TIADA ULASAN';
                                        } 
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->statusBSMM;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12"><!--
                            <?php //$formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>-->
                                <div class="x_panel" style="background-color: #cecece">
                                    <?= $model->tarikhSemakanBSM; ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($userLevel == "pegawaiLatihan" && !$model->statusSektor) { ?>
                        <div class="form-group">
                            <div class="col-sm-3"></div> 
                            <div class="col-sm-9">
                                <?php //Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                                <?php //Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                                <p align="right"><?= Html::submitButton(Yii::t('app', 'Kemaskini <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'), ['class' => 'btn btn-primary']) ?></p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
        <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>   
    <?php }
//} ?>
 
 <?php 
if (($userLevel == "ketuaSektor" && $model->statusSektor == NULL) || ($userLevel == "ketuaSektor" && $update == 'YES')) {
        ?>
        <div class="row"> 
            <div class="x_panel">      
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Semakan Ketua Sektor 1</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <?php $formk = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Lulus Yuran Program (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                        <?= $formk->field($model, 'lulusYuran')->textInput(['class' => 'form-control col-md-7 col-xs-12', 'oninput' => 'countLulus()', 'id' => 'LulusYuran', 'type' => 'number', 'min' => '0', 'value' => $model->lulusYuran != 0 ? $model->lulusYuran : $model->syorYuran])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Lulus Tiket Penerbangan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                        <?= $formk->field($model, 'lulusTiket')->textInput(['class' => 'form-control col-md-7 col-xs-12', 'oninput' => 'countLulus()', 'id' => 'LulusTiket', 'type' => 'number', 'min' => '0', 'value' => $model->lulusTiket != 0 ? $model->lulusTiket : $model->syorTiketPenerbangan])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Lulus Penginapan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                        <?= $formk->field($model, 'lulusPenginapan')->textInput(['class' => 'form-control col-md-7 col-xs-12', 'oninput' => 'countLulus()', 'id' => 'LulusInap', 'type' => 'number', 'min' => '0', 'value' => $model->lulusPenginapan != 0 ? $model->lulusPenginapan : $model->syorPenginapan])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Diluluskan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12" >
                                <div class="x_panel" style="background-color: #cecece" id="JumlahLulus">
                                    <?php 
                                        
                                        if ($model->statusSektor){
                                            echo $model->jumlahLuluss;
                                        } else {
                                            
                                            if ($model->statusBSM && !$model->statusSektor){
                                                echo $model->jumlahSyorr;
                                            } else {
                                                echo '0';
                                            }
                                        }
                                    
                                    ?>
                                    
                                </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kelulusan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?=
                                $formk->field($model, 'statusSektor')->label(false)->widget(Select2::classname(), [
                                    'data' => [
                                        '9' => 'PERMOHONAN TIDAK DILULUSKAN',
                                        '10' => 'PERMOHONAN DILULUSKAN',
                                    ],
                                    'options' => ['placeholder' => 'Sila Pilih'],
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?= $formk->field($model, 'ulasanSektor')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3"></div> 
                            <div class="col-sm-9">
                                <?php //Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                                <?php //Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                                <p align="right"><?= Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), ['class' => 'btn btn-primary']) ?></p>
                            </div>
                        </div>

                    </div>
        <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div> 
    <?php } 
    
    elseif (($userLevel == "pegawaiLatihan" && $model->statusSektor != NULL) || $userLevel == "ketuaSektor" || ($userLevel == "ul" && $model->statusSektor != NULL) || ($userLevel == "user" && $model->statusSektor != NULL )) {
    //elseif (($userLevel == "pegawaiLatihan" && $model->statusBSM == NULL) || ($userLevel == "pegawaiLatihan" && $update == 'YES')) {
        ?>
        <div class="row"> 
            <div class="x_panel">      
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Semakan Ketua Sektor 2</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
        <?php //$formx = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <?php $formj = ActiveForm::begin([
                            'action' => ['view-latihan-luar-pohon?permohonanID='.$model->permohonanID.'&userLevel=ketuaSektor&update=YES'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],

                ]); ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <?php if ($userLevel != 'user'){ ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Lulus Yuran Program (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->lulusYuran;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Lulus Tiket Penerbangan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->lulusTiket;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Lulus Penginapan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->lulusPenginapan;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Diluluskan (RM) : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12" >
                                <div class="x_panel" style="background-color: #cecece" id="JumlahLayak">
                                    <?= $model->jumlahLuluss; ?>
                                </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12"><!--
                            <?php //$formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>-->
                                <div class="x_panel" style="background-color: #cecece">
                                    <?php 
                                        if ($model->ulasanSektor){
                                            echo $model->ulasanSektor;
                                        } else {
                                            echo 'TIADA ULASAN';
                                        } 
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="x_panel" style="background-color: #cecece">
                                <?= 
                                    $model->statusSektorr;
                                    //$formx->field($model, Yii::$app->formatter->asRaw('statusPermohonann'))->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)
                                ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan : <span class="required"></span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12"><!--
                            <?php //$formx->field($model, 'ulasanKJ')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>   
                            </div>-->
                                <div class="x_panel" style="background-color: #cecece">
                                    <?= $model->tarikhKelulusan; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- butang kemaskini -->
                    </div>
        <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>   
    <?php }
//} ?>

<head>  
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v3.3.1/css/all.css">
</head>