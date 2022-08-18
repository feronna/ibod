<?php

use yii\helpers\Html; 
use yii\helpers\ArrayHelper;
//use yii\bootstrap\ActiveForm;
use app\models\myidp\KlusterKursus;
use app\models\myidp\IdpKategoriJawatan;
use app\models\myidp\Kategori;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\myidp\VIdpSenaraiKursus */
/* @var $form ActiveForm */

echo $this->render('/idp/_topmenu');

?>
<div class="form_update_latihan">
    <div class="col-md-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2>Borang Kemaskini Latihan</h2> 
                    <div class="clearfix"></div>
                </div>
            <div class="x_content">
            
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT PENGGUBAL MODUL</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">Penggubal Modul: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'penggubalModul')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
<!--                        type, model, model attribute name, options-->
                        <?php Html::activeInput('text', $model, 'penggubalModul', ['class' => 'form-control col-md-7 col-xs-12']) ?>
                    </div>
                </div>
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT KURSUS LATIHAN</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Tajuk Kursus: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'tajukLatihan')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Sinopsis Kursus: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'sinopsisKursus')->textarea(['rows' => '6'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>    
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Tahun Ditawarkan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                            echo $form->field($model, 'tahunTawaran')->dropDownList(
                                $model->getYearsList(), //function from VIdpSenaraiKursus model
                                ['prompt'=>'Pilih tahun...'])->label(false);
                        ?>
                    
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Kategori Jawatan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php 
                        
                        //use app\models\Country;
                        $kategoriJawatan = IdpKategoriJawatan::find()
                                ->orderBy("kategoriJawatanID")
                                ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData2 = ArrayHelper::map($kategoriJawatan, 'kategoriJawatanID', 'kategoriJawatanID');
                        
                        echo $form->field($model, 'kategoriJawatanID')->dropDownList(
                            $listData2,
                            ['prompt'=>'Select...']
                            )->label(false)  
                        ?>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Kluster: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php 
                        
                        //use app\models\Country;
                        $kluster = KlusterKursus::find()
                                ->orderBy("kluster_nama")
                                ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData=ArrayHelper::map($kluster,'kluster_id','kluster_nama');
                        
                        echo $form->field($model, 'klusterID')->dropDownList(
                            $listData,
                            ['prompt'=>'Select...']
                            )->label(false)  ?>
                    </div>
                </div>
                
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">Kursus Berimpak Tinggi?: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                        
                            $data = [0 => ' YA ', 1 => ' TIDAK '];
                            
                            // Simple basic usage
                            //echo $form->field($model, 'kursusImpakTinggi')->radioButtonGroup($data)->label(false);
                            
                            $model->kursusImpakTinggi = 1;
                            // Change button group size, button styles, and preselect 'Mon'
                            echo $form->field($model, 'kursusImpakTinggi')->radioButtonGroup($data, [
                                'class' => 'btn-group-sm',
                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']]
                            ])->label(false);
//
//                            // Advanced usage - Disable selected radios (e.g. 'Sun' & 'Sat')
//                            echo $form->field($model, 'weekdays3')->radioButtonGroup($data, ['disabledItems'=>[0, 6]]);
                                
                            //$form->field($model, 'kursusImpakTinggi')->widget(CheckboxX::classname(), [])->label(false); 
                            //$form->field($model, 'kursusImpakTinggi')->checkbox(['custom' => true]);
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
</div><!-- form_update_latihan -->

