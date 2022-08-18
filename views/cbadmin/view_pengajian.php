<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;

error_reporting(0);
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>MAKLUMAT PENGAJIAN PEMOHON</center></strong> </h5>
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
    
     <tr> 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:40%"><?php
                        
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
?></td>
                       
                    </tr>
                    
                    <tr> 
                        <th style="width:10%" align="right">TARIKH MULA CUTI BELAJAR</th>
                        <td style="width:40%"><?= strtoupper($model->tarikhmula)?></td>
                    </tr>
                    
                    <tr><th style="width:10%" align="right">TARIKH TAMAT CUTI BELAJAR</th>
                      <td style="width:40%"><?= strtoupper($model->tarikhtamat)?></td>
                    </tr>
                     <tr><th style="width:10%" align="right">TEMPOH PENGAJIAN</th>
                      <td style="width:40%"><?= strtoupper($model->tempohpengajian)?></td>
                    </tr>
      
                    <?php 
                         foreach($model->lanjutan as $l)
                         {
                         ?>
                    
                   
                     <tr>
                         
                        
                         <th style="width:10%" align="right">TARIKH PELANJUTAN <?= $l->idlanjutan?></th>
                        <td style="width:40%">

                            <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?>
                            (<?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->all()->tempohlanjutan);?>)</td>
                         </tr><?php }?>
                         <tr>
                         
                        
                         <th style="width:10%" align="right">PELANJUTAN KALI (1/2/3)</th>
                        <td style="width:40%">

                        <?php
            echo $form->field($lanjut,'idLanjutan')->
            dropDownList(['1' => 'PERTAMA ',
                          '2' => 'KEDUA',
                          '3' => 'KETIGA',
                          
                        ])->label(false);
?></td>
                         </tr>
                         <tr><th style="width:10%" align="right">TARIKH PELANJUTAN</th>
                         <td>    <?=
                    DatePicker::widget([
                        'model' => $lanjut,
                        'attribute' => 'lanjutansdt',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>

                   
                             <b><center> HINGGA</center></b>
                    <?=
                    DatePicker::widget([
                        'model' => $lanjut,
                        'attribute' => 'lanjutanedt',
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
    
    
    
</table>
        
        
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
</div>
