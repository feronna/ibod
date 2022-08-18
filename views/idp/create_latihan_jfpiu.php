<?php
use yii\helpers\Html; 
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use app\models\myidp\KlusterKursus;
use app\models\myidp\IdpKategoriJawatan;
use app\models\myidp\IdpCampus;
use app\models\myidp\StatusLatihan;
use dosamigos\datepicker\DatePicker;
use kartik\time\TimePicker;

echo $this->render('/idp/_topmenu'); 
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
<div class="latihan-form"> 
    <div class="col-md-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2>Permohonan Mata IDP Bagi Penganjuran Kursus Oleh JAFPIB</h2> 
                    <div class="clearfix"></div>
                </div>
            <div class="x_content">
            
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT PEMILIK MODUL</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">Pemilik Modul: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'penggubalModul')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT PENGANJURAN PROGRAM</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Tajuk : <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'tajukLatihan')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Tempat : <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model2, 'lokasi')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_date">Tarikh Mula : <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        DatePicker::widget([
                            'model' => $model2,
                            'attribute' => 'tarikhMula',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_date">Tarikh Tamat : <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        DatePicker::widget([
                            'model' => $model2,
                            'attribute' => 'tarikhAkhir',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Masa Mula: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    TimePicker::widget([
                        'model' => $model2,
                        'attribute' => 'masaMula',
                        'pluginOptions' => [
                            'showMeridian' => true,
                            'minuteStep' => 1,
                            'secondStep' => 5,
                            'defaultTime' => '8:00 AM',
                        ]
                    ]);
                    ?>
                </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Masa Tamat : <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    TimePicker::widget([
                        'model' => $model2,
                        'attribute' => 'masaTamat',
                        'pluginOptions' => [
                            'showMeridian' => true,
                            'minuteStep' => 1,
                            'secondStep' => 5,
                            'defaultTime' => '5:00 PM',
                        ]
                    ]);
                    ?>
                </div>
                </div>
<!--                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Status Latihan: <span class="required" style="color:red;">*</span>
                    </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php 

//                            //use app\models\Tahap;
//                            $statusLatihan = StatusLatihan::find()
//                                    ->orderBy("statusLatihanID")
//                                    ->all();
//
//                            //use yii\helpers\ArrayHelper;
//                            $listData2 = ArrayHelper::map($statusLatihan, 'statusLatihanID', 'statusLatihanID');
//
//                            echo $form->field($model2, 'statusSiriLatihan')->dropDownList(
//                                $listData2,
//                                ['prompt'=>'Select...']
//                                )->label(false);
                            ?>

                        </div>
                </div>-->
<!--                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Jumlah Jam Latihan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php //$form->field($model2, 'jumlahJamLatihan')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Jumlah Mata IDP Dipohon: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model2, 'jumlahMataIDP')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Upload File: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-10">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php

                       echo $form->field($model2, 'file')->fileInput()->label(false);
                    ?>
                </div>
                <span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>
        </div> 
                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
