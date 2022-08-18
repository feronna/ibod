<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\esticker\TblStickerStaf */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
<div class="x_panel"> 
    <div class="x_title">
        <h2><?= $title ?></h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">     
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Bayaran:  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">   
                    <?= $form->field($model, 'jenis_bayaran')->textInput(['value' => 'KAUNTER', 'disabled' => true])->label(false); ?>
                </div>
            </div>
        </div> 
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jumlah (RM):  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">   
                    <?= $form->field($model, 'total')->textInput(['value' => '5.00', 'disabled' => true])->label(false); ?>
                </div>
            </div>
        </div> 
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Catatan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($model, 'remark')->textarea(['maxlength' => true,'rows'=>3])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group"> 
            <br/>
            <div class="form-group text-center">
                <div class="row">
                    <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
                </div>
            </div>
            <div class="hide"> 
                <?= $form->field($model, 'pay_status')->hiddenInput(['value' => 1])->label(false); ?>  
                <?= $form->field($model, 'pay_type')->hiddenInput(['value' => 1])->label(false); ?>  
                <?= $form->field($model, 'updater')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>  
                <?= $form->field($model, 'updater_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?>  
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div> 
