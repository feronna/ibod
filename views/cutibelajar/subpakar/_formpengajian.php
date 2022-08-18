<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\hronline\Negara;
use app\models\hronline\MajorMinor; 
use dosamigos\datepicker\DatePicker;
error_reporting(0);

?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>

<div class="x_panel">
    
 


    
<div class="table-responsive">
    <table class="table table-bordered jambo_table">
                <thead>
                        <th scope="col" colspan=12">
                        <center>MAKLUMAT PENGAJIAN</center></th>
                </thead>
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">LOKASI PENGAJIAN:</th>
                        <td colspan="5">   <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true]) ->label(false);?> 
                        </td> 
                        
                </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAMA UNIVERSITI:</th>
                        <td colspan="2">   <?= $form->field($model, 'InstNm')->textArea(['maxlength' => true]) ->label(false);?> 
                        </td> 
                        <th class="col-md-3 col-sm-3 col-xs-12">NEGARA:</th>
                        <td colspan="3">
                         <?= $form->field($model, 'Country')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                        'options' => [
                            'placeholder' => 'Pilih Negara'],
                    ])->label(false); ?>
                        </td>
                </tr>
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERINGKAT PENGAJIAN:</th>
                        <td colspan="5">
                        <?php
                                echo $form->field($model,'HighestEduLevelCd')->
                                dropDownList([
                                              '102' =>'SUB KEPAKARAN',
                                            ],['prompt'=>'Pilih Peringkat Pengajian'])->label(false);
?>
                        </td>
                 </tr>
                
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">BIDANG PENGAJIAN:</th>
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
                        <td id="lain" style="display: none">
                                        <?= $form->field($model, 'MajorMinor')->textInput()->label(false); ?>
                         </td>
                        
                 </tr>
                 
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">MOD PENGAJIAN:</th>
                        <td colspan="5">
                            <?=
                    $form->field($model, 'modeID')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cbelajar\Modpengajian::find()->where(['modeID'=>[1,2,3,4,5,6,7]])->all(), 'modeID', 'studyMode'),
                    'options' => ['placeholder' => 'Pilih Mod Pengajian', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>
                      
                        </td>
                        
                 </tr>
                
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH MULA PENGAJIAN :</th>
                        <td colspan="2">
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

     
</td> <th class="col-md-3 col-sm-3 col-xs-12">TARIKH TAMAT PENGAJIAN :</th>
                        <td>
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

     
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TAJUK TESIS DISERTASI (SECARA KASAR): </th>
                        <td colspan="5">  <?= $form->field($model, 'tajuk_tesis')->textArea()->label(false); ?>
 </td> 
                        
                    
                    </tr>
                   
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12"> NAMA PENYELIA (JIKA TELAH DIKETAHUI): </th>
                        <td colspan="2" >  <?= $form->field($model, 'nama_penyelia')->textInput()->label(false); ?> </td>
                       <th class="col-md-3 col-sm-3 col-xs-12"> EMEL PENYELIA: </th>
                       <td>  <?= $form->field($model, 'emel_penyelia')->textInput()->label(false); ?> </td>
                    </tr>
                </table>
          

          
          
         

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                     <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                    
                   
                </div>
            </div>
                 <?= $form->field($model, 'iklan_id')->hiddenInput(['value' => $iklan->id])->label(false); ?>

            <?php ActiveForm::end(); ?>
     <!-- end of xpanel-->
  </div>
</div>

