<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use app\models\myidp\RefJenisAktiviti;

/* @var $this yii\web\View */
/* @var $model app\models\myidp\PermohonanKursusLuar */
/* @var $form ActiveForm */

echo $this->render('/idp/_topmenu');

$js=<<<js
    $(document).ready(function(){
        
        $(".a").hide();
        $(".b").hide();
        $(".c").hide();
        $(".d").hide();
        
        var val1 = $("#jenis_carian").val();
        switch(parseInt(val1)) {
                case 1:
                   $(".a").show();
                   $(".b").show();
                   $(".c").show();
                   $(".d").hide();
                   break;
        
                case 2:
                   $(".a").show();
                   $(".b").show();
                   $(".c").show();
                   $(".d").hide();
                   break;
        
                case 3:
                   $(".a").show();
                   $(".b").hide();
                   $(".c").hide();
                   $(".d").hide();
                   break;
        
                case 4:
                   $(".a").show();
                   $(".b").hide();
                   $(".c").hide();
                   $(".d").hide();
                   break;
        
                case 5:
                   $(".a").show();
                   $(".b").hide();
                   $(".c").hide();
                   $(".d").hide();
                   break;
        
                case 6:
                   $(".a").show();
                   $(".b").hide();
                   $(".c").hide();
                   $(".d").hide();
                   break;
        
                case 7:
                   $(".a").show();
                   $(".b").hide();
                   $(".c").hide();
                   $(".d").hide();
                   break;
        }
        
        $('#jenis_carian').on('select2:close', function(e) {
            
            var val = $('#jenis_carian').val();
            
            switch(parseInt(val)) { 
                case 1:
                   $("#jenis_penganjur").val('').trigger('change');
                   $("#kompetensi").val('').trigger('change');
                   $(':input').not(":button").val('');
                   $(".a").show();
                   $(".b").show();
                   $(".c").show();
                   $(".d").hide();
                   break;
        
                case 2:
                   $("#jenis_penganjur").val('').trigger('change');
                   $("#kompetensi").val('').trigger('change');
                   $(':input').not(":button").val('');
                   $(".a").show();
                   $(".b").show();
                   $(".c").show();
                   $(".d").hide();
                   break;
        
                case 3:
                   $("#jenis_penganjur").val('').trigger('change');
                   $("#kompetensi").val('').trigger('change');
                   $(':input').not(":button").val('');
                   $(".a").show();
                   $(".b").hide();
                   $(".c").hide();
                   $(".d").hide();
                   break;
        
                case 4:
                   $("#jenis_penganjur").val('').trigger('change');
                   $("#kompetensi").val('').trigger('change');
                   $(':input').not(":button").val('');
                   $(".a").show();
                   $(".b").hide();
                   $(".c").hide();
                   $(".d").hide();
                   break;
        
                case 5:
                   $("#jenis_penganjur").val('').trigger('change');
                   $("#kompetensi").val('').trigger('change');
                   $(':input').not(":button").val('');
                   $(".a").show();
                   $(".b").hide();
                   $(".c").hide();
                   $(".d").hide();
                   break;
        
                case 6:
                   $("#jenis_penganjur").val('').trigger('change');
                   $("#kompetensi").val('').trigger('change');
                   $(':input').not(":button").val('');
                   $(".a").show();
                   $(".b").hide();
                   $(".c").hide();
                   $(".d").hide();
                   break;
        
                case 7:
                   $("#jenis_penganjur").val('').trigger('change');
                   $("#kompetensi").val('').trigger('change');
                   $(':input').not(":button").val('');
                   $(".a").show();
                   $(".b").hide();
                   $(".c").hide();
                   $(".d").hide();
                   break;
            }
        
            $('#jenis_carian').val(val);
        
        });
        
        $('#jenis_penganjur').on('select2:close', function(e) {
            
            var val2 = $('#jenis_penganjur').val();
            
            switch(parseInt(val2)) { 
                case 1:
//                   $("#senarai").val('').trigger('change');
//                   $("#tahun").val('').trigger('change');
//                   $(':input').not(":button").val('');
                   $(".a").show();
                   $(".b").show();
                   $(".c").show();
                   $(".d").show();
                   break;
        
                case 2:
//                   $("#senarai").val('').trigger('change');
//                   $("#tahun").val('').trigger('change');
//                   $(':input').not(":button").val('');
                   $(".a").show();
                   $(".b").show();
                   $(".c").show();
                   $(".d").hide();
                   break;
        
            }
        
            $('#jenis_penganjur').val(val2);
        
        });
        
    });
js;
$this->registerJs($js);

?>
<script>
function checkDate(){
    
    var startDate = new Date(document.getElementById("StartDate").value);
    
    var checkDate = new Date();
    
    var endDate = new Date(document.getElementById("EndDate").value);
    if ((Date.parse(startDate)-2592000000 <= Date.parse(checkDate))) {
        alert("HARAP MAAF! Tarikh mula kursus haruslah lebih daripada 30 hari daripada tarikh sekarang.");
        document.getElementById("StartDate").value = "";
    }
    
    if ((Date.parse(endDate) < Date.parse(startDate))) {
        alert("RALAT! Tarikh akhir kursus haruslah selepas tarikh mula. Sila isi kembali.");
        document.getElementById("EndDate").value = "";
    }
}  
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'right',
            title : "<p>Sila muatnaik dokumen berkaitan kursus luar yang dipohon seperti poster, brosur, iklan dan sebagainya.</p>",
            html : true
        })
    });
</script>
<div class="idp-mohonkursusluar">
    <div class="col-md-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2>Permohonan Mata IDP</h2> 
                    <div class="clearfix"></div>
                </div>
            <div class="x_content">       
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <div class="form-group" >
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis_carian">Jenis Aktiviti</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= 
                            
                            $form->field($model, 'jenisAktivitiPohon')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(RefJenisAktiviti::find()->all(), 'jenisAktivitiID', 
                                        function($model){
                                            $a = $model['deskripsiAktiviti'].' - '.$model['kumpulan'];
                                            return $a;
                                        }),
                                        //'hideSearch' => true,
                                        'options' => ['placeholder' => 'Pilih Aktiviti', 
                                            'class' => 'form-control col-md-7 col-xs-12',
                                            'id' => 'jenis_carian'],
                                        'pluginOptions' => [
                                            //'allowClear' => true
                                        ],
                                        'theme' => Select2::THEME_CLASSIC,
                                    ]);
                                                 
                        ?>
                    </div>
                </div>
                <div class="form-group b">
<!--                <div class="form-group" >-->
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tajuk Kursus : 
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'namaProgram')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>
                    </div>
                </div>
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT PENGANJUR</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Penganjur : 
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= 
                            $form->field($model, 'jenisPenganjur')->label(false)->widget(Select2::classname(),
                                [
                                    'data' => [
                                        '1' => 'Agensi Luar (External Agencies)',
                                        '2' => 'UMS (JFPIU/Persatuan/Kesatuan/Kelab)'
                                        ],
                                    'options' => [
                                        'placeholder' => 'Sila Pilih',
                                        ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        ],
                                    'theme' => Select2::THEME_CLASSIC,
                                ]); 
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penganjur : 
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'namaPenganjur')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat : 
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula : 
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'tarikhMula',
                            'template' => '{input}{addon}',
                            'options' => [
                            'class' => 'form-control col-lg-4 col-md-7 col-xs-12',
                            'onchange' => 'checkDate()',
                            'id' => 'StartDate',
                            ],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',                           
                                'startDate' => '2020-01-01',
                                'endDate' => '2020-12-31',
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat : 
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'tarikhTamat',
                            'template' => '{input}{addon}',
                            'options' => [
                            'class' => 'form-control col-lg-4 col-md-7 col-xs-12',
                            'onchange' => 'checkDate()', 
                            'id' => 'EndDate',
                            ],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'startDate' => '2020-01-01',
                                'endDate' => '2020-12-31',
                            ]
                        ]);
                        ?>
                    </div>
                </div>
               
                
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Aspek Tugas Utama Pemohon Yang Berkaitan Dengan Program Pembangunan Profesional Yang Dipohon : 
                    <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?= $form->field($model, 'laporan')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>   
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muatnaik dokumen (1) : 
                    <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-10">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php
//                    if (!empty($model2->filename) && $model2->filename != 'deleted') {
//                        echo Html::a(Yii::$app->FileManager->NameFile($model2->filename));
//                        echo '&nbsp&nbsp&nbsp&nbsp';
//                        if($model2->id){
//                            echo Html::a('Padam', ['deletegambar', 'id' => $model2->id], ['class' => 'btn btn-danger']) . '<p>';
//                        }
//                        
//                    }
//                    else{
                       echo $form->field($model, 'file1')->fileInput()->label(false);
                            //$form->field($model, 'failProgram1')
                    //}
                    ?>
                </div>
                <span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muatnaik dokumen (2) : 
                </label>
                <div class="col-md-4 col-sm-4 col-xs-10">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php
//                    if (!empty($model2->filename) && $model2->filename != 'deleted') {
//                        echo Html::a(Yii::$app->FileManager->NameFile($model2->filename));
//                        echo '&nbsp&nbsp&nbsp&nbsp';
//                        if($model2->id){
//                            echo Html::a('Padam', ['deletegambar', 'id' => $model2->id], ['class' => 'btn btn-danger']) . '<p>';
//                        }
//                        
//                    }
//                    else{
                       echo $form->field($model, 'file2')->fileInput()->label(false);
                            //$form->field($model, 'failProgram1')
                    //}
                    ?>
                </div>
                <span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>
                </div> 
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muatnaik dokumen (3) :
                </label>
                <div class="col-md-4 col-sm-4 col-xs-10">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php
//                    if (!empty($model2->filename) && $model2->filename != 'deleted') {
//                        echo Html::a(Yii::$app->FileManager->NameFile($model2->filename));
//                        echo '&nbsp&nbsp&nbsp&nbsp';
//                        if($model2->id){
//                            echo Html::a('Padam', ['deletegambar', 'id' => $model2->id], ['class' => 'btn btn-danger']) . '<p>';
//                        }
//                        
//                    }
//                    else{
                       echo $form->field($model, 'file3')->fileInput()->label(false);
                            //$form->field($model, 'failProgram1')
                    //}
                    ?>
                </div>
                <span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>
                </div> 
                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">
                        <?php //Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                        <?php //Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                        <p align="right"><?= Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), ['class' => 'btn btn-primary']) ?></p>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>