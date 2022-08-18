<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\TopMenuWidget;
use yii\helpers\ArrayHelper;
use app\models\cbelajar\PendidikanTertinggi;
use app\models\cbelajar\Modpengajian;
use app\models\hronline\Negara;
use app\models\hronline\MajorMinor; 
error_reporting(0);
?>



    <div class="x_panel">

           <div class="x_content">
               
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

         
          <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Nama Universiti: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'InstNm')->textInput()->label(false); ?> 
                    </div>
                </div>

           <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Negara: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <?= $form->field($model, 'CountryCd')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                        'options' => [
                            'placeholder' => 'Pilih Negara'],
                    ])->label(false); ?>
                    </div>
                </div>


                
               
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Peringkat Pengajian: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                    $form->field($model, 'HighestEduLevelCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(PendidikanTertinggi::find()->where(['isActive' => 1])->orderBy(['HighestEduLevelRank' => SORT_ASC])->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                        'options' => ['placeholder' => 'Pilih Peringkat Pengajian', 'class' => 'form-control col-md-7 col-xs-12',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                    </div>
                </div> 
               <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Major">Major: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          
            
             <?=$form->field($model, 'MajorCd')->label(false)->widget(Select2::classname(), [
                 'data' => ArrayHelper::map(MajorMinor::find()->all(),  'MajorMinorCd', 'MajorMinor'),
                 'options' => ['placeholder' => 'Pilih Major', 'class' => 'form-control col-md-7 col-xs-12',
                 'onchange' => 'javascript:if ($(this).val() == "9999"){
                   $("#lain").show();
                                         }
                                    else{
                                    $("#lain").hide();
                                    }'],
                        
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],
                                ]);


                                ?> 
                               
                              <div id="lain" style="display: none">
                                        <?= $form->field($model, 'MajorMinor')->textInput()->label(false); ?>
                              </div>
                                
        </div>
        </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="modeID">Mod Pengajian: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
    echo $form->field($model, "modeID")->dropDownList(['1' => 'Penyelidikan Sepenuhnya', '2' => 'Campuran (Kerja Kursus & Tesis)', '3'=>'Kerja Kursus Sepenuhnya '],['prompt'=>'Pilih Tujuan Pengajian'])->label(false);
?>
                        
                        
                    </div>
                </div> 

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikh_mula">Tarikh Mula Pengajian: <span class="required">*</span>
                </label>
                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh_mula',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>
        
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikh_tamat">Tarikh Tamat Pengajian: <span class="required">*</span>
                </label>
                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh_tamat',
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tajuk_tesis">Tajuk Tesis Disertasi (Sarjana) dan Tajuk Penyelidikan PhD/Post Doktoral (Sila Lampirkan):<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                          <?= $form->field($model, 'tajuk_tesis')->textArea()->label(false); ?> 
                    </div>
                </div>

                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_penyelia">Nama Penyelia (Cadangan):<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                          <?= $form->field($model, 'nama_penyelia')->textInput()->label(false); ?> 
                    </div>
                </div>
               
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="emel_penyelia">Emel Penyelia:<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                          <?= $form->field($model, 'emel_penyelia')->textInput()->label(false); ?> 
                    </div>
                </div>
         

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                     <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                   
                </div>
            </div>
                 <?= $form->field($model, 'iklan_id')->hiddenInput(['value' => $iklan->id])->label(false); ?>

            <?php ActiveForm::end(); ?>
           </div>
    </div>  <!-- end of xpanel-->
