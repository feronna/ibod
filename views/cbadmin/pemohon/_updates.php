<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\MajorMinor; 

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>KEMASKINI MAKLUMAT PENGAJIAN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
       
       <table class="table table-sm table-bordered">
    
    
    <tr>
            <td width="40%"><strong>INSTITUSI/PENGAJIAN:</strong></td>
            <td><?= $form->field($model, 'InstNm')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
    </tr>
    <td width="40%"><strong>LOKASI PENGAJIAN:</strong></td>
            <td><?= $form->field($model, 'lokasi')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
    </tr>     
    
     <tr> 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:40%"> <?=$form->field($model, 'MajorCd')->label(false)->widget(Select2::classname(), [
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


                                ?></td>
                       
                    </tr>
                    <tr>
                     <td>
                     <td colspan="5" id="lain" style="display: none">
                                        <?= $form->field($model, 'MajorMinor')->textInput()->label(false); ?>
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
                    </tr>
                    
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
            <td width="40%"><strong>TAJUK TESIS:</strong></td>
            <td><?= $form->field($model, 'tajuk_tesis')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
    </tr>      
      <tr>
            <td width="40%"><strong>NAMA PENYELIA:</strong></td>
            <td><?= $form->field($model, 'nama_penyelia')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
    </tr>
    <tr>
            <td width="40%"><strong>EMEL PENYELIA:</strong></td>
            <td><?= $form->field($model, 'emel_penyelia')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
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

