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
<h5> <strong><center>TAMBAH TEMPAT PENGAJIAN </center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
       
       <table class="table table-sm table-bordered">
    
            <tr >
            <td width="40%" colspan="4" ><strong>PENGAJIAN:</strong></td>
            <td style="width:40%">
<?php
            echo $form->field($mod,'order')->
            dropDownList(['1' => 'PERTAMA ',
                          '2' => 'KEDUA',
                          '3' => 'KETIGA',
                          
                        ])->label(false);
?></td>


</tr>
    
 <tr >
            <td width="40%" colspan="4" ><strong>INSTITUSI/PENGAJIAN:</strong></td>
            <td style="width:40%"><?= strtoupper($model->InstNm)?>
            <?= $form->field($mod, 'renewTempat')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>


</tr>
  
    </tr>
     
    

                      
                 
    
                    <tr> 
                        <th width="40%" colspan="4" align="right">TARIKH MULA PENGAJIAN</th>
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

