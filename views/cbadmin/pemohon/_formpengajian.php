<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\hronline\Negara;
use app\models\hronline\MajorMinor; 
use kartik\daterange\DateRangePicker;
use dosamigos\datepicker\DatePicker;

error_reporting(0);
?>
<p align ="right">
                    
                    <?php echo Html::a('Kembali',  ['pemohon/maklumat-pengajian',  'id' => $iklan->id], ['class' => 'btn btn-primary btn-sm']); ?> 
                </p>
   <div class="x_panel">  
       <div class="x_content">
           <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>

<div class="table-responsive">

                 <table class="table table-bordered jambo_table">
                    <thead>
                        <th scope="col" colspan=12">
                        <center>MAKLUMAT PENGAJIAN YANG DIPOHON</center></th></thead>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Universiti:</th>
                        <td colspan="2">   <?= $form->field($model, 'InstNm')->textInput(['maxlength' => true]) ->label(false);?> 

                        </td> 
                       
                        <th class="col-md-3 col-sm-3 col-xs-12">Negara:</th>
                        <td colspan="3">
                         <?= $form->field($model, 'Country')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                        'options' => [
                            'placeholder' => 'Pilih Negara'],
                    ])->label(false); ?>
                        </td>
                    </tr>
                    <tr>
                        
                        <th class="col-md-3 col-sm-3 col-xs-12">Lokasi Pengajian:</th>
                        <td colspan="4">   <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true]) ->label(false);?> 

                        </td>
                        
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Status Pengajian:</th>
                        <td colspan="5">
                        <?php
            echo $form->field($model,'modeStudy')->
            dropDownList(['SEPENUH MASA' => 'SEPENUH MASA ',
                          'SEPARUH MASA' => 'SEPARUH MASA', 
                        ],['prompt'=>'Pilih Status Pengajian'])->label(false);
?>
                        </td>
                        
                 </tr>
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Peringkat Pengajian:</th>
                        <td colspan="5">
                        <?php
            echo $form->field($model,'HighestEduLevelCd')->
            dropDownList(['12' => 'Sijil ',
                          '11' => 'Diploma', 
                          '8'=>'Sarjana Muda',
                          '20'=> 'Sarjana',
                          '1' => 'Doktor Falsafah (PhD)'],['prompt'=>'Pilih Peringkat Pengajian'])->label(false);
?>
                        </td>
                        
                 </tr>
                 
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Bidang Pengajian:</th>
                        <td colspan="5">
                      
                               <?=$form->field($model, 'MajorCd')->label(false)->widget(Select2::classname(), [
                     'data' => ArrayHelper::map(MajorMinor::find()->all(),  'MajorMinorCd', 'MajorMinor'),
                     'options' => ['placeholder' => 'Pilih Bidang Pengajian', 'class' => 'form-control col-md-7 col-xs-12',
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
                        </td>
                      
                   
                        
                 </tr>
                 <tr>
                     <td>
                     <td colspan="5" id="lain" style="display: none">
                                        <?= $form->field($model, 'MajorMinor')->textInput(['placeholder' => 'Sila letak nama bidang pengajian anda'])->label(false); ?>
                         </td>
                         
                 </tr>
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Mula Pengajian:</th>
                        <td colspan="5"> <div class="col-sm-10">
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
</td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Tamat Pengajian:</th>
                        <td colspan="5"> <div class="col-sm-10">
             <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh_tamat',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>

        </div>
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tajuk Tesis Disertasi (secara kasar) dan cadangan program PhD (Sila Lampirkan): </th>
                        <td colspan="2">  <?= $form->field($model, 'tajuk_tesis')->textArea()->label(false); ?> 
 

                        </td> 
                        <th class="col-md-3 col-sm-3 col-xs-12">Lampiran (Jika Ada):</th>
                       
                         <td><br><?= $form->field($model, 'file1')->fileInput()->label(false);?> </td>
                    
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12"> Nama Penyelia (Jika telah diketahui): </th>
                        <td colspan="2" >  <?= $form->field($model, 'nama_penyelia')->textInput()->label(false); ?> </td>
                       <th class="col-md-3 col-sm-3 col-xs-12"> Emel Penyelia: </th>
                       <td>  <?= $form->field($model, 'emel_penyelia')->textInput()->label(false); ?> </td>
                    </tr>
                </table>
            </div>
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
     <!-- end of xpanel-->
