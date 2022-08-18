<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use dosamigos\tinymce\TinyMce;
error_reporting(0);
?>

<?= $this->render('menu') ?> 

<?php $form = ActiveForm::begin([ 'options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Kemaskini Klausa</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
         <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Klausa :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'clause_order')->textInput(['maxlength' => true, 'placeholder' => 'Klausa']) ->label(false);?> 
            </div>
        </div> 

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Klausa :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'clause_title')->textInput(['maxlength' => true, 'placeholder' => 'Tajuk Klausa']) ->label(false);?> 
            </div>
        </div> 
  
        <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Butiran Klausa :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <? $form->field($model, 'clause_details')->textarea(array('rows'=>6,'cols'=>5)) ->label(false);?> 
            <?php
            //  $form->field($model, 'clause_details')->widget(TinyMce::className(), [
            //     'options' => ['rows' => 10],
            //     'language' => 'en',
            //     'clientOptions' => [
            //         'plugins' => [],
            //         'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
            //     ]
            // ])->label(false);
             ?>
            </div>
        </div>  -->
 
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



 


