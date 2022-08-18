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

   <div class="x_panel">   <div class="x_content">
           <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
 <p align ="right">
                    
                    <?php echo Html::a('Kembali',  ['cutisabatikal/maklumat-pengajian',  'id' => $model->iklan_id], ['class' => 'btn btn-primary btn-sm']); ?> 
                </p>

<div class="table-responsive">

                 <table class="table table-bordered jambo_table">
                    <thead>
                        <th scope="col" colspan=12">
                         <center>MAKLUMAT PENGAJIAN YANG DIPOHON</center></th></thead>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Universiti:</th>
                        <td colspan="10">   <?= $form->field($model, 'InstNm')->textInput(['maxlength' => true]) ->label(false);?> 

                        </td> 
                        
                    </tr>
                    
                    <tr>
                        
                        <th class="col-md-3 col-sm-3 col-xs-12">Negara:</th>
                        <td colspan="10">
                         <?= $form->field($model, 'Country')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                        'options' => [
                            'placeholder' => 'Pilih Negara'],
                    ])->label(false); ?>
                        </td>
                    </tr>
                    
                    
                
                 
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Bidang Pengajian / Latihan:</th>
                        <td colspan="6">
                      
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
                        <th class="col-md-3 col-sm-3 col-xs-12">Cuti Sabatikal sahaja (Tujuan menjalani cuti sabatikal):</th>
                        <td colspan="6">
                        <?php
                        echo $form->field($model, "modeID")->
                                dropDownList(['4' => 'Penyelidikan ', 
                                    '5' => ' Pengajian (Kursus/Latihan/Sangkutan)', 
                                    '6'=>'Lawatan akademik dan saintifik berkaitan bidang kepakaran ',
                                    '7'=> 'Penulisan Buku (Deraf Akhir)' ],['prompt'=>'Pilih Tujuan Pengajian'])->label(false);
?>
                        </td>
                        
                 </tr>
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Mula Pengajian :</th>
                        <td colspan="3"> <div class="col-sm-10">
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
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Tamat Pengajian :</th>

<td> <div class="col-sm-10">
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
           </div>
     <!-- end of xpanel-->
