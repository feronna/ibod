<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\daterange\DateRangePicker;
use dosamigos\datepicker\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
error_reporting(0);
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>TUKAR UNIVERSITI/TARIKH/BIDANG & TANGGUH PENGAJIAN </center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
       
       <table class="table table-sm table-bordered">
    
    <tr>
        <td width="40%" colspan="4"><strong>JENIS PERMOHONAN:</strong></td>
            <td><?=$form->field($mod, 'idBorang')->label(false)->widget(Select2::classname(), [
                 'data' => ArrayHelper::map(\app\models\cbelajar\RefBorang::find()->where(['borang'=>4])->all(),  'id', 'jenisBorang'),
                 'options' => ['placeholder' => 'Pilih Jenis Permohonan', 'class' => 'form-control col-md-7 col-xs-12',
                  'onchange' => 
                     'javascript:if ($(this).val() == "22"){
                        $("#mod").show();
                    }
                    else if ($(this).val() == "24"){
                        $("#tempat").show();
                    }
                    else if ($(this).val() == "23"){
                        $("#tarikh").show();
                    }
                     else if ($(this).val() == "25"){
                        $("#lapor").show();
                    }
                     else if ($(this).val() == "31"){
                        $("#tangguh").show();
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
 <tr id="tempat" style="display: none">
            <td width="40%" colspan="4" ><strong>INSTITUSI/PENGAJIAN:</strong></td>
            <td style="width:40%"><?= strtoupper($model->InstNm)?>
            <?= $form->field($mod, 'renewTempat')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>


</tr>
  
    </tr>
     <tr id="mod" style="display: none">
            <td width="40%" colspan="4"><strong>BIDANG PENGAJIAN BAHARU:</strong></td>
            <td ><?php
                        
                        if(($model->MajorCd == NULL) && ($model->MajorMinor != NULL))
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
                 <?=$form->field($mod, 'MajorCd')->label(false)->widget(Select2::classname(), [
                 'data' => ArrayHelper::map(\app\models\hronline\MajorMinor::find()->all(),  'MajorMinorCd', 'MajorMinor'),
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


                        ?> </td>
                               
                              <td width="40" colspan="2"id="lain" style="display: none">
                                        <?= $form->field($mod, 'MajorMinor')->textInput()->label(false); ?>
                              </td>
                        

    </tr>
    
    

                      
                 
    
                    <tr id="tarikh" style="display: none"> 
                        <th width="40%" colspan="4" align="right">TARIKH MULA CUTI BELAJAR BAHARU</th>
                        <td style="width:40%"><?= strtoupper($model->tarikhmula)?> HINGGA <?= strtoupper($model->tarikhtamat)?> (<?= strtoupper($model->tempohpengajian)?>)<br/>
                        
                         <?=
                    DatePicker::widget([
                        'model' => $mod,
                        'attribute' => 'renewTarikhm',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?> HINGGA
                         <?=
                    DatePicker::widget([
                        'model' => $mod,
                        'attribute' => 'renewTarikht',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?></td>
                    </tr>
                    <tr id="tangguh" style="display: none">
                        <td width="40%" colspan="1"><strong>PELARASAN TARIKH PENGAJIAN:<br><br/></strong> <?= strtoupper($model->tarikhmula)?> HINGGA <?= strtoupper($model->tarikhtamat)?> (<?= strtoupper($model->tempohpengajian)?>)<br/></td>
            <td style="width:40%" colspan="1">
                        
                    <br>TARIKH MULA PENGAJIAN BAHARU<?= $form->field($mod, 'renewTarikhm')->widget(DatePicker::className(),
                            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                            'options' => [ 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'renewTarikhm' ]])->label(false);?><b>HINGGA</b> <br/>
                        TARIKH TAMAT PENGAJIAN BAHARU <?= $form->field($mod, 'renewTarikht')->widget(DatePicker::className(),
                            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                            'options' => [ 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'renewTarikht' ]])->label(false);?></td>
            
            <td width="40" colspan="2"><strong>PENANGGUHAN PENGAJIAN:</strong></td>
            <td style="width:40%" colspan="1">
                        
                    <br>TARIKH MULA PENANGGUHAN<?=
                    DatePicker::widget([
                        'model' => $mod,
                        'attribute' => 'dt_stangguh',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?> <b>HINGGA</b> <br/>
                        TARIKH TAMAT PENANGGUHAN <?=
                    DatePicker::widget([
                        'model' => $mod,
                        'attribute' => 'dt_ntangguh',
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
            <td width="40%" colspan="4"><strong>CATATAN:</strong></td>
            <td colspan="4"><?= $form->field($mod, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td >
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
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>

    </div>
    </div>
</div>

