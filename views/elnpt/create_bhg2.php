<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;    
use app\models\elnpt\RefPnpKursus;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>
            
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        
        <div class="panel-body">
            <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahap Penyeliaan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($pnp, 'tahap_penyeliaan')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                'PhD (Penyelidikan)' => 'PhD (Penyelidikan) - Penyeliaan Luar', 
                                'Sarjana (Penyelidikan)' => 'Sarjana (Penyelidikan) - Penyeliaan Luar',
                                'DrPH' => 'DrPH (Doctor of Public Health) - Penyeliaan Luar',
//                                'Sarjana (Penyelidikan)' => 'Sarjana (Penyelidikan)', 
//                                'DrPH (Doctor of Public Health)' => 'DrPH (Doctor of Public Health)', 'Sarjana (Kerja Kursus)' => 'Sarjana (Kerja Kursus)', 
//                                'Sarjana Muda (Projek Tahun Akhir/ Latihan Industri/ Latihan Amali/ Praktikum)' => 'Sarjana Muda (Projek Tahun Akhir/ Latihan Industri/ Latihan Amali/ Praktikum)'
                                ],
                            'hideSearch' => true,
                            'options' => [
                                'placeholder' => 'Carian ...', 
//                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                                ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="col-md-12 col-sm-12 col-xs-12"><strong>SEBAGAI PENYELIA UTAMA / PENGERUSI</strong></label>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Telah Perlanjutan</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($pnp, 'utama_telah')->textInput([
//                                'placeholder' => 'Bil Pelajar',
                                'type' => 'number',
                                ])->label(false);
                        ?>
                    </div><br>
                     (Bil. Pelajar)
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Belum Perlanjutan</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($pnp, 'utama_belum')->textInput([
//                                'placeholder' => 'Bil Pelajar',
                                'type' => 'number',
                                ])->label(false);
                        ?>
                    </div><br>
                     (Bil. Pelajar)
                </div>
            
                <div class="form-group">
                    <label class="col-md-12 col-sm-12 col-xs-12"><strong>SEBAGAI PENYELIA BERSAMA / AHLI</strong></label>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Telah Perlanjutan</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($pnp, 'sama_telah')->textInput([
//                                'placeholder' => 'Bil Pelajar',
                                'type' => 'number',
                                ])->label(false);
                        ?>
                    </div><br>
                     (Bil. Pelajar)
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Belum Perlanjutan</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($pnp, 'sama_belum')->textInput([
//                                'placeholder' => 'Bil Pelajar',
                                'type' => 'number',
                                ])->label(false);
                        ?>
                    </div><br>
                     (Bil. Pelajar)
                </div>
            
                <div class="padding-v-md">
                    <div class="line line-dashed"></div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
            <?php yii\widgets\Pjax::end() ?>
        </div>
    </div>
    </div>
</div>       