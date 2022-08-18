<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\Campus;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblrscoadminpost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscoadminpost-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="x_panel">
    <div class="x_content">

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flag">Allowance: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo
                $form->field($model, 'it_income_code')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\hronline\RefAllowance::find()->all(), 'it_income_code', 'it_account_name'),
                    'options' => ['placeholder' => 'Pilih Allowance', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div>  
                
    <br>
        
    <div class="form-group text-center">
        <?php //echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
 </div>
</div>
</div>