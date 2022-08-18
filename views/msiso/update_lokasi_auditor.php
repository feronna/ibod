<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use app\models\msiso\RefAuditor;

error_reporting(0);
?>
 <?= $this->render('menu') ?> 

<?php $form = ActiveForm::begin([ 'options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Lokasi Audit Auditor</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
         <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model->kakitangan, 'CONm')->textInput(['maxlength' => true, 'disabled' => 'true']) ->label(false);?> 
            </div>
        </div> 

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jabatan :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'dept')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\hronline\Department::find()->all(), 'shortname', 'shortname'),
                            'options' => [
                            'placeholder' => ''],
                            ])->label(false); 
                        ?> 
            </div>
        </div>  

        <div class="customer-form">  
                <div class="form-group" align="left">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5"> 
                    <br>
                    <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?>
                   
                </div>
                </div>
            </div> 
        <div class="ln_solid"></div>
    </div>
    </div>
</div> <?php ActiveForm::end(); ?>

 

 


