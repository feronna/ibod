<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\hronline\MajorMinor; 
use kartik\select2\Select2;
use app\models\hronline\Negara;
/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>KEMASKINI MAKLUMAT PENGAJIAN DAN BIASISWA</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
       
       <table class="table table-sm table-bordered">
    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERINGKAT PENGAJIAN:</th>
                        <td colspan="5">
                        <?php
                                echo $form->field($model,'HighestEduLevelCd')->
                                dropDownList([
                                              '207' => 'Sangkutan',
                                            ],['prompt'=>'Pilih Peringkat Pengajian'])->label(false);
?>
                        </td>
                 </tr>
      <tr>
                        
                        <th class="col-md-3 col-sm-3 col-xs-12">LOKASI PENGAJIAN:</th>
                        <td colspan="4">   <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true]) ->label(false);?> 

                        </td>
                        
                    </tr>
    <tr>
            <td width="40%"><strong>INSTITUSI/PENGAJIAN:</strong></td>
            <td><?= $form->field($model, 'InstNm')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
    </tr>
    
    <tr>
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
                        <th style="width:10%" align="right">BIDANG PENGAJIAN</th>
                        <td style="width:40%">
                            

                      <?php
                        
                        if(($model->MajorCd == NULL) || ($model->MajorMinor != NULL))
                        {
                                echo  strtoupper($model->MajorMinor);
                        }
                        elseif (($model->MajorCd != NULL) && ($model->MajorMinor != NULL))  {
                            echo   strtoupper($model->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($model->major->MajorMinor);
                        }
?>
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
                    
                  
                        <th style="width:10%" align="right">TARIKH MULA CUTI BELAJAR</th>
                        <td style="width:40%">  <?=
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
</td>
                    
                    <tr><th style="width:10%" align="right">TARIKH TAMAT CUTI BELAJAR</th>
                      <td style="width:40%"><?=
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
                    ?></td>
                    </tr>
                   
      <tr>
                       <th style="width:10%" align="right"> NAMA PENYELIA: </th>
                        <td colspan="2" >  <?= $form->field($model, 'nama_penyelia')->textInput()->label(false); ?> </td>
                   
                    </tr>
                    
    <tr>
                      <th style="width:10%" align="right"> EMEL PENYELIA: </th>
                       <td>  <?= $form->field($model, 'emel_penyelia')->textInput()->label(false); ?> </td>
                    </tr>
                    
                    
                    
    
    
</table>

        
            
        
        
    </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    

        
    <div class="x_content">
  
       
        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>

    </div>
    </div>
</div>

