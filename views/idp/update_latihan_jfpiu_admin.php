<?php
use yii\helpers\Html; 
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use app\models\myidp\KlusterKursus;
use app\models\myidp\IdpKategoriJawatan;
use app\models\myidp\IdpCampus;
use app\models\myidp\StatusLatihan;
use app\models\myidp\Kategori;
use dosamigos\datepicker\DatePicker;
use kartik\time\TimePicker;
use kartik\widgets\Select2;

echo $this->render('/idp/_topmenu'); 
?>
<div class="latihan-form"> 
    <div class="col-md-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2>Permohonan Mata IDP Bagi Penganjuran Kursus Oleh JFPIU</h2> 
                    <div class="clearfix"></div>
                </div>
            <div class="x_content">
            
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT PENGANJUR</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">Penganjur: <span class="required" style="color:red;">*</span>
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Kompetensi: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php 
                        
                        //use app\models\KlusterKursus;
                        $kompetensi = Kategori::find()
                                ->orderBy("kategori_id")
                                ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData=ArrayHelper::map($kompetensi,'kategori_id','kategori_nama');
                        
                        echo $form->field($model, 'kompetensi')->dropDownList(
                            $listData,
                            ['prompt'=>'Select...']
                            )->label(false)  ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Jumlah Mata IDP Diluluskan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model2, 'jumlahMataIDP')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Peserta : </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= 
                    // With a model and without ActiveForm
                    Select2::widget([
                        'name' => 'momo',
                        'value' => $peserta,
                        'data' => $allStaf,
                        'options' => ['placeholder' => 'Sila pilih...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ],
                    ]);
                    ?>
                    </div>
            
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
