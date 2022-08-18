<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DateTimePicker; 
?>


<div class="x_panel">  
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?> 
    <?php if ($exist) { ?>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Permohonan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?=
                    $form->field($model, 'apply_type')->label(false)->widget(Select2::classname(), [
                        'data' => ['LANJUTAN' => 'LANJUTAN', 'ROSAK' => 'ROSAK', 'HILANG' => 'HILANG'],
                        'options' => ['placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div> 
    <?php } ?>
    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right"> Tarikh/Masa pengambilan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-6">  
                <?=
                $form->field($model, 'wakil_masa_ambil')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => '....'],
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ])->label(false);
                ?>
            </div>
        </div>
    </div>  
    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Kp <small>(Wakil pengambilan)</small>:  
            </label>
            <div class="col-md-6 col-sm-6 col-xs-6"> 
                <?= $form->field($model, 'wakil_ICNO')->textInput([])->label(false); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama <small>(Wakil pengambilan)</small>:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-6">  
                <?= $form->field($model, 'wakil_nama')->textInput([])->label(false); ?>
            </div>
        </div>
    </div>  
    <br/>
    <div class="form-group text-center">
        <div class="row">
            <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
        </div>
    </div> 
    <?php ActiveForm::end(); ?> 
</div> 
