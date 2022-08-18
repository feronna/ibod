<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\myidp\PermohonanKursusLuar */
/* @var $form ActiveForm */

echo $this->render('/idp/_topmenu'); 

?>
<div class="idp-mohonkursusluar">
    <div class="col-md-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2>Permohonan Kursus Luar</h2> 
                    <div class="clearfix"></div>
                </div>
            <div class="x_content">
    <?php //$form = ActiveForm::begin(); ?>
    <?php //$form = ActiveForm::begin(['layout' => 'horizontal']) ?>        
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
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
                                        'placeholder' => 'Sila Pilih'
                                        ]
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
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT PROGRAM</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Program : 
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'namaProgram')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat : 
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'tarikhTamat',
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Yuran Program (RM) : 
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'jumlahYuran')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tiket Kapal Terbang (RM) : 
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'jumlahTiketPenerbangan')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Hotel Penginapan (RM) : 
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'jumlahPenginapan')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    ASPEK TUGAS UTAMA PEMOHON YANG BERKAITAN DENGAN PROGRAM PEMBANGUNAN PROFESIONAL YANG DIPOHON : 
                    <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?= $form->field($model, 'aspekTugasUtama')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>   
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