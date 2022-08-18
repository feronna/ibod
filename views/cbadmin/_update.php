<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>KEMASKINI PENGIRAAN BON</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
       
       <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">PERINGKAT PENGAJIAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
  <?php
            echo $form->field($model,'HighestEduLevelCd')->
            dropDownList(['1' => 'Doktor Falsafah (Phd) ',
                          '200' => 'Pasca Kedoktoran', 
                          '102'=>'Sub Kepakaran',
                          '20'=> 'Sarjana',
                          '202' => 'Sarjana Kepakaran',
                          '99' =>'Cuti Sabatikal',
                          '999' =>'Latihan Industri',
                        ],['prompt'=>'Pilih Peringkat Pengajian'])->label(false);
?>          </div>
            </div>
<div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH MULA BON:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
            <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_mkhidmat',
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
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH TAMAT BON:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
            <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_tkhidmat',
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
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TEMPOH BON:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
  <?php
            echo $form->field($model,'tempoh')->
            dropDownList(['1' => '1 TAHUN ',
                          '2' => '2 TAHUN', 
                          '3'=>'3 TAHUN',
                          '4'=> '4 TAHUN',
                          '5' => '5 TAHUN',
                          '6' =>'6 TAHUN',
                          '7' =>'7 TAHUN',
                        ],['prompt'=>'Pilih Tempoh Bon'])->label(false);
?>                </div>
            </div>
            
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        
     

    </div>
    </div>
</div>
</div>


        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>


