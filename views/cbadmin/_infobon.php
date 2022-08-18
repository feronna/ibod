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
<h5> <strong><center>MAKLUMAT BON PERKHIDMATAN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TEMPOH BON:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 't_phd')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        

        
       <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">JUMLAH BON:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'j_bon')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        
          <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">JUMLAH PERKHIDMATAN DARI LAPOR DIRI:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'j_lapor')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">BAKI BON PERKHIDMATAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'baki_bon')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        
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
